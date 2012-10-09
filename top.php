<?php
	//allow output buffering
	ob_start('ob_gzhandler');

	//pull in stored functions
	include("functioncall.php");

	//include pages with connection details, DRY approach
	connect_db();
	
	if(check_login($_POST['username'], $_POST['pwd']))	{ $_SESSION['login'] = "true";  $_SESSION['username'] = $_POST['username']; }
	elseif($_GET['dologin'] == "false" )				{ $_SESSION['login'] = "false"; }
?>