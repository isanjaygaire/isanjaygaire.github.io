<?php
/*
Template Name: Landing with Title
*/
if ( !post_password_required() ) {
get_header('none')
?>
	<?php 
		$gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID()); 
		$logo_color = 'f6f7f9';
		$title_color = '161616';
		$slogan_color = '505050';
		$landing_text = '';
		$landing_title = '';
		if (isset($gt3_theme_pagebuilder['landing']['color'])) {
			$logo_color = $gt3_theme_pagebuilder['landing']['color'];
		}
		if (isset($gt3_theme_pagebuilder['landing']['title_color'])) {
			$title_color = $gt3_theme_pagebuilder['landing']['title_color'];
		}
		if (isset($gt3_theme_pagebuilder['landing']['slogan_color'])) {
			$slogan_color = $gt3_theme_pagebuilder['landing']['slogan_color'];
		}
		if (isset($gt3_theme_pagebuilder['landing']['title'])) {
			$landing_title = $gt3_theme_pagebuilder['landing']['title'];
		}
		if (isset($gt3_theme_pagebuilder['landing']['text'])) {
			$landing_text = $gt3_theme_pagebuilder['landing']['text'];
		}
	?>
		<div class="landing_block landing_w_title fadeOnLoad" style="background-color:#<?php echo $logo_color; ?>;">
        	<div class="landing_block_content">
                <a href="<?php echo $gt3_theme_pagebuilder['landing']['url']; ?>" class="landing_link"></a>
                <?php if ($landing_title !== '') {?>
                <h1 class="landing_title" style="color:#<?php echo $title_color; ?>"><?php echo $landing_title; ?></h1>
                <?php } ?>                
                <?php if ($landing_text !== '') {?>
                <span class="landing_text" style="color:#<?php echo $slogan_color; ?>"><?php echo $landing_text; ?></span>
                <?php } ?>
            </div>
		</div>
        <div class="landing_bg" style="background-image:url(<?php echo gt3_the_theme_option("bg_landing"); ?>)"></div>
		<script>		
			var landing_block = jQuery('.landing_block');
			jQuery(document).ready(function () {
				centerWindow();
				jQuery('.custom_bg').remove();
			});
			jQuery(window).load(function () {
				centerWindow();
				setTimeout('centerWindow()', 500);
			});
			jQuery(window).resize(function () {
				setTimeout('centerWindow()', 500);
				setTimeout('centerWindow()', 1000);
			});
			function centerWindow() {
				setLandingTop = -1 * (landing_block.height() / 2);
				setLandingLeft = -1 * (landing_block.width() / 2);
				landing_block.css('margin-top', setLandingTop + 'px');
				landing_block.css('margin-left', setLandingLeft + 'px');
			}
		</script>
<?php get_footer('none'); 
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