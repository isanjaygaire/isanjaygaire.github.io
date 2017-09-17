<?php 
/*
Template Name: Portfolio Listing
*/
if ( !post_password_required() ) {
get_header('fullscreen');
the_post();

$gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
$pf = get_post_format();
wp_enqueue_script('gt3_cookie_js', get_template_directory_uri() . '/js/jquery.cookie.js', array(), false, true);

if (isset($gt3_theme_pagebuilder['portfolio']['port_type']) && $gt3_theme_pagebuilder['portfolio']['port_type'] == 'port_isotope') {
	wp_enqueue_script('gt3_isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array(), false, true);
	wp_enqueue_script('gt3_isotope_sorting', get_template_directory_uri() . '/js/sorting.js', array(), false, true);
} else {
	wp_enqueue_script('gt3_masonry_js', get_template_directory_uri() . '/js/masonry.min.js', array(), false, true);
	wp_enqueue_script('gt3_endlessScroll_js', get_template_directory_uri() . '/js/jquery.endless-scroll.js', array(), false, true);
}
$setPad = '0px';
$hasFilter = '';

if (isset($gt3_theme_pagebuilder['settings']['cat_ids']) && (is_array($gt3_theme_pagebuilder['settings']['cat_ids']))) {
	$compile_cats = array();
	foreach ($gt3_theme_pagebuilder['settings']['cat_ids'] as $catkey => $catvalue) {
		array_push($compile_cats, $catkey);
	}
	$selected_categories = implode(",", $compile_cats);
}
if (isset($gt3_theme_pagebuilder['portfolio']['port_style'])){
	$port_style = $gt3_theme_pagebuilder['portfolio']['port_style'];
} else {
	$port_style = 'port_style_grid';
}

$aq_width = "570px";
$aq_height = "430px";

if ($port_style == "port_style_grid") {
	$aq_width = "570px";
	$aq_height = "430px";
} 
if ($port_style == "port_style_2col") {
	$aq_width = "960px";
	$aq_height = "700px";
} 
if ($port_style == "port_style_3col") {
	$aq_width = "640px";
	$aq_height = "480px";
} 
if ($port_style == "port_style_4col") {
	$aq_width = "570px";
	$aq_height = "430px";
} 

$post_type_terms = array();
$post_type_filter = array();
if (isset($selected_categories) && strlen($selected_categories) > 0) {
	$post_type_terms = explode(",", $selected_categories);
	$post_type_filter = explode(",", $selected_categories);
	$post_type_field = "id";
} else {
	$post_type_field = "slug";
}

$wp_query_in_shortcodes = new WP_Query();
$args = array(
	'post_type' => 'port',
	'order' => 'DESC',
	'paged' => $paged,
	'posts_per_page' => gt3_get_theme_option('fw_port_per_page')
);

if (isset($_GET['slug']) && strlen($_GET['slug']) > 0) {
	$post_type_terms = esc_attr($_GET['slug']);
	$selected_categories = esc_attr($_GET['slug']);
	$post_type_field = "slug";
}
if (count($post_type_terms) > 0) {
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'portcat',
			'field' => $post_type_field,
			'terms' => $post_type_terms
		)
	);
}	
			
if (!isset($gt3_theme_pagebuilder['fs_portfolio']['filter']) || $gt3_theme_pagebuilder['fs_portfolio']['filter'] == 'on') {
	$hasFilter = 'has_filter';
} 
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

if ($bc == 'no' && $title == 'no' && $hasFilter == 'has_filter') {
	$filter_class = 'filter_only';
} else {
	$filter_class = '';
}
if ($title == 'yes' || $bc == 'yes' || $hasFilter == 'has_filter') { ?>
    <div class="breadcrumb_area">
    	<div class="fs_breadcrumb_area">
        	<div class="left_bc_area">
			<?php if ($title == 'yes') { ?>
                <div class="page_title_block">
                    <h1 class="title"><?php the_title(); ?></h1>
                </div>
				<?php } 
                if ($bc == 'yes') {
                    gt3_the_breadcrumb();
                } ?>
   			</div>
            <div class="right_bc_area <?php echo $filter_class; ?>" >
				<?php 
                if ($hasFilter == 'has_filter') {
                    $compile = showPortCats($post_type_filter);
                    echo $compile;
                } ?>            
            </div>
            <div class="clear"></div>
        </div>
    </div>
<?php } ?>
	<?php if (gt3_get_theme_option("show_preloader") == 'on') { ?>
        <div class="bg_preloader">
            <div class="preloader more"></div>
        </div>
    <?php } ?>
    <div class="portfolio-listing <?php echo $hasFilter; echo " " . $port_style; ?> fadeOnLoad">   
        <style>
			.fw-portPreview {
				padding:0 <?php echo $setPad; ?> <?php echo $setPad; ?> 0;
			}
			.fw_grid_gallery .fw_grid_item {
				width:25%;
			}
		</style>  
        <div class="fw_grid_module is_masonry fs_grid_portfolio <?php echo $hasFilter; ?>" style="padding-top:<?php echo $setPad; ?>; margin-left:<?php echo $setPad; ?>;">  
<?php 
			global $wp_query_in_shortcodes, $paged;
			
			if(empty($paged)){
				$paged = (get_query_var('page')) ? get_query_var('page') : 1;
			}			
		?>
		<?php 
	        $wp_query_in_shortcodes->query($args);			
	        while ($wp_query_in_shortcodes->have_posts()) : $wp_query_in_shortcodes->the_post();
				$all_likes = gt3pb_get_option("likes");
				$gt3_theme_post = get_plugin_pagebuilder(get_the_ID());
				$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
				$featured_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
				$pf = get_post_format();
                $target = (isset($gt3_theme_post['settings']['new_window']) && $gt3_theme_post['settings']['new_window'] == "on" ? "target='_blank'" : "");
				if (isset($gt3_theme_post['page_settings']['portfolio']['work_link']) && strlen($gt3_theme_post['page_settings']['portfolio']['work_link']) > 0) {
					$linkToTheWork = esc_url($gt3_theme_post['page_settings']['portfolio']['work_link']);
				} else {
					$linkToTheWork = get_permalink();
				}
				$echoallterm = '';
				$echoallterm2 = '';
				$portCateg = '';
				$new_term_list = get_the_terms(get_the_id(), "portcat");
                if (is_array($new_term_list)) {
                    foreach ($new_term_list as $term) {
                        $tempname = strtr($term->name, array(
                            ' ' => '-',
                        ));
                        $echoallterm .= strtolower($tempname) . ", ";
						$echoallterm2 .= strtolower($tempname) . " ";
						$portCateg .= $tempname . ", ";
                        $echoterm = $term->name;
                    }
                } else {
                    $portCateg = 'Uncategorized  ';
                }
				$portCateg = substr($portCateg, 0, -2);
				$photoTitle = get_the_title();				
			?>            
            <?php if (isset($gt3_theme_pagebuilder['portfolio']['port_type']) && $gt3_theme_pagebuilder['portfolio']['port_type'] == 'port_isotope') { ?>
			<div <?php post_class("portfolio-listing-item element ". $echoallterm2); ?> data-category="<?php echo $echoallterm2 ?>">
            <?php } else { ?>
			<div <?php post_class("portfolio-listing-item"); ?>>
			<?php } ?>
                <div class="portfolio_item_block">
                    <div class="portfolio_item_wrapper">
	                    <a target="<?php echo $target ?>" href="<?php echo $linkToTheWork ?>">
                            <div class="img_block wrapped_img">                            
                                <img src="<?php echo aq_resize($featured_image[0], $aq_width, $aq_height, true, true, true) ?>" alt="<?php echo $featured_alt ?>">
                                <div class="featured_item_fadder"></div>
                                <span class="plus_icon"></span>
                                <span class="featured_portfolio_title"><?php echo get_the_title(); ?></span>
                            </div>
                        </a>
                    </div>						
                </div>
			</div><!-- .fw_grid_item -->  
		<?php endwhile; 
			wp_reset_postdata();
		?>
	</div>
	<?php if (isset($gt3_theme_pagebuilder['portfolio']['port_type']) && $gt3_theme_pagebuilder['portfolio']['port_type'] == 'port_isotope') { ?>
        <a href="<?php echo esc_js("javascript:void(0)");?>" class="load_more_works shortcode_button btn_type4 btn_large"><?php esc_html_e('Load More', 'geographic') ?></a>            
    <?php }?>            
</div>

    <script>
		jQuery(document).ready(function() {
			jQuery('.custom_bg').remove();
		});

		jQuery(window).load(function($){
		});	

		jQuery(window).resize(function($){
		});
		
        var posts_already_showed = <?php gt3_the_theme_option('fw_port_per_page'); ?>,
			<?php if (isset($selected_categories) && strlen($selected_categories) > 0) {
				echo 'categories = "'. $selected_categories .'"';
			} else {
				echo 'categories = ""';
			}?>

	<?php if (isset($gt3_theme_pagebuilder['portfolio']['port_type']) && $gt3_theme_pagebuilder['portfolio']['port_type'] == 'port_isotope') {?>
        function get_works() {
            gt3_get_isotope_posts("port", <?php gt3_the_theme_option('fw_port_per_page'); ?>, posts_already_showed, "port_listing_isotope", ".fw_grid_module ", categories, '<?php echo $port_style; ?>', '<?php echo $post_type_field; ?>');
            posts_already_showed = posts_already_showed + <?php gt3_the_theme_option('fw_port_per_page'); ?>;
        }
        jQuery(document).ready(function () {
            jQuery('.load_more_works').on("click",function(){
				get_works();
			});
        });
	<?php } else { ?>
        function get_works() {
            <?php if (gt3_get_theme_option("demo_server") == "true") { ?> if (posts_already_showed > 18) {posts_already_showed = 0;} <?php } ?>
            gt3_get_portfolio("port", <?php gt3_the_theme_option('fw_port_per_page'); ?>, posts_already_showed, "port_listing", ".fw_grid_module ", categories, '<?php echo $port_style; ?>', '<?php echo $post_type_field; ?>');
            posts_already_showed = posts_already_showed + <?php gt3_the_theme_option('fw_port_per_page'); ?>;
        }	

		jQuery(function() {
		  jQuery(document).endlessScroll({
			bottomPixels: 250,
			fireDelay: 500,
			callback: function() {
				get_works();
			}
		  });
		});
        jQuery(document).ready(function () {
			jQuery('.is_masonry').masonry();
			setTimeout("jQuery('.is_masonry').masonry();",1000);
        });
        jQuery(window).load(function () {
			jQuery('.is_masonry').masonry();
			setTimeout("jQuery('.is_masonry').masonry();",1000);
        });
        jQuery(window).resize(function () {
			jQuery('.is_masonry').masonry();
			setTimeout("jQuery('.is_masonry').masonry();",1000);
        });
	<?php } ?>

    </script>    
	<?php 
		$GLOBALS['showOnlyOneTimeJS']['gallery_likes'] = "
		<script>
			jQuery(document).ready(function($) {
				jQuery('.gallery_likes_add').on('click', function(){
				var gallery_likes_this = jQuery(this);
				if (!jQuery.cookie(gallery_likes_this.attr('data-modify')+gallery_likes_this.attr('data-attachid'))) {
					jQuery.post(gt3_ajaxurl, {
						action:'add_like_attachment',
						attach_id:jQuery(this).attr('data-attachid')
					}, function (response) {
						jQuery.cookie(gallery_likes_this.attr('data-modify')+gallery_likes_this.attr('data-attachid'), 'true', { expires: 7, path: '/' });
						gallery_likes_this.addClass('already_liked');
						gallery_likes_this.find('i').removeClass('icon-heart-o').addClass('icon-heart');
						gallery_likes_this.find('span').text(response);
					});
				}
				});
			});
		</script>
		";		
	?>
    
<?php get_footer('fullscreen'); 
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