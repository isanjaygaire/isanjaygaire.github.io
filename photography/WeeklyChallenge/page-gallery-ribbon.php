
<?php 
/*
Template Name: Gallery - Ribbon
*/
if ( !post_password_required() ) {
get_header('fullscreen');
the_post();

$gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
$pf = get_post_format();			
wp_enqueue_script('gt3_cookie_js', get_template_directory_uri() . '/js/jquery.cookie.js', array(), false, true);
wp_enqueue_script('gt3_flow_js', get_template_directory_uri() . '/js/ribbon.js', array(), false, true);
$all_likes = gt3pb_get_option("likes");
$post_views = (get_post_meta(get_the_ID(), "post_views", true) > 0 ? get_post_meta(get_the_ID(), "post_views", true) : "0");
update_post_meta(get_the_ID(), "post_views", (int)$post_views + 1);
$compile_slides = '';
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
						$compile_slides .= "<li data-count='".$imgi."' data-title='". $photoTitle ."' data-caption='". $photoCaption ."' class='ribbon_slide slide".$imgi."'><iframe src='http://player.vimeo.com/video/". $videoid  ."?autoplay=0&loop=0&api=0' width='100%' height='100%' frameborder='0' webkitAllowFullScreen mozallowfullscreen allowFullScreen class='blur_iframe'></iframe></li>";
					}
				}
				$imgi++;
			}			
		} ?>
        	<script>
				<?php echo $script_compile; ?>
			</script>
            <div class="ribbon_main_wrapper fadeOnLoad">
                <ul class="ribbon_list">
                    <?php echo $compile_slides; ?>
                </ul>                
            </div>
			<a class="rbPrev" href="<?php echo esc_js("javascript:void(0)"); ?>"></a>
            <a class="rbNext" href="<?php echo esc_js("javascript:void(0)"); ?>"></a>
            <div class="rb_indicator rb_indicator_left"><span class="rb_current_display">0</span> / <span class="rb_total_display">0</span></div>
            <div class="rb_indicator rb_indicator_right"><span class="rb_current_display">0</span> / <span class="rb_total_display">0</span></div>
            
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
            <!-- .fullscreen_content_wrapper -->            
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