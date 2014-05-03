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
                <h1>Add Post</h1>
            </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
            <ol class="breadcrumb">
              <li><a href="./index.php?page=home">Home</a></li>
              <li><a href="./index.php?page=dashboard">Dashboard</a></li>
              <li><a href="./post.php">Manage Post</a></li>
              <li class="active">Add post</li>
            </ol>
        </div>
    </div>

    <div class="row">

        <form class="form" role="form" action="" method="post">
            <div class="form-group">
                <label for="post_title" class="col-xs-12 col-sm-12 col-md-1 col-lg-1 col-md-offset-1 col-lg-offset-1">title</label>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                  <input type="text" class="form-control" id="post_title" name="post_title" placeholder="title">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <!--<p> It sdfsdfnsofnn sndfnsdfn <br/> jsdfsndfnsonf <br/> lets me </p>-->
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1">
                    <label for="post content">Post content</label>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1">
                    <textarea class="form-control" id="post_content" name="post_content" rows="10" cols="40" maxlength="2000" placeholder="post input"></textarea>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                  <!--<p> It sdfsdfnsofnn sndfnsdfn <br/> jsdfsndfnsonf <br/> lets me </p>-->
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1">
                    <label for="post content">Tags</label>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 col-md-offset-1 col-lg-offset-1">
                    <textarea class="form-control" id="tags" name="tags" rows="1" cols="1" maxlength="500" placeholder="post input"></textarea>
                </div>
                <p>Suggestions: <span id="txtHint"></span></p> <!--tag suggstion-->
                <!--<p> It sdfsdfnsofnn sndfnsdfn <br/> jsdfsndfnsonf <br/> lets me </p>-->
            </div>


            <div class="form-group">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-md-offset-1 col-lg-offset-1">
                  <br/>
                  <button type="submit" class="btn btn-success">Post It ! Share is caring</button>
                </div>
            </div>
        </form>
            <!-- content post_settings-->
    </div>

    