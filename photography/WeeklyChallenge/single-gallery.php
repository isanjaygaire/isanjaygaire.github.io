<?php
if (!post_password_required()) {
    get_header('fullscreen');
    $all_likes = gt3pb_get_option("likes");
    the_post();
    $gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
    $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
    $pf = get_post_format();

    $galleryType = gt3_get_theme_option('default_gallery_style');

    if (isset($gt3_theme_pagebuilder['settings']['gallery_style'])) {
        if ($gt3_theme_pagebuilder['settings']['gallery_style'] == 'fw-gallery-post') {
            $galleryType = 'fw-gallery-post';
        }
        if ($gt3_theme_pagebuilder['settings']['gallery_style'] == 'ribbon-gallery-post') {
            $galleryType = 'ribbon-gallery-post';
        }
    }
    /* ADD 1 view for this post */
    $post_views = (get_post_meta(get_the_ID(), "post_views", true) > 0 ? get_post_meta(get_the_ID(), "post_views", true) : "0");
    update_post_meta(get_the_ID(), "post_views", (int)$post_views + 1);
    wp_enqueue_script('gt3_cookie_js', get_template_directory_uri() . '/js/jquery.cookie.js', array(), false, true);
    $all_likes = gt3pb_get_option("likes");
    ?>
    <?php
    if ($galleryType == 'fw-gallery-post') { ?>
        <?php
        $test_title = '';
        wp_enqueue_script('gt3_fsGallery_js', get_template_directory_uri() . '/js/fs_gallery.js', array(), false, true);
        $sliderCompile = "";
        if (isset($gt3_theme_pagebuilder['sliders']['fullscreen']['slides']) && is_array($gt3_theme_pagebuilder['sliders']['fullscreen']['slides'])) {

            if (isset($gt3_theme_pagebuilder['sliders']['fullscreen']['anim_style']) && $gt3_theme_pagebuilder['sliders']['fullscreen']['anim_style'] !== 'default') {
                $fx = $gt3_theme_pagebuilder['sliders']['fullscreen']['anim_style'];
            } else {
                $fx = gt3_get_theme_option("default_slider_anim");
            }
            if (isset($gt3_theme_pagebuilder['sliders']['fullscreen']['fit_style']) && $gt3_theme_pagebuilder['sliders']['fullscreen']['fit_style'] !== 'default') {
                $fit_style = $gt3_theme_pagebuilder['sliders']['fullscreen']['fit_style'];
            } else {
                $fit_style = gt3_get_theme_option("default_fit_style");
            }
            if (isset($gt3_theme_pagebuilder['sliders']['fullscreen']['controls']) && $gt3_theme_pagebuilder['sliders']['fullscreen']['controls'] !== 'default') {
                $controls = $gt3_theme_pagebuilder['sliders']['fullscreen']['controls'];
            } else {
                $controls = gt3_get_theme_option("default_controls");
            }
            if ($controls == 'on' || $controls == 'yes') {
                $controls = 'true';
            } else {
                $controls = 'false';
            }
            if (isset($gt3_theme_pagebuilder['sliders']['fullscreen']['autoplay']) && $gt3_theme_pagebuilder['sliders']['fullscreen']['autoplay'] !== 'default') {
                $autoplay = $gt3_theme_pagebuilder['sliders']['fullscreen']['autoplay'];
            } else {
                $autoplay = gt3_get_theme_option("default_autoplay");
            }
            if ($autoplay == 'on' || $autoplay == 'yes') {
                $autoplay = 'true';
            } else {
                $autoplay = 'false';
            }

            $interval = gt3_get_theme_option("gallery_interval");

            $sliderCompile .= '<script>gallery_set = [';
            $script_compile = '';
            $preloadCompile = '';
            foreach ($gt3_theme_pagebuilder['sliders']['fullscreen']['slides'] as $imageid => $image) {
                $uniqid = mt_rand(0, 9999);
                if (isset($image['title']['value']) && strlen($image['title']['value']) > 0) {
                    $photoTitle = $image['title']['value'];
                    $test_title = "has_title";
                } else {
                    $photoTitle = "";
                }
                if (isset($image['caption']['value']) && strlen($image['caption']['value']) > 0) {
                    $photoCaption = $image['caption']['value'];
                } else {
                    $photoCaption = "";
                }
                if (isset($image['title']['color']) && strlen($image['title']['color']) > 0) {
                    $titleColor = $image['title']['color'];
                } else {
                    $titleColor = "ffffff";
                }
                if (isset($image['caption']['color']) && strlen($image['caption']['color']) > 0) {
                    $captionColor = $image['caption']['color'];
                } else {
                    $captionColor = "ffffff";
                }
                $PCREpattern = '/\r\n|\r|\n/u';
                $photoCaption = preg_replace($PCREpattern, '', nl2br($photoCaption));

                if ($image['slide_type'] == 'image') {
                    $sliderCompile .= '{type: "image", image: "' . wp_get_attachment_url($image['attach_id']) . '", thmb: "' . aq_resize(wp_get_attachment_url($image['attach_id']), "104", "104", true, true, true) . '", alt: "' . str_replace('"', "'", $photoTitle) . '", title: "' . str_replace('"', "'", esc_attr($photoTitle)) . '", description: "' . str_replace('"', "'", esc_attr($photoCaption)) . '", titleColor: "#' . $titleColor . '", descriptionColor: "#' . $captionColor . '"},';
                    $preloadCompile .= '"' . wp_get_attachment_url($image['attach_id']) . '",';
                } else if ($image['slide_type'] == 'video') {
                    #YOUTUBE
                    $is_youtube = substr_count($image['src'], "youtu");
                    if ($is_youtube > 0) {
                        $videoid = substr(strstr($image['src'], "="), 1);
                        $thmb = "http://img.youtube.com/vi/" . $videoid . "/0.jpg";
                        $sliderCompile .= '{type: "youtube", uniqid: "' . $uniqid . '", src: "' . $videoid . '", thmb: "' . $thmb . '", alt: "' . str_replace('"', "'", $photoTitle) . '", title: "' . str_replace('"', "'", esc_attr($photoTitle)) . '", description: "' . str_replace('"', "'", esc_attr($photoCaption)) . '", titleColor: "#' . $titleColor . '", descriptionColor: "#' . $captionColor . '"},';
                    }
                    #VIMEO
                    $is_vimeo = substr_count($image['src'], "vimeo");
                    if ($is_vimeo > 0) {
                        $videoid = substr(strstr($image['src'], "m/"), 2);
                        $thmbArray = json_decode(file_get_contents("http://vimeo.com/api/v2/video/" . $videoid . ".json"));
                        if (!empty($thmbArray))
                            $thmb = $thmbArray[0]->thumbnail_large;
                        $sliderCompile .= '{type: "vimeo", uniqid: "' . $uniqid . '", src: "' . $videoid . '", thmb: "' . $thmb . '", alt: "' . str_replace('"', "'", $photoTitle) . '", title: "' . str_replace('"', "'", esc_attr($photoTitle)) . '", description: "' . str_replace('"', "'", esc_attr($photoCaption)) . '", titleColor: "#' . $titleColor . '", descriptionColor: "#' . $captionColor . '"},';
                    }
                }
            }
            $sliderCompile .= "]" . $script_compile . "
			var fsImg = [" . $preloadCompile . "]
			
            jQuery(document).ready(function(){
                header.addClass('fixed_header');
                jQuery('body').fs_gallery({
                    fx: '" . $fx . "', /*fade, slip*/
                    fit: '" . $fit_style . "',
                    slide_time: " . $interval . ", /*This time must be < then time in css*/
                    autoplay: " . $autoplay . ",
                    show_controls: " . $controls . ",
                    slides: gallery_set
                });
        		if (myWindow.width() < 760) {
					jQuery('.fs_content_bg').css('margin-top', myWindow.height()- header_h);
				}
                jQuery('.close_controls').on('click', function(){
                    html.toggleClass('hide_controls');
                });			
            });
            </script>";

            echo $sliderCompile; ?>
            <?php if (gt3_get_theme_option("show_preloader") == 'on') { ?>
                <div class="bg_preloader">
                    <div class="preloader more"></div>
                </div>
            <?php } ?>
            <div class="fs_bg"></div>
            <?php
            $title_class = '';
            $title_shadow = '';
            ?>
            <div class="fs_controls_append"></div>
            
            <div class="centered_title <?php echo $title_class; ?>">
                <div class="fs_title_wrapper fadeOnLoad <?php echo $title_class; ?>">
                    <h2 class="fs_title"><?php echo the_title(); ?>&nbsp;</h2>
                    <span class="fs_descr"></span>
                </div>
            </div>
    
            <div class="fs_controls_append"></div>
            <div class="rb_indicator rb_indicator_left"><span class="rb_current_display">0</span> / <span class="rb_total_display">0</span></div>
            <div class="rb_indicator rb_indicator_right"><span class="rb_current_display">0</span> / <span class="rb_total_display">0</span></div>
            <div class="landing-border-left"></div>
            <div class="landing-border-right"></div>
            
            <script>
                jQuery(document).ready(function () {
                    jQuery('.custom_bg').remove();
                });
            </script>
        <?php } 
    } else if ($galleryType == 'ribbon-gallery-post') {
        wp_enqueue_script('gt3_flow_js', get_template_directory_uri() . '/js/ribbon.js', array(), false, true);
        ?>

		<?php if (gt3_get_theme_option("show_preloader") == 'on') { ?>
            <div class="bg_preloader">
                <div class="preloader more"></div>
            </div>
		<?php } ?>

        <?php
        if (isset($gt3_theme_pagebuilder['sliders']['fullscreen']['slides']) && is_array($gt3_theme_pagebuilder['sliders']['fullscreen']['slides'])) {
            $imgi = 1;
            $script_compile = '';
            $compile_slides = '';
            foreach ($gt3_theme_pagebuilder['sliders']['fullscreen']['slides'] as $imageid => $image) {
				if (isset($image['title']['value']) && strlen($image['title']['value'])>0) {$photoTitle = $image['title']['value'];} else {$photoTitle = " ";}
				if (isset($image['caption']['value']) && strlen($image['caption']['value'])>0) {$photoCaption  = $image['caption']['value'];} else {$photoCaption = " ";}
				if ($image['slide_type'] == 'image') {
						$compile_slides .= "<li data-count='".$imgi."' data-title='". $photoTitle ."' data-caption='". $photoCaption ."' class='ribbon_slide slide".$imgi."'><img src='" . aq_resize(wp_get_attachment_url($image['attach_id']), null, "1000", true, true, true) . "' alt='" . $photoTitle ."' class='blur_img img2preload'/>";
						if ($photoTitle !== ' ' || $photoCaption !== ' ') {
							$compile_slides .= "<div class='ribbon_text_wrapper'><div class='ribbon_text'>";
								if ($photoTitle !== ' ') {
									$compile_slides .= "<h2 class='ribbon_title'>". $photoTitle."</h2>";
								}
								if ($photoCaption !== ' ') {
									$compile_slides .= "<span class='ribbon_caption'>". $photoCaption."</span>";
								}
							$compile_slides .= "</div></div>";
						}
						$compile_slides .= "</li>";
					} else {
	
					#YOUTUBE
					$is_youtube = substr_count($image['src'], "youtu");
					if ($is_youtube > 0) {
						$videoid = substr(strstr($image['src'], "="), 1);
						$compile_slides .= "<li data-count='".$imgi."' data-title='". $photoTitle ."' data-caption='". $photoCaption ."' class='ribbon_slide slide".$imgi."'><iframe width='100%' height='100%' src='http://www.youtube.com/embed/" . $videoid . "?controls=1&autoplay=0&showinfo=0&modestbranding=1&wmode=opaque&rel=0&hd=1&disablekb=1' frameborder='0' allowfullscreen class='blur_iframe'></iframe></li>";
					}
					#VIMEO
					$is_vimeo = substr_count($image['src'], "vimeo");				
					if ($is_vimeo > 0) {
						$videoid = substr(strstr($image['src'], "m/"), 2);
						$compile_slides .= "<li data-count='".$imgi."' data-title='". $photoTitle ."' data-caption='". $photoCaption ."' class='ribbon_slide slide".$imgi."'><iframe src='http://player.vimeo.com/video/". $videoid  ."?autoplay=0&loop=0&api=0' width='100%' height='100%' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen class='blur_iframe' ></iframe></li>";
					}
				}
				$imgi++;            }
        } ?>
        <script>
            <?php echo $script_compile; ?>
        </script>
        <div class="ribbon_main_wrapper fadeOnLoad">
            <ul class="ribbon_list">
                <?php echo $compile_slides; ?>
            </ul>
			<a class="rbPrev" href="<?php echo esc_js("javascript:void(0)"); ?>"></a>
            <a class="rbNext" href="<?php echo esc_js("javascript:void(0)"); ?>"></a>
            <div class="rb_indicator rb_indicator_left"><span class="rb_current_display">0</span> / <span class="rb_total_display">0</span></div>
            <div class="rb_indicator rb_indicator_right"><span class="rb_current_display">0</span> / <span class="rb_total_display">0</span></div>
        </div>

    <?php } ?>

    <script>
        jQuery(document).ready(function () {
            jQuery('.custom_bg').remove();
        });
    </script>
    <?php
    get_footer('fullscreen');
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