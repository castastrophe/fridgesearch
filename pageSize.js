
function adjustSize() {
	var screenWidth = screen.width;
	
	var sideSpecs = ((screenWidth - (screenWidth * .75))/2);
	var smallScreen = screenWidth - (sideSpecs*2);
	var smallSides = (smallScreen - (smallScreen * .95))/2;
	
	document.getElementById('main').style.left = sideSpecs  + 'px';
	document.getElementById('main').style.right = sideSpecs  + 'px';
	
	document.getElementById('lowerLinks').style.left = sideSpecs  + 'px';
	document.getElementById('lowerLinks').style.width = (smallScreen - 20)  + 'px';
	
	document.getElementById('whyJoin').style.left = smallSides + 'px';
	document.getElementById('regForm').style.right = smallSides + 'px';	
	
	document.getElementById('whyJoin').style.width = (smallScreen - (smallSides*4))/2 + 'px';
	document.getElementById('regForm').style.width = (smallScreen - (smallSides*4))/2 + 'px';
}