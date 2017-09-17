<?php
if (post_password_required()) {
?>
<p class="nocomments"><?php esc_html_e('This post is password protected. Enter the password to view comments.','geographic') ; ?></p>
<?php return;
}
?>


<div id="comments">
    <?php // Do not delete these lines

    #Required for nested reply function that moves reply inline with JS
    if ( is_singular() ) wp_enqueue_script( 'comment-reply' );

    if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die ('Please do not load this page directly. Thanks!');

    ?>

    <!-- You can start editing here. -->
    <?php /* Begin Comments & Trackbacks */ ?>
    <?php if (have_comments()) : ?>
        <h3 class="headInModule postcomment"><?php echo comments_number( '0', '1', '%' ).' '; echo esc_html__('Comments','geographic').": "; ?></h3>
        <ol class="commentlist">
            <?php 
				if ( gt3_get_theme_option("post_pingbacks") == "enabled" ) {
					wp_list_comments('type=all&callback=gt3_theme_comment');
				} else {
					wp_list_comments('type=comment&callback=gt3_theme_comment');
				}			
			?>
        </ol>

        <div class="dn"><?php paginate_comments_links(); ?></div>
    <?php // End Comments ?>

    <?php else : // this is displayed if there are no comments so far ?>

    <?php if ('open' == $post->comment_status) : ?>
        <!-- If comments are open, but there are no comments. -->

        <?php else : // comments are closed ?>
        <!-- If comments are closed. -->
        <p><?php /*echo "Sorry, the comment form is closed at this time.";*/ ?></p>

        <?php endif; ?>
    <?php endif; ?>

    <?php if ('open' == $post->comment_status) :

    $comment_form = array(
        'fields' => apply_filters( 'comment_form_default_fields', array(
            'author' => '<label class="label-name"></label><input type="text" placeholder="'.esc_html__('Name *','geographic').'" title="'.esc_html__('Name *','geographic').'" id="author" name="author" class="form_field">',
            'email'  => '<label class="label-email"></label><input type="text" placeholder="'.esc_html__('Email *','geographic').'" title="'.esc_html__('Email *','geographic').'" id="email" name="email" class="form_field">',
            'url'    => '<label class="label-web"></label><input type="text" placeholder="'.esc_html__('URL','geographic').'" title="'.esc_html__('URL','geographic').'" id="web" name="url" class="form_field">'
        ) ),
        'comment_field' => '<label class="label-message"></label><textarea name="comment" cols="45" rows="5" placeholder="'.esc_html__('Message...','geographic').'" id="comment-message" class="form_field"></textarea>',
        'comment_form_before' => '',
        'comment_form_after' => '',
        'must_log_in' => esc_html__('You must be logged in to post a comment.','geographic'),
        'title_reply' => esc_html__('Leave a Comment!','geographic'),
        'label_submit' => esc_html__('Post Comment','geographic'),
        'logged_in_as' => '<p class="logged-in-as">' . esc_html__('Logged in as','geographic') . ' <a href="'.admin_url( 'profile.php' ).'">'.$user_identity.'</a>. <a href="'.wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) )).'">' . esc_html__('Log out?','geographic') . '</a></p>',
    );
    comment_form($comment_form, $post->ID);

    else : // Comments are closed ?>
    <p><?php esc_html_e('Sorry, the comment form is closed at this time.','geographic') ?></p>
    <?php endif; ?>
</div>
<script>
	jQuery(document).ready(function(){
		jQuery('.commentlist').find('li').each(function(){
			if (jQuery(this).find('ul').size() > 0) {
				jQuery(this).addClass('has_ul');
			}
		});
		jQuery('.form-allowed-tags').width(jQuery('#commentform').width() - jQuery('.form-submit').width() - 13);
		jQuery('.comment-reply-link').on('click', function(){
			jQuery('.form-allowed-tags').width(jQuery('#commentform').width() - jQuery('.form-submit').width() - 13);
		});
	});	
	jQuery(window).resize(function(){
		jQuery('.form-allowed-tags').width(jQuery('#commentform').width() - jQuery('.form-submit').width() - 13);
	});
</script>