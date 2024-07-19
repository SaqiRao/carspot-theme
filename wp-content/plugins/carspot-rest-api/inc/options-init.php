<?php

/* Theme Options For Carspot WordPress API Theme */
if (!class_exists('Redux')) {
    return;
}
$opt_name = "carspotAPI";
$theme = wp_get_theme();
$args = array(
    'opt_name' => 'carspotAPI',
    'dev_mode' => false,
    'display_name' => __('Carspot Apps API Options', "carspot-rest-api"),
    'display_version' => '1.0.0',
    'page_title' => __('Carspot Apps API Options', "carspot-rest-api"),
    'update_notice' => true,
    'admin_bar' => true,
    'menu_type' => 'submenu',
    'menu_title' => __('Apps API Options', "carspot-rest-api"),
    'allow_sub_menu' => true,
    'page_parent_post_type' => 'your_post_type',
    'customizer' => true,
    'default_show' => true,
    'default_mark' => '*',
    'hints' => array(
        'icon_position' => 'right',
        'icon_size' => 'normal',
        'tip_style' => array('color' => 'light',),
        'tip_position' => array('my' => 'top left', 'at' => 'bottom right',),
        'tip_effect' => array(
            'show' => array('duration' => '500', 'event' => 'mouseover',),
            'hide' => array('duration' => '500', 'event' => 'mouseleave unfocus',),
        ),
    ),
    'output' => true,
    'output_tag' => true,
    'settings_api' => true,
    'cdn_check_time' => '1440',
    'compiler' => true,
    'global_variable' => 'carspotAPI',
    'page_permissions' => 'manage_options',
    'save_defaults' => true,
    'show_import_export' => true,
    'database' => 'options',
    'transient_time' => '3600',
    'network_sites' => true,
);


$args['share_icons'][] = array(
    'url' => 'https://www.facebook.com/scriptsbundle',
    'title' => __('Like us on Facebook', "carspot-rest-api"),
    'icon' => 'el el-facebook'
);

Redux::setArgs($opt_name, $args);

/* ------------------ App Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => __('App Settings', "carspot-rest-api"),
    'id' => 'api_app_settings',
    'desc' => '',
    'icon' => 'el el-cogs',
    'fields' => array(
        array(
            'id' => 'app_is_open',
            'type' => 'switch',
            'title' => __('Make App Open', "carspot-rest-api"),
            'desc' => __('Make App Open For Public', "carspot-rest-api"),
            'default' => false,
        ),
        array(
            'id' => 'app_logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Logo', 'carspot-rest-api'),
            'compiler' => 'true',
            'desc' => __('Site Logo image for the site.', 'carspot-rest-api'),
            'subtitle' => __('Dimensions: 230 x 40', 'carspot-rest-api'),
            'default' => array('url' => CARSPOT_API_PLUGIN_URL . "images/logo.png"),
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => __('Language and Color', 'carspot-rest-api'),
    'id' => 'app_settings_lang_color',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'app_settings_rtl',
            'type' => 'switch',
            'title' => __('RTL', "carspot-rest-api"),
            'desc' => __('Make app RTL', "carspot-rest-api"),
            'default' => false,
        ),
        array(
            'id' => 'gmap_lang',
            'type' => 'text',
            'title' => __('App Language', 'carspot-rest-api'),
            'desc' => carspotAPI_make_link('https://developers.google.com/maps/faq#languagesupport', __('List of available languages.', 'carspot-rest-api')) . __('If you have selected RTL put language code here like for arabic ar', "carspot-rest-api"),
            'default' => 'en',
        ),
        array(
            'id' => 'app_settings_color',
            'type' => 'color',
            'transparent' => false,
            'title' => __('Select App Colour', 'redux-framework-demo'),
            'subtitle' => __('Pick a title color for the app (default: #fb236a).', 'nokri-rest-api'),
            'default' => '#f58936',
        ),
    )
));


Redux::setSection($opt_name, array(
    'title' => __('Social Login Settings', 'carspot-rest-api'),
    'id' => 'app_settings_social_btn',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'app_settings_fb_btn',
            'type' => 'switch',
            'title' => __('Facebook Login/Register', "carspot-rest-api"),
            'desc' => __('Show or hide google button.', "carspot-rest-api"),
            'default' => true,
        ),
        array(
            'id' => 'app_settings_google_btn',
            'type' => 'switch',
            'title' => __('Google Login/Register', "carspot-rest-api"),
            'desc' => __('Show or hide google button.', "carspot-rest-api"),
            'default' => false,
        ),
        array(
            'id' => 'app_settings_apple_btn',
            'type' => 'switch',
            'title' => __('Apple Login/Register', "carspot-rest-api"),
            'desc' => __('Show or hide Apple button.', "carspot-rest-api"),
            'default' => true,
        ),
        array(
            'id' => 'app_register_tagline',
            'type' => 'text',
            'title' => __('Tagline', "carspot-rest-api"),
            'desc' => __('Show or hide register tagline.', "carspot-rest-api"),
            'default' => __('Over 25000 classified ads listing.', "carspot-rest-api"),
        ),
        array(
            'id' => 'sb_enable_social_links',
            'type' => 'switch',
            'title' => __('Enable Social Profiles', 'carspot-rest-api'),
            'subtitle' => __('for display', 'carspot-rest-api'),
            'default' => false,
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => __('Slider Settings', 'carspot-rest-api'),
    'id' => 'app_settings_slider',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'sb_enable_featured_slider_scroll',
            'type' => 'switch',
            'title' => __('Enable Scroll On Featured Ads', 'carspot-rest-api'),
            'desc' => __('Turn on/off auto scroll on the featured ads slider', 'carspot-rest-api'),
            'default' => false,
        ),
        array(
            'id' => 'sb_enable_featured_slider_duration',
            'type' => 'text',
            'title' => __('Slider Scroll Speed', 'carspot-rest-api'),
            'default' => 40,
            'required' => array('sb_enable_featured_slider_scroll', '=', true),
            'desc' => __('Enter value in milisecons 1000 is 1 second', 'carspot-rest-api'),
        ),
        array(
            'id' => 'sb_enable_featured_slider_loop',
            'type' => 'text',
            'title' => __('Slider Loop scroll', 'carspot-rest-api'),
            'default' => 2000,
            'required' => array('sb_enable_featured_slider_scroll', '=', true),
            'desc' => __('Enter value in milisecons 1000 is 1 second. Once end starts again after X number of seconds', 'carspot-rest-api'),
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => __('App Pages', 'carspot-rest-api'),
    'id' => 'app_settings_pages_section',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'app_settings_pages',
            'type' => 'select',
            'data' => 'pages',
            'multi' => true,
            'sortable' => true,
            'title' => __('Select Pages', 'carspot-rest-api'),
        ),
    )
));

/* ------------------App Rating ----------------------- */
Redux::setSection($opt_name, array(
    'title' => __('App Share/Rating', 'carspot-rest-api'),
    'id' => 'app_share_rating',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'allow_app_rating',
            'type' => 'switch',
            'title' => __('App Rating', "carspot-rest-api"),
            'desc' => __('Show app rating icon on the top.', "carspot-rest-api"),
            'default' => false,
        ),
        array(
            'id' => 'allow_app_rating_title',
            'type' => 'text',
            'title' => __('Rating Title', 'carspot-rest-api'),
            'default' => __("App Store Rating", "carspot-rest-api"),
            'required' => array('allow_app_rating', '=', '1'),
            'desc' => __('Rating title in the popup.', 'carspot-rest-api'),
        ),
        array(
            'id' => 'allow_app_rating_url',
            'type' => 'text',
            'title' => __('App URL', 'carspot-rest-api'),
            'default' => '',
            'required' => array('allow_app_rating', '=', '1'),
            'desc' => __('Enter app URL for app rating. URL is required', 'carspot-rest-api'),
        ),
        array(
            'id' => 'allow_app_share',
            'type' => 'switch',
            'title' => __('App Share', "carspot-rest-api"),
            'desc' => __('Show app share icon on the top.', "carspot-rest-api"),
            'default' => false,
        ),
        array(
            'id' => 'allow_app_share_title',
            'type' => 'text',
            'title' => __('Share Popup Title', 'carspot-rest-api'),
            'default' => __("Share this", "carspot-rest-api"),
            'required' => array('allow_app_share', '=', '1'),
            'desc' => __('title in the popup.', 'carspot-rest-api'),
        ),
        array(
            'id' => 'allow_app_share_text',
            'type' => 'text',
            'title' => __('Subject', 'carspot-rest-api'),
            'default' => '',
            'required' => array('allow_app_share', '=', '1'),
            'desc' => __('App share subject. Not required.', 'carspot-rest-api'),
        ),
        array(
            'id' => 'allow_app_share_url',
            'type' => 'text',
            'title' => __('App Share URL', 'carspot-rest-api'),
            'default' => '',
            'required' => array('allow_app_share', '=', '1'),
            'desc' => __('Enter app share URL for app sharing. URL is required.', 'carspot-rest-api'),
        ),
    )
));


/* ------------------About Us ----------------------- */
Redux::setSection($opt_name, array(
    'title' => __('About Us', 'carspot-rest-api'),
    'id' => 'other_pages_1',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'other-pages-1-title',
            'type' => 'text',
            'title' => __('Main Title', 'carspot-rest-api'),
            'default' => __('About Us', 'carspot-rest-api'),
        ),
        array(
            'id' => 'other-pages-1-desc',
            'type' => 'editor',
            'title' => __('Description', 'carspot-rest-api'),
        ),
        array(
            'id' => 'other_pages_1_show',
            'type' => 'switch',
            'title' => __('Show Accordians ', "carspot-rest-api"),
            'desc' => __('This show accordians on your app about us page.', "carspot-rest-api"),
            'default' => true,
        ),
        array(
            'id' => 'other-pages-1-slides',
            'show' => array('title' => true, 'description' => true, 'url' => false),
            'type' => 'slides',
            'class' => 'carspot-hide-upload',
            'title' => __('Slides Options', 'redux-framework-demo'),
            'subtitle' => __('Unlimited slides with drag and drop sortings.', 'redux-framework-demo'),
            'desc' => __('This field will store all slides values into a multidimensional array to use into a foreach loop.', 'redux-framework-demo'),
            'required' => array('other_pages_1_show', '=', true),
            'placeholder' => array(
                'title' => __('This is a title', 'redux-framework-demo'),
                'description' => __('Description Here', 'redux-framework-demo'),
                'url' => __('Give us a link!', 'redux-framework-demo'),
            ),
        ),
    )
));

/* Redux::setSection( $opt_name, array(
  'title'      => __( 'Ads Settings', "carspot-rest-api" ),
  'id'         => 'api_ads_screen1',
  'desc'       => '',
  'subsection' => true,
  'fields'     => array(

  array(
  'id'    => 'opt-info-warning0',
  'type'  => 'info',
  'style' => 'warning',
  'title' => __( 'Ads Setting (AdMob)', 'carspot-rest-api' ),
  'desc'  => __( 'Here you can set the AdMob settings for the app', 'carspot-rest-api' )
  ),

  array(
  'id'       => 'api_ad_show',
  'type'     => 'switch',
  'title'    => __( 'Show Ads', 'carspot-rest-api' ),
  'desc'    => __( 'Trun ads on or off.', 'carspot-rest-api' ),
  'default'  => false,
  ),





  array(
  'id'       => 'api_ad_type_banner',
  'type'     => 'switch',
  'title'    => __( 'Show Banner Ads', 'carspot-rest-api' ),
  'subtitle' => __( 'Turn on or off for banner ads', 'carspot-rest-api' ),
  'default'  => false,
  'required' => array( 'api_ad_show', '=', '1' ),
  ),


  array(
  'id'       => 'api_ad_position',
  'type'     => 'button_set',
  'title'    => __( 'Banner Ad Position', 'carspot-rest-api' ),
  'required' => array( 'api_ad_type_banner', '=', true ),
  'options'  => array(
  'top' => __( 'Top', 'carspot-rest-api' ),
  'bottom' => __( 'Bottom', 'carspot-rest-api' ),
  ),

  'default'  => 'top'
  ),

  array(
  'id'       => 'api_ad_key_banner',
  'type'     => 'text',
  'title'    => __( 'Enter Your Ad Key (banner) Android', 'carspot-rest-api' ),
  'default'  => '',
  'required' => array( array( 'api-is-buy-android-app', '=', true ) , array('api_ad_type_banner', '=', true)),
  'desc'     => __( 'Please make sure you are putting correct ad id your selected above banner', 'carspot-rest-api' ),
  ),

  //Added For IOS

  array(
  'id'       => 'api_ad_key_banner_ios',
  'type'     => 'text',
  'title'    => __( 'Enter Your Ad Key (banner) IOS', 'carspot-rest-api' ),
  'default'  => '',
  'required' => array( array( 'api-is-buy-ios-app', '=', true ) , array('api_ad_type_banner', '=', true)),
  'desc'     => __( 'Please make sure you are putting correct ad id your selected above banner', 'carspot-rest-api' ),
  ),
  //Added For IOS

  array(
  'id'       => 'api_ad_type_initial',
  'type'     => 'switch',
  'title'    => __( 'Show Initial Ads', 'carspot-rest-api' ),
  'subtitle' => __( 'Turn on or off for initial ads', 'carspot-rest-api' ),
  'default'  => false,
  'required' => array( 'api_ad_show', '=', '1' ),
  ),

  array(
  'id'       => 'api_ad_key',
  'type'     => 'text',
  'title'    => __( 'Enter Your Ad Key (initial) Android', 'carspot-rest-api' ),
  'default'  => '',
  'required' => array( array( 'api-is-buy-android-app', '=', true ) , array('api_ad_type_initial', '=', true)),
  'desc'     => __( 'Please make sure you are putting correct ad id your selected above interstital', 'carspot-rest-api' ),
  ),
  //For IOS
  array(
  'id'       => 'api_ad_key_ios',
  'type'     => 'text',
  'title'    => __( 'Enter Your Ad Key (initial) IOS', 'carspot-rest-api' ),
  'default'  => '',
  'required' => array( array( 'api-is-buy-ios-app', '=', true ) , array('api_ad_type_initial', '=', true)),
  'desc'     => __( 'Please make sure you are putting correct ad id your selected above interstital', 'carspot-rest-api' ),
  ),
  //For IOS ends
  array(
  'id'       => 'api_ad_time_initial',
  'type'     => 'text',
  'title'    => __( 'Show 1st Ad After', 'carspot-rest-api' ),
  'default'  => '',
  'required' => array( 'api_ad_type_initial', '=', true ),
  'desc'     => __( 'Show 1st ad after specific time. In seconds 1 is for 1 second', 'carspot-rest-api' ),
  ),
  array(
  'id'       => 'api_ad_time',
  'type'     => 'text',
  'title'    => __( 'Show Ad After', 'carspot-rest-api' ),
  'default'  => '',
  'required' => array( 'api_ad_type_initial', '=', true ),
  'desc'     => __( 'Show ads next time after specific time. In seconds 1 is for 1 second', 'carspot-rest-api' ),
  ),




  )
  ) ); */
Redux::setSection($opt_name, array(
    'title' => __('Analytics Settings', "carspot-rest-api"),
    'id' => 'api_ads_screen2',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-info-warning1',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('App Analytics', 'carspot-rest-api'),
            'desc' => __('Below you can setup analytics for the app.', 'carspot-rest-api')
        ),
        array(
            'id' => 'api_analytics_show',
            'type' => 'switch',
            'title' => __('Make Analytics', 'carspot-rest-api'),
            'desc' => __('Trun ads on or off.', 'carspot-rest-api'),
            'default' => false,
        ),
        array(
            'id' => 'api_analytics_id',
            'type' => 'text',
            'title' => __('Analytics ID', 'carspot-rest-api'),
            'default' => '',
            'required' => array('api_analytics_show', '=', true),
            'desc' => __('Put analytics id here i.e.', 'carspot-rest-api') . ' UA-XXXXXXXXX-X',
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Firebase Settings', "carspot-rest-api"),
    'id' => 'api_ads_screen3',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'opt-info-warning2',
            'type' => 'info',
            'style' => 'warning',
            'title' => __('Puch Nofifications', 'carspot-rest-api'),
            'desc' => __('Below you can setup Puch Nofifications for the app.', 'carspot-rest-api')
        ),
        array(
            'id' => 'api_firebase_id',
            'type' => 'text',
            'title' => __('Firebase API KEY', 'carspot-rest-api'),
            'default' => '',
            'desc' => __('Put firebase api key', 'carspot-rest-api'),
        ),
    )
));


Redux::setSection($opt_name, array(
    'title' => __('App Key Settings', "carspot-rest-api"),
    'id' => 'api_key_settings',
    'desc' => '',
    'icon' => 'el el-key',
    'fields' => array()
));

Redux::setSection($opt_name, array(
    'title' => __('Android Key Settings', "carspot-rest-api"),
    'id' => 'api_key_settingsAndroid',
    'desc' => '',
    'icon' => 'el el-key',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'api_key_settings-info1',
            'type' => 'info',
            'notice' => false,
            'style' => 'info',
            'title' => __('Alert', 'carspot-rest-api'),
            'desc' => __('Once added be carefull editing next time. Those Key Should Be Same In App Header.', 'carspot-rest-api')
        ),
        array(
            'id' => 'api_key_settings-info1-1',
            'type' => 'info',
            'notice' => false,
            'style' => 'info',
            'title' => __('Info', 'carspot-rest-api'),
            'desc' => __('Below section is only for if you have purchased Android App. Then turn it on and enter the purchase code in below text field that will appears.', 'carspot-rest-api')
        ),
        array(
            'id' => 'api-is-buy-android-app',
            'type' => 'switch',
            'title' => __('For Android App', 'carspot-rest-api'),
            'default' => false,
            'desc' => __('If you have purchased the android app.', 'carspot-rest-api'),
        ),
        array(
            'required' => array('api-is-buy-android-app', '=', true),
            'id' => 'appKey_pCode',
            'type' => 'text',
            'title' => __('Enter You Android Purchase Code Here', 'carspot-rest-api'),
            'default' => '',
            'desc' => __('Your android item purchase code got from codecanyon. You have purchased the item seprately.', 'carspot-rest-api'),
            'text_hint' => array(
                'title' => __('Alert', 'carspot-rest-api'),
                'content' => __('Once added be carefull editing next time. This key Should be same in app header.'),
            ),
        ),
        array(
            'required' => array('api-is-buy-android-app', '=', true),
            'id' => 'appKey_Scode',
            'type' => 'text',
            'title' => __('Enter Your Android Secret Code Here', 'carspot-rest-api'),
            'default' => '',
            'text_hint' => array(
                'title' => __('Alert', 'carspot-rest-api'),
                'content' => __('Once added be carefull editing next time. This key Should be same in app header.'),
            ),
            'desc' => __('Just a random number generated by you for app security.', 'carspot-rest-api'),
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => __('IOS Key Settings', "carspot-rest-api"),
    'id' => 'api_key_settingsIos',
    'desc' => '',
    'icon' => 'el el-key',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'api_key_settings-info1-2',
            'type' => 'info',
            'notice' => false,
            'style' => 'info',
            'title' => __('Info', 'carspot-rest-api'),
            'desc' => __('Below section is only for if you have purchased IOS App. Then turn it on and enter the purchase code in below text field that will appears.', 'carspot-rest-api')
        ),
        array(
            'id' => 'api-is-buy-ios-app',
            'type' => 'switch',
            'title' => __('For IOS App', 'carspot-rest-api'),
            'default' => false,
            'desc' => __('If you have purchased the ios app.', 'carspot-rest-api'),
        ),
        array(
            'required' => array('api-is-buy-ios-app', '=', true),
            'id' => 'appKey_pCode_ios',
            'type' => 'text',
            'title' => __('Enter You IOS Purchase Code Here', 'carspot-rest-api'),
            'default' => '',
            'desc' => __('Your IOS item purchase code got from codecanyon. You have purchased the item seprately.', 'carspot-rest-api'),
            'text_hint' => array(
                'title' => __('Alert', 'carspot-rest-api'),
                'content' => __('Once added be carefull editing next time. This key Should be same in app header.'),
            ),
        ),
        array(
            'required' => array('api-is-buy-ios-app', '=', true),
            'id' => 'appKey_Scode_ios',
            'type' => 'text',
            'title' => __('Enter Your IOS Secret Code Here', 'carspot-rest-api'),
            'default' => '',
            'text_hint' => array(
                'title' => __('Alert', 'carspot-rest-api'),
                'content' => __('Once added be carefull editing next time. This key Should be same in app header.'),
            ),
            'desc' => __('Just a random number generated by you for app security.', 'carspot-rest-api'),
        ),
        array(
            'id' => 'appKey_youtubeKey',
            'type' => 'text',
            'title' => __('Enter Your Youtube Key', 'carspot-rest-api'),
            'default' => '',
            'text_hint' => array(
                'title' => __('Alert', 'carspot-rest-api'),
                'content' => __('Once added be carefull editing next time. This key Should be same in app header.'),
            )
        ),
    )
));


Redux::setSection($opt_name, array(
    'title' => __('Stripe Settings', "carspot-rest-api"),
    'id' => 'api_payment_stripe',
    'desc' => '',
    'icon' => 'el el-check',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'api_key_settings-info1-3',
            'type' => 'info',
            'notice' => false,
            'style' => 'info',
            'title' => __('Info', 'carspot-rest-api'),
            'desc' => __('Below section is Other API and Payment settings', 'carspot-rest-api')
        ),
        array(
            'id' => 'appKey_stripe_publishKey',
            'type' => 'text',
            'title' => __('Enter Your Stripe Publishable key Here', 'carspot-rest-api'),
            'default' => '',
            'desc' => __('This will use in app', 'carspot-rest-api'),
            'text_hint' => array(
                'title' => __('Alert', 'carspot-rest-api'),
                'content' => __('Once added be carefull editing next time. This key Should be same in app header.'),
            )
        ),
        array(
            'id' => 'appKey_stripeSKey',
            'type' => 'text',
            'title' => __('Enter Your Stripe Secret key Here', 'carspot-rest-api'),
            'default' => '',
            'desc' => __('This will use at server for varification', 'carspot-rest-api'),
            'text_hint' => array(
                'title' => __('Alert', 'carspot-rest-api'),
                'content' => __('Once added be carefull editing next time. This key Should be same in app header.'),
            )
        ),
    )
));


Redux::setSection($opt_name, array(
    'title' => __('Paypal Settings', "carspot-rest-api"),
    'id' => 'api_payment_paypal',
    'desc' => '',
    'icon' => 'el el-check',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'appKey_paypalMode',
            'type' => 'button_set',
            'title' => __('Paypal Mode', 'carspot-rest-api'),
            'options' => array(
                'live' => __('Live', 'carspot-rest-api'),
                'sandbox' => __('Sandbox', 'carspot-rest-api'),
            ),
            'default' => 'live',
        ),
        array(
            'id' => 'appKey_paypalKey',
            'type' => 'text',
            'title' => __('Enter Your Paypal Key', 'carspot-rest-api'),
            'default' => '',
            'text_hint' => array(
                'title' => __('Alert', 'carspot-rest-api'),
                'content' => __('Once added be carefull editing next time. This key Should be same in app header.'),
            ),
            'desc' => __('Enter you paypal client id here', 'carspot-rest-api'),
        ),
        array(
            'id' => 'appKey_paypalClientSecret',
            'type' => 'text',
            'title' => __('Enter Your Paypal Secret', 'carspot-rest-api'),
            'default' => '',
            'text_hint' => array(
                'title' => __('Alert', 'carspot-rest-api'),
                'content' => __('Once added be carefull editing next time. This key Should be same in app header.'),
            ),
            'desc' => __('Enter you paypal Secret id here', 'carspot-rest-api'),
        ),
        array(
            'id' => 'paypalKey_merchant_name',
            'type' => 'text',
            'title' => __('Merchant Name', 'carspot-rest-api'),
            'default' => '',
            'desc' => __('Enter the merchant name', 'carspot-rest-api'),
        ),
        array(
            'id' => 'paypalKey_currency',
            'type' => 'text',
            'title' => __('Account Currency', 'carspot-rest-api'),
            'default' => '',
            'desc' => __('Currency name i.e. USD Supported currency list here: ', 'carspot-rest-api') . ' https://developer.paypal.com/docs/integration/direct/rest/currency-codes/',
        ),
        array(
            'id' => 'paypalKey_privecy_url',
            'type' => 'text',
            'title' => __('Privecy Url', 'carspot-rest-api'),
            'default' => '',
            'desc' => __('Example link ', 'carspot-rest-api') . 'https://www.example.com/privacy',
        ),
        array(
            'id' => 'paypalKey_agreement',
            'type' => 'text',
            'title' => __('Agreement Url', 'carspot-rest-api'),
            'default' => '',
            'desc' => __('Example link ', 'carspot-rest-api') . 'https://www.example.com/legal',
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => __('InApp Purchase Settings', "carspot-rest-api"),
    'id' => 'api_payment_inapp',
    'desc' => '',
    'icon' => 'el el-check',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'api-inapp-android-app',
            'type' => 'switch',
            'title' => __('Android InApp Purchase', 'carspot-rest-api'),
            'default' => false,
            'desc' => __('If you have purchased the android app.', 'carspot-rest-api'),
        ),
        array(
            'required' => array('api-inapp-android-app', '=', true),
            'id' => 'api_inapp-info1-1',
            'type' => 'info',
            'notice' => false,
            'style' => 'info',
            'title' => __('Info', 'carspot-rest-api'),
            'desc' => __('Go to Application then you will see Development tools option on the left side of menu. Click this option now navigate to Services &APIs. Now you will Licensing & in-app billing section copy the key from here.', 'carspot-rest-api')
        ),
        array(
            'required' => array('api-inapp-android-app', '=', true),
            'id' => 'inApp_androidSecret',
            'type' => 'textarea',
            'title' => __('Your Android InApp Secret Code Here', 'carspot-rest-api'),
            'default' => '',
            'desc' => __('Enter the secret code you got from store. While copy paste please make sure there is no white space.', 'carspot-rest-api'),
            'text_hint' => array(
                'title' => __('Alert', 'carspot-rest-api'),
                'content' => __('Once added be carefull editing next time.'),
            ),
        ),
        array(
            'id' => 'api-inapp-ios-app',
            'type' => 'switch',
            'title' => __('AppStore InApp Purchase', 'carspot-rest-api'),
            'default' => false,
            'desc' => __('If you have purchased the AppStore app.', 'carspot-rest-api'),
        ),
        array(
            'required' => array('api-inapp-ios-app', '=', true),
            'id' => 'inApp_iosSecret',
            'type' => 'textarea',
            'title' => __('Your AppStore InApp Secret Code Here', 'carspot-rest-api'),
            'default' => '',
            'desc' => __('Enter the secret code you got from store. While copy paste please make sure there is no white space.', 'carspot-rest-api'),
            'text_hint' => array(
                'title' => __('Alert', 'carspot-rest-api'),
                'content' => __('Once added be carefull editing next time.'),
            ),
        ),
    )
));


Redux::setSection($opt_name, array(
    'title' => __('Thank You Settings', "carspot-rest-api"),
    'id' => 'api_payment_thankyou',
    'desc' => '',
    'icon' => 'el el-check',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'payment_thankyou',
            'type' => 'text',
            'title' => __('Thank You Title', 'carspot-rest-api'),
            'default' => __('Thank You For Your Order', 'carspot-rest-api'),
        ),
    )
));


Redux::setSection($opt_name, array(
    'title' => __('Menu Settings', "carspot-rest-api"),
    'id' => 'api_menu_settings',
    'desc' => '',
    'icon' => 'el el-align-justify',
    'fields' => array(
        array(
            'id' => 'api-sortable-app-menu',
            'type' => 'sortable',
            'title' => __('Menu Title Control', 'carspot-rest-api'),
            'desc' => __('Chnage menu title to what you want. If you want to hide any menu item make it empty.', 'carspot-rest-api'),
            'label' => true,
            'options' => array(
                'home' => __("Home", "carspot-rest-api"),
                'profile' => __("Profile", "carspot-rest-api"),
                'search' => __("Advance Search", "carspot-rest-api"),
                'inbox_list' => __("Inbox List", "carspot-rest-api"),
                'sell_your_car' => __("Sell Your Car", "carspot-rest-api"),
                'comparison_search' => __("Comparison Search", "carspot-rest-api"),
                'packages' => __("Packages", "carspot-rest-api"),
                'review' => __("Review", "carspot-rest-api"),
                'about_us' => __("About Us", "carspot-rest-api"),
                'contact_us' => __("Contact Us", "carspot-rest-api"),
                'dynamic_pages' => __("Dynamic Pages", "carspot-rest-api"),
                'blog' => __("Blog", "carspot-rest-api"),
                'logout' => __("Logout", "carspot-rest-api"),
                'login' => __("Login", "carspot-rest-api"),
                'register' => __("Register", "carspot-rest-api"),
                'language' => __("Select Language", "carspot-rest-api"),
            )
        ),
        array(
            'id' => 'carspot_dynamic_pages',
            'type' => 'select',
            'data' => 'pages',
            'multi' => true,
            'sortable' => true,
            'title' => __('Select Dynamic Page', 'carspot-rest-api'),
            'subtitle' => __('Select/sort Pages', 'carspot-rest-api'),
            'desc' => __('It will replace the Dynamic Pages from above menu', 'carspot-rest-api'),
        ),
        array(
            'id' => 'api-menu-message-count',
            'type' => 'switch',
            'title' => __('Show Message Count', 'carspot-rest-api'),
            'default' => false,
            'desc' => __('Turn on/off Show Message Count in menu.', 'carspot-rest-api'),
        ),
    )
));
/*
 * Home Screen
 * Themes Settings
 */
Redux::setSection($opt_name, array(
    'title' => __("Home Screen Themes", "carspot-rest-api"),
    'id' => 'api_home_theme_section',
    'fields' => array(
        array(
            'id' => 'home_thme_header_title',
            'type' => 'text',
            'title' => __('Home theme main title', 'carspot-rest-api'),
            'default' => __('Automotive Car Dealer', 'carspot-rest-api'),
        ),
        array(
            'id' => 'home_thme_header_sub_title',
            'type' => 'text',
            'title' => __('Home theme sub title', 'carspot-rest-api'),
            'default' => __('More than 17,000 business listed', 'carspot-rest-api'),
        ),
        array(
            'id' => 'total_no_cars_your_area',
            'type' => 'text',
            'title' => __('Nomber of used cars in your area', 'carspot-rest-api'),
            'default' => __('17,288', 'carspot-rest-api'),
        ),
        array(
            'id' => 'total_no_cars_your_area_text',
            'type' => 'text',
            'title' => __('User cars in your Town', 'carspot-rest-api'),
            'default' => __('Used cars for sale in you Town search now', 'carspot-rest-api'),
        ),
        array(
            'id' => 'home_theme_baner_img',
            'type' => 'media',
            'url' => true,
            'title' => __('Home theme banner image', 'carspot-rest-api'),
            'compiler' => 'true',
            'default' => array('url' => CARSPOT_API_PLUGIN_URL . "images/theme-baner.png"),
        ),
        array(
            'id' => 'app_home_themes',
            'type' => 'image_select',
            'title' => __('Select Home Theme', 'carspot-rest-api'),
            'desc' => __('Select your home screen.', 'carspot-rest-api'),
            'subtitle' => __('Only Home Screen 1 work with sortable options.', 'carspot-rest-api'),
            'options' => array(
                '0' => array(
                    'alt' => __('Home Screen 0', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/0.png',
                ),
                '1' => array(
                    'alt' => __('Home Screen 1', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/1.png',
                ),
                '2' => array(
                    'alt' => __('Home Screen 2', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/2.png'
                ),
                '3' => array(
                    'alt' => __('Home Screen 3', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/3.png'
                ),
                '4' => array(
                    'alt' => __('Home Screen 4', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/4.png'
                ),
                '5' => array(
                    'alt' => __('Home Screen 5', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/5.png'
                ),
                '6' => array(
                    'alt' => __('Home Screen 6', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/6.png'
                ),
                '7' => array(
                    'alt' => __('Home Screen 7', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/7.png'
                ),
                '8' => array(
                    'alt' => __('Home Screen 8', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/8.png'
                ),
                '9' => array(
                    'alt' => __('Home Screen 9', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/9.png'
                ),
                '10' => array(
                    'alt' => __('Home Screen 10', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/10.png'
                ),
            ),
            'default' => '4'
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => __("Body Type Section Views", "carspot-rest-api"),
    'id' => 'api_home_body_type_sec_views',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'carspot_api_body_sec_views',
            'type' => 'image_select',
            'title' => __('Choose view for Body Type Section', 'carspot-rest-api'),
            'subtitle' => __('Body Type Section View', 'carspot-rest-api'),
            'options' => array(
                '1' => array(
                    'alt' => __('Body Type View 1', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/bodytypes/1.png',
                ),
                '2' => array(
                    'alt' => __('Body Type View 2', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/bodytypes/2.png'
                ),
                '3' => array(
                    'alt' => __('Body Type View 3', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/bodytypes/3.png'
                ),
                '4' => array(
                    'alt' => __('Body Type View 4', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/bodytypes/4.png'
                ),
                '5' => array(
                    'alt' => __('Body Type View 5', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/bodytypes/5.png'
                ),
                '6' => array(
                    'alt' => __('Body Type View 6', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/bodytypes/6.png'
                ),
                '7' => array(
                    'alt' => __('Body Type View 7', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/bodytypes/7.png'
                ),
            ),
            'default' => '3'
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => __("Feature Listing Section Views", "carspot-rest-api"),
    'id' => 'api_home_feature_list_sec_views',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'carspot_api_list_sec_views',
            'type' => 'image_select',
            'title' => __('Choose view for Feature Listing Section', 'carspot-rest-api'),
            'subtitle' => __('Feature Listing Section View', 'carspot-rest-api'),
            'options' => array(
                '1' => array(
                    'alt' => __('Feature Listing View 1', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/featureList/1.png',
                ),
                '2' => array(
                    'alt' => __('Feature Listing View 2', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/featureList/2.png'
                ),
                '3' => array(
                    'alt' => __('Feature Listing View 3', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/featureList/3.png'
                ),
                '4' => array(
                    'alt' => __('Feature Listing View 4', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/featureList/4.png'
                ),
                '5' => array(
                    'alt' => __('Feature Listing View 5', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/featureList/5.png'
                ),
                '6' => array(
                    'alt' => __('Feature Listing View 6', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/featureList/6.png'
                ),
            ),
            'default' => '1'
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => __("Body Make Section Views", "carspot-rest-api"),
    'id' => 'api_home_body_make_sec_views',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'carspot_api_body_make_views',
            'type' => 'image_select',
            'title' => __('Choose view for Body Make Section', 'carspot-rest-api'),
            'subtitle' => __('Body Make Section View', 'carspot-rest-api'),
            'options' => array(
                '1' => array(
                    'alt' => __('Body Make View 1', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/makes/1.png',
                ),
                '2' => array(
                    'alt' => __('Body Make View 2', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/makes/2.png'
                ),
                '3' => array(
                    'alt' => __('Body Make View 3', 'carspot-rest-api'),
                    'img' => CARSPOT_API_PLUGIN_URL . 'images/makes/3.png'
                ),
            ),
            'default' => '1'
        ),
    )
));

/*
 * Home Screen
 *  */

Redux::setSection($opt_name, array(
    'title' => __('Home Screen', "carspot-rest-api"),
    'id' => 'api_home_screen',
    'desc' => '',
    'icon' => 'el el-home',
    'fields' => array(
        array(
            'id' => 'sb_home_screen_title',
            'type' => 'text',
            'title' => __('Screen Title', 'carspot-rest-api'),
            'default' => __('Home Screen', 'carspot-rest-api'),
            'desc' => __('Set the title for homescreen', 'carspot-rest-api'),
        ),
        array(
            'id' => 'hom_sec_bg',
            'type' => 'media',
            'url' => true,
            'title' => __('Home screen Background', 'carspot-rest-api'),
            'compiler' => 'true',
            'desc' => __('Image for Home screen', 'carspot-rest-api'),
            'subtitle' => __('Dimensions: 800 x 800', 'carspot-rest-api'),
            'default' => array('url' => CARSPOT_API_PLUGIN_URL . "images/home-secreen.jpg"),
        ),
        array(
            'id' => 'hom_sec_tagline',
            'type' => 'text',
            'title' => __('Home screen Tagline', 'carspot-rest-api'),
            'default' => __('Find Adds', 'nokri-rest-api'),
        ),
        array(
            'id' => 'hom_sec_headline',
            'type' => 'text',
            'title' => __('Home screen Headline', 'carspot-rest-api'),
            'default' => __('Search From 1500+ Adds', 'carspot-rest-api'),
        ),
        array(
            'id' => 'hom_sec_place_holder',
            'type' => 'text',
            'title' => __('Home screen Place Holder', 'carspot-rest-api'),
            'default' => __('Search Keywords...', 'carspot-rest-api'),
        ),
        array(
            'id' => 'hom_sec_advance_search',
            'type' => 'text',
            'title' => __('Home screen below search bar text', 'carspot-rest-api'),
            'default' => __('Advance search', 'carspot-rest-api'),
        ),
        array(
            'id' => 'home-notice-info0',
            'type' => 'info',
            'style' => 'info',
            'title' => __('Sort Home Screen Options', 'carspot-rest-api'),
        ),
        array(
            'id' => 'home-screen-sortable-enable',
            'type' => 'switch',
            'title' => __('Home Sortable', 'carspot-rest-api'),
            'default' => false,
            'desc' => __('Sort home sections here', 'carspot-rest-api'),
        ),
        array(
            'required' => array('home-screen-sortable-enable', '=', true),
            'id' => 'home-screen-sortable',
            'type' => 'sortable',
            'mode' => 'checkbox', // checkbox or text
            'title' => __('Sortable Sections', 'carspot-rest-api'),
            'subtitle' => __('Only Home Screen 1 work with this sortable options.', 'carspot-rest-api'),
            'desc' => __('Sort section layouts on homescreen', 'carspot-rest-api'),
            'options' => array(
                'body_type' => __('Body Types', 'carspot-rest-api'),
                'cat_icons' => __('Category Icons', 'carspot-rest-api'),
                'featured_ads' => __('Featured Ads', 'carspot-rest-api'),
                'latest_ads' => __('Latest Ads', 'carspot-rest-api'),
                'cat_locations' => __('Locations Icons', 'carspot-rest-api'),
                'blogNews' => __('Blog/News', 'carspot-rest-api'),
                'comparison' => __('Comparison', 'carspot-rest-api'),
            ),
            'default' => array(
                'cat_icons' => __('Category Icons', 'carspot-rest-api'),
                'sliders' => __('Simple Ads', 'carspot-rest-api'),
            )
        ),
    )
));


/* * ********************** */
/* Body Type Section */
/* * ********************** */
Redux::setSection($opt_name, array(
    'title' => __("Body Type", "carspot-rest-api"),
    'id' => 'api_home_body_type',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        /* Body type */
        array(
            'id' => 'api_home_body_type_switch',
            'type' => 'switch',
            'title' => __('Body Type', 'carspot-rest-api'),
            'default' => false,
            'desc' => __('Show body type slider', 'carspot-rest-api'),
        ),
        array(
            'id' => 'api_home_body_type_section_title',
            'required' => array('api_home_body_type_switch', '=', true),
            'type' => 'text',
            'title' => __('Body Type Section Title', 'carspot-rest-api'),
            'desc' => __('Separate string with sign like Featured|Types', 'carspot-rest-api'),
            'default' => __('Featured|Types', 'carspot-rest-api'),
        ),
        array(
            'required' => array('api_home_body_type_switch', '=', true),
            'id' => 'carspot-api-ad-body-types-multi',
            'type' => 'select',
            'data' => 'terms',
            'args' => array(
                'taxonomies' => 'ad_body_types',
                'hide_empty' => false,
                /* 'taxonomies' => array( 'ad_cats' ), */
            ),
            'multi' => true,
            'sortable' => true,
            'title' => __('Body Type Multi Select Option', 'carspot-rest-api'),
            'desc' => __('This is the description field, again good for additional info.', 'carspot-rest-api'),
        ),
        array(
            'id' => 'api_home_body_type_ad_post',
            'required' => array('api_home_body_type_switch', '=', true),
            'type' => 'text',
            'title' => __('Ad Post Button Title', 'carspot-rest-api'),
            'desc' => __('sell you car button text below the body type boxes.', 'carspot-rest-api'),
            'default' => __('Sell your car', 'carspot-rest-api'),
        ),
    )
));

/* * ********************** */
/* Featured Makes */
/* * ********************** */
Redux::setSection($opt_name, array(
    'title' => __("Featured Makes", "carspot-rest-api"),
    'id' => 'api_home_featured_makes',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        /* Body type */
        array(
            'id' => 'api_home_featured_makes_switch',
            'type' => 'switch',
            'title' => __('Featured Makes', 'carspot-rest-api'),
            'default' => false,
            'desc' => __('Show featured makes slider', 'carspot-rest-api'),
        ),
        array(
            'required' => array('api_home_featured_makes_switch', '=', true),
            'id' => 'categories-section-title',
            'type' => 'text',
            'title' => __('Makes Section Title', 'carspot-rest-api'),
            'default' => __('Featured|Makes', 'carspot-rest-api'),
            'desc' => __('Separate string with sign like Featured|Makes', 'carspot-rest-api'),
        ),
        array(
            'required' => array('api_home_featured_makes_switch', '=', true),
            'id' => 'categories-section-view-all',
            'type' => 'text',
            'title' => __('Makes Section View All', 'carspot-rest-api'),
            'default' => __('View All Makes', 'carspot-rest-api'),
        ),
        array(
            'required' => array('api_home_featured_makes_switch', '=', true),
            'id' => 'api_cat_columns',
            'type' => 'button_set',
            'title' => __('Makes Columns', 'carspot-rest-api'),
            'desc' => __('Select number of info columns', 'carspot-rest-api'),
            'options' => array(
                '3' => __('3 Column', 'carspot-rest-api'),
                '4' => __('4 Columns', 'carspot-rest-api'),
            ),
            'default' => '3'
        ),
        array(
            'required' => array('api_home_featured_makes_switch', '=', true),
            'id' => 'carspot-api-ad-cats-multi',
            'type' => 'select',
            'data' => 'terms',
            'multi' => true,
            'sortable' => true,
            'title' => __('Makes Multi Select Option', 'carspot-rest-api'),
            'desc' => __('Select makes you want to show', 'carspot-rest-api'),
            'args' => array(
                'taxonomies' => array('ad_cats'),
                'hide_empty' => false,
            ),
        ),
    )
));


Redux::setSection($opt_name, array(
    'title' => __("Featured Ads", "carspot-rest-api"),
    'id' => 'api_home_ads_featured',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        /* featured ads */
        array(
            'id' => 'feature_on_home',
            'type' => 'switch',
            'title' => __('Featured Ads', 'carspot-rest-api'),
            'default' => false,
            'desc' => __('Show featured ads slider', 'carspot-rest-api'),
        ),
        array(
            'id' => 'sb_home_ads_title',
            'required' => array('feature_on_home', '=', true),
            'type' => 'text',
            'title' => __('Featured Ads Section Title', 'carspot-rest-api'),
            'desc' => __('Separate string with sign like Featured|Makes', 'carspot-rest-api'),
            'default' => 'Featured Ads',
        ),
        array(
            'id' => 'sb_home_ads_view_all',
            'required' => array('feature_on_home', '=', true),
            'type' => 'text',
            'title' => __('Featured Ads View All Title', 'carspot-rest-api'),
            'default' => __('View All', 'carspot-rest-api'),
        ),
        array(
            'id' => 'home_related_posts_count',
            'required' => array('feature_on_home', '=', true),
            'type' => 'slider',
            'title' => __('Featured Posts', 'carspot-rest-api'),
            'subtitle' => __('On homepage', 'carspot-rest-api'),
            'desc' => __('Select Number of featured posts', 'carspot-rest-api'),
            'default' => 5,
            'min' => 1,
            'step' => 1,
            'max' => 150,
            'display_value' => 'label'
        ),
        array(
            'id' => 'home_featured_position',
            'type' => 'button_set',
            'title' => __('Featured Ads Position', 'carspot-rest-api'),
            'options' => array(
                '1' => __('Top', 'carspot-rest-api'),
                '2' => __('Middle', 'carspot-rest-api'),
                '3' => __('Bottom', 'carspot-rest-api'),
            ),
            'default' => '1',
            'required' => array('feature_on_home', '=', true),
        ),
    )
));


Redux::setSection($opt_name, array(
    'title' => __("Latest Ads", "carspot-rest-api"),
    'id' => 'api_home_latest',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        /* latets ads */
        array(
            'id' => 'home-notice-info2',
            'type' => 'info',
            'style' => 'info',
            'title' => __('Latest Ads Section', 'carspot-rest-api'),
        ),
        array(
            'required' => array('home-screen-sortable-enable', '=', true),
            'id' => 'latest_on_home',
            'type' => 'switch',
            'title' => __('Latest Ads', 'carspot-rest-api'),
            'default' => false,
            'desc' => __('Show latest ads slider', 'carspot-rest-api'),
        ),
        array(
            'id' => 'sb_home_latest_ads_title',
            'required' => array('latest_on_home', '=', true),
            'type' => 'text',
            'title' => __('Latest Ads Section Title', 'carspot-rest-api'),
            'desc' => __('Separate string with sign like Featured|Makes', 'carspot-rest-api'),
            'default' => 'Latest Ads',
        ),
        array(
            'id' => 'sb_home_latest_ads_title_view_all',
            'required' => array('latest_on_home', '=', true),
            'type' => 'text',
            'title' => __('Latest Ads View All Title', 'carspot-rest-api'),
            'default' => __('View All', 'carspot-rest-api'),
        ),
        array(
            'id' => 'home_latest_posts_count',
            'required' => array('latest_on_home', '=', true),
            'type' => 'slider',
            'title' => __('Latest Ads', 'carspot-rest-api'),
            'subtitle' => __('On homepage', 'carspot-rest-api'),
            'desc' => __('Select Number of latest ads', 'carspot-rest-api'),
            'default' => 5,
            'min' => 1,
            'step' => 1,
            'max' => 150,
            'display_value' => 'label'
        ),
    )
));


Redux::setSection($opt_name, array(
    'title' => __("Ads Locations", "carspot-rest-api"),
    'id' => 'api_home_locations',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        /* locations */
        array(
            'id' => 'home-notice-info5',
            'type' => 'info',
            'style' => 'info',
            'title' => __('Locations icons Section', 'carspot-rest-api'),
        ),
        array(
            'required' => array('home-screen-sortable-enable', '=', true),
            'id' => 'api_location_on_home',
            'type' => 'switch',
            'title' => __('Location', 'carspot-rest-api'),
            'default' => false,
            'desc' => __('Show Location on home page', 'carspot-rest-api'),
        ),
        array(
            'required' => array('api_location_on_home', '=', true),
            'id' => 'api_location_title',
            'required' => array('home-screen-sortable-enable', '=', true),
            'type' => 'text',
            'title' => __('Location Section Title', 'carspot-rest-api'),
            'desc' => __('Separate string with sign like Explore|city', 'carspot-rest-api'),
            'default' => __('Explore|city', 'carspot-rest-api'),
        ),
        array(
            'required' => array('api_location_on_home', '=', true),
            'required' => array('home-screen-sortable-enable', '=', true),
            'id' => 'carspot-api-ad-loc-multi',
            'type' => 'select',
            'data' => 'terms',
            'args' => array(
                'taxonomies' => 'ad_country',
                'hide_empty' => false,
            ),
            'multi' => true,
            'sortable' => true,
            'title' => __('Select Locations Categories', 'carspot-rest-api'),
            'desc' => __('Select locations you want to show', 'carspot-rest-api'),
        ),
    )
));


Redux::setSection($opt_name, array(
    'title' => __("Comparison", "carspot-rest-api"),
    'id' => 'api_home_comparison',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        /* locations */
        array(
            'id' => 'home-notice-info7',
            'type' => 'info',
            'style' => 'info',
            'title' => __('Comparison section. (You must on Home Sortable to show comparison)', 'carspot-rest-api'),
        ),
        array(
            'required' => array('home-screen-sortable-enable', '=', true),
            'id' => 'posts_comparison_home',
            'type' => 'switch',
            'title' => __('Comparison', 'carspot-rest-api'),
            'default' => false,
            'desc' => __('Show Comparison', 'carspot-rest-api'),
        ),
        array(
            'id' => 'api_comparison_title',
            'required' => array('posts_comparison_home', '=', true),
            'type' => 'text',
            'title' => __('Comparison Section Title', 'carspot-rest-api'),
            'default' => __('Comparison', 'carspot-rest-api'),
            'desc' => __('Separate string with sign like Top|Comparison', 'carspot-rest-api'),
        ),
        array(
            'id' => 'api_comparison_view_all',
            'required' => array('posts_comparison_home', '=', true),
            'type' => 'text',
            'title' => __('Comparison Section View All', 'carspot-rest-api'),
            'default' => __('View All', 'carspot-rest-api'),
        ),
        array(
            'id' => 'api_comparison_vs_txt',
            'required' => array('posts_comparison_home', '=', true),
            'type' => 'text',
            'title' => __('Comparison V/s text', 'carspot-rest-api'),
            'default' => __('V/S', 'carspot-rest-api'),
        ),
        array(
            'required' => array('posts_comparison_home', '=', true),
            'id' => 'carspot-api-com_car1',
            'type' => 'select',
            'data' => 'post',
            'args' => array('post_type' => array('comparison'), 'numberposts' => -1),
            'multi' => true,
            'title' => __('Comparison Cars', 'redux-framework-demo'),
            'desc' => __('Select 1st car for comparison', 'redux-framework-demo'),
        ),
        array(
            'required' => array('posts_comparison_home', '=', true),
            'id' => 'carspot-api-com_car2',
            'type' => 'select',
            'data' => 'post',
            'args' => array('post_type' => array('comparison'), 'numberposts' => -1),
            'multi' => true,
            'title' => __('Comparison V/S Car', 'redux-framework-demo'),
            'desc' => __('Select second car for comparison', 'redux-framework-demo'),
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => __("Blog/News", "carspot-rest-api"),
    'id' => 'api_home_blogNews',
    'desc' => '',
    'subsection' => true,
    'fields' => array(
        /* locations */
        array(
            'id' => 'home-notice-info7',
            'type' => 'info',
            'style' => 'info',
            'title' => __('Blog and news section. (You must on Home Sortable to show blogs)', 'carspot-rest-api'),
        ),
        array(
            'required' => array('home-screen-sortable-enable', '=', true),
            'id' => 'posts_blogNews_home',
            'type' => 'switch',
            'title' => __('News/Blog', 'carspot-rest-api'),
            'default' => false,
            'desc' => __('Show News/Blog ads slider', 'carspot-rest-api'),
        ),
        array(
            'id' => 'api_blogNews_title',
            'required' => array('posts_blogNews_home', '=', true),
            'type' => 'text',
            'title' => __('Blog/News Setion Title', 'carspot-rest-api'),
            'default' => __('Blog/News', 'carspot-rest-api'),
        ),
        array(
            'required' => array('posts_blogNews_home', '=', true),
            'id' => 'carspot-api-blogNews-multi',
            'type' => 'select',
            'data' => 'terms',
            'args' => array(
                'taxonomies' => 'category',
                'hide_empty' => false,
            ),
            'multi' => true,
            'sortable' => true,
            'title' => __('Select Categories', 'carspot-rest-api'),
            'desc' => __('Select categories to show in the blog/news section. Leave empty if you want to show from all.', 'carspot-rest-api'),
        ),
        array(
            'id' => 'home_blogNews_posts_count',
            'required' => array('posts_blogNews_home', '=', true),
            'type' => 'slider',
            'title' => __('Number of Posts', 'carspot-rest-api'),
            'subtitle' => __('On homepage', 'carspot-rest-api'),
            'desc' => __('Select max number of Posts to show', 'carspot-rest-api'),
            'default' => 5,
            'min' => 1,
            'step' => 1,
            'max' => 150,
            'display_value' => 'label'
        ),
    )
));


/* Home Complete Ends Here */


Redux::setSection($opt_name, array(
    'title' => __("Ad's General Settings", "carspot-rest-api"),
    'id' => 'api_ad_posts',
    'desc' => '',
    'icon' => 'el el-adjust-alt',
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
            'id' => 'report_options',
            'type' => 'text',
            'title' => __('Report ad Options', 'carspot-rest-api'),
            'default' => 'Spam|Offensive|Duplicated|Fake',
        ),
        array(
            'id' => 'report_limit',
            'type' => 'text',
            'title' => __('Ad Report Limit', 'carspot-rest-api'),
            'desc' => __('Only integer value without spaces.', 'carspot-rest-api'),
            'default' => 10,
        ),
        array(
            'id' => 'report_action',
            'type' => 'select',
            'title' => __('Action on Ad Report Limit', 'carspot-rest-api'),
            'options' => array(1 => 'Auto Inactive', 2 => 'Email to Admin'),
            'default' => 1,
        ),
        array(
            'id' => 'report_email',
            'type' => 'text',
            'title' => __('Email', 'carspot-rest-api'),
            'desc' => __('Email where you want to get notify.', 'carspot-rest-api'),
            'required' => array('report_action', '=', array(2)),
            'default' => get_option('admin_email'),
        ),
        array(
            'id' => 'default_related_image',
            'type' => 'media',
            'url' => true,
            'title' => __('Default Image', 'carspot-rest-api'),
            'compiler' => 'true',
            'desc' => __('If there is no image of ad then this will be show.', 'carspot-rest-api'),
            'subtitle' => __('Dimensions: 300 x 225', 'carspot-rest-api'),
            'default' => array('url' => CARSPOT_API_PLUGIN_URL . "images/default-img.png"),
        ),
        array(
            'id' => 'ads_images_sizes',
            'type' => 'button_set',
            'title' => __('Set Image Sizes for listings', 'carspot-rest-api'),
            'options' => array(
                'default' => __('Default', 'carspot-rest-api'),
                'size2' => __('Size 2', 'carspot-rest-api'),
                'size3' => __('Size 3', 'carspot-rest-api'),
                'size4' => __('Size 4', 'carspot-rest-api'),
                'size5' => __('Size 5', 'carspot-rest-api'),
            ),
            'default' => 'default',
            'desc' => __('Change with caution we only recommend default.', 'carspot-rest-api'),
        ),
        array(
            'id' => 'ads_images_sizes_adDetils',
            'type' => 'button_set',
            'title' => __('Set Image Sizes for Ad Details', 'carspot-rest-api'),
            'options' => array(
                'default' => __('Default', 'carspot-rest-api'),
                'size2' => __('Size 2', 'carspot-rest-api'),
            ),
            'default' => 'default',
            'desc' => __('Change with caution we only recommend default.', 'carspot-rest-api'),
        ),
        array(
            'id' => 'app_settings_message_firebase',
            'type' => 'switch',
            'title' => __('Message Settings', "carspot-rest-api"),
            'desc' => __('Send message notification through firebase when receive new message on ad.', "carspot-rest-api"),
            'default' => true,
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => __("Ad Post Settings", "carspot-rest-api"),
    'id' => 'api_ad_post_settings',
    'desc' => '',
    'icon' => 'el el-home',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'adpost_cat_template',
            'type' => 'switch',
            'title' => __('Turn On Category Template', 'carspot-rest-api'),
            'default' => false,
        ),
        array(
            'id' => 'sb_standard_images_size',
            'type' => 'switch',
            'title' => __('Strict image mode', 'carspot-rest-api'),
            'subtitle' => __('Not allowed less than 760x410', 'carspot-rest-api'),
            'default' => false,
        ),
        array(
            'id' => 'sb_upload_limit',
            'type' => 'select',
            'title' => __('Ad image set limit', 'carspot-rest-api'),
            'options' => array(1 => 1,
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
                25 => 25
            ),
            'default' => 5,
        ),
        array(
            'id' => 'sb_upload_size',
            'type' => 'select',
            'title' => __('Ad image max size', 'carspot-rest-api'),
            'options' => array('307200-300kb' => '300kb',
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
            'id' => 'allow_price_type',
            'type' => 'switch',
            'title' => __('Price Type', 'carspot-rest-api'),
            'desc' => __('Display Price type option.', 'carspot-rest-api'),
            'default' => true,
        ),
        array(
            'id' => 'sb_price_types',
            'type' => 'select',
            'options' => array(
                'Fixed' => __('Fixed', 'carspot-rest-api'),
                'Negotiable' => __('Negotiable', 'carspot-rest-api'),
                'on_call' => __('Price on call', 'carspot-rest-api'),
                //'auction' => __('Auction', 'carspot-rest-api'),
                'free' => __('Free', 'carspot-rest-api'),
                'no_price' => __('No price', 'carspot-rest-api'),
            ),
            'multi' => true,
            'sortable' => true,
            'title' => __('Price Types', 'carspot-rest-api'),
            'default' => array(),
        ),
//        array(
//            'id' => 'sb_price_types_more',
//            'type' => 'text',
//            'title' => __('Custom Price Type', 'carspot-rest-api'),
//            'desc' => __('Separated by | like option 1|option 2', 'carspot-rest-api'),
//            'default' => '',
//        ),
        array(
            'id' => 'sb_ad_update_notice',
            'type' => 'text',
            'title' => __('Update Ad Notice', 'carspot-rest-api'),
            'default' => 'Hey, be careful you are updating this AD.',
        ),
        array(
            'id' => 'allow_featured_on_ad',
            'type' => 'switch',
            'title' => __('Allow make featured ad', 'carspot-rest-api'),
            'subtitle' => __('on ad post.', 'carspot-rest-api'),
            'default' => true,
        ),
        array(
            'id' => 'sb_feature_desc',
            'type' => 'textarea',
            'title' => __('Featured ad description', 'carspot-rest-api'),
            'subtitle' => __('on ad post.', 'carspot-rest-api'),
            'required' => array('allow_featured_on_ad', '=', true),
            'default' => 'Featured AD has more attention as compare to simple ad.',
        ),
        /* PDF Brochure options */
        array(
            'id' => 'allow_brochure_on_ad',
            'type' => 'switch',
            'title' => __('Allow Pdf Brochure on ad', 'carspot-rest-api'),
            'subtitle' => __('Pdf Brochure on ad post.', 'carspot-rest-api'),
            'default' => false,
        ),
        array(
            'id' => 'sb_upload_brochure_limit_mb',
            'type' => 'select',
            'title' => __('Brochure limit in MB', 'carspot-rest-api'),
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
            'default' => '5-5MB',
            'required' => array('allow_brochure_on_ad', '=', true),
        ),
        array(
            'id' => 'sb_upload_brochure_count',
            'type' => 'text',
            'title' => __('Brochure Upload limit', 'carspot-rest-api'),
            'subtitle' => __('Only numeric value', 'carspot-rest-api'),
            'default' => 2,
            'required' => array('allow_brochure_on_ad', '=', true),
        ),
        array(
            'id' => 'sb_ad_post_brochure_label',
            'type' => 'text',
            'title' => __('Title of select Brochure', 'carspot-rest-api'),
            'default' => __('Select Brochure', 'carspot-rest-api'),
            'required' => array('allow_brochure_on_ad', '=', true),
        ),
        array(
            'id' => 'sb_ad_post_brochure_size_label',
            'type' => 'text',
            'title' => __('Message for Brochure size', 'carspot-rest-api'),
            'default' => __('Maximum size should be 5 MB', 'carspot-rest-api'),
            'required' => array('allow_brochure_on_ad', '=', true),
        ),
        array(
            'id' => 'sb_advertise_ad_label',
            'type' => 'text',
            'title' => __('Title of Advertise an ad', 'carspot-rest-api'),
            'default' => __('Advertise an ad', 'carspot-rest-api'),
        ),
        /* Video Upload Options */
        array(
            'id' => 'allow_video_on_ad',
            'type' => 'switch',
            'title' => __('Allow Video on ad', 'carspot-rest-api'),
            'subtitle' => __('video on ad post.', 'carspot-rest-api'),
            'default' => true,
        ),
        array(
            'id' => 'sb_upload_video_limit_mb',
            'type' => 'text',
            'title' => __('Video limit in MB', 'carspot-rest-api'),
            'subtitle' => __('Only numeric value', 'carspot-rest-api'),
            'default' => 10,
            'required' => array('allow_video_on_ad', '=', true),
        ),
        array(
            'id' => 'sb_upload_video_limit_duration',
            'type' => 'text',
            'title' => __('Video duration in seconds', 'carspot-rest-api'),
            'subtitle' => __('Only numeric value', 'carspot-rest-api'),
            'default' => 10,
            'required' => array('allow_video_on_ad', '=', true),
        ),
        array(
            'id' => 'sb_upload_video_limit',
            'type' => 'text',
            'title' => __('Video Upload Limit', 'carspot-rest-api'),
            'subtitle' => __('Only numeric value', 'carspot-rest-api'),
            'default' => 5,
            'required' => array('allow_video_on_ad', '=', true),
        ),
        array(
            'id' => 'sb_ad_post_video_label',
            'type' => 'text',
            'title' => __('Title of select video', 'carspot-rest-api'),
            'default' => __('Select Vidoe', 'carspot-rest-api'),
            'required' => array('allow_video_on_ad', '=', true),
        ),
        array(
            'id' => 'sb_ad_upload_video_label',
            'type' => 'text',
            'title' => __('Title of Upload video', 'carspot-rest-api'),
            'default' => __('Upload Video', 'carspot-rest-api'),
            'required' => array('allow_video_on_ad', '=', true),
        ),
        array(
            'id' => 'sb_ad_post_video_size_label',
            'type' => 'text',
            'title' => __('Message for video size', 'carspot-rest-api'),
            'default' => __('Maximum size should be 10 MB', 'carspot-rest-api'),
            'required' => array('allow_video_on_ad', '=', true),
        ),
        array(
            'id' => 'sb_ad_post_video_duration_label',
            'type' => 'text',
            'title' => __('Message for video duration', 'carspot-rest-api'),
            'default' => __('Maximum duration should be 60 seconds', 'carspot-rest-api'),
            'required' => array('allow_video_on_ad', '=', true),
        ),
        array(
            'id' => 'allow_video_quality',
            'type' => 'select',
            'title' => __('Allowed video Quality', 'carspot-rest-api'),
            'options' => array(
                '2160p' => '2160p',
                '1080p' => '1080p',
                '720p' => '720p',
                '480p' => '480p',
                '4.3p' => '4:3'
            ),
            'default' => '480p',
            'required' => array('allow_video_on_ad', '=', true),
        ),
        array(
            'id' => 'sb_ad_post_video_format_msg',
            'type' => 'text',
            'title' => __('Message for video format', 'carspot-rest-api'),
            'default' => __('only mp4 format supported', 'carspot-rest-api'),
            'required' => array('allow_video_on_ad', '=', true),
        ),
        array(
            'id' => 'allow_upload_video_trim',
            'type' => 'switch',
            'title' => __('Allow Video Trim', 'carspot-rest-api'),
            'subtitle' => __('video Trim Yes/No.', 'carspot-rest-api'),
            'default' => false,
            'required' => array('allow_video_on_ad', '=', true),
        ),
        array(
            'id' => 'allow_upload_video_compress',
            'type' => 'switch',
            'title' => __('Allow Video compress', 'carspot-rest-api'),
            'subtitle' => __('video compress Yes/No.', 'carspot-rest-api'),
            'default' => false,
            'required' => array('allow_video_on_ad', '=', true),
        ),
        array(
            'id' => 'allow_video_compression_level',
            'type' => 'select',
            'title' => __('Select Compression Level', 'carspot-rest-api'),
            'options' => array(
                'low' => __('Low', 'carspot-rest-api'),
                'medium' => __('Medium', 'carspot-rest-api')
            ),
            'default' => 'medium',
            'required' => array('allow_upload_video_compress', '=', true),
        ),
        array(
            'id' => 'sb_ad_post_video_upload_progres',
            'type' => 'text',
            'title' => __('Message for video uploading', 'carspot-rest-api'),
            'default' => __('Please wait video uploading is in progress', 'carspot-rest-api'),
            'required' => array('allow_video_on_ad', '=', true),
        ),
        /* allow 3rd party api search. */
        array(
            'id' => 'allow_third_party_api_search',
            'type' => 'switch',
            'title' => __('Allow immatriculationapi', 'carspot-rest-api'),
            'subtitle' => __('Allow search from immatriculationapi.com', 'carspot-rest-api'),
            'default' => false,
        ),
        array(
            'id' => 'sb_api_outer_user_name',
            'type' => 'text',
            'title' => __('User name for API', 'carspot-rest-api'),
            'default' => __('tomberapic', 'carspot-rest-api'),
            'required' => array('allow_third_party_api_search', '=', true),
        ),
        array(
            'id' => 'allow_registration_text_field',
            'type' => 'switch',
            'title' => __('Allow Registration Field', 'carspot-rest-api'),
            'subtitle' => __('Show Registration Field Yes/No.', 'carspot-rest-api'),
            'default' => false,
            'required' => array('allow_third_party_api_search', '=', true),
        ),
        array(
            'id' => 'api_reg_field_placeholder',
            'type' => 'text',
            'title' => __('Placeholder for API field', 'carspot-rest-api'),
            'default' => __('AA-123-BB ou 1234AA75', 'carspot-rest-api'),
            'required' => array('allow_registration_text_field', '=', true),
        ),
    )
));

Redux::setSection($opt_name, array(
    'title' => __("Ad View Settings", "carspot-rest-api"),
    'id' => 'api_ad_view_settings',
    'desc' => '',
    'icon' => 'el el-home',
    'subsection' => true,
    'fields' => array(
        /* Extra */
        array(
            'id' => 'style_ad_720_1',
            'type' => 'textarea',
            'title' => esc_html__('Advertisement', 'carspot-rest-api'),
            'subtitle' => esc_html__('720 x 90', 'carspot-rest-api'),
            'desc' => esc_html__('Above the Ad description', 'carspot-rest-api'),
            'default' => '<img class="center-block" alt="" src="' . trailingslashit(get_template_directory_uri()) . 'images/banner-1.png"> ',
        ),
        array(
            'id' => 'style_ad_720_2',
            'type' => 'textarea',
            'title' => esc_html__('Advertisement', 'carspot-rest-api'),
            'subtitle' => esc_html__('720 x 90', 'carspot-rest-api'),
            'desc' => esc_html__('Below the Ad description', 'carspot-rest-api'),
            'default' => '<img class="center-block alt="" src="' . trailingslashit(get_template_directory_uri()) . 'images/banner-1.png"> ',
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __("Ad Search Settings", "carspot-rest-api"),
    'id' => 'api_ad_search_settings',
    'desc' => '',
    'icon' => 'el el-home',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'feature_on_search',
            'type' => 'switch',
            'title' => __('Featured Ads', 'carspot-rest-api'),
            'default' => true,
        ),
        array(
            'id' => 'sb_search_ads_title',
            'required' => array('feature_on_search', '=', true),
            'type' => 'text',
            'title' => __('Featured Ads Section Title', 'carspot-rest-api'),
            'default' => 'Featured Ads',
        ),
        array(
            'id' => 'search_related_posts_count',
            'required' => array('feature_on_search', '=', true),
            'type' => 'slider',
            'title' => __('Featured Posts', 'carspot-rest-api'),
            'subtitle' => __('On ad details page', 'carspot-rest-api'),
            'desc' => __('Select Number of featured posts', 'carspot-rest-api'),
            'default' => 5,
            'min' => 1,
            'step' => 1,
            'max' => 150,
            'display_value' => 'label'
        ),
        array(
            'id' => 'search_price_slider_min',
            'type' => 'text',
            'title' => __('Provide search page price slider min. value', 'phreelance_theme'),
            'subtitle' => __('This must be numeric without any comma or full stop.', 'phreelance_theme'),
            'validate' => 'numeric',
            'default' => '0',
        ),
        array(
            'id' => 'search_price_slider_max',
            'type' => 'text',
            'title' => __('Provide search page price slider max. value', 'phreelance_theme'),
            'subtitle' => __('This must be numeric without any comma or full stop.', 'phreelance_theme'),
            'validate' => 'numeric',
            'default' => '20000000',
        ),
    )
));


Redux::setSection($opt_name, array(
    'title' => __('Ad Rating Settings', 'carspot-rest-api'),
    'id' => 'sb_ad_rating_settings',
    'desc' => '',
    'icon' => 'el el-cogs',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'sb_ad_rating',
            'type' => 'switch',
            'title' => __('Rating on ad', 'carspot-rest-api'),
            'default' => false,
        ),
        array(
            'id' => 'sb_update_rating',
            'type' => 'switch',
            'title' => __('Allow update the rating', 'carspot-rest-api'),
            'required' => array('sb_ad_rating', '=', array(true)),
            'default' => false,
        ),
        array(
            'id' => 'sb_ad_rating_title',
            'type' => 'text',
            'title' => __('Rating section title', 'carspot-rest-api'),
            'required' => array('sb_ad_rating', '=', array(true)),
            'default' => 'Rating & Reviews',
        ),
        array(
            'id' => 'sb_rating_email_author',
            'type' => 'switch',
            'title' => __('Email to Author on rating', 'carspot-rest-api'),
            'required' => array('sb_ad_rating', '=', array(true)),
            'default' => false,
        ),
        array(
            'id' => 'sb_rating_reply_email',
            'type' => 'switch',
            'title' => __('Email to Author on reply', 'carspot-rest-api'),
            'required' => array('sb_ad_rating', '=', array(true)),
            'default' => false,
        ),
        array(
            'id' => 'sb_rating_max',
            'type' => 'spinner',
            'title' => __('Rating show at most', 'carspot-rest-api'),
            'required' => array('sb_ad_rating', '=', array(true)),
            'default' => '5',
            'min' => '1',
            'step' => '1',
            'max' => '50',
        ),
    )
));

/* Only show if woocommerce plugin activated */
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    Redux::setSection($opt_name, array(
        'title' => __("Woo Products", "carspot-rest-api"),
        'id' => 'api_woo_products_settings',
        'desc' => '',
        'icon' => 'el el-list-alt',
        'fields' => array(
            array(
                'id' => 'api_woo_products_multi',
                'type' => 'select',
                'data' => 'posts',
                'args' => array(
                    'post_type' => 'product',
                    'posts_per_page' => -1,
                ),
                'multi' => true,
                'sortable' => true,
                'title' => __('Select Products', 'carspot-rest-api'),
            ),
            array(
                'id' => 'opt-info-select',
                'type' => 'info',
                'desc' => __('Select Payment Packages', 'carspot-rest-api'),
            ),
            array(
                'required' => array('api-is-buy-android-app', '=', true),
                'id' => 'api-payment-packages',
                'type' => 'select',
                'multi' => true,
                'sortable' => true,
                'title' => __('Payment Methods For Android App', 'carspot-rest-api'),
                'desc' => __('Select the payment methods you want to add.', 'carspot-rest-api'),
                'options' => carspotAPI_payment_types(),
                'default' => array('stripe')
            ),
            array(
                'required' => array('api-is-buy-ios-app', '=', true),
                'id' => 'api-payment-packages-ios',
                'type' => 'select',
                'multi' => true,
                'sortable' => true,
                'title' => __('Payment Methods IOS App', 'carspot-rest-api'),
                'desc' => __('Note ios only uses InApp Purchase', 'carspot-rest-api'),
                'options' => carspotAPI_payment_types('', 'ios'),
                'default' => array('app_inapp')
            ),
        )
    ));
}


Redux::setSection($opt_name, array(
    'title' => __('Users', "carspot-rest-api"),
    'id' => 'api_users_screen',
    'desc' => '',
    'icon' => 'el el-user',
    'fields' => array(
        array(
            'id' => 'sb_phone_verification',
            'type' => 'switch',
            'title' => __('Phone verfication', 'carspot-rest-api'),
            'default' => false,
            'desc' => __('If phone verification is on then system put verified batch to ad details on number so other can see this number is verified.', 'carspot-rest-api'),
        ),
        array(
            'id' => 'sb_resend_code',
            'type' => 'text',
            'title' => __('Resend security code', 'carspot-rest-api'),
            'subtitle' => __('In seconds', 'carspot-rest-api'),
            'desc' => __('Only integer value without spaces, 30 means 30-seconds', 'carspot-rest-api'),
            'required' => array('sb_phone_verification', '=', array('1')),
            'default' => 30,
        ),
        array(
            'id' => 'sb_change_ph',
            'type' => 'switch',
            'title' => __('Change phone number while ad posting.', 'carspot-rest-api'),
            'desc' => __('If off then only user profile number will be display and can not be changeable.', 'carspot-rest-api'),
            'default' => true,
        ),
        array(
            'id' => 'sb_new_user_email_to_user',
            'type' => 'switch',
            'title' => __('Welcome Email to User', 'carspot-rest-api'),
            'default' => true
        ),
        array(
            'id' => 'sb_new_user_email_verification',
            'type' => 'switch',
            'title' => __('New user email verification', 'carspot-rest-api'),
            'default' => false,
            'desc' => __('If verfication on then please update your new user email template by verification link.', 'carspot-rest-api'),
        ),
        array(
            'id' => 'sb_new_user_register_policy',
            'type' => 'select',
            'data' => 'pages',
            'multi' => false,
            'sortable' => false,
            'title' => __('Select Page', 'carspot-rest-api'),
            'subtitle' => __('Terms and Conditions', 'carspot-rest-api'),
            'desc' => __('Specially for General Data Protection Regulation (GDPR)', 'carspot-rest-api'),
        ),
        array(
            'id' => 'sb_new_user_register_checkbox_text',
            'type' => 'text',
            'title' => __('Term and Condition Text', 'carspot-rest-api'),
            'default' => '',
            'desc' => __('Terms and Condition text next to checkbox. Leave empty if you want to show default text', 'carspot-rest-api'),
        ),
        array(
            'id' => 'sb_new_user_delete_option',
            'type' => 'switch',
            'title' => __('Show Delete button', 'carspot-rest-api'),
            'default' => false,
            'desc' => __('Show delete button on user profile. Due to General Data Protection Regulation (GDPR) policy. Note: This will delete the entire data from the database and can not be recovered.', 'carspot-rest-api'),
        ),
        array(
            'required' => array('sb_new_user_delete_option', '=', true),
            'id' => 'sb_new_user_delete_option_text',
            'type' => 'text',
            'title' => __('Delete Popup Text', 'carspot-rest-api'),
            'default' => 'Are you sure you want to delete the account.',
            'desc' => __('Popup text after delete link clicked.', 'carspot-rest-api'),
        ),
        array(
            'id' => 'sb_user_allow_block',
            'type' => 'switch',
            'title' => __('Block User', 'carspot-rest-api'),
            'default' => false,
            'desc' => __('Allow users to block anyone and stop seeing his ads.', 'carspot-rest-api'),
        ),
        array(
            'id' => 'sb_user_dp',
            'type' => 'media',
            'url' => true,
            'title' => __('Default user picture', 'carspot-rest-api'),
            'compiler' => 'true',
            'subtitle' => __('Dimensions: 200 x 200', 'carspot-rest-api'),
            'default' => array('url' => CARSPOT_API_PLUGIN_URL . "images/user.jpg"),
        ),
        array(
            'id' => 'sb_user_guest_dp',
            'type' => 'media',
            'url' => true,
            'title' => __('Default guest picture', 'carspot-rest-api'),
            'compiler' => 'true',
            'subtitle' => __('Dimensions: 200 x 200', 'carspot-rest-api'),
            'default' => array('url' => CARSPOT_API_PLUGIN_URL . "images/user.jpg"),
        ),
        array(
            'id' => 'sb_user_profile_tab1',
            'type' => 'text',
            'title' => __('User profile tab one text', 'carspot-rest-api'),
            'default' => __('Inventory', 'carspot-rest-api'),
        ),
        array(
            'id' => 'sb_user_profile_tab2',
            'type' => 'text',
            'title' => __('User profile tab two text', 'carspot-rest-api'),
            'default' => __('Review', 'carspot-rest-api'),
        ),
        array(
            'id' => 'sb_user_profile_tab3',
            'type' => 'text',
            'title' => __('User profile tab three text', 'carspot-rest-api'),
            'default' => __('Contact', 'carspot-rest-api'),
        ),
        array(
            'id' => 'api_individual_user_addres',
            'type' => 'switch',
            'title' => __('Show address field in Profile', 'carspot-rest-api'),
            'default' => false,
            'desc' => __('Show address field in profile for individual user.', 'carspot-rest-api'),
        ),
    )
));
Redux::setSection($opt_name, array(
    'title' => __('Admob Settings', "carspot-rest-api"),
    'id' => 'api_admob_screen',
    'desc' => '',
    'icon' => 'el el-bullhorn',
    'fields' => array(
        array(
            'id' => 'sb_admob_switch',
            'type' => 'switch',
            'title' => __('Want to turn on AdMob banners', 'carspot-rest-api'),
            'default' => false,
            'on' => __('YES', 'carspot-rest-api'),
            'off' => __('NO', 'carspot-rest-api'),
            'desc' => __('When you turn this on you have to provide more detail', 'carspot-rest-api'),
        ),
        array(
            'id' => 'sb_admob_banner_position',
            'type' => 'button_set',
            'title' => esc_html__('Select Banner Postion', 'carspot'),
            'options' => array(
                'top' => esc_html__('Top', 'carspot'),
                'bottom' => esc_html__('Bottom', 'carspot'),
            ),
            'required' => array('sb_admob_switch', '=', true),
            'default' => 'top'
        ),
        array(
            'id' => 'sb_admob_banner_id',
            'type' => 'text',
            'title' => __('Banner ad ID', 'carspot-rest-api'),
            'default' => '',
            'required' => array('sb_admob_switch', '=', true),
            'desc' => __('Please provide Banner id', 'carspot-rest-api'),
        ),
        array(
            'id' => 'sb_admob_interstitial_switch',
            'type' => 'switch',
            'title' => __('Want to turn on interstitial ads', 'carspot-rest-api'),
            'default' => false,
            'on' => __('YES', 'carspot-rest-api'),
            'off' => __('NO', 'carspot-rest-api'),
            'desc' => __('When you turn this on you have to provide more detail', 'carspot-rest-api'),
        ),
        array(
            'id' => 'sb_admob_interstitial_interval',
            'type' => 'text',
            'title' => esc_html__('Interstitial ad interval', 'carspot'),
            'required' => array('sb_admob_interstitial_switch', '=', true),
            'desc' => __('Please provide interstitial ads interval in miliseconds eg. 1000 milliseconds  = 1 second', 'carspot-rest-api'),
        ),
        array(
            'id' => 'sb_admob_interstitial_id',
            'type' => 'text',
            'title' => __('Interstitial ad ID', 'carspot-rest-api'),
            'default' => '',
            'required' => array('sb_admob_interstitial_switch', '=', true),
            'desc' => __('Please provide Interstitial ad id', 'carspot-rest-api'),
        ),
    )
));
/* ------------------Email Templates Settings ----------------------- */
Redux::setSection($opt_name, array(
    'title' => __('Email Templates', 'carspot-rest-api'),
    'id' => 'sb_email_templates',
    'desc' => '',
    'icon' => 'el el-pencil',
    'fields' => array()
));

Redux::setSection($opt_name, array(
    'title' => __('App Contact Form', 'carspot-rest-api'),
    'id' => 'sb_email_templates2',
    'desc' => '',
    'icon' => 'el el-envelope',
    'subsection' => true,
    'fields' => array(
        array(
            'id' => 'carspot_app_contact_form_subject',
            'type' => 'text',
            'title' => __('Contact App Subject', 'carspot-rest-api'),
            'desc' => __('%site_name% , %app_name% will be translated accordingly.', 'carspot-rest-api'),
            'default' => __('A New Contact Email Reveived - ', 'carspot-rest-api') . '%app_name%',
        ),
        array(
            'id' => 'carspot_app_contact_form_from',
            'type' => 'text',
            'title' => __('Contact App FROM', 'carspot-rest-api'),
            'desc' => __('NAME valid@email.com is compulsory as we gave in default.', 'carspot-rest-api'),
            'default' => '' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        ),
        array(
            'id' => 'carspot_app_contact_form_to',
            'type' => 'text',
            'title' => __('Contact Email Receive On', 'carspot-rest-api'),
            'desc' => __('Send the contact email on custom select email. If no email is enter then it will send to site admin.', 'carspot-rest-api'),
        ),
        array(
            'id' => 'carspot_app_contact_form_content',
            'type' => 'editor',
            'title' => __('Contact App Email', 'carspot-rest-api'),
            'desc' => __('%site_name% , %app_name%, %sender_name%, %sender_email%, %sender_subject%, %sender_desc%  will be translated accordingly.', 'carspot-rest-api'),
            'default' => '<table class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f6f6f6; width: 100%;" border="0" cellspacing="0" cellpadding="0"><tbody><tr><td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td><td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; margin: 0 auto !important;"><div class="content" style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;"><table class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #fff; border-radius: 3px; width: 100%;"><tbody><tr><td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;"><table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0"><tbody><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="alert" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #000; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #fff; margin: 0; padding: 20px;" align="center" valign="top" bgcolor="#fff">Carspot - Classified WoodPress Theme/App</td></tr><tr><td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"><p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><span style="font-family: sans-serif; font-weight: normal;">Hello </span><span style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;"><b>Admin,</b></span></p><p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">You\'ve received a new contact email from %app_name% contact form.</p><p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Subject: %sender_subject%</p> Sender Name: %sender_name%Sender Email: %sender_email%<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Contact Message:</p> %sender_desc%<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Thanks,</strong></p></td></tr></tbody></table></td></tr></tbody></table><div class="footer" style="clear: both; padding-top: 10px; text-align: center; width: 100%;"><table style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" border="0" cellspacing="0" cellpadding="0"><tbody><tr><td class="content-block powered-by" style="font-family: sans-serif; font-size: 12px; vertical-align: top; color: #999999; text-align: center;"><a style="color: #999999; text-decoration: underline; font-size: 12px; text-align: center;" href="https://themeforest.net/user/scriptsbundle">Scripts Bundle</a>.</td></tr></tbody></table></div></div></td><td style="font-family: sans-serif; font-size: 14px; vertical-align: top;"></td></tr></tbody></table>',
        ),
    )
));


/*
 * wpml
 */
if (function_exists('icl_object_id')) {
    Redux::setSection($opt_name, array(
        'title' => esc_html__("WPML Settings", "carspot-rest-api"),
        'id' => 'app_wpml_settings',
        'desc' => '',
        'icon' => 'el el-book',
        'fields' => array()
    ));

    Redux::setSection($opt_name, array(
        'title' => esc_html__('WPML', "carspot-rest-api"),
        'id' => 'app_wpml',
        'desc' => '',
        'subsection' => true,
        'fields' => array(
            array(
                'id' => 'enable_wpml_app',
                'type' => 'switch',
                'title' => esc_html__('Enable WPML', "carspot-rest-api"),
                'desc' => esc_html__('Note: Before enable this switch WPML plugin must be active.', 'carspot-rest-api'),
                'default' => false,
            ),
            array(
                'id' => 'sb_language_opt',
                'type' => 'switch',
                'title' => esc_html__('Display Languages in Menu', "carspot-rest-api"),
                'desc' => esc_html__('Note: Before enable this switch WPML plugin must be active.', 'carspot-rest-api'),
                'default' => false,
                'required' => array('enable_wpml_app', '=', true),
            ),
            array(
                'id' => 'sb_wpml_select_lang_title',
                'type' => 'text',
                'title' => esc_html__('Select Your Language Title', 'carspot-rest-api'),
                'desc' => esc_html__('Set the title for Select Your Language', 'carspot-rest-api'),
                'default' => esc_html__('Select Your Language', 'carspot-rest-api'),
                'required' => array('enable_wpml_app', '=', true),
            ),
            array(
                'id' => 'all_wpml_app_langs',
                'type' => 'select',
                'multi' => true,
                'title' => esc_html__('Languages', "carspot-rest-api"),
                'options' => cs_app_languages(),
                'subtitle' => '',
                'default' => false,
                'required' => array('enable_wpml_app', '=', true),
            ),
            array(
                'id' => 'duplicate_wpml_app_posts',
                'type' => 'switch',
                'title' => esc_html__('Duplicate', "carspot-rest-api"),
                'subtitle' => esc_html__('Enable this option to duplicate post in all other languages after successful publish.', 'carspot-rest-api'),
                'desc' => esc_html__('Note: Disable means the posts publish only in the current language.', 'carspot-rest-api'),
                'default' => false,
                'required' => array('enable_wpml_app', '=', true),
            ),
            array(
                'id' => 'display_all_wpml_app_posts',
                'type' => 'switch',
                'title' => esc_html__('Display Posts)', "carspot-rest-api"),
                'subtitle' => esc_html__('Enable this option to display all other languages post in current language.', 'carspot-rest-api'),
                'desc' => esc_html__('Note: Disable means to display only current language post.', 'carspot-rest-api'),
                'default' => false,
                'required' => array('enable_wpml_app', '=', true),
            ),
            array(
                'id' => 'wpml_app_logo',
                'type' => 'media',
                'url' => true,
                'title' => esc_html__('WPML logo', 'carspot-rest-api'),
                'compiler' => 'true',
                'desc' => esc_html__('Upload WPML logo for your App.', 'carspot-rest-api'),
                'default' => array('url' => trailingslashit(get_template_directory_uri()) . 'images/logo.png'),
                'required' => array('enable_wpml_app', '=', true),
            ),
        )
    ));
}


function carspotAPI_hide_reduxSlides_upload_button()
{
    echo '<style>.carspot-hide-upload .redux-container-slides .redux_slides_add_remove {display: none !important; }</style>';
}

add_action('admin_head', 'carspotAPI_hide_reduxSlides_upload_button');
