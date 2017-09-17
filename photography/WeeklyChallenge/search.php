<?php get_header();
wp_enqueue_script('gt3_cookie_js', get_template_directory_uri() . '/js/jquery.cookie.js', array(), false, true);

#Emulate default settings for page without personal ID
$gt3_theme_pagebuilder = gt3_get_default_pb_settings();
$gt3_current_page_sidebar = $gt3_theme_pagebuilder['settings']['layout-sidebars'];
$compile_search = '';
?>

    <div class="content_wrapper search_page">
        <div class="container <?php echo esc_attr($gt3_theme_pagebuilder['settings']['layout-sidebars']) ?>">
            <div class="content_block row">
                <div
                    class="fl-container <?php echo(($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "right-sidebar") ? "hasRS" : ""); ?>">
                    <div class="row">
                        <div
                            class="posts-block <?php echo($gt3_theme_pagebuilder['settings']['layout-sidebars'] == "left-sidebar" ? "hasLS" : ""); ?>">
                            <div class="contentarea search_results">
                                <?php
                                echo '<div class="row-fluid"><div class="span12 module_cont module_blog module_search" style="margin:0">';
								if (isset($_GET['s']) && strlen($_GET['s']) > 0) {
									global $paged;
									$foundSomething = false;
	
									$defaults = array('numberposts' => 10, 'post_type' => 'any', 'post_status' => 'publish', 'post_password' => '', 'suppress_filters' => false, 's' => get_search_query(), 'paged' => $paged);
									$gt3_wp_query = http_build_query($defaults);
									$posts = get_posts($gt3_wp_query);
	
									foreach ($posts as $post) {
										$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
										if (strlen($featured_image[0]) > 0) {
											$hasImage = 'hasImage';
											$featured_img = '<div class="pf_output_container"><img src="' . aq_resize($featured_image[0], "1170", "", true, true, true) . '" /></div>';
										} else {
											$hasImage = 'noImage';
											$featured_img = '';
										}
	
										$pf = get_post_format();
										if ($pf == "image" || $pf == "video") {
											$pf_class = $pf;
										} else {
											$pf_class = 'standart';
										}
										setup_postdata($post);
										if (isset($posttags) && $posttags) {
											$post_tags = '';
											$post_tags_compile = '<span class="preview_meta_tags">tags:';
											foreach ($posttags as $tag) {
												$post_tags = $post_tags . '<a href="?tag=' . $tag->slug . '">' . $tag->name . '</a>' . ', ';
											}
											$post_tags_compile .= ' ' . trim($post_tags, ', ') . '</span>';
										} else {
											$post_tags_compile = '';
										}
	
										$compile_search .= '
											<div class="blog_post_preview">
												<div class="preview_content">
													<div class="preview_top_wrapper">
														<div class="fs_blog_top '. $pf_class .'">
															<h2 class="preview_blog_title"><a href="'. get_permalink() .'">' . get_the_title() . '</a></h2>
															<div class="featured_items_meta">
																<span>'. get_the_time("F d, Y") .'</span>
																<span class="middot">&middot;</span>
																<span>'. esc_html__('by', 'gt3_builder') .' <a href="'.get_author_posts_url( get_the_author_meta('ID')).'">'.get_the_author_meta('display_name').'</a></span>
																<span class="middot">&middot;</span>
																<span><a href="' . get_comments_link() . '">'. get_comments_number(get_the_ID()) .' '. esc_html__('comments', 'gt3_builder') .'</a></span>										
															</div>
														</div>
													</div>';
										$compile_search .= $featured_img;
										$fullContent = esc_html(get_the_content());
										$compile_search .= '<article class="contentarea">
														<a href="' . get_permalink() . '" class="preview_read_more">' . esc_html__('Read More', 'geographic') . '</a>
													</article>
												</div>
										</div><!--.blog_post_preview -->';
										$foundSomething = true;
									}
									echo $compile_search;
									echo gt3_get_theme_pagination();
	
									if ($foundSomething == false) {
										?>
										<h1 class="title"><?php echo esc_html__('Not Found!', 'geographic'); ?></h1>
										<div class="search_form_wrap">
											<form name="search_field" method="get"
												  action="<?php echo esc_url(home_url('/')); ?>"
												  class="search_form" style="margin-top: 14px; margin-bottom: 40px;">
												<input type="text" name="s"
													   value=""
													   placeholder="<?php esc_html_e('Search the site...', 'geographic'); ?>"
													   class="field_search">
											</form>
										</div>
										<?php
									}
								} else {
										?>
										<h1 class="title"><?php echo esc_html__('Not Found!', 'geographic'); ?></h1>
										<div class="search_form_wrap">
											<form name="search_field" method="get"
												  action="<?php echo esc_url(home_url('/')); ?>"
												  class="search_form" style="margin-top: 14px; margin-bottom: 40px;">
												<input type="text" name="s"
													   value=""
													   placeholder="<?php esc_html_e('Search the site...', 'geographic'); ?>"
													   class="field_search">
											</form>
										</div>
										<?php
								}

                                echo '</div><div class="clear"></div></div>';
                                ?>
                            </div>
                        </div>
                        <?php get_sidebar('left'); ?>
                    </div>
                </div>
                <?php get_sidebar('right'); ?>
                <div class="clear"></div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>