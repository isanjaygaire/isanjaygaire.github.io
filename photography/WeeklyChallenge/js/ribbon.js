var clicking = false,
	dragMe = jQuery('#dragMe'),
	demension = 0,
	statusBar = jQuery('#ribbon_status'),
	rList = jQuery('.ribbon_list'),
	maxSlide = rList.find('li').size(),
	status_max = jQuery('.rb_total_display'),
	status_cur = jQuery('.rb_current_display'),
	rb_indicator_left = jQuery('.rb_indicator_left'),
	rb_indicator_right = jQuery('.rb_indicator_right');

if (jQuery(window).width() > 760) {
	dragMe.bind('touchstart', function(event) {
		touch = event.targetTouches[0];
		startAt = touch .pageX;
		html.addClass('clicked');
	});
	dragMe.bind('touchmove', function(event) {
		touch = event.targetTouches[0];
		movePath = -1* (startAt - touch.pageX)/3;
		
		prevSlide2 = jQuery('.prevStep2');
		prevSlide = jQuery('.prevStep');
		curSlide = jQuery('.currentStep');
		nextSlide = jQuery('.nextStep');
		nextSlide2 = jQuery('.nextStep2');

		mainMove = ((myWindow.width() - curSlide.width() - 30) /2) + movePath;
		nextMove = (curSlide.width() + mainOffSet) + 30 + movePath;
		prevMove = (mainOffSet -30 - prevSlide.width()) + movePath;
		nextMove2 = (nextSlide.width() + nextOffset) + 30 + movePath;
		prevMove2 = (prevOffset - prevSlide2.width()) - 30 + movePath;

		jQuery('.prevStep2').css({'transform' : ' translateX('+ prevMove2 +'px)'});
		jQuery('.prevStep').css({'transform' : ' translateX('+ prevMove +'px)'});
		jQuery('.currentStep').css({'transform' : ' translateX('+ mainMove +'px)'});
		jQuery('.nextStep').css({'transform' : ' translateX('+ nextMove +'px)'});
		jQuery('.nextStep2').css({'transform' : ' translateX('+ nextMove2 +'px)'});
	});
	dragMe.bind('touchend', function(event) {
		touch = event.changedTouches[0];			

		html.removeClass('clicked');
		if (touch.pageX < startAt) {
			next_slide();
		}
		if (touch.pageX > startAt) {
			prev_slide();
		}
	});
	}
	
jQuery(document).ready(function($){
	status_max.html(maxSlide);
	jQuery('.custom_bg').remove();
	jQuery('.ribbon_list').on("swipeleft",function(){
		next_slide();
	});
	jQuery('.ribbon_list').on("swiperight",function(){
		prev_slide();
	});			
	jQuery('.rbPrev').on('click', function(){
		prev_slide();
	});
	jQuery('.rbPrev').on({
		mouseenter: function () {
			rb_indicator_left.addClass('indicator_hovered');
		},
		mouseleave: function () {
			rb_indicator_left.removeClass('indicator_hovered');
		}
	});
		
	jQuery('.rbNext').on('click', function(){
		next_slide();
	});
	jQuery('.rbNext').on({
		mouseenter: function () {
			rb_indicator_right.addClass('indicator_hovered');
		},
		mouseleave: function () {
			rb_indicator_right.removeClass('indicator_hovered');
		}
	});

	jQuery(document.documentElement).keyup(function (event) {
		if ((event.keyCode == 37) || (event.keyCode == 40)) {
			prev_slide();
		} else if ((event.keyCode == 39) || (event.keyCode == 38)) {
			next_slide();
		}
	});

	jQuery('.slide1').addClass('currentStep');
	ribbon_setup();
	
});	
jQuery(window).resize(function($){
	updateSlide();
	setTimeout("updateSlide()",500);
});	
jQuery(window).load(function($){
	setSlide(1);
});	

function ribbon_setup() {
	if (window_w > 760) {
		if (jQuery('#wpadminbar').size() > 0) {
			setHeight = myWindow.height() - header.height() - jQuery('#wpadminbar').height() - footer.height();
			setTop = header.height() + jQuery('#wpadminbar').height();
		} else {
			setHeight = myWindow.height() - header.height() - footer.height();
			setTop = header.height();			
		}
		rList.height(setHeight).css('top', setTop + 'px');
		rList.find('li').height(setHeight);				
		jQuery('.num_current').text('1');
		
		jQuery('.num_all').text(rList.size());								
		jQuery('.slider_caption').text(jQuery('.currentStep').attr('data-title'));
		rList.find('li').each(function(){
			if (jQuery(this).find('iframe').size() > 0) {
				jQuery(this).find('iframe').height(jQuery(this).height()).width((jQuery(this).height()/9)*16);
				jQuery(this).width(jQuery(this).find('iframe').width());
			} else {
				jQuery(this).width(jQuery(this).find('img').width());
			}
			jQuery(this).attr('data-offset',jQuery(this).offset().left);
			jQuery(this).attr('data-width',jQuery(this).width());
		});				
	}
}

function setSlide(slideNum) {
	status_cur.html(slideNum);
	jQuery('.prevStep2').removeClass('prevStep2');
	jQuery('.prevStep').removeClass('prevStep');
	jQuery('.currentStep').removeClass('currentStep');
	jQuery('.nextStep').removeClass('nextStep');
	jQuery('.nextStep2').removeClass('nextStep2');
	
	curSlide = jQuery('.slide'+slideNum);
	curSlide.addClass('currentStep');
	
	if((parseInt(slideNum)+1) > maxSlide) {
		nextSlide = jQuery('.slide1');
		nextSlide2 = jQuery('.slide2');
	} else if ((parseInt(slideNum)+1) == maxSlide){
		nextSlide = jQuery('.slide'+maxSlide);
		nextSlide2 = jQuery('.slide1');
	} else {
		nextSlide = jQuery('.slide'+(parseInt(slideNum)+1));
		nextSlide2 = jQuery('.slide'+(parseInt(slideNum)+2));
	}
	
	if((parseInt(slideNum)-1) < 1) {
		prevSlide = jQuery('.slide'+maxSlide);
		prevSlide2 = jQuery('.slide'+(maxSlide-1));
	} else if ((slideNum-1) == 1){
		prevSlide = jQuery('.slide1');
		prevSlide2 = jQuery('.slide'+maxSlide);
	} else {
		prevSlide = jQuery('.slide'+(parseInt(slideNum)-1));
		prevSlide2 = jQuery('.slide'+(parseInt(slideNum)-2));
	}

	prevSlide2.addClass('prevStep2');
	prevSlide.addClass('prevStep');
	curSlide.addClass('currentStep');
	nextSlide.addClass('nextStep');
	nextSlide2.addClass('nextStep2');
	
	mainOffSet = (window_w - curSlide.width()) /2;
	nextOffset = curSlide.width() + 30 + mainOffSet;
	prevOffset = mainOffSet - 30 - prevSlide.width();
	nextOffset2 = nextSlide.width() + 30 + nextOffset;
	prevOffset2 = prevOffset - 30 - prevSlide2.width();
	
	curSlide.css('transform' , 'translateX('+mainOffSet+'px)'); 
	nextSlide.css('transform' , 'translateX('+nextOffset+'px)');
	nextSlide2.css('transform' , 'translateX('+nextOffset2+'px)');
	prevSlide.css('transform' , 'translateX('+prevOffset+'px)');
	prevSlide2.css('transform' , 'translateX('+prevOffset2+'px)');
}

function updateSlide() {
	if (window_w > 760) {
		if (jQuery('#wpadminbar').size() > 0) {
			setHeight = myWindow.height() - header.height() - jQuery('#wpadminbar').height() - footer.height();
			setTop = header.height() + jQuery('#wpadminbar').height();
		} else {
			setHeight = myWindow.height() - header.height() - footer.height();
			setTop = header.height();		
		}
		rList.height(setHeight).css('top', setTop + 'px');
		rList.find('li').height(setHeight);
		
		jQuery('.slider_caption').text(jQuery('.currentStep').attr('data-title'));
		rList.find('li').each(function(){
			if (jQuery(this).find('iframe').size() > 0) {
				jQuery(this).find('iframe').height(jQuery(this).height()).width((jQuery(this).height()/9)*16);
				jQuery(this).width(jQuery(this).find('iframe').width());
			} else {
				jQuery(this).width(jQuery(this).find('img').width());
			}
			jQuery(this).attr('data-offset',jQuery(this).offset().left);
			jQuery(this).attr('data-width',jQuery(this).width());
		});				
	}
	
	prevSlide2 = jQuery('.prevStep2');
	prevSlide = jQuery('.prevStep');
	curSlide = jQuery('.currentStep');
	nextSlide = jQuery('.nextStep');
	nextSlide2 = jQuery('.nextStep2');

	mainOffSet = (myWindow.width() - curSlide.width()) /2;
	nextOffset = curSlide.width() + 30 + mainOffSet;
	prevOffset = mainOffSet - 30 - prevSlide.width();
	nextOffset2 = nextSlide.width() + 30 + nextOffset;
	prevOffset2 = prevOffset - 30 - prevSlide2.width();
		
	jQuery('.slide_title').text(curSlide.attr('data-title'));
	curSlide.css({'transform' : 'translateX('+mainOffSet+'px)'}); 
	nextSlide.css({'transform' : 'translateX('+nextOffset+'px)'});
	nextSlide2.css({'transform' : 'translateX('+nextOffset2+'px)'});
	prevSlide.css({'transform' : 'translateX('+prevOffset+'px)'});
	prevSlide2.css({'transform' : 'translateX('+prevOffset2+'px)'});
}

function prev_slide() {
	curSlide = parseInt(jQuery('.currentStep').attr('data-count'));
	if (curSlide - 1 < 1) {
		curSlide = maxSlide;
	} else {
		curSlide = curSlide - 1;
	}
	setSlide(curSlide);
}
function next_slide() {
	curSlide = parseInt(jQuery('.currentStep').attr('data-count'));
	if (curSlide + 1 > maxSlide) {
		curSlide = 1;
	} else {
		curSlide = curSlide + 1;
	}
	setSlide(curSlide);
}
