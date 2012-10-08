<?php
  session_start();
	if($_SESSION['user']!="confirmed"){ 
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
<div id="title">
	<div id="links">
	<ul>
	<li><a href="index.php"> Home </a></li>
	<li><a href=""> Link </a><li>
	</ul>
	</div>
	
	<h1>What's in your 'fridge?</h1>
</div>

<div id="leftColumn">
	<div id="theForm">
	<form style="margin-left: 25px">
		<p>What ingredients would you like to cook with?</p>
		<input type="text" name="ingred" size="15px"/>
		<input type="text" name="ingred" size="15px"/>
		<input type="text" name="ingred" size="15px"/>
		<input type="text" name="ingred" size="15px"/>
		<div class="button"><input type="submit" value="Submit"/></div>
	</form>
	</div>
</div>

<div id="main">
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam pharetra ipsum eget purus condimentum viverra. Vestibulum rutrum tincidunt rhoncus. Donec ut massa quam. Aliquam eu metus vitae neque tempor mollis id a neque. Quisque sit amet ante eros. Cras tristique massa eu nisi feugiat dapibus. Cras sed velit neque, a egestas nunc. Quisque placerat libero quis dolor blandit sed tempus ante scelerisque. In hac habitasse platea dictumst. Ut vitae tellus lorem. Donec eget eros at nulla posuere bibendum. Pellentesque rhoncus mollis felis ac tempor. Quisque dictum mollis justo, ultrices vestibulum nisi congue in. Integer sagittis gravida sodales. In enim est, feugiat at euismod et, scelerisque nec erat. Cras scelerisque facilisis diam, eu pretium turpis scelerisque ac. Maecenas commodo pharetra risus, vitae commodo massa aliquam quis. Nullam cursus, lacus sit amet dictum tincidunt, diam dolor dignissim lorem, eu vehicula magna magna eget odio. Sed interdum congue vestibulum. Quisque sit amet risus nunc, eu ullamcorper nulla.</p>
</div>

<div id="login">
<?php
	if($_SESSION['user']=="confirmed"){ 
		include("openDB.php");
		$getName = $_SESSION['username'];
		
		$query = stripSlashes("SELECT firstName,lastName FROM User WHERE email='$getName'");
		$result=mysql_fetch_row(mysql_query($query));
		echo "Welcome ".$result[0]." ".$result[1]."!";
	}
?>
</div>

</body>
</html>
