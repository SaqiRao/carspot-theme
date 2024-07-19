<?php
namespace ElementorCarspot;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {

    /**
     * Instance
     *
     * @since 1.2.0
     * @access private
     * @static
     *
     * @var Plugin The single instance of the class.
     */
    private static $_instance = null;

    /**
     * Instance
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /* call constructor */

    public function __construct() {
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
        add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
        /* include custom functions */
        require_once(__DIR__ . '/elementor-fucntions.php');
        /* include render html file */
        require_once(__DIR__ . '/shortcodes-html.php');
    }

    /**
     * Include Widgets files
     *
     */
    
    private function include_widgets_files() {
        require_once(__DIR__ . '/widgets/about-us.php');
        require_once(__DIR__ . '/widgets/about-us-fancy.php');
        require_once(__DIR__ . '/widgets/about-us-simple.php');
        require_once(__DIR__ . '/widgets/ad_post.php');
        require_once(__DIR__ . '/widgets/ads.php');
        require_once(__DIR__ . '/widgets/ad_by_location.php');
        require_once(__DIR__ . '/widgets/ad_by_make.php');
        require_once(__DIR__ . '/widgets/ads_google_map.php');
        require_once(__DIR__ . '/widgets/ads_slider.php');
        //require_once(__DIR__ . '/widgets/ads_with_tabs.php');
        require_once(__DIR__ . '/widgets/advertisement_72-_90.php');
        require_once(__DIR__ . '/widgets/apps-simple.php');
        require_once(__DIR__ . '/widgets/apps-classic.php');
        require_once(__DIR__ . '/widgets/blog.php');
        require_once(__DIR__ . '/widgets/buy_salse_hero.php');
        require_once(__DIR__ . '/widgets/buy_sell.php');
        require_once(__DIR__ . '/widgets/call_to_action.php');
        require_once(__DIR__ . '/widgets/call_to_action_two.php');
        require_once(__DIR__ . '/widgets/call_to_action_three.php');
        require_once(__DIR__ . '/widgets/car_inspection.php');
        require_once(__DIR__ . '/widgets/car_inspection_two.php');
        //this shortcode make by elementor default functionality
        //require_once(__DIR__ . '/widgets/car_images.php');
        require_once(__DIR__ . '/widgets/cat_classic.php');
        require_once(__DIR__ . '/widgets/cats_fancy.php');
        require_once(__DIR__ . '/widgets/clients_slider.php');
        require_once(__DIR__ . '/widgets/compare_posts.php');
        require_once(__DIR__ . '/widgets/contact_us.php');
        require_once(__DIR__ . '/widgets/expert_reviews.php');
        require_once(__DIR__ . '/widgets/faq.php');
        require_once(__DIR__ . '/widgets/fun_facts.php');
        require_once(__DIR__ . '/widgets/our_team.php');
        require_once(__DIR__ . '/widgets/packages.php');
        require_once(__DIR__ . '/widgets/packages_style_two.php');
        //require_once(__DIR__ . '/widgets/popular_cats.php');
        require_once(__DIR__ . '/widgets/process_cycle.php');
        require_once(__DIR__ . '/widgets/profile.php');
        require_once(__DIR__ . '/widgets/quote.php');
        require_once(__DIR__ . '/widgets/reviews.php');
        require_once(__DIR__ . '/widgets/search_bar_minimal.php');
        //require_once(__DIR__ . '/widgets/search_bar_simple.php');
        require_once(__DIR__ . '/widgets/search_simple.php');
        require_once(__DIR__ . '/widgets/search_creative.php');
        require_once(__DIR__ . '/widgets/search_modern.php');
        require_once(__DIR__ . '/widgets/search_fancy.php');
        require_once(__DIR__ . '/widgets/search_tab_advance.php');
        require_once(__DIR__ . '/widgets/search_tab_classified.php');
        require_once(__DIR__ . '/widgets/search_make_models.php');
        require_once(__DIR__ . '/widgets/search_side_form.php');
        require_once(__DIR__ . '/widgets/search_side_form_two.php');
        require_once(__DIR__ . '/widgets/search_modern_two.php');
        require_once(__DIR__ . '/widgets/services.php');
        require_once(__DIR__ . '/widgets/services_two.php');
        require_once(__DIR__ . '/widgets/services_three.php');
        require_once(__DIR__ . '/widgets/services_modern.php');
        require_once(__DIR__ . '/widgets/services_simple.php');
        require_once(__DIR__ . '/widgets/services_classic.php');
        require_once(__DIR__ . '/widgets/services_with_facts.php');
        require_once(__DIR__ . '/widgets/shop_products.php');
        require_once(__DIR__ . '/widgets/shop_slider.php');
        require_once(__DIR__ . '/widgets/shop_tabs.php');
        require_once(__DIR__ . '/widgets/signin.php');
        require_once(__DIR__ . '/widgets/signup.php');
        require_once(__DIR__ . '/widgets/testimonial.php');
        require_once(__DIR__ . '/widgets/testimonial_two.php');
        require_once(__DIR__ . '/widgets/textblock.php');
        require_once(__DIR__ . '/widgets/why_us.php');
        require_once(__DIR__ . '/widgets/inspection.php');
    }

    //Ad Shortcode Category
    public function add_elementor_widget_categories($category_manager) {
        $category_manager->add_category(
                'cstheme',
                [
                    'title' => __('Carspot Widgets', 'cs-elementor'),
                    'icon' => 'fa fa-plug',
                ]
        );
    }

    /**
     * Register Widgets
     *
     * Register new Elementor widgets.
     *
     * @since 1.2.0
     * @access public
     */
    public function register_widgets() {
        // Its is now safe to include Widgets files
        $this->include_widgets_files();
        /* Register Widgets */
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\About_Us());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\About_Us_Fancy());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\About_Us_Simple());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Ad_Post());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Ads());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Ad_By_Location());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Ad_By_Make_New());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Ads_Google_Map());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Ads_Slider());
        //\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Ads_With_Tabs());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Advertisement_720_90());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Apps_Simple());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Apps_Classic());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Blog());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Buy_Sale_Hero());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Buy_Sell());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Call_To_Action());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Call_To_Action_Two());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Call_To_Action_Three());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Car_Inspection());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Car_Inspection_Two());
        //\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Car_Images());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Cat_Classic());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Cat_Fancy());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Clients_Slider());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Compare_Posts());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\ContactUs());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Expert_Reviews());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\FAQ());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Fun_Fact());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Our_Team());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Packages_Style_Two());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Packages());
        //\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Popular_Cats());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Process_Cycle());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Profile());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Quote());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Reviews());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Search_Bar_Minimal());
        //\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Search_Bar_Simple());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Search_Simple());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Search_Creative());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Search_Modern());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Search_Fancy());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Search_Tab_Advance());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Search_Tab_Classified());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Search_With_Make_Models());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Search_Side_Form());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Search_Side_Form_Two());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Search_Modern_Two());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Services());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Services_Two());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Services_Three());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Services_Modern());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Services_Simple());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Services_Classic());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Services_With_Facts());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Shop_Products());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Shop_Slider());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Shop_Tabs());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Sign_In());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Sign_Up());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Testi_Monial());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Testi_Monial_Two());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Text_Block());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Why_Us());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Inspection());
    }

}

Plugin::instance();