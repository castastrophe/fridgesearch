<?php

function login_status(){
	if($_SESSION['login']!="true"){ header("Location: index.php"); }
}

function connect_db(){
	include("credentials.php");
	include("dbLogin.php");
}

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

function ratings($recID, $user){
	//if the user has not yet rated this recipe
	$query = stripSlashes("SELECT COUNT(numStars) FROM Ratings WHERE recipeID='".$recID."' AND userID='".$user."'");
	$result = mysql_query($query);
	$rateQuery = mysql_fetch_row($result);
		
	//For recipes you have not yet rated
	if($rateQuery[0] == 0){
		for($r=0; $r<4; $r++){
			$s = ($r+1);
			echo "<a href=\"recipeView.php?recipeID=".$recID."&rating=".$s."\"";
			echo " onMouseOver=\"mouseOver(".$s.")\"";
			echo " onMouseOut=\"mouseOut(".$s.")\">";
			echo "<img src=\"rating_star_blank.png\" name=\"star".$s."\" id=\"rate\"/></a>";
		}
	}
	//For recipes you have already rated
	else{
		$query = stripSlashes("SELECT numStars FROM Ratings WHERE recipeID='".$recID."' AND userID='".$user."'");
		$result = mysql_query($query);
		$rating = mysql_fetch_row($result);

		for($r=0; $r<4; $r++){
			$s = ($r+1);
			echo "<a href=\"recipeView.php?recipeID=".$recID."&rating=".$s."\"";
			echo " onMouseOver=\"mouseOver(".$s.")\"";
			echo " onMouseOut=\"mouseOut(".$s.")\">";
			echo "<img src=\"";
			if($r < $rating[0]){
				echo "rating_star_full.png";
			}
			else{
				echo "rating_star_blank.png";
			}
			echo "\" name=\"star".$s."\" id=\"rate\"/></a> ";
		}
	}
}

?>