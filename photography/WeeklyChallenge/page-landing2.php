<?php
/*
Template Name: Landing Striped 
*/
if ( !post_password_required() ) {
get_header('none');
?>
	<?php $gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
   if (isset($gt3_theme_pagebuilder["strips"]["side1"]["opacity"]) && $gt3_theme_pagebuilder["strips"]["side1"]["opacity"] !== '') {
		$opacity1 = $gt3_theme_pagebuilder["strips"]["side1"]["opacity"];
	} else {
		$opacity1 = '0.5';
	}
   if (isset($gt3_theme_pagebuilder["strips"]["side2"]["opacity"]) && $gt3_theme_pagebuilder["strips"]["side2"]["opacity"] !== '') {
		$opacity2 = $gt3_theme_pagebuilder["strips"]["side2"]["opacity"];
	} else {
		$opacity2 = '0.5';
	}
    if (isset($gt3_theme_pagebuilder['strips']) && is_array($gt3_theme_pagebuilder['strips'])) {
        $strip_width = 50;
	?>
    	<style>
			.strip-landing-item .strip-landing-fadder {
				background:#<?php echo $gt3_theme_pagebuilder["strips"]["side2"]["fcolor"] ?>;
				opacity:0;
			}
			.strip-landing-item:hover .strip-landing-fadder {
				opacity:<?php echo $opacity2 ?>;
			}
			.strip-landing-item:first-child .strip-landing-fadder {
				background:#<?php echo $gt3_theme_pagebuilder["strips"]["side1"]["fcolor"] ?>;
				opacity:0;			
			}
			.strip-landing-item:first-child:hover .strip-landing-fadder {
				opacity:<?php echo $opacity1 ?>;
			}
		</style>
        <div class="strip-landing" data-width="<?php echo $strip_width; ?>" data-count="<?php echo count($gt3_theme_pagebuilder["strips"]); ?>">
            <?php foreach ($gt3_theme_pagebuilder['strips'] as $stripid => $stripdata) {
                if (!isset($stripdata['opacity']) || $stripdata['opacity'] == '') {
                    $opacity = '1';
                } else {
                    $opacity = $stripdata['opacity'];
                }
                ?>
            <div class="strip-landing-item" data-href="<?php echo $stripdata['link']; ?>" style="background-image:url(<?php echo wp_get_attachment_url($stripdata['attachid']); ?>); width:<?php echo $strip_width; ?>%;">
                <div class="strip-landing-fadder"></div>
                <div class="strip-landing-text">
                    <?php 
						if (isset($stripdata['striptitle1']) && $stripdata['striptitle1'] !== '') {
					?>
                    <a href="<?php echo $stripdata['link']; ?>"><h2 class="strip-landing-title"><?php echo $stripdata['striptitle1']; ?></h2></a>
                    <br class="clear"/>
                    <?php 
						}
						if (isset($stripdata['striptitle1']) && $stripdata['striptitle2'] !== '') {
					?>
                    	<span class="strip-landing-caption"><?php echo $stripdata['striptitle2']; ?></span>
                    <?php 
						}
					?>

                </div>
                <a href="<?php echo $stripdata['link']; ?>" class="strip-landing-link"></a>
            </div>
            <?php }?>
        </div>
        <div class="landing-border-top"></div>
		<div class="landing-border-bottom"></div>
        <div class="landing-border-left"></div>
        <div class="landing-border-right"></div>
        <script>
            jQuery(document).ready(function($) {
				strip_setup();
            });	
			jQuery(window).resize(function(){
				strip_setup();
				setTimeout("strip_setup()",500);
				setTimeout("strip_setup()",1000);
			});
			function strip_setup() {
				
			}
        </script>
    <?php } ?> 
<?php
get_footer('none'); 
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