<?php
    include("./_admin_start.php");
    include("./_admin_initialize.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title><? echo SITE_URL_TITLE; ?></title>
<link rel="icon" href="templates/img/logo.png" sizes="16x16" type="image/png">
<? include "_assets.php";?>
</head>

<div="container" style="margin: 10px;">
<?php
    include("_top.php");
?>
    <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
                <h1>Manage Admin detail</h1>
            </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
            <ol class="breadcrumb">
              <li><a href="./index.php?page=home">Home</a></li>
              <li><a href="./index.php?page=settings">Settings</a></li>
              <li class="active">Manage Admin detail</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1" >
        <?php
            if($RES=="edit_success") echo '<div class="alert alert-success alert-dismissable">Group id edited successfully</div>';
            if($RES=="edit_error") echo '<div class="alert alert-danger alert-dismissable">Group id could not be edited due to some error</div>';
        ?>
        </div>
    </div>

    <?  //SELECT QUERY TO LIST DATA

        //if user admin he can update the button or else disable.
        $username = $_SESSION['s_admin_username'];
        $sql      =  "SELECT * FROM admin_mst
                       WHERE USERNAME = '$username'";
        $result   = $conn->query($sql);
        if ($conn->error) {
            printf("MySQL error encountered : %s",$conn->error);
        }
        $num_rows = $result->num_rows;
        $arrres   = $result->fetch_assoc();
    ?>
    <? if ($num_rows != 0 && $username == 'admin')
    {?>

        <form class="form-horizontal" role="form" action="./admin_login.php?action=save_admin_settings" method="post">
            <div class="form-group">
                <label for="inputPassword3" class="col-xs-12 col-sm-12 col-md-2 col-lg-2 col-md-offset-1 col-lg-offset-1"> Group id</label>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                  <input type="text" class="form-control" id="group_id" name="group_id" maxlength="2" value="<?=$arrres['group_id']; ?>">
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-md-offset-3 col-lg-offset-3">
                  <button type="submit" class="btn btn-primary">Update Setting</button>
                </div>
            </div>
        </form>

    <? } else { ?>

        <div="row">
            <div class="col-xs-12 col-sm-4 col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
                <div class="jumbotron">
                  <h1> <?php echo "Hi $username!";?> </h1>
                  <p>Please contact admin to for more detail to enable your settings.</p>
                </div>
            </div>
        </div>
    <? } ?>
<?php
    include("_footer.php");
    include ("_assets_javascript.php");
?>
</div>
</body>