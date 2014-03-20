<?php
ob_start();
session_start();

require_once("./includes/config.php"); //include configuration file
require_once("./includes/functions.php"); //include file containing all functions
require_once("./classes/phpmailer/class.phpmailer.php"); //phpMailer Class for safe mailing

$conn=mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD);
mysql_select_db(DB_DATABASE) or die("database not available");
?>

<?
$action=@$_GET['action'];

if( $action == "login" ) {
	$adminUser =@trim($_POST['admin_name']);
	$password  =@trim($_POST['admin_password']);

	$sql     ="SELECT * FROM center_mst WHERE center_code='$center_code' AND password='$password'";
	$result  =mysql_query($sql)or die(mysql_error());
	$num_rows=mysql_num_rows($result);

}
elseif (1) {

}