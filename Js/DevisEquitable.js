$(function(){
	
	$('.slider').mobilyslider({
		content: '.sliderContent',
		children: 'div',
		transition: 'fade',
		animationSpeed: 1000,
		autoplay: true,
		autoplaySpeed: 5000,
		pauseOnHover: false,
		bullets: true,
		arrows: true,
		arrowsHide: true,
		prev: 'prev',
		next: 'next',
		animationStart: function(){},
		animationComplete: function(){}
	});
	
});
