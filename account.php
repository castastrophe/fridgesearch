<?php
	session_start();
	if($_SESSION['login']!="yes"){
		header("Location: index.php");
	}
?>

<html>
<head>

<!-- 
   Home Page for CS230
   Author: Cas Gentry
   Date:   12 Oct 10

   Filename:         home.html
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
	<h2>Account Information</h2>
</div>
	<div id="showAccount">
		<?php
			include("openDB.php");
			
			$usrID = $_SESSION['username'];
			
			$query = stripSlashes("SELECT firstName, lastName, email FROM User WHERE email='".$usrID."'");
			$result=mysql_query($query);
			
			$heading = array ("First name", "Last name", "Email");
			echo "<table>";
			
			for($i=0; $i<mysql_num_rows($result); $i++){
				$row=mysql_fetch_row($result);
				
				for( $j=0; $j<mysql_num_fields($result); $j++ ){				
					echo "<tr><td width=\"40%\" align=\"right\">".$heading[$j].":</td>";
					echo "<td width=\"60%\">".$row[$j]."</td></tr>";
				}
			}
			
			echo "</table>";
		?>
	</div>
	
	<?php
		include("userMenu.php");
	?>
</div>

<?php include("lowerLinks.php"); ?>

</body>
</html>