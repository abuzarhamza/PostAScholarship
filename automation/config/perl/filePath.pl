#!/usr/bin/perl

use warnings;
use strict;

our %CONFIG = ();

$CONFIG{'PERL_MODULE_PATH'} = '../modules';

$CONFIG{'SQL_DIRPATH'}      = '../../../mysql/';
$CONFIG{'SQL_CRDB_FILE'}    = 'createDB.sql';
$CONFIG{'SQL_CRTABLE_FILE'} = 'createTable.sql';
