<?php

#Upload images
add_action('wp_ajax_mix_ajax_post_action', 'mix_theme_upload_images');
function mix_theme_upload_images()
{
    if (is_admin()) {
        $save_type = $_POST['type'];

        if ($save_type == 'upload') {

            $clickedID = esc_attr($_POST['data']);
            $filename = $_FILES[$clickedID];
            $filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']);

            $override['test_form'] = false;
            $override['action'] = 'wp_handle_upload';
            $uploaded_file = wp_handle_upload($filename, $override);
            $upload_tracking[] = $clickedID;
            gt3_update_theme_option($clickedID, $uploaded_file['url']);
            if (!empty($uploaded_file['error'])) {
                echo 'Upload Error: ' . $uploaded_file['error'];
            } else {
                echo esc_url($uploaded_file['url']);
            }
        }
    }

    die();
}

#Upload images
add_action('wp_ajax_gt3_get_blog_posts', 'gt3_get_blog_posts');
add_action('wp_ajax_nopriv_gt3_get_blog_posts', 'gt3_get_blog_posts');
function gt3_get_blog_posts()
{
    $setPad = esc_attr($_REQUEST['set_pad']);
    if ($_REQUEST['template_name'] == "fw_blog_template") {
        $wp_query_get_blog_posts = new WP_Query();
        $args = array(
            'post_type' => esc_attr($_REQUEST['post_type']),
            'offset' => absint($_REQUEST['posts_already_showed']),
            'post_status' => 'publish',
            'cat' => esc_attr($_REQUEST['categories']),
            'posts_per_page' => absint($_REQUEST['posts_count'])
        );
        $wp_query_get_blog_posts->query($args);
        while ($wp_query_get_blog_posts->have_posts()) : $wp_query_get_blog_posts->the_post();
            $pf = get_post_format();
            if ($pf == "image" || $pf == "video") {
                $pf_class = $pf;
            } else {
                $pf_class = 'standart';
            }

            $all_likes = gt3pb_get_option("likes");
            $gt3_theme_pagebuilder = get_post_meta(get_the_ID(), "pagebuilder", true);

            if (get_the_category()) $categories = get_the_category();
            $post_categ = '';
            $separator = ', ';
            if ($categories) {
                foreach ($categories as $category) {
                    $post_categ = $post_categ . '<a href="' . get_category_link($category->term_id) . '">' . $category->cat_name . '</a>' . $separator;
                }
            }

            ?>
            <div <?php post_class("blogpost_preview_fw newLoaded anim_el loading"); ?>>
                <div class="fw_preview_wrapper featured_items">
                    <a href="<?php echo esc_js("javascript:void(0)"); ?>" class="fs_blog_loadmore"></a>

                    <div class="fs_img_block wrapped_img">
                        <?php if (get_post_format() !== 'video' && get_post_format() !== 'audio') {
                            echo '<a href="' . get_permalink() . '"></a>';
                        } ?>
                        <?php echo get_pf_type_output(array("pf" => get_post_format(), "gt3_theme_pagebuilder" => $gt3_theme_pagebuilder, "width" => '585', "height" => '', "fw_post" => true)); ?>
                    </div>
                    <div class="fs_blog_top <?php echo $pf_class ?>">
                        <h6 class="fs_blog_title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
                        </h6>

                        <div class="featured_items_meta">
                            <span><?php echo trim($post_categ, ', ') ?></span>
                            <span class="preview_meta_data"><?php echo get_the_time("F d, Y") ?></span>
                            <span><a
                                    href="<?php echo get_comments_link() ?>"><?php echo get_comments_number(get_the_ID());
                                    esc_html_e(' comments', 'geographic') ?></a></span>
                        </div>
                    </div>
                    <div class="fs_blog_content">
                        <?php
                        $post = get_post();
                        $post_excerpt = ((strlen($post->post_excerpt) > 0) ? smarty_modifier_truncate($post->post_excerpt, 170, "") : smarty_modifier_truncate(get_the_content(), 170, ""));
                        $post_excerpt .= '. <a href="' . get_permalink() . '" class="fs_read_more">' . esc_html__('Read more', 'geographic') . ' <i class="icon-angle-right"></i></a>';
                        echo $post_excerpt;
                        ?>
                    </div>
                </div>
            </div>
        <?php endwhile;
		wp_reset_postdata();
    }
    die();
}

#Get last slide ID
add_action('wp_ajax_get_unused_id_ajax', 'get_unused_id_ajax');
if (!function_exists('get_unused_id_ajax')) {
    function get_unused_id_ajax()
    {
        $lastid = gt3_get_theme_option("last_slide_id");
        if ($lastid < 3) {
            $lastid = 2;
        }
        $lastid++;

        $mystring = esc_url(home_url('/'));
        $findme = 'gt3themes';
        $pos = strpos($mystring, $findme);

        if ($pos === false) {
            echo $lastid;
        } else {
            echo str_replace(array("/", "-", "_"), "", substr(wp_get_theme()->get('ThemeURI'), -4, 3)) . date("d") . date("m") . $lastid;
        }

        gt3_update_theme_option("last_slide_id", $lastid);

        die();
    }
}


add_action('wp_ajax_add_like_post', 'gt3_add_like_post');
add_action('wp_ajax_nopriv_add_like_post', 'gt3_add_like_post');
function gt3_add_like_post()
{
    $post_id = absint($_POST['post_id']);
    $post_likes = (get_post_meta($post_id, "post_likes", true) > 0 ? get_post_meta($post_id, "post_likes", true) : "0");
    $new_likes = absint($post_likes) + 1;
    update_post_meta($post_id, "post_likes", $new_likes);
    echo $new_likes;
    die();
}

#Load portfolio works
add_action('wp_ajax_get_portfolio_works', 'get_portfolio_works');
add_action('wp_ajax_nopriv_get_portfolio_works', 'get_portfolio_works');
if (!function_exists('get_portfolio_works')) {
    function get_portfolio_works()
    {
        $port_style = esc_attr($_REQUEST['set_pad']);

		$aq_width = "570px";
		$aq_height = "430px";
		
		if ($port_style == "port_style_grid") {
			$aq_width = "570px";
			$aq_height = "430px";
		} 
		if ($port_style == "port_style_2col") {
			$aq_width = "960px";
			$aq_height = "700px";
		} 
		if ($port_style == "port_style_3col") {
			$aq_width = "640px";
			$aq_height = "480px";
		} 
		if ($port_style == "port_style_4col") {
			$aq_width = "570px";
			$aq_height = "430px";
		} 

        $html_template = esc_attr($_POST['template_name']);
        $now_open_works = absint($_POST['posts_already_showed']);
        $works_per_load = absint($_POST['posts_count']);
        $category = esc_attr($_POST['categories']);
        $post_type_field = esc_attr($_POST['post_type_field']);
        $gt3_wp_query = new WP_Query();
        $args = array(
            'post_type' => 'port',
            'order' => 'DESC',
            'post_status' => 'publish',
            'offset' => $now_open_works,
            'posts_per_page' => $works_per_load,
        );

        if (strlen($category) > 0) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'portcat',
                    'field' => $post_type_field,
                    'terms' => ($post_type_field == "slug" ? $category : explode(",", $category))
                )
            );
        }

        $gt3_wp_query->query($args);
        //$i = 1;

        while ($gt3_wp_query->have_posts()) : $gt3_wp_query->the_post();
            $pf = get_post_format();
            if (empty($pf)) $pf = "text";
            $pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());

            $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()), 'single-post-thumbnail');
            if (strlen($featured_image[0]) < 1) {
                $featured_image[0] = IMGURL . "/core/your_image_goes_here.jpg";
            }

            if (isset($pagebuilder['settings']['external_link']) && strlen($pagebuilder['settings']['external_link']) > 0) {
                $linkToTheWork = $pagebuilder['settings']['external_link'];
                $target = "target='_blank'";
            } else {
                $linkToTheWork = get_permalink();
                $target = "";
            }

            if (isset($pagebuilder['settings']['time_spent']) && strlen($pagebuilder['settings']['time_spent']) > 0) {
                $time_spent_value = $pagebuilder['settings']['time_spent'];
                $time_spent_html = '<div class="portfolio_descr_time">' . ((get_theme_option("translator_status") == "enable") ? get_text("translator_time_spent") : esc_html__('Time spent', 'geographic')) . ': <span>' . $time_spent_value . '</span></div>';
            } else {
                $time_spent_value = '';
                $time_spent_html = '';
            }

            if (!isset($echoallterm)) {
                $echoallterm = '';
            }
            $new_term_list = get_the_terms(get_the_id(), "portcat");
            if (is_array($new_term_list)) {
                foreach ($new_term_list as $term) {
                    $tempname = strtr($term->name, array(
                        ' ' => '-',
                    ));
                    $echoallterm .= strtolower($tempname) . " ";
                    $echoterm = $term->name;
                }
            }

            #Portfolio grid
            $all_likes = gt3pb_get_option("likes");
            $gt3_theme_post = get_plugin_pagebuilder(get_the_ID());
            $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
			$featured_alt = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
            $pf = get_post_format();
            $target = (isset($gt3_theme_post['settings']['new_window']) && $gt3_theme_post['settings']['new_window'] == "on" ? "target='_blank'" : "");
            if (isset($gt3_theme_post['page_settings']['portfolio']['work_link']) && strlen($gt3_theme_post['page_settings']['portfolio']['work_link']) > 0) {
                $linkToTheWork = esc_url($gt3_theme_post['page_settings']['portfolio']['work_link']);
            } else {
                $linkToTheWork = get_permalink();
            }
            $echoallterm = '';
            $portCateg = '';
            $photoTitle = get_the_title();
            if ($_REQUEST['template_name'] == "port_canvas") { ?>
                <div <?php post_class("portfolio-canvas-item loading anim_el newLoaded" . $echoallterm); ?>
                    data-category="<?php echo $echoallterm ?>">
                    <div class="portfolio_item_block">
                        <div class="portfolio_item_wrapper">
                            <div class="port_img_block">
                                <div class="portfolio-canvas-fadder"></div>
                                <img src="<?php echo aq_resize($featured_image[0], "570", "", true, true, true) ?>"
                                     alt="<?php echo $featured_alt ?>">
                                <a target="<?php echo $target ?>" href="<?php echo $linkToTheWork ?>"></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
            if ($_REQUEST['template_name'] == "port_listing_isotope") { ?>
                <div <?php post_class("portfolio-listing-item loading anim_el newLoaded element " . $echoallterm); ?>
                    data-category="<?php echo $echoallterm ?>">
                    <div class="portfolio_item_block">
                        <div class="portfolio_item_wrapper">
                            <a target="<?php echo $target ?>" href="<?php echo $linkToTheWork ?>">
                                <div class="img_block wrapped_img">                            
                                    <img src="<?php echo aq_resize($featured_image[0], $aq_width, $aq_height, true, true, true) ?>" alt="<?php echo $featured_alt ?>">
                                    <div class="featured_item_fadder"></div>
                                    <span class="plus_icon"></span>
                                    <span class="featured_portfolio_title"><?php echo get_the_title(); ?></span>
                                </div>
                            </a>
                        </div>						
                    </div>
                </div>
            <?php }

            if ($_REQUEST['template_name'] == "port_listing") { ?>
                <div <?php post_class("portfolio-listing-item newLoaded loading anim_el"); ?>>
                    <div class="portfolio_item_block">
                        <div class="portfolio_item_wrapper">
                            <a target="<?php echo $target ?>" href="<?php echo $linkToTheWork ?>">
                                <div class="img_block wrapped_img">                            
                                    <img src="<?php echo aq_resize($featured_image[0], $aq_width, $aq_height, true, true, true) ?>" alt="<?php echo $featured_alt ?>">
                                    <div class="featured_item_fadder"></div>
                                    <span class="plus_icon"></span>
                                    <span class="featured_portfolio_title"><?php echo get_the_title(); ?></span>
                                </div>
                            </a>
                        </div>						
                    </div>
                </div>
                <?php
            }
            #END

            //$i++;
            //unset($echoallterm, $pf);
        endwhile;
		wp_reset_postdata();
        die();
    }
}

#Load gallery works
add_action('wp_ajax_get_gallery_works', 'get_gallery_works');
add_action('wp_ajax_nopriv_get_gallery_works', 'get_gallery_works');
if (!function_exists('get_gallery_works')) {
    function get_gallery_works()
    {
        $openID = absint($_POST['current_id']);
        $pagebuilder = gt3_get_theme_pagebuilder($openID);
		$slider_compile = '';
		$slide_num = 1;
        ?>        
            <?php if (isset($pagebuilder['sliders']['fullscreen']['slides']) && is_array($pagebuilder['sliders']['fullscreen']['slides'])) {
                    foreach ($pagebuilder['sliders']['fullscreen']['slides'] as $imageid => $image) {
                        $uniqid = mt_rand(0, 9999);
                        if (isset($image['title']['value']) && strlen($image['title']['value'])>0) {$photoTitle = $image['title']['value'];} else {$photoTitle = "";}
                        if (isset($image['caption']['value']) && strlen($image['caption']['value'])>0) {$photoCaption  = $image['caption']['value'];} else {$photoCaption = "";}						
						
                        if ($image['slide_type'] == 'image') {
							$src_type = 'image';
							$src = wp_get_attachment_url($image['attach_id']);
                        } else if ($image['slide_type'] == 'video') {
                            #YOUTUBE							
                            $is_youtube = substr_count($image['src'], "youtu");
                            if ($is_youtube > 0) {
								$src_type = 'youtube';
								$src = substr(strstr($image['src'], "="), 1);
                            }
                            #VIMEO
                            $is_vimeo = substr_count($image['src'], "vimeo");
                            if ($is_vimeo > 0) {								
								$src_type = 'vimeo';
								$src = substr(strstr($image['src'], "m/"), 2);
							}
                        }            
							$slider_compile .= '<li class="ajax_slide as_slide'. $slide_num .'" data-title="'. $photoTitle .'" data-caption="'. $photoCaption .'" data-type="'. $src_type .'" data-src="'. $src .'" data-count="'. $slide_num .'"></li>';
						$slide_num++;
                	}
				} else { 
					$slider_compile .= '<li class="ajax_slide empty"><h2>'. esc_html__('No Images', 'geographic') .'</h2></li>';
				} ?>
        <?php
        echo $slider_compile;
		die();
    }
}

#Ajax import xml
add_action('wp_ajax_ajax_import_dump', 'ajax_import_dump');
if (!function_exists('ajax_import_dump')) {
    function ajax_import_dump()
    {
        if (is_admin()) {
            if (!defined('WP_LOAD_IMPORTERS')) {
                define('WP_LOAD_IMPORTERS', true);
            }

            require_once(TEMPLATEPATH . '/core/xml-importer/importer.php');

            try {
                ob_start();
                $importer = new WP_Import();
                $importer->import(TEMPLATEPATH . '/core/xml-importer/import.xml');
                ob_clean();
            } catch (Exception $e) {
                die(json_encode(array(
                    'message' => $e->getMessage()
                )));
            }
            die(json_encode(array(
                'message' => 'Data was imported successfully'
            )));
        }
    }
}

add_action( 'wp_ajax_add_like_attachment', 'gt3_add_like' );
add_action( 'wp_ajax_nopriv_add_like_attachment', 'gt3_add_like' );
function gt3_add_like() {
    $all_likes = gt3pb_get_option("likes");
    $attach_id = absint($_POST['attach_id']);
    $all_likes[$attach_id] = (isset($all_likes[$attach_id]) ? $all_likes[$attach_id] : 0)+1;
    gt3pb_update_option("likes", $all_likes);
    echo $all_likes[$attach_id];
    die();
}
