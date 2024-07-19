<?php 


function add_custom_section_child($sections) {
    $sections[] = array(
        'title' => __('Category Default Section', 'your-theme-text-domain'),
        'icon' => 'el el-website',
        'fields' => array(
            array(
                'id' => 'sb_default_dynamic_template_on',
                'type' => 'switch',
                'title' => __('Select Dynamic Template', 'adforest'),
                'default' => false,
                'desc' => __('Select a default category to which you assign a template.', 'adforest'),
            ),
            array(
                'required' => array('sb_default_dynamic_template_on', '=', true),
                'id' => 'sb_default_dynamic_template',
                'type' => 'select',
                'data' => 'terms',
                'args' => array('taxonomies' => array('sb_dynamic_form_templates'), 'hide_empty' => false,),
                'multi' => false,
                'sortable' => false,
                'title' => __('Select Template', 'adforest'),
                'desc' => __('Select a default category to which you assign a template.', 'adforest'),
                'default' => array(),
            ),
        ),
    );

    return $sections;
}

 require_once get_stylesheet_directory()  . '\inc\theme_shortcodes\shortcodes\ad_post.php'; 
 //require_once get_stylesheet_directory()  . '\template-parts\layouts\ad_style\ad-detail.php'; 

add_filter('redux/options/carspot_theme/sections', 'add_custom_section_child');

function get_template_fields() {
    global $carspot_theme;
    
        $html = '';
        $template_id = $carspot_theme['sb_default_dynamic_template'];
        $html .= carspot_get_dynamic_form($template_id);
        return $html;
}




/* Custom Model Widgets Start*/
add_action('widgets_init', function () {
    register_widget('carspot_search_template_modle_feild');
});
if (!class_exists('carspot_search_template_modle_feild')) {

    class carspot_search_template_modle_feild extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_search_template_modle_feild',
                'description' => esc_html__('Only for search and single ad sidebar.', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Custom Model Search', 'carspot'), $widget_ops);
        }


        public function widget($args, $instance)
        {
            global $carspot_theme;
            extract($args);
            $titles = apply_filters('widget_title', $instance['title']);
            $expand = "";
            if (isset($_GET['ad_model']) && $_GET['ad_model'] != "") {
                $expand = "in";
                $title = $_GET['ad_model'];
            }

            ?>
            <div class="panel panel-default" id="red-title">
                <!-- Heading -->
                <div class="panel-heading" role="tab" id="headingFivezz">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseFive1" aria-expanded="true" aria-controls="collapseFive1">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            <?php echo $titles; ?>
                        </a>
                    </h4>
                </div>
                <form method="get"
                      action="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>">
                    <!-- Content -->
                    <div id="collapseFive1" class="panel-collapse collapse <?php echo esc_attr($expand); ?>"
                         role="tabpanel" aria-labelledby="headingFive">
                        <div class="panel-body">
                            <div class="search-widget">
                                <input id="autocomplete-dynamic" autocomplete="off" class="form-control"
                                       placeholder="<?php echo esc_html__('search', 'carspot'); ?>" type="text"
                                       name="ad_model" value="">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <?php
                    echo carspot_search_params('ad_model');
                    ?>
                </form>
            </div>

            <?php
        }

        /**
         * Back-end widget form.
         *
         * @param array $instance Previously saved values from database.
         * @see WP_Widget::form()
         *
         */
        public function form($instance)
        {

            $title = (isset($instance['title'])) ? $instance['title'] : esc_html__('Search By:', 'carspot');
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title:', 'carspot'); ?>
                    <small><?php echo esc_html__('You can leave it empty as well', 'carspot'); ?></small>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                       value="<?php echo esc_attr($title); ?>">
            <p><?php echo esc_html__('You can show/hide the specific type from categories custom fields where you created it.', 'carspot'); ?> </p>
            </p>

            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         * @see WP_Widget::update()
         *
         */
        public function update($new_instance, $old_instance)
        {
            $instance = $old_instance;
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            return $instance;
        }

    }

}

/* Custom Model Widgets Ends*/


/* Custom Weight Widgets Start*/
add_action('widgets_init', function () {
    register_widget('carspot_search_template_weight_feild');
});
if (!class_exists('carspot_search_template_weight_feild')) {

    class carspot_search_template_weight_feild extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_search_template_weight_feild',
                'description' => esc_html__('Only for search and single ad sidebar.', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Custom Weight Search', 'carspot'), $widget_ops);
        }


        public function widget($args, $instance)
        {
            global $carspot_theme;
            extract($args);
            $titles = apply_filters('widget_title', $instance['title']);
            $expand = "";
            if (isset($_GET['ad_weight']) && $_GET['ad_weight'] != "") {
                $expand = "in";
                $title = $_GET['ad_weight'];
            }

            ?>
            <div class="panel panel-default" id="red-title">
                <!-- Heading -->
                <div class="panel-heading" role="tab" id="headingFivezz">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseFive2" aria-expanded="true" aria-controls="collapseFive2">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            <?php echo $titles; ?>
                        </a>
                    </h4>
                </div>
                <form method="get"
                      action="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>">
                    <!-- Content -->
                    <div id="collapseFive2" class="panel-collapse collapse <?php echo esc_attr($expand); ?>"
                         role="tabpanel" aria-labelledby="headingFive">
                        <div class="panel-body">
                            <div class="search-widget">
                                <input id="autocomplete-dynamic" autocomplete="off" class="form-control"
                                       placeholder="<?php echo esc_html__('search', 'carspot'); ?>" type="text"
                                       name="ad_weight" value="">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <?php
                    echo carspot_search_params('ad_weight');
                    ?>
                </form>
            </div>

            <?php
        }

        /**
         * Back-end widget form.
         *
         * @param array $instance Previously saved values from database.
         * @see WP_Widget::form()
         *
         */
        public function form($instance)
        {

            $title = (isset($instance['title'])) ? $instance['title'] : esc_html__('Search By:', 'carspot');
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title:', 'carspot'); ?>
                    <small><?php echo esc_html__('You can leave it empty as well', 'carspot'); ?></small>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                       value="<?php echo esc_attr($title); ?>">
            <p><?php echo esc_html__('You can show/hide the specific type from categories custom fields where you created it.', 'carspot'); ?> </p>
            </p>

            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         * @see WP_Widget::update()
         *
         */
        public function update($new_instance, $old_instance)
        {
            $instance = $old_instance;
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            return $instance;
        }

    }

}

/* Custom Weight Widgets Ends*/







/* Custom Brands Widgets Start*/
add_action('widgets_init', function () {
    register_widget('carspot_search_template_brands_feild');
});
if (!class_exists('carspot_search_template_brands_feild')) {

    class carspot_search_template_brands_feild extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_search_template_brands_feild',
                'description' => esc_html__('Only for search and single ad sidebar.', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Custom Brands Search', 'carspot'), $widget_ops);
        }


        public function widget($args, $instance)
        {
            global $carspot_theme;
            extract($args);
            $titles = apply_filters('widget_title', $instance['title']);
            $expand = "";
            if (isset($_GET['ad_brand']) && $_GET['ad_brand'] != "") {
                $expand = "in";
                $title = $_GET['ad_brand'];
            }

            ?>
            <div class="panel panel-default" id="red-title">
                <!-- Heading -->
                <div class="panel-heading" role="tab" id="headingFivezz">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseFive3" aria-expanded="true" aria-controls="collapseFive3">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            <?php echo $titles; ?>
                        </a>
                    </h4>
                </div>
                <form method="get"
                      action="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>">
                    <!-- Content -->
                    <div id="collapseFive3" class="panel-collapse collapse <?php echo esc_attr($expand); ?>"
                         role="tabpanel" aria-labelledby="headingFive">
                        <div class="panel-body">
                            <div class="search-widget">
                                <input id="autocomplete-dynamic" autocomplete="off" class="form-control"
                                       placeholder="<?php echo esc_html__('search', 'carspot'); ?>" type="text"
                                       name="ad_brand" value="">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <?php
                    echo carspot_search_params('ad_brand');
                    ?>
                </form>
            </div>

            <?php
        }

        /**
         * Back-end widget form.
         *
         * @param array $instance Previously saved values from database.
         * @see WP_Widget::form()
         *
         */
        public function form($instance)
        {

            $title = (isset($instance['title'])) ? $instance['title'] : esc_html__('Search By:', 'carspot');
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title:', 'carspot'); ?>
                    <small><?php echo esc_html__('You can leave it empty as well', 'carspot'); ?></small>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                       value="<?php echo esc_attr($title); ?>">
            <p><?php echo esc_html__('You can show/hide the specific type from categories custom fields where you created it.', 'carspot'); ?> </p>
            </p>

            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         * @see WP_Widget::update()
         *
         */
        public function update($new_instance, $old_instance)
        {
            $instance = $old_instance;
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            return $instance;
        }

    }

}
/* Custom Brands Widgets Ends*/







/* Custom Number of hours Widgets Start*/
add_action('widgets_init', function () {
    register_widget('carspot_search_template_hours_feild');
});
if (!class_exists('carspot_search_template_hours_feild')) {

    class carspot_search_template_hours_feild extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_search_template_hours_feild',
                'description' => esc_html__('Only for search and single ad sidebar.', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Custom Number of hours Search', 'carspot'), $widget_ops);
        }


        public function widget($args, $instance)
        {
            global $carspot_theme;
            extract($args);
            $titles = apply_filters('widget_title', $instance['title']);
            $expand = "";
            if (isset($_GET['ad_hours']) && $_GET['ad_hours'] != "") {
                $expand = "in";
                $title = $_GET['ad_hours'];
            }

            ?>
            <div class="panel panel-default" id="red-title">
                <!-- Heading -->
                <div class="panel-heading" role="tab" id="headingFivezz">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseFive4" aria-expanded="true" aria-controls="collapseFive4">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            <?php echo $titles; ?>
                        </a>
                    </h4>
                </div>
                <form method="get"
                      action="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>">
                    <!-- Content -->
                    <div id="collapseFive4" class="panel-collapse collapse <?php echo esc_attr($expand); ?>"
                         role="tabpanel" aria-labelledby="headingFive">
                        <div class="panel-body">
                            <div class="search-widget">
                                <input id="autocomplete-dynamic" autocomplete="off" class="form-control"
                                       placeholder="<?php echo esc_html__('search', 'carspot'); ?>" type="text"
                                       name="ad_hours" value="">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <?php
                    echo carspot_search_params('ad_hours');
                    ?>
                </form>
            </div>

            <?php
        }

        /**
         * Back-end widget form.
         *
         * @param array $instance Previously saved values from database.
         * @see WP_Widget::form()
         *
         */
        public function form($instance)
        {

            $title = (isset($instance['title'])) ? $instance['title'] : esc_html__('Search By:', 'carspot');
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title:', 'carspot'); ?>
                    <small><?php echo esc_html__('You can leave it empty as well', 'carspot'); ?></small>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                       value="<?php echo esc_attr($title); ?>">
            <p><?php echo esc_html__('You can show/hide the specific type from categories custom fields where you created it.', 'carspot'); ?> </p>
            </p>

            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         * @see WP_Widget::update()
         *
         */
        public function update($new_instance, $old_instance)
        {
            $instance = $old_instance;
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            return $instance;
        }

    }

}

/* Custom Number of hours Widgets Ends*/

remove_action('wp_ajax_sb_ad_posting', 'carspot_ad_posting');
add_action('wp_ajax_sb_ad_posting', 'carspot_ad_postings');
if (!function_exists('carspot_ad_postings')) {

    function carspot_ad_postings()
    {
        check_ajax_referer('carspot_ad_post_secure', 'security');
        global $carspot_theme;
        if (get_current_user_id() == "") {
            echo "0";
            die();
        }
        // Getting values
        $params = array();
        parse_str($_POST['sb_data'], $params);
        $cats = array();
        if (isset($params['ad_cat_sub_sub_sub']) != "") {
            $cats[] = $params['ad_cat_sub_sub_sub'];

        }
        if ($params['ad_cat_sub_sub'] != "") {
            $cats[] = $params['ad_cat_sub_sub'];
        }
        if ($params['ad_cat_sub'] != "") {
            $cats[] = $params['ad_cat_sub'];
        }
        if ($params['ad_cat'] != "") {
            $cats[] = $params['ad_cat'];
        }
        $video_req = $_POST['video_req'];
        $get_ads = get_user_meta(get_current_user_id(), '_sb_simple_ads', true);
        $ad_status = 'publish';
        /* if post going to update */
        if ($_POST['is_update'] != "") {
            if ($carspot_theme['sb_update_approval'] == 'manual') {
                $ad_status = 'pending';
            }
            if ($carspot_theme['sb_ad_approval'] == 'manual') {
                $ad_status = 'pending';
            }
            $pid = $_POST['is_update'];
            $media = get_attached_media('image', $pid);
            $is_imageallow = carspotCustomFieldsVals($pid, $cats);
            if ($is_imageallow == 1 && count((array)$media) == 0) {
                echo "img_req";
                die();
            }
            /* video required or not */
            $total_vid = get_post_meta($pid, 'carspot_video_uploaded_attachment_', true);
            if ($video_req == 1 && ($total_vid == '' || count($total_vid) < 1)) {
                echo "vid_req";
                die();
            }
            if (count((array)$media) > 0) {
                foreach ($media as $single_media) {
                    set_post_thumbnail($pid, $single_media->ID);
                }
            }
            } else {
            if ($carspot_theme['sb_ad_approval'] == 'manual') {
                $ad_status = 'pending';
            }
            $pid = get_user_meta(get_current_user_id(), 'ad_in_progress', true);
            $media = get_attached_media('image', $pid);
            $is_imageallow = carspotCustomFieldsVals($pid, $cats);

            if ($is_imageallow == 1 && count((array)$media) == 0) {
                echo "img_req";
                die();
            }
            if (count((array)$media) > 0) {
                foreach ($media as $single_media) {
                    set_post_thumbnail($pid, $single_media->ID);
                }
            }
            /* video required or not */
            $total_vid = get_post_meta($pid, 'carspot_video_uploaded_attachment_', true);
           // if ($video_req == 1 && ($total_vid == '' || count($total_vid) < 1)) {
           if ($video_req == 1 && (!is_array($total_vid) || count($total_vid) < 1)) {

                echo "vid_req";
                die();
            }

            /* Now user can post new ad */
            delete_user_meta(get_current_user_id(), 'ad_in_progress');
            update_post_meta($pid, '_carspot_is_feature', '0');
            update_post_meta($pid, '_carspot_ad_status_', 'active');
            //send email on new post creation
            carspot_get_notify_on_ad_post($pid);
        }

        /* Bad words filteration */
        $words = explode(',', $carspot_theme['bad_words_filter']);
        $replace = $carspot_theme['bad_words_replace'];
        $desc = carspot_badwords_filter($words, $params['ad_description'], $replace);
        $title = carspot_badwords_filter($words, $params['ad_title'], $replace);
        $my_post = array(
            'ID' => $pid,
            'post_title' => sanitize_text_field($title),
            'post_status' => $ad_status,
            'post_content' => $desc,
            'post_name' => sanitize_text_field($title)
        );

        wp_update_post($my_post);
        /* ==============================
         *          Categories
         * ============================= */
        $category = array();
        if ($params['ad_cat'] != "") {
            $category[] = $params['ad_cat'];
        }
        if ($params['ad_cat_sub'] != "") {
            $category[] = $params['ad_cat_sub'];
        }
        if ($params['ad_cat_sub_sub'] != "") {
            $category[] = $params['ad_cat_sub_sub'];
        }
        if ($params['ad_cat_sub_sub_sub'] != "") {
            $category[] = $params['ad_cat_sub_sub_sub'];
        }

        if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'category_based' && class_exists('WooCommerce') && sizeof(WC()->cart->get_cart()) > 0 && $get_ads == 0) {
            $ad_status = 'pending';
            $my_post = array(
                'ID' => $pid,
                'post_status' => $ad_status,
            );
            wp_update_post($my_post);
            update_post_meta($pid, '_carspot_category_based_cats', $category);
            wp_set_post_terms($pid, $category, 'ad_cats');
        } else {
            wp_set_post_terms($pid, $category, 'ad_cats');
            update_post_meta($pid, '_carspot_category_based_cats', $category);
        }

        /* ==============================
         *          Country
         * ============================= */
        $countries = array();
        if ($params['ad_country'] != "") {
            $countries[] = $params['ad_country'];
        }
        if ($params['ad_country_states'] != "") {
            $countries[] = $params['ad_country_states'];
        }
        if ($params['ad_country_cities'] != "") {
            $countries[] = $params['ad_country_cities'];
        }
        if ($params['ad_country_towns'] != "") {
            $countries[] = $params['ad_country_towns'];
        }
        wp_set_post_terms($pid, $countries, 'ad_country');
        if (isset($params['ad_country']) && !empty($params['ad_country'])) {
            update_post_meta($pid, '_carspot_ad_country', ($params['ad_country']));
        }
        /* country-state */
        if (isset($params['ad_country_states']) && !empty($params['ad_country_states'])) {
            update_post_meta($pid, '_carspot_ad_country_states', ($params['ad_country_states']));
        }
        /* country-city */
        if (isset($params['ad_country_cities']) && !empty($params['ad_country_cities'])) {
            update_post_meta($pid, '_carspot_ad_country_cities', ($params['ad_country_cities']));
        }
        /* country-town */
        if (isset($params['ad_country_towns']) && !empty($params['ad_country_towns'])) {
            update_post_meta($pid, '_carspot_ad_country_towns', ($params['ad_country_towns']));
        }

        /* ==============================
         *          Ad Type
         * ============================= */
        if ($params['_carspot_ad_type'] != "") {
            $type_arr = explode('|', $params['_carspot_ad_type']);
            wp_set_post_terms($pid, $type_arr[0], 'ad_type');
            update_post_meta($pid, '_carspot_ad_type', ($type_arr[1]));
        }
        /* ==============================
         *          Ad Condition
         * ============================= */
        if ($params['_carspot_ad_condition'] != "") {
            $condition_arr = explode('|', $params['_carspot_ad_condition']);
            wp_set_post_terms($pid, $condition_arr[0], 'ad_condition');
            update_post_meta($pid, '_carspot_ad_condition', ($condition_arr[1]));
        }
        /* ==============================
         *          Ad Warranty
         * ============================= */
        if ($params['_carspot_ad_warranty'] != "") {
            $warranty_arr = explode('|', $params['_carspot_ad_warranty']);
            wp_set_post_terms($pid, $warranty_arr[0], 'ad_warranty');
            update_post_meta($pid, '_carspot_ad_warranty', ($warranty_arr[1]));
        }
        /* ==============================
         *          Ad Year
         * ============================= */
        if ($params['_carspot_ad_years'] != "") {
            $year_arr = explode('|', $params['_carspot_ad_years']);
            wp_set_post_terms($pid, $year_arr[0], 'ad_year');
            update_post_meta($pid, '_carspot_ad_years', ($year_arr[1]));
        }
        /* ==============================
         *          Ad Body Type
         * ============================= */
        if ($params['_carspot_ad_body_types'] != "") {
            $ad_body_type_arr = explode('|', $params['_carspot_ad_body_types']);
            wp_set_post_terms($pid, $ad_body_type_arr[0], 'ad_body_type');
            update_post_meta($pid, '_carspot_ad_body_types', ($ad_body_type_arr[1]));
        }
        /* ==============================
         *          Ad Transmission
         * ============================= */
        $ad_transmission = '';
        if ($params['_carspot_ad_transmissions'] != "") {
            $ad_transmission_arr = explode('|', $params['_carspot_ad_transmissions']);
            wp_set_post_terms($pid, $ad_transmission_arr[0], 'ad_transmission');
            update_post_meta($pid, '_carspot_ad_transmissions', ($ad_transmission_arr[1]));
        }
        /* ==============================
         *          Ad Engine Capacity
         * ============================= */
        if ($params['ad_engine_capacity'] != "") {
            $ad_engine_capacity_arr = explode('|', $params['ad_engine_capacity']);
            wp_set_post_terms($pid, $ad_engine_capacity_arr[0], 'ad_engine_capacity');
            update_post_meta($pid, '_carspot_ad_engine_capacities', ($ad_engine_capacity_arr[1]));
        }
        /* ==============================
         *          Ad Engine Type
         * ============================= */
        if ($params['_carspot_ad_engine_capacities'] != "") {
            $ad_engine_type_arr = explode('|', $params['_carspot_ad_engine_capacities']);
            wp_set_post_terms($pid, $ad_engine_type_arr[0], 'ad_engine_type');
            update_post_meta($pid, '_carspot_ad_engine_types', ($ad_engine_type_arr[1]));
        }
        /* ==============================
         *          Ad Assemble
         * ============================= */
        if ($params['_carspot_ad_assembles'] != "") {
            $ad_assemble_arr = explode('|', $params['_carspot_ad_assembles']);
            wp_set_post_terms($pid, $ad_assemble_arr[0], 'ad_assemble');
            update_post_meta($pid, '_carspot_ad_assembles', ($ad_assemble_arr[1]));
        }
        /* ==============================
         *          Ad Color
         * ============================= */
        if ($params['_carspot_ad_colors'] != "") {
            $ad_color_arr = explode('|', $params['_carspot_ad_colors']);
            wp_set_post_terms($pid, $ad_color_arr[0], 'ad_colors');
            update_post_meta($pid, '_carspot_ad_colors', ($ad_color_arr[1]));
        }
        /* ==============================
         *          Ad Insurance
         * ============================= */
        if ($params['_carspot_ad_insurance'] != "") {
            $ad_insurance_arr = explode('|', $params['_carspot_ad_insurance']);
            wp_set_post_terms($pid, $ad_insurance_arr[0], 'ad_insurance');
            update_post_meta($pid, '_carspot_ad_insurance', ($ad_insurance_arr[1]));
        }
        /* ==============================
         *          Ad Tags
         * ============================= */
        $tags = explode(',', $params['tags']);
        wp_set_object_terms($pid, $tags, 'ad_tags');
         




        /* Update post meta */
        update_post_meta($pid, '_carspot_poster_name', sanitize_text_field($params['sb_user_name']));
        update_post_meta($pid, '_carspot_poster_contact', sanitize_text_field($params['sb_contact_number']));
        update_post_meta($pid, '_carspot_ad_mileage', sanitize_text_field($params['ad_mileage']));
        update_post_meta($pid, '_carspot_ad_price', sanitize_text_field($params['ad_price']));
        update_post_meta($pid, '_carspot_ad_map_lat', sanitize_text_field($params['ad_map_lat']));
        update_post_meta($pid, '_carspot_ad_map_long', sanitize_text_field($params['ad_map_long']));
        update_post_meta($pid, '_carspot_ad_bidding', sanitize_text_field($params['ad_bidding']));
        update_post_meta($pid, '_carspot_ad_price_type', sanitize_text_field($params['ad_price_type']));
        update_post_meta($pid, '_carspot_ad_map_location', sanitize_text_field($params['sb_user_address']));
        update_post_meta($pid, '_carspot_ad_avg_city', sanitize_text_field($params['ad_avg_city']));
        update_post_meta($pid, '_carspot_ad_avg_hwy', sanitize_text_field($params['ad_avg_hwy']));
        update_post_meta($pid, '_ad_time_key', sanitize_text_field($params['ad_time']));
        update_post_meta($pid, 'ad_min_bid_key', sanitize_text_field($params['ad_min_bid']));
        update_post_meta($pid, 'ad_dif_bid_key', sanitize_text_field($params['ad_dif_bid']));
        

        //update_post_meta($pid, '_carspot_review_by_company', sanitize_text_field($params['review_by_company_url']));
        foreach ($params as $key => $val) {
            $pos = strpos($key, '_carspot_');
            if ($pos !== false) {
                $value = '';
                if ($val != "") {
                    $valueArr = explode('|', $val);
                    wp_set_post_terms($pid, $valueArr[0], 'ad_insurance');
                    $value = $valueArr[1];
                }
                update_post_meta($pid, $key, sanitize_text_field($value));
            }
        }
        if (isset($params['ad_yvideo']) && $params['ad_yvideo'] != "") {
            $video = explode("&t=", $params['ad_yvideo']);
            if (isset($video[0]) && $video[0] != "") {
                update_post_meta($pid, '_carspot_ad_yvideo', sanitize_text_field($video[0]));
            } else {
                update_post_meta($pid, '_carspot_ad_yvideo', sanitize_text_field($params['ad_yvideo']));
            }
        } else {
            update_post_meta($pid, '_carspot_ad_yvideo', sanitize_text_field($params['ad_yvideo']));
        }
        // Stroring Extra fileds in DB
        if ($params['sb_total_extra'] > 0) {
            for ($i = 1; $i <= $params['sb_total_extra']; $i++) {
                update_post_meta($pid, "_sb_extra_" . $params["title_$i"], sanitize_text_field($params["sb_extra_$i"]));
            }
        }

        //Add Dynamic Fields
        if (isset($params['cat_template_field']) && count($params['cat_template_field']) > 0) {
            foreach ($params['cat_template_field'] as $key => $data) {
                if (is_array($data)) {
                    $dataArr = array();
                    foreach ($data as $k) {
                        $dataArr[] = $k;
                    }
                    $data = stripslashes(json_encode($dataArr, JSON_UNESCAPED_UNICODE));
                }
                update_post_meta($pid, $key, sanitize_text_field($data));
            }
        }
        /* ad features */
        $features = $params['ad_features'];
        if (count((array)$features) > 0) {
            $ad_features = '';
            foreach ($features as $feature) {
                $ad_features .= $feature . "|";
            }
            $ad_features = rtrim($ad_features, '|');
        }
        update_post_meta($pid, '_carspot_ad_features', sanitize_text_field($ad_features));
        update_post_meta($pid, '_ad_time_key', sanitize_text_field($params['ad_time']));
        /* review stamp array */
        $review_stamp_val = $params['review_stamp_nme'];
        if ($review_stamp_val != '') {
            $arrays = explode('|', $review_stamp_val);
            update_post_meta($pid, '_carspot_ad_review_stamp', $arrays[1]);
            wp_set_post_terms($pid, $arrays[0], $term_type);


        }
        /* VIN Number vin_number */
        if ($params['vin_number'] != "") {
            update_post_meta($pid, 'carspot_ad_vin_number', sanitize_text_field($params['vin_number']));
        }
        //only for category based pricing
        if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'category_based' && class_exists('WooCommerce')) {
            if (sizeof(WC()->cart->get_cart()) > 0) {
                $carts = WC()->cart->get_cart();

                WC()->session->set('_carspot_ad_id', $pid);
                if (isset($carspot_theme['sb_checkout_page']) && $carspot_theme['sb_checkout_page'] != '') {
                    $pid = $carspot_theme['sb_checkout_page'];
                }
            }
        }

        //only for category based pricing
        if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'package_based') {
            if (isset($_POST['is_update']) && $_POST['is_update'] == "") {
                $simple_ads = get_user_meta(get_current_user_id(), '_sb_simple_ads', true);
                if ($simple_ads > 0 && !is_super_admin(get_current_user_id())) {
                    $simple_ads = $simple_ads - 1;
                    update_user_meta(get_current_user_id(), '_sb_simple_ads', $simple_ads);
                }
            }

            // Making it featured ad
            if (isset($params['sb_make_it_feature']) && $params['sb_make_it_feature']) {
                // Uptaing remaining ads.
                $featured_ad = get_user_meta(get_current_user_id(), '_carspot_featured_ads', true);
                if ($featured_ad > 0 || $featured_ad == '-1') {
                    update_post_meta($pid, '_carspot_is_feature', '1');
                    update_post_meta($pid, '_carspot_is_feature_date', date('Y-m-d'));
                    $featured_ad = $featured_ad - 1;
                    update_user_meta(get_current_user_id(), '_carspot_featured_ads', $featured_ad);
                }
            }
        /* ==============================
         *          Ad Custom Field
         * ============================= */
      
         //Model
        if (isset($params['ad_model']) && !empty($params['ad_model'])) {
            update_post_meta($pid, '_carspot_tpl_field_ad_model', ($params['ad_model']));
        }
         //Brands
        if (isset($params['ad_brand']) && !empty($params['ad_brand'])) {
            update_post_meta($pid, '_carspot_tpl_field_ad_brand', ($params['ad_brand']));
        }
        //Number Of Hours
        if (isset($params['ad_hour']) && !empty($params['ad_hour'])) {
            update_post_meta($pid, '_carspot_tpl_field_ad_hours', ($params['ad_hour']));
        }
        //weight
        if (isset($params['ad_weight']) && !empty($params['ad_weight'])) {
            update_post_meta($pid, '_carspot_tpl_field_ad_weight', ($params['ad_weight']));
        }
            // Bumping it up
            if (isset($params['sb_bump_up']) && $params['sb_bump_up']) {
                // Uptaing remaining ads.
                $bump_ads = get_user_meta(get_current_user_id(), '_carspot_bump_ads', true);
                if ($bump_ads > 0 || $bump_ads == '-1') {
                    wp_update_post(
                        array(
                            'ID' => $pid, // ID of the post to update
                            'post_date' => current_time('mysql'),
                            'post_date_gmt' => get_gmt_from_date(current_time('mysql'))
                        )
                    );
                    if ($bump_ads != '-1') {
                        $bump_ads = $bump_ads - 1;
                    }
                    update_user_meta(get_current_user_id(), '_carspot_bump_ads', $bump_ads);
                }
            }
        }
        
        if ($_POST['is_update'] == "") {
           
            do_action('cs_duplicate_posts_lang_wpml', $pid, 'ad_post');
        }
        echo urldecode(get_the_permalink($pid));
        die();
    }

}