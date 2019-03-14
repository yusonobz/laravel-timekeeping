$(document).ready(function(){
	
	var isHidden = true;
	var menu = $('header .header-nav');
	/***************** Nav toggle ******************/
	$('#toggleButton').on('click',function() {	
		 if(isHidden){
			$(menu).css({'visibility':'visible', 'opacity' : '1'}).addClass('animated fadeIn');
			isHidden = false;
		 } else {
	
			$(menu).css({'visibility':'hidden', 'opacity' : '0'}).removeClass('animated fadeOut');	
			isHidden = true;
		 }	 
	});

	$(window).resize(function() {
		 var width = $(window).width();
		 
		 if(width > 990){
			 $(menu).css({'visibility':'visible', 'opacity' : '1'});
		 }
	});
	
});