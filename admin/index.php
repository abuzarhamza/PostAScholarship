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
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td><?php include("_top.php");?> </td>
        </tr>

        <tr>
            <td align="centre">
                <?php if( CheckAdminLogedIn() ) { include("_panel.php"); }
                      else { include("_login.php"); }
                ?>
            </td>
        </tr>

        <tr>
            <td><? include("_footer.php");?></td>
        </tr>
    </table>
</body>
</html>

<?php
//closing the db connection
mysql_close($conn) or die("error closing connection");
ob_end_flush();
?>