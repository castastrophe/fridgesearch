<?php
/*
 * Page: searchResults.php
 * Desc: Recipe search, view search
 * Author: Cas Gentry
 * Date Updated: 7 Oct 12
*/

	include("top.php");
	
	login_status();
  	
  	$ingredients = trim($_POST['ingreds']);
  	$userPick = array();

	//Build an array to hold the search terms userPick
	function mergeArray($value){
		global $userPick;
		if ($value != null){
			$userPick[] = $value;
		}
	}

	//runs the function mergeArray() on every element of $ingredients
	if($ingredients){
		array_walk($ingredients, "mergeArray");
	} 
?>
<html>

<?php include("head.html")?>

<body>
<div id="main">
	<?php
		if(@$_SESSION['login'] == "true"){
			include("userMenu.php");
		}
	?>
	
	<div id="title"><h1>What's in your 'fridge?</h1></div>
	<div id="content">
	<table>
		<tr>
			<td>
	<?php
		if(empty($ingredients)){
			echo "<p>No search terms were entered.</p>";
		}
		else{
			echo "<p>Recipes which include ";
			if(sizeof($userPick)>1){
				for($a=0; $a<(sizeof($userPick)-1); $a++){
					echo $userPick[$a].", ";
				}
				echo "and/or ".$userPick[$a].".";
			}
			else{
				echo $userPick[0].".";
			}
		
			echo "</p>";
		}
	?>
			</td>
		</tr>
	
	<?php
		//don't query the database if no search terms were entered
		if(!empty($ingredients)){
			echo "\t\t<tr>\n\t\t\t<td>";
			
			//search database for items in userPick array and assign values for best match
			$query = "SELECT DISTINCT recipeID, COUNT(*) AS counter FROM Ingredients WHERE ";
			
			for($x=0; $x<(sizeof($userPick)-1); $x++){
				$query=$query."LOWER(name) LIKE LOWER('%".$userPick[$x]."%') OR ";
			}
			
			$query=$query."LOWER(name) LIKE LOWER('%".$userPick[$x]."%')";
			$query=$query."GROUP BY recipeID ORDER BY counter DESC";
			$query=stripSlashes($query);

			$bestMatch= mysql_query($query);
			
			//print out the best matches
			for($l=0; $l < mysql_num_rows($bestMatch); $l++){
				$level = mysql_fetch_row($bestMatch);
				for($m=0; $m < mysql_num_fields($bestMatch); $m=$m+2){
					$getRecipeInfo = mysql_query("SELECT title, image, summary FROM Recipe WHERE recipeID=$level[$m]");
			
					for($c=0; $c<mysql_num_rows($getRecipeInfo); $c++){
						$row=mysql_fetch_row($getRecipeInfo);
						echo"<table><tr>";
						echo "<td rowspan=\"2\"><img src=\"images/recipePics/".$row[1]."\" width=\"125\" id=\"viewImage\"/></td>";
						echo "<td><div id=\"viewTitle\"><h2><a href=\"casgentry.com/recipe/recipeView.php?recipeID=".$level[$m]."\">".$row[0]."</a></h2></div> ";
						
						//ratings
						$getRating = mysql_query("SELECT numStars FROM Ratings WHERE recipeID=$level[$m]");
						$total = 0;
						for($d=0; $d<mysql_num_rows($getRating); $d++){
							$stars=mysql_fetch_row($getRating);
							for($e=0; $e<mysql_num_fields($bestMatch); $e++){
								$total = $total + $stars[$e];
							}
						}
						
						$average = $total/sizeof($stars);
					
						echo " <div id=\"viewRate\"> ";
						for($d=0; $d<4;$d++){
							if($d<$average){
								echo " <img src=\"images/rating_star_full.png\" id=\"rate\"/> ";
							}
							else{
								echo " <img src=\"images/rating_star_blank.png\" id=\"rate\"/> ";
							}
						}
					
						echo "</div>";
						echo "</td></tr>";
						echo "<tr><td colspan=\"2\"><div id=\"shortDesc\">".$row[2]."</div><BR><BR></td>";
						echo "</tr></table>";
					}
				}
			}
					
			echo "</td></tr>";
		}
	?>
		</table>
	</div>
</div>

<?php include("bottom.php"); ?>