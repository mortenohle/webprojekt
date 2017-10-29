// Slider Startseite

$(window).ready(function() {
	
	var images = $('.slide-image');
	
	$(document).on('click', '.slide-image', function() {
		if(!$(this).hasClass('active')) {
			slide_nav($(this));
		}
	});
	
	$(images).first().addClass('active');
	$(images).first().addClass('slide-active');
	$(images).last().addClass('slide-previous');
	$(images[1]).addClass('slide-next');
	
	
	// Slider Navigation
	function slide_nav(OBJEKT) {
		
		var active = $('.active');
		
		$('.slide-previous').removeClass('slide-previous');
		$('.slide-next').removeClass('slide-next');
		
		active.removeClass('active');
		$(OBJEKT).addClass('active');
		active.removeClass('slide-active');
		$(OBJEKT).addClass('slide-active');
		
		if($(OBJEKT).prev().hasClass('slide-image')) {
			$(OBJEKT).prev().addClass('slide-previous');
		} else {
			$('.slide-image').last().addClass('slide-previous');
		}
		
		if($(OBJEKT).next().hasClass('slide-image')) {
			$(OBJEKT).next().addClass('slide-next');
		} else {
			$('.slide-image').first().addClass('slide-next');
		}
		
	}
	
	//Slider automatischer Wechsel
	slide_auto();
	
	function slide_auto() {
		
		var slide_time = 7000;
		
		
		if($('.active').next().hasClass('slide-image')) {
			var active_next = $('.active').next();
		} else {
			var active_next = $('.slide-image').first();
		}
		
		var active = $('.active');
		
		$('.slide-previous').removeClass('slide-previous');
		$('.slide-next').removeClass('slide-next');
		
		active.removeClass('active');
		$(active_next).addClass('active');
		active.removeClass('slide-active');
		$(active_next).addClass('slide-active');
		
		if($(active_next).prev().hasClass('slide-image')) {
			$(active_next).prev().addClass('slide-previous');
		} else {
			$('.slide-image').last().addClass('slide-previous');
		}
		
		if($(active_next).next().hasClass('slide-image')) {
			$(active_next).next().addClass('slide-next');
		} else {
			$('.slide-image').first().addClass('slide-next');
		}
		
		
		setTimeout(function() {
			slide_auto();
		}, slide_time);
	}
	
});