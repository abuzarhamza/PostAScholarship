package SQL::Sanity;

use warnings;
use strict;

use Export;

our $VERION = 0.01

our @EXPORT_OK  = (clearComment);
our @EXPORT_TAG = ();


=head1
function   : clearComment
descriptin : remove the comment in the query statement
in         : scalar
out        : scalar
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

1;
