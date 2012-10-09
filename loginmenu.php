<?php
	if ($_SESSION['login'] == "true"){
		include("userMenu.php");
	}
	else{
		echo "<div id=\"login\">";
		echo "<form action=\"index.php?dologin=true\" method=\"POST\">";
		echo "<table><tr>";
		echo "<td class=\"tableTag\">E-mail</td></tr>";
		echo "<tr><td><input type=\"text\" name=\"username\" class=\"logInput\" maxlength=\"50\"/></td></tr>";
			
		echo "<tr><td><p class=\"errorMsg\">";
		if(@$_SESSION['mismatch']=="true"){
			echo "Incorrect username or password.";
		}
		elseif(@$_SESSION['unregistered']=="true"){
			echo "E-mail not yet registered.";
		}
	
		echo "</p></tr><tr><td class=\"tableTag\">Password</td></tr>";
		echo "<tr><td><input type=\"password\" name=\"pwd\" class=\"logInput\" maxlength=\"50\"/>";
		echo "</td></tr><tr>";
		echo "<td><div class=\"signup\">Not yet a member?  <a href=\"register.php\">Sign up</a> today.</div></td>";
		echo "</tr><tr><td><input type=\"submit\" class=\"logButton\" value=\"Login\"/></td></tr>";
		echo "</table></form>";
		echo "</div>";
	}
?>