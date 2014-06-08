<?php
    ob_start();
    //session_start();
    include("./_admin_start.php");
    include("./_admin_initialize.php");
    // require_once("./includes/config.php");
    // require_once("./includes/functions.php");
    require_once("./classes/PHP-DataPagination/DataPageset.class.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<link rel="icon" href="templates/img/logo.png" sizes="16x16" type="image/png">
<title><? echo SITE_URL_TITLE; ?> - Administrator</title>
<?php include "_assets.php";?>
</head>
<body>
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
              <p><a href="./add_post.php"><button class="btn btn-warning"><span class="fa fa-pencil-square-o"> </span> Add post</button></a></p>
            </div>
        </div>
    </div>

<?

    $pageHtml    = "";
    //<td>#</td>
    $postHtml    = "<tr>
                      <td>title</td>
                      <td>author name</td>
                      <td>creation date</td>
                      <td>bookmark </td>
                      <td>view </td>
                    </tr>\n";
    $errorFlag   = 0;

    //$sql         = "CALL get_count_posttype('POST')";
    //SQL error : Commands out of sync; you can't run this command now
    $sql         = "select count(id) as count from post
                     where root = 1
                     order by creation_date";
    $result      = $conn->query($sql);
    if ( $conn->error ) {
        $errorFlag =1;
    }
    else {
        $postCountArr    = $result->fetch_object();
        $postCount       = $postCountArr->count;
        $result->close();
    }


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
          $offset     = 0;
        }
        else {
            if ( ! is_null($pageObj->previous_page() ) ) {
                $offset  =  $pageObj->previous_page() * $recLimit;
            }
        }

        if (! $conn->multi_query("CALL get_postview_for_admin($offset,$recLimit)")
        ) {
            $errorFlag =1;
        }
        else {
            do {
                if ( $res = $conn->store_result() ) {

                    while ( $obj = $res->fetch_object() ) {
                        $postHtml .= '<tr>
                                     <td><a href="">'. $obj->title . '</a></td>
                                     <td>'. $obj->author_name .'</td>
                                     <td>'.$obj->creation_date .'</td>
                                     <td> <span class="glyphicon glyphicon-bookmark"> <span class="badge"> '. $obj->book_count .'</span> </td>'.
                                     '<td>' .
                                     '<span class=" fa fa-caret-square-o-right"> <span class="badge"> '. $obj->view ."</span>
                                     </td>
                                   </tr>\n";
                    }
                    $res->free();
                }
            } while ( $conn->more_results() && $conn->next_result() );

            //pagination
            $pageHtml .= '<div class="row">  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >' . "\n";
            $pageHtml .= '<ul class="pagination"> '."\n";

            //echo "testing : current page : " . $pageObj->current_page;
            if ($pageObj->current_page == 1 ) {
              $pageHtml .= '<li class="disabled"> <a href="#"> &laquo </a></li>' ."\n";
            }
            else {
              $pageHtml .= '<li><a href="'. $_SERVER['PHP_SELF'] .'?page='.$pageObj->previous_page().'&rec=10'.'">&laquo;</a></li>' ."\n";
            }

            $pageObj->pages_in_set();

            foreach ($pageObj->page_set_pages as $pageNumber ) {

                if ( $pageNumber == $pageObj->current_page ) {
                $pageHtml .= '<li class="active"><span>'.$pageNumber.'<span class="sr-only">(current)</span></span></li>';
                }
                else {
                $pageHtml .= '<li><a href="'. $_SERVER['PHP_SELF'] .'?page='.$pageNumber.'&rec=10'.'">'. $pageNumber .'</a></li>';
                }
            }

            if ( $pageObj->current_page == $pageObj->last_page() ) {
                $pageHtml .= '<li class="disabled"><a href="#">&raquo;</a></li>';
            }
            else {

                if ( ! is_null($pageObj->next_page()) ) {
                    $pageHtml .= '<li><a href="'. $_SERVER['PHP_SELF'].'?page='.$pageObj->last_page().'&rec=10'.'">&raquo;</a></li>';
                }
                else {
                    $pageHtml .= '<li><a href="'. $_SERVER['PHP_SELF'].'?page='.$pageObj->next_page().'&rec=10'.'"> &raquo;</a></li>';
                }

            }

            $pageHtml .= '</div> </div>';

            echo $pageHtml;
        }
        
    }
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
?>

    <!--error msg-->
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
        <?
            if ( $RES == "sqlerror" ) echo '<div class="alert alert-danger alert-dismissable">SQL error : '. $conn->error .'</div>';
            if ( $RES == "nopost" ) echo '<div class="alert alert-danger alert-dismissable">No post can be found</div>';
            if ( $errorFlag == 1 ) echo '<div class="alert alert-danger alert-dismissable">SQL error : '. $conn->error .'</div>';
            if ( $errorFlag == 2 ) echo '<div class="alert alert-danger alert-dismissable">No post can be found</div>';
        ?>
        </div>
    </div>

<?php if ( $errorFlag != 1 && $errorFlag != 2 ) : ?>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
            <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">Posts</div>
                <table class="table table-hover table-striped">
                    <?php echo "$postHtml";?>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
            <div class="table-responsive">
            <table class="table table-hover table-striped">
            </table>
            </div>
        </div>
    </div>';

<?php endif;?>

<?php
    include("_footer.php");
    include ("_assets_javascript.php");
?>
</div>
</body>