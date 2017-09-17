<?php 
if ( !post_password_required() ) {
/* LOAD PAGE BUILDER ARRAY */
$gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());
$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'single-post-thumbnail' );
$pf = get_post_format();
$gt3_current_page_sidebar = $gt3_theme_pagebuilder['settings']['layout-sidebars'];

/* ADD 1 view for this post */
$post_views = (get_post_meta(get_the_ID(), "post_views", true) > 0 ? get_post_meta(get_the_ID(), "post_views", true) : "0");
update_post_meta(get_the_ID(), "post_views", (int)$post_views + 1);
wp_enqueue_script('gt3_cookie_js', get_template_directory_uri() . '/js/jquery.cookie.js', array(), false, true);
wp_enqueue_script('gt3_fsGallery_js', get_template_directory_uri() . '/js/fs_gallery.js', array(), false, true);

$gt3page_settings = gt3_get_theme_pagebuilder(@get_the_ID());		
if (isset($gt3page_settings['settings']['portfolio_style']) && $gt3page_settings['settings']['portfolio_style'] !== 'default') {
	$pf_showbg = $gt3page_settings['settings']['portfolio_style'];
} else {
	$pf_showbg = gt3_get_theme_option("default_portfolio_style");
}	

if($pf_showbg == 'pf-boxed') {
	get_header('fullscreen');
} else {
	get_header();
}


$all_likes = gt3pb_get_option("likes");
the_post();

$pft = get_post_format();
if ($pft !== "image" && $pft !== "video") {
	$pft = "standart";
}

if (!isset($gt3_theme_pagebuilder['settings']['show_title']) || $gt3_theme_pagebuilder['settings']['show_title'] !== "no") {
	$title = 'yes';
} else {
	$title = 'no';
}
if ((!isset($gt3_theme_pagebuilder['settings']['show_breadcrumb_area']) || $gt3_theme_pagebuilder['settings']['show_breadcrumb_area'] !== "no") && gt3_get_theme_option("show_breadcrumb_area") !== "no") {
	$bc = 'yes';
} else {
	$bc = 'no';
}
if($post->post_type == 'port' && $pf_showbg == 'pf-boxed') {
	echo '<div class="portfolio_boxed">';
}

if ($title == 'yes' || $bc == 'yes') { ?>
    <div class="breadcrumb_area">
    	<div class="container">
			<?php if ($title == 'yes') { ?>
                <div class="page_title_block">
                    <h1 class="title"><?php the_title(); ?></h1>
                </div>
            <?php } 
            if ($bc == 'yes') {
                gt3_the_breadcrumb(); 
            } ?>
        </div>
    </div>
<?php } ?>

<script>
	jQuery(document).ready(function(){
		iframe16x9(jQuery('.pf_output_container'));
	});
	jQuery(window).resize(function(){
		iframe16x9(jQuery('.pf_output_container'));
	});
	jQuery(window).load(function(){
		iframe16x9(jQuery('.pf_output_container'));
	});
</script>
<div class="content_wrapper">
	<div class="container is_page <?php echo esc_attr($gt3_theme_pagebuilder['settings']['layout-sidebars']) ?>">    
        <div class="content_block row">
            <div class="fl-container <?php echo(($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "right-sidebar") ? "hasRS" : ""); ?>">
                <div class="row">
                    <div class="posts-block <?php echo($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "hasLS" : ""); ?>">                    
                        <div class="contentarea">
							<?php 
                                $pft = get_post_format();
                                if ( $pft == "image" || $pft == "video") {
                                    echo get_pf_type_output(array("pf" => get_post_format(), "gt3_theme_pagebuilder" => $gt3_theme_pagebuilder, "width" => "1170", "height" => "760"));
                                } else {
                                    echo get_pf_type_output(array("pf" => get_post_format(), "gt3_theme_pagebuilder" => $gt3_theme_pagebuilder, "width" => "1170", "height" => "")); 
                                }										
                            ?>
                                <div class="featured_items_meta single_post_meta">
	                                <span><?php the_time("F d, Y"); ?></span>
                                    <span class="middot">&middot;</span>
                                    <span>									
										<?php 
                                            $terms = get_the_terms( get_the_ID(), 'portcat' );
                                            if ( $terms && ! is_wp_error( $terms ) ) {
                                                $draught_links = array();
                                                $tmp_categ = "";
                                                foreach ( $terms as $term ) {
                                                    $tmp_categ .= $term -> term_id .",";
                                                    $draught_links[] = '<a href="'.get_term_link($term->slug, "portcat").'">'.$term->name.'</a>';
                                                }
                                                $tmp_categ = mb_substr($tmp_categ, 0, -1);
                                                
                                                $on_draught = join( ", ", $draught_links );
                                                $show_cat = true;
                                            }
                                            if ($terms !== false) {
                                                echo $on_draught;
                                                $tmp_categ = $tmp_categ;
                                            } else {
                                                echo "Uncategorized";
                                                $tmp_categ = "";
                                            }
                                        ?>
                                    </span>
                                    <span class="middot">&middot;</span>
									<?php 
                                        if (isset($gt3_theme_pagebuilder['page_settings']['portfolio']['skills']) ? $socicons = $gt3_theme_pagebuilder['page_settings']['portfolio']['skills'] : $socicons = false);
                                        if (is_array($socicons)) {
                                            foreach ($socicons as $key => $value) {
                                                //$compile .= $value['data-icon-code'] . $value['name'] . $value['link'];
                                                if ($value['value'] == '') {
                                                    echo '
														<span class="skill_ico">'.$value['name'].'</span>
														<span class="middot">&middot;</span>';
                                                } else {
                                                    echo '
														<span class="skill_ico"><a href="'.$value['value'].'" title="'.$value['name'].'">'.$value['name'].'</a></span>
														<span class="middot">&middot;</span>';
                                                }
                                            }
                                        }												
                                    ?>   									                                 
                                    <span><a href="<?php echo get_comments_link(); ?>"><?php echo get_comments_number(get_the_ID())?> <?php esc_html_e('Comments', 'geographic'); ?></a></span>
                                </div>                                
                                <?php global $contentAlreadyPrinted;
                                if ($contentAlreadyPrinted !== true) {
									echo "<article class='contentarea single_contentarea'>";
                                    the_content(esc_html__('Read more!', 'geographic'));
                                }
								echo "</article>";
                                echo "<div class='clear'></div>";
                                wp_link_pages(array('before' => '<div class="page-link"><span class="pagger_info_text">' . esc_html__('Pages', 'geographic') . ': </span>', 'after' => '</div>', 'separator' => '<span class="middot">&middot;</span>'));
                                ?>
                                <div class="dn"><?php posts_nav_link(); ?></div>                                                                
                                <div class="ground_meta">
                                	<div class="single_left_side">
										<div class="gallery_likes_add single_likes <?php echo (isset($_COOKIE['like_post'.get_the_ID()]) ? "already_liked" : ""); ?>" data-attachid="<?php echo get_the_ID(); ?>" data-modify="like_post">
                                            <i class="stand_icon <?php echo (isset($_COOKIE['like_post'.get_the_ID()]) ? "icon-heart" : "icon-heart-o"); ?>"></i>
                                            <span><?php echo ((isset($all_likes[get_the_ID()]) && $all_likes[get_the_ID()]>0) ? $all_likes[get_the_ID()] : 0); ?></span>
                                        </div><!-- .preview_likes -->
                                        <div class="blogpost_share_wrapper">
                                        	<div class="blogpost_share_toggle">
                                            	<span class="blogpost_share_icon"></span><?php esc_html_e('Share', 'geographic'); ?>
                                            </div>
                                            <div class="blogpost_share hided_share">
                                                <a target="_blank"
                                                   href="http://www.facebook.com/share.php?u=<?php echo get_permalink(); ?>"
                                                   class="top_socials share_facebook"><i class="stand_icon icon-facebook"></i></a>
                                                <a target="_blank"
                                                   href="https://twitter.com/intent/tweet?text=<?php echo get_the_title(); ?>&amp;url=<?php echo get_permalink(); ?>"
                                                   class="top_socials share_tweet"><i class="stand_icon icon-twitter"></i></a>
                                                <a target="_blank"
                                                   href="https://plus.google.com/share?url=<?php echo get_permalink(); ?>"
                                                   class="top_socials share_gplus"><i class="icon-google-plus"></i></a>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
									</div>
                                    <div class="single_right_side">
                                        <div class="tags_area">
											<?php the_tags("", '', ''); ?>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
								</div><!-- .ground_meta -->
                                
                                <div class="page_navigation">
                                    <?php
                                        previous_post_link('<div class="post_prev">%link</div>', '<span class="post_prev-icon"></span><h5>' . esc_html__('Previous Post', 'geographic'). '</h5><span class="post_prev_caption">%title</span>');
                                        next_post_link('<div class="post_next">%link</div>', '<h5>'. esc_html__('Next Post', 'geographic'). '</h5><span class="post_next_caption">%title</span><span class="post_next-icon"></span>');
                                    ?>
                                    <div class="clear"></div>
                                </div>
                                
                                <?php 
                                if (gt3_get_theme_option("related_posts") == "on") {
                                    if ($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "no-sidebar") {
                                        $posts_per_line = 4;
                                    } else {
                                        $posts_per_line = 3;
                                    }

									if (is_gt3_builder_active()) {
										echo '<div class="row"><div class="span12 single_post_module module_cont module_small_padding featured_items single_feature featured_posts">';
										echo do_shortcode("[feature_portfolio
										heading_color=''
										heading_size='h3'
										heading_text=''
										number_of_posts=" . $posts_per_line . "
										posts_per_line=" . $posts_per_line . "
										selected_categories='" . $tmp_categ . "'
										sorting_type='random'
										related='yes'
										post_type='post'][/feature_portfolio]");
										echo '</div></div>';
									}
                                }
                            ?>
								<?php if (gt3_get_theme_option('portfolio_comments') == "enabled") {?>
                                <div class="row">
                                    <div class="span12">
                                        <?php comments_template(); ?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div><!-- .contentarea -->
                        </div>
                    <?php get_sidebar('left'); ?>
                </div>
            </div>
            <?php get_sidebar('right'); ?>
        </div>
    </div>
</div>
<?php
	$GLOBALS['showOnlyOneTimeJS']['gallery_likes'] = "
	<script>
		jQuery(document).ready(function($) {
			jQuery('.gallery_likes_add').on('click',function(){
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
if($post->post_type == 'port' && $pf_showbg == 'pf-boxed') {
	echo '</div>';
}

?>

<?php 
	if($pf_showbg == 'pf-boxed') {
		get_footer('fullscreen');
	} else {
		get_footer();
	}

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