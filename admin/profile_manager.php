<?php
    include("./_admin_start.php");
    include("./_admin_initialize.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title><? echo SITE_URL_TITLE; ?></title>
<? include "_assets.php";?>
</head>

<div="container" style="margin: 10px;">

<?php
    include("_top.php");
?>

    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
                <h1>Profile</h1>
            </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
            <ol class="breadcrumb">
              <li><a href="./index.php?page=home">Home</a></li>
              <li><a href="./index.php?page=profile">Profile</a></li>
              <li class="active">Edit your profile</li>
            </ol>
        </div>
    </div>

<?php
    include("_footer.php");
    include ("_assets_javascript.php");
?>
</div>
</body>