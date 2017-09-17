<?php
/*
Template Name: Gallery - Albums Flow
*/
if ( !post_password_required() ) {
    get_header('fullscreen');
    the_post();
	wp_enqueue_script('gt3_flow_js', get_template_directory_uri() . '/js/flow.js', array(), false, true);
	
    $gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
	if (isset($gt3_theme_pagebuilder['settings']['filter']) && $gt3_theme_pagebuilder['settings']['filter'] == 'off') {
		$hasFilter = '';
	} else {
		$hasFilter = 'has_filter';
	}
	

        global $wp_query_in_shortcodes, $paged;
		$post_type_field = 'id';
        if(empty($paged)){
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        }
        if (isset($gt3_theme_pagebuilder['settings']['cat_ids']) && (is_array($gt3_theme_pagebuilder['settings']['cat_ids']))) {
            $compile_cats = array();
            foreach ($gt3_theme_pagebuilder['settings']['cat_ids'] as $catkey => $catvalue) {
                array_push($compile_cats, $catkey);
            }
            $selected_categories = implode(",", $compile_cats);
        } else {
            $selected_categories = "";
        }
        $post_type_terms = array();
        if (isset($selected_categories) && strlen($selected_categories) > 0) {
            $post_type_terms = explode(",", $selected_categories);
			$post_type_filter = explode(",", $selected_categories);
            if (count($post_type_terms) > 0) {
                $args = array(
                    'post_type' => 'gallery',
                    'order' => 'DESC',
                    'paged' => $paged,
                    'posts_per_page' => -1
                );
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'gallerycat',
                        'field' => 'id',
                        'terms' => $post_type_terms
                    )
                );
            }
        } else {
			$post_type_filter = "";
            $args = array(
                'post_type' => 'gallery',
                'order' => 'DESC',
                'paged' => $paged,
                'posts_per_page' => -1
            );
        }
		$wp_query_in_shortcodes = new WP_Query();
		$args = array(
			'post_type' => 'gallery',
			'order' => 'DESC',
			'paged' => $paged,
			'posts_per_page' => -1
		);
	
		if (isset($_GET['slug']) && strlen($_GET['slug']) > 0) {
			$post_type_terms = esc_attr($_GET['slug']);
			$selected_categories = esc_attr($_GET['slug']);
			$post_type_field = "slug";
		}
		if (count($post_type_terms) > 0) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'gallerycat',
					'field' => $post_type_field,
					'terms' => $post_type_terms
				)
			);
		}
        ?>
	<?php if (gt3_get_theme_option("show_preloader") == 'on') { ?>
        <div class="bg_preloader">
            <div class="preloader more"></div>
        </div>
    <?php } ?>        
	<div class="flow_albums fadeOnLoad">
	<?php
        $wp_query_in_shortcodes->query($args);
		$num = 1;
		$bg_slide_complie = '';
        while ($wp_query_in_shortcodes->have_posts()) : $wp_query_in_shortcodes->the_post();
            $gt3_theme_post = get_plugin_pagebuilder(get_the_ID());
            $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
            $featured_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
            $pf = get_post_format();
            $echoallterm = '';
            $echoallterm2 = '';
            $new_term_list = get_the_terms(get_the_id(), "gallerycat");
            if (is_array($new_term_list)) {
                foreach ($new_term_list as $term) {
                    $tempname = strtr($term->name, array(
                        ' ' => ', ',
                    ));
                    $tempname2 = strtr($term->name, array(
                        ' ' => ' ',
                    ));
                    $echoallterm .= strtolower($tempname) . " ";
                    $echoallterm2 .= $tempname2 . ", ";
                    $echoterm = $term->name;
                }
                $tempname = substr($echoallterm2,0,-2);
            } else {
                $tempname = 'Uncategorized';
            }
			$picsCount = count($gt3_theme_post['sliders']['fullscreen']['slides']);
            ?>            
            <div class="flow_item album_item<?php echo get_the_ID(); ?> slide<?php echo $num; ?>" data-count="<?php echo $num; ?>" data-link = "<?php echo get_permalink(); ?>">
	            <a href="<?php echo get_permalink(); ?>" class="iPhone_link"></a>
                <a href="<?php echo esc_js("javascript:void(0)"); ?>" class="ajax_flow_link ajax_flow_link_big" data-postid = "<?php echo get_the_ID(); ?>"></a>
                <img class="flow_img" src="<?php echo aq_resize($featured_image[0], "1280", "960", true, true, true) ?>" alt="<?php echo $featured_alt ?>">
                <div class="flow_descr_wrapper">
                    <div class="flow_descr_block">
                        <h2><a href="<?php echo esc_js("javascript:void(0)"); ?>" class="ajax_flow_link" data-postid = "<?php echo get_the_ID(); ?>"><?php the_title(); ?></a></h2>
                        <div class="flow_meta">
                            <span><?php echo $tempname; ?></span>
                            <span class="middot">&middot;</span>
                            <span><?php echo get_the_time("F d, Y") ?></span>
                            <span class="middot">&middot;</span>
                            <span><?php echo $picsCount; ?> <?php esc_html_e('pictures', 'geographic'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
		<?php 
			$bg_slide_complie .= '<li class="bg_slide'. $num .'" data-bg="'. $featured_image[0] .'"></li>';
			$num++;
			endwhile; 
			wp_reset_postdata();
		?>
    </div>
    <div class="flow_controls">
        <a href="<?php echo esc_js("javascript:void(0)"); ?>" class="flow_prev rbPrev"></a>
        <a href="<?php echo esc_js("javascript:void(0)"); ?>" class="flow_next rbNext"></a>
    </div><!-- .flow_controls -->
    
	<?php if($hasFilter == 'has_filter') { ?>
    <div class="flow_filter_wrapper">
    	<?php echo showGalleryCats($post_type_filter);?>
    </div><!-- .flow_filter -->
	<?php } ?>
    
    <ul id="ajax_slider" class="reload">
        
    </ul>
    
    <div class="ajaxSlider_controls">
        <a href="<?php echo esc_js("javascript:void(0)"); ?>" class="ajax_prev rbPrev"></a>
        <a href="<?php echo esc_js("javascript:void(0)"); ?>" class="ajax_next rbNext"></a>
        <a href="<?php echo esc_js("javascript:void(0)"); ?>" class="ajax_close"></a>
    </div><!-- .ajaxSlider_controls -->

	<script>
		//Main Var
		var indicator_left = jQuery('.rb_indicator_left'),
			indicator_left = jQuery('.rb_indicator_right'),
			ajax_prev = jQuery('.ajax_prev'),
			ajax_next = jQuery('.ajax_next'),
			ajax_close = jQuery('.ajax_close'),
			ajax_slider = jQuery('#ajax_slider'),
			ajaxControls = jQuery('.ajaxSlider_controls');
			
		jQuery(document).ready(function(){
			jQuery('.ajax_flow_link').on('click', function(){
				gt3_get_gallery(jQuery(this).attr('data-postid'));
			});
			ajax_prev.on('click', function(){
				prev_ajax_slide();
			});
			ajax_next.on('click', function(){
				next_ajax_slide();
			});
			ajax_close.on('click', function(){
				hide_ajax_slider();
			});			
		});
		jQuery(window).load(function(){
			setup_ajax_slider();
		});
		jQuery(window).resize(function(){
			setup_ajax_slider();
		});
	</script>
    
	<ul class="bg_slider">
    	<?php echo $bg_slide_complie; ?>
    </ul>
    <div class="landing-border-left"></div>
    <div class="landing-border-right"></div>	
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