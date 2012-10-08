<?php

function ratings(){
	//if the user has not yet rated this recipe
	$query = stripSlashes("SELECT COUNT(numStars) FROM Ratings WHERE recipeID='".$recipeID."' AND userID='".$row[2]."'");
	$result = mysql_query($query);
	$rateQuery = mysql_fetch_row($result);
			
	//For recipes you have not yet rated
	if($rateQuery[0] == 0){			
		for($r=0; $r<4; $r++){
			$s = ($r+1);
			echo "<a href=\"recipeView.php?recipeID=".$recipeID."&rating=".$s."\"";
			echo " onMouseOver=\"mouseOver(".$s.")\"";
			echo " onMouseOut=\"mouseOut(".$s.")\">";
			echo "<img src=\"rating_star_blank.png\" name=\"star".$s."\" id=\"rate\"/></a>";
		}		
	}
	//For recipes you have already rated
	else{
		$query = stripSlashes("SELECT numStars FROM Ratings WHERE recipeID='".$recipeID."' AND userID='".$row[2]."'");
		$result = mysql_query($query);
		$rating = mysql_fetch_row($result);
		
		for($r=0; $r<4; $r++){
			$s = ($r+1);
			echo "<a href=\"recipeView.php?recipeID=".$recipeID."&rating=".$s."\"";
			echo " onMouseOver=\"mouseOver(".$s.")\"";
			echo " onMouseOut=\"mouseOut(".$s.")\">";
			echo "<img src=\"";
			if($r < $rating[0]){
				echo "rating_star_full.png";
			}
			else{
				echo "rating_star_blank.png";
			}
			echo "\" name=\"star".$s."\" id=\"rate\"/></a> ";
		}		
	}
}
?>