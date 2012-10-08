<?php
/*
 * Page: index.php
 * Desc: Home page for recipe search
 * Author: Cas Gentry
 * Date Updated: 7 Oct 12
*/

	// allow output buffering
	ob_start('ob_gzhandler');

	// start a new session
	session_start();
    
    // include pages with connection details, DRY approach
  	include("credentials.php");
	include("dbLogin.php");
	
	//pull in stored functions
	include("functioncall.php");
	
	if(check_login($_POST['username'], $_POST['pwd'])){ $_SESSION['login'] = "true"; }
  	elseif(@$_GET['dologin'] == "no" ){ $_SESSION['login']="false"; }
?>

<html>
<head>

<!-- 
   Home Page for Recipe Organizing Tool
   Author: Cas Gentry
   Date:   12 Oct 10

   Filename:         index.php
   Supporting files: format.css, error.js, openDB.php, userMenu.php, dbLogin.php, funcioncall.php
-->

<link href="format.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="error.js"> </script>
<title>Recipe Organization Tool</title>

</head>

<body>
<div id="main">
	<?php
		if ( @$_SESSION['login'] != "true" ){
			echo "<div id=\"login\">";
			echo "<form action=\"index.php?dologin=yes\" method=\"POST\">";
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
		else{
			include("userMenu.php");
		}
	?>

	<div id="title">
		<h1>What's in your 'fridge?</h1>
	</div>

	<div id="content">
		<div id="fridge">
			<div id="searchForm">
			<form style="margin-left: 25px" action="searchResults.php" method="POST">
				<p>What ingredients would you like to cook with?</p>
				<?php
					for($a=0; $a<5; $a++){
						echo "<input type=\"text\" name=\"ingreds[]\" class=\"ingred\"/>";
					}
				?>
				<input type="submit" value="Search" class="button"/>
			</form>
			</div>
		</div>
	
		<div id="blurb">
			<p>Have you ever found yourself with a group of seemingly random ingredients and no idea what to make for dinner?
			Enter the main ingredients in the refridgerator to the left, hit Search, and peruse user-submited recipes
			that meet your needs!  Don't see your mom's famous spicy chili?  Register today and submit your own recipes!</p>
		</div>
		
		
	</div>

</div>

<?php include("lowerLinks.php"); ?>

</body>
</html>
<?php ob_end_flush(); ?>