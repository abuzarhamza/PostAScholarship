<?php
    ob_start();
    session_start();
    require_once("./includes/config.php");
    require_once("./includes/functions.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<link rel="icon" href="templates/img/logo.png" sizes="16x16" type="image/png">
<title><? echo SITE_URL_TITLE; ?> - Administrator</title>
<?php include "_assets.php";?>
</head>
<?php
    include("_top.php");
?>

<div="container" style="margin: 10px;">
    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
                <h1>Manage Post</h1>
            </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
            <ol class="breadcrumb">
              <li><a href="./index.php?page=home">Home</a></li>
              <li><a href="./index.php?page=dashboard">Dashboard</a></li>
              <li class="active">Manage Post</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-md-offset-1 col-lg-offset-1" >
            <div class="span2">
              <p><a href="./add_post.php"><button class="btn btn-warning"><span class="fa fa-pencil-square-o"> </span> Add post</button></p>
            </div>
        </div>
    </div>
<?

        $sql         = "CALL get_count_posttype('POST')";
        $result      = mysql_query($sql);
        $pageHtml    = "";
        $postHtml    = "<tr>
                          <td>#</td>
                          <td>title</td>
                          <td>author name</td>
                          <td>creation date</td>
                          <td>view,bookmark stats</td>
                        </tr>\n";
        $errorFlag   = 0;

        if ( mysql_error() ) {
            $errorFlag =1;
        }


        $postCount    = mysql_result($result, 0);

        /*
**********SAMPLE USAGE *************
$obj = new DataPageset(500,10,4,5,'slide');
echo "test1\n";
echo "current page :" . $obj->current_page . "\n";
echo "previous_page : ". $obj->previous_page() . "\n";
echo "last_page : ". $obj->last_page() . "\n";
echo "next_page : ". $obj->next_page() . "\n";
echo "enteries_on_this_page : ". $obj->enteries_on_this_page() . "\n";

$obj->current_page = 26;
echo "test1\n";
echo "current page :" . $obj->current_page . "\n";
echo "previous_page : ". $obj->previous_page() . "\n";
echo "last_page : ". $obj->last_page() . "\n";
echo "next_page : ". $obj->next_page() . "\n";
echo "enteries_on_this_page : ". $obj->enteries_on_this_page() . "\n";
$obj->pages_in_set();

foreach ($obj->page_set_pages as $v) {
    echo "$v\n";
}
*/
    if ( $postCount == 0 ) {
      $errorFlag = 2;
    }
    else {
        $recLimit     = 10;
        $currentPage  = 1;

        if ( isset( $_GET{'rec'} ) ) {
            $recLimit    = $_GET{'rec'};
        }
        if ( isset( $_GET{'page'} ) ) {
            $currentPage = $_GET{'page'};
        }

        $pageObj      =  new DataPageset($postCount,$recLimit,$currentPage,5,'slide');
        if ( $pageObj->current_page == 1 ) {
          $offset      = 0;
        }
        else {
          $offset      =  $pageObj->current_page * $recLimit;
        }
        $sql         = "CALL get_postviewtags_for_admin($offset,$recLimit,'POST')";
        $result      = mysql_query($sql);

    }


        if ($postCount == 0 && $errorFlag == 0 ) {
            $errorFlag = 2;
        }

        if ( $errorFlag == 0 ) {
            if ( isset($_GET{'page'} ) ) {
               $page   = $_GET{'page'} + 1;
               $offset = $rec_limit * $page ;
            }
            else {
               $page = 0;
               $offset = 0;
            }
            $leftRec = $postCount - ($page * $recLimit);

            $sql         = "CALL get_postviewtags_for_admin($offset,$recLimit,'POST')";
            $result      = mysql_query($sql);
            // if ( mysql_error() ) {
            //     header("Locatrion: $_PHP_SELF?res=sqlerror");
            //     exit;
            // }

            $postCounter = 1;
            while ( $row = mysql_fetch_array ($result)) {
                $postHtml .= '<tr>
                              <td>$postCounter</td>
                              <td><a href="">'.$row['title'].'</a></td>
                              <td><a href="">'.$row['author name'].'</a></td>
                              <td>'.$row['creation_date'].'</td>
                                <td> <span class="glyphicon glyphicon-bookmark"> <span class="badge"> '.$row['book_count'] .'</span>
                                   <span class=" fa fa-caret-square-o-right"> <span class="badge"> '. $row['view']."</span>
                              </td>
                            </tr>\n";
                $postCounter++;
            }

            $pageHtml = '<div class="row">  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >';
            $pageHtml .= '<ul class="pagination">';
            $countPage = 1;


           if ( $page == 0 ) {
                $pageHtml .= '<li><a href="#">&laquo;</a></li>';
                $pageHtml .= '<li><a href="'.$_PHP_SELF?page=$last.'">'.$page.'</a></li>';
                $pageHtml .= '<li><a href="#">&raquo;</a></li>';
           }
           elseif ( $page > 0 ) {
                $pageHtml = "";
           }
           elseif ( $left_rec < $rec_limit ) {
                $pageHtml = "";
           }
           $pageHtml .= '</div> </div>';

        }

        // if( $page > 0 )
        // {
        //    $last = $page - 2;
        //    echo "<a href=\"$_PHP_SELF?page=$last\">Last 10 Records</a> |";
        //    echo "<a href=\"$_PHP_SELF?page=$page\">Next 10 Records</a>";
        // }
        // else if( $page == 0 )
        // {
        //    echo "<a href=\"$_PHP_SELF?page=$page\">Next 10 Records</a>";
        // }
        // else if( $left_rec < $rec_limit )
        // {
        //    $last = $page - 2;
        //    echo "<a href=\"$_PHP_SELF?page=$last\">Last 10 Records</a>";
        // }
?>

    <!--error msg-->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
<?
    if ($RES == "sqlerror" || $errorFlag==1 ) echo '<div class="alert alert-danger alert-dismissable">SQL error</div>';
    if ($RES == "nopost" ||  $errorFlag==2) echo '<div class="alert alert-danger alert-dismissable">No post can be found</div>';
?>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
            <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">Posts</div>
                <table class="table table-hover table-striped">
                </table>
        </div>
    </div>
      <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
        <ul class="pagination">
              <li><a href="#">&laquo;</a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">4</a></li>
              <li><a href="#">5</a></li>
              <li><a href="#">&raquo;</a></li>
         </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
            <div class="table-responsive">
            <table class="table table-hover table-striped">
            </table>
            </div>
        </div>
    </div>



<?php
    include("_footer.php");
    include ("_assets_javascript.php");
?>
</div>
</body>