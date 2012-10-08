<?php
/*
 * Page: cookbook.php
 * Desc: Recipe search, view your recipes
 * Author: Cas Gentry
 * Date Updated: 7 Oct 12
*/

	include("top.php");
	
	login_status();
?>
<html>

<?php include("head.html"); ?>

<body>
<div id="main">

	<div id="title">
		<h1>What's in your 'fridge?</h1>
		<h2>My Cookbook</h2>
	</div>
		<div id="homeLink"><a href="index.php"><img src="fridge.jpg" height="100px"/></a></div>
		
	<?php
		$usrID = $_SESSION['username'];
   		
   		$query = stripSlashes("SELECT recipeID FROM Recipe WHERE userID='$usrID'");
		$result=mysql_query($query);
	?>
		<div id="showRecipe">
			<table>
	<?php
		if($result){
			for($l=0; $l<mysql_num_rows($result); $l++){
			$level = mysql_fetch_row($result);
			for($m=0; $m<mysql_num_fields($result); $m=$m+2){
				$getRecipeInfo = mysql_query("SELECT title, image, summary FROM Recipe WHERE recipeID=$level[$m]");
		
				for($c=0; $c<mysql_num_rows($getRecipeInfo); $c++){
					$row=mysql_fetch_row($getRecipeInfo);
					echo"<table><tr>";
					echo "<td rowspan=\"2\"><img src=\"recipePics/".$row[1]."\" width=\"125\" id=\"viewImage\"/></td>";
					echo "<td><div id=\"viewTitle\"><h2><a href=\"http://lion.arvixe.com/~kosterb/gentryca/Project/recipeView.php?recipeID=".$level[$m]."\">".$row[0]."</a></h2></div> ";
					//ratings
					$getRating = mysql_query("SELECT numStars FROM Ratings WHERE recipeID=$level[$m]");
					$total = 0;
					for($d=0; $d<mysql_num_rows($getRating); $d++){
						$stars=mysql_fetch_row($getRating);
						for($e=0; $e<mysql_num_fields($result); $e++){
							$total = $total + $stars[$e];
						}
					}
					$average = $total/sizeof($stars);
				
					echo " <div id=\"viewRate\"> ";
					for($d=0; $d<4;$d++){
						if($d<$average){
							echo " <img src=\"rating_star_full.png\" id=\"rate\"/> ";
						}
						else{
							echo " <img src=\"rating_star_blank.png\" id=\"rate\"/> ";
						}
					}
				
					echo "</div></td></tr>";
					echo "<tr><td colspan=\"2\"><div id=\"shortDesc\">".$row[2]."</div><BR><BR></td>";
					echo "</tr></table>";
				}
			}
		}
			
		}
		else{
			echo "<tr><td>No recipes have yet been entered.</td></tr>";
		}
	?>
		</table>
	</div>

	<?php include("userMenu.php"); ?>
	
</div>

<?php include("bottom.php"); ?>