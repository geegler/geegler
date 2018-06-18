<?php

namespace System\Libraries;
/*
*
* filename: PaginationClass.php
*/

class PaginationClass
{

    private $count, $source, $page, $q, $pageName, $page_var, $rows_pp;

    //public function __construct($count, $source, $page, $q, $pageName, $page_var, $rows_pp)

    public function __construct($count, $page_no, $method, $q, $source = null)
    {

        $this->v_count = $count;
        $this->v_source = $source;
        $this->v_page = $page_no;
        $this->v_q = $q;
        //$this->pageName = $pageName;
        //$this->page_var = $page_var;
        $this->rows_pp = '';
        $this->method = $method;
    }

    public function pagenate()
    {
        if ($this->pageName === 'toprated.php')
        {
            $this->v_q = 'top';
        }
        if ($this->pageName === 'latest.php')
        {
            $this->v_q = 'latest';
        }
        if ($this->pageName === 'mostviewed.php')
        {
            $this->v_q = 'mostviewed';
        }
        if ($this->pageName === 'mostfavored.php')
        {
            $this->v_q = 'mostfavored';
        }
        $qname = $this->v_q;
        // number of rows to show per page
        $pageit = "";
        $cat = "";
        $this->rows_pp = 24;
        if ($this->v_source == "ph")
        {
            $this->rows_pp = 24;
        }
        if ($this->v_source == 'yp')
        {
            $this->rows_pp = 29;
        }
        // find out total pages
        $totalpages = ceil($this->v_count / $this->rows_pp);
        /*
        // get the current page or set a default
        if (isset($_GET[''.$this->page_var.'']) && is_numeric($_GET[''.$this->page_var.''])) {
        // cast var as int
        $this->v_page = (int) $_GET[''.$this->page_var.''];
        } 
        */
        //get page from the segment
        if (isset($this->v_page))
        {
            $this->v_page = (int)$this->v_page;
        } else
        {
            // default this->v_page num
            $this->v_page = 1;
        } // end if
        // if current page is greater than total pages...
        if ($this->v_page > $totalpages)
        {
            // set current page to last page
            $this->v_page = $totalpages;
        } // end if
        // if current page is less than first page...
        if ($this->v_page < 1)
        {
            // set current page to first page
            $this->v_page = 1;
        } // end if
        // the offset of the list, based on current page
        $offset = ($this->v_page - 1) * $this->rows_pp;

        // range of num links to show
        $range = 3;
        // if not on page 1, don't show back links

        if ($this->v_page > 1)
        {
            // show << link to go back to page 1
            $pageit .= " <a href='" . $this->method . $this->v_q . "/1/'><<</a> ";
            // get previous page num
            $prevpage = $this->v_page - 1;
            // show < link to go back to 1 page
            $pageit .= " <a href='" . $this->method . $this->v_q . "/" . $prevpage .
                "/'>Previous</a> ";
        } // end if

        // loop to show links to range of pages around current page
        for ($x = ($this->v_page - $range); $x < (($this->v_page + $range) + 1); $x++)
        {
            // if it's a valid page number...
            if (($x > 0) && ($x <= $totalpages))
            {
                // if we're on current page...
                if ($x == $this->v_page)
                {
                    // 'highlight' it but don't make a link
                    $pageit .= " <span class='current'>$x</span> ";
                    // if not current page...
                } else
                {
                    // make it a link
                    $pageit .= " <a href='" . $this->method . $this->v_q . "/" . $x . "/'>" . $x .
                        "</a> ";
                } // end else

            } // end if

        } // end for
        // if not on last page, show forward and last page links
        if ($this->v_page != $totalpages)
        {
            // get next page
            $nextpage = $this->v_page + 1;
            // echo forward link for next page
            $pageit .= " <a href='" . $this->method . $this->v_q . "/" . $nextpage .
                "/'>Next</a> ";
            // echo forward link for lastpage
            $pageit .= " <a href='" . $this->method . $this->v_q . "/" . $totalpages .
                "/'>>></a> ";
        } // end if
        /****** end build pagination links ******/
        return $pageit;

        unset($pageit);

    }
}
