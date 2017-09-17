<?php
/*
Template Name: Coming Soon
*/
if (!post_password_required()) {
    ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <head>
        <meta http-equiv="Content-Type"
              content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
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
        wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>

<?php
$gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
wp_enqueue_script('gt3_countdown', get_template_directory_uri() . '/js/jquery.countdown.min.js', array(), false, true);
if (isset($gt3_theme_pagebuilder['countdown']['year'])) $year = esc_attr($gt3_theme_pagebuilder['countdown']['year']);
if (isset($gt3_theme_pagebuilder['countdown']['day'])) $day = esc_attr($gt3_theme_pagebuilder['countdown']['day']);
if (isset($gt3_theme_pagebuilder['countdown']['month'])) $month = esc_attr($gt3_theme_pagebuilder['countdown']['month']);
?>
	<?php if ($gt3_theme_pagebuilder['settings']['show_logo'] == 'on') { ?>
    <div class="countdown_logo_wrapper">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="menu_logo countdown_logo"><img
                src="<?php gt3_the_theme_option("logo"); ?>" alt=""
                width="<?php gt3_the_theme_option("logo_standart_width"); ?>"
                height="<?php gt3_the_theme_option("logo_standart_height"); ?>" class="logo_def"><img
                src="<?php gt3_the_theme_option("logo_retina"); ?>" alt=""
                width="<?php gt3_the_theme_option("logo_standart_width"); ?>"
                height="<?php gt3_the_theme_option("logo_standart_height"); ?>" class="logo_retina"></a>
        <?php } ?>
    </div>

    <div class="global_count_wrapper fadeOnLoad">
        <?php if (!isset($gt3_theme_pagebuilder['settings']['show_title']) || $gt3_theme_pagebuilder['settings']['show_title'] !== "no") { ?>
            <div class="count_title"><h1><?php the_title(); ?></h1></div>
        <?php } 
		if (isset($year) && isset($day) && isset($month) && $year !== "" && $day !== "" && $month !== "") { ?>
            <script>
               jQuery(function () {
                    var austDay = new Date();
                    austDay = new Date(<?php echo esc_attr($year); ?>, <?php echo esc_attr($month) ?>-1, <?php echo esc_attr($day) ?>);
                    jQuery('#countdown').countdown({until: austDay});
                });
            </script>
            <div class="countdown_wrapper">
                <div id="countdown">
					<!-- <span class="countdown-row countdown-show4">
                    	<span class="countdown-section">
                        	<span class="countdown-amount">05</span>
                            <span class="countdown-period">Days</span>
						</span>
                        <span class="countdown-section">
                            <span class="countdown-amount">13</span>
                            <span class="countdown-period">Hours</span>
						</span>
                        <span class="countdown-section">
                        	<span class="countdown-amount">46</span>
                            <span class="countdown-period">Minutes</span>
						</span>
                        <span class="countdown-section">
                        	<span class="countdown-amount">27</span>
                            <span class="countdown-period">Seconds</span>
						</span>
					</span> .Debug -->
                </div>
            </div>
        <?php } else { ?>
            <h1 class="count_error"><?php esc_html_e('Date has not been entered', 'geographic') ?></h1>
        <?php } 
		if (isset($gt3_theme_pagebuilder['countdown']['shortcode']) && $gt3_theme_pagebuilder['countdown']['shortcode'] !== '') { ?>
            <div class="count_container_wrapper">
                <div class="count_container">
                    <div class="form_area">
                        <?php if (isset($gt3_theme_pagebuilder['countdown']['shortcode']) && $gt3_theme_pagebuilder['countdown']['shortcode'] !== '') {
                            echo "<div class='notify_shortcode'>" . (is_gt3_builder_active() ? do_shortcode($gt3_theme_pagebuilder['countdown']['shortcode']) : '') . "<div class='clear'></div></div>";
                        } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    
    <div class="countdown_footer">
        <?php if (isset($gt3_theme_pagebuilder['page_settings']['icons'])) {
            $ico_compile = '<div class="soc_icons">';
            foreach ($gt3_theme_pagebuilder['page_settings']['icons'] as $key => $value) {
                if ($value['link'] == '') $value['link'] = '#';
                $ico_compile .= '<a href="' . $value['link'] . '" class="count_ico" title="' . $value['name'] . '"><span><i class="' . $value['data-icon-code'] . '"></i></span></a>';
            }
            $ico_compile .= "</div>";
            echo $ico_compile;				
        } ?>            
        <div class="countdown_copyright"><?php echo esc_html(gt3_the_theme_option("copyright")); ?></div>
    </div>
    
    <div class="contdown_fadder"></div>
	<?php gt3_the_pb_custom_bg_and_color(gt3_get_theme_pagebuilder(@get_the_ID())); ?>
    <script>
        var global_counter = jQuery('.global_count_wrapper'),
			cout_footer = jQuery('.countdown_footer'),
			count_logo = jQuery('.countdown_logo_wrapper'),
			settop, logotop;
		
        jQuery(document).ready(function () {
            centerWindow();
        });
        jQuery(window).resize(function () {
            setTimeout('centerWindow()', 500);
            setTimeout('centerWindow()', 1000);
        });
        function centerWindow() {
			settop = (myWindow.height() - cout_footer.height() - parseInt(cout_footer.css('bottom')) - global_counter.height())/2;
			logotop = (settop - count_logo.height())/2;
            global_counter.css('top', settop + 'px');
			count_logo.css('top', logotop + 'px');
        }
    </script>

    <?php get_footer('none');
} else { ?>
    <div class="pp_block unloaded">
        <h1 class="pp_title"><?php  esc_html_e('This Content is Password Protected', 'geographic') ?></h1>
        <div class="pp_wrapper">
            <?php the_content(); ?>
        </div>
    </div>
    <div class="landing-border-left"></div>
    <div class="landing-border-right"></div>    
    <div class="bg404" style="background-image:url(<?php echo gt3_the_theme_option("bg_img"); ?>)">
    	<span class="bg404_fadder"></span>
    </div>    
    <script>
		jQuery(document).ready(function(){
			jQuery('.post-password-form').find('label').find('input').attr('placeholder', 'Enter The Password...');
			setTimeout('jQuery(".pp_block").removeClass("unloaded")',350);
		});
	</script>
<?php 
	get_footer('fullscreen');
} ?>