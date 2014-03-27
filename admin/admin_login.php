<?php
ob_start();
session_start();
header("Cache-control: private");

require_once("./includes/config.php"); //include configuration file
require_once("./includes/functions.php"); //include file containing all functions

$conn = mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD);
mysql_select_db(DB_DATABASE) or die("database not available");
?>

<?
//The @ is error suppression operator in PHP.

if  ( array_key_exists('action', $_GET) ) {

    $action = $_GET['action'];

    if ( $action == "login" ) {

        if ( array_key_exists('username', $_POST) &&
             array_key_exists('password', $_POST)
        ) {

            $adminUser      = trim($_POST['username']);
            $password       = trim($_POST['password']);
            $encryptedPwd   = md5($password);

            $sql     = " SELECT * FROM admin_mst
                          WHERE username = '$adminUser' 
                            AND password = '$password'
                            AND status='1'
                       ";

            $result  = mysql_query($sql) or die(mysql_error());
            $arrres  = mysql_fetch_assoc($result);
            $numRows = mysql_num_rows($result);

            if ( $numRows != 0 ) {
                //session data is being set
                $_SESSION['s_admin_logged_in'] = true;
                $_SESSION['s_admin_username']  = $adminUser;
                $_SESSION['s_admin_type']      = $arrres['group_id'];
                header("Location: index.php?res=login_success");

            } else {
                header("Location: index.php?res=login_error");
            }
            exit;

        } else {
            header("Location: index.php?res=login_error");
            exit;
        }

    }
    elseif($action=="logout") {
        $sql = "UPDATE admin_mst 
                   SET last_login='".TimestampToMySQLdatetime()."' 
                 WHERE username='$_SESSION[s_admin_username]'";

        $result=mysql_query($sql) or die(mysql_error());
        
        $_SESSION['s_admin_logged_in'] = false;
        $_SESSION['s_admin_username']  = "";
        $_SESSION['s_admin_type']      = "";

        session_destroy();
        
        header("Location: index.php?res=logout_success");
        exit;
    }
    elseif ( $action == "change_password" ) {

        if ( array_key_exists('s_admin_username', $_SESSION) &&
             array_key_exists('old_password',$_POST) &&
             array_key_exists('new_password',$_POST) &&
             array_key_exists('confirm_password',$_POST) 

        ) {
            $username        = $_SESSION['s_admin_username'];
            // $oldPassword     = clean($_POST['old_password']);
            // $newPassword     = clean($_POST['new_password']);
            // $cofirmPassword  = clean($_POST['confirm_password']);

            $oldPassword     = trim($_POST['old_password']);
            $newPassword     = trim($_POST['new_password']);
            $cofirmPassword  = trim($_POST['confirm_password']);

            $encryptedOldPwd = md5($oldPassword);
            $encryptedNewPwd = md5($newPassword);

            if ( $newPassword != $cofirmPassword ) {
                header("Location: change_admin_password.php?res=old_new_mismatch");
                exit;
            }

            $sql="SELECT * FROM admin_mst 
                   WHERE username ='$username' 
                     AND password ='$oldPassword'";
            
            $result   = mysql_query($sql) or die(mysql_error());
            $num_rows = mysql_num_rows($result);

            if($num_rows!=0) {
                $sql="UPDATE admin_mst SET password='$newPassword'
                       WHERE username='$username'";
                $result=mysql_query($sql) or die(mysql_error());

                //session variable unset
                $_SESSION['s_admin_logged_in'] = false;
                $_SESSION['s_admin_username']  = "";
                $_SESSION['s_admin_type']      = "";
                session_destroy();
            
                header("Location: index.php?res=change_password_success");
            } 
            else {
                header("Location: change_admin_password.php?res=invalid_old_password");
            }
            exit;

        }
        else {
            header("Location: index.php?res=");
            exit;
        }
    }
    elseif( $action=="save_settings" ) {

        foreach( $_POST as $setting_name => $setting_value) {

            if($setting_name!='Submit') {
                $setting_name =@clean($setting_name);
                $setting_value=@clean($setting_value);
                
                $sql="UPDATE cms_settings_mst SET setting_value='$setting_value' WHERE setting_name='$setting_name'";
                $result=mysql_query($sql) or die(mysql_error());        
            }
        }

        header("Location: general_settings.php?res=success");
        exit;
    }   
}
?>
<?php
ob_end_flush();
?>


