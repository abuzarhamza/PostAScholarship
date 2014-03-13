#!/user/bin/perl 

use warnings;
use strict;
use DBI;
use DBD::mysql;

my $fileName = "";
my $filePath = "";

my $dh = DBI->connect('dbi:mysql:;mysql_socket=/opt/lampp/var/mysql/mysql.sock','root','');
open(my $fh, "") or die "cant open the file : $!"


