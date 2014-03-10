#!/usr/bin/perl

use warnings,
use strict;
use DBD;
use DBI::mysql;



createTable();




sub createTable {
	local $/ = ';';


	open(my $fh, "") or die "cont open the file : $!";
	while($fh) {
			

	
	}
	close $fh;

}




















