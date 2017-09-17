<?php

$gt3_tabs_admin_theme = new Tabs_admin_theme();

$gt3_tabs_admin_theme->add(new Tab_admin_theme(array(
    'name' => 'General',
    'desc' => '',
    'icon' => 'general.png',
    'icon_active' => 'general_active.png',
    'icon_hover' => 'general_hover.png'
), array(
    new UploadOption_admin_theme(array(
        'name' => 'Logo',
        'id' => 'logo',
        'desc' => 'Default: 131px x 27px',
        'default' => THEMEROOTURL . '/img/logo.png'
    )),
    new UploadOption_admin_theme(array(
        'name' => 'Logo (Retina)',
        'id' => 'logo_retina',
        'desc' => 'Default: 262px x 54px',
        'default' => THEMEROOTURL . '/img/retina/logo.png'
    )),
    new textOption_admin_theme(array(
        'name' => 'Logo width',
        'id' => 'logo_standart_width',
        'not_empty' => true,
        'width' => '100px',
        'textalign' => 'center',
        'default' => '131'
    )),
    new textOption_admin_theme(array(
        'name' => 'Logo height',
        'id' => 'logo_standart_height',
        'not_empty' => true,
        'width' => '100px',
        'textalign' => 'center',
        'default' => '27'
    )),

    new UploadOption_admin_theme(array(
        'name' => 'Landing logo',
        'id' => 'logo_landing',
        'desc' => 'Default: 262px x 54px',
        'default' => THEMEROOTURL . '/img/landing_logo.png'
    )),
    new UploadOption_admin_theme(array(
        'name' => 'Landing Logo (Retina)',
        'id' => 'logo_landing_retina',
        'desc' => 'Default: 524px x 108px',
        'default' => THEMEROOTURL . '/img/retina/landing_logo.png'
    )),	
    new textOption_admin_theme(array(
        'name' => 'Landing logo width',
        'id' => 'landing_logo_standart_width',
        'not_empty' => true,
        'width' => '100px',
        'textalign' => 'center',
        'default' => '262'
    )),
    new textOption_admin_theme(array(
        'name' => 'Landing logo height',
        'id' => 'landing_logo_standart_height',
        'not_empty' => true,
        'width' => '100px',
        'textalign' => 'center',
        'default' => '54'
    )),	

    new UploadOption_admin_theme(array(
        'type' => 'upload',
        'name' => 'Favicon',
        'id' => 'favicon',
        'desc' => 'Icon must be 16x16px or 32x32px. Please note that if you\'ve already uploaded the Site Icon in the Theme Customizer (Appearance -> Customize), the settings from the theme options panel will be ignored.',
        'default' => THEMEROOTURL . '/img/favico.ico'
    )),
    new UploadOption_admin_theme(array(
        'type' => 'upload',
        'name' => 'Apple touch icon (57px)',
        'id' => 'apple_touch_57',
        'desc' => 'Icon must be 57x57px. Please note that if you\'ve already uploaded the Site Icon in the Theme Customizer (Appearance -> Customize), the settings from the theme options panel will be ignored.',
        'default' => THEMEROOTURL . '/img/apple_icons_57x57.png'
    )),
    new UploadOption_admin_theme(array(
        'type' => 'upload',
        'name' => 'Apple touch icon (72px)',
        'id' => 'apple_touch_72',
        'desc' => 'Icon must be 72x72px. Please note that if you\'ve already uploaded the Site Icon in the Theme Customizer (Appearance -> Customize), the settings from the theme options panel will be ignored.',
        'default' => THEMEROOTURL . '/img/apple_icons_72x72.png'
    )),
    new UploadOption_admin_theme(array(
        'type' => 'upload',
        'name' => 'Apple touch icon (114px)',
        'id' => 'apple_touch_114',
        'desc' => 'Icon must be 114x114px. Please note that if you\'ve already uploaded the Site Icon in the Theme Customizer (Appearance -> Customize), the settings from the theme options panel will be ignored.',
        'default' => THEMEROOTURL . '/img/apple_icons_114x114.png'
    )),
    new TextareaOption_admin_theme(array(
        'name' => esc_html__('Copyright', 'geographic'),
        'id' => 'copyright',
        'default' => 'Copyright &copy; 2020 Geographic. All Rights Reserved.'
    )),
    new TextareaOption_admin_theme(array(
        'name' => esc_html__('Phone Number', 'geographic'),
        'id' => 'phone_number',
        'default' => '(845) 415-2693'
    )),
    new TextareaOption_admin_theme(array(
        'name' => esc_html__('Contact Address', 'geographic'),
        'id' => 'contact_address',
        'default' => '285 Lexington Ave, New York, NY'
    )),
    new TextareaOption_admin_theme(array(
        'name' => esc_html__('Contact Email', 'geographic'),
        'id' => 'contact_email',
        'default' => 'info@yoursite.com'
    )),	
	
    new TextareaOption_admin_theme(array(
        'name' => 'Any code <br>(before &lt;/head&gt;)',
        'id' => 'code_before_head',
        'default' => ''
    )),
    new TextareaOption_admin_theme(array(
        'name' => 'Any code <br>(before &lt;/body&gt;)',
        'id' => 'code_before_body',
        'default' => ''
    )),
    new AjaxButtonOption_admin_theme(array(
        'title' => 'Import Sample Data',
        'id' => 'action_import',
        'name' => esc_html__('Import demo content', 'geographic'),
        'confirm' => TRUE,
        'data' => array(
            'action' => 'ajax_import_dump'
        )
    ))
)));

$gt3_tabs_admin_theme->add(new Tab_admin_theme(array(
    'name' => 'Sidebars',
    'desc' => '',
    'icon' => 'sidebars.png',
    'icon_active' => 'sidebars_active.png',
    'icon_hover' => 'sidebars_hover.png'
), array(
    new SelectOption_admin_theme(array(
        'name' => 'Default sidebar layout',
        'id' => 'default_sidebar_layout',
        'desc' => '',
        'default' => 'right-sidebar',
        'options' => array(
            'left-sidebar' => 'Left sidebar',
            'right-sidebar' => 'Right sidebar',
            'no-sidebar' => 'Without sidebar'
        )
    )),
    new SidebarManager_admin_theme(array(
        'name' => 'Sidebar manager',
        'id' => 'sidebar_manager',
        'desc' => ''
    ))
)));

$gt3_tabs_admin_theme->add(new Tab_admin_theme(array(
    'name' => 'Fonts',
    'desc' => '',
    'icon' => 'fonts.png',
    'icon_active' => 'fonts_active.png',
    'icon_hover' => 'fonts_hover.png'
), array(
    new FontSelector_admin_theme(array(
        'name' => 'Content font',
        'id' => 'main_font',
        'desc' => '',
        'default' => 'Roboto',
        'options' => get_fonts_array_only_key_name()
    )),
    new textOption_admin_theme(array(
        'name' => 'Main font parameters',
        'id' => 'google_font_parameters_main_font',
        'not_empty' => true,
        'default' => ':300',
        'width' => '100%',
        'textalign' => 'left',
        'desc' => 'Google font. Click <a href="https://developers.google.com/webfonts/docs/getting_started" target="_blank">here</a> for help.'
    )),
    new FontSelector_admin_theme(array(
        'name' => 'Main menu font',
        'id' => 'main_menu_font',
        'desc' => '',
        'default' => 'Roboto',
        'options' => get_fonts_array_only_key_name()
    )),
    new textOption_admin_theme(array(
        'name' => 'Main menu font parameters',
        'id' => 'google_font_parameters_menu_font',
        'not_empty' => true,
        'default' => ':300',
        'width' => '100%',
        'textalign' => 'left',
        'desc' => 'Google font. Click <a href="https://developers.google.com/webfonts/docs/getting_started" target="_blank">here</a> for help.'
    )),
    new FontSelector_admin_theme(array(
        'name' => 'Headers',
        'id' => 'text_headers_font',
        'desc' => '',
        'default' => 'Roboto',
        'options' => get_fonts_array_only_key_name()
    )),
    new textOption_admin_theme(array(
        'name' => 'Headers font parameters',
        'id' => 'google_font_parameters_headers_font',
        'not_empty' => true,
        'default' => ':300,700',
        'width' => '100%',
        'textalign' => 'left',
        'desc' => 'Google font. Click <a href="https://developers.google.com/webfonts/docs/getting_started" target="_blank">here</a> for help.'
    )),
    new textOption_admin_theme(array(
        'name' => 'Content font weight',
        'id' => 'content_weight',
        'not_empty' => true,
        'default' => '300',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'H1, H3, H5 font weight',
        'id' => 'h1_weight',
        'not_empty' => true,
        'default' => '700',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'H2, H4, H6 font weight',
        'id' => 'h2_weight',
        'not_empty' => true,
        'default' => '300',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'Main menu font weight',
        'id' => 'menu_weight',
        'not_empty' => true,
        'default' => '300',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'Main menu font size',
        'id' => 'menu_font_size',
        'not_empty' => true,
        'default' => '14px',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'Sub menu font size',
        'id' => 'submenu_font_size',
        'not_empty' => true,
        'default' => '14px',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'H1 font size',
        'id' => 'h1_font_size',
        'not_empty' => true,
        'default' => '30px',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'H2 font size',
        'id' => 'h2_font_size',
        'not_empty' => true,
        'default' => '25px',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'H3 font size',
        'id' => 'h3_font_size',
        'not_empty' => true,
        'default' => '20px',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'H4 font size',
        'id' => 'h4_font_size',
        'not_empty' => true,
        'default' => '18px',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'H5 font size',
        'id' => 'h5_font_size',
        'not_empty' => true,
        'default' => '16px',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'H6 font size',
        'id' => 'h6_font_size',
        'not_empty' => true,
        'default' => '14px',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'Content font size',
        'id' => 'main_content_font_size',
        'not_empty' => true,
        'default' => '14px',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'Content line height',
        'id' => 'main_content_line_height',
        'not_empty' => true,
        'default' => '21px',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    )),
    new textOption_admin_theme(array(
        'name' => 'Paragraph Bottom Margin',
        'id' => 'p_bottom_margin',
        'not_empty' => true,
        'default' => '10px',
        'width' => '100px',
        'textalign' => 'center',
        'desc' => ''
    ))
)));

$gt3_tabs_admin_theme->add(new Tab_admin_theme(array(
    'name' => 'View Options',
    'icon' => 'layout.png',
    'icon_active' => 'layout_active.png',
    'icon_hover' => 'layout_hover.png'
), array(
    new SelectOption_admin_theme(array(
        'name' => 'Responsive',
        'id' => 'responsive',
        'desc' => '',
        'default' => 'on',
        'options' => array(
            'on' => 'On',
            'off' => 'Off'
        )
    )),
    new SelectOption_admin_theme(array(
        'name' => 'Preloader',
        'id' => 'show_preloader',
        'desc' => '',
        'default' => 'sticky_off',
        'options' => array(
            'on' => 'On',
            'off' => 'Off'
        )
    )),	
    new SelectOption_admin_theme(array(
        'name' => 'Sticky Header',
        'id' => 'header_style',
        'desc' => '',
        'default' => 'sticky_off',
        'options' => array(
            'sticky_on' => 'On',
            'sticky_off' => 'Off'
        )
    )),	
    new UploadOption_admin_theme(array(
        'type' => 'upload',
        'name' => 'Default background image',
        'id' => 'bg_img',
        'desc' => '',
        'default' => THEMEROOTURL . '/img/def_bg.jpg'
    )),
    new UploadOption_admin_theme(array(
        'type' => 'upload',
        'name' => '404 Page background image',
        'id' => 'bg_404',
        'desc' => '',
        'default' => THEMEROOTURL . '/img/bg_404.jpg'
    )),
    new UploadOption_admin_theme(array(
        'type' => 'upload',
        'name' => 'Landing background image',
        'id' => 'bg_landing',
        'desc' => '',
        'default' => THEMEROOTURL . '/img/bg_landing.jpg'
    )),
    new textOption_admin_theme(array(
        'name' => 'Grid Portfolio Items per page',
        'id' => 'fw_port_per_page',
        'not_empty' => true,
        'width' => '100px',
        'textalign' => 'center',
        'default' => '24'
    )),
	new SelectOption_admin_theme(array(
        'name' => 'Related Posts',
        'id' => 'related_posts',
        'desc' => '',
        'default' => 'on',
        'options' => array(
            'on' => 'On',
            'off' => 'Off'
        )
    )),
    new SelectOption_admin_theme(array(
        'name' => 'Default portfolio posts layout',
        'id' => 'default_portfolio_style',
        'desc' => '',
        'default' => 'pf-clean',
        'options' => array(
            'pf-clean' => 'Clean Layout',
			'pf-boxed' => 'Boxed Layout'
        )
    )),
    new SelectOption_admin_theme(array(
        'name' => 'Portfolio comments',
        'id' => 'portfolio_comments',
        'desc' => '',
        'default' => 'enabled',
        'options' => array(
            'disabled' => 'Disabled',
            'enabled' => 'Enabled'
        )
    )),	
    new SelectOption_admin_theme(array(
        'name' => 'Page comments',
        'id' => 'page_comments',
        'desc' => '',
        'default' => 'disabled',
        'options' => array(
            'disabled' => 'Disabled',
            'enabled' => 'Enabled'
        )
    )),
    new SelectOption_admin_theme(array(
        'name' => 'Post comments',
        'id' => 'post_comments',
        'desc' => '',
        'default' => 'enabled',
        'options' => array(
            'disabled' => 'Disabled',
            'enabled' => 'Enabled'
        )
    )),
    new SelectOption_admin_theme(array(
        'name' => esc_html__('Trackbacks and Pingbacks', 'geographic'),
        'id' => 'post_pingbacks',
        'desc' => '',
        'default' => 'disabled',
        'options' => array(
            'disabled' => esc_html__('Disabled', 'geographic'),
            'enabled' => esc_html__('Enabled', 'geographic')
        )
    )),	
    new SelectOption_admin_theme(array(
        'name' => esc_html__('WooCommerce Default Listing', 'geographic'),
        'id' => 'woo_listing',
        'desc' => '',
        'default' => 'simple',
        'options' => array(
            'simple' => esc_html__('Simple', 'geographic'),
            'fullwidth' => esc_html__('Fullwidth', 'geographic')
        )
    )),	
    new TextareaOption_admin_theme(array(
        'name' => 'Custom CSS',
        'id' => 'custom_css',
        'default' => ''
    ))
)));

$gt3_tabs_admin_theme->add(new Tab_admin_theme(array(
    'name' => esc_html__('Socials', 'geographic'),
    'icon' => 'social.png',
    'icon_active' => 'social_active.png',
    'icon_hover' => 'social_hover.png'
), array(
    new TextOption_admin_theme(array(
        'name' => esc_html__('Facebook', 'geographic'),
        'id' => 'social_facebook',
        'default' => 'http://facebook.com',
        'desc' => 'Please specify http:// to the URL'
    )),
    new TextOption_admin_theme(array(
        'name' => esc_html__('Flickr', 'geographic'),
        'id' => 'social_flickr',
        'default' => 'http://flickr.com',
        'desc' => 'Please specify http:// to the URL'
    )),
    new TextOption_admin_theme(array(
        'name' => esc_html__('Tumblr', 'geographic'),
        'id' => 'social_tumblr',
        'default' => 'http://tumblr.com',
        'desc' => 'Please specify http:// to the URL'
    )),
    new TextOption_admin_theme(array(
        'name' => esc_html__('Instagram', 'geographic'),
        'id' => 'social_instagram',
        'default' => 'http://instagram.com',
        'desc' => 'Please specify http:// to the URL'
    )),
    new TextOption_admin_theme(array(
        'name' => esc_html__('Twitter', 'geographic'),
        'id' => 'social_twitter',
        'default' => 'http://twitter.com',
        'desc' => 'Please specify http:// to the URL'
    )),

    new TextOption_admin_theme(array(
        'name' => esc_html__('Youtube', 'geographic'),
        'id' => 'social_youtube',
        'default' => 'https://www.youtube.com/',
        'desc' => 'Please specify http:// to the URL'
    )),
    new TextOption_admin_theme(array(
        'name' => esc_html__('Dribbble', 'geographic'),
        'id' => 'social_dribbble',
        'default' => 'http://dribbble.com/',
        'desc' => 'Please specify http:// to the URL'
    )),
    new TextOption_admin_theme(array(
        'name' => esc_html__('Google+', 'geographic'),
        'id' => 'social_gplus',
        'default' => 'https://plus.google.com/',
        'desc' => 'Please specify http:// to the URL'
    )),
    new TextOption_admin_theme(array(
        'name' => esc_html__('Vimeo', 'geographic'),
        'id' => 'social_vimeo',
        'default' => 'https://vimeo.com/',
        'desc' => 'Please specify http:// to the URL'
    )),
    new TextOption_admin_theme(array(
        'name' => esc_html__('Delicious', 'geographic'),
        'id' => 'social_delicious',
        'default' => 'https://delicious.com/',
        'desc' => 'Please specify http:// to the URL'
    )),
    new TextOption_admin_theme(array(
        'name' => esc_html__('Linked In', 'geographic'),
        'id' => 'social_linked',
        'default' => 'https://www.linkedin.com/',
        'desc' => 'Please specify http:// to the URL'
    )),
    new TextOption_admin_theme(array(
        'name' => esc_html__('Pinterest', 'geographic'),
        'id' => 'social_pinterest',
        'default' => 'http://pinterest.com',
        'desc' => 'Please specify http:// to the URL'
    )),
)));

$gt3_tabs_admin_theme->add(new Tab_admin_theme(array(
    'name' => 'Gallery Options',
    'icon' => 'landing.png',
    'icon_active' => 'landing_active.png',
    'icon_hover' => 'landing_hover.png'
), array(
    new SelectOption_admin_theme(array(
        'name' => 'Default Post Style',
        'id' => 'default_gallery_style',
        'desc' => '',
        'default' => 'fw-gallery-post',
        'options' => array(
            'fw-gallery-post' => 'Fullscreen Slider',
            'ribbon-gallery-post' => 'Ribbon Slider'
        )
    )),
    new SelectOption_admin_theme(array(
        'name' => 'Slider Animation',
        'id' => 'default_slider_anim',
        'desc' => '',
        'default' => 'fade',
        'options' => array(
            'fade' => 'Fade',
			'slip' => 'Slip'
        )
    )),
    new SelectOption_admin_theme(array(
        'name' => 'Slider Fit Style',
        'id' => 'default_fit_style',
        'desc' => '',
        'default' => 'no_fit',
        'options' => array(
            'no_fit' => 'Cover Slide',
			'fit_always' => 'Fit Always',
            'fit_width' => 'Fit Horizontal',
			'fit_height' => 'Fit Vertical'
        )
    )),	
    new SelectOption_admin_theme(array(
        'name' => 'Show Slider Controls',
        'id' => 'default_controls',
        'desc' => '',
        'default' => 'on',
        'options' => array(
            'on' => 'Yes',
            'off' => 'No'
        )
    )),
    new SelectOption_admin_theme(array(
        'name' => 'Autoplay',
        'id' => 'default_autoplay',
        'desc' => '',
        'default' => 'on',
        'options' => array(
            'on' => 'Yes',
            'off' => 'No'
        )
    )),
    new textOption_admin_theme(array(
        'name' => 'Slide Interval In Milliseconds',
        'id' => 'gallery_interval',
        'not_empty' => true,
        'width' => '100px',
        'textalign' => 'center',
        'default' => '3000'
    ))
)));

$gt3_tabs_admin_theme->add(new Tab_admin_theme(array(
    'name' => 'Color options',
    'icon' => 'colors.png',
    'icon_active' => 'colors_active.png',
    'icon_hover' => 'colors_hover.png'
), array(

    new ColorOption_admin_theme(array(
        'name' => 'Theme Color',
        'id' => 'theme_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '26a69a'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Body Background',
        'id' => 'background_bg',
        'desc' => '',
        'not_empty' => 'true',
        'default' => 'ffffff'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Breadcrumb Background',
        'id' => 'breadcrumb_bg',
        'desc' => '',
        'not_empty' => 'true',
        'default' => 'f6f7f9'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Sidebar Background',
        'id' => 'sidebar_bg',
        'desc' => '',
        'not_empty' => 'true',
        'default' => 'f6f7f9'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Headings Color',
        'id' => 'headings_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '161616'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Footer Color',
        'id' => 'footer_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '161616'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Content Color',
        'id' => 'content_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '505050'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Main Menu Color',
        'id' => 'menu_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '161616'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Main Menu Hover and Active Color',
        'id' => 'menu_color_hover',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '878787'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Sub-menu color',
        'id' => 'submenu_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '161616'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Sub-menu Active Color',
        'id' => 'submenu_active_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '878787'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Sub-menu Hover Color',
        'id' => 'submenu_hover_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '161616'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Sub-menu Hover Background',
        'id' => 'submenu_hover_bg',
        'desc' => '',
        'not_empty' => 'true',
        'default' => 'f6f7f9'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Sub-menu Border',
        'id' => 'submenu_border',
        'desc' => '',
        'not_empty' => 'true',
        'default' => 'f2f2f2'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Content Highlight Background',
        'id' => 'content_highlight_bg',
        'desc' => '',
        'not_empty' => 'true',
        'default' => 'bdbdbd'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Content Highlight Color',
        'id' => 'content_highlight',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '878787'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Content Highlight Dark',
        'id' => 'content_highlight_hovered',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '161616'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Content Items Border',
        'id' => 'content_borders',
        'desc' => '',
        'not_empty' => 'true',
        'default' => 'bebebe'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Light Content Item Background',
        'id' => 'light_item_bg',
        'desc' => '',
        'not_empty' => 'true',
        'default' => 'f6f7f9'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Light Content Item Color',
        'id' => 'light_item_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '161616'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Dark Content Item Background',
        'id' => 'dark_item_bg',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '161616'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Dark Content Item Color',
        'id' => 'dark_item_color',
        'desc' => '',
        'not_empty' => 'true',
        'default' => 'ffffff'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Price Table Item Odd',
        'id' => 'price_item_odd',
        'desc' => '',
        'not_empty' => 'true',
        'default' => 'eeeeee'
    )),
    new ColorOption_admin_theme(array(
        'name' => 'Price Table Item Even',
        'id' => 'price_item_even',
        'desc' => '',
        'not_empty' => 'true',
        'default' => 'f8f8f8'
    ))	
)));

?>