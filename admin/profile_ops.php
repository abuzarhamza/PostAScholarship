<?php
ob_start();
session_start();
header("Cache-control: private");

require_once("./includes/config.php"); //include configuration file
require_once("./includes/functions.php"); //include file containing all functions

// $conn = mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD);
// mysql_select_db(DB_DATABASE) or die("database not available");
//mysqli_set_charset($conn,"utf8");
?>

<?
    if  ( array_key_exists('action', $_GET) ) {
        $action           = $_GET['action'];
        $keyForUpdateForm = "display_name,first_name,last_name,about_me,web";
        $userName         = $_SESSION['s_admin_username'];
        $errorMsg         = "";
        $errorFlag        = 0;

        if ( $action == "update_user_profile" ) {

            foreach (explode(",", $keyForUpdateForm) as $key) {
                if ( array_key_exists($key, $_POST) ) {
                    $_POST[$key] =  $conn->mysqli_real_escape_string(trim($_POST[$key]));
                }
                else {
                    $errorFlag = 1;
                }
            }

            if ( $errorFlag != 1 ) {
                $sql      = "CALL verify_and_update_adminprofile('$userName','$_POST[display_name]','$_POST[first_name]','$_POST[last_name]','$_POST[about_me]','$_POST[web]')";

                $result   = $conn->query($sql);
                if ( $conn->error ) {
                    $errorFlag = 1;
                } else {
                    if( $result->data_seek(0) == 0 ) {
                        $errorFlag = 1;
                    }
                }
            }

        }
        else {
            $errorFlag = 1;
        }

        if ($errorFlag  == 1)  {
            //echo "<p>should forward</p>";
            header("Location: profile_manager.php?res=update_error");
            exit;
        }
        else {
            header("Location: profile_manager.php?res=update_success");
            exit;
        }
    }
    else {
        header("Loaction : profile_manager.php?res=update_error");
        exit;
    }
?>

<?php
ob_end_flush();
?>