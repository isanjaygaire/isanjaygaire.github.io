<?php 
/* Template Name: Vertically Stretched Page */
if ( !post_password_required() ) {
get_header('fullscreen'); the_post();
$gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
?>
<div class="centered_container">
	<div class="centered_container_wrapper">
        <div class="page_title_block">
            <?php if (!isset($gt3_theme_pagebuilder['settings']['show_title']) || $gt3_theme_pagebuilder['settings']['show_title'] !== "no") { 
                echo '<h1 class="title">';
                the_title();
                echo '</h1>';
            } ?>                
        </div>                    
        <div class="contentarea">
            <?php
            the_content(esc_html__('Read more!', 'geographic'));
            wp_link_pages(array('before' => '<div class="page-link">' . esc_html__('Pages', 'geographic') . ': ', 'after' => '</div>'));
            ?>
        </div>
	</div>
</div>
<div class="landing-border-left"></div>
<div class="landing-border-right"></div>

<?php gt3_the_pb_custom_bg_and_color(gt3_get_theme_pagebuilder(@get_the_ID())); ?>
<script>
	var center_container = jQuery('.centered_container');
	jQuery(document).ready(function(){
		centerWindow();
	});
	jQuery(window).load(function(){
		centerWindow();
	});
	jQuery(window).resize(function(){
		centerWindow();
		setTimeout('centerWindow()',500);
		setTimeout('centerWindow()',1000);
	});
	function centerWindow() {
		if (jQuery('#wpadminbar').size() > 0) {
			setTop = (myWindow.height() - header.height() - jQuery('#wpadminbar').height() - footer.height() - center_container.height())/2 + header.height() - jQuery('#wpadminbar').height();
			headerH = header.height();
		} else {
			setTop = (myWindow.height() - header.height() - footer.height() - center_container.height())/2 + header.height();
			headerH = header.height();
		}
		if (setTop < headerH+30) {
			center_container.addClass('fixed');
			jQuery('body').addClass('addPadding');
			center_container.css('top', headerH+30+'px');
			console.log('headerH:' + headerH+30);
		} else {
			center_container.css('top', setTop +'px');
			center_container.removeClass('fixed');
			jQuery('body').removeClass('addPadding');
			console.log('setTop:' + setTop+30);
		}
	}
</script>

<?php get_footer('fullscreen'); 
} else {
	get_header('fullscreen');
	echo "<div class='fixed_bg' style='background-image:url(".gt3_get_theme_option('bg_img').")'></div>";
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