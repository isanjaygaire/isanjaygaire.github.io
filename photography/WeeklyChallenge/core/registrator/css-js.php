<?php

#Frontend
if (!function_exists('css_js_register')) {
    function css_js_register()
    {
        $wp_upload_dir = wp_upload_dir();

        #CSS
        wp_enqueue_style('gt3_default_style', get_bloginfo('stylesheet_url'));
        wp_enqueue_style("gt3_theme", get_template_directory_uri() . '/css/theme.css');
        wp_enqueue_style("gt3_responsive", get_template_directory_uri() . '/css/responsive.css');
        if (gt3_get_theme_option("default_skin") == 'skin_light') {
            wp_enqueue_style('gt3_skin', get_template_directory_uri() . '/css/light.css');
        }
        wp_enqueue_style("gt3_custom", $wp_upload_dir['baseurl'] . "/" . "custom.css");

        #JS
        wp_enqueue_script("jquery");
		wp_enqueue_script('gt3_mousewheel_js', get_template_directory_uri() . '/js/jquery.mousewheel.js', array(), false, true);
		wp_enqueue_script('gt3_swipe_js', get_template_directory_uri() . '/js/jquery.event.swipe.js', array(), false, true);
        wp_enqueue_script('gt3_theme_js', get_template_directory_uri() . '/js/theme.js', array(), false, true);
    }
}
add_action('wp_enqueue_scripts', 'css_js_register');

#Additional files for plugin
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active('woocommerce/woocommerce.php')) {
    if (!function_exists('woo_files')) {
        function woo_files()
        {
			$wp_upload_dir = wp_upload_dir();
			
            wp_enqueue_style('css_woo', get_template_directory_uri() . '/css/woo.css');
            wp_enqueue_script('js_woo', get_template_directory_uri() . '/js/woo.js', array(), false, true);
        }
    }
    add_action('wp_print_styles', 'woo_files');
}

#Admin
add_action('admin_enqueue_scripts', 'admin_css_js_register');
function admin_css_js_register()
{
    #CSS (MAIN)
    wp_enqueue_style('jquery-ui', get_template_directory_uri() . '/core/admin/css/jquery-ui.css');
    wp_enqueue_style('colorpicker_css', get_template_directory_uri() . '/core/admin/css/colorpicker.css');
    wp_enqueue_style('gallery_css', get_template_directory_uri() . '/core/admin/css/gallery.css');
    wp_enqueue_style('colorbox_css', get_template_directory_uri() . '/core/admin/css/colorbox.css');
    wp_enqueue_style('selectBox_css', get_template_directory_uri() . '/core/admin/css/jquery.selectBox.css');
    wp_enqueue_style('admin_css', get_template_directory_uri() . '/core/admin/css/admin.css');
    #CSS OTHER

    #JS (MAIN)
    wp_enqueue_script('admin_js', get_template_directory_uri() . '/core/admin/js/admin.js');
    wp_enqueue_script('ajaxupload_js', get_template_directory_uri() . '/core/admin/js/ajaxupload.js');
    wp_enqueue_script('colorpicker_js', get_template_directory_uri() . '/core/admin/js/colorpicker.js');
    wp_enqueue_script('selectBox_js', get_template_directory_uri() . '/core/admin/js/jquery.selectBox.js');
    wp_enqueue_script('backgroundPosition_js', get_template_directory_uri() . '/core/admin/js/jquery.backgroundPosition.js');
    wp_enqueue_script(array("jquery-ui-core", "jquery-ui-dialog", "jquery-ui-sortable"));
    wp_enqueue_media();
}

#Data for creating static css/js files.
$text_headers_font = gt3_get_theme_option("text_headers_font");

$main_menu_size = gt3_get_theme_option("menu_font_size");
$main_menu_height = substr(gt3_get_theme_option("menu_font_size"), 0, -2);
$main_menu_height = (int)$main_menu_height + 2;
$main_menu_height = $main_menu_height . "px";

$submenu_size = gt3_get_theme_option("submenu_font_size");
$submenu_height = substr(gt3_get_theme_option("submenu_font_size"), 0, -2);
$submenu_height = (int)$main_menu_height + 2;
$submenu_height = $main_menu_height . "px";

$h1_font_size = gt3_get_theme_option("h1_font_size");
$h1_line_height = substr(gt3_get_theme_option("h1_font_size"), 0, -2);
$h1_line_height = (int)$h1_line_height + 2;
$h1_line_height = $h1_line_height . "px";

$h2_font_size = gt3_get_theme_option("h2_font_size");
$h2_line_height = substr(gt3_get_theme_option("h2_font_size"), 0, -2);
$h2_line_height = (int)$h2_line_height + 2;
$h2_line_height = $h2_line_height . "px";

$h3_font_size = gt3_get_theme_option("h3_font_size");
$h3_line_height = substr(gt3_get_theme_option("h3_font_size"), 0, -2);
$h3_line_height = (int)$h3_line_height + 2;
$h3_line_height = $h3_line_height . "px";

$h4_font_size = gt3_get_theme_option("h4_font_size");
$h4_line_height = substr(gt3_get_theme_option("h4_font_size"), 0, -2);
$h4_line_height = (int)$h4_line_height + 2;
$h4_line_height = $h4_line_height . "px";

$h5_font_size = gt3_get_theme_option("h5_font_size");
$h5_line_height = substr(gt3_get_theme_option("h5_font_size"), 0, -2);
$h5_line_height = (int)$h5_line_height + 2;
$h5_line_height = $h5_line_height . "px";

$h6_font_size = gt3_get_theme_option("h6_font_size");
$h6_line_height = substr(gt3_get_theme_option("h6_font_size"), 0, -2);
$h6_line_height = (int)$h6_line_height + 2;
$h6_line_height = $h6_line_height . "px";

$body_bg = gt3_get_theme_option("background_bg");
$breadcrumb_bg = gt3_get_theme_option("breadcrumb_bg");
$sidebar_bg = gt3_get_theme_option("sidebar_bg");
$headings_color = gt3_get_theme_option("headings_color");
$content_color = gt3_get_theme_option("content_color");
$menu_color = gt3_get_theme_option("menu_color");
$submenu_color = gt3_get_theme_option("submenu_color");
$submenu_hover_color = gt3_get_theme_option("submenu_hover_color");
$submenu_active_color = gt3_get_theme_option("submenu_active_color");
$submenu_hover_bg = gt3_get_theme_option("submenu_hover_bg");
$submenu_border = gt3_get_theme_option("submenu_border");
$content_highlight_bg = gt3_get_theme_option("content_highlight_bg");
$content_highlight = gt3_get_theme_option("content_highlight");
$content_highlight_hovered = gt3_get_theme_option("content_highlight_hovered");
$content_borders = gt3_get_theme_option("content_borders");
$light_item_bg = gt3_get_theme_option("light_item_bg");
$light_item_color = gt3_get_theme_option("light_item_color");
$dark_item_bg = gt3_get_theme_option("dark_item_bg");
$dark_item_color = gt3_get_theme_option("dark_item_color");
$price_item_odd = gt3_get_theme_option("price_item_odd");
$price_item_even = gt3_get_theme_option("price_item_even");
$footer_color = gt3_get_theme_option("footer_color");
$theme_color = gt3_get_theme_option("theme_color");
$menu_color_hover = gt3_get_theme_option("menu_color_hover");

$gt3_custom_css = new cssJsGenerator(
    $filename = "custom.css",
    $filetype = "css",
    $output = '
	.fl-container a {
		color:#'. $content_highlight_hovered .';
	}
	.fl-container a:hover {
		color:#'. $content_highlight .';
	}	
	.sidepanel a {
		color:#'. $content_color .';
	}
	.sidepanel a:hover {
		color:#'. $content_highlight_hovered .';
	}	
	body,
	#dm_fullscreen,
	.main_header nav ul.menu .sub-menu,
	.main_header nav ul.menu .sub-menu:before,
	.main_header nav ul.menu .sub-menu:after,
	.main_header.sticky_off,
	.module_diagramm .skill_bar_wrapper span,
	.fullscreen_footer,
	.bg404:before,
	.bg404:after,
	.landing-border-top,
	.landing-border-bottom,
	.landing-border-left,
	.landing-border-right,
	.main_footer,
	.strip-item:before,
	#cols_wrapper:before,
	#cols_wrapper:after,
	.portfolio_boxed,
	.centered_container_wrapper,
	.ribbon_list li,
	.bg_preloader {
		background:#' . $body_bg . ';
	}
	* {
		font-family:' . gt3_get_theme_option("main_font") . ';		
	}	
	p, td, div,
	.contact_info_item a,
	.featured_items_meta .preview_likes span,
	.featured_items_meta .preview_likes i {
		color:#' . $content_color . ';
		font-weight:' . gt3_get_theme_option("content_weight") . ';	
	}
	p {
		margin:0 0 ' . gt3_get_theme_option("p_bottom_margin") . ' 0		
	}
	table, th, td {
		border: #'. $content_borders .' 1px solid;
	}
	.widget_calendar tfoot {
		border-color:#'. $content_borders .';
	}


	input[type="text"],
	input[type="email"],
	input[type="password"],
	textarea {
		border-color:#'. $content_borders .';
		color:#'. $content_highlight .';
		-moz-osx-font-smoothing: grayscale;		
		-webkit-font-smoothing: antialiased;		
	}
	
	input[type="text"]::-webkit-input-placeholder,
	input[type="email"]::-webkit-input-placeholder,
	input[type="password"]::-webkit-input-placeholder,
	textarea::-webkit-input-placeholder {
		color: #'. $content_highlight .';
		-webkit-font-smoothing: antialiased;
	}
	textarea::-moz-placeholder {
		color: #'. $content_highlight .';
		opacity: 1;
		-moz-osx-font-smoothing: grayscale;
	}
	input[type="text"]::-moz-placeholder {
		color: #'. $content_highlight .';
		opacity: 1;
		-moz-osx-font-smoothing: grayscale;
	}
	input[type="email"]::-moz-placeholder {
		color: #'. $content_highlight .';
		opacity: 1;
		-moz-osx-font-smoothing: grayscale;
	}
	input[type="password"]::-moz-placeholder {
		color: #'. $content_highlight .';
		opacity: 1;
		-moz-osx-font-smoothing: grayscale;
	}	
	input[type="text"]:-ms-input-placeholder,
	input[type="email"]:-ms-input-placeholder,
	input[type="password"]:-ms-input-placeholder,
	textarea:-ms-input-placeholder {
		color: #'. $content_highlight .';
	}	
	

	h1, h2, h3, h4, h5, h6,
	h1 span, h2 span, h3 span, h4 span, h5 span, h6 span,
	h1 small, h2 small, h3 small, h4 small, h5 small, h6 small,
	h1 a, h2 a, h3 a, h4 a, h5 a, h6 a,
	.pseudo_stat_count,
	.promoblock_wrapper h2,
	.dropcap,
	.iconbox_wrapper i,
	.countdown-amount,
	.countdown-period,
	.count_ico,
	.woocommerce-result-count,
	.shipping-calculator-button {
		color:#'. $headings_color .';
	}

	/*Fonts Families and Sizes*/
	p, td, div,
	input,
	textarea {
		font-family:' . gt3_get_theme_option("main_font") . ';
		font-weight:' . gt3_get_theme_option("content_weight") . ';
	}

	p, td, div,
	blockquote p {
		font-size:' . gt3_get_theme_option("main_content_font_size") . ';
		line-height:' . gt3_get_theme_option("main_content_line_height") . ';
	}

	h1, h3, h5,
	h1 span, h3 span, h5 span,
	h1 small, h3 small, h5 small,
	h1 a, h3 a, h5 a,
	h1 a:hover, h3 a:hover, h5 a:hover,
	.dropcap {
		font-family: ' . $text_headers_font . ';
		font-weight:' . gt3_get_theme_option("h1_weight") . ';
		-moz-osx-font-smoothing:grayscale;
		-webkit-font-smoothing:antialiased;
		padding:0;
	}
	h2, h4, h6,
	h2 span, h4 span, h6 span,
	h2 small, h4 small, h6 small,
	h2 a, h4 a, h6 a,
	h2 a:hover, h4 a:hover, h6 a:hover,
	.woocommerce-result-count {
		font-family: ' . $text_headers_font . ';
		font-weight:' . gt3_get_theme_option("h2_weight") . ';
		-moz-osx-font-smoothing:grayscale;
		-webkit-font-smoothing:antialiased;
		padding:0;
	}

	.search404.search_form input.field_search,
	.pp_wrapper input[type="password"],
	.preview_read_more,
	.shortcode_button,	
	input[type="button"],
	input[type="reset"],
	input[type="submit"],	
	.notify_shortcode input[type="submit"],
	.notify_shortcode input[type="email"],
	.woocommerce a.button,
	.woocommerce button.button,
	.woocommerce input.button,
	.woocommerce #respond input#submit,
	.woocommerce #content input.button,
	.woocommerce a.edit,
	.woocommerce #commentform #submit,
	.woocommerce-page input.button,
	.woocommerce .wrapper input[type="reset"],
	.woocommerce .wrapper input[type="submit"],
	.woocommerce #respond input#submit, 
	.woocommerce a.button, 
	.woocommerce button.button, 
	.woocommerce input.button,
	.woocommerce table.shop_table thead th {	
		font-family: ' . $text_headers_font . ';
		font-weight:' . gt3_get_theme_option("headings_weight") . ';
		-moz-osx-font-smoothing:grayscale;
		-webkit-font-smoothing:antialiased;	
	}
	.woocommerce #respond input#submit, 
	.woocommerce a.button, 
	.woocommerce button.button, 
	.woocommerce input.button,
	.wc-proceed-to-checkout .checkout-button {	
		font-weight:' . gt3_get_theme_option("h2_weight") . '!important;
	}
	h1, h1 span, h1 a,
	h3.promo_title {
		font-size:' . $h1_font_size . ';
		line-height:' . $h1_line_height . ';
	}
	h2, h2 span, h2 a {
		font-size:' . $h2_font_size . ';
		line-height:' . $h2_line_height . ';
	}
	.bg_title h2 {
		font-size:' . $h1_font_size . ';
		line-height:' . $h1_line_height . ';	
	}
	h3, h3 span, h3 a, h3 a:hover {
		font-size:' . $h3_font_size . ';
		line-height:' . $h3_line_height . ';
	}
	h4, h4 span, h4 a {
		font-size:' . $h4_font_size . ';
		line-height:' . $h4_line_height . ';
	}
	h5, h5 span, h5 a {
		font-size:' . $h5_font_size . ';
		line-height:' . $h5_line_height . ';
	}
	h6, h6 span, h6 a,
	.comment_info h6:after {
		font-size:' . $h6_font_size . ';
		line-height:' . $h6_line_height . ';
	}	
	.category_name {
		font-size:' . $h1_font_size . ';
		line-height:' . $h1_line_height . ';
		font-weight:' . gt3_get_theme_option("h1_weight") . ';		
	}

	.main_header p,
	.main_header td,
	.main_header div,
	.main_header input,
	.main_header textarea {
		color:#'. $headings_color .';
		font-weight:' . gt3_get_theme_option("header_weight") . ';
		font-size:' . gt3_get_theme_option("header_font_size") . ';
		line-height:' . gt3_get_theme_option("header_line_height") . ';		
	}

	.main_header h1,
	.main_header h2,
	.main_header h3,
	.main_header h4,
	.main_header h5,
	.main_header h6,
	.woocommerce table.shop_table thead th {
		color:#'. $headings_color .';		
	}
	
    /* CSS HERE */
	::selection {
		background:#'.$content_highlight_bg.';
		color:#'.$content_color.';
	}
	::-moz-selection {
		background:#'.$content_highlight_bg.';
		color:#'.$content_color.';
	}
	
	/* - - - */
	.main_header nav ul.menu > li > a,
	ul.mobile_menu li a {
		font-size:'. $main_menu_size .';
		line-height:'. $main_menu_height .';
		color:#'. $menu_color .';
	}
	.main_header nav ul.menu > li > a:hover,
	.main_header nav ul.menu > li.current-menu-ancestor > a,
	.main_header nav ul.menu > li.current-menu-item > a,
	.main_header nav ul.menu > li.current-menu-parent > a,
	ul.mobile_menu li.current-menu-ancestor > a,
	ul.mobile_menu li.current-menu-item > a,
	ul.mobile_menu li.current-menu-parent > a,
	ul.mobile_menu li.current-menu-ancestor > a span,
	ul.mobile_menu li.current-menu-item > a span,
	ul.mobile_menu li.current-menu-parent > a span,
	.mobile_menu li.current-menu-parent.menu-item-has-children > a:after,
	.mobile_menu li.current-menu-item.menu-item-has-children > a:after,
	.mobile_menu li.current-menu-ancestor.menu-item-has-children > a:after {
		color:#'. $menu_color_hover .';
	}

	.menu_toggler span,
	.menu_toggler span:before,
	.menu_toggler span:after {
		background:#'. $menu_color .';
	}
	.menu_toggler:hover span,
	.menu_toggler:hover span:before,
	.menu_toggler:hover span:after {
		background:#'. $menu_color_hover .';
	}
	.main_header nav ul.sub-menu > li.current-menu-ancestor > a,
	.main_header nav ul.sub-menu > li.current-menu-item > a,
	.main_header nav ul.sub-menu > li.current-menu-parent > a {
		color:#'. $submenu_active_color .';
	}
	
	.header_cart_content a span	{
		color:#'. $menu_color .';
	}
	.header_cart_content a:hover span	{
		color:#'. $menu_color_hover .';
	}
	
	.main_header nav ul.sub-menu li a {
		font-size:'. $submenu_size .';
		line-height:'. $submenu_height .';
		color:#'. $submenu_color .';
	}
	.main_header nav ul.sub-menu li a:hover {
		color:#'. $submenu_hover_color .';
		background:#'. $submenu_hover_bg .';
	}
	.main_header nav ul.sub-menu li a {
		border-color:#'. $submenu_border .';
	}
	.main_header ul.sub-menu li.menu-item-has-children:before {
		border-color: transparent transparent transparent #'. $submenu_color .';
	}
	.main_header nav ul.sub-menu > li.current-menu-ancestor:before,
	.main_header nav ul.sub-menu > li.current-menu-item:before,
	.main_header nav ul.sub-menu > li.current-menu-parent:before {
		border-color: transparent transparent transparent #'. $submenu_active_color .';
	}	
	.main_header nav ul.sub-menu > li.menu-item-has-children:hover:before {
		border-color: transparent transparent transparent #'. $submenu_color .'!important;
	}
	.main_header ul.sub-menu > li:first-child:after {
		border-color: transparent transparent #'. $submenu_hover_bg .' transparent;	
	}
	footer.main_footer div,
	footer.main_footer span,
	footer.main_footer a {
		color:#'. $footer_color .';
	}
	footer.main_footer a:hover {
		color:#'. $content_highlight .';
	}	
	.back2top {
		background:#'. $dark_item_bg .';
	}
	.back2top:before {
		border-color: transparent transparent #'. $dark_item_color .' transparent;
	}
	.main_header.sticky_on {
		background:rgba(' . gt3_HexToRGB($body_bg) . ',0.95);
	}
	.main_header.sticky_on.fs_header {
		background:rgba(' . gt3_HexToRGB($body_bg) . ',1);
	}
	.breadcrumb_area {
		background:#'. $breadcrumb_bg .';
	}
	.breadcrumbs a, 
	.breadcrumbs span,
	.optionset li,
	.optionset li a,
	.optionset li:before {
		color:#'. $content_highlight .';
	}
	.breadcrumbs a:hover,
	.optionset a:hover,
	.optionset .selected a {
		color:#'. $headings_color .';
	}

	.woo-sidebar-right,
	.woo-sidebar-left,
	.right-sidebar-block,
	.left-sidebar-block {
		background:#'. $sidebar_bg .';
	}

	
	/* Typography */
	.highlighted_light {
		color:#'. $content_color .';
		background:#'. $content_highlight_bg .';
	}
	.highlighted_dark {
		color:#'. $dark_item_color .';
		background:#'. $dark_item_bg .';
	}
	.dropcap {
		color:#'. $content_highlight .';
	}
	.dropcap.type1 {
		color:#'. $content_highlight_hovered .';
	}
	blockquote,
	blockquote.b_light {
		border-color:#'. $content_highlight .';
	}
	blockquote.b_dark {
		border-color:#'. $content_highlight_bg .';
	}
	blockquote .author {
		color:#'. $content_highlight .';
	}	
	blockquote.q_light .author,
	blockquote.q_dark .author {
		color:#'. $headings_color .';
	}
	blockquote.q_light:after {
		color:#'. $content_highlight_bg .';
	}
	blockquote.q_dark:after {
		color:#'. $dark_item_bg .';
	}
	.module_cont hr.type1,
	article.contentarea hr.type1 {
		border-color:#'. $content_highlight_bg .';
	}
	.module_cont hr.type2,
	article.contentarea hr.type2 {
		border-color:#'. $content_highlight .';
	}
	.module_cont hr.type3,
	article.contentarea hr.type3 {
		border-color:#'. $content_highlight_hovered .';
	}
	
	/* Custom Buttons */
	.btn_type5,
	.shortcode_button.btn_type1:hover,
	.shortcode_button.btn_type2:hover,
	.shortcode_button.btn_type3:hover {
		background:#'. $theme_color .';
	}
	
	/* MODULES */
	
	/*accordion*/
	h6.shortcode_accordion_item_title,
	h6.shortcode_toggles_item_title,
	.shortcode_accordion_item_body,
	.shortcode_toggles_item_body {
		border-color:#'. $content_borders .';
	}
	h6.shortcode_accordion_item_title:hover,
	h6.shortcode_toggles_item_title:hover {
		border-color:#'. $dark_item_bg .';
		background:#'. $dark_item_bg .';
		color:#'. $dark_item_color .';
	}
	.shortcode_accordion_item_title.state-active .ico,
	.shortcode_toggles_item_title.state-active .ico {
		border-color: transparent transparent #'. $content_color .' transparent;
	}
	.shortcode_accordion_item_title.state-active:hover .ico,
	.shortcode_toggles_item_title.state-active:hover .ico {
		border-color: transparent transparent #'. $dark_item_color .' transparent;
	}

	.shortcode_accordion_item_title .ico,
	.shortcode_toggles_item_title .ico {
		border-color: #'. $content_color .' transparent transparent transparent;
	}
	.shortcode_accordion_item_title:hover .ico,
	.shortcode_toggles_item_title:hover .ico {
		border-color: #'. $dark_item_color .' transparent transparent transparent;
	}	
	
	/* Featured Items */
	.featured_item_fadder,
	.gallery_fadder {
		background:rgba(' . gt3_HexToRGB($body_bg) . ',0);	
	}
	.img_block:hover .featured_item_fadder,
	.gallery_item_wrapper:hover .gallery_fadder,
	.album_item_img:hover .gallery_fadder {
		background:rgba(' . gt3_HexToRGB($body_bg) . ',0.5);	
	}
	.plus_icon,
	.dm_ctrl_close,
	.ajax_close,
	.dm_slider_prev,
	.dm_slider_next {
		background:#'. $dark_item_bg .';
	}
	.plus_icon:hover,
	.dm_ctrl_close:hover,
	.ajax_close:hover,
	.dm_slider_prev:hover,
	.dm_slider_next:hover {
		background:#'. $dark_item_color .';
	}
	.plus_icon:before,
	.plus_icon:after,
	.ajax_close:before,
	.ajax_close:after,
	.dm_ctrl_close:before,
	.dm_ctrl_close:after {
		background:#'. $dark_item_color .';
	}
	.plus_icon:hover:before,
	.plus_icon:hover:after,
	.ajax_close:hover:before,
	.ajax_close:hover:after,
	.dm_ctrl_close:hover:before,
	.dm_ctrl_close:hover:after {
		background:#'. $dark_item_bg .';
	}
	.featured_items_meta span,
	.featured_items_meta a,
	.module_team .op,
	.featured_items_body h4 a:hover {
		color:#'. $content_highlight .';
	}
	.featured_items_meta a:hover {
		color:#'. $headings_color .';
	}
	.no_feature_img,
	.featured_portfolio_title,
	.gallery_title,
	.dm_more_info {
		background:#'. $dark_item_bg .';
		color:#'. $dark_item_color .';
	}
	.dm_more_info .info_title {	
		color:#'. $dark_item_color .';
	}
	.dm_more_info .info_caption {
		color:#'. $content_highlight .';
	}	
	.no_feature_img:hover {
		background:#'. $dark_item_color .';
		color:#'. $dark_item_bg  .';
	}
	
	/* promo text & tabs */
	.promoblock_wrapper,
	.shortcode_tab_item_title,
	.all_body_cont {
		border-color:#'. $content_borders .';
	}
	.shortcode_tab_item_title:hover {
		color:#'. $content_highlight_bg .';
	}
	.shortcode_tab_item_title.active:before {
		background:#' . $body_bg . ';
	}
	
	.testimonials_footer,
	.testimonials_footer span {
		color:#'. $content_highlight .';
	}
	.module_partners ul li .item_wrapper {
		border-color:#'. $content_borders .';
	}
	.module_partners ul li .item_wrapper a {
		background:rgba(' . gt3_HexToRGB($body_bg) . ',0);
	}
	.module_partners ul li .item_wrapper a:hover {
		background:rgba(' . gt3_HexToRGB($body_bg) . ',0.5);
	}
	
	/* Price Table */
	.price_item_title h6 {
		background:#'. $dark_item_bg .';
		color:#'. $dark_item_color .';
	}
	.item_cost_wrapper,
	.price_item_text,
	.price_item_btn {
		border-color:#'. $content_borders .';
	}
	.price_item_text:before {
		color:#'. $headings_color .'
	}
	.price_item_text:nth-child(even) {
		background:#'. $price_item_odd .';
	}
	.price_item_text:nth-child(odd) {
		background:#'. $price_item_even .';
	}
	.price_item.most_popular .price_item_title h6 {
		background:#'. $theme_color .';
	}
	
	.contact_info_list.is_contact_list .contact_info_item a:hover {
		color:#'.$content_highlight_hovered.';
	}
	/*Pagger*/
	.pagerblock a,
	.page-link a,
	.page-link span {
		color:#'.$content_highlight_hovered.';
	}
	.pagerblock a:hover,
	.pagerblock a.current,
	.page-link a:hover,
	.page-link {
		color:#'.$content_highlight.';
	}
	.pagerblock .prev_pagination span {
		border-color: transparent #'.$content_highlight_hovered.' transparent transparent;
	}
	.pagerblock .next_pagination span {
		border-color: transparent transparent transparent #'.$content_highlight_hovered.';
	}
	.pagerblock .prev_pagination a:hover span {
		border-color: transparent #'.$content_highlight.' transparent transparent;
	}
	.pagerblock .next_pagination a:hover span {
		border-color: transparent transparent transparent #'.$content_highlight.';
	}
	
	/* 404 */
	.title404,
	.subtitle404,
	.text404,
	.search404.search_form input.field_search,
	.pp_wrapper input[type="password"] {	
		color:#'. $headings_color .';
	}
	.bg404_fadder {
		background:rgba(' . gt3_HexToRGB($body_bg) . ',0.7);
	}
	input[type="button"]:hover,
	input[type="reset"]:hover,
	input[type="submit"]:hover,
	.search404 .search_button:hover,
	.notify_shortcode input[type="submit"]:hover,
	.pp_wrapper input[type="submit"]:hover {
		background:#'. $theme_color .';
	}
	
	/* Landing */
	.strip-landing-text {
		background:#'. $dark_item_bg .';
	}
	.strip-landing-text .strip-landing-title {
		color:#'. $dark_item_color .';
	}
	.strip-landing-text a:hover .strip-landing-title,
	.strip-landing-text .strip-landing-caption {
		color:#'. $content_highlight .';
	}	
	
	/* Half Page */
	.half_page_container {
		border-color:#'. $body_bg .';
		background:#'. $light_item_bg .';
	}
	
	/* CountDown */
	.contdown_fadder {
		background:rgba(' . gt3_HexToRGB($body_bg) . ',0.6);
	}
	
	/*Strip*/
	.strip-text {
		background:#'. $dark_item_bg .';
	}
	.strip-text h2 {
		color:#'. $dark_item_color .';
	}
	.strip-text span {
		color:#'. $content_highlight .';
	}
	
	/* Portfolio Shifting */
	.page_indicator,
	.port_shift_text {
		background:#'. $dark_item_bg .';
	}
	.page_indicator,
	.page_indicator i,
	.page_indicator span {
		color:#'. $dark_item_color .';
	}
	
	.port_shift_text h2 a,
	.port_shift_text .preview_likes:hover i,
	.port_shift_text .preview_likes:hover span {
		color:#'. $dark_item_color .';
	}
	.port_shift_text h2 a:hover {
		color:#'. $content_highlight .';
	}
	.port_shift_text span,
	.port_shift_text i {
		color:#'. $content_highlight .';
	}
	
	/* Single Pages */
	.blogpost_share_toggle {
		color:#'. $content_highlight_hovered .';
	}
	.blogpost_share_wrapper:hover .blogpost_share_toggle {
		color:#'. $content_highlight .';
	}
	.single_likes span,
	.single_likes i,
	.tags_area a,
	.tagcloud a {
		color:#'. $content_highlight_hovered .';
	}
	.tags_area a,
	.tagcloud a,
	.blogpost_share,
	.blogpost_share a.top_socials {
		border-color:#'. $content_borders .';
	}
	.tags_area a:hover,
	.tagcloud a:hover {
		color:#'. $dark_item_color .';
		background:#'. $dark_item_bg .';
		border-color:#'. $dark_item_bg .';
	}
	.blogpost_share:before {
		border-color: transparent #'. $content_borders .' transparent transparent;
	}
	.page_navigation .post_prev,
	.page_navigation .post_next {
		border-color:#'. $body_bg .';
		background:#'. $light_item_bg .';
	}
	.page_navigation .post_prev h5,
	.page_navigation .post_next h5,
	.blogpost_share a.top_socials {
		color:#'. $content_highlight_hovered .';
	}
	.page_navigation .post_prev .post_prev_caption,
	.page_navigation .post_next .post_next_caption {
		color:#'. $content_highlight .';
	}

	.page_navigation .post_prev:hover,
	.page_navigation .post_next:hover {
		background:#'. $dark_item_bg .';
	}
	.page_navigation .post_prev:hover h5,
	.page_navigation .post_next:hover h5,
	.page_navigation .post_prev:hover .post_prev_caption,
	.page_navigation .post_next:hover .post_next_caption {
		color:#'. $dark_item_color .';
	}
	.comment-notes,
	.comment-notes span,
	.comment-notes span a,
	.comment_meta span,
	.comment_meta span a,
	.logged-in-as,
	.logged-in-as span,
	.logged-in-as a {
		color:#'. $content_highlight .';
	}
	.comment_meta span a:hover,
	.comment-notes a:hover,
	.logged-in-as a:hover {
		color:#'. $content_highlight_hovered .';
	}
	
	/* Widgets Area */
	.widget_search .search_form:before,
	.widget_product_search .woocommerce-product-search:before {
		color:#'. $content_color .';
	}
	.widget_search .field_search {
		border-color:#'. $content_borders .';
	}
	.widget_product_search .search-field {
		border:1px solid #'. $content_borders .'!important;
	}

	.widget_nav_menu ul li a,
	.widget_archive ul li a,
	.widget_pages ul li a,
	.widget_categories ul li a,
	.widget_recent_entries ul li a,
	.widget_meta ul li a {
		color:#'. $content_color .';
	}
	.widget_nav_menu ul li a:hover,
	.widget_archive ul li a:hover,
	.widget_pages ul li a:hover,
	.widget_categories ul li a:hover,
	.widget_recent_entries ul li a:hover,
	.widget_meta ul li a:hover {	
		color:#'. $content_highlight .';
	}
	.widget_calendar td a {
		color:#'. $content_highlight .';
	}
	.widget_calendar td a:hover {
		color:#'. $content_highlight_hovered .';
	}
	
	/* Ribbon && Fullscreen*/
	.rbPrev,
	.rbNext {
		background:#'. $dark_item_bg.';
	}
	.rbPrev:hover,
	.rbNext:hover {
		background:#'. $light_item_bg.';
	}
	.ribbon_text h2,
	.centered_title .fs_title {
		color:#'. $dark_item_color.';
	}
	.rb_indicator {
		color:#'. $dark_item_color.';
		background:rgba(' . gt3_HexToRGB($dark_item_bg) . ',0.9);
	}
	.fs_title_wrapper,
	.ribbon_text {
		background:rgba(' . gt3_HexToRGB($dark_item_bg) . ',0.9);
	}
	.ribbon_caption,
	.centered_title .fs_descr {
		color:#'. $content_highlight .';
	}
	
	/* Albums */
	.category_name_wrapper,
	.albums-info-wrapper, 
	.albums-info-wrapper:before,
	.albums-info-wrapper:after {
		background:#'. $light_item_bg .';
	}
	.albums-info-content article,
	.albums-info-content p,
	.albums-info-content span {
		color:#'. $light_item_color .';
	}
	.category_name {
		category_name:#'. $light_item_bg .';
	}
	.albums_title,
	.flow_descr_block {
		background:#'. $dark_item_bg .';
		color:#'. $dark_item_color .';
	}
	.flow_descr_block h2,
	.flow_descr_block h2 a {
		color:#'. $dark_item_color .';
	}
	.flow_descr_block h2 a:hover {
		color:#'. $content_highlight .';
	}
	.bg_slider:before {
		background:rgba(' . gt3_HexToRGB($body_bg) . ',0.9);
	}
	.flow_item .flow_descr_block span {
		color:#'. $content_highlight .';
	}
	#ajax_slider:before,
	#ajax_slider:after,
	#ajax_slider li,
	#ajax_slider {
		background-color:#'. $body_bg .';
	}
	.flow_filter li a {
		color:#'. $content_highlight_hovered .';
	}	
	.flow_filter li a:hover,
	.recent_posts_content a:hover {
		color:#'. $content_highlight .';
	}
	.recent_posts_content .featured_items_meta a:hover {
		color:#'. $content_color .';
	}
	.flow_filter li.selected a {
		background:#'. $dark_item_bg .';
		color:#'. $dark_item_color .';
	}
	
	/* WOO Classes */
	.woocommerce select {
		color:#'. $content_highlight .'!important;
		border-color:#'. $content_borders .'!important;
	}
	
	.woocommerce a.button,
	.woocommerce button.button,
	.woocommerce input.button,
	.woocommerce #respond input#submit,
	.woocommerce #content input.button,
	.woocommerce a.edit,
	.woocommerce #commentform #submit,
	.woocommerce-page input.button,
	.woocommerce .wrapper input[type="reset"],
	.woocommerce .wrapper input[type="submit"],
	.woocommerce .widget_price_filter .price_slider_amount .button {
		background:#'. $dark_item_bg .'!important;
		color:#'. $dark_item_color .'!important;
	}
	.woocommerce a.button:hover,
	.woocommerce button.button:hover,
	.woocommerce input.button:hover,
	.woocommerce #respond input#submit:hover,
	.woocommerce #content input.button:hover,
	.woocommerce a.edit:hover,
	.woocommerce #commentform #submit:hover,
	.woocommerce-page input.button:hover,
	.woocommerce .wrapper input[type="reset"]:hover,
	.woocommerce .wrapper input[type="submit"]:hover,
	.woocommerce .widget_price_filter .price_slider_amount .button:hover {
		background:#'. $theme_color .'!important;
	}
	.my_product_meta span,
	.my_product_meta span a {
		color:#'. $content_highlight .'!important;
	}
	.my_product_meta span a:hover {
		color:#'. $content_highlight_hovered .'!important;
	}
	nav.woocommerce-pagination ul.page-numbers li span,
	nav.woocommerce-pagination ul.page-numbers li a {
		color:#'.$content_highlight_hovered.';
	}
	nav.woocommerce-pagination ul.page-numbers li span.current,
	nav.woocommerce-pagination ul.page-numbers li a:hover {
		color:#'.$content_highlight.';
	}
	.next.page-numbers:before {
		border-color: transparent transparent transparent #'.$content_highlight_hovered.';
	}
	.prev.page-numbers:before {
		border-color: transparent #'.$content_highlight_hovered.' transparent transparent;
	}	
	.next.page-numbers:hover:before {
		border-color: transparent transparent transparent #'.$content_highlight.';
	}
	.prev.page-numbers:hover:before {
		border-color: transparent #'.$content_highlight.' transparent transparent;
	}	

	.sidepanel.widget_product_categories ul li a {
		color:#'. $content_color .';
	}
	.sidepanel.widget_product_categories ul li a:hover {	
		color:#'. $content_highlight_hovered .';
	}
	
	.summary.entry-summary .price del .amount,
	.summary.entry-summary .price del,
	.summary.entry-summary .price del span {
		font-size:' . $h3_font_size . '!important;
		line-height:' . $h3_line_height . '!important;
		font-family: ' . $text_headers_font . '!important;
		font-weight:' . gt3_get_theme_option("h2_weight") . '!important;
	}
	.summary.entry-summary .price .amount,
	.summary.entry-summary .price ins,
	.summary.entry-summary .price ins span {
		font-size:' . $h2_font_size . '!important;
		line-height:' . $h2_line_height . '!important;
		font-family: ' . $text_headers_font . '!important;
		font-weight:' . gt3_get_theme_option("h1_weight") . '!important;
	}
	.summary.entry-summary .price .amount,
	.summary.entry-summary .price del,
	.summary.entry-summary .price del span,
	.summary.entry-summary .price ins,
	.summary.entry-summary .price ins span {
		-moz-osx-font-smoothing:grayscale;
		-webkit-font-smoothing:antialiased;
		padding:0;
		color:#'. $headings_color .';
		
	}
	.product_title.entry-title {
		font-family: ' . $text_headers_font . '!important;
		font-weight:' . gt3_get_theme_option("h2_weight") . '!important;
		font-size:' . $h2_font_size . '!important;
		line-height:' . $h2_line_height . '!important;		
		-moz-osx-font-smoothing:grayscale;
		-webkit-font-smoothing:antialiased;
		padding:0;
	}
	
	.woocommerce .summary.entry-summary button.single_add_to_cart_button {
		background:#'. $dark_item_bg .'!important;
		color:#'. $dark_item_color .'!important;
	}
	.woocommerce .summary.entry-summary button.single_add_to_cart_button:hover {
		background:#'. $theme_color .'!important;
	}
	.woocommerce div.product .woocommerce-tabs .panel,
	.woocommerce #content div.product .woocommerce-tabs .panel,
	.woocommerce .quantity input.qty, 
	.woocommerce #content .quantity input.qty,
	.woocommerce #reviews #commentform input[type="text"],
	.woocommerce #reviews #commentform input[type="text"]:focus,
	.woocommerce #reviews #commentform textarea,
	.woocommerce #reviews #commentform textarea:focus,
	.woocommerce .woocommerce_message, .woocommerce .woocommerce_error, .woocommerce .woocommerce_info,
	.woocommerce .woocommerce-message, .woocommerce .woocommerce-error, .woocommerce .woocommerce-info,
	.woocommerce table.shop_table th,
	.woocommerce table.shop_table td,
	.woocommerce-cart table.cart td.actions .coupon .input-text {
		border:1px solid #'. $content_borders .'!important;
	}
	.summary .product_meta span,
	.summary .product_meta span a {
		font-family: ' . $text_headers_font . '!important;
		font-weight:' . gt3_get_theme_option("h6_weight") . '!important;
		font-size:' . $h6_font_size . '!important;
		line-height:' . $h6_line_height . '!important;		
	}
	.summary .product_meta span,
	.summary .product_meta a,
	.my_comment_meta span,
	.my_comment_meta a {
		color:#'. $content_highlight .';
	}
	.summary .product_meta > span,
	.summary .product_meta a:hover {
		color:#'. $content_highlight_hovered .';
	}
	.woocommerce label,
	.cart-collaterals .cart_totals span,
	.cart-collaterals .cart_totals table,
	.cart-collaterals .cart_totals td,
	.cart-collaterals .cart_totals tr,
	.cart-collaterals .cart_totals th {
		color:#'. $content_highlight_hovered .';
	}
	.woocommerce div.product .woocommerce-tabs ul.tabs li,
	.widget_product_tag_cloud a,
	.woocommerce #billing_phone,
	.select2-drop.select2-drop-above.select2-drop-active, 
	.select2-container .select2-choice, 
	.select2-drop-active,
	.woocommerce table.shop_table, 
	.woocommerce-page table.shop_table {
		border:1px #'. $content_borders .' solid!important;
	}
	.widget_product_tag_cloud a:hover {
		border:1px #'. $dark_item_bg .' solid!important;
	}
	.woocommerce table.cart a.remove:after,
	.woocommerce #content table.cart a.remove:after,
	.woocommerce table.cart a.remove:before,
	.woocommerce #content table.cart a.remove:before {
		background:#'. $content_highlight_hovered .'!important;
	}
	.woocommerce table.cart a.remove:hover:after,
	.woocommerce #content table.cart a.remove:hover:after,
	.woocommerce table.cart a.remove:hover:before,
	.woocommerce #content table.cart a.remove:hover:before {
		background:#'. $content_highlight .'!important;
	}
	
	/* Widgets */
	.woo_wrap ul.cart_list li a,
	.woo_wrap ul.product_list_widget li a,
	.main_container ul.cart_list li a,
	.main_container ul.product_list_widget li a,
	.woocommerce ul.product_list_widget li a,
	.woo_wrap ul.cart_list li span,
	.woo_wrap ul.product_list_widget li span,
	.main_container ul.cart_list li span,
	.main_container ul.product_list_widget li span,
	.woocommerce ul.product_list_widget li span,
	.widget_shopping_cart_content .total span,
	.widget_shopping_cart_content .total,
	.widget_shopping_cart_content .total strong,
	.lost_password a {
		color:#'. $content_highlight_hovered .';
		font-weight:' . gt3_get_theme_option("content_weight") . ';	
	}
	.woo_wrap ul.cart_list li .amount,
	.woo_wrap ul.product_list_widget li .amount,
	.main_container ul.cart_list li .amount,
	.main_container ul.product_list_widget li .amount,
	.woocommerce ul.product_list_widget li .amount,
	.cart_list.product_list_widget .quantity,
	.lost_password a:hover {
		color:#'. $content_highlight .';
		font-weight:' . gt3_get_theme_option("content_weight") . ';	
	}
	.product_list_widget .reviewer {
		color:#'. $content_highlight .'!important;
	}
	.shop_top_side .widget_price_filter .ui-slider .ui-slider-handle:before,
	.shop_top_side .widget_price_filter .ui-slider .ui-slider-handle:after {
		color:#'. $content_highlight_hovered .';
	}
	.woocommerce_container ul.products li.product a h3:hover, 
	.woocommerce ul.products li.product a h3:hover {
		color:#'. $content_highlight .'!important;
	}
	.woocommerce a {
		color:#'. $content_highlight_hovered .';
	}
	.woocommerce a:hover {
		color:#'. $content_highlight .';
	}
	.woocommerce .breadcrumbs a {
		color:#'. $content_highlight .';
	}
	.woocommerce .breadcrumbs a:hover {
		color:#'. $content_highlight_hovered .';
	}
	.woocommerce div.product .woocommerce-tabs ul.tabs li a {
		color:#'. $content_highlight_hovered .'!important;
	}
	.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover {
		color:#'. $content_highlight .'!important;
	}
	.woocommerce div.product .woocommerce-tabs ul.tabs li.active a {
		color:#'. $content_highlight_hovered .'!important;
	}
	.woocommerce a.remove {
		color:#'. $content_highlight_hovered .'!important;
	}
	.woocommerce a.remove:hover {
		color:#'. $content_highlight .'!important;
	}
    '
);
?>