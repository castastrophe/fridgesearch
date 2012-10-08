<?php
	session_start();
	if($_SESSION['login']!="yes"){
		header("Location: index.php");
	}

	if(@$_GET['upload']=="yes") {
   		include("openDB.php");

		$title 	= $_POST[recipeTitle];
		$blurb = $_POST[blurb];		
	   	$serve	= $_POST[serveSize];
	   	$time	= $_POST[cookTime];
	   	$steps = $_POST[cookSteps];
		
		$usrID = $_SESSION['username'];
   		
   		$query = stripSlashes("SELECT MAX(recipeID) FROM Recipe");
		$result=mysql_query($query);
		$row = mysql_fetch_row($result);
		
		if(mysql_num_rows($result) != null){
			$row[0]++;
			$recID = $row[0];
		}
		else{
			$recID = 1;
		}
		
		
		$img = $_FILES[picField][name];
		$img = $recID.".jpg";
		
   		$query = "INSERT INTO Recipe VALUES('".$recID."', '".$title."', '".$img."', '".$usrID."', '".$serve."', '".$time."', '".$steps."', '".$blurb."')";
	   	$result = mysql_query( $query );
	   
	   	move_uploaded_file($_FILES[picField][tmp_name],"recipePics/".$img);
	
		$qty = $_POST['quantity'];
		$measurement = $_POST['measure'];
		$ingred = $_POST['ingredient'];
		for($a=0; $a<sizeof($ingred); $a++){
			if($ingred[$a] != null){
				$query = "INSERT INTO Ingredients VALUES('".$recID."', '".$qty[$a]."', '".$measurement[$a]."', '".$ingred[$a]."')";
				$result = mysql_query($query);
			}
		}
		
	   	header("Location: cookbook.php");
	}
?>

<html>
<head>
<script language="JavaScript" type="text/javascript" src="richtext.js"></script>

<script type="text/javascript">
// width to resize large images to
var maxWidth=250;
  // height to resize large images to
var maxHeight=250;
  // valid file types
var fileTypes=["bmp","gif","png","jpg","jpeg"];
  // the id of the preview image tag
var outImage="previewField";
  // what to display when the image is not valid
var defaultPic="recipe.jpg";

function preview(what){
  var source=what.value;
  var ext=source.substring(source.lastIndexOf(".")+1,source.length).toLowerCase();
  for (var i=0; i<fileTypes.length; i++) if (fileTypes[i]==ext) break;
  globalPic=new Image();
  if (i<fileTypes.length) globalPic.src=source;
  else {
    globalPic.src=defaultPic;
    alert("THAT IS NOT A VALID IMAGE\nPlease load an image with an extention of one of the following:\n\n"+fileTypes.join(", "));
  }
  setTimeout("applyChanges()",200);
}
var globalPic;
function applyChanges(){
  var field=document.getElementById(outImage);
  var x=parseInt(globalPic.width);
  var y=parseInt(globalPic.height);
  if (x>maxWidth) {
    y*=maxWidth/x;
    x=maxWidth;
  }
  if (y>maxHeight) {
    x*=maxHeight/y;
    y=maxHeight;
  }
  field.style.display=(x<1 || y<1)?"none":"";
  field.src=globalPic.src;
  field.width=x;
  field.height=y;
}
</script>

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
		<h2>Add Your Own Recipe*</h2>
	</div>
	<div id="homeLink"><a href="index.php"><img src="fridge.jpg" height="100px"/></a></div>
	<div id="addRecipe">
		<table id="addRecipeForm" width="100%"><form enctype="multipart/form-data" action="addrecipes.php?upload=yes" method="POST" onsubmit="return submitForm();">
		<script language="JavaScript" type="text/javascript">
		
			function submitForm() {
				//make sure hidden and iframe values are in sync for all rtes before submitting form
				updateRTEs();
				
				//change the following line to true to submit form
				alert("rte1 = " + htmlDecode(document.RTEDemo.rte1.value));
				return false;
			}

			//Usage: initRTE(imagesPath, includesPath, cssFile)
			initRTE("images/", "", "");
		</script>
			<tr><td class="leftRecipe" width="10%">Title:</td>
				<td width="40%"><input type="text" name="recipeTitle" style="width: 100%"/></td>
			
				<td rowspan="10" width="50%" align="center"><img id="previewField" src="recipe.jpg" height="250px">
					<BR><p id="picFont"><span class="special">*</span>All recipes added must be the sole property of the user entering them.  Please do not
					submit copyrighted recipes as your own.</p>
				</td>
			
			</tr>
				
			<tr><td class="leftRecipe">Short Description:</td>
				<td><textarea name="blurb" rows="7" style="width: 100%"/></textarea></td></tr>
			
			<tr><td class="leftRecipe">Image:</td>
				<td><input type="file" name="picField" onchange="preview(this)" style="width: 100%"></td></tr>
			
			<tr><td class="leftRecipe">Serves:</td>
				<td><input type="text" name="serveSize" style="width: 25%"/><span id="measurement">people</span></td></tr>
			
			<tr><td class="leftRecipe">Cook time:</td>
				<td><input type="text" name="cookTime" style="width: 25%"/><span id="measurement">min</span></td></tr>
			
			<tr><td class="leftRecipe">Ingredients:</td>
				<td>
					<?php
						include("openDB.php");
						
						$ingredAmt = 5;
						
						for($a=0; $a<$ingredAmt; $a++){
							echo "<input type=\"text\" name=\"quantity[]\" style=\"width: 10%\" class=\"qty\"/>";
						
							$query = stripSlashes("SELECT DISTINCT value FROM Measurements");
							$result= mysql_query($query);
							
							echo "<select name=\"measure[]\">"; 
							echo "<option> </option>";
							for($i=0; $i<mysql_num_rows($result); $i++){
								$row=mysql_fetch_row($result);
								for( $j=0; $j<mysql_num_fields($result); $j++ ){
									echo "<option>".$row[$j]."</option>";
								}
							}
							echo "</select>";
							echo "<input type=\"text\" name=\"ingredient[]\" style=\"width: 40%\" class=\"ingred\"/>";
							echo "<BR>";
						}
						
						echo "<BR>";
						echo "<input type=\"button\" style=\"width: 75px;\" value=\"Add More\" onClick=\"history.go(0)\"/>";
					?>
					<BR><BR>
				</td></tr>
				
			
			<tr><td class="leftRecipe">Directions:</td>
				<td colspan="2">
				<script language="JavaScript" type="text/javascript">
					//Usage: writeRichText(fieldname, html, width, height, buttons, readOnly)
					writeRichText('cookSteps', '<ol><li></li></ol>', 400, 200, true, false);
				</script>
				
				<!--<textarea name="cookSteps" rows="14" style="width: 140%"/>1. </textarea></td></tr>-->
			
			<tr><td colspan="2" align="right"><input type="submit" style="width: 100px"/><BR><BR><BR></td></tr>
		</form></table>
	</div>

</div>

<?php include("lowerLinks.php"); ?>
</body>
</html>