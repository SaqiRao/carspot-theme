<?php
/**
 * For full documentation, please visit: http://docs.reduxframework.com/
 * For a more extensive sample-config file, you may look at:
 * https://github.com/reduxframework/redux-framework/blob/master/sample/sample-config.php
 */
if (!class_exists('Redux')) {
    return;
}

// This is your option name where all the Redux data is stored.
$opt_name = "carspot_theme";
/**
 * SET ARGUMENTSPublic Profile
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */
$theme = wp_get_theme(); // For use with some settings. Not necessary.
$args = array(
    'opt_name' => 'carspot_theme',
    'dev_mode' => false,
    'display_name' => esc_html__('Theme Options', 'carspot'),
    'display_version' => wp_get_theme()->get('Version'),
    'page_title' => esc_html__('Theme Options', 'carspot'),
    'update_notice' => true,
    'admin_bar' => true,
    'menu_type' => 'submenu',
    'menu_title' => esc_html__('Theme Options', 'carspot'),
    'allow_sub_menu' => true,
    'page_parent_post_type' => 'your_post_type',
    'customizer' => true,
    'default_show' => true,
    'default_mark' => '*',
    'hints' => array(
        'icon_position' => 'right',
        'icon_size' => 'normal',
        'tip_style' => array(
            'color' => 'light',
        ),
        'tip_position' => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect' => array(
            'show' => array(
                'duration' => '500',
                'event' => 'mouseover',
            ),
            'hide' => array(
                'duration' => '500',
                'event' => 'mouseleave unfocus',
            ),
        ),
    ),
    'output' => true,
    'output_tag' => true,
    'settings_api' => true,
    'cdn_check_time' => '1440',
    'compiler' => true,
    'global_variable' => 'carspot_theme',
    'page_permissions' => 'manage_options',
    'save_defaults' => true,
    'show_import_export' => true,
    'database' => 'options',
    'transient_time' => '3600',
    'network_sites' => true,
);

$args['share_icons'][] = array(
    'url' => 'https://www.facebook.com/scriptsbundle',
    'title' => esc_html__('Like us on Facebook', 'carspot'),
    'icon' => 'el el-facebook'
);

Redux::setArgs($opt_name, $args);
/*
 * ---> END ARGUMENTS

 * ---> START HELP TABS
 */
$tabs = array(
    array(
        'id' => 'redux-help-tab-1',
        'title' => esc_html__('Theme Information 1', 'carspot'),
        'content' => esc_html__('<p>This is the tab content, HTML is allowed.</p>', 'carspot')
    ),
    array(
        'id' => 'redux-help-tab-2',
        'title' => esc_html__('Theme Information 2', 'carspot'),
        'content' => esc_html__('<p>This is the tab content, HTML is allowed.</p>', 'carspot')
    )
);
Redux::setHelpTab($opt_name, $tabs);

// Set the help sidebar
$content = esc_html__('<p>This is the sidebar content, HTML is allowed.</p>', 'carspot');
Redux::setHelpSidebar($opt_name, $content);
/*
 * <--- END HELP TABS

 * ---> START SECTIONS
 *
 */
/* ------------------Header Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('General', 'carspot'),
    'id' => 'sb_theme_generalr',
    'desc' => '',
    'icon' => 'el el-wrench',
    'fields' => array(
        array(
            'id' => 'sb_admin_translate',
            'type' => 'switch',
            'title' => esc_html__('Is Admin translated', 'carspot'),
            'desc' => esc_html__('After saving please refresh it.', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'sb_demo_mode',
            'type' => 'switch',
            'title' => esc_html__('Demo mode', 'carspot'),
            'desc' => esc_html__('This will be used only for the demo purposes.', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'sb_pre_loader',
            'type' => 'switch',
            'title' => esc_html__('Pre Page Loader', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'theme_loader_type',
            'type' => 'button_set',
            'title' => esc_html__('Pre loader Styles ', 'carspot'),
            'options' => array(
                'classic' => esc_html__('Classic', 'carspot'),
                'modern' => esc_html__('Modern', 'carspot'),
            ),
            'required' => array('sb_pre_loader', '=', true),
            'default' => 'modern'
        ),
        array(
            'id' => 'theme_loader_type_modern',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Default Preloade Image', 'carspot'),
            'compiler' => 'true',
            'subtitle' => esc_html__('Dimensions: 200 x 200', 'carspot'),
            'required' => array(array('sb_pre_loader', '=', true), array('theme_loader_type', '=', 'modern')),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/sb-loader.gif'),
        ),
        array(
            'id' => 'sb_color_plate',
            'type' => 'switch',
            'title' => esc_html__('Color Plate', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'theme_color',
            'type' => 'button_set',
            'title' => esc_html__('Theme Colors', 'carspot'),
            'options' => array(
                'defualt' => esc_html__('Default', 'carspot'),
                'green' => esc_html__('Green', 'carspot'),
                'purple' => esc_html__('Purple', 'carspot'),
                'blue' => esc_html__('Blue', 'carspot'),
                'gold' => esc_html__('Gold', 'carspot'),
            ),
            'default' => 'defualt'
        ),
        array(
            'id' => 'admin_bar',
            'type' => 'switch',
            'title' => esc_html__('Admin Bar', 'carspot'),
            'subtitle' => esc_html__('wordpress', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'scroll_to_top',
            'type' => 'switch',
            'title' => esc_html__('Scroll to top', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'crop_ad_images',
            'type' => 'switch',
            'title' => esc_html__('Crop Images Forcefully', 'carspot'),
            'default' => true,
            'desc' => esc_html__('Note : After Enable/Disable Please Run the "Force Regenerate Thumbnails" plugin for regenerate image sizes.', 'carspot'),
        ),
        array(
            'id' => 'sb_user_dp',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Default user picture', 'carspot'),
            'compiler' => 'true',
            'subtitle' => esc_html__('Dimensions: 200 x 200', 'carspot'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/users/1.jpg'),
        ),
        array(
            'id' => 'rental-bread-image',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Default Rentals Breadcrumb picture', 'carspot'),
            'compiler' => 'true',
            'subtitle' => esc_html__('Dimensions: 200 x 200', 'carspot'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/users/1.jpg'),
        ),
        array(
            'id' => 'show_banners_on_product',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Rental Search picture', 'carspot'),
            'compiler' => 'true',
            'subtitle' => esc_html__('Dimensions: 200 x 200', 'carspot'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/users/1.jpg'),
        ),
        array(
            'id' => 'block_or_simple_widget',
            'type' => 'button_set',
            'title' => esc_html__('Simple/Block Editor Widget View', 'carspot'),
            'options' => array(
                'simple_widget' => esc_html__('Simple Widgets', 'carspot'),
                'block_editor' => esc_html__('Block Editor Widgets', 'carspot'),
            ),
            'default' => 'simple_widget'
        ),
        array(
            'id' => 'cs_register_proces',
            'type' => 'switch',
            'title' => esc_html__('Registration Process', 'carspot'),
            'default' => true,
            'desc' => esc_html__('Note : After Enable, Then you can use Registration Process.', 'carspot'),
        ),

       
    )
));

/* ------------------Header Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Header', 'carspot'),
    'id' => 'sb_theme_header',
    'desc' => '',
    'icon' => 'el el-arrow-up',
    'fields' => array(
        array(
            'id' => 'sb_header',
            'type' => 'button_set',
            'title' => esc_html__('Header Style', 'carspot'),
            'options' => array(
                'white' => 'Modern',
                'black' => 'Classic',
                'services' => 'Services',
                'shop' => 'Shop',
                'transparent' => 'Transparent 1',
                'transparent2' => 'Transparent With Searchbar',
                'new' => 'New Header',
                'elementorProHeader' => 'Elementor Pro Header',
            ),
            'default' => 'white'
        ),
        array(
            'id' => 'trans_bread_img',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Select Transparent Breadcrumb Image', 'carspot'),
            'compiler' => 'true',
            'required' => array('sb_header', '=', array('transparent', 'transparent2')),
            'desc' => esc_html__('Site Logo image for the site.', 'carspot'),
            'subtitle' => esc_html__('A good resolution images', 'carspot'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        ),
        array(
            'id' => 'sb_top_bar',
            'type' => 'switch',
            'title' => esc_html__('Top Bar', 'carspot'),
            'default' => true,
            'required' => array('sb_header', '=', array('white', 'black', 'services', 'shop', 'new')),
        ),
        array(
            'id' => 'top_bar_color',
            'type' => 'button_set',
            'title' => esc_html__('Top Bar Color', 'carspot'),
            'required' => array('sb_top_bar', '=', true),
            'options' => array(
                'dark' => 'Black',
                'colored' => 'Colored',
            ),
            'default' => 'colored'
        ),
        array(
            'id' => 'top_bar_type',
            'type' => 'button_set',
            'title' => esc_html__('Top Bar Type', 'carspot'),
            'required' => array('sb_top_bar', '=', true),
            'options' => array(
                'classified' => 'Classified',
                'services' => 'Services',
                'modern' => 'Modern',
            ),
            'default' => 'classified'
        ),
        array(
            'id' => 'sb_sticky_header',
            'type' => 'switch',
            'title' => esc_html__('Sticky Menu', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'ad_contact_number',
            'type' => 'text',
            'title' => esc_html__('Contact Number', 'carspot'),
            'required' => array(array('sb_header', '=', 'new')),
            'default' => '0302-56666-8989',
        ),
        array(
            'id' => 'top_bar_pages',
            'type' => 'select',
            'data' => 'pages',
            'multi' => false,
            'sortable' => true,
            'title' => esc_html__('Select Pages', 'carspot'),
            'subtitle' => esc_html__('for top bar', 'carspot'),
            'required' => array('sb_top_bar', '=', true),
        ),
        array(
            'id' => 'sb_sign_in_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Sign In Page', 'carspot'),
            'required' => array('top_bar_type', '=', array('classified', 'modern'), array('sb_header', '=', 'new')),
            'default' => array('6'),
        ),
        array(
            'id' => 'sb_sign_up_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Sign Up Page', 'carspot'),
            'required' => array(array('sb_top_bar', '=', true), array('top_bar_type', '=', array('classified', 'modern'))),
            'default' => array('10'),
        ),
        array(
            'id' => 'sb_profile_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Profile Page', 'carspot'),
            'required' => array(array('sb_top_bar', '=', true), array('top_bar_type', '=', array('classified', 'modern'))),
            'default' => array('15'),
        ),
        array(
            'id' => 'sb_post_ad_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Ad Post Page', 'carspot'),
            'required' => array('top_bar_type', '=', 'classified'),
            'default' => array('17'),
        ),

        array(
            'id' => 'post_sellme_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Sell For Me Add', 'carspot'),
            'default' => array('3249'),
        ),
        array(
            'id' => 'sb_site_logo',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Logo', 'carspot'),
            'compiler' => 'true',
            'desc' => esc_html__('Site Logo image for the site.', 'carspot'),
            'subtitle' => esc_html__('Dimensions: 230 x 40', 'carspot'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        ),
        array(
            'id' => 'sb_site_logo_light',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Logo on Sticky', 'carspot'),
            'compiler' => 'true',
            'desc' => esc_html__('Site Logo image for the site.', 'carspot'),
            'subtitle' => esc_html__('Dimensions: 230 x 40', 'carspot'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        ),
        array(
            'id' => 'for_email',
            'type' => 'rane_text',
            'rane_field_2' => true,
            'rane_field_3' => false,
            'title' => esc_html__('Your Email Address', 'carspot'),
            'placeholder' => array(
                'rane_field_1' => esc_html__('Main Title', 'carspot'),
                'rane_field_2' => esc_html__('columns', 'carspot'),
            ),
            'default' => array(
                'rane_field_1' => 'Email Us',
                'rane_field_2' => 'contact@scriptsundle.com',
            ),
            'description' => esc_html__('Plase enter your main title and email adress', 'carspot'),
            'required' => array(array('sb_header', '=', 'services')),
        ),
        array(
            'id' => 'for_call',
            'type' => 'rane_text',
            'rane_field_2' => true,
            'rane_field_3' => false,
            'title' => esc_html__('Your Contact No', 'carspot'),
            'placeholder' => array(
                'rane_field_1' => esc_html__('Main Title', 'carspot'),
                'rane_field_2' => esc_html__('Contact No', 'carspot'),
            ),
            'default' => array(
                'rane_field_1' => 'Call Now',
                'rane_field_2' => '(92) 123-456-78',
            ),
            'description' => esc_html__('Plase enter your main title and contact No', 'carspot'),
            'required' => array(array('sb_header', '=', 'services')),
        ),
        array(
            'id' => 'for_location',
            'type' => 'rane_text',
            'rane_field_2' => true,
            'rane_field_3' => false,
            'title' => esc_html__('Your Location', 'carspot'),
            'placeholder' => array(
                'rane_field_1' => esc_html__('Main Title', 'carspot'),
                'rane_field_2' => esc_html__('Location', 'carspot'),
            ),
            'default' => array(
                'rane_field_1' => 'Find Us',
                'rane_field_2' => 'Model Town, London',
            ),
            'description' => esc_html__('Plase enter your main title and location adress', 'carspot'),
            'required' => array(array('sb_header', '=', 'services')),
        ),
        array(
            'id' => 'ad_in_menu',
            'type' => 'switch',
            'title' => esc_html__('Post A AD', 'carspot'),
            'subtitle' => esc_html__('Show Button in Menu', 'carspot'),
            'default' => 1,
        ),
        array(
            'id' => 'ad_button_type',
            'type' => 'button_set',
            'title' => esc_html__('Button Type', 'carspot'),
            'subtitle' => esc_html__('post button type', 'carspot'),
            'required' => array(array('ad_in_menu', '=', true)),
            'options' => array(
                'post' => 'Post Ad',
                'quote' => 'Request Quote',
                'search_field' => 'Search Field',
            ),
            'default' => 'post',
        ),
        array(
            'id' => 'ad_button_title',
            'type' => 'text',
            'title' => esc_html__('Button Title', 'carspot'),
            'subtitle' => esc_html__('Text on button', 'carspot'),
            'required' => array(array('ad_in_menu', '=', true)),
            'default' => 'Sell Your Car',
        ),
        array(
            'id' => 'quote_page_link',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Select Quote Page', 'carspot'),
            'required' => array(array('ad_in_menu', '=', true), array('ad_button_type', '=', 'quote')),
            'default' => array(1058),
        ),
        array(
            'id' => 'cs_other_btn_sell_car_title',
            'type' => 'text',
            'title' => esc_html__('Button Title When "Post A AD Off"', 'carspot'),
            'subtitle' => esc_html__('Text on button', 'carspot'),
            'required' => array(array('ad_in_menu', '=', false)),
            'default' => 'Other Button',
        ),
        array(
            'id' => 'cs_other_btn_sell_car_link',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Select Page If "Post A AD Off"', 'carspot'),
            'subtitle' => esc_html__('Select Page.', 'carspot'),
            'required' => array(array('ad_in_menu', '=', false),),
            'default' => array(1058),
        ),
        array(
            'id' => 'contact_in_menu',
            'type' => 'switch',
            'title' => esc_html__('Contact Details 0r Email', 'carspot'),
            'subtitle' => esc_html__('Show Details in Menu', 'carspot'),
            'default' => 1,
            'required' => array('sb_header', '=', 'white'),
        ),
        array(
            'id' => 'sb_contact_btn',
            'type' => 'button_set',
            'title' => esc_html__('Contact option in menu', 'carspot'),
            'required' => array('contact_in_menu', '=', true),
            'options' => array(
                'call' => 'Call Us Now',
                'email' => 'Email Us Now',
            ),
            'default' => 'call'
        ),
        array(
            'id' => 'contact_icon',
            'type' => 'text',
            'title' => esc_html__('Select Icon You Want To Show', 'carspot'),
            'required' => array('contact_in_menu', '=', true),
            'desc' => carspot_make_link('http://templates.scriptsbundle.com/carspot/demos/icons.html', esc_html__('List of Icons', 'carspot')) . " " . esc_html__('You can select any icon as you want', 'carspot'),
            'default' => 'flaticon-customer-service',
        ),
        array(
            'id' => 'sb_contact_btn_text',
            'type' => 'text',
            'title' => esc_html__('Display Text', 'carspot'),
            'required' => array('contact_in_menu', '=', true),
            'default' => 'Call Us Now',
        ),
        array(
            'id' => 'sb_contact_btn_value',
            'type' => 'text',
            'title' => esc_html__('Display Value', 'carspot'),
            'required' => array('contact_in_menu', '=', true),
            'default' => '111 222 333 444',
        ),
    )
));

/* ------------------Ad Posing Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Ads Settings', 'carspot'),
    'id' => 'sb_ad_settings',
    'desc' => '',
    'icon' => 'el el-adjust-alt',
));

Redux::setSection($opt_name, array(
    'title' => esc_html__('General Settings', 'carspot'),
    'id' => 'sb_ad_general_settings',
    'desc' => '',
    'icon' => 'el el-cogs',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'carspot_package_type',
            'type' => 'button_set',
            'title' => esc_html__('Package Mode', 'carspot'),
            'desc' => esc_html__('You can select only one package type at a time. Changing package type will conflict your previous settings.', 'carspot'),
            'options' => array(
                'category_based' => esc_html__('Category Based', 'carspot'),
                'package_based' => esc_html__('Packages Based', 'carspot'),
            ),
            'default' => 'package_based'
        ),
        array(
            'id' => 'carspot_form_type',
            'type' => 'button_set',
            'title' => esc_html__('Form Type', 'carspot'),
            'desc' => esc_html__('This ON/OFF option is only for admin to post from back end. If you want to enable for users please got ad post page.', 'carspot'),
            'options' => array(
                'yes' => esc_html__('Category Based Form', 'carspot'),
                'no' => esc_html__('Default Form', 'carspot'),
            ),
            'default' => 'no'
        ),
        array(
            'id' => 'sb_packages_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => __('Packages Page', 'carspot'),
            'required' => array('carspot_package_type', '=', array('package_based')),
            'default' => '',
        ),
        array(
            'id' => 'sb_location_allowed',
            'type' => 'switch',
            'title' => __('Allowed all countries', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'sb_list_allowed_country',
            'type' => 'select',
            'options' => carspot_get_all_countries(),
            'multi' => true,
            'title' => __('Select Countries', 'carspot'),
            'required' => array('sb_location_allowed', '=', array('0')),
            'desc' => __('You can select max 5 countries as per GOOGLE limit.', 'carspot') . ' ' . carspot_make_link('https://developers.google.com/maps/documentation/javascript/3.exp/reference#ComponentRestrictions', __('Read More', 'carspot')),
        ),
        array(
            'id' => 'carspot_gmap_lang',
            'type' => 'text',
            'title' => esc_html__('Google map language', 'carspot'),
            'desc' => carspot_make_link('https://developers.google.com/maps/faq#languagesupport', esc_html__('List of available languages', 'carspot')),
            'default' => 'en',
        ),
        array(
            'id' => 'communication_mode',
            'type' => 'button_set',
            'title' => esc_html__('Communications Mode', 'carspot'),
            'options' => array(
                'phone' => esc_html__('Phone', 'carspot'),
                'message' => esc_html__('Messages', 'carspot'),
                'both' => esc_html__('Both', 'carspot'),
            ),
            'default' => 'both'
        ),
        array(
            'id' => 'communication_icon_message',
            'type' => 'text',
            'title' => esc_html__('Message Icon', 'carspot'),
            'desc' => carspot_make_link('http://templates.scriptsbundle.com/carspot/demos/icons.html', esc_html__('List of Icons', 'carspot')) . " " . esc_html__('You can select any icon as you want', 'carspot'),
            'default' => 'flaticon-mail-1',
        ),
        array(
            'id' => 'communication_icon_phone',
            'type' => 'text',
            'title' => esc_html__('Phone Icon', 'carspot'),
            'desc' => carspot_make_link('http://templates.scriptsbundle.com/carspot/demos/icons.html', esc_html__('List of Icons', 'carspot')) . " " . esc_html__('You can select any icon as you want', 'carspot'),
            'default' => 'flaticon-smartphone',
        ),
        array(
            'id' => 'sb_send_email_on_ad_post',
            'type' => 'switch',
            'title' => esc_html__('Send email on Ad Post', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'ad_post_email_value',
            'type' => 'text',
            'title' => esc_html__('Email for notification.', 'carspot'),
            'required' => array('sb_send_email_on_ad_post', '=', '1'),
            'default' => get_option('admin_email'),
        ),
        array(
            'id' => 'sb_send_email_on_message',
            'type' => 'switch',
            'title' => esc_html__('Send email on message', 'carspot'),
            'desc' => esc_html__('When someone drop a message on ad then email send to concern user.', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'msg_notification_on',
            'type' => 'switch',
            'title' => esc_html__('Toastr notification', 'carspot'),
            'desc' => esc_html__('When someone drop a message on ad then notify to user on web via small popup.', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'msg_notification_time',
            'type' => 'text',
            'title' => esc_html__('Check Notification', 'carspot'),
            'subtitle' => esc_html__('after X second', 'carspot'),
            'desc' => esc_html__('Check notification after how many second. 1000 means 1 second.', 'carspot'),
            'required' => array('msg_notification_on', '=', array('1')),
            'default' => 100000,
        ),
        array(
            'id' => 'msg_notification_text',
            'type' => 'text',
            'title' => esc_html__('Notification text', 'carspot'),
            'desc' => esc_html__('%count% will be replace with number of messages.', 'carspot'),
            'required' => array('msg_notification_on', '=', array('1')),
            'default' => "You have %count% new messages.",
        ),
        array(
            'id' => 'sb_notification_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('All notifications page', 'carspot'),
            'required' => array('msg_notification_on', '=', array('1')),
            'default' => array('935'),
        ),
        array(
            'id' => 'sb_currency',
            'type' => 'text',
            'title' => esc_html__('Currency', 'carspot'),
            'desc' => carspot_make_link('http://htmlarrows.com/currency/', esc_html__('List of Currency', 'carspot')) . " " . esc_html__('You can use HTML code or text as well like USD etc', 'carspot'),
            'default' => '$',
        ),
        array(
            'id' => 'sb_price_direction',
            'type' => 'select',
            'options' => array('left' => 'Left', 'right' => 'Right'),
            'title' => esc_html__('Price direction', 'carspot'),
            'default' => 'left',
        ),
            array(
            'id' => 'ad_price_type',
            'type' => 'select',
            'options' => array('Fixed' => __('Fixed', 'carspot'), 'Negotiable' => __('Negotiable', 'carspot'), 'on_call' => __('Price on call', 'carspot'), 'auction' => __('Auction', 'carspot'), 'Free' => __('Free', 'carspot'), 'no_price' => __('No Price', 'carspot')),
            'multi' => true,
            'sortable' => true,
            'title' => __('Price Types', 'carspot'),
            'subtitle' => esc_html__('Ads Price type', 'carspot'),
            'default' => array(),
        ),
        array(
            'id' => 'ad_price_type_more',
            'type' => 'text',
            'title' => __('Custom Price Type', 'carspot'),
            'subtitle' => esc_html__('Ads Custom Price type', 'carspot'),
            'desc' => __('Separated by | like option 1|option 2', 'carspot'),
            'default' => '',
        ),
       
        array(
            'id' => 'sb_price_separator',
            'type' => 'text',
            'title' => esc_html__('Thousands Separator', 'carspot'),
            'default' => ',',
        ),
        array(
            'id' => 'sb_price_decimals',
            'type' => 'text',
            'title' => esc_html__('Decimals', 'carspot'),
            'desc' => esc_html__('It should be 0 for no decimals.', 'carspot'),
            'default' => '0',
        ),
        array(
            'id' => 'sb_price_decimals_separator',
            'type' => 'text',
            'title' => esc_html__('Decimals Separator', 'carspot'),
            'default' => '.',
        ),
        array(
            'id' => 'sb_distance_unit',
            'type' => 'text',
            'title' => esc_html__('Vehicle Distance Unit (km/miles).', 'carspot'),
            'default' => 'km',
        ),
        array(
            'id' => 'sb_power_unit',
            'type' => 'text',
            'title' => esc_html__('Vehicle Power Unit (cc).', 'carspot'),
            'default' => 'cc',
        ),
        array(
            'id' => 'email_on_ad_approval',
            'type' => 'switch',
            'title' => __('Email to Ad owner on approval', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'featured_expiry',
            'type' => 'text',
            'title' => esc_html__('Feature Ad Expired', 'carspot'),
            'subtitle' => esc_html__('In DAYS', 'carspot'),
            'desc' => esc_html__('Only integer value without spaces -1 means never expired.', 'carspot'),
            'default' => 7,
        ),
        array(
            'id' => 'cs_ads_expiry_days',
            'type' => 'text',
            'title' => esc_html__('Simple Ads Expired', 'carspot'),
            'desc' => __('Only integer value without spaces -1 means never expired', 'carspot'),
            'subtitle' => __('In DAYS', 'carspot'),
            'default' => '-1',
        ),
        array(
            'id' => 'cs_expiry_ad_move_trash',
            'type' => 'select',
            'title' => __('Simple Ad move to trash or not', 'carspot'),
            'desc' => __('After specific days ads move to trash or in expire tab', 'carspot'),
            'options' => array(
                'trash' => 'Trash',
                'expire' => 'Expire',
            ),
            'default' => 'expire',
        ),
        array(
            'id' => 'email_on_simple_ad_expire_trash',
            'type' => 'switch',
            'title' => esc_html__('Send email to ad owner', 'carspot'),
            'subtitle' => __('Send email on simple ad expire or trash', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'sb_checkout_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Checkout Page', 'carspot'),
            'default' => '',
        ),
        array(
            'id' => 'share_ads_on',
            'type' => 'switch',
            'title' => esc_html__('Enable Ad Share', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'report_options',
            'type' => 'text',
            'title' => esc_html__('Report ad Options', 'carspot'),
            'default' => 'Spam|Offensive|Duplicated|Fake',
        ),
        array(
            'id' => 'report_limit',
            'type' => 'text',
            'title' => esc_html__('Ad Report Limit', 'carspot'),
            'desc' => esc_html__('Only integer value without spaces.', 'carspot'),
            'default' => 10,
        ),
        array(
            'id' => 'report_action',
            'type' => 'select',
            'title' => esc_html__('Action on Ad Report Limit', 'carspot'),
            'options' => array(1 => 'Auto Inactive', 2 => 'Email to Admin'),
            'default' => 1,
        ),
        array(
            'id' => 'report_email',
            'type' => 'text',
            'title' => esc_html__('Email', 'carspot'),
            'desc' => esc_html__('Email where you want to get notify.', 'carspot'),
            'required' => array('report_action', '=', array(2)),
            'default' => get_option('admin_email'),
        ),
        array(
            'id' => 'default_related_image',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Default Image', 'carspot'),
            'compiler' => 'true',
            'desc' => esc_html__('If there is no image of ad then this will be show.', 'carspot'),
            'subtitle' => esc_html__('Dimensions: 300 x 225', 'carspot'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/no-image.jpg'),
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => esc_html__('Ads Post Settings', 'carspot'),
    'id' => 'sb_ad_post',
    'desc' => '',
    'icon' => 'el el-cogs',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'carspot_ad_order_approved',
            'type' => 'button_set',
            'title' => esc_html__('Ad Order Approved By', 'carspot'),
            'options' => array(
                '1' => esc_html__('Auto Approve', 'carspot'),
                '2' => esc_html__('Admin Approve', 'carspot'),
            ),
            'default' => '1'
        ),
        array(
            'id' => 'sb_ad_approval',
            'type' => 'select',
            'title' => esc_html__('Ad Approval', 'carspot'),
            'options' => array(
                'auto' => 'Auto Approved',
                'manual' => 'Admin manual approval'
            ),
            'default' => 'auto',
        ),
        array(
            'id' => 'sb_update_approval',
            'type' => 'select',
            'options' => array('auto' => 'Auto Approved', 'manual' => 'Admin manual approval'),
            'title' => esc_html__('Ad Update Approval', 'carspot'),
            'default' => 'auto',
        ),
        array(
            'id' => 'enable_review_stamp',
            'type' => 'switch',
            'title' => esc_html__('Enable Review Stamp', 'carspot'),
            'subtitle' => esc_html__('Want to get Review Stamp by user', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'enable_custom_locationz',
            'type' => 'switch',
            'title' => esc_html__('Enable custom location on ad post', 'carspot'),
            'subtitle' => esc_html__('Want to show country, city, state option', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'admin_allow_unlimited_ads',
            'type' => 'switch',
            'title' => esc_html__('Post unlimited free ads', 'carspot'),
            'subtitle' => esc_html__('For Administrator', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'sb_allow_ads',
            'type' => 'switch',
            'title' => esc_html__('Free Ads', 'carspot'),
            'subtitle' => esc_html__('For new user', 'carspot'),
            'desc' => __('Free ads only works with packages system only', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'sb_free_ads_limit',
            'type' => 'text',
            'title' => esc_html__('Free Ads limit', 'carspot'),
            'required' => array('sb_allow_ads', '=', array(true)),
            'subtitle' => esc_html__('For new user', 'carspot'),
            'desc' => esc_html__('It must be an inter value, -1 means unlimited.', 'carspot'),
            'default' => 5,
        ),
        array(
            'id' => 'sb_allow_featured_ads',
            'type' => 'switch',
            'title' => __('Free Featured Ads', 'carspot'),
            'subtitle' => __('For new user', 'carspot'),
            'required' => array(array('sb_allow_ads', '=', array(true))),
            'default' => true,
        ),
        array(
            'id' => 'sb_featured_ads_limit',
            'type' => 'text',
            'title' => __('Featured Ads limit', 'carspot'),
            'subtitle' => __('For new user', 'carspot'),
            'required' => array(
                array('sb_allow_ads', '=', array(true)),
                array('sb_allow_featured_ads', '=', array(true))
            ),
            'desc' => __('It must be an inter value, -1 means unlimited.', 'carspot'),
            'default' => 3,
        ),
        array(
            'id' => 'sb_allow_bump_ads',
            'type' => 'switch',
            'title' => __('Free Bump Ads', 'carspot'),
            'subtitle' => __('For new user', 'carspot'),
            'required' => array(array('sb_allow_ads', '=', array(true))),
            'default' => true,
        ),
        array(
            'id' => 'sb_bump_ads_limit',
            'type' => 'text',
            'title' => __('Bump Ads limit', 'carspot'),
            'subtitle' => __('For new user', 'carspot'),
            'required' => array(
                array('sb_allow_ads', '=', array(true)),
                array('sb_allow_bump_ads', '=', array(true))
            ),
            'desc' => __('It must be an inter value, -1 means unlimited.', 'carspot'),
            'default' => 2,
        ),
        array(
            'id' => 'sb_package_validity',
            'type' => 'text',
            'title' => __('Free package validity', 'carspot'),
            'subtitle' => __('In days for new user', 'carspot'),
            'required' => array('sb_allow_ads', '=', array(true)),
            'desc' => __('It must be an inter value, -1 means never expired.', 'carspot'),
            'default' => -1,
        ),
        array(
            'id' => 'cs_pakg_expirty_email_cron_switch',
            'type' => 'switch',
            'title' => esc_html__('Send email by cron before package expiry', 'carspot'),
            'desc' => esc_html__('Note : This functionality works hiddenly and send email to user before one day package expiry.This option takes a lot of load so any one who wishes to choose this option must have a good server that can support heavy load. ', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'cs_pakg_expirty_cron_interval',
            'type' => 'select',
            'required' => array('cs_pakg_expirty_email_cron_switch', '=', true),
            'title' => 'Cron Interval',
            'desc' => __('Cron job run after this Interval', 'carspot'),
            'options' => array(
                'hourly' => 'Hourly',
                'twicedaily' => 'Twice Daily',
                'daily' => 'Daily',
                'weekly' => 'Weekly'
            ),
            'default' => 'daily',
        ),
        array(
            'id' => 'sb_allow_free_bump_up',
            'type' => 'switch',
            'title' => __('Free Bump Ads for all users', 'carspot'),
            'required' => array('sb_allow_ads', '=', array(true)),
            'subtitle' => __('witout any package/restriction.', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'cs_images_requir',
            'type' => 'switch',
            'title' => esc_html__('Gallery Images required.', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'sb_upload_limit',
            'type' => 'select',
            'title' => esc_html__('Ad image set limit', 'carspot'),
            'options' => array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
                9 => 9,
                10 => 10,
                11 => 11,
                12 => 12,
                13 => 13,
                14 => 14,
                15 => 15,
                16 => 16,
                17 => 17,
                18 => 18,
                19 => 19,
                20 => 20,
                21 => 21,
                22 => 22,
                23 => 23,
                24 => 24,
                25 => 25,
                26 => 26,
                27 => 27,
                28 => 28,
                29 => 29,
                30 => 30,
                31 => 31,
                32 => 32,
                33 => 33,
                34 => 34,
                35 => 35
            ),
            'default' => 5,
        ),
        array(
            'id' => 'sb_upload_size',
            'type' => 'select',
            'title' => esc_html__('Ad image max size', 'carspot'),
            'options' => array(
                '307200-300kb' => '300kb',
                '614400-600kb' => '600kb',
                '819200-800kb' => '800kb',
                '1048576-1MB' => '1MB',
                '2097152-2MB' => '2MB',
                '3145728-3MB' => '3MB',
                '4194304-4MB' => '4MB',
                '5242880-5MB' => '5MB',
                '6291456-6MB' => '6MB',
                '7340032-7MB' => '7MB',
                '8388608-8MB' => '8MB',
                '9437184-9MB' => '9MB',
                '10485760-10MB' => '10MB',
                '11534336-11MB' => '11MB',
                '12582912-12MB' => '12MB',
                '13631488-13MB' => '13MB',
                '14680064-14MB' => '14MB',
                '15728640-15MB' => '15MB',
                '20971520-20MB' => '20MB',
                '26214400-25MB' => '25MB'
            ),
            'default' => '2097152-2MB',
        ),
        array(
            'id' => 'allow_tax_condition',
            'type' => 'switch',
            'title' => esc_html__('Display Condition Taxonomy', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'allow_tax_warranty',
            'type' => 'switch',
            'title' => esc_html__('Display Warranty Taxonomy', 'carspot'),
            'default' => true,
        ),
        //New array
        array(
            'id' => 'allow_ad_years',
            'type' => 'switch',
            'title' => esc_html__('Display Years Taxonomy', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'allow_ad_body_types',
            'type' => 'switch',
            'title' => esc_html__('Display Body Type Taxonomy', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'allow_ad_transmissions',
            'type' => 'switch',
            'title' => esc_html__('Display Transmission Taxonomy', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'allow_ad_engine_capacities',
            'type' => 'switch',
            'title' => esc_html__('Display Engine Capacity Taxonomy', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'allow_ad_engine_types',
            'type' => 'switch',
            'title' => esc_html__('Display Engine Type Taxonomy', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'allow_ad_assembles',
            'type' => 'switch',
            'title' => esc_html__('Display Assemble Taxonomy', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'allow_ad_colors',
            'type' => 'switch',
            'title' => esc_html__('Display Color Taxonomy', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'allow_ad_insurance',
            'type' => 'switch',
            'title' => esc_html__('Display Insurence Taxonomy', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'allow_ad_features',
            'type' => 'switch',
            'title' => esc_html__('Display Features Taxonomy', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'allow_ad_economy',
            'type' => 'switch',
            'title' => esc_html__('Display Fuel Economy', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'allow_lat_lon',
            'type' => 'switch',
            'title' => esc_html__('Latitude & Longitude', 'carspot'),
            'desc' => esc_html__('This will be display on ad post page for pin point map', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'sb_default_lat',
            'type' => 'text',
            'title' => esc_html__('Latitude', 'carspot'),
            'subtitle' => esc_html__('for default map.', 'carspot'),
            //'required' => array('allow_lat_lon', '=', true),
            'default' => '40.7127837',
        ),
        array(
            'id' => 'sb_default_long',
            'type' => 'text',
            'title' => esc_html__('Longitude', 'carspot'),
            'subtitle' => esc_html__('for default map.', 'carspot'),
            //'required' => array('allow_lat_lon', '=', true),
            'default' => '-74.00594130000002',
        ),
        array(
            'id' => 'allow_ad_address',
            'type' => 'switch',
            'title' => __('Address Mandatory', 'carspot'),
            'desc' => __('mandatory address on ad post.', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'address_type_id',
            'type' => 'button_set',
            'title' => __('Address Type', 'carspot'),
            'options' => array(
                'cities' => 'Cities',
                'addresses' => 'Addresses',
            ),
            'default' => 'cities',
        ), 
        array(
            'id' => 'allow_price_type',
            'type' => 'switch',
            'title' => __('Price Type', 'carspot'),
            'desc' => __('Display Price type option.', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'sb_ad_update_notice',
            'type' => 'text',
            'title' => esc_html__('Update Ad Notice', 'carspot'),
            'default' => 'Hey, be careful you are updating this AD.',
        ),
        array(
            'id' => 'bad_words_filter',
            'type' => 'textarea',
            'title' => esc_html__('Bad Words Filter', 'carspot'),
            'subtitle' => esc_html__('comma separated', 'carspot'),
            'placeholder' => esc_html__('word1,word2', 'carspot'),
            'desc' => esc_html__('These words will be removed from AD Title and Description', 'carspot'),
            'default' => '',
        ),
        array(
            'id' => 'bad_words_replace',
            'type' => 'text',
            'title' => esc_html__('Bad Words Replace Word', 'carspot'),
            'desc' => esc_html__('This words will be replace with above bad words list from AD Title and Description', 'carspot'),
            'default' => '',
        ),
        array(
            'id' => 'allow_upload_video',
            'type' => 'switch',
            'title' => esc_html__('Allow upload video', 'carspot'),
            'desc' => esc_html__('On/Off upload video.', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'cs_video_requir',
            'type' => 'switch',
            'title' => esc_html__('Video required.', 'carspot'),
            'default' => false,
            'required' => array('allow_upload_video', '=', true),
        ),
        array(
            'id' => 'sb_upload_video_mb_limit',
            'type' => 'select',
            'options' => array(
                '1-1MB' => '1MB',
                '2-2MB' => '2MB',
                '3-3MB' => '3MB',
                '4-4MB' => '4MB',
                '5-5MB' => '5MB',
                '6-6MB' => '6MB',
                '7-7MB' => '7MB',
                '8-8MB' => '8MB',
                '9-9MB' => '9MB',
                '10-10MB' => '10MB',
                '11-11MB' => '11MB',
                '12-12MB' => '12MB',
                '13-13MB' => '13MB',
                '14-14MB' => '14MB',
                '15-15MB' => '15MB',
                '20-20MB' => '20MB',
                '25-25MB' => '25MB',
                '50-50MB' => '50MB'
            ),
            'title' => esc_html__('Set limit in MB for video', 'carspot'),
            'default' => '2-2MB',
            'required' => array('allow_upload_video', '=', true),
        ),
        array(
            'id' => 'sb_upload_video_limit',
            'type' => 'select',
            'title' => esc_html__('set limit for upload video', 'carspot'),
            'options' => array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
                9 => 9,
                10 => 10,
                15 => 15,
                20 => 20,
                30 => 30
            ),
            'default' => 2,
            'required' => array('allow_upload_video', '=', true),
        ),
//        array(
//            'id' => 'sb_upload_video_minut_limit',
//            'type' => 'text',
//            'title' => esc_html__('set duration limit in Seconds for video', 'carspot'),
//            'default' => 15,
//            'required' => array('allow_upload_video', '=', true),
//        ),
        array(
            'id' => 'pdf_brochure_section',
            'type' => 'switch',
            'title' => esc_html__('Pdf brochure show/hide', 'carspot'),
            'desc' => esc_html__('On/Off for pdf brochure show/hide', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'pdf_brochure_upload_limit',
            'type' => 'select',
            'title' => esc_html__('Brochure upload limit', 'carspot'),
            'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10),
            'default' => 2,
            'required' => array('pdf_brochure_section', '=', true),
        ),
        array(
            'id' => 'pdf_brochure_size',
            'type' => 'select',
            'title' => esc_html__('Pdf brochure size in MB', 'carspot'),
            'options' => array(
                '1-1MB' => '1MB',
                '2-2MB' => '2MB',
                '3-3MB' => '3MB',
                '4-4MB' => '4MB',
                '5-5MB' => '5MB',
                '6-6MB' => '6MB',
                '7-7MB' => '7MB',
                '8-8MB' => '8MB',
                '9-9MB' => '9MB',
                '10-10MB' => '10MB',
                '11-11MB' => '11MB',
                '12-12MB' => '12MB',
                '13-13MB' => '13MB',
                '14-14MB' => '14MB',
                '15-15MB' => '15MB',
                '20-20MB' => '20MB',
                '25-25MB' => '25MB'
            ),
            'default' => '2-2MB',
            'required' => array('pdf_brochure_section', '=', true),
        ),
//	    array(
//		    'id' => 'pdf_brochure_required',
//		    'type' => 'switch',
//		    'title' => esc_html__('Brochure Required', 'carspot'),
//		    'desc' => esc_html__('On/Off for brochure required', 'carspot'),
//		    'required' => array('pdf_brochure_section', '=', true),
//		    'default' => false,
//	    ),
        array(
            'id' => 'cs_allow_third_party_api_search',
            'type' => 'switch',
            'title' => __('Allow immatriculationapi search', 'carspot'),
            'subtitle' => __('Allow search from immatriculationapi.com', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'cs_outer_user_name',
            'type' => 'text',
            'title' => __('User name for API', 'carspot'),
            'default' => __('tomberapic', 'carspot-rest-api'),
            'required' => array('cs_allow_third_party_api_search', '=', true),
        ),
        array(
            'id' => 'cs_allow_registration_text_field',
            'type' => 'switch',
            'title' => __('Allow Registration Field', 'carspot'),
            'subtitle' => __('Show Registration Field Yes/No.', 'carspot'),
            'default' => false,
            'required' => array('cs_allow_third_party_api_search', '=', true),
        ),
        array(
            'id' => 'cs_reg_field_placeholder',
            'type' => 'text',
            'title' => __('Placeholder for API field', 'carspot'),
            'default' => __('AA-123-BB or 1234AA75', 'carspot'),
            'required' => array('cs_allow_registration_text_field', '=', true),
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => esc_html__('Ads View Settings', 'carspot'),
    'id' => 'sb_view_post',
    'desc' => '',
    'icon' => 'el el-wrench',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'single_ad_style',
            'type' => 'button_set',
            'title' => esc_html__('Single Ad Style', 'carspot'),
            'options' => array(
                '1' => 'Style 1',
                '2' => 'Style 2',
                '3' => 'Style 3',
            ),
            'default' => '1'
        ),
        array(
            'id' => 'ad_slider_type',
            'type' => 'button_set',
            'title' => esc_html__('Images Slider Type', 'carspot'),
            'options' => array(
                '1' => 'With Slider',
                '2' => 'Modern Gallery',
                '3' => 'Simple Gallery',
                '4' => 'Classified',
            ),
            'default' => '1',
            'required' => array('single_ad_style', '=', '1'),
        ),
        array(
            'id' => 'car_key_features',
            'type' => 'switch',
            'title' => esc_html__('Key Features', 'carspot'),
            'default' => true,
        ),

        array(
            'id' => 'whatsapp_icon',
            'type' => 'switch',
            'title' => esc_html__(' WhatsApp Icon', 'carspot'),
            'default' => true,
        ),

        array(
            'id' => 'sell_for_me_btn',
            'type' => 'switch',
            'title' => esc_html__(' Sell For Me Add', 'carspot'),
            'default' => true,
        ),

        array(
            'id' => 'car_key_icons_enginetype',
            'type' => 'text',
            'title' => esc_html__('Engine Type Icon', 'carspot'),
            'required' => array('car_key_features', '=', array(true)),
            'default' => 'flaticon-gas-station-1',
        ),
        array(
            'id' => 'car_key_icons_mileage',
            'type' => 'text',
            'title' => esc_html__('Mileage Icon', 'carspot'),
            'required' => array('car_key_features', '=', array(true)),
            'default' => 'flaticon-dashboard-1',
        ),
        array(
            'id' => 'car_key_icons_engine_capacity',
            'type' => 'text',
            'title' => esc_html__('Engine Capacity Icon', 'carspot'),
            'required' => array('car_key_features', '=', array(true)),
            'default' => 'flaticon-tool',
        ),
        array(
            'id' => 'car_key_icons_year',
            'type' => 'text',
            'title' => esc_html__('Year Icon', 'carspot'),
            'required' => array('car_key_features', '=', array(true)),
            'default' => 'flaticon-calendar',
        ),
        array(
            'id' => 'car_key_icons_transmission',
            'type' => 'text',
            'title' => esc_html__('Transmission Type Icon', 'carspot'),
            'required' => array('car_key_features', '=', array(true)),
            'default' => 'flaticon-gearshift',
        ),
        array(
            'id' => 'car_key_icons_body_type',
            'type' => 'text',
            'title' => esc_html__('Body Type Icon', 'carspot'),
            'required' => array('car_key_features', '=', array(true)),
            'default' => 'flaticon-transport-1',
        ),
        array(
            'id' => 'car_key_icons_color',
            'type' => 'text',
            'title' => esc_html__('Color Icon', 'carspot'),
            'required' => array('car_key_features', '=', array(true)),
            'default' => 'flaticon-cogwheel-outline',
        ),
        array(
            'id' => 'Related_ads_on',
            'type' => 'switch',
            'title' => esc_html__('Related Ads', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'sb_related_ads_title',
            'type' => 'text',
            'title' => esc_html__('Related Ads Section Title', 'carspot'),
            'required' => array('Related_ads_on', '=', array(true)),
            'default' => 'Similiar Ads',
        ),
        array(
            'id' => 'max_ads',
            'type' => 'select',
            'title' => esc_html__('Max Related ads to show', 'carspot'),
            'required' => array('Related_ads_on', '=', array(true)),
            'options' => array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
                9 => 9,
                10 => 10,
                11 => 11,
                12 => 12,
                13 => 13,
                14 => 14,
                15 => 15
            ),
            'default' => 5,
        ),
        array(
            'id' => 'related_ad_style',
            'type' => 'button_set',
            'title' => esc_html__('Related Ad Style', 'carspot'),
            'options' => array(
                '1' => 'Grid',
                '2' => 'List',
            ),
            'required' => array('Related_ads_on', '=', array(true)),
            'default' => '1'
        ),
        array(
            'id' => 'cs_categ_label_detail_page_description',
            'type' => 'text',
            'title' => __('Category Label for Description on Detail Page', 'carspot'),
            'desc' => __('3-level category title separate by | like Make|Model|Version', 'carspot'),
            'default' => 'Make|Model|Version',
        ),
        array(
            'id' => 'related_parent_or_child',
            'type' => 'switch',
            'title' => __('Show Related Ads According to Parent/Child', 'carspot'),
            'required' => array('Related_ads_on', '=', array(true)),
            'default' => false,
            'desc' => __('Off mean show ads according to parent category.', 'carspot'),
        ),
        array(
            'id' => 'finacne_calc_on',
            'type' => 'switch',
            'title' => esc_html__('Financing Calculator', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'test_drive_form_on',
            'type' => 'switch',
            'title' => esc_html__('Test Drive Form', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'make_offer_form_on',
            'type' => 'switch',
            'title' => esc_html__('Make Offer Form', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'avg_city_title',
            'type' => 'text',
            'title' => esc_html__('Average in City Title', 'carspot'),
            'default' => esc_html__('City MPG', 'carspot'),
        ),
        array(
            'id' => 'avg_highway_title',
            'type' => 'text',
            'title' => esc_html__('Average in Highway Title', 'carspot'),
            'default' => esc_html__('Highway MPG', 'carspot'),
        ),
        array(
            'id' => 'tips_title',
            'type' => 'text',
            'title' => esc_html__('Tips Section Title', 'carspot'),
            'default' => 'Safety tips for deal',
        ),
        array(
            'id' => 'tips_for_ad',
            'type' => 'editor',
            'title' => esc_html__('Deal Tips', 'carspot'),
            'default' => '<ol>
                         <li>Use a safe location to meet seller</li>
                         <li>Avoid cash transactions</li>
                         <li>Beware of unrealistic offers</li>
                      </ol>
',
            'args' => array(
                'wpautop' => false,
                'media_buttons' => false,
                'textarea_rows' => 5,
                'teeny' => false,
                'quicktags' => false,
            )
        ),
        array(
            'id' => 'style_ad_720_1',
            'type' => 'textarea',
            'title' => esc_html__('Advertisement', 'carspot'),
            'subtitle' => esc_html__('720 x 90', 'carspot'),
            'desc' => esc_html__('Above the Ad description', 'carspot'),
            'default' => '<img class="center-block" alt="' . __('imag not found', 'carspot') . '" src="' . trailingslashit(get_template_directory_uri()) . 'images/banner-1.png"> ',
        ),
        array(
            'id' => 'style_ad_720_2',
            'type' => 'textarea',
            'title' => esc_html__('Advertisement', 'carspot'),
            'subtitle' => esc_html__('720 x 90', 'carspot'),
            'desc' => esc_html__('Below the Ad description', 'carspot'),
            'default' => '<img class="center-block alt="' . __('imag not found', 'carspot') . '" src="' . trailingslashit(get_template_directory_uri()) . 'images/banner-1.png"> ',
        ),
        array(
            'id' => 'style_ad_160_1',
            'type' => 'textarea',
            'title' => esc_html__('Advertisement', 'carspot'),
            'subtitle' => esc_html__('160 x 600', 'carspot'),
            'desc' => esc_html__('Right Side', 'carspot'),
            'required' => array('ad_layout_style', '=', array('2')),
            'default' => '<img alt="' . __('imag not found', 'carspot') . '" src="' . trailingslashit(get_template_directory_uri()) . 'images/160x600.png"> ',
        ),
        array(
            'id' => 'style_ad_160_2',
            'type' => 'textarea',
            'title' => esc_html__('Advertisement', 'carspot'),
            'subtitle' => esc_html__('160 x 600', 'carspot'),
            'desc' => esc_html__('Left Side', 'carspot'),
            'required' => array('ad_layout_style', '=', array('2')),
            'default' => '<img alt="' . __('imag not found', 'carspot') . '" src="' . trailingslashit(get_template_directory_uri()) . 'images/160x600.png"> ',
        ),

       
    )
));

Redux::setSection($opt_name, array(
    'title' => esc_html__('Search Settings', 'carspot'),
    'id' => 'ad_search_settings',
    'desc' => '',
    'icon' => 'el el-cogs',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'sb_search_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Search Page', 'carspot'),
            'default' => array('13'),
        ),
        array(
            'id' => 'search_page_layout',
            'type' => 'button_set',
            'title' => esc_html__('Search Page Style', 'carspot'),
            'options' => array(
                'search_layout_one' => 'Style One',
                'search_layout_two' => 'Style Two',
            ),
            'default' => 'search_layout_one'
        ),
        array(
            'id' => 'sb_search_options_type',
            'type' => 'button_set',
            'title' => esc_html__('Search Options Type', 'carspot'),
            'options' => array(
                'radio' => esc_html__('Radio', 'carspot'),
                'checkbox' => esc_html__('Checkbox', 'carspot'),
            ),
            'default' => 'radio'
        ),
        array(
            'id' => 'sb_filter_count',
            'type' => 'switch',
            'title' => esc_html__('Display ads count', 'carspot'),
            'default' => false,
            'desc' => esc_html__('Enable/Disable the total ads count of categories filter.', 'carspot'),
        ),
        array(
            'id' => 'listing_features_grids',
            'type' => 'button_set',
            'title' => esc_html__('Listing Style Features', 'carspot'),
            'options' => array(
                'car' => 'For Car',
                'others' => 'Classified And Other',
            ),
            'default' => 'car'
        ),
        array(
            'id' => 'sb_video_icon',
            'type' => 'switch',
            'title' => esc_html__('Show video icon on ads', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'video_icon',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Video Icon Image', 'carspot'),
            'compiler' => 'true',
            'desc' => esc_html__('Video Icon Image on ads.', 'carspot'),
            'subtitle' => esc_html__('Dimensions: 32 x 32', 'carspot'),
            'required' => array('sb_video_icon', '=', '1'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/youtube-flat.png'),
        ),
        array(
            'id' => 'cat_level_1',
            'type' => 'text',
            'title' => esc_html__('Category Heading Level 1', 'carspot'),
            'default' => 'Select Make',
        ),
        array(
            'id' => 'cat_level_2',
            'type' => 'text',
            'title' => esc_html__('Category Heading Level 2', 'carspot'),
            'default' => 'Select Model',
        ),
        array(
            'id' => 'cat_level_3',
            'type' => 'text',
            'title' => esc_html__('Category Heading Level 3', 'carspot'),
            'default' => 'Select Version',
        ),
        array(
            'id' => 'cat_level_4',
            'type' => 'text',
            'title' => esc_html__('Category Heading Level 4', 'carspot'),
            'default' => 'Select 4th Level',
        ),
        array(
            'id' => 'sb_location_titles',
            'type' => 'text',
            'title' => __('Location titles', 'carspot'),
            'desc' => __('4-level location title separate by | like Country|State|City|Town', 'carspot'),
            'default' => 'Country|State|City|Town',
        ),
        array(
            'id' => 'search_layout',
            'type' => 'button_set',
            'title' => esc_html__('Search Layout', 'carspot'),
            'required' => array('search_page_layout', '=', 'search_layout_one'),
            'options' => array(
                'grid_1' => 'Grid 1',
                'grid_2' => 'Grid 2',
                'grid_3' => 'Grid 3',
                'grid_4' => 'Grid 4',
                'grid_5' => 'Grid 5',
                'grid_6' => 'Grid 6',
                'list_1' => 'List 1',
                'list_2' => 'List 2',
                'list_3' => 'List 3',
            ),
            'default' => 'grid_1'
        ),
        array(
            'id' => 'ad_title_limt',
            'type' => 'switch',
            'title' => esc_html__('Ads Title Limit', 'carspot'),
            'required' => array('search_layout', '=', array('grid_1', 'grid_2', 'grid_3', 'grid_4', 'grid_5')),
            'default' => true,
        ),
        array(
            'id' => 'grid_title_limit',
            'type' => 'select',
            'title' => esc_html__('Title Limit For Grid Listing', 'carspot'),
            'required' => array(
                array('search_layout', '=', 'grid_1', 'grid_2', 'grid_3', 'grid_4', 'grid_5'),
                array('ad_title_limt', '=', '1')
            ),
            'options' => array(
                10 => 10,
                15 => 15,
                20 => 20,
                25 => 25,
                30 => 30,
                35 => 35,
                40 => 40,
                45 => 45,
                50 => 50,
                55 => 55
            ),
            'default' => 20,
        ),
        array(
            'id' => 'cat_and_location',
            'type' => 'button_set',
            'title' => esc_html__('Taxonomy Link', 'carspot'),
            'options' => array(
                'search' => esc_html__('Search Page', 'carspot'),
                'category' => esc_html__('Category Page', 'carspot'),
            ),
            'default' => 'search'
        ),
        array(
            'id' => 'search_sidebar_position',
            'type' => 'button_set',
            'title' => esc_html__('Search Sidebar Position', 'carspot'),
            'options' => array(
                'top' => esc_html__('Left ( top in mobile)', 'carspot'),
                'bottom' => esc_html__('Right ( bottom in mobile)', 'carspot'),
            ),
            'default' => 'top'
        ),
        array(
            'id' => 'feature_on_search',
            'type' => 'switch',
            'title' => esc_html__('Featured Ads', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'max_ads_feature',
            'type' => 'select',
            'title' => esc_html__('Max Featured ads to show', 'carspot'),
            'required' => array(array('feature_on_search', '=', array(true))),
            'options' => array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
                9 => 9,
                10 => 10,
                11 => 11,
                12 => 12,
                13 => 13,
                14 => 14,
                15 => 15
            ),
            'default' => 5,
        ),
        array(
            'id' => 'feature_ads_title',
            'type' => 'text',
            'title' => esc_html__('Featured Ads Title', 'carspot'),
            'required' => array('feature_on_search', '=', array(true)),
            'default' => 'Featured Ads',
        ),
        array(
            'id' => 'feature_ads_in_regular',
            'type' => 'switch',
            'title' => esc_html__('Featured ads Duplication', 'carspot'),
            'default' => false,
            'desc' => __('Featured ads will also be visible in between regular ads on search page.', 'carspot'),
        ),
        array(
            'id' => 'show_only_active_ads',
            'type' => 'switch',
            'title' => esc_html__('Show Only active ads', 'carspot'),
            'default' => true,
            'desc' => __('If this option is on than it will show only active ads on search. Sold and expired ads will not be shown. Turn off this option to show Sold and Expired ads in search.', 'carspot'),
        ),
        array(
            'id' => 'search_featured_layout',
            'type' => 'button_set',
            'title' => esc_html__('Featured Layout Style', 'carspot'),
            'options' => array(
                'search_featured_layout_grid' => 'Grid Style',
                'search_featured_layout_list' => 'List Style',
            ),
            'default' => 'search_featured_layout_grid'
        ),
        array(
            'id' => 'search_ad_720_1',
            'type' => 'textarea',
            'title' => esc_html__('Advertisement', 'carspot'),
            'subtitle' => esc_html__('720 x 90', 'carspot'),
            'desc' => esc_html__('Above the Ad description', 'carspot'),
            'default' => '<img class="center-block" alt="' . __('imag not found', 'carspot') . '" src="' . trailingslashit(get_template_directory_uri()) . 'images/banner-1.png"> ',
        ),
        array(
            'id' => 'search_ad_720_2',
            'type' => 'textarea',
            'title' => esc_html__('Advertisement', 'carspot'),
            'subtitle' => esc_html__('720 x 90', 'carspot'),
            'desc' => esc_html__('Below the Ad description', 'carspot'),
            'default' => '<img class="center-block" alt="' . __('imag not found', 'carspot') . '" src="' . trailingslashit(get_template_directory_uri()) . 'images/banner-1.png"> ',
        ),
    )
));

/* Map Settings Starts From Here */
Redux::setSection($opt_name, array(
    'title' => __('Map Settings', 'carspot'),
    'id' => 'map_settings',
    'desc' => __("Here you can setup the Map Settings for the theme. We have two type of map api's.", "carspot"),
    'icon' => 'el el-map-marker-alt',
    'fields' => array(
        array(
            'id' => 'map-setings-map-type',
            'type' => 'button_set',
            'title' => __('Map Type', 'carspot'),
            'subtitle' => __('Select Map', 'carspot'),
            'desc' => __('Select map type you want to add in the theme. By default google map is activated.', 'carspot'),
            'options' => array(
                'google_map' => __('Google Map', 'carspot'),
                'leafletjs_map' => __('Leafletjs/OpenStreet Map', 'carspot'),
                'no_map' => __('No Map', 'carspot'),
            ),
            'default' => 'google_map'
        ),
    )
));

/* ------------------Email Templates Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Email Templates', 'carspot'),
    'id' => 'sb_email_templates',
    'desc' => '',
    'icon' => 'el el-pencil',
    'fields' => array(
        array(
            'id' => 'sb_msg_subject_on_new_ad',
            'type' => 'text',
            'title' => esc_html__('New Ad email subject', 'carspot'),
            'desc' => esc_html__('%site_name% , %ad_owner% , %ad_title% will be translated accordingly.', 'carspot'),
            'default' => 'You have new Ad - Carspot',
        ),
        array(
            'id' => 'sb_msg_from_on_new_ad',
            'type' => 'text',
            'title' => esc_html__('New Ad FROM', 'carspot'),
            'desc' => esc_html__('FROM: NAME valid@email.com is compulsory as we gave in default.', 'carspot'),
            'default' => 'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_msg_on_new_ad',
            'type' => 'editor',
            'title' => esc_html__('New Ad Posted Message', 'carspot'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %ad_owner% , %ad_title% , %ad_link% will be translated accordingly.', 'carspot'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="http://carspot.scriptsbundle.com/wp-content/uploads/2017/03/sb.png" alt="' . __('imag not found', 'carspot') . '" width="80" height="80" /><br/>
A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>Admin,</b></span></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">You\'ve new AD;</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Title: %ad_title%</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Link: <a href="%ad_link%">%ad_title%</a></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Poster: %ad_owner%</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
        array(
            'id' => 'sb_message_subject_on_new_ad',
            'type' => 'text',
            'title' => esc_html__('New Message email subject', 'carspot'),
            'desc' => esc_html__('%site_name% , %ad_title% will be translated accordingly.', 'carspot'),
            'default' => 'You have new message - Carspot',
        ),
        array(
            'id' => 'sb_message_from_on_new_ad',
            'type' => 'text',
            'title' => esc_html__('New Message FROM', 'carspot'),
            'desc' => esc_html__('FROM: NAME valid@email.com is compulsory as we gave in default.', 'carspot'),
            'default' => 'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_message_on_new_ad',
            'type' => 'editor',
            'title' => esc_html__('New Message template', 'carspot'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %message% , %sender_name%, %ad_title% , %ad_link% will be translated accordingly.', 'carspot'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="http://carspot.scriptsbundle.com/wp-content/uploads/2017/03/sb.png" alt="' . __('imag not found', 'carspot') . '" width="80" height="80" />
<br/>A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>Admin,</b></span></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">You\'ve new Message;</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Title: %ad_title%</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Link: <a href="%ad_link%">%ad_title%</a></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Sender: %sender_name%</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Message: %message%</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
        array(
            'id' => 'sb_report_ad_subject',
            'type' => 'text',
            'title' => esc_html__('Ad report email subject', 'carspot'),
            'desc' => esc_html__('%site_name% , %ad_title% will be translated accordingly.', 'carspot'),
            'default' => 'Ad Reported - Carspot',
        ),
        array(
            'id' => 'sb_report_ad_from',
            'type' => 'text',
            'title' => esc_html__('Ad report email FROM', 'carspot'),
            'desc' => esc_html__('FROM: NAME valid@email.com is compulsory as we gave in default.', 'carspot'),
            'default' => 'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_report_ad_message',
            'type' => 'editor',
            'title' => esc_html__('Ad Report template', 'carspot'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %ad_owner% , %ad_title% , %ad_link% will be translated accordingly.', 'carspot'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="http://carspot.scriptsbundle.com/wp-content/uploads/2017/03/sb.png" alt="' . __('imag not found', 'carspot') . '" width="80" height="80" />

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>Admin,</b></span></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Below Ad is reported.</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Title: %ad_title%</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Link: <a href="%ad_link%">%ad_title%</a></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Ad Poster: %ad_owner%</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
        array(
            'id' => 'sb_forgot_password_subject',
            'type' => 'text',
            'title' => __('Reset Password email subject', 'carspot'),
            'desc' => __('%site_name% will be translated accordingly.', 'carspot'),
            'default' => 'Reset Password - carspot',
        ),
        array(
            'id' => 'sb_forgot_password_from',
            'type' => 'text',
            'title' => __('Reset Password email FROM', 'carspot'),
            'desc' => __('FROM: NAME valid@email.com is compulsory as we gave in default.', 'carspot'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_forgot_password_message',
            'type' => 'editor',
            'title' => esc_html__('Reset Password template', 'carspot'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %user% , %reset_link% will be translated accordingly.', 'carspot'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="http://carspot.scriptsbundle.com/wp-content/uploads/2017/03/sb.png" alt="' . __('imag not found', 'carspot') . '" width="80" height="80" />

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello %user%</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
Please use this below link to reset your password.
<br />
%reset_link%
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
        array(
            'id' => 'sb_new_rating_subject',
            'type' => 'text',
            'title' => esc_html__('Rating email subject', 'carspot'),
            'desc' => esc_html__('%site_name% will be translated accordingly.', 'carspot'),
            'default' => 'New Rating - Carspot',
        ),
        array(
            'id' => 'sb_new_rating_from',
            'type' => 'text',
            'title' => esc_html__('New rating email FROM', 'carspot'),
            'desc' => esc_html__('FROM: NAME valid@email.com is compulsory as we gave in default.', 'carspot'),
            'default' => 'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_new_rating_message',
            'type' => 'editor',
            'title' => esc_html__('New rating template', 'carspot'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %receiver% , %rator% , %rating% , %comments% , %rating_link% will be translated accordingly.', 'carspot'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="http://carspot.scriptsbundle.com/wp-content/uploads/2017/03/sb.png" alt="' . __('imag not found', 'carspot') . '" width="80" height="80" />

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello %receiver%</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
You got new rating;

User who rated: %rator%

Stars: %rating%

Link: %rating_link%

Comments: %comments%
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
        array(
            'id' => 'sb_new_bid_subject',
            'type' => 'text',
            'title' => esc_html__('Bid email subject', 'carspot'),
            'desc' => esc_html__('%site_name% will be translated accordingly.', 'carspot'),
            'default' => 'New Bid - Carspot',
        ),
        array(
            'id' => 'sb_new_bid_from',
            'type' => 'text',
            'title' => esc_html__('Bid email FROM', 'carspot'),
            'desc' => esc_html__('FROM: NAME valid@email.com is compulsory as we gave in default.', 'carspot'),
            'default' => 'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_new_bid_message',
            'type' => 'editor',
            'title' => esc_html__('Bid email template', 'carspot'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %receiver% , %bidder% , %bid% , %comments% , %bid_link% will be translated accordingly.', 'carspot'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="http://carspot.scriptsbundle.com/wp-content/uploads/2017/03/sb.png" alt="' . __('imag not found', 'carspot') . '" width="80" height="80" />

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello %receiver%</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
You got new Bid;

Bidder: %bidder%

Bid: %bid%

Link: %bid_link%

Comments: %comments%
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
        array(
            'id' => 'sb_new_user_admin_message_subject',
            'type' => 'text',
            'title' => __('New user email template subject for Admin', 'carspot'),
            'default' => 'New User Registration',
        ),
        array(
            'id' => 'sb_new_user_admin_message_from',
            'type' => 'text',
            'title' => __('New user email FROM for Admin', 'carspot'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'carspot'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_new_user_admin_message',
            'type' => 'editor',
            'title' => __('New user email template for Admin', 'carspot'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%site_name% , %display_name%, %email% will be translated accordingly.', 'carspot'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="http://carspot.scriptsbundle.com/wp-content/uploads/2017/03/sb.png" alt="' . __('imag not found', 'carspot') . '" width="80" height="80" />

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello Admin</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
New user has registered on your site %site_name%;

Name: %display_name%

Email: %email%

&nbsp;
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),


        array(
            'id' => 'sb_aprove_inspection_email_subject',
            'type' => 'text',
            'title' => __('Inspection Approved subject', 'carspot'),
            'default' => 'You Ad has been activated.',
        ),
        array(
            'id' => 'sb_aprove_inspection_email_from',
            'type' => 'text',
            'title' => __('Inspection Approved FROM', 'carspot'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'carspot'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_aprove_inspection_email_message',
            'type' => 'editor',
            'title' => __('Inspection Approved message', 'carspot'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%site_name% , %user_name%, %ad_title% ,  %ad_link% will be translated accordingly.', 'carspot'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="http://carspot.scriptsbundle.com/wp-content/uploads/2017/06/logo-2.png" alt="' . __('imag not found', 'carspot') . '" width="80" height="80" />

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello %user_name%</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
<br />
You ad has been activated.
<br />
Details are below;
<br />

Ad Title: %ad_title%
<br />
Ad Link: %ad_link%
<br />


&nbsp;
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),

  


        array(
            'id' => 'sb_reject_inspection_email_subject',
            'type' => 'text',
            'title' => __('Inspection Reject subject', 'carspot'),
            'default' => 'You Ad has been activated.',
        ),
        array(
            'id' => 'sb_reject_inspection_email_from',
            'type' => 'text',
            'title' => __('Inspection Reject FROM', 'carspot'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'carspot'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_reject_inspection_email_message',
            'type' => 'editor',
            'title' => __('Inspection Reject message', 'carspot'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%site_name% , %user_name%, %ad_title% ,  %ad_link% will be translated accordingly.', 'carspot'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="http://carspot.scriptsbundle.com/wp-content/uploads/2017/06/logo-2.png" alt="' . __('imag not found', 'carspot') . '" width="80" height="80" />

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello %user_name%</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
<br />
You ad has been activated.
<br />
Details are below;
<br />

Ad Title: %ad_title%
<br />
Ad Link: %ad_link%
<br />


&nbsp;
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),   


        array(
            'id' => 'sb_new_inspection_admin_message_subject',
            'type' => 'text',
            'title' => __('New Inspection email template subject for Admin', 'carspot'),
            'default' => 'New User Inspection',
        ),
        array(
            'id' => 'sb_new_inspection_admin_message_from',
            'type' => 'text',
            'title' => __('New Inspection email FROM for Admin', 'carspot'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'carspot'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_new_inspection_admin_message',
            'type' => 'editor',
            'title' => __('New Inspection email template for Admin', 'carspot'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%site_name% , %display_name%, %email% will be translated accordingly.', 'carspot'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="http://carspot.scriptsbundle.com/wp-content/uploads/2017/03/sb.png" alt="' . __('imag not found', 'carspot') . '" width="80" height="80" />

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello Admin</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
New user has registered on your site %site_name%;

Name: %display_name%

Email: %email%

&nbsp;
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
        array(
            'id' => 'sb_new_inspection_message_subject',
            'type' => 'text',
            'title' => __('New user Inspection email template subject', 'carspot'),
            'default' => 'New User Inspection',
        ),
        array(
            'id' => 'sb_new_user_inspection_message_from',
            'type' => 'text',
            'title' => __('New user email FROM', 'carspot'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'carspot'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_new_user_inspection_message',
            'type' => 'editor',
            'title' => __('New user Inspection email template', 'carspot'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%site_name% , %user_name% %display_name% %verification_link% will be translated accordingly.', 'carspot'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="http://carspot.scriptsbundle.com/wp-content/uploads/2017/06/logo-2.png" alt="' . __('imag not found', 'carspot') . '" width="80" height="80" />

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello %display_name%</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
Welcome to %site_name%.
<br />
Your details are below;
<br />

Username Monu: %user_name%
<br />

please verify your account: %verification_link% 
<br />


&nbsp;
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
        array(
            'id' => 'sb_new_user_message_subject',
            'type' => 'text',
            'title' => __('New user email template subject', 'carspot'),
            'default' => 'New User Registration',
        ),
        array(
            'id' => 'sb_new_user_message_from',
            'type' => 'text',
            'title' => __('New user email FROM', 'carspot'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'carspot'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_new_user_message',
            'type' => 'editor',
            'title' => __('New user email template', 'carspot'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%site_name% , %user_name% %display_name% %verification_link% will be translated accordingly.', 'carspot'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="http://carspot.scriptsbundle.com/wp-content/uploads/2017/06/logo-2.png" alt="' . __('imag not found', 'carspot') . '" width="80" height="80" />

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello %display_name%</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
Welcome to %site_name%.
<br />
Your details are below;
<br />

Username Monu: %user_name%
<br />

please verify your account: %verification_link% 
<br />


&nbsp;
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
        array(
            'id' => 'sb_active_ad_email_subject',
            'type' => 'text',
            'title' => __('Ad activation subject', 'carspot'),
            'default' => 'You Ad has been activated.',
        ),
        array(
            'id' => 'sb_active_ad_email_from',
            'type' => 'text',
            'title' => __('Ad activation FROM', 'carspot'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'carspot'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_active_ad_email_message',
            'type' => 'editor',
            'title' => __('Ad activation message', 'carspot'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%site_name% , %user_name%, %ad_title% ,  %ad_link% will be translated accordingly.', 'carspot'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="http://carspot.scriptsbundle.com/wp-content/uploads/2017/06/logo-2.png" alt="' . __('imag not found', 'carspot') . '" width="80" height="80" />

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello %user_name%</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
<br />
You ad has been activated.
<br />
Details are below;
<br />

Ad Title: %ad_title%
<br />
Ad Link: %ad_link%
<br />


&nbsp;
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
        /* TEST DRIVE EMAIL TEMPLATE */
        array(
            'id' => 'sb_test_drive_email_subject',
            'type' => 'text',
            'title' => __('Test drive subject', 'carspot'),
            'default' => 'You have been contacted for schedule test drive.',
        ),
        array(
            'id' => 'sb_test_drive_email_from',
            'type' => 'text',
            'title' => __('Test Drive FROM', 'carspot'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'carspot'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_test_drive_email_message',
            'type' => 'editor',
            'title' => __('Test drive email template', 'carspot'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%td_name% , %td_email%, %td_phone% ,  %td_date_time%, %td_msg%, %td_ad_link% will be translated accordingly. <br>td = "Test Drive"', 'carspot'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="http://carspot.scriptsbundle.com/wp-content/uploads/2017/06/logo-2.png" alt="' . __('imag not found', 'carspot') . '" width="80" height="80" />

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
<br />
You have been contacted by someone for test drive.
<br />
Details are below;
<br />

Name: %td_name%
<br />
Email Address: %td_email%
<br />
Contact No.: %td_phone%
<br />
Date and Time: %td_date_time%
<br />
Additional message: %td_msg%
<br />
Ad Link: <a href="%td_ad_link%" target="_blank"> Ad Link </a>


&nbsp;
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
        /* MAKE OFFER EMAIL TEMPLATE */
        array(
            'id' => 'sb_make_offer_email_subject',
            'type' => 'text',
            'title' => __('Make offer subject', 'carspot'),
            'default' => 'Someone make an offer to your ad.',
        ),
        array(
            'id' => 'sb_make_offer_email_from',
            'type' => 'text',
            'title' => __('Make Offer FROM', 'carspot'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'carspot'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_make_offer_email_message',
            'type' => 'editor',
            'title' => __('Make offer email template', 'carspot'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%mo_name% , %mo_email%, %mo_phone% ,  %mo_price%, %mo_msg%, %mo_ad_link% will be translated accordingly. <br>mo = "Make Offer"', 'carspot'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="http://carspot.scriptsbundle.com/wp-content/uploads/2017/06/logo-2.png" alt="' . __('imag not found', 'carspot') . '" width="80" height="80" />

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
<br />
Someone send you offer for your car.
<br />
Details are below;
<br />

Name: %mo_name%
<br />
Email Address: %mo_email%
<br />
Contact No.: %mo_phone%
<br />
Offered price: %mo_price%
<br />
Additional message: %mo_msg%
<br />
Ad Link: <a href="%mo_ad_link%" target="_blank"> Ad Link </a>


&nbsp;
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
        /* DEALER CONTACT EMAIL TEMPLATE */
        array(
            'id' => 'sb_contact_dealer_email_subject',
            'type' => 'text',
            'title' => __('Dealer Contact subject', 'carspot'),
            'default' => 'Someone has contacted you from ' . get_bloginfo('name'),
        ),
        array(
            'id' => 'sb_contact_dealer_email_from',
            'type' => 'text',
            'title' => __('Dealers Contact FROM', 'carspot'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'carspot'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_contact_dealer_email_message',
            'type' => 'editor',
            'title' => __('Dealer contact email template body', 'carspot'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%dc_name% , %dc_email%, %dc_phone% , %dc_msg% will be converted with contacter details from front end form. <br>dc = "Dealer Contacter"', 'carspot'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="http://carspot.scriptsbundle.com/wp-content/uploads/2017/06/logo-2.png" alt="' . __('imag not found', 'carspot') . '" width="80" height="80" />

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
<br />
Someone send you email from ' . get_bloginfo('name') . '
<br />
Details are below;
<br />

Name: %dc_name%
<br />
Email Address: %dc_email%
<br />
Contact No.: %dc_phone%
<br />
Additional message: %dc_msg%


&nbsp;
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
        /* Package Expire EMAIL TEMPLATE */
        array(
            'id' => 'sb_make_expire_package_subject',
            'type' => 'text',
            'title' => __('Make Expiry Package subject', 'carspot'),
            'default' => 'Your Package nearly Expire',
        ),
        array(
            'id' => 'sb_make_expire_package_email_from',
            'type' => 'text',
            'title' => __('Make Email FROM', 'carspot'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'carspot'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'sb_make_expire_package_email_message',
            'type' => 'editor',
            'title' => __('Make package expire email template', 'carspot'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => __('%exp_name% , %exp_email%, %exp_phone% ,  %exp_date%, %exp_msg%, %exp_packg_page_link% will be translated accordingly. <br>mo = "Make Offer"', 'carspot'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
<td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
<div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
<table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
<tbody>
<tr>
<td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="http://carspot.scriptsbundle.com/wp-content/uploads/2017/06/logo-2.png" alt="' . __('imag not found', 'carspot') . '" width="80" height="80" />

A Designing and development company</td>
</tr>
<tr>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
<br />
Someone send you email for package expiry reminder.
<br />
Details are below;
<br />

Name: %exp_name%
<br />
Email Address: %exp_email%
<br />
Contact No.: %exp_phone%
<br />
Package Expiry Date: %exp_date%
<br />
Packages Page Link: <a href="%exp_packg_page_link%" target="_blank"> Packages </a>


&nbsp;
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
<table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
</tr>
</tbody>
</table>
</div>
&nbsp;

</div></td>
<td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
</tr>
</tbody>
</table>
&nbsp;',
        ),
    )
));
/* ------------------Users Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Users', 'carspot'),
    'id' => 'sb_user_settings',
    'desc' => '',
    'icon' => 'el el-cog-alt',
));
Redux::setSection($opt_name, array(
    'title' => esc_html__('Users Settings', 'carspot'),
    'id' => 'sb_ad_sub_user_settings',
    'desc' => '',
    'icon' => 'el el-user',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'menu_sortable',
            'type' => 'sortable',
            'title' => __('User Dashboard Menu', 'carspot'),
            'subtitle' => __('Drag and drop to reorder. Leave empty if you want to remove from menu.', 'carspot'),
            'desc' => __('Do not forget to save after reordering menu.', 'carspot'),
            'mode' => 'text',
            'options' => array(
                'Home Page' => 'Home Page',
                'Dashboard' => 'Dashboard',
                'Edit profile' => 'Edit profile',
                'My Profile' => 'My Profile',
                'My Messages' => 'My Messages',
                'My Inventory' => 'My Inventory',
                'My Ratings' => 'My Ratings',
                'My Orders' => 'My Orders',
                'Logout' => 'Logout',
            ),
            'label' => true,
        ),
        array(
            'id' => 'new_dashboard',
            'type' => 'select',
            'data' => 'pages',
            'title' => __('User Dashboard Page', 'carspot'),
            'default' => '',
        ),
        array(
            'id' => 'after_login',
            'type' => 'button_set',
            'title' => esc_html__('Redirect After Login', 'carspot'),
            'subtitle' => esc_html__('post button type', 'carspot'),
            'options' => array(
                'dashboard_page' => 'Dashboard',
                'edit_profile_page' => 'Edit Profile',
            ),
            'default' => 'dashboard_page',
        ),
        array(
            'id' => 'welcome_text',
            'type' => 'text',
            'title' => esc_html__('Dashboard Welcome text', 'carspot'),
            'default' => "Welcome back:",
        ),
        array(
            'id' => 'sb_new_user_email_verification',
            'type' => 'switch',
            'title' => __('New user email verification', 'carspot'),
            'default' => false,
            'desc' => __('If verfication on then please update your new user email template by verification link.', 'carspot'),
        ),
        array(
            'id' => 'admin_contact_page',
            'type' => 'select',
            'data' => 'pages',
            'multi' => false,
            'title' => __('Contact to Admin', 'carspot'),
            'required' => array('sb_new_user_email_verification', '=', array('1')),
            'desc' => __('Select the page if verification email is not sent to new user.', 'carspot'),
        ),
        array(
            'id' => 'sb_new_user_email_to_admin',
            'type' => 'switch',
            'title' => __('New User Email to Admin', 'carspot'),
            'default' => true
        ),
        array(
            'id' => 'sb_new_user_email_to_user',
            'type' => 'switch',
            'title' => __('Welcome Email to User', 'carspot'),
            'default' => true
        ),
        array(
            'id' => 'sb_user_phone_required',
            'type' => 'switch',
            'title' => esc_html__('User phone number required', 'carspot'),
            'default' => true
        ),
        array(
            'id' => 'sb_user_license_required',
            'type' => 'switch',
            'title' => esc_html__('License required', 'carspot'),
            'default' => true
        ),
        array(
            'id' => 'sb_enable_user_badge',
            'type' => 'switch',
            'title' => esc_html__('Enable Badge', 'carspot'),
            'subtitle' => esc_html__('for display', 'carspot'),
            'default' => true,
        ),
        // array(
        //     'id' => 'carspot_show_badge',
        //     'type' => 'switch',
        //     'title' => __('Show Badge', 'carspot'),
        //     'desc' => __('Do you want to Show Badge profile sidebar?.', 'carspot'),
        //     'default' => true,
        // ),
        
        array(
          
            'id'       => 'carspot_badge11-default-image',
            'type'     => 'media',
            'url'      => true,
            'title'    => __( 'Default Badge', 'carspot' ),
            'compiler' => 'true',
            'desc'     => __( 'Select Badge default image here', 'carspot' ),
            'default'  => array( 'url' => trailingslashit( get_template_directory_uri () ) . 'assets/images/users/badge.png' ),
            'required' => array('sb_enable_user_badge', '=', true),
        ),	
        array(
            'id' => 'carspot_profile_badge',
            'type' => 'select',
            'data' => 'posts',
            'args' => array(
                'post_type' => array('product'),
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key' => 'badge_package', // Replace with the name of the postmeta key you want to filter by
                        'value' => 'carspot_badge', // Replace with the desired postmeta value
                        'compare' => '=', // Use '=' for exact matching
                        // You can use other comparison operators like '!=', '>', '<', 'LIKE', 'NOT LIKE', etc.
                    ),
                ),
                'posts_per_page' => -1,
                'order' => 'DESC',
                'orderby' => 'date',
            ),
            'title' => esc_html__('badge Page Link', 'carspot'),
            'required' => array('sb_enable_user_badge', '=', true),
        ),
        array(
            'id' => 'dash_notif_title',
            'type' => 'text',
            'title' => esc_html__('Dashboard Notification Title', 'carspot'),
            'default' => "",
        ),
        array(
            'id' => 'dash_notif_desc',
            'type' => 'editor',
            'title' => esc_html__('Dashboard Notification Description', 'carspot'),
            'default' => '',
            'args' => array(
                'wpautop' => false,
                'media_buttons' => false,
                'textarea_rows' => 10,
                'teeny' => false,
                'quicktags' => false,
            )
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => esc_html__('Dealers Settings', 'carspot'),
    'id' => 'sb_ad_dealer_settings',
    'desc' => '',
    'icon' => 'el el-torso',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'dealer_reviews',
            'type' => 'select',
            'data' => 'pages',
            'title' => __('Select review page', 'carspot'),
            'default' => '',
        ),
        array(
            'id' => 'user_inventory',
            'type' => 'select',
            'data' => 'pages',
            'title' => __('Select inventory page', 'carspot'),
            'default' => '',
        ),
        array(
            'id' => 'sb_dealer_contact',
            'type' => 'switch',
            'title' => esc_html__('Contact Form For Dealers', 'carspot'),
            'default' => true,
            'desc' => esc_html__('Turn on this option if you want to enable delaer contact form. For email template visit Email Template tab in this theme options', 'carspot'),
        ),
        array(
            'id' => 'sb_about_title',
            'type' => 'text',
            'title' => esc_html__('About Title', 'carspot'),
            'default' => "About Dealer:",
        ),
        array(
            'id' => 'sb_inventory_title',
            'type' => 'text',
            'title' => esc_html__('Inventory Title', 'carspot'),
            'default' => "Dealer Inventory:",
        ),
        array(
            'id' => 'sb_reviews_title',
            'type' => 'text',
            'title' => esc_html__('Reviews Title', 'carspot'),
            'default' => "Dealer Reviews: ",
        ),
        array(
            'id' => 'sb_write_reviews_title',
            'type' => 'text',
            'title' => esc_html__('Write Review Title', 'carspot'),
            'default' => "Write a Reviews:",
        ),
        array(
            'id' => 'sb_enable_user_ratting',
            'type' => 'switch',
            'title' => esc_html__('Enable User Rating', 'carspot'),
            'subtitle' => esc_html__('To logged in users', 'carspot'),
            'default' => true,
        ),
        array(
            'id' => 'email_to_user_on_rating',
            'type' => 'switch',
            'title' => esc_html__('Send Email to user', 'carspot'),
            'subtitle' => esc_html__('on new ratting', 'carspot'),
            'required' => array('sb_enable_user_ratting', '=', '1'),
            'default' => true,
        ),
        array(
            'id' => 'sb_reviews_count_limit',
            'type' => 'text',
            'title' => esc_html__('Button after number of reviews/ads', 'carspot'),
            'required' => array('sb_enable_user_ratting', '=', '1'),
            'default' => "5",
            'desc' => esc_html__('This option will work for both inventory and reviews on user profile page', 'carspot'),
        ),
        array(
            'id' => 'sb_first_rating_stars_title',
            'type' => 'text',
            'title' => esc_html__('First Rating Stars Title', 'carspot'),
            'required' => array('sb_enable_user_ratting', '=', '1'),
            'default' => "Level of Services",
        ),
        array(
            'id' => 'sb_second_rating_stars_title',
            'type' => 'text',
            'title' => esc_html__('Secong Rating Stars Title', 'carspot'),
            'required' => array('sb_enable_user_ratting', '=', '1'),
            'default' => "Buying Process",
        ),
        array(
            'id' => 'sb_third_rating_stars_title',
            'type' => 'text',
            'title' => esc_html__('Third Rating Stars Title', 'carspot'),
            'required' => array('sb_enable_user_ratting', '=', '1'),
            'default' => "Vehicle Selection",
        ),
        array(
            'id' => 'dealer_ad_320',
            'type' => 'textarea',
            'title' => esc_html__('Advertisement', 'carspot'),
            'subtitle' => esc_html__('Max width should be 350px and heigh can be diferent', 'carspot'),
            'desc' => esc_html__('This will be visible on dealers page sidebar', 'carspot'),
            'default' => '<img class="center-block img-responsive" alt="' . __('imag not found', 'carspot') . '" src="' . trailingslashit(get_template_directory_uri()) . 'images/big.png"> ',
        ),
    )
));
/* ------------------URL Rewriting Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => __('URL Rewriting', 'carspot'),
    'id' => 'sb_url_rewriting',
    'desc' => '',
    'icon' => 'el el-cogs',
    'fields' => array(
        array(
            'id' => 'sb_url_rewriting_enable',
            'type' => 'switch',
            'title' => __('Enable url rewriting', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'sb_ad_slug',
            'type' => 'text',
            'title' => __('Classified ad slug', 'carspot'),
            'required' => array('sb_url_rewriting_enable', '=', '1'),
            'desc' => __('eg classified-ads', 'carspot'),
            'default' => "",
        ),
    )
));

        /* ------------------ Messaging Settings ----------------------- */
        //this work for message customization but we are not work on it 5-Nov-2020
        //Redux::setSection( $opt_name, array(
        //	'title'  => __( 'Messaging', 'carspot' ),
        //	'id'     => 'cs_mesging_seting',
        //	'desc'   => '',
        //	'icon'   => 'el el-list-alt',
        //	'fields' => array(
        //		array(
        //			'id'      => 'cs_mesging_opt',
        //			'type'    => 'button_set',
        //			'title'   => esc_html__( 'Messaging Between', 'carspot' ),
        //			'options' => array(
        //				'btwn_author' => 'Between Author',
        //				'btwn_admin'  => 'Between Admin',
        //			),
        //			'default' => 'btwn_author',
        //		),
        //	)
        //) );

/* ------------------Comment/Bidding Settings ----------------------- */

carspot_timezone_list();
    $time_zones_arr = array('' => __('Select Timezone', 'carspot'));
    if (function_exists('carspot_timezone_list')) {
        $time_zones_arr = carspot_timezone_list('options');
    }

Redux::setSection($opt_name, array(
    'title' => esc_html__('Bidding Settings', 'carspot'),
    'id' => 'sb_comments_settings',
    'desc' => '',
    'icon' => 'el el-cogs',
    'fields' => array(
        array(
            'id' => 'sb_enable_comments_offer',
            'type' => 'switch',
            'title' => esc_html__('Enable Bidding', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'sb_enable_comments_offer_user',
            'type' => 'switch',
            'title' => esc_html__('Give bidding option to user', 'carspot'),
            'required' => array('sb_enable_comments_offer', '=', '1'),
            'default' => false,
        ),
        array(
            'id' => 'sb_enable_comments_offer_user_title',
            'type' => 'text',
            'title' => esc_html__('User Section Title', 'carspot'),
            'required' => array('sb_enable_comments_offer_user', '=', '1'),
            'default' => "Bidding",
        ),
        array(
            'id' => 'sb_email_on_new_bid_on',
            'type' => 'switch',
            'title' => esc_html__('Email to Ad author', 'carspot'),
            'subtitle' => esc_html__('on bid', 'carspot'),
            'required' => array('sb_enable_comments_offer', '=', '1'),
            'default' => false,
        ),

        array(
            'id' => 'email_on_max_bid_on',
            'type' => 'switch',
            'title' => esc_html__('Email to Bidder', 'carspot'),
            'subtitle' => esc_html__('on bid', 'carspot'),
            'required' => array('sb_enable_comments_offer', '=', '1'),
            'default' => false,
        ),

        array(
            'id' => 'timer_bid_on',
            'type' => 'switch',
            'title' => esc_html__('Bidding Timer', 'carspot'),
            'subtitle' => esc_html__('on bid', 'carspot'),
            'required' => array('sb_enable_comments_offer', '=', '1'),
            'default' => false,
        ),

        array(
            'id' => 'minimum_bid_on',
            'type' => 'switch',
            'title' => esc_html__('Minimum Bidding', 'carspot'),
            'subtitle' => esc_html__('on bid', 'carspot'),
            'required' => array('sb_enable_comments_offer', '=', '1'),
            'default' => false,
        ),

        array(
            'id' => 'increment_bid_on',
            'type' => 'switch',
            'title' => esc_html__('Bidding Increment', 'carspot'),
            'subtitle' => esc_html__('on bid', 'carspot'),
            'required' => array('sb_enable_comments_offer', '=', '1'),
            'default' => false,
        ),

       

        array(
            'id' => 'sb_comments_section_title',
            'type' => 'text',
            'title' => esc_html__('Section Title', 'carspot'),
            'required' => array('sb_enable_comments_offer', '=', '1'),
            'default' => "Bids",
        ),
        array(
            'id' => 'sb_comments_section_note',
            'type' => 'text',
            'title' => esc_html__('Disclaimer note', 'carspot'),
            'required' => array('sb_enable_comments_offer', '=', '1'),
            'default' => "*Your phone number will be show to post author",
        ),

        array(
            'id' => 'bid_timezone',
            'type' => 'select',
            'title' => __('Timezones', 'carspot'),
            'required' => array('sb_enable_comments_offer', '=', '1'),
            // 'subtitle' => $tz_subtitle,
            // 'desc' => $zone_currentTime,
            'options' => $time_zones_arr,
        ),
        
        array(
            'id' => 'sb_enable_Email_offer',
            'type' => 'switch',
            'title' => esc_html__('Maximum Bidding Email ', 'carspot'),
            'subtitle' => esc_html__('Send Maximum bidding email exist user.', 'carspot'),
            'default' => false,
        ),

        array(
            'id' => 'new_bid_email_all_user',
            'type' => 'text',
            'title' => __('Maximum New Bid Email Subjects', 'carspot'),
            'desc' => __('%site_name% will be translated accordingly.', 'carspot'),
            'required' => array('sb_enable_Email_offer', '=', '1'),
            'default' => 'Maximum Bidding - carspot',
        ),
        array(
            'id' => 'new_bid_email_from',
            'type' => 'text',
            'title' => __('Maximum New Bid email FROM', 'carspot'),
            'desc' => __('FROM: NAME valid@email.com is compulsory as we gave in default.', 'carspot'),
            'required' => array('sb_enable_Email_offer', '=', '1'),
            'default' => get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'new_bid_post_email',
            'type' => 'editor',
            'title' => esc_html__('Maximum New bid Posted Message', 'carspot'),
            'required' => array('sb_enable_Email_offer', '=', '1'),
            'args' => array(
                'teeny' => true,
                'textarea_rows' => 10,
                'wpautop' => false,
            ),
            'desc' => esc_html__('%site_name% , %receiver% , %bidder% , %bid% , %comments% , %bid_link% will be translated accordingly.', 'carspot'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
            <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;">
            <div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
            <table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;">
            <tbody>
            <tr>
            <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;">
            <table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
            <td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff"><img class="alignnone size-full wp-image-1437" src="http://carspot.scriptsbundle.com/wp-content/uploads/2017/03/sb.png" alt="' . __('imag not found', 'carspot') . '" width="80" height="80" />

            A Designing and development company</td>
            </tr>
            <tr>
            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">
            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello %receiver%</span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>,</b></span></p>
            You got Maximum Bid;

            Bidder: %bidder%

            Bid: %bid%

            Link: %bid_link%

            Comments: %comments%
            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks!</strong></p>
            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">ScriptsBundle</p>
            </td>
            </tr>
            </tbody>
            </table>
            </td>
            </tr>
            </tbody>
            </table>
            <div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;">
            <table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
            <td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td>
            </tr>
            </tbody>
            </table>
            </div>
            &nbsp;

            </div></td>
            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td>
            </tr>
            </tbody>
            </table>
            &nbsp;',
              
    ),


 
    )
));

/* ------------------ Reviews Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Reviews Settings', 'carspot'),
    'id' => 'sb-review-settings',
    'desc' => '',
    'icon' => 'el el-edit',
    'fields' => array(
        array(
            'id' => 'review_sidebar',
            'type' => 'button_set',
            'title' => esc_html__('Review Sidebar', 'carspot'),
            'options' => array(
                'right' => 'Right',
                'left' => 'Left',
                'no-sidebar' => 'No Sidebar',
            ),
            'default' => 'right'
        ),
        array(
            'id' => 'default_related_image_review',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Review Listing Default Thumbnail', 'carspot'),
            'compiler' => 'true',
            'desc' => esc_html__('If there is no image of ad then this will be show.', 'carspot'),
            'subtitle' => esc_html__('Dimensions: 360 x 270', 'carspot'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/no-pic.jpg'),
        ),
        array(
            'id' => 'review_related_image_large',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Review Detail Default Thumbnail', 'carspot'),
            'compiler' => 'true',
            'desc' => esc_html__('If there is no image of ad then this will be show.', 'carspot'),
            'subtitle' => esc_html__('Dimensions: 760 x 410', 'carspot'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/review-large.jpg'),
        ),
    )
));

/* ------------------ Vehicle Reviews Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Vehicle History Settings', 'carspot'),
    'id' => 'cs-vehicle-review-settings',
    'desc' => '',
    'icon' => 'el el-edit',
    'fields' => array(
        array(
            'id' => 'enable_vehicle_review',
            'type' => 'switch',
            'title' => esc_html__('Enable Vehicle Review Report', 'carspot'),
            'subtitle' => esc_html__('Show/Hide Vehicle Review', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'vehicle_review_enabled_opt',
            'type' => 'button_set',
            'title' => __('Report Display Option', 'carspot'),
            'options' => array(
                'all' => 'On All Ads',
                'specific' => 'On Specific Ads',
            ),
            'default' => 'specific',
            'required' => array('enable_vehicle_review', '=', array(true)),
        ),
        array(
            'id' => 'vehicle_review_title',
            'type' => 'text',
            'title' => __('Title', 'carspot'),
            'required' => array('enable_vehicle_review', '=', array(true)),
        ),
        array(
            'id' => 'vehicle_review_url',
            'type' => 'text',
            'title' => __('Vehicle Review Link', 'carspot'),
            'required' => array(
                ['enable_vehicle_review', '=', array(true)],
                ['vehicle_review_enabled_opt', '=', array('all')]
            ),
        ),
        array(
            'id' => 'vehicle_review_logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Vehicle Review Logo', 'carspot'),
            'compiler' => 'true',
            'subtitle' => __('Dimensions: 64 x 64', 'carspot'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
            'required' => array('enable_vehicle_review', '=', array(true)),
        ),
    )
));

/* ------------------ Comparison Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Comparison Settings', 'carspot'),
    'id' => 'sb-comparison-settings',
    'desc' => '',
    'icon' => 'el el-edit',
    'fields' => array(
        array(
            'id' => 'carspot_compare_page',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Comparison Page', 'carspot'),
            'default' => array('651'),
        ),
        array(
            'id' => 'compare_ad_front',
            'type' => 'select',
            'data' => 'pages',
            'title' => esc_html__('Comparison Page Frontend', 'carspot'),
        ),
        array(
            'id' => 'compare_ad_front_title',
            'type' => 'text',
            'title' => esc_html__('Compare Ad Page Heading', 'carspot'),
            'subtitle' => '',
            'desc' => '',
        ),
        array(
            'id' => 'compare_ad_front_desc',
            'type' => 'textarea',
            'title' => esc_html__('Compare Ad Page Description.', 'carspot'),
            'subtitle' => '',
            'desc' => '',
        ),
    )
));

/* ------------------Blog Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Blog Settings', 'carspot'),
    'id' => 'sb-blog-settings',
    'desc' => '',
    'icon' => 'el el-edit',
    'fields' => array(
        array(
            'id' => 'blog_sidebar',
            'type' => 'button_set',
            'title' => esc_html__('Blog Sidebar', 'carspot'),
            'options' => array(
                'right' => 'Right',
                'left' => 'Left',
                'no-sidebar' => 'No Sidebar',
            ),
            'default' => 'right'
        ),
        array(
            'id' => 'sb_blog_page_title',
            'type' => 'text',
            'title' => esc_html__('Blog Page Title', 'carspot'),
            'subtitle' => '',
            'desc' => '',
            'default' => 'Blog Posts',
        ),
        array(
            'id' => 'ad_right',
            'type' => 'textarea',
            'title' => esc_html__('Ad on Right', 'carspot'),
            'subtitle' => esc_html__('160 x 600', 'carspot'),
            'required' => array('single_style', '=', array('no-sidebar')),
            'default' => '<img src="' . trailingslashit(get_template_directory_uri()) . 'images/160x600.png' . '" title="' . esc_attr('Ad', 'carspot') . '" />',
        ),
        array(
            'id' => 'ad_left',
            'type' => 'textarea',
            'title' => esc_html__('Ad on Left', 'carspot'),
            'subtitle' => esc_html__('160 x 600', 'carspot'),
            'required' => array('single_style', '=', array('no-sidebar')),
            'default' => '<img src="' . trailingslashit(get_template_directory_uri()) . 'images/160x600.png' . '" title="' . esc_attr('Ad', 'carspot') . '" />',
        ),
        array(
            'id' => 'sb_blog_single_title',
            'type' => 'text',
            'title' => esc_html__('Single Post Title', 'carspot'),
            'subtitle' => '',
            'desc' => '',
            'default' => 'Blog Details',
        ),
        array(
            'id' => 'enable_share_post',
            'type' => 'switch',
            'title' => esc_html__('Enable Share', 'carspot'),
            'subtitle' => esc_html__('on single Post', 'carspot'),
            'default' => false,
        ),
    )
));

/* ------------------Shop Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Shop', 'carspot'),
    'id' => 'sb_shop_settings',
    'desc' => '',
    'icon' => 'el el-shopping-cart',
    'fields' => array(
        array(
            'id' => 'related_products',
            'type' => 'switch',
            'title' => esc_html__('Related Products', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'max_related_products',
            'type' => 'select',
            'title' => esc_html__('Max Related Products To Show', 'carspot'),
            'required' => array('related_products', '=', array(true)),
            'options' => array(
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
                6 => 6,
                7 => 7,
                8 => 8,
                9 => 9,
                10 => 10,
                11 => 11,
                12 => 12,
                13 => 13,
                14 => 14,
                15 => 15
            ),
            'default' => 5,
        ),
        array(
            'id' => 'related_products_title',
            'type' => 'text',
            'title' => esc_html__('Related Products Title', 'carspot'),
            'required' => array('related_products', '=', array(true)),
            "description" => esc_html__('For color ', 'carspot') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . esc_html__('warp text within this tag', 'carspot') . '<strong>' . esc_html('{/color}') . '</strong>',
            'default' => 'Related {color} Products {/color}',
        ),
        array(
            'id' => 'show_cart_top',
            'type' => 'switch',
            'title' => esc_html__('Show Cart On TopBar', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'show_cart_total',
            'type' => 'switch',
            'title' => esc_html__('Show Cart Total On Ad Post Page Only', 'carspot'),
            'default' => false,
        ),
        array(
            'id' => 'cart_float_text',
            'type' => 'text',
            'title' => esc_html__('Cart Button Title', 'carspot'),
            'required' => array('show_cart_total', '=', '1'),
            'default' => 'Pay',
        ),
        array(
            'id' => 'cart_float_animation',
            'type' => 'text',
            'title' => esc_html__('Animation On Cart Stick Button', 'carspot'),
            'required' => array('show_cart_total', '=', '1'),
            'desc' => carspot_make_link('https://daneden.github.io/animate.css/', esc_html__('List of Animation', 'carspot')),
            'default' => 'tada',
        ),
    )
));
/* ------------------API Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('API Settings', 'carspot'),
    'id' => 'sb-api-settings',
    'desc' => '',
    'icon' => 'el el-cogs',
    'fields' => array(
        array(
            'id' => 'mapbox_access_tokens',
            'type' => 'text',
            'title' => esc_html__('Mapbox Access tokens', 'carspot'),
            'subtitle' => '',
            'desc' => carspot_make_link('https://account.mapbox.com/access-tokens/', esc_html__('How to Find it', 'carspot')),
            'default' => '',
        ),
        array(
            'id' => 'google_api_key',
            'type' => 'text',
            'title' => esc_html__('Google ReCAPTCHA API Key', 'carspot'),
            'subtitle' => '',
            'desc' => carspot_make_link('https://www.google.com/recaptcha/admin', esc_html__('How to Find it', 'carspot')),
            'default' => '',
        ),
        array(
            'id' => 'google_api_secret',
            'type' => 'text',
            'title' => esc_html__('Google ReCAPTCHA API Secret', 'carspot'),
            'subtitle' => '',
            'desc' => carspot_make_link('https://www.google.com/recaptcha/admin', esc_html__('How to Find it', 'carspot')),
            'default' => '',
        ),
        array(
            'id' => 'mailchimp_api_key',
            'type' => 'text',
            'title' => esc_html__('MailChimp API Key', 'carspot'),
            'desc' => carspot_make_link('http://kb.mailchimp.com/integrations/api-integrations/about-api-keys', esc_html__('How to Find it', 'carspot')),
        ),
        array(
            'id' => 'gmap_api_key',
            'type' => 'text',
            'title' => esc_html__('Google Map API Key', 'carspot'),
            'desc' => carspot_make_link('https://developers.google.com/maps/documentation/javascript/get-api-key', esc_html__('How to Find it', 'carspot')),
            'default' => 'AIzaSyB_La6qmewwbVnTZu5mn3tVrtu6oMaSXaI',
        ),
        array(
            'id' => 'fb_api_key',
            'type' => 'text',
            'title' => esc_html__('Facebook Client ID', 'carspot'),
            'desc' => carspot_make_link('https://developers.facebook.com/?advanced_app_create=true', esc_html__('How to Make', 'carspot')),
        ),
        array(
            'id' => 'gmail_api_key',
            'type' => 'text',
            'title' => esc_html__('Gmail Client ID', 'carspot'),
            'desc' => carspot_make_link('https://console.developers.google.com/apis/api/gmail/', esc_html__('How to Find it', 'carspot')),
        ),
        array(
            'id' => 'redirect_uri',
            'type' => 'text',
            'title' => esc_html__('Redirect URI', 'carspot'),
            'desc' => esc_html__('Must be URI where you want to redirect after thentication, it will be your web url.', 'carspot'),
        ),
    )
));

/* ------------------Comming Soon ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Coming Soon', 'carspot'),
    'id' => 'sb_comming_soon_section',
    'desc' => '',
    'icon' => 'el el-screen',
    'fields' => array(
        array(
            'id' => 'sb_comming_soon_mode',
            'type' => 'switch',
            'title' => esc_html__('Coming Soon Mode', 'carspot'),
            'subtitle' => '',
            'default' => false
        ),
        array(
            'id' => 'sb_comming_soon_logo',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Coming Soon Logo', 'carspot'),
            'compiler' => 'true',
            'subtitle' => esc_html__('Dimensions: 220 x 40', 'carspot'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
        ),
        array(
            'id' => 'coming_soon_notify',
            'type' => 'switch',
            'title' => esc_html__('Notify Section', 'carspot'),
            'subtitle' => '',
            'default' => false
        ),
        array(
            'id' => 'mailchimp_notify_list_id',
            'type' => 'text',
            'title' => esc_html__('MailChimp List ID', 'carspot'),
            'required' => array('coming_soon_notify', '=', true),
            'desc' => carspot_make_link('http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id', esc_html__('How to Find it', 'carspot')),
        ),
        array(
            'id' => 'sb_comming_soon_date',
            'type' => 'text',
            'title' => esc_html__('Set Date', 'carspot'),
            'subtitle' => esc_html__('When you ready to launch', 'carspot'),
            'desc' => esc_html__('YYYY/MM/DD', 'carspot'),
            'default' => '2017/06/28',
        ),
        array(
            'id' => 'sb_comming_soon_title',
            'type' => 'textarea',
            'title' => esc_html__('Description', 'carspot'),
            'default' => 'Our website is under construction.',
        ),
        array(
            'id' => 'social_media_soon',
            'type' => 'sortable',
            'title' => esc_html__('Social Media', 'carspot'),
            'desc' => esc_html__('You can sort it out as you want.', 'carspot'),
            'label' => true,
            'options' => array(
                'Facebook' => '',
                'Twitter' => '',
                'Linkedin' => '',
                'Google' => '',
                'YouTube' => '',
                'Vimeo' => '',
                'Pinterest' => '',
                'Tumblr' => '',
                'Instagram' => '',
                'Reddit' => '',
                'Flickr' => '',
                'StumbleUpon' => '',
                'Delicious' => '',
                'dribble' => '',
                'behance' => '',
                'DeviantART' => '',
            ),
        ),
    )
));

/* ------------------Social Media ----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Social Media', 'carspot'),
    'id' => 'sb_theme_social_media',
    'desc' => '',
    'icon' => 'el el-share',
    'fields' => array(
        array(
            'id' => 'social_media',
            'type' => 'sortable',
            'title' => esc_html__('Social Media', 'carspot'),
            'desc' => esc_html__('You can sort it out as you want.', 'carspot'),
            'label' => true,
            'options' => array(
                'Facebook' => '',
                'Twitter' => '',
                'Linkedin' => '',
                'Google' => '',
                'YouTube' => '',
                'Vimeo' => '',
                'Pinterest' => '',
                'Tumblr' => '',
                'Instagram' => '',
                'Reddit' => '',
                'Flickr' => '',
                'StumbleUpon' => '',
                'Delicious' => '',
                'dribble' => '',
                'behance' => '',
                'DeviantART' => '',
            ),
            'default' => array(
                'Facebook' => '#',
                'Twitter' => '#',
                'Linkedin' => '#',
                'Google' => '#',
                'YouTube' => '#',
            ),
        ),
    )
));

/* ------------------  Footer Settings----------------------- */
Redux::setSection($opt_name, array(
    'title' => esc_html__('Footer Settings', 'carspot'),
    'id' => 'sb-footer',
    'desc' => '',
    'icon' => 'el el-cog-alt',
    'fields' => array(
        array(
            'id' => 'footer_type',
            'type' => 'button_set',
            'title' => esc_html__('Footer Style', 'carspot'),
            'options' => array(
                'white' => 'White',
                'dark' => 'Dark',
                'short_footer' => 'Short Footer',
                'transparent' => 'Transparent',
                'elementorproFooter' => 'Elementor Footer',
            ),
            'default' => 'white'
        ),
        array(
            'id' => 'footer_logo',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Footer Logo', 'carspot'),
            'compiler' => 'true',
            'desc' => esc_html__('Site Logo image for the site.', 'carspot'),
            'subtitle' => esc_html__('Dimensions: 230 x 40', 'carspot'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
            'required' => array(
                array('footer_type', '=', array('transparent', 'white', 'dark')),
            )
        ),
        array(
            'id' => 'footer_bg',
            'type' => 'media',
            'url' => true,
            'title' => esc_html__('Footer bg', 'carspot'),
            'compiler' => 'true',
            'desc' => esc_html__('Footer background image.', 'carspot'),
            'subtitle' => esc_html__('provide hight resolution image too look it sharp', 'carspot'),
            'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
            'required' => array(
                array('footer_type', '=', array('transparent', 'short_footer')),
            )
        ),
        array(
            'id' => 'footer_text_under_logo',
            'type' => 'textarea',
            'title' => esc_html__('Footer Text', 'carspot'),
            'subtitle' => esc_html__('under logo', 'carspot'),
            'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur et dolor eget erat fringilla port.',
            'required' => array(
                array('footer_type', '=', array('transparent', 'white', 'dark')),
            )
        ),
        array(
            'id' => 'app_main_title',
            'type' => 'text',
            'title' => esc_html__('App Section Heading', 'carspot'),
            'subtitle' => esc_html__('Footer App Section Heading', 'carspot'),
            'default' => 'Get Our Apps',
            'required' => array(
                array('footer_type', '=', array('transparent', 'short_footer')),
            )
        ),
        array(
            'id' => 'footer_android_app',
            'type' => 'text',
            'title' => esc_html__('Android App Link', 'carspot'),
            'default' => '#',
        ),
        array(
            'id' => 'footer_ios_app',
            'type' => 'text',
            'title' => esc_html__('IOS App Link', 'carspot'),
            'default' => '',
        ),
        array(
            'id' => 'footer_text_under_apps_btn',
            'type' => 'textarea',
            'title' => esc_html__('Footer Text under app buttons', 'carspot'),
            'subtitle' => esc_html__('text under the  apps download buttons', 'carspot'),
            'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur et dolor eget erat fringilla port.',
        ),
        array(
            'id' => 'section_2_title',
            'type' => 'text',
            'title' => esc_html__('Section-2 Title', 'carspot'),
            'subtitle' => esc_html__('Footer Section', 'carspot'),
            'default' => 'Follow Us',
            'required' => array(
                array('footer_type', '=', array('white', 'dark')),
            )
        ),
        array(
            'id' => 'section_4_title',
            'type' => 'text',
            'title' => esc_html__('Section-3 Title', 'carspot'),
            'subtitle' => esc_html__('Footer Section', 'carspot'),
            'default' => 'Quick Links',
            'required' => array('footer_type', '=', 'transparent'),
        ),
        array(
            'id' => 'sb_footer_pages',
            'type' => 'select',
            'data' => 'pages',
            'multi' => true,
            'sortable' => true,
            'title' => esc_html__('QUICK LINKS', 'carspot'),
            'desc' => esc_html__('Select Page Links For The Footer', 'carspot'),
            'required' => array('footer_type', '=', 'transparent'),
        ),
        array(
            'id' => 'section_4_title',
            'type' => 'text',
            'title' => esc_html__('Quick Links Title', 'carspot'),
            'subtitle' => esc_html__('Footer Section', 'carspot'),
            'default' => 'Quick Links',
            'required' => array(
                array('footer_type', '=', array('white', 'dark', 'transparent')),
            )
        ),
        array(
            'id' => 'sb_footer_links',
            'type' => 'select',
            'data' => 'pages',
            'multi' => true,
            'sortable' => true,
            'title' => esc_html__('QUICK LINKS', 'carspot'),
            'desc' => esc_html__('Select Page Links For The Footer', 'carspot'),
            'required' => array(
                array('footer_type', '=', array('white', 'dark')),
            )
        ),
        array(
            'id' => 'section_3_title',
            'type' => 'text',
            'title' => esc_html__('Section-4 Title', 'carspot'),
            'subtitle' => esc_html__('Footer Section', 'carspot'),
            'default' => 'Singup for Weekly Newsletter',
            'required' => array(
                array('footer_type', '=', array('white', 'dark')),
            )
        ),
        array(
            'id' => 'section_3_text',
            'type' => 'text',
            'title' => esc_html__('Section-4 Description', 'carspot'),
            'subtitle' => esc_html__('Footer Section', 'carspot'),
            'default' => 'We may send you information about related events, webinars, products and services which we believe.',
            'required' => array(
                array('footer_type', '=', array('white', 'dark')),
            )
        ),
        array(
            'id' => 'section_3_mc',
            'type' => 'switch',
            'title' => esc_html__('News Letter', 'carspot'),
            'subtitle' => '',
            'default' => true,
            'required' => array(
                array('footer_type', '=', array('white', 'dark')),
            )
        ),
        array(
            'id' => 'mailchimp_footer_list_id',
            'type' => 'text',
            'title' => esc_html__('MailChimp List ID', 'carspot'),
            'required' => array('section_3_mc', '=', true),
            'desc' => carspot_make_link('http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id', esc_html__('How to Find it', 'carspot')),
            'required' => array(
                array('footer_type', '=', array('white', 'dark')),
            )
        ),
        array(
            'id' => 'sb_footer',
            'type' => 'editor',
            'title' => esc_html__('Footer Bar', 'carspot'),
            'default' => 'Copyright 2019 &copy; Theme Created By ScriptsBundle, All Rights Reserved.',
            'args' => array(
                'wpautop' => false,
                'media_buttons' => false,
                'textarea_rows' => 5,
                'teeny' => false,
                'quicktags' => false,
            )
        ),
    )
));

/*
 * WPML Settings
 */
if (function_exists('icl_object_id')) {
    Redux::setSection($opt_name, array(
        'title' => esc_html__('WPML Settings', 'carspot'),
        'id' => 'cs-wpml',
        'desc' => '',
        'icon' => 'el el-globe-alt',
        'fields' => array(
            array(
                'id' => 'cs_duplicate_post',
                'type' => 'switch',
                'title' => esc_html__('Duplicate Posts', 'carspot'),
                'subtitle' => __('Enable this option to duplicate posts in all others languages after successfully publish.', 'carspot'),
                'desc' => esc_html__('Note : Disable means the posts publish only in the current language.', 'carspot'),
                'default' => false,
            ),
            array(
                'id' => 'cs_display_post',
                'type' => 'switch',
                'title' => esc_html__('Display Posts', 'carspot'),
                'subtitle' => __('Enable this option to display all others languages posts in current language.', 'carspot'),
                'desc' => esc_html__('Note : Disable means to display only current language posts.', 'carspot'),
                'default' => false,
            ),
            array(
                'id' => 'cs_lang_switcher',
                'type' => 'switch',
                'title' => esc_html__('Language Switcher on Topbar', 'carspot'),
                'subtitle' => __('Enable this option to display language switcher on topbar.', 'carspot'),
                'default' => false,
            ),
            array(
                'id' => 'cs_menu_lang_switch',
                'type' => 'switch',
                'title' => esc_html__('Language Switcher in Menu', 'carspot'),
                'subtitle' => __('Enable this option to Show language switcher in menu.', 'carspot'),
                'default' => false,
            ),
        )
    ));
}