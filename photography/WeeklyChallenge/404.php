<?php
get_header('fullscreen'); ?>
    <div class="wrapper404 unloaded">
        <div class="container404">
            <h1 class="title404"><?php echo esc_html__('404', 'geographic'); ?></h1>
            <h2 class="subtitle404"><?php echo esc_html__('OOPS! NOT FOUND!', 'geographic'); ?></h2>
            <div class="text404"><?php echo esc_html__('It looks like nothing was found at this location. Maybe start from the homepage or do a quick search?', 'geographic'); ?></div>
            <form name="search_field" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search_form search404">
                <input type="text" name="s" value="" class="field_search" placeholder="<?php esc_html_e('Type to Search...', 'geographic'); ?>">
                <a href="<?php echo esc_js("javascript:document.search_field.submit()"); ?>" class="search_button"><?php esc_html_e('search the site', 'geographic'); ?></a>
            </form>            
            <div class="clear"></div>
        </div>
    </div>
    <div class="bg404" style="background-image:url(<?php echo gt3_the_theme_option("bg_404"); ?>)">
    	<span class="bg404_fadder"></span>
    </div>
    <script>
        var wrapper404 = jQuery('.wrapper404');
        jQuery(document).ready(function () {
            centerWindow();
			jQuery('.custom_bg').remove();
            setTimeout('wrapper404.removeClass("unloaded")', 350);
        });
        jQuery(window).load(function () {
            centerWindow();
        });
        jQuery(window).resize(function () {
            setTimeout('centerWindow()', 500);
            setTimeout('centerWindow()', 1000);
        });
        function centerWindow() {
            set404Top = -1 * (wrapper404.height() / 2);
            wrapper404.css('margin-top', set404Top + 'px');
        }
    </script>
<?php get_footer('fullscreen'); ?>