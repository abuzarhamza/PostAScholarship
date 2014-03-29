<? 
ob_start();
session_start();
header("Cache-control: private");

require_once("includes/config.php"); //includes configuration file
require_once("includes/functions.php"); //includes file containing all user defined functions

if(!CheckAdminLogedIn())
{
	header("Location: index.php");
}
?>