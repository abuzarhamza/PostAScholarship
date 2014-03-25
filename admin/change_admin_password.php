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

<body>
<div="container" style="margin: 10px;">
<?php
    include("_top.php");
?>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
                <h1>Change Password</h1>        
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
                <ol class="breadcrumb">
                  <li><a href="./index.php?page=settings">Settings</a></li>
                  <li class="active">Change Password</li>
                </ol>
            </div>
        </div>

        <form class="form-horizontal" role="form" action="./admin.php?" method="post">
            <div class="form-group">
                <label for="inputPassword3" class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-md-offset-1 col-lg-offset-1"> Old Password</label>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                  <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                </div>
            </div>
        </form>
    

        <form action="./admin.php?" method="post" accept-charset="UTF-8" class="form-horizontal">
            <div class="input-group">
                <span class="input-group-addon">old password</span>
                <input type="password" class="form-control" placeholder="password" name="old_password" id="old_password">
            </div>
            <div class="input-group">
                <span class="input-group-addon">new password</span>
                <input type="password" class="form-control" placeholder="password" name="new_password" id="new_password">
            </div>
            <div class="input-group">
                <span class="input-group-addon">confirm password</span>
                <input type="password" class="form-control" placeholder="password" name="confirm_password" id="confirm_password">
            </div>
        </form>


<?php
    include("_footer.php");
    include ("_assets_javascript.php");
?>
</div>
</body>