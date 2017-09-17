    <footer class="main_footer fullscreen_footer">
    	<div class="footer_left">        
        	<div class="copyright"><?php echo esc_html(gt3_the_theme_option("copyright")); ?></div>
        </div>
        <div class="footer_right">
	        <span class="address"><?php echo esc_html(gt3_the_theme_option("contact_address")); ?></span>
            <span class="footer_dot">&middot;</span>
			<span class="phone"><?php echo esc_html(gt3_the_theme_option("phone_number")); ?></span>            
            <span class="footer_dot">&middot;</span>
            <span class="email"><a href="mailto:<?php echo esc_html(gt3_the_theme_option("contact_email")); ?>"><?php echo esc_html(gt3_the_theme_option("contact_email")); ?></a></span>
        </div>
        <div class="clear"></div>
    </footer>
	<?php
		gt3_the_theme_option("code_before_body"); wp_footer();
    ?>
    <?php 
		$gt3page_settings = gt3_get_theme_pagebuilder(@get_the_ID());		
		if (isset($gt3page_settings['settings']['portfolio_style']) && $gt3page_settings['settings']['portfolio_style'] !== 'default') {
			$pf_showbg = $gt3page_settings['settings']['portfolio_style'];
		} else {
			$pf_showbg = gt3_get_theme_option("default_portfolio_style");
		}	
		if($post->post_type == 'port' && $pf_showbg == 'pf-boxed') {
			echo '<div class="landing-border-left"></div><div class="landing-border-right"></div>';
			gt3_the_pb_custom_bg_and_color(gt3_get_theme_pagebuilder(@get_the_ID()));
		}
	?>    
</body>
</html>