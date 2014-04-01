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

<?
        $sql         = "CALL get_count_posttype('POST')";
        $result      = mysql_query($sql);
        $postCount   = mysql_result($result, 0);
        $outputTable = "";

        if ( mysql_error() ) {

        } else {
            if( $postCount == 0 ) {
                $outputTable = "<tr></tr>";
            }
            else {

            }
        }
?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
            <div class="table-responsive">
            <table class="table table-hover table-striped">
            </table>
            </div>
        </div>
    </div>

<?php
    include("_top.php");
?>

<?php
    include("_footer.php");
    include ("_assets_javascript.php");
?>
</div>
</body>