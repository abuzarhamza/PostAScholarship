<?php
//--------------------------------------------------------------------------------------
//check if admin is logged or not
function CheckAdminLogedIn() {
	return true;
	if( isset($_SESSION['s_admin_logged_in']) && $_SESSION['s_admin_logged_in']==true )
	{
		return true;
	}
	else
	{
		return false;
	}
}
?>