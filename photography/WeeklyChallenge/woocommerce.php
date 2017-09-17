<?php 
if ( !post_password_required() ) {
get_header();
$gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
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
if (gt3_get_theme_option("woo_listing") == 'simple' || is_singular( 'product' )) {
	$container_class = 'container';
} else {
	$container_class = 'fs_container';
}

if ($title == 'yes' || $bc == 'yes') { ?>
    <div class="breadcrumb_area">
    	<div class="<?php echo $container_class; ?>">
			<?php if ($title == 'yes') { ?>
                <div class="page_title_block">
                    <h1 class="title"><?php esc_html_e('Shop', 'geographic'); ?></h1>
                </div>
            <?php } 
            if ($bc == 'yes') {
                gt3_the_breadcrumb(); 
            } ?>
        </div>
    </div>
<?php } ?>

<?php 
if (gt3_get_theme_option("woo_listing") == 'simple' || is_singular( 'product' )) { ?>
<div class="content_wrapper simple_woo_content">
	<div class="container is_page <?php echo esc_attr($gt3_theme_pagebuilder['settings']['layout-sidebars']) ?>">    
        <div class="content_block row">
            <div class="fl-container <?php echo(($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "right-sidebar") ? "hasRS" : ""); ?>">
                <div class="row">
                    <div class="posts-block <?php echo($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "hasLS" : ""); ?>">                    
                        <div class="contentarea">
                        	<div class="hide_me sorting_text"><?php echo esc_html__('Sorting', 'geographic'); ?></div>
                            <?php
							woocommerce_content();
                            wp_link_pages(array('before' => '<div class="page-link">' . esc_html__('Pages', 'geographic') . ': ', 'after' => '</div>'));
                            if (gt3_get_theme_option('page_comments') == "enabled") {?>
                            <hr class="comment_hr"/>
                            <div class="row">
                                <div class="span12">
                                    <?php comments_template(); ?>
                                </div>
                            </div>							
                            <?php }?>							
                        </div>
                    </div>
                    <?php get_sidebar('woo-left'); ?>
                </div>
            </div>
            <?php get_sidebar('woo-right'); ?>
        </div>
    </div>
</div>
<?php } else { ?>
<div class="fs_woo_content woocommerce_container woocommerce_fullscreen">
    <div class="contentarea">
        <div class="shop_top_side">
        	<div class="def_shop_sorting"></div>
        	<?php dynamic_sidebar('WooCommerce Fullscreen Top Widgets'); ?>            
            <div class="woo_def_sort_info"><h6><?php echo esc_html__('Sorting', 'geographic'); ?></h6></div>
        </div>                
        <?php
        woocommerce_content();
        wp_link_pages(array('before' => '<div class="page-link">' . esc_html__('Pages', 'geographic') . ': ', 'after' => '</div>')); ?>
    </div>
</div>
<?php }
	get_footer();
} else {
	get_header('fullscreen');
?>
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