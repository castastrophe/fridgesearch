<?php
	//allow output buffering
	ob_start('ob_gzhandler');

	//include pages with connection details, DRY approach
	connect_db();

	//pull in stored functions
	include("functioncall.php");
	
	if(check_login($_POST['username'], $_POST['pwd']))	{ $_SESSION['login'] = "true";  }
	elseif($_GET['dologin'] == "false" )				{ $_SESSION['login'] = "false"; }
?>