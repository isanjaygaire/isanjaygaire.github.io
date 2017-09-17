jQuery(document).ready(function($){
	if (window_w > 1024) {
		jQuery('.dm_ctrl_close').on('hover', function(){
			jQuery('.dm_span_close').addClass('hovered');
		},function(){
			jQuery('.dm_span_close').removeClass('hovered');
		});
		jQuery('.dm_ctrl_info').on('hover', function(){
			jQuery('.dm_span_info').addClass('hovered');
		},function(){
			jQuery('.dm_span_info').removeClass('hovered');
		});
	}
	jQuery('.dm_ctrl_info').on('click', function(){
		dm_html.toggleClass('showed_info');
		jQuery('.dm_more_info').toggleClass('hided_info');
	});
});	

var dragMe = jQuery("#dm_dragMe"),
	html = jQuery('html');

dragMe.on('touchstart', function(event) {
	touch = event.originalEvent.touches[0];
	startAt = touch.pageX;
	html.addClass('touched');
});		

dragMe.on('touchmove', function(event) {
	touch = event.originalEvent.touches[0];			
	movePath = -1* (startAt - touch.pageX)/2;
	movePercent = (movePath*100)/window_w;
	prevSl = html.find('.dm_prev');
	curSl = html.find('.dm_current');
	nextSl = html.find('.dm_next');

	movePrev = -100 + movePercent;
	moveMain = movePercent;
	moveNext = 100 + movePercent;
		
	prevSl.css('left' , movePrev +'%');
	curSl.css('left' , moveMain +'%');
	nextSl.css('left' , moveNext +'%');
});

dragMe.on('touchend', function(event) {
	html.removeClass('touched');
	touch = event.originalEvent.changedTouches[0];
	if (touch.pageX < startAt) {
		html.find('.dm_slider_next').click();
	}
	if (touch.pageX > startAt) {
		html.find('.dm_slider_prev').click();
	}
});


var dm_body = jQuery('body'),
	dm_html = jQuery('html'),
	dragMe = jQuery('#dm_fullscreen');
	dm_winHeight = myWindow.height(),
	dm_winWidth = myWindow.width();
	dm_html.addClass('dm_lightbox');

jQuery.fn.dm_lightbox = function (dm_options) {	
	var dm_container = dm_options.container,
		allSize = jQuery('.dm_link').size(),
		minSlide = 1,
		maxSlide = jQuery('.dm_link').size(),
		temp = 0,
		setSlide = 1;
		
	dm_body.append('<div id="dm_fullscreen"><ul class="dm_list"></ul></div>');	
	dm_fullscreen = jQuery('#dm_fullscreen');
	dm_list = jQuery('.dm_list');

    dm_body.append('<a href="javascript:void(0)" class="dm_slider_prev"/><a href="javascript:void(0)" class="dm_slider_next"/><a href="javascript:void(0)" class="dm_ctrl_close"/><div class="fs_thmb_viewport dm_thmb_viewport"><div class="fs_thmb_wrapper"><ul class="fs_thmb_list dm_thmb_list"></ul></div></div>');
	if (jQuery('.dm_lightbox_only').size() > 0) {
		dm_body.append('<a href="javascript:void(0)" class="closeAlone nav_button nav-close"/>');
	}
	if (jQuery('#dm_dragMe').size() < 1) {
		dm_body.append('<div id="dm_dragMe"/>');
	}

	//DebugWin
    //dm_body.append('<div id="dm_debuger"><span class="debug_line1"/><span class="debug_line2"/><span class="debug_line3"/><span class="debug_line4"/><span class="debug_line5"/><span class="debug_line6"/><span class="debug_line7"/></div>');
    dm_thmb = jQuery('.fs_thmb_list');
	dm_thmb_viewport = jQuery('.fs_thmb_viewport');
	if (jQuery('#wpadminbar').size() > 0) {
		dm_list.height(myWindow.height() - header.height() - jQuery('#wpadminbar').height());
	} else {
		dm_list.height(myWindow.height() - header.height());
	}
	dm_body.append('<div class="dm_more_info_wrapper"><div class="dm_more_info hided_info"><h4 class="info_title"></h4><h6 class="info_caption"></h6></div></div>');
	dm_more_info = jQuery('.dm_more_info');
	dm_title = jQuery('.info_title');
	dm_caption = jQuery('.info_caption');
	thisSlide = 1;
    while (thisSlide <= allSize) {
		this_type = jQuery('#dm_image'+thisSlide).attr('data-type');
		this_src = jQuery('#dm_image'+thisSlide).attr('href');
		this_title = jQuery('#dm_image'+thisSlide).attr('title');		
		this_caption = jQuery('#dm_image'+thisSlide).find('img').attr('data-caption');
		this_title_color = jQuery('#dm_image'+thisSlide).find('img').attr('data-title-color');
		this_caption_color = jQuery('#dm_image'+thisSlide).find('img').attr('data-caption-color');
		this_thmb = jQuery('#dm_image'+thisSlide).attr('data-thmb');
		this_width = jQuery('#dm_image'+thisSlide).attr('data-width');
		this_height = jQuery('#dm_image'+thisSlide).attr('data-height');
		this_ratio = jQuery('#dm_image'+thisSlide).attr('data-ratio');
		
		dm_list.append('<li class="dm_slide dm_slide'+thisSlide+'" data-title="'+this_title+'" data-caption="'+this_caption+'" data-title-color="'+ this_title_color +'" data-caption-color ="'+ this_caption_color +'" data-width="'+this_width+'" data-height="'+this_height+'" data-ratio="'+this_ratio+'" data-count="' + thisSlide + '" data-title="'+ this_title +'" data-type="'+ this_type +'" data-src="'+ this_src +'"/>');
		dm_thmb.append('<li class="dm_slide_thmb dm_slide' + thisSlide + '" data-count="' + thisSlide + '"><img alt="' + this_title + '" src="' + this_thmb + '"/></li>');
		thisSlide++;
	}
	
	jQuery('.dm_link').on('click', function(e){
		e.preventDefault();
		dm_list.addClass('nowLoading');
		setSlide = jQuery(this).attr('data-count');
		setImage(setSlide);
		setThmb(setSlide);
		setTimeout("dm_list.removeClass('nowLoading')", 500);
	});
	jQuery('.dm_slider_prev').on('click', function(){		
		curSlide = parseInt(jQuery('.dm_current').attr('data-count'));
		setSlide = curSlide - 1;
		if (setSlide < minSlide) setSlide = maxSlide;
		if (setSlide > maxSlide) setSlide = minSlide;
		setImage(setSlide);
		setThmb(setSlide);		
	});

	jQuery('.dm_slider_next').on('click', function(){
		curSlide = parseInt(jQuery('.dm_current').attr('data-count'));
		setSlide = curSlide+ 1;
		if (setSlide < minSlide) setSlide = maxSlide;
		if (setSlide > maxSlide) setSlide = minSlide;
		setImage(setSlide);
		setThmb(setSlide);
	});	

	jQuery(document.documentElement).keyup(function (event) {
		if ((event.keyCode == 37) || (event.keyCode == 38)) {
			curSlide = parseInt(jQuery('.dm_current').attr('data-count'));
			setSlide = curSlide - 1;		
			if (setSlide < minSlide) setSlide = maxSlide;
			if (setSlide > maxSlide) setSlide = minSlide;
			setImage(setSlide);
			setThmb(setSlide);		
		} else if ((event.keyCode == 39) || (event.keyCode == 40)) {
			curSlide = parseInt(jQuery('.dm_current').attr('data-count'));
			setSlide = curSlide + 1;
			if (setSlide < minSlide) setSlide = maxSlide;
			if (setSlide > maxSlide) setSlide = minSlide;
			setImage(setSlide);
			setThmb(setSlide);
		}
	});
	
	if (window_w > 1024) {
		dm_list.find('li').on('click', function(){
			if (jQuery(this).hasClass('zoomed')) {
				jQuery(this).removeClass('zoomed');
				setViewPort(jQuery(this));
			} else {
				if (jQuery(this).hasClass('canZoom')) {
					jQuery(this).addClass('zoomed');
					dataW = jQuery(this).attr('data-width');
					dataH = jQuery(this).attr('data-height');
					jQuery(this).find('img').css({
						'width' :  dataW + 'px',
						'height' : dataH + 'px',
						'margin-top' : -dataH/2,
						'margin-left' : -dataW/2
					});
				}
			}
		});
	}

	dm_list.find('li').on('mousemove', function(e) {
		if (jQuery(this).hasClass('zoomed')) {;
			pageYa = e.pageY-myWindow.scrollTop();
			dm_winHeight = myWindow.height(),
			dm_winWidth = myWindow.width();			
			move_img = jQuery(this).find('img');
			if (move_img.width() > dm_winWidth && move_img.height() > dm_winHeight) {
				moveFactor_x = move_img.width() - dm_winWidth;
				moveFactor_y = move_img.height() - dm_winHeight;
				move_percentY = pageYa/dm_winHeight;
				move_percentX = e.pageX/dm_winWidth;
				set_move_side = move_percentX*moveFactor_x - moveFactor_x/2;
				set_move_top = move_percentY*moveFactor_y - moveFactor_y/2;
				move_img.css({'transform' : ' translate('+ set_move_side +'px, '+set_move_top+'px)'});
				if (jQuery('#dm_debuger').size() > 0) {
					jQuery('.debug_line1').html('Trans Type: X and Y!');
					jQuery('.debug_line2').html('MoveFactorX: '+ moveFactor_x +' ; Percent: '+ move_percentX);
					jQuery('.debug_line3').html('MoveFactorY: '+ moveFactor_y +' ; Percent: '+ move_percentY);
					jQuery('.debug_line4').html('Move Side: '+ set_move_side);
					jQuery('.debug_line5').html('Move Top: '+ set_move_top);
					jQuery('.debug_line6').html('PageX: '+ e.pageX +' ; PageY: '+ pageYa);
					jQuery('.debug_line7').html('WinW: '+ dm_winWidth +' ; WinH: '+ dm_winHeight);
				}
			} else 			
			if (move_img.height() > dm_winHeight) {
				moveFactor_y = move_img.height() - dm_winHeight;
				move_percentY = pageYa/dm_winHeight;
				set_move_top = move_percentY*moveFactor_y - moveFactor_y/2;
				move_img.css({'transform' : ' translateY('+ set_move_top +'px)'});
				if (jQuery('#dm_debuger').size() > 0) {				
					jQuery('.debug_line1').html('Trans Type: Y Only!');
					jQuery('.debug_line2').html('MoveFactorX: ');
					jQuery('.debug_line3').html('MoveFactorY: '+ moveFactor_y +' ; Percent: '+ move_percentY);
					jQuery('.debug_line4').html('Move Side: ');
					jQuery('.debug_line5').html('Move Top: '+ set_move_top);
					jQuery('.debug_line6').html('PageX: ; PageY: '+ pageYa);
					jQuery('.debug_line7').html('WinW: '+ dm_winWidth +' ; WinH: '+ dm_winHeight);					
				}
			} else 
			if (move_img.width() > dm_winWidth) {
				moveFactor_x = move_img.width() - dm_winWidth;
				move_percentX = e.pageX/dm_winWidth;
				set_move_side = move_percentX*moveFactor_x - moveFactor_x/2;
				move_img.css({'transform' : ' translateX('+ set_move_side +'px)'});
				if (jQuery('#dm_debuger').size() > 0) {				
					jQuery('.debug_line1').html('Trans Type: X Only!');
					jQuery('.debug_line2').html('MoveFactorX: '+ moveFactor_x +' ; Percent: '+ move_percentX);
					jQuery('.debug_line3').html('MoveFactorY: ');
					jQuery('.debug_line4').html('Move Side: '+ set_move_side);
					jQuery('.debug_line5').html('Move Top: ');
					jQuery('.debug_line6').html('PageX: '+ e.pageX +' ; PageY:');
					jQuery('.debug_line7').html('WinW: '+ dm_winWidth +' ; WinH: '+ dm_winHeight);					
				}
			}
		}
	});
	
	jQuery('.dm_ctrl_close').on('click', function(){
		dm_html.removeClass('dm_show');
		dm_more_info.animate({'opacity' : 0},300,function(){
			setTimeout("dm_title.html(dm_current.attr('data-title'))", 200);
			setTimeout("dm_caption.html(dm_current.attr('data-caption'))", 200);
			dm_title.removeClass('title_only');			
		});
		jQuery('.dm_slide').each(function(){
			jQuery(this).empty();
		});		
	});

	function setImage(setSlide) {
		nextSlide = parseInt(setSlide)+1;
		if (nextSlide > maxSlide) nextSlide = minSlide;
		prevSlide = parseInt(setSlide)-1;
		if (prevSlide < minSlide) prevSlide = maxSlide;
		jQuery('.zoomed').removeClass('zoomed');
		jQuery('.dm_prev').removeClass('dm_prev');
		jQuery('.dm_current').removeClass('dm_current');
		jQuery('.dm_next').removeClass('dm_next');
		
		dm_html.addClass('dm_show');
		dm_list.find('.dm_slide'+prevSlide).addClass('dm_prev').css('left', '-100%');
		dm_list.find('.dm_slide'+setSlide).addClass('dm_current').css('left', '0%');
		dm_list.find('.dm_slide'+nextSlide).addClass('dm_next').css('left', '100%');
		dm_prev = jQuery('.dm_prev');
		dm_current= jQuery('.dm_current');
		dm_next = jQuery('.dm_next');

		dm_more_info.animate({'opacity' : 0},300,function(){
			setTimeout("dm_title.html(dm_current.attr('data-title'))", 200);
			setTimeout("dm_caption.html(dm_current.attr('data-caption'))", 200);
			if (dm_current.attr('data-title') !== '' || dm_current.attr('data-caption') !== "") {
				setTimeout("dm_more_info.animate({'opacity' : 1},300)", 200);
			}
			if (dm_current.attr('data-caption') == "") {
				dm_title.addClass('title_only');
			} else {
				dm_title.removeClass('title_only');
			}
		});

		jQuery('.dm_slide').each(function(){
			if (!jQuery(this).hasClass('dm_prev') && !jQuery(this).hasClass('dm_current') && !jQuery(this).hasClass('dm_next')) {
				jQuery(this).empty();
			}
		});
		
		if (dm_prev.attr('data-type') == 'vimeo') {
			dm_prev.empty();
		} else if (dm_prev.attr('data-type') == 'youtube') {
			dm_prev.empty();
		} else {
			if (dm_prev.find('img').size() < 1) {
				dm_prev.append('<img src="'+ dm_prev.attr('data-src') +'" alt="'+ dm_prev.attr('data-title') +'">');
			}
		}

		if (dm_current.attr('data-type') == 'vimeo') {
			dm_current.append(jQuery('<iframe width="100%" height="100%" src="http://player.vimeo.com/video/' + dm_current.attr('data-src') + '?api=0&amp;title=0&amp;byline=0&amp;portrait=0&autoplay=1&loop=0&controls=0" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>'));
		} else if (dm_current.attr('data-type') == 'youtube') {
			dm_current.append('<iframe width="100%" height="100%" src="http://www.youtube.com/embed/' + dm_current.attr('data-src') + '?controls=0&autoplay=1&showinfo=0&modestbranding=1&wmode=opaque&rel=0&hd=1&disablekb=1" frameborder="0" allowfullscreen></iframe>');
		} else {
			if (dm_current.find('img').size() < 1) {
				dm_current.append('<img src="'+ dm_current.attr('data-src') +'" alt="'+ dm_current.attr('data-title') +'">');
			}
		}
		if (dm_current.attr('data-type') == 'vimeo' || dm_current.attr('data-type') == 'youtube') {
			if (myWindow.width() > 1024) {
				if (jQuery('iframe').size() > 0) {
					if (((window_h + 150) / 9) * 16 > window_w) {
						jQuery('iframe').height(window_h + 150).width(((window_h + 150) / 9) * 16);
						jQuery('iframe').css({
							'margin-left': (-1 * jQuery('iframe').width() / 2) + 'px',
							'top': "-75px",
							'margin-top': '0px'
						});
					} else {
						jQuery('iframe').width(window_w).height(((window_w) / 16) * 9);
						jQuery('iframe').css({
							'margin-left': (-1 * jQuery('iframe').width() / 2) + 'px',
							'margin-top': (-1 * jQuery('iframe').height() / 2) + 'px',
							'top': '50%'
						});
					}
				}
			} else {
				jQuery('iframe').height(window_h).width(window_w).css({
					'top': '0px',
					'margin-left' : '0px',
					'left' : '0px',
					'margin-top': '0px'
				});			
			}
		}
		
		if (dm_next.attr('data-type') == 'vimeo') {
			dm_next.empty();
		} else if (dm_next.attr('data-type') == 'youtube') {
			dm_next.empty();
		} else {
			if (dm_next.find('img').size() < 1) {
				dm_next.append('<img src="'+ dm_next.attr('data-src') +'" alt="'+ dm_next.attr('data-title') +'">');
			}
		}
		setViewPort(dm_prev);
		setViewPort(dm_current);
		setViewPort(dm_next);
	}
	
	function setViewPort(object) {
		dm_winHeight = myWindow.height(),
		dm_winWidth = myWindow.width();		
		image = object.find('img')
		winRatio = dm_winWidth/dm_winHeight;
		imgRatio = object.attr('data-ratio');
		image.css({'transform' : ' translate(0,0)'});

		if (winRatio > 1) {
			//Win Landscape
			if (imgRatio > 1) {
				//Win Landscape With Img Landscape
				if (winRatio > imgRatio) {
					iW = object.attr('data-width')/(object.attr('data-height')/dm_winHeight); iH = dm_winHeight;					
					image.width(iW); image.height(iH);
					image.css({'margin-top' : -iH/2,'margin-left' : -iW/2,});
					
					if (object.attr('data-height') > dm_winHeight) {
						object.addClass('canZoom');
					} else {
						object.removeClass('canZoom');
					}						
				} else {
					iW = dm_winWidth; iH = object.attr('data-height')/(object.attr('data-width')/dm_winWidth);
					image.width(iW); image.height(iH);
					image.css({'margin-top' : -iH/2,'margin-left' : -iW/2,});

					if (object.attr('data-width') > dm_winWidth) {
						object.addClass('canZoom');
					} else {
						object.removeClass('canZoom');
					}						
				}
			} else {
				//Win Landscape With Img Portarait
				iW = object.attr('data-width')/(object.attr('data-height')/dm_winHeight); iH = dm_winHeight;
				image.width(iW); image.height(iH);
				image.css({'margin-top' : -iH/2,'margin-left' : -iW/2,});

				if (object.attr('data-height') > dm_winHeight) {
					object.addClass('canZoom');
				} else {
					object.removeClass('canZoom');
				}
			}
		} else {
			//Win Portrait
			if (imgRatio > 1) {
				//Win Portrait With Img Landscape
				iW = dm_winWidth; iH = object.attr('data-height')/(object.attr('data-width')/dm_winWidth);
				image.width(iW); image.height(iH);
				image.css({'margin-top' : -iH/2,'margin-left' : -iW/2,});

				if (object.attr('data-width') > dm_winWidth) {
					object.addClass('canZoom');
				} else {
					object.removeClass('canZoom');
				}
			} else {
				//Win Portrait With Img Portarait
				if (winRatio < imgRatio) {
					iW = dm_winWidth; iH = object.attr('data-height')/(object.attr('data-width')/dm_winWidth);
					image.width(iW); image.height(iH);
					image.css({'margin-top' : -iH/2,'margin-left' : -iW/2,});

					if (object.attr('data-width') > dm_winWidth) {
						object.addClass('canZoom');
					} else {
						object.removeClass('canZoom');
					}
				} else {
					iW = object.attr('data-width')/(object.attr('data-height')/dm_winHeight); iH = dm_winHeight;
					image.width(iW); image.height(iH);
					image.css({'margin-top' : -iH/2,'margin-left' : -iW/2,});

					if (object.attr('data-height') > dm_winHeight) {
						object.addClass('canZoom');
					} else {
						object.removeClass('canZoom');
					}
				}				
			}			
		}
		return;
	}

	function setThmb(setSlide) {
		jQuery('.thmbPrev2').removeClass('thmbPrev2');
		jQuery('.thmbPrev').removeClass('thmbPrev');
		jQuery('.thmbCurrent').removeClass('thmbCurrent');				
		jQuery('.thmbNext').removeClass('thmbNext');
		jQuery('.thmbNext2').removeClass('thmbNext2');		
		
		dm_thmb.find('.dm_slide'+parseInt(setSlide)).addClass('thmbCurrent');
		if((parseInt(setSlide)+1) > maxSlide) {
			dm_thmb.find('.dm_slide1').addClass('thmbNext');
			dm_thmb.find('.dm_slide2').addClass('thmbNext2');
		} else if ((parseInt(setSlide)+1) == maxSlide){
			dm_thmb.find('.dm_slide'+maxSlide).addClass('thmbNext');
			dm_thmb.find('.dm_slide1').addClass('thmbNext2');					
		} else {
			dm_thmb.find('.dm_slide'+(parseInt(setSlide)+1)).addClass('thmbNext');
			dm_thmb.find('.dm_slide'+(parseInt(setSlide)+2)).addClass('thmbNext2');				
		}
		if((parseInt(setSlide)-1) < 1) {
			dm_thmb.find('.dm_slide'+maxSlide).addClass('thmbPrev');
			dm_thmb.find('.dm_slide'+(maxSlide-1)).addClass('thmbPrev2');
		} else if ((setSlide-1) == 1){					
			dm_thmb.find('.dm_slide1').addClass('thmbPrev');
			dm_thmb.find('.dm_slide'+maxSlide).addClass('thmbPrev2');
		} else {
			dm_thmb.find('.dm_slide'+(parseInt(setSlide)-1)).addClass('thmbPrev');
			dm_thmb.find('.dm_slide'+(parseInt(setSlide)-2)).addClass('thmbPrev2');
		}
			
	}
	
	jQuery(window).resize(function(){		
		if (jQuery('.dm_current').size() > 0) {
			curObject = jQuery('.dm_current');
			setViewPort(curObject);
		}
	});
}
