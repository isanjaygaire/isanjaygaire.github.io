<?php
$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
if (strlen($featured_image[0])>0) {
	$pf_url = $featured_image[0];
} else {
	$pf_url = gt3_get_theme_option("logo");
}

$gt3_theme_pagebuilder = gt3_get_theme_pagebuilder(get_the_ID());

if(get_the_category()) $categories = get_the_category();
$post_categ = '';
$separator = ', ';
if ($categories) {
    foreach($categories as $category) {
        $post_categ = $post_categ .'<a href="'.get_category_link( $category->term_id ).'">'.$category->cat_name.'</a>'.$separator;
    }
}

if(get_the_tags() !== '') {
    $posttags = get_the_tags();

}
if ($posttags) {
    $post_tags = '';
    $post_tags_compile = '<span class="preview_meta_tags">tags:';
    foreach($posttags as $tag) {
        $post_tags = $post_tags . '<a href="?tag='.$tag->slug.'">'.$tag->name .'</a>'. ', ';
    }
    $post_tags_compile .= ' '.trim($post_tags, ', ').'</span>';
} else {
    $post_tags_compile = '';
}
	if (!isset($pf)) {
		$compile = '';
	}

	if (strlen($featured_image[0]) > 0) {
		$hasImage = 'hasImage';
		$featured_img = '<div class="pf_output_container"><img src="'. aq_resize($featured_image[0], "1170", "", true, true, true) .'" /></div>';
	} else {
		$hasImage = 'noImage';
		$featured_img = '';
	}

	$all_likes = gt3pb_get_option("likes");
	
	$pf = get_post_format();
	if ($pf == "image" || $pf == "video") {
		$pf_class = $pf;
	} else {
		$pf_class = 'standart';
	}?>

        <div class="blog_post_preview">
			<div class="preview_content">
                <div class="preview_top_wrapper">
				    <?php echo $featured_img; ?>
					<div class="fs_blog_top <?php echo $pf_class; ?>">
                        <h2 class="preview_blog_title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="featured_items_meta">
                            <span><?php echo get_the_time("F d, Y") ?></span>
                            <span class="middot">&middot;</span>
                            <span><?php echo esc_html__('by', 'gt3_builder'); ?><a href="<?php echo get_author_posts_url( get_the_author_meta('ID')); ?>"><?php echo get_the_author_meta('display_name');?></a></span>
                            <span class="middot">&middot;</span>
                            <span><?php echo esc_html__('in', 'geographic'); echo" ".trim($post_categ, ', '); ?></span>
                            <span class="middot">&middot;</span>
                            <span><a href="<?php echo get_comments_link(); ?>"><?php echo get_comments_number(get_the_ID()); echo " ". esc_html__('comments', 'geographic');?></a></span>
                            <span class="middot">&middot;</span>
                            <?php echo $post_tags_compile; ?>
                            
                            <div class="gallery_likes_add preview_likes <?php echo (isset($_COOKIE['like_post'.get_the_ID()]) ? "already_liked" : ""); ?>" data-attachid="<?php echo get_the_ID(); ?>" data-modify="like_post">
                                <i class="stand_icon <?php echo (isset($_COOKIE['like_post'.get_the_ID()]) ? "icon-heart" : "icon-heart-o"); ?>"></i>
                                <span><?php echo ((isset($all_likes[get_the_ID()]) && $all_likes[get_the_ID()]>0) ? $all_likes[get_the_ID()] : 0); ?></span>
                            </div><!-- .preview_likes -->
                        </div>
                    </div>
                </div>
				<article class="contentarea">
                    <?php if (is_gt3_builder_active()) {
                        echo ((strlen(get_the_excerpt()) > 0) ? get_the_excerpt() : get_the_content());?>
                        <br class="clear">
                        <a href="<?php echo get_permalink(); ?>" class="preview_read_more"><?php esc_html_e('Continue Reading', 'geographic'); ?></a>
                    <?php } else {
                        if (strlen(get_the_excerpt()) > 0) {
                            echo get_the_excerpt(); ?>
                            <br class="clear">
                            <a href="<?php echo get_permalink(); ?>" class="preview_read_more"><?php esc_html_e('Continue Reading', 'geographic'); ?></a>
                        <?php } else {
                            the_content(esc_html__('Continue Reading', 'geographic'));
                        }
                    }?>                
                </article>
            </div>
        </div><!--.blog_post_preview -->

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