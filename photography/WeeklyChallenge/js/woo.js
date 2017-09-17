"use strict";
var shop_top_side = jQuery('.shop_top_side'),
	woo_billing = jQuery('.woocommerce-billing-fields');

jQuery(document).ready(function(){
	if (shop_top_side.size() > 0) {
		if (jQuery('.woocommerce_fullscreen .woocommerce-ordering').size() > 0) {
			var def_sort = jQuery('.woocommerce_fullscreen .woocommerce-ordering').html();
			var sort_def_name = shop_top_side.find('.woo_def_sort_info').html();
			jQuery('.woocommerce_fullscreen').find('.def_shop_sorting').append('<div class="sort_field_name">'+sort_def_name+'</div><form method="get" class="woocommerce-ordering">'+def_sort+'</form>');
		}
		jQuery('.product_added_cart').css({'margin-left': - jQuery('.product_added_cart').width()/2 + 'px'});
		jQuery('.add_to_cart_button').on('click', function(){
			if (jQuery(this).hasClass("product_type_simple")) {
				jQuery('.product_added_cart').addClass('show_info');
			}
			setTimeout(function() {
				jQuery('.product_added_cart').removeClass('show_info');
			}, 1000);											
		});
	}
	
	// Checkout
	if (woo_billing.size() > 0) {
		var p_email = woo_billing.find('#billing_email_field'),
			p_phone = woo_billing.find('#billing_phone_field'),
			p_email_html = p_email.html(),
			p_email_class = p_email.attr('class'),
			p_phone_html = p_phone.html(),
			p_phone_class = p_phone.attr('class');
		p_email.remove();
		p_phone.remove();
		woo_billing.append("<p id='billing_email_field' class='"+p_email_class+"'>"+p_email_html+"</p><p id='billing_phone_field' class='"+p_phone_class+"'>"+p_phone_html+"</p>")
	}
});

// Woocommerce Price Filter
if (jQuery('.price_slider_wrapper').size() > 0) {
	setInterval(function woopricefilter() {
		"use strict";
		var price_from = jQuery('.price_slider_amount').find('span.from').text();
		var price_to = jQuery('.price_slider_amount').find('span.to').text();
		
		jQuery('.price_slider').find('.ui-slider-handle').first().attr('data-width', price_from);
		jQuery('.price_slider').find('.ui-slider-handle').last().attr('data-width-r', price_to);
		
	}, 100);
}

// Woocommerce Cart
if (jQuery('.woocommerce-cart').size() > 0) {
	setInterval(function cart_update() {
		"use strict";	
		var window_h = jQuery(window).height(),
			wrapper_h = jQuery('.wrapper').height(),
			header_h = jQuery('header').height(),
			footer_h = jQuery('footer').height(),
			fake_space = window_h - header_h - footer_h - wrapper_h;
		if (fake_space < 113) {
			jQuery('footer').addClass('static_footer');
		} else {
			jQuery('footer').removeClass('static_footer');
		}	
	}, 100);
}

jQuery(document).ready(function(){
	"use strict";	
	setup_main_wrapper();
	
	if (jQuery('.simple_woo_content').size() > 0) {
		jQuery('.simple_woo_content').find('.woocommerce-ordering').prepend('<h6>'+ jQuery('.sorting_text').html() +'</h6>');		
	}
	if (jQuery('.woocommerce_container').size() > 0) {
		var p_title = jQuery('.woocommerce_container').find('h1.page-title').html();
		if (jQuery('.summary').size() > 0) {		
		} else {
			jQuery('.bc_area h1.entry-title, .bc_area .breadcrumbs span').empty();
			jQuery('.bc_area h1.entry-title, .bc_area .breadcrumbs span').append(p_title);
		}					
	}
	// Products Meta
	jQuery('.woocommerce ul.products li.product').each(function(){
		var woo_meta_cat = jQuery(this).find(".product_meta .posted_in a").html();
		var woo_meta_cat_href = jQuery(this).find(".product_meta .posted_in a").attr('href');
		var woo_meta_price = jQuery(this).find("span.price").html();	
		var woo_meta_add2cart_href = jQuery(this).find("a.add_to_cart_button").attr('href');
		var woo_meta_add2cart_text = jQuery(this).find("a.add_to_cart_button").html();
		if(typeof woo_meta_price !== 'undefined') {
			jQuery(this).find('.woo_product_meta').prepend('<div class="woo_product_price">'+woo_meta_price+'</div>');										
		}
		if(typeof woo_meta_cat !== 'undefined') {
			jQuery(this).find('.woo_product_meta').prepend('<div class="woo_product_category">'+woo_meta_cat+'</div>');										
		}
		jQuery(this).find('.product_meta').after('<div class="my_product_meta"><span class="my_product_category"><a href="'+ woo_meta_cat_href +'" rel="tag">'+ woo_meta_cat +'</a></span><span class="middot">&middot;</span><span class="my_product_price">'+ woo_meta_price +'</span><span class="middot">&middot;</span><span class="my_add2cart_span"><a class="my_add2cart" href="'+ woo_meta_add2cart_href +'">'+woo_meta_add2cart_text+'</a></span></div>');
	});
	//Pagger
	jQuery('.next.page-numbers').html('');
	jQuery('.prev.page-numbers').html('');
	
	// Thumbs Hover	
	jQuery('.woocommerce ul.products li.product, .woocommerce .images .thumbnails a, .woocommerce .images .woocommerce-main-image').each(function(){										
		if (jQuery(this).find('.onsale').size() > 0) {
			var onSaleHTML = '<span class="onsale">' + jQuery(this).find('.onsale').html() + '</span>';
			jQuery(this).find('.onsale').remove();
			jQuery(this).find('.onsale').html();
		} else {
			onSaleHTML = '';
		}
		jQuery(this).find("img").wrapAll('<div class="woo_hover_img"></div>').before(onSaleHTML).after('<span class="plus_icon"></span>');		
	});
		 
	// Woocommerce Fullscreen
	if (jQuery('.woocommerce_fullscreen').size() > 0) {
		if(jQuery('.woocommerce_fullscreen').parents('body').hasClass('single-product')) {			
		} else {
			jQuery('.woocommerce_fullscreen').parents('body').find('.bc_area .container').addClass('fullwith_container');
		}		
		jQuery('.single-product .woocommerce_fullscreen').find('.product').addClass('container pt6');
	}
	
	//Comments
	jQuery('.comment-text').each(function(){
		var author_name = jQuery(this).find('strong[itemprop="author"]').html(),
			comment_date = jQuery(this).find('time[itemprop="datePublished"]').html(),
			star_html = jQuery(this).find('.star-rating').html();
		jQuery(this).prepend('<div class="my_comment_meta"><span class="my_meta_author">'+ author_name +'</span><span class="middot">&middot;</span><span class="my_meta_time">'+ comment_date +'</span><span class="middot">&middot;</span><div class="star-rating">'+ star_html +'</div></div>')
	});
	
});

jQuery(window).load(function(){
	"use strict";
	// Woocommerce
	jQuery(".woocommerce-page .widget_price_filter .price_slider").wrap("<div class='price_filter_wrap'></div>");	
	jQuery("#tab-additional_information .shop_attributes").wrap("<div class='additional_info'></div>");	
	jQuery(".shop_table.cart").wrap("<div class='woo_shop_cart'></div>");
	setup_main_wrapper();
});

jQuery(window).resize(function(){
	"use strict";
	setup_main_wrapper();
});

function setup_main_wrapper() {
	var set_min_height = myWindow.height() - header.height() - footer.height();
	main_wrapper.css('min-height', set_min_height + 'px');
}