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
        <?php
            if($RES=="update_success") echo '<div class="alert alert-success alert-dismissable">User profile updated successfully</div>';
            if($RES=="update_error") echo '<div class="alert alert-danger alert-dismissable">User profile  could not be updated due to some error</div>';
        ?>
        </div>
    </div>

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
    //STORE proredur
    //give result and create and id too if not
    $userName = $_SESSION['s_admin_username'];
    $sql = "CALL verify_and_insert_username('$userName')";
    $result   = mysql_query($sql);

    if ( $result ) {
        $arrRes   = mysql_fetch_assoc($result);
    }
?>

<?php if ($result) : ?>
        <form class="form-horizontal" role="form" action="./profile_ops.php?action=update_user_profile" method="post">
            <div class="form-group">
                <label for="display_name" class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-md-offset-1 col-lg-offset-1"> Display Name</label>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                  <input type="text" class="form-control" id="display_name" name="display_name" maxlength="30" value="<?=$arrRes['display_name']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="first_name" class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-md-offset-1 col-lg-offset-1"> First Name</label>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                  <input type="text" class="form-control" id="first_name" name="first_name"  maxlength="30" value="<?=$arrRes['first_name']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="last_name" class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-md-offset-1 col-lg-offset-1"> Last Name</label>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                  <input type="text" class="form-control" id="last_name" name="last_name"  maxlength="30" value="<?=$arrRes['last_name']; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="web" class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-md-offset-1 col-lg-offset-1"> Web url</label>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                  <input type="text" class="form-control" id="web" name="web"  maxlength="30" value="<?=$arrRes['web']; ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="about_me" class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-md-offset-1 col-lg-offset-1"> About me</label>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                  <textarea class="form-control" id="about_me" name="about_me" rows="4" cols="40" maxlength="140"><?=$arrRes['about_me']; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-md-offset-3 col-lg-offset-3">
                  <button type="submit" class="btn btn-primary">Update profile</button>
                </div>
            </div>
        </form>
<? else : ?>
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
        <div class="alert alert-danger alert-dismissable">Error encountered !!</div>
    </div>
<? endif; ?>

<?php
    include("_footer.php");
    include ("_assets_javascript.php");
?>
</div>
</body>