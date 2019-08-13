$(document).ready(function(){

var image1 = new Image()
image1.src = "images/1.jpg"
var image2 = new Image()
image2.src = "images/2.jpg"

var step=1;
function slideit()
 {
	 document.images.slide.src = eval("image"+step+".src");
	 if(step<2){
	 	step++;
	 }
	else{
		step=1;
		setTimeout("slideit()",2500);
	}
};
	 slideit();

});