<?php
/*
 * Page: index.php
 * Desc: Home page for recipe search
 * Author: Cas Gentry
 * Date Updated: 7 Oct 12
*/

	include("top.php");
	
	// start a new session
	session_start();
?>

<html>

<?php include("head.html"); ?>

<body>
<div id="main">
	<?php
		include("loginmenu.php");
	?>

	<div id="title">
		<h1>What's in your 'fridge?</h1>
	</div>

	<div id="content">
		<div id="fridge">
			<div id="searchForm">
			<!-- <form style="margin-left: 25px" action="searchResults.php" method="POST"> -->
			<form style="margin-left: 25px" action="" method="POST">
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

<?php include("bottom.php"); ?>