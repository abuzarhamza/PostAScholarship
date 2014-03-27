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
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
                <div id="validation_msg" class="hide"></div>
            </div>
        </div>

        <form class="form-horizontal" role="form" action="./admin_login.php?action=change_password" method="post">
            <div class="form-group has-success has-feedback">
                <label for="inputPassword3" class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-md-offset-1 col-lg-offset-1"> Old Password</label>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                  <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Password">
                </div>
            </div>
            <div class="form-group has-success has-feedback">
                <label for="inputPassword3" class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-md-offset-1 col-lg-offset-1"> New Password</label>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                  <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password">
                </div>
            </div>
            <div class="form-group has-success has-feedback">
                <label for="inputPassword3" class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-md-offset-1 col-lg-offset-1"> Confirm Password</label>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                  <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-md-offset-3 col-lg-offset-3">
                  <button type="submit" class="btn btn-default">Change Password</button>
                </div>
            </div>
        </form>

<?php
    include("_footer.php");
    include ("_assets_javascript.php");
?>
</div>
</body>