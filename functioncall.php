<?php

function check_login($usr, $pass){
	unset($_SESSION['mismatch']);
	unset($_SESSION['unregistered']);
	
	if(empty($usr)){
		$_SESSION['err'] = "User name is empty."; 
		return false;
	}
	elseif(empty($pass)){
		$_SESSION['err'] = "Password is empty."; 
		return false;
	}
	else{
		//get password from db based on e-mail entered
		$query  = stripSlashes("SELECT password FROM User WHERE email='$usr'");
		$result = mysql_fetch_row(mysql_query($query));

		//check that password matches entered password
		if($result[0] == $pass){
			$_SESSION['login']="true";
			$_SESSION['username']= $email;
		}
		else{
			$query = stripSlashes("SELECT COUNT(*) FROM User WHERE email='$email' LIMIT 1");
			$result=mysql_fetch_row(mysql_query($query));
			if($result[0]==1){ $_SESSION['mismatch']="true"; }
			else{ $_SESSION['unregistered']="true"; } 
		
			$_SESSION['login']="false";
		}
		
		return true;
	}
}

?>