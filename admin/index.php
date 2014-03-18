<?php
    ob_start();
    session_start();
    require_once("includes/config.php");
    require_once("includes/functions.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title><? echo SITE_URL_TITLE; ?> - Administrator</title>
<? include "_assets.php";?>
</head>

<body>

    <?php if( CheckAdminLogedIn() ) { include("_panel.php"); }
          else { include("_login.php"); }
    ?>

    <? include("_footer.php");?>
</body>
</html>

<?php
//closing the db connection
mysql_close($conn) or die("error closing connection");
ob_end_flush();
?>