<?php	
	include("credentials.php");
	include("dbLogin.php");
	
	$getName = $_SESSION['username'];
		
	$query = stripSlashes("SELECT firstname,lastname FROM User WHERE email='$getName'");
	$result=mysql_fetch_row(mysql_query($query));
	
	echo "<div id=\"welcome\">";
	echo "Welcome ".$result[0]." ".$result[1]."!";
	echo "</div>";
	
	echo "<div id=\"userMenu\"><table><tr>";
	echo "<tr><td colspan=\"2\"><a href=\"account.php\">Account Information</a></td></tr>";
	echo "<tr><td colspan=\"2\"><a href=\"cookbook.php\">My Cookbook</a></td></tr>";
	echo "<tr><td colspan=\"2\"><a href=\"addrecipes.php\">Add Recipes</a></td></tr>";
	echo "<tr><td><a href=\"index.php?dologin=false\">Log Out</a></td></tr>";
	echo "</table></div>";
?>