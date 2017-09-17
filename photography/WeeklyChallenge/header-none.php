<?php
$gt3page_settings = gt3_get_theme_pagebuilder(@get_the_ID());
$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
    <?php echo((gt3_get_theme_option("responsive") == "on") ? '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">' : ''); ?>
	<?php
    if (function_exists('has_site_icon') && has_site_icon()) {
    ?>
        <link rel="shortcut icon" href="<?php echo aq_resize(get_site_icon_url(), "32", "32", true, true, true); ?>" type="image/x-icon">
        <link rel="apple-touch-icon" href="<?php echo aq_resize(get_site_icon_url(), "57", "57", true, true, true); ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo aq_resize(get_site_icon_url(), "72", "72", true, true, true); ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo aq_resize(get_site_icon_url(), "114", "114", true, true, true); ?>">
    <?php
    } else {
    ?>
        <link rel="shortcut icon" href="<?php echo gt3_get_theme_option('favicon'); ?>" type="image/x-icon">
        <link rel="apple-touch-icon" href="<?php echo gt3_get_theme_option('apple_touch_57'); ?>">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo gt3_get_theme_option('apple_touch_72'); ?>">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo gt3_get_theme_option('apple_touch_114'); ?>">
    <?php
    }
    ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <script type="text/javascript">
        var gt3_ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>
    <?php echo gt3_get_if_strlen(gt3_get_theme_option("custom_css"), "<style>", "</style>") . gt3_get_if_strlen(gt3_get_theme_option("code_before_head"));
    globalJsMessage::getInstance()->render();
    wp_head();
    ?>
</head>

<body <?php body_class(array(gt3_the_pb_custom_bg_and_color(gt3_get_theme_pagebuilder(@get_the_ID()), array("classes_for_body" => true)))); ?>>