#!/user/bin/perl 

use warnings;
use strict;
use DBI;
use DBD::mysql;
use lib 'perl/modules';
use lib '../config';

require 'filePath.pl';

use SQL::Sanity(clearComment);

our %CONFIG;

CreateDatabase(\%CONFIG);
CreateTable(\%CONFIG);

=head
=cut
sub CreateDatabase {
    my ($ref_hash) =  @_;
    my %Config     = %$ref_hash;

    local $\ = ';';

    my $sqlFilePath = $Config{'SQL_DIRPATH'};
    my $sqlFileName = $sqlFileName . $Config{'SQL_CRDB_FILE'};

    my $dh = DBI->connect('dbi:mysql:;mysql_socket=/opt/lampp/var/mysql/mysql.sock','root','');

    open(my $fh, "$sqlFileName") or die "cant open the file : $!";
    while (<$fh>) {
        chomp;
        my $query = $_;

        print "QUERY : $query\n";
        $query = clearComment($query);
        print "AFTER SANITIZATION : $query\n";

        next if  ($query eq "");

        my $sh = $dbh->prepare($query);
        $sh->execute();
        $sh->finish();
    }
    close $fh;

    $dbh->disconnect() or warn "Disconnection failed : $DBI::errstr";
}

=head
=cut
sub CreateTable {
    my ($ref_hash) =  @_;
    my %Config     = %$ref_hash;

    local $\ = ';';

    my $sqlFilePath = $Config{'SQL_DIRPATH'};
    my $filePath    = $sqlFilePath . $Config{'SQL_CRTABLE_FILE'};

    my $dh = DBI->connect('dbi:mysql:postascholarship_db;mysql_socket=/opt/lampp/var/mysql/mysql.sock','root','');
    open(my $fh, "$filePath") or die "cant open the file : $!";
    while (<$fh>) {
        chomp;
        my $query = $_;

        print "QUERY : $query\n";
        $query = clearComment($query);
        print "AFTER SANITIZATION : $query\n";

        next if  ($query eq "");

        my $sh    = $dbh->prepare($query);
        $sh->execute();
        $sh->finish();
    }
    close $fh;

    $dbh->disconnect() or warn "Disconnection failed : $DBI::errstr";
}