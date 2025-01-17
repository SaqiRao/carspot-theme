<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.3 for parent theme CarSpot for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */
/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
require_once get_template_directory() . '/tgm/class-tgm-plugin-activation.php';
add_action('tgmpa_register', 'carspot_themes_register_required_plugins');

/**
 * Register the required plugins for this theme.
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */

function carspot_check_if_redux_framework()
{
    if (!in_array('redux-framework/redux-framework.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        add_action('admin_notices', 'carspot_redux_framework_install_notice');
    }
}

if (!function_exists('carspot_redux_framework_install_notice')) {
    function carspot_redux_framework_install_notice()
    {
        ?>
        <div class="error notice">
            <p>
            <h4 style="color:red"><?php echo esc_html__('Note: Please Intall and activate Redux-Framework Plugin before update Carspot-Framework 2.2.3.', 'carspot'); ?></h4></p>
        </div>
        <?php
    }
}

function carspot_themes_register_required_plugins()
{
    $elementor_framework = array();
    $elementor_plugin = array();
    if (!is_plugin_active('js_composer/js_composer.php')) {
        $elementor_plugin = array(
            'name' => esc_html__('Elementor', 'carspot'),
             // The plugin name.
            'slug' => 'elementor', 
            // The plugin slug (typically the folder name).
            'source' => '', 
            // The plugin source.
            'required' => true, 
            // If false, the plugin is only 'recommended' instead of required.
            'version' => '',
             // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation' => false, 
            // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, 
            // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url' => esc_url('https://downloads.wordpress.org/plugin/elementor.3.14.1.zip'),
             // If set, overrides default API URL and points to an external URL.
            'is_callable' => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
        );
        $elementor_framework = array(
            'name' => esc_html__('Carspot Elementor Widgets', 'carspot'), 
            // The plugin name.
            'slug' => 'carspot-elementor', 
            // The plugin slug (typically the folder name).
            'source' => get_template_directory() . '/required-plugins/carspot-elementor.zip', 
            // The plugin source.
            /* 'source'             => $plugin_link, // The plugin source. */
            'required' => true,
             // If false, the plugin is only 'recommended' instead of required.
            'version' => '1.0.9', 
            // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation' => false,
             // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false,
             // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url' => '', 
            // If set, overrides default API URL and points to an external URL.
            //'is_callable' => carspot_check_if_elementor_framework(), // If set, this callable will be be checked for availability to determine if a plugin is active.
        );
    }
    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    // check if purchase code is there
    if (get_option('_sb_purchase_code') == "") {
        return;
    }
    $plugins = array(
        // This is an example of how to include a plugin bundled with a theme.
        array(
            'name' => esc_html__('WP Bakery Visual Composer', 'carspot'),
             // The plugin name.
            'slug' => 'js_composer', 
            // The plugin slug (typically the folder name).
            'source' => get_template_directory() . '/required-plugins/js_composer.zip',
             // The plugin source.
            'required' => true, 
            // If false, the plugin is only 'recommended' instead of required.
            'version' => '', 
            // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation' => false, 
            // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false,
             // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url' => '', 
            // If set, overrides default API URL and points to an external URL.
            'is_callable' => '', 
            // If set, this callable will be be checked for availability to determine if a plugin is active.
        ),
        $elementor_framework,
        $elementor_plugin,
        array(
            'name' => esc_html__('Carspot Framework', 'carspot'), 
            // The plugin name.
            'slug' => 'carspot_framework', 
            // The plugin slug (typically the folder name).
            'source' => get_template_directory() . '/required-plugins/carspot_framework.zip',
             // The plugin source.
            /* 'source' => $plugin_link, // The plugin source. */
            'required' => true,
             // If false, the plugin is only 'recommended' instead of required.
            'version' => '2.3.0',
             // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation' => false, 
            // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, 
            // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url' => '', 
            // If set, overrides default API URL and points to an external URL.
            //'is_callable' => carspot_check_if_redux_framework(), // If set, this callable will be be checked for availability to determine if a plugin is active.
        ),
        array(
            'name' => esc_html__('Woocommerce', 'carspot'), 
            // The plugin name.
            'slug' => 'woocommerce', 
            // The plugin slug (typically the folder name).
            'source' => '', 
            // The plugin source.
            'required' => true, 
            // If false, the plugin is only 'recommended' instead of required.
            'version' => '7.1.0', 
            // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation' => false, 
            // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.   
            'external_url' => esc_url('https://downloads.wordpress.org/plugin/woocommerce.8.2.1.zip'),
             // If set, overrides default API URL and points to an external URL.
            'is_callable' => '', 
            // If set, this callable will be be checked for availability to determine if a plugin is active.
        ),
        array(
            'name' => esc_html__('Contact Form 7', 'carspot'),
             // The plugin name.
            'slug' => 'contact-form-7', 
            // The plugin slug (typically the folder name).
            'source' => '', 
            // The plugin source.
            'required' => true, 
            // If false, the plugin is only 'recommended' instead of required.
            'version' => '',
             // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation' => false, 
            // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false,
             // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.    
            'external_url' => esc_url('https://downloads.wordpress.org/plugin/contact-form-7.5.8.1.zip'),
             // If set, overrides default API URL and points to an external URL.
            'is_callable' => '', 
            // If set, this callable will be be checked for availability to determine if a plugin is active.
        ), 
        array(
            'name' => esc_html__('Image Watermark WP', 'carspot'), 
            // The plugin name.
            'slug' => 'image-watermark-wp', 
            // The plugin slug (typically the folder name).
            'source' => '', 
            // The plugin source.
            'required' => true, 
            // If false, the plugin is only 'recommended' instead of required.
            'version' => '', 
            // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation' => false,
             // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, 
            // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.    
            'external_url' => esc_url('https://downloads.wordpress.org/plugin/image-watermark.1.7.3.zip'), // If set, overrides default API URL and points to an external URL.
            'is_callable' => '', 
            // If set, this callable will be be checked for availability to determine if a plugin is active.
        ),
        array(
            'name' => esc_html__('AddToAny Share Buttons', 'carspot'), 
            // The plugin name.
            'slug' => 'add-to-any', 
            // The plugin slug (typically the folder name).
            'source' => '', 
            // The plugin source.
            'required' => true, 
            // If false, the plugin is only 'recommended' instead of required.
            'version' => '', 
            // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation' => false, 
            // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, 
            // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.    
            'external_url' => esc_url('https://downloads.wordpress.org/plugin/add-to-any.1.8.8.zip'),
             // If set, overrides default API  URL and points to an external URL.
            'is_callable' => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
        ),
    );

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     */
    $config = array(
        'id' => 'carspot', 
        // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '', 
        // Default absolute path to bundled plugins.
        'menu' => 'tgmpa-install-plugins', 
        // Menu slug.
        'has_notices' => true, 
        // Show admin notices or not.
        'dismissable' => false, 
        // If false, a user cannot dismiss the nag message.
        'dismiss_msg' => '', 
        // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,
         // Automatically activate plugins after installation or not.
        'message' => '', 
        // Message to output right before the plugins table.
    );

    tgmpa($plugins, $config);
}
