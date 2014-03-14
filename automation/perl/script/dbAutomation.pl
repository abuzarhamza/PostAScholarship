#!/user/bin/perl

use warnings;
use strict;
use DBI;
use DBD::mysql;
use Data::Dumper;
use lib '../modules';
use SQL::Sanity qw(clearComment);

require '../../config/perl/filePath.pl';

#use SQL::General (readSQLFile);

##########################
#TO DO
#CREATE SQL::General
#function readSQLFile read the file and return the array with the list of query
##########################


our %CONFIG;




CreateDatabase(\%CONFIG);
CreateTable(\%CONFIG);

=head1
function    : CreateDatabase
description : create the db.
in          : ref_hash
out         : none
=cut
sub CreateDatabase {
    my ($ref_hash) =  @_;
    my %Config     = %$ref_hash;

    local $\ = ';';

    my $baseDir = $Config{'SQL_DIRPATH'};
    my $sqlFileName = $baseDir  . $Config{'SQL_CRDB_FILE'};

    my $dbh = DBI->connect('dbi:mysql:;mysql_socket=/opt/lampp/var/mysql/mysql.sock','root','',{PrintError=>1, RaiseError=>1});

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

=head1
function    : CreateTable
description : create the table.
in          : ref_hash
out         : none
=cut
sub CreateTable {
    my ($ref_hash) =  @_;
    my %Config     = %$ref_hash;

    local $\ = ';';

    my $baseDir  = $Config{'SQL_DIRPATH'};
    my $filePath = $baseDir . $Config{'SQL_CRTABLE_FILE'};

    my $dbh = DBI->connect('dbi:mysql:postascholarship_db;mysql_socket=/opt/lampp/var/mysql/mysql.sock','root','',{PrintError=>1, RaiseError=>1});
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
