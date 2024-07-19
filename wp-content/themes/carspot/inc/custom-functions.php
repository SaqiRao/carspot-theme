<?php

class Carsport_custom
{

    function __construct()
    {
        add_action('carsport_search_option_type', array($this, 'carsport_search_option_type_callback'), 10);
        add_action('carsport_search_option_checked', array($this, 'carsport_search_option_checked_callback'), 10, 2);
        add_filter('carspot_search_option_name', array($this, 'carspot_search_option_name_callback'), 10, 1);
        add_filter('carsport_add_multiquery_args', array($this, 'carsport_add_multiquery_args_callback'), 10, 3);
        add_action('carspot_cat_breadcrumb', array($this, 'carspot_cat_breadcrumb_callback'));
        add_filter('carsport_search_hidden_values', array($this, 'carsport_search_hidden_values_callback'), 10, 3);
        add_action('carsport_search_category_count', array($this, 'carsport_search_category_count_callback'), 10, 2);
    }

    public function carsport_search_category_count_callback($key = '', $val = '')
    {

        global $carspot_theme;

        $sb_filter_count = isset($carspot_theme['sb_filter_count']) ? $carspot_theme['sb_filter_count'] : false;

        if ($sb_filter_count) {
            $is_active = '';
            if (isset($carspot_theme['show_only_active_ads']) && $carspot_theme['show_only_active_ads']) {
                $is_active = array(
                    'key' => '_carspot_ad_status_',
                    'value' => 'active',
                    'compare' => '=',
                );
            }

            $show_featured_in_search = '';
            $value_from_theme_options = $carspot_theme['feature_ads_in_regular'];
            if ($value_from_theme_options == '1') {
                $show_featured_in_search = array();
            } else {
                $show_featured_in_search = array(
                    'relation' => 'OR',
                    array(
                        'key' => '_carspot_is_feature',
                        'value' => '',
                        'compare' => 'NOT EXISTS',
                    ),
                    array(
                        'key' => '_carspot_is_feature',
                        'value' => '1',
                        'compare' => '!=',
                    ),
                );

            }
            $args = array(
                'post_type' => 'ad_post',
                'post_status' => 'publish',
                'fields' => 'ids',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => $key,
                        'value' => $val,
                        'compare' => '=',
                    ),
                    $is_active,
                    $show_featured_in_search,
                ),
                /*'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => $key,
                        'value' => $val,
                        'compare' => '=',
                    ),
                    array(
                        'key' => '_carspot_ad_status_',
                        'value' => 'active',
                        'compare' => '=',
                    )
                ),*/
            );

            $the_query = new WP_Query($args);
            ?>
            <span> (<?php echo esc_html($the_query->found_posts); ?>) </span>
            <?php
        }
    }

    public function carsport_search_hidden_values_callback($return_str, $query_res, $hidden_key)
    {
        global $carspot_theme;
        //$return_str = '';
        $sb_search_options_type = isset($carspot_theme['sb_search_options_type']) ? $carspot_theme['sb_search_options_type'] : 'radio';
        if ($sb_search_options_type == 'checkbox' && isset($query_res) && is_array($query_res)) {
            foreach ($query_res as $url_val) {
                $alter_key = $this->carspot_search_option_name_callback($hidden_key);
                $return_str .= '<input type="hidden" name="' . esc_attr($alter_key) . '" value="' . esc_attr($url_val) . '" />';
            }
        }
        return $return_str;
    }

    public function carspot_cat_breadcrumb_callback()
    {
        global $carspot_theme;
        $type = $carspot_theme['cat_and_location'];

        if (is_singular('ad_post')) {
            $ad_terms = get_the_terms(get_the_ID(), 'ad_cats');


            if (isset($ad_terms) && !empty($ad_terms) && is_array($ad_terms)) {

                foreach ($ad_terms as $categ_key => $categ_value) {

                    if ($type == 'search') {
                        $link = get_the_permalink($carspot_theme['sb_search_page']) . '?cat_id=' . $categ_value->term_id;
                    } else {
                        $link = get_term_link($categ_value->term_id);
                    }
                    ?>
                    <li>
                        <a href="<?php echo esc_url($link); ?>">
                            <?php echo esc_html($categ_value->name); ?>
                        </a>
                    </li>
                    <?php
                    break;
                }
            }
        }
    }

    public function carsport_search_option_checked_callback($get_key, $find_value)
    {
        global $carspot_theme;
        $sb_search_options_type = isset($carspot_theme['sb_search_options_type']) ? $carspot_theme['sb_search_options_type'] : 'radio';
        if ($sb_search_options_type == 'checkbox') {
            $body_type = array();
            if (isset($_GET[$get_key]) && $_GET[$get_key] != "") {
                $body_type = $_GET[$get_key];
            }
            if (isset($body_type) && !empty($body_type) && is_array($body_type)) {
                foreach ($body_type as $value) {
                    if ($value == $find_value) {
                        echo esc_attr(' checked ');
                    }
                }
            }
        } else {
            $body_type = "";
            if (isset($_GET[$get_key]) && $_GET[$get_key] != "" && !is_array($_GET[$get_key])) {
                $body_type = $_GET[$get_key];
            }
            if ($body_type == $find_value) {
                echo esc_attr(' checked ');
            }
        }
    }

    public function carsport_add_multiquery_args_callback($args = array(), $get_key = '', $search_key = '')
    {
        global $carspot_theme;
        $sb_search_options_type = isset($carspot_theme['sb_search_options_type']) ? $carspot_theme['sb_search_options_type'] : 'radio';

        if ($sb_search_options_type == 'checkbox') {
            $args = array();
            if (is_array($_GET[$get_key]) && count($_GET[$get_key]) > 1) {
                $args['relation'] = 'OR';
            }
            if (is_array($_GET[$get_key]) && count($_GET[$get_key]) > 0) {
                foreach ($_GET[$get_key] as $fetch_key => $fetch_value) {
                    $args[] = array(
                        'key' => $search_key,
                        'value' => $fetch_value,
                        'compare' => '=',
                    );
                }
            }
        } else {
            return $args;
        }
        return $args;
    }

    public function carspot_search_option_name_callback($field_name = '')
    {
        global $carspot_theme;

        $sb_search_options_type = isset($carspot_theme['sb_search_options_type']) ? $carspot_theme['sb_search_options_type'] : 'radio';
        if ($sb_search_options_type == 'checkbox') {
            $field_name = $field_name . '[]';
        } else {
            $field_name = $field_name;
        }
        return $field_name;
    }

    public function carsport_search_option_type_callback()
    {
        global $carspot_theme;

        $sb_search_options_type = isset($carspot_theme['sb_search_options_type']) ? $carspot_theme['sb_search_options_type'] : 'radio';

        if ($sb_search_options_type == 'checkbox') {
            echo esc_attr('checkbox');
        } else {
            echo esc_attr('radio');
        }
    }

}

new Carsport_custom();
?>