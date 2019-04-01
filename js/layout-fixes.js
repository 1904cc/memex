/**
 * Layout fixes.js.
 *
 * Some tricks to improve the layout.
 */

document.addEventListener('DOMContentLoaded', function() {
	 
	 /*
	  Make Fixed Post Header
	  Test if header is small enough to be entirely visible.
		Test if HeaderHeight is smaller than WindowHeight minus MenuHeight:
		If yes, make it's position fixed.
	 */
	 
	 var windowHeight = window.innerHeight;
	 
	 var entryHeader = document.querySelector(".entry-header");
	 var entryHeaderW = entryHeader.clientWidth;
	 
	 var entryFooter = document.querySelector(".entry-footer");
	 var navHeight = document.getElementById('site-navigation');
	 
	 if ( ( windowHeight - navHeight.clientHeight ) > ( entryHeader.clientHeight + entryFooter.clientHeight  ) )  {
	 		 	
	 	var entryFooterTop = entryHeader.clientHeight;
	 	
	 	entryHeader.style.position = "fixed";
	 	entryHeader.style.top = "0px";
	 	entryHeader.style.width = entryHeaderW+"px";
	 	
	 	entryFooter.style.position = "fixed";
	 	entryFooter.style.top = entryFooterTop+"px";
	 	entryFooter.style.width = entryHeaderW+"px";
	 	
	 }
	 
});