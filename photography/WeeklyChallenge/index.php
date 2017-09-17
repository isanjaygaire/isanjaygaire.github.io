<?php get_header();
#Emulate default settings for page without personal ID
$gt3_theme_pagebuilder = gt3_get_default_pb_settings();
global $wp_query_in_shortcodes, $paged;
wp_enqueue_script('gt3_cookie_js', get_template_directory_uri() . '/js/jquery.cookie.js', array(), false, true);

if (!isset($gt3_theme_pagebuilder['settings']['show_title']) || $gt3_theme_pagebuilder['settings']['show_title'] !== "no") {
	$title = 'yes';
} else {
	$title = 'no';
}
if ((!isset($gt3_theme_pagebuilder['settings']['show_breadcrumb_area']) || $gt3_theme_pagebuilder['settings']['show_breadcrumb_area'] !== "no") && gt3_get_theme_option("show_breadcrumb_area") !== "no") {
	$bc = 'yes';
} else {
	$bc = 'no';
}
if ($title == 'yes' || $bc == 'yes') { ?>
    <div class="breadcrumb_area">
    	<div class="container">
			<?php if ($title == 'yes') { ?>
                <div class="page_title_block">
                    <h1 class="title"><?php the_title(); ?></h1>
                </div>
            <?php } 
            if ($bc == 'yes') {
                gt3_the_breadcrumb(); 
            } ?>
        </div>
    </div>
<?php } ?>
<div class="content_wrapper">
	<div class="container is_page <?php echo esc_attr($gt3_theme_pagebuilder['settings']['layout-sidebars']) ?>">    
        <div class="content_block row">
			<div class="fl-container <?php echo(($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "right-sidebar") ? "hasRS" : ""); ?>">
                <div class="row">
                    <div class="posts-block <?php echo($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "hasLS" : ""); ?>">                    
                        <div class="contentarea">
							<?php while (have_posts()) : the_post();
                                get_template_part("bloglisting");
                            endwhile;
							wp_reset_postdata();
							echo "<div class='default_listing'>";
							gt3_get_theme_pagination();
							echo "</div>";
							?>
                           
                        </div>
                    </div>
                    <?php get_sidebar('left'); ?>
                </div>
            </div>
            <?php get_sidebar('right'); ?>
        </div>
    </div>
</div>

<script>
	jQuery(document).ready(function(){
		setUpWindow();
	});
	jQuery(window).load(function(){
		setUpWindow();
	});
	jQuery(window).resize(function(){
		setUpWindow();
		setTimeout('setUpWindow()',500);
		setTimeout('setUpWindow()',1000);
	});
	function setUpWindow() {
		main_wrapper.css('min-height', window_h-parseInt(site_wrapper.css('padding-top')) - parseInt(site_wrapper.css('padding-bottom'))+'px');
	}
</script>

<?php get_footer(); ?>