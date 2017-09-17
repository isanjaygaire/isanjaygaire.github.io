<?php
/*
Template Name: Striped Page
*/
if ( !post_password_required() ) {
get_header('fullscreen');
?>
	<?php $gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());    
    if (isset($gt3_theme_pagebuilder['strips']) && is_array($gt3_theme_pagebuilder['strips'])) {
        $el_count = count($gt3_theme_pagebuilder["strips"]);
        $strip_width = 100/$el_count;
		$strip_widthH = $strip_width*2;
		$strip_widthAH = (100-$strip_widthH)/($el_count-1);
		$strip_height = 100/$el_count;		
	?>
    	<style>
			.strip-item {
				width:<?php echo $strip_width; ?>%;				
			}
			@media only screen and (min-width: 760px) and (max-width: 960px) {
				.strip-item {
					height:<?php echo $strip_width; ?>%!important;				
				}				
			}
		</style>
		<?php if (gt3_get_theme_option("show_preloader") == 'on') { ?>
            <div class="bg_preloader">
                <div class="preloader more"></div>
            </div>
		<?php } ?>
        <div class="strip-menu strip-vertical fadeOnLoad">
            <?php foreach ($gt3_theme_pagebuilder['strips'] as $stripid => $stripdata) {
                if (!isset($stripdata['opacity']) || $stripdata['opacity'] == '') {
                    $opacity = '1';
                } else {
                    $opacity = $stripdata['opacity'];
                }
                ?>
            <div class="strip-item block2preload" style="background-image:url(<?php echo wp_get_attachment_url($stripdata['attachid']); ?>);" data-src="<?php echo wp_get_attachment_url($stripdata['attachid']); ?>">
				<?php
                    if ((isset($stripdata['striptitle1']) && $stripdata['striptitle1'] !== '') || (isset($stripdata['striptitle2']) && $stripdata['striptitle2'] !== '')) {?>
                    <div class="strip-text">
                        <?php
                            if (isset($stripdata['striptitle1']) && $stripdata['striptitle1'] !== '') {?>
                        <h2 class="strip-title"><?php echo $stripdata['striptitle1']; ?></h2>                    
                        <?php }
                            if (isset($stripdata['striptitle2']) && $stripdata['striptitle2'] !== '') {?>
                        <span class="strip-caption"><?php echo $stripdata['striptitle2']; ?></span>
                        <?php }	?>
                    </div>
                <?php } ?>
                <a href="<?php echo $stripdata['link']; ?>" class="strip_link"></a>
            </div>
            <?php }?>
            <div class="clear"></div>
        </div>
        <script>
			var strip_menu = jQuery('.strip-menu');
            jQuery(document).ready(function($) {
				strip_setup();
            });	
			jQuery(window).resize(function(){
				strip_setup();
				setTimeout("strip_setup()",500);
				setTimeout("strip_setup()",1000);
			});
			function strip_setup() {
				if (jQuery('#wpadminbar').size() > 0) {
					strip_menu.height(myWindow.height() - header.height() - jQuery('#wpadminbar').height() - footer.height());
				} else {
					strip_menu.height(myWindow.height() - header.height() - footer.height());
				}
				if (window_w < 760) {
					jQuery('.strip-item').height(window_h/<?php echo $el_count; ?>);
				} else {
					jQuery('.strip-item').height('100%');
				}
			}
        </script>
    <?php } ?> 
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