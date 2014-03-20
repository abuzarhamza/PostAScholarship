<?php
ob_start();
session_start();

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

        if ( array_key_exists('admin_name', $_POST) &&
             array_key_exists('admin_password', $_POST)
        ) {

            $adminUser      = trim($_POST['admin_name']);
            $password       = trim($_POST['admin_password']);
            $encryptedPwd   = md5($password);

            $sql     = " SELECT * FROM admin_table 
                          WHERE admin_name='$adminUser' 
                            AND password='$encryptedPwd'
                            AND status='1'
                       ";

            $result  = mysql_query($sql) or die(mysql_error());
            $arrres  = mysql_fetch_assoc($result);
            $numRows = mysql_num_rows($result);

            if ( $numRows != 0 ) {

                $_SESSION['s_admin_logged_in'] = true;
                $_SESSION['s_admin_username']  = $username;
                $_SESSION['s_admin_type']      = $arrres['group_id'];
                header("Location: index.php?res=login_success");

            } else {

                header("Location: index.php?res=login_error");

            }
            exit;

        }
        
        

    }
    elseif (1) {

    }   
}



