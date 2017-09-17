<?php
/*
Template Name: Gallery - Albums With Info
*/
if ( !post_password_required() ) {
    get_header('fullscreen');
    the_post();

    $gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
	$hasFilter = '';

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

		$getArgs = array('taxonomy' => 'Category', 'include' => $post_type_filter);
		$getTerms = get_terms('gallerycat', $getArgs);
		
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
        
   <div class="gallery_albums fadeOnLoad">        
	    <div class="albums_grid_module">
        	<div class="albums-info">
	            <div class="albums-info-wrapper">
                	<div class="albums-info-content">
                    	<article>
                        	<?php the_content(esc_html__('Read more!', 'geographic')); ?>
                        </article>
                    </div>
                </div>
            </div>
            <?php
				$wp_query_in_shortcodes->query($args);
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
					?>
					<div <?php post_class("album_item"); ?>>
						<div class="album_item_wrapper">
							<a href="<?php echo get_permalink(); ?>">
								<div class="img_block album_item_img">	                                
									<img src="<?php echo aq_resize($featured_image[0], "540", "410", true, true, true) ?>" alt="<?php echo $featured_alt ?>">
									<div class="gallery_fadder"></div>
									<span class="plus_icon"></span>
									<div class="albums_title"><?php the_title(); ?></div>
								</div>
							</a>
						</div>
					</div>
	            <?php endwhile; 
					wp_reset_postdata();
				?>
            <div class="clear"></div>
        </div>
    </div>
    <script>
		var ai_wrapper = jQuery('.albums-info-wrapper'),
			ai_content = jQuery('.albums-info-content');
			
        jQuery(document).ready(function($){
			jQuery('.custom_bg').remove();
			albums_setup();
			if (myWindow.width() > 760) {
				ai_wrapper.on('mousewheel', function(event) {
					if (ai_wrapper.hasClass('ai-scrolled')) {
						event.preventDefault();
						var max_top = ai_wrapper.height() - ai_content.height(),
							min_top = 0,
							step = -135,
							current = parseInt(ai_content.css('top'));
						if (event.originalEvent.deltaY > 0) {
							ai_content.css('top', (current+step)+'px');
						}
						if (event.originalEvent.deltaY < 0) {
							ai_content.css('top', (current-step)+'px');
						}
						if (parseInt(ai_content.css('top')) > 0) {
							ai_content.css('top', '0px');
						}
						if (parseInt(ai_content.css('top')) < max_top) {
							ai_content.css('top', max_top+'px');
						}
					}
				});
				ai_wrapper.bind('touchstart', function(event) {
					if (ai_wrapper.hasClass('ai-scrolled')) {
						event.preventDefault();
											
						touch = event.originalEvent.touches[0];
						startAt = touch.pageY;
						html.addClass('touched');
					}
				});		
				
				ai_wrapper.bind('touchmove', function(event) {
					if (ai_wrapper.hasClass('ai-scrolled')) {
						event.preventDefault();
						var current = parseInt(ai_content.css('top'));
	
						touch = event.originalEvent.touches[0];
						movePath = -1* (startAt - touch.pageY)/3;
						ai_content.css('top', (current+movePath)+'px');
					}
				});
				
				ai_wrapper.bind('touchend', function(event) {
					if (ai_wrapper.hasClass('ai-scrolled')) {
						event.preventDefault();
						var max_top = ai_wrapper.height() - ai_content.height(),
							min_top = 0;
						
						html.removeClass('touched');
						if (parseInt(ai_content.css('top')) > 0) {
							ai_content.css('top', '0px');
						}
						if (parseInt(ai_content.css('top')) < max_top) {
							ai_content.css('top', max_top+'px');
						}
					}
				});				
			}
			
        });
        jQuery(window).load(function($){
			albums_setup();
        });
        jQuery(window).resize(function($){
			albums_setup();
        });
		
		function albums_setup() {
			setHeight = Math.floor(jQuery('.album_item_img').height()*2+parseInt(jQuery('.album_item_wrapper').css('padding-bottom')));			
			setTop = (ai_wrapper.height() - ai_content.height())/2;
			if (setTop <= 0) {
				setTop = 0;
				ai_wrapper.addClass('ai-scrolled');
			} else {
				ai_wrapper.removeClass('ai-scrolled');
			}
			jQuery('.albums-info-wrapper').height(setHeight);
			jQuery('.albums-info-content').css('top', setTop + 'px');
		}		
		
    </script>
    <?php
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