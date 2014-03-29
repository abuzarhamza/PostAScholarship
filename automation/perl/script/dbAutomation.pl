#!/user/bin/perl

use warnings;
use strict;
use DBI;
use DBD::mysql;
use Data::Dumper;

my %CONFIG = ();


$CONFIG{'SQL_DIRPATH'}      = '/opt/lampp/htdocs/PostAScholarship/mysql/';
$CONFIG{'SQL_CRDB_FILE'}        = 'createDB.sql';
$CONFIG{'SQL_CRTABLE_FILE'}     = 'createTable.sql';
$CONFIG{'SQL_INSERT_USERPRIVI'} = '/scorePrevilage.sql';


CreateDatabase(\%CONFIG);
CreateTable(\%CONFIG);
print "insert privilege";
InsertPrivilage(\%CONFIG);

=head1
function    : CreateDatabase
description : create the db.
in          : ref_hash
out         : none
=cut
sub CreateDatabase {
    my ($ref_hash) =  @_;
    my %Config     = %$ref_hash;

    local $/ = ';';

    my $dirpath = $Config{'SQL_DIRPATH'};
    my $sqlFileName = $dirpath  . $Config{'SQL_CRDB_FILE'};

    my $dbh = DBI->connect('dbi:mysql:;mysql_socket=/opt/lampp/var/mysql/mysql.sock','root','',{PrintError=>1, RaiseError=>1});

    open(my $fh, "$sqlFileName") or die "cant open the file $sqlFileName: $!";
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

    local $/ = ';';

    my $dirpath  = $Config{'SQL_DIRPATH'};
    my $filePath = $dirpath . $Config{'SQL_CRTABLE_FILE'};

    my $dbh = DBI->connect('dbi:mysql:postascholarship_db;mysql_socket=/opt/lampp/var/mysql/mysql.sock','root','',{PrintError=>1, RaiseError=>1});
    open(my $fh, "$filePath") or die "cant open the file $filePath: $!";
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

=head1
function    : insertPrivilage
description : 
in          : ref_hash
out         : none
=cut

sub InsertPrivilage {
    my ($ref_hash) = @_;
    my %Config = %$ref_hash;

    local $/ = ";";

    my $dirpath  = $Config{'SQL_DIRPATH'};
    my $filePath = $dirpath . $Config{'SQL_INSERT_USERPRIVI'};

    my $dbh = DBI->connect('dbi:mysql:postascholarship_db;mysql_socket=/opt/lampp/var/mysql/mysql.sock','root','',{PrintError=>1, RaiseError=>1});
  

    open(my $fh , "$filePath")  or die "cant open the file : $filePath :$!";
    while (<$fh>) {
        #chomp;
        #insert into privalege (score,small_des,description)
    #values (20000,'trusted user','Expanded editing, deletion and undeletion privileges');

        my $query = clearComment($_); print "\$query : $query\n";
        my $score = 0;
        
        foreach (split/\n/,$query) {
            print "$_\n";
            if ($_=~/.+values\((\d{1,}).+/) {
                $score = $1;
                print "\$score : $score\n";
            }
        }

        if ($score != 0 ) {
            my $sh =  $dbh->prepare("select score from privilege where score \= $score");
            $sh->execute();
            if ($sh->rows == 0 )  {
                $sh =  $dbh->prepare($query);
                $sh->execute();
            }
            $sh->finish();       
        }
        
            
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
sub clearComment {
    my ($query) = @_;
    my $tmpSQL  = ""; 

    foreach (split(/\n/,$query)) {
        chomp;
        if ($_=~/^--/ || $_ eq "") {
            next;
        }
            elsif ($_=~/(.+)--.+/) {
             $tmpSQL .= $1."\n";
        }
            else {
            $tmpSQL .= $_."\n"
        }
    }
   
    return $tmpSQL; 

}
