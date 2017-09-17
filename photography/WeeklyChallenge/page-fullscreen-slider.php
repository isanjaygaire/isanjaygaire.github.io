<?php
/*
Template Name: Fullscreen Slider
*/
if (!post_password_required()) {
    get_header('fullscreen');
    the_post();

    $gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
    $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
    $pf = get_post_format();
    wp_enqueue_script('gt3_fsGallery_js', get_template_directory_uri() . '/js/fs_gallery.js', array(), false, true);

    ?>
    <?php
    $sliderCompile = "";
    if (isset($gt3_theme_pagebuilder['sliders']['fullscreen']['slides']) && is_array($gt3_theme_pagebuilder['sliders']['fullscreen']['slides'])) {
        if (isset($gt3_theme_pagebuilder['sliders']['fullscreen']['thumbnails']) && $gt3_theme_pagebuilder['sliders']['fullscreen']['thumbnails'] == "off") {
            $thumbs_state = $gt3_theme_pagebuilder['sliders']['fullscreen']['thumbnails'];
            $thmb_class = 'pag-hided';
            $pag_class = 'show-pag';
        } else {
            $thumbs_state = "on";
            $thmb_class = '';
            $pag_class = '';
        }
        if (isset($gt3_theme_pagebuilder['sliders']['fullscreen']['controls']) && $gt3_theme_pagebuilder['sliders']['fullscreen']['controls'] !== 'on') {
            $controls = 0;
        } else {
            $controls = 1;
        }
        if (isset($gt3_theme_pagebuilder['sliders']['fullscreen']['thumbs']) && $gt3_theme_pagebuilder['sliders']['fullscreen']['thumbs'] !== 'off') {
            $thmbs = 1;
        } else {
            $thmbs = 0;
        }
        if (isset($gt3_theme_pagebuilder['sliders']['fullscreen']['autoplay']) && $gt3_theme_pagebuilder['sliders']['fullscreen']['autoplay'] == "off") {
            $autoplay = 0;
        } else {
            $autoplay = 1;
        }
        if (isset($gt3_theme_pagebuilder['sliders']['fullscreen']['interval']) && $gt3_theme_pagebuilder['sliders']['fullscreen']['interval'] > 0) {
            $interval = $gt3_theme_pagebuilder['sliders']['fullscreen']['interval'];
        } else {
            $interval = 3300;
        }
        if (isset($gt3_theme_pagebuilder['sliders']['fullscreen']['fit_style'])) {
            $fit_style = $gt3_theme_pagebuilder['sliders']['fullscreen']['fit_style'];
        } else {
            $fit_style = "no_fit";
        }
        if (isset($gt3_theme_pagebuilder['sliders']['fullscreen']['anim_style'])) {
            $fx = $gt3_theme_pagebuilder['sliders']['fullscreen']['anim_style'];
        } else {
            $fx = 'slip';
        }

        $sliderCompile .= '<script>gallery_set = [';
        $preloadCompile = '';
        foreach ($gt3_theme_pagebuilder['sliders']['fullscreen']['slides'] as $imageid => $image) {
            $uniqid = mt_rand(0, 9999);
            if (isset($image['title']['value']) && strlen($image['title']['value']) > 0) {
                $photoTitle = $image['title']['value'];
            } else {
                $photoTitle = "";
            }			
            if (isset($image['caption']['value']) && strlen($image['caption']['value']) > 0) {
                $photoCaption = $image['caption']['value'];
            } else {
                $photoCaption = "";
            }
            $PCREpattern = '/\r\n|\r|\n/u';
            $photoCaption = preg_replace($PCREpattern, '', nl2br($photoCaption));

            if ($image['slide_type'] == 'image') {
                $sliderCompile .= '{type: "image", image: "' . wp_get_attachment_url($image['attach_id']) . '", thmb: "' . aq_resize(wp_get_attachment_url($image['attach_id']), "104", "104", true, true, true) . '", alt: "' . str_replace('"', "'", $photoTitle) . '", title: "' . str_replace('"', "'", $photoTitle) . '", description: "' . str_replace('"', "'", $photoCaption) . '"},';
                $preloadCompile .= '"' . wp_get_attachment_url($image['attach_id']) . '",';
            } else if ($image['slide_type'] == 'video') {
                #YOUTUBE
                $is_youtube = substr_count($image['src'], "youtu");
                if ($is_youtube > 0) {
                    $videoid = substr(strstr($image['src'], "="), 1);
                    $sliderCompile .= '{type: "youtube", uniqid: "' . $uniqid . '", src: "' . $videoid . '", thmb: "' . aq_resize(wp_get_attachment_url($image['attach_id']), "400", "400", true, true, true) . '", alt: "' . str_replace('"', "'", $photoTitle) . '", title: "' . str_replace('"', "'", $photoTitle) . '", description: "' . str_replace('"', "'", $photoCaption) . '"},';
                }
                #VIMEO
                $is_vimeo = substr_count($image['src'], "vimeo");
                if ($is_vimeo > 0) {
                    $videoid = substr(strstr($image['src'], "m/"), 2);
                    $sliderCompile .= '{type: "vimeo", uniqid: "' . $uniqid . '", src: "' . $videoid . '", thmb: "' . aq_resize(wp_get_attachment_url($image['attach_id']), "400", "400", true, true, true) . '", alt: "' . str_replace('"', "'", $photoTitle) . '", title: "' . str_replace('"', "'", $photoTitle) . '", description: "' . str_replace('"', "'", $photoCaption) . '"},';
                }
            }
        }
        $sliderCompile .= "]
	var fsImg = [" . $preloadCompile . "]
	jQuery(document).ready(function(){
		header.addClass('fixed_header');
		jQuery('.custom_bg').remove();
		jQuery('body').fs_gallery({
			fx: '" . $fx . "', /*fade, slip*/
			fit: '" . $fit_style . "',
			slide_time: " . $interval . ", /*This time must be < then time in css*/
			autoplay: " . $autoplay . ",
			show_controls: " . $controls . ",
			slides: gallery_set
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
        ?>
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
                jQuery('html').addClass('single-gallery');
                <?php if ($controls == 'false') {
                    echo "jQuery('html').addClass('hide_controls');";
                } ?>
            });
        </script>

    <?php } ?>
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