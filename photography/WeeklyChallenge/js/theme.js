"use strict";
var header = jQuery('.main_header'),    
	header_h = header.height(),
	footer = jQuery('.main_footer'),
    nav = jQuery('nav.main_nav'),
    menu = nav.find('ul.menu'),
    main_li = menu.children('li'),
    html = jQuery('html'),
    body = jQuery('body'),
	myWindow = jQuery(window),
    window_h = myWindow.height(),
    window_w = myWindow.width(),
    main_wrapper = jQuery('.main_wrapper'),
    main_wrapper_min = window_h - header_h,
    site_wrapper = jQuery('.site_wrapper'),
    is_masonry = jQuery('.is_masonry'),
    grid_portfolio_item = jQuery('.grid-portfolio-item'),
    pp_block = jQuery('.pp_block'),
	fl_container = jQuery('.fl-container'),
	socials_wrapper = jQuery('.socials_wrapper'),
	landing_border_left = jQuery('.landing-border-left'),
	landing_border_right = jQuery('.landing-border-right'),
	breadcrumb_area = jQuery('.breadcrumb_area'),
    fs_min = 0,
    map_h = 0,
	top_cart = jQuery('.header_cart_content'),
	half_page_container = jQuery('.half_page_container'),
    prImg = [];
if (body.hasClass('admin-bar')) {
    header_h = header.height() + parseInt(header.css('padding-top')) + parseInt(header.css('padding-bottom')) + jQuery('#wpadminbar').height();
}

jQuery(document).ready(function ($) {
    if (jQuery('.is_page').size() > 0) {
        site_wrapper.addClass('page_wrapper');
    }
    jQuery('.menu a').each(function () {
        if (jQuery(this).attr('href') == '#') {
            jQuery(this).attr('href', 'javascript:void(0)');
        }
    });
	
	if (myWindow.scrollTop() > 0) {
		jQuery('.back2top').removeClass('hide2top');
	} else {
		jQuery('.back2top').addClass('hide2top');
	}
	myWindow.on('scroll', function(){
		if (myWindow.scrollTop() > 0) {
			jQuery('.back2top').removeClass('hide2top');
		} else {
			jQuery('.back2top').addClass('hide2top');
		}
	});
	jQuery('.back2top').on('click', function(){
		jQuery('html, body').stop().animate({scrollTop: 0}, 400, function(){
			jQuery('.back2top').addClass('hide2top');
		});		
	});
	
	if (socials_wrapper.find('li').size() > 0) {
		socials_wrapper.width(socials_wrapper.find('li').size() * 40); 
		jQuery('.socials_list').width(socials_wrapper.find('li').size() * 40);
	}
	jQuery('.socials_toggler').on('click',function(){
		socials_wrapper.toggleClass('socials_closed');
		nav.toggleClass('nav_closed');
		top_cart.toggleClass('cart_closed');
	});

    if (jQuery('.fadeOnLoad').size() > 0) {
        setTimeout("jQuery('.fadeOnLoad').animate({'opacity' : '1'}, 500)", 500);
    }

    if (body.hasClass('admin-bar') && window_w > 760) {

    }
    if (window_w < 760 && jQuery('.module_content').size() > 0) {
        jQuery('.module_content').each(function () {
            if (jQuery.trim(jQuery(this).html()) == '') {
                jQuery(this).parent('.module_cont').addClass('empty_module');
            }
        });
    }

    content_update();
    //Flickr Widget
    if (jQuery('.flickr_widget_wrapper').size() > 0) {
        jQuery('.flickr_badge_image a').each(function () {
            jQuery(this).append('<div class="flickr_fadder"></div>');
        });
    }

    //Main and Mobile Menu
    //header.find('.header_wrapper').append('<a href="javascript:void(0)" class="menu_toggler"></a>');
	if (header.size() > 0) {
		header.append('<div class="mobile_menu_wrapper"><ul class="mobile_menu container"/></div>');
		jQuery('.mobile_menu').html(nav.find('ul.menu').html());
		jQuery('.mobile_menu_wrapper').hide();
		jQuery('.menu_toggler').on('click', function () {
			jQuery('.mobile_menu_wrapper').slideToggle(300);
			jQuery('.main_header').toggleClass('opened');
		});
	}
    if (pp_block.size() > 0) {
        html.addClass('pp_page');
        pp_center();
    }

    // P R E L O A D E R //
    if (jQuery('.bg_preloader').size() > 0) {
        //setTimeout("jQuery('.preloader').addClass('start_preloader')",500); //DEBUG ANIMATION
		if (jQuery('.fs_preloader').size() > 0) {
			setTimeout('preImg(fsImg)', 300);
		} else {
			jQuery('.img2preload').each(function () {
				prImg.push(jQuery(this).attr('src'));
			});
			jQuery('.block2preload').each(function () {
				prImg.push(jQuery(this).attr('data-src'));
			});
			setTimeout('preImg(prImg)', 300);
		}
    }

    //AdminBar
    if (jQuery('#wpadminbar').size() > 0) {
        html.addClass('hasAdminBar');
    }
	
	if (jQuery('.more-link').size() > 0) {
		jQuery('.more-link').each(function(){
			jQuery(this).before('<br class="clear"/>')
		});
	}
	
	if (jQuery('.right_bc_area').size() > 0) {
		var rbca = jQuery('.right_bc_area');
		if (!rbca.hasClass('.filter_only')) {
			var settop = (jQuery('.left_bc_area').height() - rbca.height())/2;
			rbca.css('padding-top', (Math.floor(settop)-2) +'px');
		}
	}
});

function preImg(imgArray) {
    if (imgArray.length > 0) {
        var perStep = 100 / imgArray.length,
            percent = 0,
            line1 = jQuery('.preloader_line_bar1'),
            line2 = jQuery('.preloader_line_bar2');
        //console.log(imgArray.length +';'+perStep+';'+perStep*imgArray.length); //DEBUG SCRIPT
        for (var i = 0; i < imgArray.length; i++) {
            (function (img, src) {
                img.onload = function () {
                    percent = (i * perStep) / 2;
                    //console.log('PerStep:'+ perStep +'.' + percent + '% loaded'); //DEBUG SCRIPT
                    //console.log(img + ' loaded.'); //DEBUG SCRIPT
                    line1.css('width', percent + '%');
                    line2.css('width', percent + '%');
                    if (percent >= 49) {
                        removePreloader();
                    }
                };
                img.src = src;
            }(new Image(), imgArray[i]));
        }
    } else {
        setTimeout("removePreloader()", 2500);
    }
}
function removePreloader() {
    setTimeout("jQuery('.bg_preloader').addClass('removePreloader')", 450);
    setTimeout("jQuery('.bg_preloader').remove()", 1200);
    if (jQuery('.ribbon_list').size() > 0) {
        updateSlide();
        setTimeout("updateSlide()", 300);
    }
}

jQuery(window).resize(function () {
    window_h = myWindow.height();
    window_w = myWindow.width();
	setup_menu();
    if (body.hasClass('admin-bar')) {
    }
    content_update();
});

jQuery(window).load(function () {
	setup_menu();
    window_h = myWindow.height();
    window_w = myWindow.width();
    content_update();
});

function content_update() {
	if (jQuery('.sticky_on').size() > 0) {
		jQuery('.header_holder').height(header.height());
	}
    if (window_w > 760) {
        if (body.hasClass('admin-bar')) {

        }
    }
}
function setup_menu() {
	if (jQuery('.menu_cell').height() > myWindow.height()) { } else {
		jQuery('.menu_cell').css('top', '0px');
	}
}

function gt3_get_blog_posts(post_type, posts_count, posts_already_showed, template_name, content_insert_class, categories, set_pad) {
    jQuery.post(gt3_ajaxurl, {
        action: "gt3_get_blog_posts",
        post_type: post_type,
        posts_count: posts_count,
        posts_already_showed: posts_already_showed,
        template_name: template_name,
        content_insert_class: content_insert_class,
        categories: categories,
        set_pad: set_pad
    })
        .done(function (data) {
            if (data.length < 1) {
                jQuery(".fs_blog_loadmore").fadeOut("fast");
            }			
            jQuery(content_insert_class).append(data);
            if (jQuery('.this_is_blog').size() > 0) {
                jQuery('.pf_output_container').each(function () {
                    if (jQuery(this).html() == '') {
                        jQuery(this).parents('.fw_preview_wrapper').addClass('no_pf');
                    } else {
                        jQuery(this).parents('.fw_preview_wrapper').addClass('has_pf');
                    }
                });
            }
            if (jQuery('.fw-portPreview-content').size() > 0) {
                port_setup();
            }
            if (is_masonry.size() > 0) {
                is_masonry.masonry('reloadItems');
                is_masonry.masonry();
            }
            if (jQuery('.fs_grid_portfolio').size() > 0) {
                grid_portfolio_item.unbind();
                grid_portfolio_item.on({
                    mouseover: function () {
                        jQuery(this).removeClass('unhovered');
                        jQuery(this).find('.grid-item-trigger').css('height', jQuery(this).find('img').height() + jQuery(this).find('.fs-port-cont').height());
                    },
                    mouseout: function () {
                        jQuery(this).addClass('unhovered');
                        jQuery(this).find('.grid-item-trigger').css('height', jQuery(this).find('img').height());
                    }
                });
            }
            iframe16x9(jQuery('.fs_blog_module'));
            if (jQuery('.newLoaded').find('.pf_output_container').size() > 0) {
                setTimeout("jQuery('.pf_output_container').animate({'opacity' : '1'}, 1000)", 500);
            }
            jQuery('.newLoaded').each(function () {
                jQuery(this).find('.gallery_likes_add').on('click', function () {
                    var gallery_likes_this = jQuery(this);
                    if (!jQuery.cookie(gallery_likes_this.attr('data-modify') + gallery_likes_this.attr('data-attachid'))) {
                        jQuery.post(gt3_ajaxurl, {
                            action: 'add_like_attachment',
                            attach_id: jQuery(this).attr('data-attachid')
                        }, function (response) {
                            jQuery.cookie(gallery_likes_this.attr('data-modify') + gallery_likes_this.attr('data-attachid'), 'true', {
                                expires: 7,
                                path: '/'
                            });
                            gallery_likes_this.addClass('already_liked');
                            gallery_likes_this.find('i').removeClass('icon-heart-o').addClass('icon-heart');
                            gallery_likes_this.find('span').text(response);
                        });
                    }
                });
                jQuery(this).removeClass('newLoaded');
            });
            setTimeout("animateList()", 300);
			
			jQuery('.fs_blog_loadmore').on('click', function(){
				get_works();
			});			

            jQuery('.fs_port_item').on('hover', function () {
                html.addClass('fadeMe');
                jQuery(this).addClass('unfadeMe');
            }, function () {
                html.removeClass('fadeMe');
                jQuery(this).removeClass('unfadeMe');
            });
        });
}

function gt3_get_portfolio(post_type, posts_count, posts_already_showed, template_name, content_insert_class, categories, set_pad, post_type_field) {
    jQuery.post(gt3_ajaxurl, {
        action: "get_portfolio_works",
        post_type: post_type,
        posts_count: posts_count,
        posts_already_showed: posts_already_showed,
        template_name: template_name,
        content_insert_class: content_insert_class,
        categories: categories,
        set_pad: set_pad,
        post_type_field: post_type_field
    })
        .done(function (data) {
            jQuery(content_insert_class).append(data);
            if (jQuery('.this_is_blog').size() > 0) {
                jQuery('.pf_output_container').each(function () {
                    if (jQuery(this).html() == '') {
                        jQuery(this).parents('.fw_preview_wrapper').addClass('no_pf');
                    } else {
                        jQuery(this).parents('.fw_preview_wrapper').addClass('has_pf');
                    }
                });
            }
            if (jQuery('.fw-portPreview-content').size() > 0) {
                port_setup();
            }
            if (is_masonry.size() > 0) {
                is_masonry.masonry('reloadItems');
                is_masonry.masonry();
            }
            if (jQuery('.fs_grid_portfolio').size() > 0) {
                grid_portfolio_item.unbind();
                grid_portfolio_item.on({
                    mouseover: function () {
                        jQuery(this).removeClass('unhovered');
                        jQuery(this).find('.grid-item-trigger').css('height', jQuery(this).find('img').height() + jQuery(this).find('.fs-port-cont').height());
                    },
                    mouseout: function () {
                        jQuery(this).addClass('unhovered');
                        jQuery(this).find('.grid-item-trigger').css('height', jQuery(this).find('img').height());
                    }
                });
            }
            jQuery('.newLoaded').each(function () {
                jQuery(this).find('.gallery_likes_add').on('click', function () {
                    var gallery_likes_this = jQuery(this);
                    if (!jQuery.cookie(gallery_likes_this.attr('data-modify') + gallery_likes_this.attr('data-attachid'))) {
                        jQuery.post(gt3_ajaxurl, {
                            action: 'add_like_attachment',
                            attach_id: jQuery(this).attr('data-attachid')
                        }, function (response) {
                            jQuery.cookie(gallery_likes_this.attr('data-modify') + gallery_likes_this.attr('data-attachid'), 'true', {
                                expires: 7,
                                path: '/'
                            });
                            gallery_likes_this.addClass('already_liked');
                            gallery_likes_this.find('i').removeClass('icon-heart-o').addClass('icon-heart');
                            gallery_likes_this.find('span').text(response);
                        });
                    }
                });
                jQuery(this).removeClass('newLoaded');
            });
            iframe16x9(jQuery('.fs_blog_module'));
            setTimeout("animateList()", 300);
            myWindow.on('scroll', scrolling);
            jQuery('.fs_port_item').on('hover', function () {
                html.addClass('fadeMe');
                jQuery(this).addClass('unfadeMe');
            }, function () {
                html.removeClass('fadeMe');
                jQuery(this).removeClass('unfadeMe');
            });
        });
}

function gt3_get_isotope_posts(post_type, posts_count, posts_already_showed, template_name, content_insert_class, categories, set_pad, post_type_field) {
    jQuery.post(gt3_ajaxurl, {
        action: "get_portfolio_works",
        post_type: post_type,
        posts_count: posts_count,
        posts_already_showed: posts_already_showed,
        template_name: template_name,
        content_insert_class: content_insert_class,
        categories: categories,
        set_pad: set_pad,
        post_type_field: post_type_field
    })
        .done(function (data) {
            if (data.length < 1) {
                jQuery(".load_more_works").slideUp(300);
            }
            var $newItems = jQuery(data);
            jQuery(content_insert_class).isotope('insert', $newItems, function () {
                jQuery(content_insert_class).ready(function () {
                    jQuery(content_insert_class).isotope('reLayout');
                });
                if (jQuery('.fs-port-cont').size() > 0) {
                    setTimeout('jQuery(".fs_grid_portfolio").isotope("reLayout");', 1500);
                }
            });
            jQuery('.newLoaded').each(function () {
                jQuery(this).find('.gallery_likes_add').on('click', function () {
                    var gallery_likes_this = jQuery(this);
                    if (!jQuery.cookie(gallery_likes_this.attr('data-modify') + gallery_likes_this.attr('data-attachid'))) {
                        jQuery.post(gt3_ajaxurl, {
                            action: 'add_like_attachment',
                            attach_id: jQuery(this).attr('data-attachid')
                        }, function (response) {
                            jQuery.cookie(gallery_likes_this.attr('data-modify') + gallery_likes_this.attr('data-attachid'), 'true', {
                                expires: 7,
                                path: '/'
                            });
                            gallery_likes_this.addClass('already_liked');
                            gallery_likes_this.find('i').removeClass('icon-heart-o').addClass('icon-heart');
                            gallery_likes_this.find('span').text(response);
                        });
                    }
                });
				jQuery('.fs_port_loadmore').on('click', function(){
					get_works();
				});				
                jQuery(this).removeClass('newLoaded');
            });
        });
}

function animateList() {
    jQuery('.loading:first').removeClass('loading').animate({'z-index': '15'}, 200, function () {
        animateList();
        if (is_masonry.size() > 0) {
            is_masonry.masonry();
        }
    });
};

function workCheck() {
    if (jQuery('.fs_blog_module').height() < parseInt(fullscreen_block.css('min-height'))) {
        get_works();
    } else {
        fullscreen_block.addClass('cheked');
    }
}

function scrolling() {
    if (jQuery('.fullscreen_blog').size() > 0) {
        var target = jQuery('.fullscreen_blog');
    } else if (jQuery('.fw_grid_gallery').size() > 0) {
        var target = jQuery('.fw_grid_gallery');
    }
    else {
        var target = jQuery('body');
    }
    var chk_height = target.height() - jQuery(this).height() - header.height() - 100;
    if (jQuery(this).scrollTop() >= chk_height) {
        jQuery(this).unbind("scroll");
        get_works();
    }
}

function iframe16x9(container) {
    container.find('iframe').each(function () {
        jQuery(this).height((jQuery(this).width() / 16) * 9);
    });
}

var setTop = 0;
function pp_center() {
	jQuery('.cont_menu_btn').removeClass('.cont_menu_btn').addClass('fs_menu_btn');
    var pp_block = jQuery('.pp_block');
    setTop = -1 * (pp_block.height() / 2);
    pp_block.css('margin-top', setTop + 'px');
}