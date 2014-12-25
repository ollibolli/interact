$(document).ready(function(){

	var menuLinks = $('#menu ul li a');
	for (var i=0 ;menuLinks.length > i; i++){
		link = menuLinks[i];
		if (window.location.pathname == link.pathname){
			$(link).parent().addClass('active');
		} 
	}
});