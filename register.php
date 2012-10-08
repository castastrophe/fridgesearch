<?php
	session_start();
	include("credentials.php");
	include("dbLogin.php");
	
	/* After putting in your info, this puts your data into the Registration db */
	if(@$_GET['register']=="submit"){
	   	$first 	= $_POST[first];
	   	$last	= $_POST[last];
	   	$email	= $_POST[email];
	   	$thePwd	= $_POST[thePwd];
	
		/* Find out if that e-mail is already registered */
	   	$query = stripSlashes("SELECT COUNT(*) FROM User WHERE email='$email' LIMIT 1");
	   	$result=mysql_fetch_row(mysql_query($query));
	   
	   	/* If that e-mail is already registered, give an error message */
	   	if($result[0]==1){
	   		$_SESSION['error']="emailRegistered";
	   		header("Location: register.php");
		}
		
		/* If not, add the information to the Register db */
	    else{
	    	/* Find out if the e-mail is in the Register db */
	    	 $query = stripSlashes("SELECT COUNT(*) FROM Register WHERE email='$email' LIMIT 1");
	  		 $result=mysql_query($query);
	  		 $row=mysql_fetch_row($result);
	  		 
	  		 /* If the e-mail is in the db, replace it with new data */
	   		if($row[0]==1){
	   			$query="UPDATE Register SET password='$thePwd', firstName='$first', lastName='$last' WHERE email='$email'";
		   		$result=mysql_query($query);
	   		}
	   		else{
		   		$query="INSERT INTO Register values(\"$email\",\"$thePwd\",\"$first\",\"$last\")";
		   		$result=mysql_query($query);
		   	}
	   			
	   			unset($_SESSION['check']);
	   			/* E-mail the confirmation to the customer */
	  		 	$subject = "What's in Your Fridge - Confirmation E-mail";
 				$body = "Go to casgentry.com/register.php?step=validate&email=".$email." to confirm your membership with What's in Your Fridge.";
 				if (mail($email, $subject, $body)) {
   					header("Location: register.php?step=confirm");
  				} 
  				else {
  					$_SESSION['error']="emailFailed";
  					header("Location: register.php");
	   			}
	  	}

  	}
  	
  	/* Check that the entered info matches the Registration db */
  	if(@$_GET['step']=="validate" && @$_GET['checkPwd']=="do"){
		/* Using the e-mail entered, pull the pwd, fn, and ln from the db */
  	 	include("dbLogin.php");
  	 	unset($_SESSION['check']);
  	 	unset($_SESSION['error']);
  	 	
  	 	$email = $_GET['email'];
  		$usrPwd = $_POST['usrPwd'];
  		
  		$query="SELECT password,firstName,lastName FROM Register WHERE email='$email'";
  		$result=mysql_query($query);
  		
  		$row=mysql_fetch_row($result);
  		
  		echo $row[0];
  		/* If the password entered matches the password from the db, enter it into the User db */
  		if($usrPwd == $row[0]){
  			$_SESSION['check']="confirmed";
			$query="INSERT INTO User VALUES(\"$email\",\"$row[0]\",\"$row[1]\",\"$row[2]\", 1)";
			$result=mysql_query($query);
	
			/* Delete the information from the Register db */
			$query="DELETE FROM Register WHERE email='$email'";
			$result=mysql_query($query);
		}
		/* Provide an error message if the password doesn't match */
		else{
			$_SESSION['error']="mismatchPassword";
		}
	}
?>
<html>
<head>
<!-- 
   Home Page for CS230
   Author: Cas Gentry
   Date:   26 Oct 10

   Filename:         register.php
   Supporting files: format.css
-->
<link href="format.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="error.js"> </script>

<title>Database Project</title>
</head>
<body>
<div id="main">
	<div id="title">	
		<h1>What's in your 'fridge?</h1>
	</div>
		
	<div id="whyJoin">
		<div class="regTop">Become a member NOW to enjoy<BR>the following features:</div>
		<div class="regBot">
		<ul>
			<li>Save your favorite recipes</li>
			<li>Rate and review recipes</li>
			<li>Create a shopping list</li>
			<li>Submit your own recipes</li>
		</ul>
		</div>
	</div>
			
	<div id="regForm">
		<?php
		if(@$_GET['step']=="confirm"){
			echo "<p>Thank you for registering!  A confirmation e-mail will now be sent to the provided address with further instructions.</p>";
		}
		elseif(@$_GET['step']=="validate"){
			if(@$_SESSION['check']=="confirmed"){
				unset($_SESSION['check']);
				$_SESSION['login']="yes";
				echo "<p>Thank you for registering!</p>";
				echo "<form action=\"index.php\" method=\"POST\"><input type=\"submit\" value=\"Return Home\"/></form>";
			}
			else{
				$email	= $_GET['email'];
			
				echo "<form action=\"register.php?step=validate&checkPwd=do&email=".$email."\" method=\"POST\">";
				echo "<table><tr><td colspan=\"2\">To confirm your registration, please re-enter your e-mail and password.</td></tr>";
				echo "<tr><td>E-mail:</td><td><input type=\"text\" name=\"email\" size=\"15\" value=".$email."></td></tr>";
				echo "<tr><td>Password:</td><td><input type=\"password\" name=\"usrPwd\" size=\"15\"/></td></tr>";
				if (@$_SESSION['error']=='mismatchPassword'){
					unset($_SESSION['error']);
					echo "<tr><td></td><td class=\"errorMsg\" align=\"left\">Password does not match.</td></tr>";
				}
				echo "<tr><td></td><td><input type=\"submit\" name=\"Register\"/></td></tr></table>";
				
			}
		}
		else{
			if(@$_SESSION['error']=='emailRegistered'){ 
				echo "<p class=\"errorMsg\">This e-mail address has already been registered.</p>";
				unset($_SESSION['error']);
			}
			
			/* The registration form - sends you to register=submit upon submit */
			echo "<form action=\"register.php?register=submit\" method=\"POST\">";
			echo "<table><tr>";
			echo "<td colspan=\"2\" class=\"loginTitle\"><h3>Registration</h3></td>";
			echo "</tr><tr>";
			echo "<td>First name:</td><td><input type=\"text\" name=\"first\" size=\"15\"/></td>";
			echo "</tr><tr>";
			echo "<td>Last name:</td><td><input type=\"text\" name=\"last\" size=\"15\"/></td>";
			echo "</tr><tr>";
			echo "<td>E-mail address:</td><td><input type=\"text\" name=\"email\" size=\"15\"/>";
			
			if (@$_SESSION['error']=='emailFailed'){ 
				echo "<p class=\"errorMsg\">Invalid e-mail address</p>";
				unset($_SESSION['error']);
			}
			
			echo "</td>";
			echo "</tr><tr>";
			echo "<td>Password:</td><td><input type=\"password\" name=\"thePwd\" size=\"15\"/></td>";
			echo "</tr><tr><td></td>";
			echo "<td class=\"button\"><input type=\"submit\" value=\"Register\" name=\"Register\"/></td>";
			echo "</tr></table></form>";
		}
		?>
	</div>

</div>

<?php include("lowerLinks.php"); ?>

</body>
</html>