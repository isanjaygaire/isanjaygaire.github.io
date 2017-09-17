<?php 
/*
Template Name: Half Screen Page
*/

if ( !post_password_required() ) {
	get_header('fullscreen'); 
	the_post();
	$gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
	if (!isset($gt3_theme_pagebuilder['settings']['show_title']) || $gt3_theme_pagebuilder['settings']['show_title'] !== "no") {
		$title = 'yes';
	} else {
		$title = 'no';
	}
?>

<div class="half_page_container">
    <div class="row">
        <div class="posts-block <?php echo($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "hasLS" : ""); ?>">                    
            <div class="contentarea">
				<?php if ($title == 'yes') { ?>
                    <div class="page_title_block">
                        <h1 class="title"><?php the_title(); ?></h1>
                    </div>
                <?php } ?>
            
                <?php
                the_content(esc_html__('Read more!', 'geographic'));
                wp_link_pages(array('before' => '<div class="page-link">' . esc_html__('Pages', 'geographic') . ': ', 'after' => '</div>'));
                if (gt3_get_theme_option('page_comments') == "enabled") {?>
                <hr class="comment_hr"/>
                <div class="row">
                    <div class="span12">
                        <?php comments_template(); ?>
                    </div>
                </div>							
                <?php }?>							
            </div>
        </div>
    </div>
</div>
<br class="clear">
<div class="landing-border-left"></div>
<?php gt3_the_pb_custom_bg_and_color(gt3_get_theme_pagebuilder(@get_the_ID())); ?>
<script>
	jQuery(document).ready(function(){
		jQuery('.custom_bg').addClass('half_custom_bg');
		setUpWindow();
	});
	jQuery(window).load(function(){
		setUpWindow();
	});
	jQuery(window).resize(function(){
		setUpWindow();
		setTimeout('setUpWindow()',500);
		setTimeout('setUpWindow()',1000);
	});
	function setUpWindow() {
		half_page_container.css('min-height', myWindow.height()-header.height() - footer.height());
	}
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