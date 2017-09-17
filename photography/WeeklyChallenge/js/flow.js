var scale = 0.48,
	bg_slider = jQuery('.bg_slider'),
	flow_albums = jQuery('.flow_albums'),
	maxSlide = flow_albums.find('.flow_item').size(),
	filter = jQuery('.flow_filter_wrapper'),
	maxSlideAjax;

jQuery(document).ready(function($){
	jQuery('.flow_albums').on("swipeleft",function(){
		next_slide();
	});
	jQuery('.flow_albums').on("swiperight",function(){
		prev_slide();
	});			
	jQuery('.flow_prev').on('click', function(){
		prev_slide();
	});
	jQuery('.flow_next').on('click', function(){
		next_slide();
	});

	jQuery(document.documentElement).keyup(function (event) {		
		if ((event.keyCode == 37) || (event.keyCode == 40)) {
			if (ajax_slider.hasClass('show_slider')) {
				prev_ajax_slide();
			} else {
				prev_slide();
			}
		} else if ((event.keyCode == 39) || (event.keyCode == 38)) {
			if (ajax_slider.hasClass('show_slider')) {
				next_ajax_slide();
			} else {
				next_slide();
			}
		}
	});	
	setSlide(1);
});	

jQuery(window).resize(function($){
	curSlide = parseInt(jQuery('.currentStep').attr('data-count'));
	setSlide(curSlide);
});	

jQuery(window).load(function($){
	setSlide(1);
});	

function setSlide(slideNum) {
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
	prvSlide = prevSlide.attr('data-count');
	nxtSlide = nextSlide.attr('data-count');
	
	jQuery('.prevBgSlide').removeClass('prevBgSlide');
	jQuery('.currentBgSlide').removeClass('currentBgSlide');
	jQuery('.nextBgSlide').removeClass('nextBgSlide');

	bg_slider.find('.bg_slide'+prvSlide).addClass('prevBgSlide').attr('style', 'background-image:url(' + bg_slider.find('.bg_slide'+prvSlide).attr('data-bg') + ');');
	bg_slider.find('.bg_slide'+slideNum).addClass('currentBgSlide').attr('style', 'background-image:url(' + bg_slider.find('.bg_slide'+slideNum).attr('data-bg') + ');');
	bg_slider.find('.bg_slide'+nxtSlide).addClass('nextBgSlide').attr('style', 'background-image:url(' + bg_slider.find('.bg_slide'+nxtSlide).attr('data-bg') + ');');
	
	if (window_w > 760) {
		if (jQuery('#wpadminbar').size() > 0) {
			setHeight = myWindow.height() - header.height() - jQuery('#wpadminbar').height() - footer.height();
			setTop = header.height() + jQuery('#wpadminbar').height();
		} else {
			setHeight = myWindow.height() - header.height() - footer.height();
			setTop = header.height();
		}
		setTop2 = parseInt(flow_albums.css('padding-top'));
		if (filter.size() > 0) {
			setHeightItem = setHeight - filter.height() - parseInt(flow_albums.css('padding-top')) - parseInt(flow_albums.css('padding-bottom'));
		} else {
			setHeightItem = setHeight - parseInt(flow_albums.css('padding-top')) - parseInt(flow_albums.css('padding-bottom'));
		}
		
		flow_albums.height(setHeight);
		flow_albums.css('top', setTop+'px');
		flow_albums.find('.flow_item').height(setHeightItem);		
		flow_albums.find('.flow_item').each(function(){
			jQuery(this).height(setHeightItem).css('top', setTop2+'px');
			jQuery(this).width(jQuery(this).find('img').width());
		});
	}
	
	curSlide.css({'margin-left' : -1*curSlide.width()/2 +'px', 'transform' : 'scale(1,1)'}); 
	prevSlide.css({'margin-left' : -1*prevSlide.width()/2 +'px', 'transform' : 'scale('+ scale +','+ scale +')'});
	prevSlide2.css({'margin-left' : -1*prevSlide2.width()/2 +'px', 'transform' : 'scale('+ scale/2 +','+ scale/2 +')'});
	nextSlide.css({'margin-left' : -1*nextSlide.width()/2 +'px', 'transform' : 'scale('+ scale +','+ scale +')'});
	nextSlide2.css({'margin-left' : -1*nextSlide2.width()/2 +'px', 'transform' : 'scale('+ scale/2 +','+ scale/2 +')'});	
}

function prev_slide() {	
	curSlide = parseInt(jQuery('.currentStep').attr('data-count'));
	if (curSlide - 1 < 1) {
		curSlide = maxSlide;
	} else {
		curSlide = curSlide - 1;
	}
	bg_slider.find('.bg_slide'+jQuery('.nextStep').attr('data-count')).attr('style', '');	
	setSlide(curSlide);
}
function next_slide() {
	curSlide = parseInt(jQuery('.currentStep').attr('data-count'));
	if (curSlide + 1 > maxSlide) {
		curSlide = 1;
	} else {
		curSlide = curSlide + 1;
	}
	bg_slider.find('.bg_slide'+jQuery('.prevStep').attr('data-count')).attr('style', '');
	setSlide(curSlide);
}

function gt3_get_gallery(current_id) {
	jQuery.post(gt3_ajaxurl, {
		action: "get_gallery_works",
		current_id: current_id
	})
	.done(function (data) {
		ajax_slider.empty();
		ajax_slider.append(data);

		if (jQuery('.empty').size() < 1) {
			show_ajax_slider();
			set_ajax_slide(1);
		}
	});
}

function show_ajax_slider() {
	ajax_slider.addClass('show_slider');
	if (ajax_slider.find('li').size() > 1) {
		ajaxControls.addClass('show_slider');
	} else {
		ajaxControls.addClass('show_slider');
		ajaxControls.addClass('show_slider_close');
	}
}
function hide_ajax_slider() {
	ajax_slider.removeClass('show_slider');
	ajaxControls.removeClass('show_slider');
	ajaxControls.removeClass('show_slider_close');
	setTimeout("ajax_slider.empty()",600);			
}
function prev_ajax_slide() {
	as_curSlide = parseInt(jQuery('.as_current').attr('data-count'));
	as_max_slide = ajax_slider.find('li').size();
	if (as_curSlide - 1 < 1) {
		as_curSlide = as_max_slide;
	} else {
		as_curSlide = as_curSlide - 1;
	}
	jQuery('.as_prev').empty();
	jQuery('.as_next').attr('style', '').empty();
	set_ajax_slide(as_curSlide);
}
function next_ajax_slide() {
	as_curSlide = parseInt(jQuery('.as_current').attr('data-count'));			
	as_max_slide = ajax_slider.find('li').size();			
	if (as_curSlide + 1 > as_max_slide) {
		as_curSlide = 1;
	} else {
		as_curSlide = as_curSlide + 1;
	}
	jQuery('.as_next').empty();
	jQuery('.as_prev').attr('style', '').empty();
	set_ajax_slide(as_curSlide);
}
function setup_ajax_slider() {
	if (jQuery('#wpadminbar').size() > 0) {
		as_setHeight = myWindow.height() - header.height() - jQuery('#wpadminbar').height() - footer.height();
		as_setTop = header.height() + jQuery('#wpadminbar').height();
	} else {
		as_setHeight = myWindow.height() - header.height() - footer.height();
		as_setTop = header.height();	
	}
	ajax_slider.height(as_setHeight).css('top', as_setTop+'px');
}
function set_ajax_slide(asSlideNum) {
	jQuery('.as_prev').removeClass('as_prev');
	jQuery('.as_current').removeClass('as_current');
	jQuery('.as_next').removeClass('as_next');
	
	curSlide = jQuery('.as_slide'+asSlideNum);
	curSlide.addClass('as_current');
		
	if((parseInt(asSlideNum)+1) > maxSlide) {
		nextSlide = jQuery('.as_slide1');
	} else if ((parseInt(asSlideNum)+1) == maxSlide){
		nextSlide = jQuery('.as_slide'+maxSlide);
	} else {
		nextSlide = jQuery('.as_slide'+(parseInt(asSlideNum)+1));
	}
	
	if((parseInt(asSlideNum)-1) < 1) {
		prevSlide = jQuery('.as_slide'+maxSlide);
	} else if ((asSlideNum-1) == 1){
		prevSlide = jQuery('.as_slide1');
	} else {
		prevSlide = jQuery('.as_slide'+(parseInt(asSlideNum)-1));
	}

	prevSlide.addClass('as_prev');
	curSlide.addClass('as_current');
	nextSlide.addClass('as_next');
	prvSlide = prevSlide.attr('data-count');
	nxtSlide = nextSlide.attr('data-count');
	
	if (prevSlide.attr('data-type') == 'image') {
		prevSlide.attr('style', 'background-image:url(' + prevSlide.attr('data-src') + ');');
	}

	if (curSlide.attr('data-type') == 'vimeo') {
		curSlide.append('<iframe class="as_iframe" src="http://player.vimeo.com/video/' + curSlide.attr('data-src') + '?autoplay=0&loop=0&api=1" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>');
	} else if (curSlide.attr('data-type') == 'youtube') {
		curSlide.append('<iframe class="as_iframe" width="100%" height="100%" src="http://www.youtube.com/embed/' + curSlide.attr('data-src') + '?controls=0&autoplay=0&showinfo=0&modestbranding=1&wmode=opaque&rel=0&hd=1&disablekb=1" frameborder="0" allowfullscreen></iframe>');
	} else {
		curSlide.attr('style', 'background-image:url(' + curSlide.attr('data-src') + ');');
	}

	if (nextSlide.attr('data-type') == 'image') {
		nextSlide.attr('style', 'background-image:url(' + nextSlide.attr('data-src') + ');');
	}
	if (jQuery('#wpadminbar').size() > 0) {
		as_iframeHeight = myWindow.height() - header.height() - jQuery('#wpadminbar').height() - footer.height();
	} else {
		as_iframeHeight = myWindow.height() - header.height() - footer.height();
	}
	as_iframeWidth = (as_iframeHeight/9)*16;
	jQuery('.as_iframe').height(as_iframeHeight).width(as_iframeWidth);			
}
function setup_video_slide() {
	if (jQuery('#wpadminbar').size() > 0) {
		as_iframeHeight = myWindow.height() - header.height() - jQuery('#wpadminbar').height() - footer.height();
	} else {
		as_iframeHeight = myWindow.height() - header.height() - footer.height();
	}
	as_iframeWidth = (as_iframeHeight/9)*16;
	jQuery('.as_iframe').height(as_iframeHeight).width(as_iframeWidth);	
}
jQuery(window).resize(function(){
	setup_ajax_slider();
	setup_video_slide();
});