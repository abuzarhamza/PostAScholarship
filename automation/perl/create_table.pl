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

my $dbh = DBI->connect('dbi:mysql:postascholarship_db:localhost:3306;mysql_socket=/opt/lampp/var/mysql/mysql.sock','root','') 
        or die "Unable to connect: $DBI::errstr\n";


open( my $fh1,"<", "$filePath") or die "cant open the file $sqlFileName: $!";
while(<$fh1>) {

    my $query =  $_;
    print "QUERY : $query\n";

    my $sh    = $dbh->prepare($query) or die "";
    $sh->execute();
  
}
close $fh1;


