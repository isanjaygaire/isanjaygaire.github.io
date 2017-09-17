<?php
$gt3page_settings = gt3_get_theme_pagebuilder(@get_the_ID());
$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="fullscreen">
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
    <?php echo((gt3_get_theme_option("responsive") == "on") ? '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">' : ''); ?>
	<?php
    if (function_exists('has_site_icon') && has_site_icon()) {
    ?>
        <link rel="shortcut icon" href="<?php echo aq_resize(get_site_icon_url(), "32", "32", true, true, true); ?>" type="image/x-icon">
        <link rel="apple-touch-icon" href="<?php echo aq_resize(get_site_icon_url(), "57", "57", true, true, true); ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo aq_resize(get_site_icon_url(), "72", "72", true, true, true); ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo aq_resize(get_site_icon_url(), "114", "114", true, true, true); ?>">
    <?php
    } else {
    ?>
        <link rel="shortcut icon" href="<?php echo gt3_get_theme_option('favicon'); ?>" type="image/x-icon">
        <link rel="apple-touch-icon" href="<?php echo gt3_get_theme_option('apple_touch_57'); ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo gt3_get_theme_option('apple_touch_72'); ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo gt3_get_theme_option('apple_touch_114'); ?>">
    <?php
    }
    ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <script type="text/javascript">
        var gt3_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>
    <?php echo gt3_get_if_strlen(gt3_get_theme_option("custom_css"), "<style>", "</style>") . gt3_get_if_strlen(gt3_get_theme_option("code_before_head"));
    globalJsMessage::getInstance()->render();
    wp_head();
    ?>
</head>

<body <?php body_class(array(gt3_the_pb_custom_bg_and_color(gt3_get_theme_pagebuilder(@get_the_ID()), array("classes_for_body" => true)))); ?>>
<div class="header_holder sticky_on"></div>
<header class="main_header sticky_on fs_header">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="menu_logo"><img
            src="<?php gt3_the_theme_option("logo"); ?>" alt=""
            width="<?php gt3_the_theme_option("logo_standart_width"); ?>"
            height="<?php gt3_the_theme_option("logo_standart_height"); ?>" class="logo_def"><img
            src="<?php gt3_the_theme_option("logo_retina"); ?>" alt=""
            width="<?php gt3_the_theme_option("logo_standart_width"); ?>"
            height="<?php gt3_the_theme_option("logo_standart_height"); ?>" class="logo_retina"></a>
	<div class="header_right">
        <nav class="main_nav">
			<?php wp_nav_menu(array('theme_location' => 'main_menu', 'menu_class' => 'menu', 'depth' => '3', 'walker' => new gt3_menu_walker($showtitles = false))); ?>
        </nav>
		<?php if (is_plugin_active('woocommerce/woocommerce.php')) { ?>
			<div class="header_cart_content">
			   <?php global $woocommerce; ?>
               <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'theme_localization'); ?>"><div class="total_price"><?php echo $woocommerce->cart->get_cart_total(); ?><span class="price_count"><?php echo sprintf(_n('(%d item)', '(%d items)', $woocommerce->cart->cart_contents_count, 'theme_localization'), $woocommerce->cart->cart_contents_count);?></span></div></a>
            </div>
        <?php } ?>        
        <div class="socials">
            <div class="socials_wrapper socials_closed">
                <?php echo gt3_show_social_icons(array(
                    array(
                        "uniqid" => "social_facebook",
                        "class" => "ico_social_facebook",
                        "title" => "Facebook",
                        "target" => "_blank",
                    ),
                    array(
                        "uniqid" => "social_pinterest",
                        "class" => "ico_social_pinterest",
                        "title" => "Pinterest",
                        "target" => "_blank",
                    ),
                    array(
                        "uniqid" => "social_twitter",
                        "class" => "ico_social_twitter",
                        "title" => "Twitter",
                        "target" => "_blank",
                    ),
                    array(
                        "uniqid" => "social_instagram",
                        "class" => "ico_social_instagram",
                        "title" => "Instagram",
                        "target" => "_blank",
                    ),
                    array(
                        "uniqid" => "social_tumblr",
                        "class" => "ico_social_tumblr",
                        "title" => "Tumblr",
                        "target" => "_blank",
                    ),
                    array(
                        "uniqid" => "social_flickr",
                        "class" => "ico_social_flickr",
                        "title" => "Flickr",
                        "target" => "_blank",
                    ),
                    array(
                        "uniqid" => "social_youtube",
                        "class" => "ico_social_youtube",
                        "title" => "Youtube",
                        "target" => "_blank",
                    ),
                    array(
                        "uniqid" => "social_dribbble",
                        "class" => "ico_social_dribbble",
                        "title" => "Dribbble",
                        "target" => "_blank",
                    ),
                    array(
                        "uniqid" => "social_gplus",
                        "class" => "ico_social_gplus",
                        "title" => "Google+",
                        "target" => "_blank",
                    ),
                    array(
                        "uniqid" => "social_vimeo",
                        "class" => "ico_social_vimeo",
                        "title" => "Vimeo",
                        "target" => "_blank",
                    ),
                    array(
                        "uniqid" => "social_delicious",
                        "class" => "ico_social_delicious",
                        "title" => "Delicious",
                        "target" => "_blank",
                    ),
                    array(
                        "uniqid" => "social_linked",
                        "class" => "ico_social_linked",
                        "title" => "Linked In",
                        "target" => "_blank",
                    )
                ));
                ?>
            </div>
			<a href="<?php echo esc_js("javascript:void(0)"); ?>" class="socials_toggler"></a>            
        </div><!-- .socials -->
        <a href="<?php echo esc_js("javascript:void(0)"); ?>" class="menu_toggler"><span class="menu_toggler_ico"></span></a>
        <div class="clear"></div>
	</div>
    <div class="clear"></div>
</header>
