<?php 
/*
Template Name: Portfolio Shift Listing
*/
if ( !post_password_required() ) {
get_header('fullscreen');
the_post();

$gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
$pf = get_post_format();
wp_enqueue_script('gt3_cookie_js', get_template_directory_uri() . '/js/jquery.cookie.js', array(), false, true);
wp_enqueue_script('gt3_dmLightBox_js', get_template_directory_uri() . '/js/dm_lightbox.js', array(), false, true);

	global $wp_query_in_shortcodes, $paged;

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
				'post_type' => 'port',
				'order' => 'DESC',
				'paged' => $paged,
				'posts_per_page' => -1
			);
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'portcat',
					'field' => 'id',
					'terms' => $post_type_terms
				)
			);
		}
	} else {
		$post_type_filter = "";
		$args = array(
			'post_type' => 'port',
			'order' => 'DESC',
			'paged' => $paged,
			'posts_per_page' => -1
		);
	}
	$wp_query_in_shortcodes = new WP_Query();
	$type_class = 'x2x1';
?>
	<?php if (gt3_get_theme_option("show_preloader") == 'on') { ?>
        <div class="bg_preloader">
            <div class="preloader more"></div>
        </div>
    <?php } ?>
    <div class="page_indicator">
    	<a href="<?php echo esc_js("javascript:void(0)");?>" class="pageUp"><i class="icon-angle-up"></i></a>
        <span class="current_page disabled">1</span> / <span class="max_page">1</span>
        <a href="<?php echo esc_js("javascript:void(0)");?>" class="pageDown"><i class="icon-angle-down"></i></a>
    </div>

	<div class="screen_cutter mobile_cutter">
    <div id="cols_wrapper" class="album_listing_col fadeOnLoad <?php echo $type_class;?>">
    
    	<?php 
		//for ($i = 1; $i <= $colCount ; $i++) {
		$i = 1;
		$cl = 1;
		$cr = 1;
		$compile_left = "";
		$compile_right = "";
		$divTemplate = '';
		$wp_query_in_shortcodes->query($args);
		while ($wp_query_in_shortcodes->have_posts()) : $wp_query_in_shortcodes->the_post();
			$all_likes = gt3pb_get_option("likes");
			$gt3_theme_post = get_plugin_pagebuilder(get_the_ID());
			$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
			$pf = get_post_format();
			$target = (isset($gt3_theme_post['settings']['new_window']) && $gt3_theme_post['settings']['new_window'] == "on" ? "target='_blank'" : "");
			if (isset($gt3_theme_post['page_settings']['portfolio']['work_link']) && strlen($gt3_theme_post['page_settings']['portfolio']['work_link']) > 0) {
				$linkToTheWork = esc_url($gt3_theme_post['page_settings']['portfolio']['work_link']);
			} else {
				$linkToTheWork = get_permalink();
			}
			
			$echoallterm = '';
			$new_term_list = get_the_terms(get_the_id(), "portcat");
			if (is_array($new_term_list)) {
				foreach ($new_term_list as $term) {
					$tempname = strtr($term->name, array(
						' ' => ', ',
					));
					$echoallterm .= strtolower($tempname) . " ";
					$echoterm = $term->name;
				}
			} else {
				$tempname = 'Uncategorized';
			}
			if ($i % 2) {
				$rowNum = $cl;
			} else {
				$rowNum = $cr;
			}
			if (strlen(get_the_title()) > 0) {
				$title = '<h2 class="shifting_title"><a target="'. $target .'" href="'. $linkToTheWork .'">'. get_the_title() .'</a></h2>';
			} else {
				$title = '';
			}			
			$caption = ((strlen($post->post_excerpt) > 0) ? '<h3>' . $post->post_excerpt . '</h3>' : '');
			$divTemplate = '<div class="fw_grid_item item'. $rowNum .'" data-count="'. $rowNum .'">
					<div class="fw_grid_content">
						<div class="img_block wrapped_img fs_port_item gallery_item_wrapper bg_size_cover block2preload" data-src="'. $featured_image[0] .'" style="background-image:url('. $featured_image[0] .')">
							<a target="'. $target .'" href="'. $linkToTheWork .'" class="base_shifting_link"></a>
							<div class="port_shift_text">
								'. $title .'
								<div class="port_shift_meta">
									<span>'. $tempname .'</span>
									<span class="middot">&middot;</span>
									<span>'. get_comments_number(get_the_ID()) .' '. esc_html__('Comments', 'geographic') .'</span>
									<span class="middot">&middot;</span>
									<div class="gallery_likes_add preview_likes '. (isset($_COOKIE['like_port'.get_the_ID()]) ? "already_liked" : "") .'" data-attachid="'. get_the_ID() .'" data-modify="like_port">
										<i class="stand_icon '. (isset($_COOKIE['like_port'.get_the_ID()]) ? "icon-heart" : "icon-heart-o") .'"></i>
										<span>'. ((isset($all_likes[get_the_ID()]) && $all_likes[get_the_ID()]>0) ? $all_likes[get_the_ID()] : 0) .'</span>
		                            </div><!-- .preview_likes -->									
								</div>
							</div>
						</div>
					</div>
				</div>';
			if ($i % 2) {
				$compile_left .= $divTemplate;
				$cl++;
			} else {
				$compile_right = $divTemplate .$compile_right;
				$cr++;
			}
			$i++;
			endwhile;
			wp_reset_postdata();
			?>
            <div id="column_left" class="left_side">
            	<?php echo $compile_left; ?>
            </div>
            <div id="column_right" class="right_side">
            	<?php echo $compile_right; ?>
            </div>            
    </div><!-- #cols_wrapper -->

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

	<script>
		var cols = jQuery('#cols_wrapper'),		
			left = jQuery('#column_left'),
			right = jQuery('#column_right'),
			cpIndicator = jQuery('span.current_page'),
			maxIndicator = jQuery('span.max_page'),
			btnUp = jQuery('.pageUp'),
			btnDown = jQuery('.pageDown'),
			currentStep = 1;

		if (right.find('.fw_grid_item').size() > left.find('.fw_grid_item').size()) {
			var mainCol = jQuery('#column_right');
		} else {
			var mainCol = jQuery('#column_left');
		}
		var maxStep = mainCol.find('.fw_grid_item').size();
		
		jQuery(document).ready(function(){
			maxIndicator.text(maxStep);
			jQuery('.custom_bg').remove();
			if (jQuery('#wpadminbar').size() > 0) {
				setSize = myWindow.height() - header.height() - jQuery('#wpadminbar').height() - footer.height();
				cols.height(setSize).css('top', header.height() + jQuery('#wpadminbar').height() );
			} else {
				setSize = myWindow.height() - header.height() - footer.height();
				cols.height(setSize).css('top', header.height());			
			}
		
			scrollCont = jQuery('#cols_wrapper');
			
			scrollCont.on('mousewheel', function(event) {
				jQuery('.currentStep').removeClass('.currentStep');
				if (jQuery('#wpadminbar').size() > 0) {
					setSize = myWindow.height() - header.height() - jQuery('#wpadminbar').height() - footer.height();
				} else {
					setSize = myWindow.height() - header.height() - footer.height();
				}
				step = setSize;
							
				if (mainCol.height() > setSize) {					
					if (event.originalEvent.deltaY > 0) {
						currentStep++;
						if (currentStep > maxStep ) currentStep = maxStep;						
					}
					if (event.originalEvent.deltaY < 0) {
						currentStep--;
						if (currentStep < 1 ) currentStep = 1;
					}
					console.log(event);
					console.log(event.originalEvent.deltaY);
					left.css('top', -1*step*(currentStep-1) + 'px');
					right.css('bottom', -1*step*(currentStep-1) + 'px');
					cpIndicator.text(currentStep);
					
					jQuery('.disabled').removeClass('disabled');
					if (currentStep == 1) {
						btnUp.addClass('disabled');
					}
					if (currentStep == maxStep) {
						btnDown.addClass('disabled');
					}
				}
			});
			scrollCont.on('touchstart', function(event) {
				touch = event.originalEvent.touches[0];
				startAt = touch.pageY;
				html.addClass('touched');
				if (jQuery('#wpadminbar').size() > 0) {
					setSize = myWindow.height() - header.height() - jQuery('#wpadminbar').height() - footer.height();
				} else {
					setSize = myWindow.height() - header.height() - footer.height();
				}
				step = setSize;
				baseTop = parseInt(left.css('top'));
				baseBottom = parseInt(right.css('bottom'));
			});		
			
			scrollCont.on('touchmove', function(event) {
				event.preventDefault();
				touch = event.originalEvent.touches[0];
				movePath = -1* (startAt - touch.pageY)/3;
				if (mainCol.height() > setSize) {
					left.css('top', baseTop + movePath + 'px');
					right.css('bottom', baseBottom + movePath + 'px');
				}
			});
			
			scrollCont.on('touchend', function(event) {
				html.removeClass('touched');
				touch = event.originalEvent.changedTouches[0];
				if (touch.pageY < startAt) {
					currentStep++;
					if (currentStep > maxStep ) currentStep = maxStep;						
				}
				if (touch.pageY > startAt) {
					currentStep--;
					if (currentStep < 1 ) currentStep = 1;
				}
				left.css('top', -1*step*(currentStep-1) + 'px');
				right.css('bottom', -1*step*(currentStep-1) + 'px');
				cpIndicator.text(currentStep);
				jQuery('.disabled').removeClass('disabled');
				if (currentStep == 1) {
					btnUp.addClass('disabled');
				}
				if (currentStep == maxStep) {
					btnDown.addClass('disabled');
				}				
			});
					
			gal_setup();

			btnUp.on("click",function(){
				changePage('up');
			});
			btnDown.on("click",function(){
				changePage('down');
			});
			jQuery(document.documentElement).keyup(function (event) {
				if (event.keyCode == 40) {
					changePage('down');				
				} else if (event.keyCode == 38) {
					changePage('up');
				}
			});			
			
		});
		function changePage(dir) {
			jQuery('.currentStep').removeClass('.currentStep');
			if (jQuery('#wpadminbar').size() > 0) {
				setSize = myWindow.height() - header.height() - jQuery('#wpadminbar').height() - footer.height();
			} else {
				setSize = myWindow.height() - header.height() - footer.height();
			}
			step = setSize;
						
			if (mainCol.height() > setSize) {					
				if (dir == 'down') {
					currentStep++;
					if (currentStep > maxStep ) currentStep = maxStep;						
				}
				if (dir == 'up') {
					currentStep--;
					if (currentStep < 1 ) currentStep = 1;
				}
				left.css('top', -1*step*(currentStep-1) + 'px');
				right.css('bottom', -1*step*(currentStep-1) + 'px');
				cpIndicator.text(currentStep);
				
				jQuery('.disabled').removeClass('disabled');
				if (currentStep == 1) {
					btnUp.addClass('disabled');
				}
				if (currentStep == maxStep) {
					btnDown.addClass('disabled');
				}
			}
			return;	
		}
		function gal_setup() {
			if (jQuery('#wpadminbar').size() > 0) {
				setSize = myWindow.height() - header.height() - jQuery('#wpadminbar').height() - footer.height();
			} else {
				setSize = myWindow.height() - header.height() - footer.height();
			}
			cols.height(setSize).css('top', header_h);					
			if (jQuery('.x2x2').size() > 0) {
				jQuery('.fs_port_item').height(setSize/2);
			} else {
				jQuery('.fs_port_item').height(setSize);
			}			
			jQuery('.al_listing_content').each(function(){
				jQuery(this).css('margin-top', -1*jQuery(this).height()/2+'px');
			});
			left.css('top', -1*setSize*(currentStep-1) + 'px');
			right.css('bottom', -1*setSize*(currentStep-1) + 'px');
			cpIndicator.text(currentStep);
		}
		jQuery(window).load(function($){
			gal_setup();
		});	
		jQuery(window).resize(function($){
			gal_setup();
			setTimeout("gal_setup()",500);
		});		
	</script>
    </div>
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