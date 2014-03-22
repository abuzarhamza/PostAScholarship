<?php
//--------------------------------------------------------------------------------------
//check if admin is logged or not
function CheckAdminLogedIn() {

	if( isset($_SESSION['s_admin_logged_in']) && $_SESSION['s_admin_logged_in']==true )
	{
		return true;
	}
	else
	{
		return false;
	}
}

//convert timestamp to MySQL's DATE or DATETIME (YYYY-MM-DD hh:mm:ss)
//returns the DATE or DATETIME equivalent of a given timestamp
function TimestampToMySQLdatetime($timestamp = "", $datetime = true)
{
  if(empty($timestamp) || !is_numeric($timestamp)) $timestamp = time();

    return ($datetime) ? date("Y-m-d H:i:s", $timestamp) : date("Y-m-d", $timestamp);
}
?>
