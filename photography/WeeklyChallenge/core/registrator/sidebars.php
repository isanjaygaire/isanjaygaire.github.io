<?php 

$all_sidebars = gt3_get_theme_sidebars_for_admin();

if (function_exists('register_sidebar')){
    
    #default values
    $register_sidebar_attr = array(
        'description' => esc_html__('Add the widgets appearance for Custom Sidebar. Drag the widget from the available list on the left, configure widgets options and click Save button. Select the sidebar on the posts or pages in just few clicks.', 'geographic'),
        'before_widget' => '<div class="sidepanel %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h5 class="sidebar_header">',
        'after_title' => '</h5>'
    );

    #REGISTER DEFAULT SIDEBARS
    $register_sidebar_attr['name'] = "Default";
    $register_sidebar_attr['id'] = 'page-sidebar-1';
    register_sidebar($register_sidebar_attr);

    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if (is_plugin_active('woocommerce/woocommerce.php')) {
        $register_sidebar_attr['name'] = "WooCommerce";
        $register_sidebar_attr['id'] = 'page-sidebar-99';
        register_sidebar($register_sidebar_attr);

		$register_woo_sidebar_attr['name'] = "WooCommerce Fullscreen Top Widgets";
        $register_woo_sidebar_attr['id'] = 'page-sidebar-95';
		$register_woo_sidebar_attr['before_title'] = '<h6 class="woo_topbar_header">';
		$register_woo_sidebar_attr['after_title'] = '</h6>';
		$register_woo_sidebar_attr['before_widget'] = '<div class="woo_topbar_widget %2$s">';
		$register_woo_sidebar_attr['after_widget'] = '</div>';
        register_sidebar($register_woo_sidebar_attr);
	}

    
    $sidebar_id = 100;
    if (is_array($all_sidebars)) {
        foreach ($all_sidebars as $sidebarName) {
            $register_sidebar_attr['name'] = $sidebarName;
            $register_sidebar_attr['id'] = 'page-sidebar-' . $sidebar_id++ ;
            register_sidebar($register_sidebar_attr);
            $sidebar_id++;
        }
    }
}

?>