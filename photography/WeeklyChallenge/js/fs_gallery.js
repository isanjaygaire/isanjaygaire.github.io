var	rb_indicator_left = jQuery('.rb_indicator_left'),
	rb_indicator_right = jQuery('.rb_indicator_right');

jQuery.fn.fs_gallery = function (fs_options) {
	var fs_body = this;
	if (jQuery('.fs_gallery_wrapper').size() > 0) {
		jQuery('.fs_gallery_wrapper').remove();
		jQuery('#fs_play-pause').remove();
		jQuery('.fs_thmb_viewport').remove();
	}
    if (fs_options.slides.length > 1) {
        var fs_interval = setInterval('nextSlide()', fs_options.slide_time);
    }	
    if (fs_options.thmb_state == 'off') {
        set_state = "fs_hide";
    } else {
        set_state = "";
    }
    if (fs_options.autoplay == 0) {
        playpause = "nav-play";
        clearInterval(fs_interval);
    } else {
        playpause = "nav-pause";
    }
    if (fs_options.show_controls == 0) {
		jQuery('html').addClass('hide_controls');
    }
	if (jQuery('.fs_content_trigger').size() > 0) {
		fs_body = jQuery('.fs_content_trigger');
		fs_body.append('<div class="fs_gallery_wrapper w_content fadeOnLoad"><ul class="' + fs_options.fit + ' fs_gallery_container ' + fs_options.fx + '"/></div>');	
	} else {
    	fs_body.append('<div class="fs_gallery_wrapper fadeOnLoad"><ul class="' + fs_options.fit + ' fs_gallery_container ' + fs_options.fx + '"/></div>');
	}
    fs_container = jQuery('.fs_gallery_container');
	
    if (fs_options.slides.length > 1) {
        jQuery('.fs_controls_append').prepend('<a href="javascript:void(0)" class="rbPrev fs_slider_prev"></a><a href="javascript:void(0)" class="rbNext fs_slider_next"></a><a href="javascript:void(0)" id="fs_play-pause" class="nav_button '+playpause+'"></a>');
    }
    fs_body.append('<div class="fs_thmb_viewport ' + set_state + '"><div class="fs_thmb_wrapper"><ul class="fs_thmb_list" style="width:' + fs_options.slides.length * 80 + 'px"></ul></div></div>');
    fs_thmb = jQuery('.fs_thmb_list');
    if (fs_options.autoplay == 0) {
        fs_thmb.addClass('paused');
    }
    fs_thmb_viewport = jQuery('.fs_thmb_viewport');
    $fs_title = jQuery('.fs_title');
    $fs_descr = jQuery('.fs_descr');
	$fs_title_wrapper = jQuery('.fs_title_wrapper');

	$status_max = jQuery('.rb_total_display'),
	$status_cur = jQuery('.rb_current_display'),

	$status_max.text(fs_options.slides.length);
	$status_cur.text('1');
    thisSlide = 0;
    while (thisSlide <= fs_options.slides.length - 1) {
        if (fs_options.slides[thisSlide].type == "image") {
            fs_container.append('<li class="fs_slide block2preload slide' + thisSlide + '" data-count="' + thisSlide + '" data-src="' + fs_options.slides[thisSlide].image + '" data-type="' + fs_options.slides[thisSlide].type + '"></li>');
        } else if (fs_options.slides[thisSlide].type == "youtube") {
            fs_container.append('<li class="fs_slide yt_slide video_slide slide' + thisSlide + '" data-count="' + thisSlide + '" data-bg="' + fs_options.slides[thisSlide].thmb + '" data-src="' + fs_options.slides[thisSlide].src + '" data-type="' + fs_options.slides[thisSlide].type + '"></li>');
        } else {
            fs_container.append('<li class="fs_slide video_slide slide' + thisSlide + '" data-id="player' + fs_options.slides[thisSlide].uniqid + '" data-count="' + thisSlide + '" data-bg="' + fs_options.slides[thisSlide].thmb + '" data-src="' + fs_options.slides[thisSlide].src + '" data-type="' + fs_options.slides[thisSlide].type + '"></li>');
        }

        if (fs_options.slides[thisSlide].type == "image") {
            fs_thmb.append('<li class="fs_slide_thmb slide' + thisSlide + '" data-count="' + thisSlide + '"><img alt="' + fs_options.slides[thisSlide].alt + ' ' + thisSlide + '" src="' + fs_options.slides[thisSlide].thmb + '"/></li>');
        } else if (fs_options.slides[thisSlide].type == "youtube") {
            fs_thmb.append('<li class="fs_slide_thmb video_thmb yt_thmb slide' + thisSlide + '" data-count="' + thisSlide + '"><img alt="' + fs_options.slides[thisSlide].alt + ' ' + thisSlide + '" src="' + fs_options.slides[thisSlide].thmb + '"/><div class="fs_thmb_fadder"></div></li>');
        } else {
            fs_thmb.append('<li class="fs_slide_thmb video_thmb slide' + thisSlide + '" data-count="' + thisSlide + '"><img alt="' + fs_options.slides[thisSlide].alt + ' ' + thisSlide + '" src="' + fs_options.slides[thisSlide].thmb + '"/><div class="fs_thmb_fadder"></div></li>');
        }
        thisSlide++;
    }
    jQuery('li.slide0').addClass('current-slide');
	jQuery('li'+ fs_options.slides.length - 1).addClass('prev-slide');
	jQuery('li.slide1').addClass('next-slide');
	current = 0;
	setThmb(current);

    firstObj = fs_container.find('li.slide0');
    fNextObj = fs_container.find('li.slide1');
    var gallery_fixer = 0;

	if (jQuery('.gallery_post_controls').size() > 0) {
        gallery_fixer = jQuery('.gallery_post_controls').find('a').size()*65 + parseInt(jQuery('.gallery_post_controls').css('right'));
    }

    if (firstObj.attr('data-type') == 'image') {
        firstObj.attr('style', 'background:url(' + fs_container.find('li.slide0').attr('data-src') + ') no-repeat;');
    } else if (firstObj.attr('data-type') == 'youtube') {
        firstObj.attr('style', 'background:url(' + fs_options.slides[0].thmb + ') no-repeat;');
        firstObj.append('<iframe width="100%" height="100%" src="http://www.youtube.com/embed/' + fs_options.slides[0].src + '?controls=0&autoplay=1&showinfo=0&modestbranding=1&wmode=opaque&rel=0&hd=1&disablekb=1" frameborder="0" allowfullscreen></iframe>');
    } else {
        firstObj.attr('style', 'background:url(' + fs_options.slides[0].thmb + ') no-repeat;');
        firstObj.append('<iframe src="http://player.vimeo.com/video/' + fs_options.slides[0].src + '?autoplay=1&loop=0&api=1&player_id=player' + fs_options.slides[0].uniqid + '" width="100%" height="100%" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>');
    }
    if (fs_options.slides.length > 1) {
        if (fNextObj.attr('data-type') == 'image') {
            fNextObj.attr('style', 'background:url(' + fs_container.find('li.slide1').attr('data-src') + ') no-repeat;');
        } else if (fNextObj.attr('data-type') == 'youtube') {
            fNextObj.attr('style', 'background:url(' + fs_options.slides[1].thmb + ') no-repeat;');
        } else {
            fNextObj.attr('style', 'background:url(' + fs_options.slides[1].thmb + ') no-repeat;');
        }
    }

    if (myWindow.width() > 1024) {
        if (jQuery('iframe').size() > 0) {
            if (((fs_container.height() + 150) / 9) * 16 > fs_container.width()) {
                jQuery('iframe').height(fs_container.height() + 150).width(((fs_container.height() + 150) / 9) * 16);
                jQuery('iframe').css({
                    'margin-left': (-1 * jQuery('iframe').width() / 2) + 'px',
                    'top': "-75px",
                    'margin-top': '0px'
                });
            } else {
                jQuery('iframe').width(fs_container.width()).height(((fs_container.width()) / 16) * 9);
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
			'left' : '0',
			'margin-top': '0px'
		});			
	}

    $fs_title.html(fs_options.slides[0].title);
    $fs_descr.html(fs_options.slides[0].description);
	if (fs_options.slides[0].description == '') {
		$fs_title.addClass('only_title');
	} else {
		$fs_title.removeClass('only_title');
	}
	if (fs_options.slides[0].title == '') {
		$fs_title.addClass('only_caption');
	} else {
		$fs_title.removeClass('only_caption');
	}
	if (fs_options.slides[0].description == '') {
		$fs_title.addClass('only_title');
	} else {
		$fs_title.removeClass('only_title');
	}
	if (fs_options.slides[0].description == '' && fs_options.slides[0].title == '') {
		$fs_title_wrapper.addClass('empty_block');
	} else {
		$fs_title_wrapper.removeClass('empty_block');
	}

    if (fs_options.slides.length > 1) {
        jQuery('.fs_slide_thmb').on('click', function () {
            goToSlide(parseInt(jQuery(this).attr('data-count')));
        });
        jQuery('.fs_slider_prev').on('click', function () {
            prevSlide();
        });
        jQuery('.fs_slider_next').on('click', function () {
            nextSlide();
        });

        jQuery(document.documentElement).keyup(function (event) {
            if ((event.keyCode == 37)) {
                prevSlide();
            } else if ((event.keyCode == 39)) {
                nextSlide();
            }
        });

        jQuery('#fs_play-pause').on('click', function () {
            if (jQuery(this).hasClass('nav-pause')) {
                fs_thmb.addClass('paused');
                jQuery(this).removeClass('nav-pause').addClass('nav-play');
                clearInterval(fs_interval);
            } else {
                fs_thmb.removeClass('paused');
                jQuery(this).removeClass('nav-play').addClass('nav-pause');
                fs_interval = setInterval('nextSlide()', fs_options.slide_time);
            }
        });
	
		fs_container.on('touchstart', function(event) {
			clearInterval(fs_interval);
			touch = event.originalEvent.touches[0];
			startAt = touch.pageX;
			html.addClass('touched');
		});		
		
		fs_container.on('touchmove', function(event) {			
			touch = event.originalEvent.touches[0];
			movePath = -1* (startAt - touch.pageX)/2;
			movePercent = (movePath*100)/window_w;
			prevSl = fs_container.find('.prev-slide');
			curSl = fs_container.find('.current-slide');
			nextSl = fs_container.find('.next-slide');

			if (fs_options.fx == 'slip') {
				movePrev = -100 + movePercent;
				moveMain = movePercent;
				moveNext = 100 + movePercent;

				prevSl.css('left' , movePrev +'%');
				curSl.css('left' , moveMain +'%');
				nextSl.css('left' , moveNext +'%');
			} else {				
				if (movePercent < 0) {
					curSl.css('opacity', 1+movePercent/100);
					nextSl.css('opacity', -1*movePercent/100);
				} else {
					curSl.css('opacity', 1-movePercent/100);
					nextSl.css('opacity', movePercent/100);
				}
			}
		});
		fs_container.on('touchend', function(event) {
			html.removeClass('touched');
			touch = event.originalEvent.changedTouches[0];
			if (touch.pageX < startAt) {
				nextSlide();
			}
			if (touch.pageX > startAt) {
				prevSlide();
			}
		});
		if (myWindow.width() > 1200) {
			jQuery('#addClass').addClass('disabled');
			fs_body.mousemove(function() {
				jQuery('#fs_play-pause').removeClass('disabled');
				setTimeout("jQuery('#fs_play-pause').addClass('disabled')",1000);
			});
		}
		//jQuery('#fs_play-pause')
    }
	/* KILL */
    kill_slider = function () {
		clearInterval(fs_interval);
	}
    /* N E X T   S L I D E */
	nextSlide = function () {
        clearInterval(fs_interval);
        thisSlide = parseInt(fs_container.find('.current-slide').attr('data-count'));
        fs_container.find('.slide' + thisSlide).find('iframe').remove();
        thisSlide++;
		maxSize = fs_container.find('li').size()-1;

		if (thisSlide > maxSize) {
			thisSlide = 0;
		}
		if((thisSlide+1) > maxSize) {
			nextObj = fs_container.find('.slide0');
			cnextObj = fs_container.find('.slide1');
		} else if ((thisSlide+1) == maxSize){
			nextObj = fs_container.find('.slide'+maxSize);
			cnextObj = fs_container.find('.slide0');
		} else {
			nextObj = fs_container.find('.slide'+(thisSlide+1));
			cnextObj = fs_container.find('.slide'+(thisSlide+2));
		}
		if((thisSlide-1) < 0) {
			prevObj = fs_container.find('.slide'+maxSize);
			cprevObj = fs_container.find('.slide'+(maxSize-1));
		} else if ((thisSlide-1) == 0){					
			prevObj = fs_container.find('.slide0');
			cprevObj = fs_container.find('.slide'+maxSize);
		} else {
			prevObj = fs_container.find('.slide'+(thisSlide-1));
			cprevObj = fs_container.find('.slide'+(thisSlide-2));
		}
        cprevObj.attr('style', '').html('');
		cnextObj.attr('style', '').html('');
		$status_cur.text(thisSlide+1);

        $fs_title.fadeOut(300);
        $fs_descr.fadeOut(300, function () {
            $fs_title.html(fs_options.slides[thisSlide].title);
            $fs_descr.html(fs_options.slides[thisSlide].description);
			if (fs_options.slides[thisSlide].description == '') {
				$fs_title.addClass('only_title');
			} else {
				$fs_title.removeClass('only_title');
			}		
			if (fs_options.slides[thisSlide].title == '') {
				$fs_title.addClass('only_caption');
			} else {
				$fs_title.removeClass('only_caption');
			}
			
			if (fs_options.slides[thisSlide].description == '' && fs_options.slides[thisSlide].title == '') {
				$fs_title_wrapper.addClass('empty_block');
			} else {
				$fs_title_wrapper.removeClass('empty_block');
			}
				
            $fs_title.fadeIn(300);
            $fs_descr.fadeIn(300);
        });

        currentObj = fs_container.find('.slide' + thisSlide);
		setThmb(thisSlide);
		
        if (currentObj.attr('data-type') == 'image') {
            currentObj.attr('style', 'background:url(' + currentObj.attr('data-src') + ') no-repeat;');
        } else if (currentObj.attr('data-type') == 'youtube') {
            currentObj.attr('style', 'background:url(' + currentObj.attr('data-bg') + ') no-repeat;');
			currentObj.append('<iframe width="100%" height="100%" src="http://www.youtube.com/embed/' + currentObj.attr('data-src') + '?controls=0&autoplay=1&showinfo=0&modestbranding=1&wmode=opaque&rel=0&hd=1&disablekb=1" frameborder="0" allowfullscreen></iframe>');
        } else {
            currentObj.attr('style', 'background:url(' + currentObj.attr('data-bg') + ') no-repeat;');
            currentObj.append(jQuery('<iframe width="100%" height="100%" src="http://player.vimeo.com/video/' + currentObj.attr('data-src') + '?api=1&amp;title=0&amp;byline=0&amp;portrait=0&autoplay=1&loop=0&controls=0&player_id=' + currentObj.attr('data-id') + '" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>').attr('id', currentObj.attr('data-id')));
        }

        if (nextObj.attr('data-type') == 'image') {
            nextObj.attr('style', 'background:url(' + nextObj.attr('data-src') + ') no-repeat;');
        } else if (nextObj.attr('data-type') == 'youtube') {
            nextObj.attr('style', 'background:url(' + nextObj.attr('data-bg') + ') no-repeat;');
        } else {
            nextObj.attr('style', 'background:url(' + nextObj.attr('data-bg') + ') no-repeat;');
        }

        if (prevObj.attr('data-type') == 'image') {
            prevObj.attr('style', 'background:url(' + prevObj.attr('data-src') + ') no-repeat;');
        } else if (prevObj.attr('data-type') == 'youtube') {
            prevObj.attr('style', 'background:url(' + prevObj.attr('data-bg') + ') no-repeat;');
        } else {
            prevObj.attr('style', 'background:url(' + prevObj.attr('data-bg') + ') no-repeat;');
        }

        jQuery('.current-slide').removeClass('current-slide');
		jQuery('.prev-slide').removeClass('prev-slide');
		jQuery('.next-slide').removeClass('next-slide');

        jQuery('.slide' + thisSlide).addClass('current-slide');
        nextObj.addClass('next-slide');
		prevObj.addClass('prev-slide');
		
		videoSetup();

        if (!fs_thmb.hasClass('paused') && currentObj.attr('data-type') == 'image') {
            fs_interval = setInterval('nextSlide()', fs_options.slide_time);
        }
    }

    /* P R E V I O U S   S L I D E */
    prevSlide = function () {
        clearInterval(fs_interval);
        thisSlide = parseInt(fs_container.find('.current-slide').attr('data-count'));
        fs_container.find('.slide' + thisSlide).find('iframe').remove();
        thisSlide--;

		maxSize = fs_container.find('li').size()-1;

		if (thisSlide < 0) {
			thisSlide = maxSize;
		}		
		if((thisSlide+1) > maxSize) {
			nextObj = fs_container.find('.slide0');
			cnextObj = fs_container.find('.slide1');
		} else if ((thisSlide+1) == maxSize){
			nextObj = fs_container.find('.slide'+maxSize);
			cnextObj = fs_container.find('.slide0');
		} else {
			nextObj = fs_container.find('.slide'+(thisSlide+1));
			cnextObj = fs_container.find('.slide'+(thisSlide+2));
		}
		if((thisSlide-1) < 0) {
			prevObj = fs_container.find('.slide'+maxSize);
			cprevObj = fs_container.find('.slide'+(maxSize-1));
		} else if ((thisSlide-1) == 0){					
			prevObj = fs_container.find('.slide0');
			cprevObj = fs_container.find('.slide'+maxSize);
		} else {
			prevObj = fs_container.find('.slide'+(thisSlide-1));
			cprevObj = fs_container.find('.slide'+(thisSlide-2));
		}
        cprevObj.attr('style', '').html('');
		cnextObj.attr('style', '').html('');
		$status_cur.text(thisSlide+1);
		
        $fs_title.fadeOut(300);
        $fs_descr.fadeOut(300, function () {
            $fs_title.html(fs_options.slides[thisSlide].title);
            $fs_descr.html(fs_options.slides[thisSlide].description);
			if (fs_options.slides[thisSlide].description == '') {
				$fs_title.addClass('only_title');
			} else {
				$fs_title.removeClass('only_title');
			}		
			if (fs_options.slides[thisSlide].title == '') {
				$fs_title.addClass('only_caption');
			} else {
				$fs_title.removeClass('only_caption');
			}
			if (fs_options.slides[thisSlide].description == '' && fs_options.slides[thisSlide].title == '') {
				$fs_title_wrapper.addClass('empty_block');
			} else {
				$fs_title_wrapper.removeClass('empty_block');
			}
				
            $fs_title.fadeIn(300);
            $fs_descr.fadeIn(300);
        });

        currentObj = fs_container.find('.slide' + thisSlide);
		setThmb(thisSlide);

        if (currentObj.attr('data-type') == 'image') {
            currentObj.attr('style', 'background:url(' + currentObj.attr('data-src') + ') no-repeat;');
        } else if (currentObj.attr('data-type') == 'youtube') {
            currentObj.attr('style', 'background:url(' + nextObj.attr('data-bg') + ') no-repeat;');
			currentObj.append('<iframe width="100%" height="100%" src="http://www.youtube.com/embed/' + currentObj.attr('data-src') + '?controls=0&autoplay=1&showinfo=0&modestbranding=1&wmode=opaque&rel=0&hd=1&disablekb=1" frameborder="0" allowfullscreen></iframe>');            
        } else {
            currentObj.attr('style', 'background:url(' + currentObj.attr('data-bg') + ') no-repeat;');
            currentObj.append(jQuery('<iframe width="100%" height="100%" src="http://player.vimeo.com/video/' + currentObj.attr('data-src') + '?api=1&amp;title=0&amp;byline=0&amp;portrait=0&autoplay=1&loop=0&controls=0&player_id=' + currentObj.attr('data-id') + '" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>').attr('id', currentObj.attr('data-id')));
        }

        if (nextObj.attr('data-type') == 'image') {
            nextObj.attr('style', 'background:url(' + nextObj.attr('data-src') + ') no-repeat;');
        } else if (nextObj.attr('data-type') == 'youtube') {
            nextObj.attr('style', 'background:url(' + nextObj.attr('data-bg') + ') no-repeat;');
        } else {
            nextObj.attr('style', 'background:url(' + nextObj.attr('data-bg') + ') no-repeat;');
        }

        if (prevObj.attr('data-type') == 'image') {
            prevObj.attr('style', 'background:url(' + prevObj.attr('data-src') + ') no-repeat;');
        } else if (prevObj.attr('data-type') == 'youtube') {
            prevObj.attr('style', 'background:url(' + prevObj.attr('data-bg') + ') no-repeat;');
        } else {
            prevObj.attr('style', 'background:url(' + prevObj.attr('data-bg') + ') no-repeat;');
        }

        jQuery('.current-slide').removeClass('current-slide');
		jQuery('.prev-slide').removeClass('prev-slide');
		jQuery('.next-slide').removeClass('next-slide');

        jQuery('.slide' + thisSlide).addClass('current-slide');
        nextObj.addClass('next-slide');
		prevObj.addClass('prev-slide');
		
		videoSetup();
		
        if (!fs_thmb.hasClass('paused') && currentObj.attr('data-type') == 'image') {
            fs_interval = setInterval('nextSlide()', fs_options.slide_time);
        }		
    }

    /* S E L E C T   S L I D E */
    goToSlide = function (set_slide) {
        clearInterval(fs_interval);
        oldSlide = parseInt(fs_container.find('.current-slide').attr('data-count'));
        thisSlide = set_slide;
		setThmb(thisSlide);

		maxSize = fs_container.find('li').size()-1;
		if((thisSlide+1) > maxSize) {
			nextObj = fs_container.find('.slide0');
			cnextObj = fs_container.find('.slide1');
		} else if ((thisSlide+1) == maxSize){
			nextObj = fs_container.find('.slide'+maxSize);
			cnextObj = fs_container.find('.slide0');
		} else {
			nextObj = fs_container.find('.slide'+(thisSlide+1));
			cnextObj = fs_container.find('.slide'+(thisSlide+2));
		}
		if((thisSlide-1) < 0) {
			prevObj = fs_container.find('.slide'+maxSize);
			cprevObj = fs_container.find('.slide'+(maxSize-1));
		} else if ((thisSlide-1) == 0){					
			prevObj = fs_container.find('.slide0');
			cprevObj = fs_container.find('.slide'+maxSize);
		} else {
			prevObj = fs_container.find('.slide'+(thisSlide-1));
			cprevObj = fs_container.find('.slide'+(thisSlide-2));
		}
        cprevObj.attr('style', '').html('');
		cnextObj.attr('style', '').html('');
		$status_cur.text(thisSlide+1);
		
        $fs_title.fadeOut(300);
        $fs_descr.fadeOut(300, function () {
            $fs_title.html(fs_options.slides[thisSlide].title);
            $fs_descr.html(fs_options.slides[thisSlide].description);
			if (fs_options.slides[thisSlide].description == '') {
				$fs_title.addClass('only_title');
			} else {
				$fs_title.removeClass('only_title');
			}
			
			if (fs_options.slides[thisSlide].title == '') {
				$fs_title.addClass('only_caption');
			} else {
				$fs_title.removeClass('only_caption');
			}

			if (fs_options.slides[thisSlide].description == '' && fs_options.slides[thisSlide].title == '') {
				$fs_title_wrapper.addClass('empty_block');
			} else {
				$fs_title_wrapper.removeClass('empty_block');
			}

            $fs_title.fadeIn(300);
            $fs_descr.fadeIn(300);
        });

        fs_container.find('.fs_slide').attr('style', '');
        fs_container.find('.fs_slide').find('iframe').remove();
        currentObj = fs_container.find('.slide' + thisSlide);
        if (currentObj.attr('data-type') == 'image') {
            currentObj.attr('style', 'background:url(' + currentObj.attr('data-src') + ') no-repeat;');
        } else if (currentObj.attr('data-type') == 'youtube') {
            currentObj.append('<iframe width="100%" height="100%" src="http://www.youtube.com/embed/' + currentObj.attr('data-src') + '?controls=0&autoplay=1&showinfo=0&modestbranding=1&wmode=opaque&rel=0&hd=1&disablekb=1" frameborder="0" allowfullscreen></iframe>');
        } else {
            currentObj.attr('style', 'background:url(' + currentObj.attr('data-bg') + ') no-repeat;');
            currentObj.append(jQuery('<iframe width="100%" height="100%" src="http://player.vimeo.com/video/' + currentObj.attr('data-src') + '?api=1&amp;title=0&amp;byline=0&amp;portrait=0&autoplay=1&loop=0&controls=0&player_id=' + currentObj.attr('data-id') + '" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>').attr('id', currentObj.attr('data-id')));
        }

        jQuery('.current-slide').removeClass('current-slide');
        jQuery('.slide' + thisSlide).addClass('current-slide');

        if (!fs_thmb.hasClass('paused') && currentObj.attr('data-type') == 'image') {
            fs_interval = setInterval('nextSlide()', fs_options.slide_time);
        }
		
        if (nextObj.attr('data-type') == 'image') {
            nextObj.attr('style', 'background:url(' + nextObj.attr('data-src') + ') no-repeat;');
        } else if (nextObj.attr('data-type') == 'youtube') {
            nextObj.attr('style', 'background:url(' + nextObj.attr('data-bg') + ') no-repeat;');
        } else {
            nextObj.attr('style', 'background:url(' + nextObj.attr('data-bg') + ') no-repeat;');
        }

        if (prevObj.attr('data-type') == 'image') {
            prevObj.attr('style', 'background:url(' + prevObj.attr('data-src') + ') no-repeat;');
        } else if (prevObj.attr('data-type') == 'youtube') {
            prevObj.attr('style', 'background:url(' + prevObj.attr('data-bg') + ') no-repeat;');
        } else {
            prevObj.attr('style', 'background:url(' + prevObj.attr('data-bg') + ') no-repeat;');
        }

        jQuery('.current-slide').removeClass('current-slide');
		jQuery('.prev-slide').removeClass('prev-slide');
		jQuery('.next-slide').removeClass('next-slide');

        jQuery('.slide' + thisSlide).addClass('current-slide');
        nextObj.addClass('next-slide');
		prevObj.addClass('prev-slide');
		
		videoSetup();

   }
	function videoSetup() {
        /*SETUP VIDEO*/
        if (myWindow.width() > 1024) {
            if (jQuery('iframe').size() > 0) {
				if (((fs_container.height() + 150) / 9) * 16 > fs_container.width()) {
					jQuery('iframe').height(fs_container.height() + 150).width(((fs_container.height() + 150) / 9) * 16);
					jQuery('iframe').css({
						'margin-left': (-1 * jQuery('iframe').width() / 2) + 'px',
						'top': "-75px",
						'margin-top': '0px'
					});
				} else {
					jQuery('iframe').width(fs_container.width()).height(((fs_container.width()) / 16) * 9);
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
}

jQuery(document).ready(function ($) {
	setGalleryContainer(jQuery('.fs_gallery_container'));
	jQuery('.rbPrev').on({
		mouseenter: function () {
			rb_indicator_left.addClass('indicator_hovered');
		},
		mouseleave: function () {
			rb_indicator_left.removeClass('indicator_hovered');
		}
	});
	jQuery('.rbNext').on({
		mouseenter: function () {
			rb_indicator_right.addClass('indicator_hovered');
		},
		mouseleave: function () {
			rb_indicator_right.removeClass('indicator_hovered');
		}
	});	
});

jQuery(window).resize(function () {
	setGalleryContainer(jQuery('.fs_gallery_container'));
	setw = Math.floor((window_w - (jQuery('.gallery_post_controls').find('a').size()*65) - parseInt(jQuery('.fs_thmb_viewport').css('left'))- parseInt(jQuery('.gallery_post_controls').css('right')))/80)*80;
	jQuery('.fs_thmb_viewport').width(setw);
    if (myWindow.width() > 1024) {
        if (jQuery('iframe').size() > 0) {
            if (((fs_container.height() + 150) / 9) * 16 > fs_container.width()) {
                jQuery('iframe').height(fs_container.height() + 150).width(((fs_container.height() + 150) / 9) * 16);
                jQuery('iframe').css({
                    'margin-left': (-1 * jQuery('iframe').width() / 2) + 'px',
                    'top': "-75px",
                    'margin-top': '0px'
                });
            } else {
                jQuery('iframe').width(fs_container.width()).height(((fs_container.width()) / 16) * 9);
                jQuery('iframe').css({
                    'margin-left': (-1 * jQuery('iframe').width() / 2) + 'px',
                    'margin-top': (-1 * jQuery('iframe').height() / 2) + 'px',
                    'top': '50%'
                });
            }
        }
    } else {
		jQuery('iframe').height(myWindow.height()).width(myWindow.width()).css({
			'top': '0px',
			'margin-left' : '0px',
			'left' : '0px',
			'margin-top': '0px'
		});			
	}
});

function setGalleryContainer(contClass) {
	if (jQuery('#wpadminbar').size() > 0) {
		setHeight = myWindow.height() - header.height() - jQuery('#wpadminbar').height() - footer.height();
		setWidth = myWindow.width() - landing_border_left.width() - landing_border_right.width();
		contClass.width(setWidth).height(setHeight).css('top', header.height() + jQuery('#wpadminbar').height() + 'px');
	} else {
		setHeight = myWindow.height() - header.height() - footer.height();
		setWidth = myWindow.width() - landing_border_left.width() - landing_border_right.width();
		contClass.width(setWidth).height(setHeight).css('top', header.height() + 'px');	
	}
}

function setThmb(cur) {
	allSize = jQuery('.fs_thmb_list').find('.fs_slide_thmb').size()-1;
	jQuery('.thmbPrev2').removeClass('thmbPrev2');
	jQuery('.thmbPrev').removeClass('thmbPrev');
	jQuery('.thmbCurrent').removeClass('thmbCurrent');				
	jQuery('.thmbNext').removeClass('thmbNext');
	jQuery('.thmbNext2').removeClass('thmbNext2');
	
	jQuery('.fs_thmb_list').find('.slide'+cur).addClass('thmbCurrent');
	if((cur+1) > allSize) {
		jQuery('.fs_thmb_list').find('.slide0').addClass('thmbNext');
		jQuery('.fs_thmb_list').find('.slide1').addClass('thmbNext2');
	} else if ((cur+1) == allSize){
		jQuery('.fs_thmb_list').find('.slide'+allSize).addClass('thmbNext');
		jQuery('.fs_thmb_list').find('.slide0').addClass('thmbNext2');					
	} else {
		jQuery('.fs_thmb_list').find('.slide'+(cur+1)).addClass('thmbNext');
		jQuery('.fs_thmb_list').find('.slide'+(cur+2)).addClass('thmbNext2');				
	}
	if((cur-1) < 0) {
		jQuery('.fs_thmb_list').find('.slide'+allSize).addClass('thmbPrev');
		jQuery('.fs_thmb_list').find('.slide'+(allSize-1)).addClass('thmbPrev2');
	} else if ((cur-1) == 0){					
		jQuery('.fs_thmb_list').find('.slide0').addClass('thmbPrev');
		jQuery('.fs_thmb_list').find('.slide'+allSize).addClass('thmbPrev2');
	} else {
		jQuery('.fs_thmb_list').find('.slide'+(cur-1)).addClass('thmbPrev');
		jQuery('.fs_thmb_list').find('.slide'+(cur-2)).addClass('thmbPrev2');
	}
}
