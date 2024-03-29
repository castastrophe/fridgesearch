<?php
/*
 * Page: recipeView.php
 * Desc: Recipe search, view a single recipes
 * Author: Cas Gentry
 * Date Updated: 7 Oct 12
*/

	include("top.php");
	
	login_status();
	
	if(@$_GET['rating'] != null){
		//Recipe ID should be found in the url
		$recipeID 	= trim($_GET['recipeID']);
		$rate 		= trim($_GET['rating']);
		$userID 	= trim($_SESSION['username']);
		
		$query = "SELECT COUNT(*) FROM Ratings WHERE recipeID='$recipeID' AND userID='$userID'";
	  	$result= mysql_query($query);
	  	
	  	$checks = mysql_fetch_row($result);
	  		 
	  	// If this recipe has already been rated, replace it
	   	if($checks){
	   		$query  = "UPDATE Ratings SET recipeID='$recipeID', numStars='$rate', userID='$userID', recipeID='$recipeID' WHERE recipeID='$recipeID'";
		   	$result = mysql_query($query);
	   	}
	   	//Otherwise, add it
		else{
			$query  = "INSERT INTO Ratings VALUES('$recipeID', '$rate', '$userID')";
			$result = mysql_query($query);
		}
	}
?>

<html>

<?php include("head.html"); ?>

<body>

<script type="text/javascript">
	function mouseOver(num){
		for(var a=0; a < num; a++){
			var b = (a + 1);
			document.images['star'+b].src='rating_star_full.png';
		}
	}
	
	function mouseOut(value){
		for(var c=0; c < value; c++){
			var d = (c + 1);
			document.images['star'+d].src='rating_star_blank.png';
		}
	}
</script>

<div id="main">

	<div id="title">
		<h1>What's in your 'fridge?</h1>
		<h2>Recipe Details</h2>
	</div>
	
	<div id="displayRecipe">
		<?php
			//Recipe ID should be found in the url
			$recipeID = trim($_GET['recipeID']);
			
			//Pull recipe data from database
			$query = "SELECT title, image, userID, summary, serves, cookTime, steps FROM Recipe WHERE recipeID='".$recipeID."'";
			$result= mysql_query($query);
		?>
		
		<table style="padding: 0px">
		
		<?php
			$row = mysql_fetch_row($result);
			$author = $row[2];
			
			//Recipe Title
			echo "<tr><th colspan=\"4\" id=\"displayTitle\">".$row[0]."<BR>";
			
			//Pull author name from User db
			$query = stripSlashes("SELECT firstName, lastName FROM User WHERE email='$author'");
			$result= mysql_query($query);
			$name = mysql_fetch_row($result);
			
			echo "<div id=\"author\">By ".$name[0]." ".$name[1]."</th></tr>";
			
			//Display recipe image
			echo "<tr><td rowspan=\"3\"><img src=\"recipePics/".$row[1]."\" width=\"175\"/></td>";
			
			//How many ppl does it serve
			echo "<td class=\"topRow\">Serves: ".$row[4]."</td>";
			
			//Calculate and display how long it takes to cook this recipe
			echo "<td class=\"topRow\">Cook time: ";
			if($row[5] < 60){
				echo "".$row[5]." mins";
			}
			else{
				$hrs = $row[5]/60;
				$min = $row[5] - ($hrs*60);
				
				if($min == 0){
					echo $hrs." hrs";
				}
				else{
					echo $hrs." hrs ".$min." mins";
				}
			}
			echo "</td>";
			
			//Display recipe ratings
			echo "<td class=\"topRow\">";
			ratings($recipeID, $row[2]);
			echo "</td></tr>";
			
			echo "<tr><td colspan=\"3\" id=\"summary\">\"".$row[3]."\"</td></tr>";
			
			$query = stripSlashes("SELECT quantity, measurement, name FROM Ingredients WHERE recipeID=".$recipeID."");
			$result = mysql_query($query);
			
			//Display ingredients
			echo "<tr><td colspan=\"3\">";

			for($x=0; $x<mysql_num_rows($result); $x++){
				$ingredient = mysql_fetch_row($result);
				echo "<ul class=\"ingreds\"><li>";
				for($y=0; $y<mysql_num_fields($result); $y++ ){
					if($ingredient[$y] != "<item>"){
						echo " ".$ingredient[$y]." ";
					}
				}
				echo "</li></ul>";
			}

			echo "<td></tr>";
			echo "<tr><td colspan=\"4\" class=\"steps\">".$row[6]."</td></tr>";
		?>
		</table>
	</div>

	<?php include("userMenu.php"); ?>
</div>

<?php include("bottom.php"); ?>