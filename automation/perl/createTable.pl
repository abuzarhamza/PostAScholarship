#!/usr/bin/perl

use warnings;
use strict;
#use Cmd;


use DBI;
use DBD::mysql;

local $/ = ';';

my $sqlFileName = "createTable.sql";
my $filePath    = '../../mysql/'. $sqlFileName;

#print "MSG : chnaging the directory path";

print "Starting the script\n";

my $dbh = DBI->connect('dbi:mysql:postascholarship_db:localhost:3306;mysql_socket=/opt/lampp/var/mysql/mysql.sock','root','', {PrintError => 1 , RaiseError =>1}) 
        or die "Unable to connect: $DBI::errstr\n";


open( my $fh1,"<", "$filePath") or die "cant open the file $sqlFileName: $!";
while(<$fh1>) {

    my $query =  $_;

    print "QUERY : $query\n";
    $query = satantize_query($query);
    print "AFTER SANITIZATION : $query\n";

    next if  ($query eq "");

    my $sh    = $dbh->prepare($query);
    $sh->execute();
    $sh->finish();
}
close $fh1;

$dbh->disconnect() or warn "Disconnection failed : $DBI::errstr";


=head
this functional will remove the comment in the query statement
=cut
sub satantize_query {
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
