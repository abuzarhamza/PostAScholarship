package SQL::Sanity;

our $VERION    = 0.01;
our @EXPORT_OK = ();
our @EXPORT_TAGS = ();

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