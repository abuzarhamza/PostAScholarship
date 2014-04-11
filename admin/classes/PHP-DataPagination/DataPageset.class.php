<?
    class DataPageset {

        var $total_entries,$entries_per_page,$current_page,
        $mode,$pages_per_set;

        function __construct($total_entries=0,$entries_per_page=10,$current_page=1,$pages_per_set=10,$mode='slide') {
            $this->total_entries    = $total_entries;
            $this->entries_per_page = $entries_per_page;
            $this->current_page     = $current_page;
            $this->pages_per_set    = $pages_per_set;
            $this->mode             = 'slide';

        }

        public function entries_per_page($entries_per_page) {
            $this->entries_per_page = $entries_per_page;
        }

        public function total_entries($total_entries) {
            $this->total_entries=$total_entries;
        }

        public function first_page() {
            $this->first_page =1;
            return $this->first_page;
        }

        public function current_page() {
            if (empty($this->total_entries) ||
                 empty($this->entries_per_page) || empty($this->current_page)
            ) {
                return $this->first_page;
            }

            if ( $this->current_page < $this->first_page ) {
                return $this->first_page;
            }
            if ( $this->current_page > $this->last_page ) {
                return $this->last_page;
            }

            return $this->current_page; 
        }

        public function last_page() {

            $pages = $this->total_entries / $this->entries_per_page;
            if ($pages == intval($pages) ) {
                $this->last_page = $pages;
            } else {
                $this->last_page = $pages +1;
            }

            if ( $this->last_page < 1 ) {
                $this->last_page = 1;
            }
            return $this->last_page;
        }

        public function enteries_on_this_page() {
            if ($this->total_entries == 0) {
                return 0;
            } else {
                return $this->last() - $this->first() + 1;
            }
        }

        //This method returns the number of the first entry on the current page:
        public function first() {
            if ($this->total_entries == 0 ) {
                return 0;
            } else {
                return ( ($this->current_page - 1) * $this->entries_per_page) +1;
            }
        }

        //This method returns the number of the last entry on the current page:
        public function last() {
            if ( $this->current_page == $this->last_page() ) {
                return $this->total_entries;
            } else {
                return ( $this->current_page * $this->entries_per_page );
            }
        }

        public function previous_page() {
            if ( $this->current_page > 1) {
                return $this->current_page - 1;
            } else {
                return undef;
            }
        }

        public function next_page() {
            if ( $this->current_page > 1
                && $this->current_page < $this->last_page()
            ) {
                return $this->current_page + 1;
            } else {
                return undef;
            }
        }

        public function previous_set() {
            if ( isset($this->page_set_previous) ) {
                return $this->page_set_previous;
            }

            return undef;
        }

        public function next_set(){
            if ( isset($this->page_set_next) ) {
                return $this->page_set_next;
            }

            return undef;
        }

        public function pages_in_set() {

            if (empty($this->pages_per_set))  {
                return undef;
            }
            $max_pages_per_set = $this->pages_per_set;

            if ( $max_pages_per_set < 1 ) {
                # Only have one page in the set, must be page 1
                if ( $this->current_page != 1 ) {
                    $this->page_set_previous = $this->current_page - 1 ;
                }
                $this->page_set_pages[0] = 1;
                if ( $this->current_page < $this->last_page() ) {
                    $this->page_set_next = $this->current_page() + 1;
                }
            }
            else {

                if ( $this->mode == 'slide' ) {
                    if ($max_pages_per_set > $this->last_page() ) {
                         # No sliding, no next/prev pageset
                         $this->page_set_pages = range(1, $this->last_page());
                    }
                    else {
                        # Find the middle rounding down - we want more pages after, than before
                        $middle = intval($max_pages_per_set/2);

                        # offset for extra value right of center on even numbered sets
                        $offset =1;

                        if ( $max_pages_per_set %2 != 0 ) {
                            # must have been an odd number, add one
                            $middle++;
                            $offset = 0;
                        }

                        $starting_page = $this->current_page - $middle + 1;
                        if ( $starting_page < 1) {
                            $starting_page =1;
                        }

                        $end_page = $starting_page + $max_pages_per_set - 1;
                        if ( $end_page > $this->last_page() ) {
                            $end_page = $this->last_page();
                        }

                        if ( $this->current_page <= $middle ) {
                            #near the start of the page numbers
                            $this->page_set_next
                                = $max_pages_per_set + $middle - $offset;
                            $this->page_set_pages = range (1,$max_pages_per_set);

                        }
                        elseif ( $this->current_page >
                            ($this->last_page() - $middle - $offset)
                        ) {
                            # near the end of the page numbers
                            $this->page_set_previous
                                = $this->last_page()
                                - $max_pages_per_set
                                - $middle + 1;
                            $this->page_set_pages
                                = range( ( $this->last_page() - $max_pages_per_set + 1 ) ,
                                         $this->last_page()
                                        ) ;
                        }
                        else {
                            # Start scrolling baby!
                            $this->page_set_pages = range($starting_page , $end_page );
                            $this->page_set_previous
                                = $starting_page - $middle - $offset;
                            if ( $this->page_set_previous < 1 ) {
                                $this->page_set_previous = 1;
                            }

                            $this->page_set_next = $end_page + $middle;
                        }
                    }
                }
                elseif ( $this->mode == 'fixed' ) {
                    $starting_page = $this->_calc_start_page($max_pages_per_set);
                    $end_page      = $starting_page + $max_pages_per_set - 1;

                    if ( $end_page < $this->last_page() ) {
                        $this->page_set_next = $end_page + 1;
                    }

                    if ( $starting_page > 1 ) {
                        $this->page_set_previous
                            = $starting_page - $max_pages_per_set;
                    }
                }

            }
        }

        private function _calc_start_page($max_pages_per_set) {

            $current_page = $self->current_page;
            $start_page = 1;

            $current_page_set = 0;

            if ( $max_pages_per_set > 0 ) {
                $current_page_set = intval( $current_page / $max_pages_per_set );

                if ( $current_page % $max_pages_per_set == 0 ) {
                    $current_page_set = $current_page_set - 1;
                }
            }

            $start_page = ( $current_page_set * $max_pages_per_set ) + 1;

            return $start_page;
        }
    }
?>