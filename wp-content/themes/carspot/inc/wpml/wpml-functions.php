<?php
/* ===========================
 * display result within all
 * languages or only current language
 * (used)
  ============================ */
if (!function_exists('carspot_wpml_show_all_posts_callback')) {
    function carspot_wpml_show_all_posts_callback($query_args = array(), $option_name = 'carspot_theme', $option_key_name = 'cs_display_post')
    {
        if (carspot_check_wpml_installed() && $query_args != '') {
            global $sitepress;
            $cs_show_posts = false;
            $cs_theme_option = get_option($option_name);
            $cs_display_post = ($cs_theme_option[$option_key_name]);
            if (!is_admin()) {
                if (class_exists('Redux')) {
                    $cs_show_posts = $cs_display_post;
                }
                if ($cs_show_posts == true) {
                    do_action('cs_wpml_terms_filters');
                    $query_args['suppress_filters'] = $cs_show_posts;
                }
            }
        }
        return $query_args;
    }
}

/* ======================
 * check wpml installed
 * and activated
 * (used)
 ======================= */
if (!function_exists('carspot_check_wpml_installed')) {
    function carspot_check_wpml_installed()
    {
        if (function_exists('icl_object_id')) {
            return true;
        } else {
            return false;
        }
    }
}

/*
 *  custom language switcher
 * (used)
 * */
if (!function_exists('cs_language_switcher')) {

    function cs_language_switcher()
    {
        if (function_exists('icl_object_id')) {
            $lang_link = '';
            //$languages = icl_get_languages('skip_missing=0&orderby=code'); //commneted on 5/4/2021
            $languages = apply_filters('wpml_active_languages', NULL, 'orderby=id&order=desc');
            $final_img = esc_url(trailingslashit(get_template_directory_uri()) . 'images/translation.png');
            $lang_name = esc_html__('All Languages', 'carspot');
            if (!empty($languages)) {
                ?>
                <!-- <ul class="listnone">-->
                <li class="dropdown">
                    <span class="loc"><?php echo $lang_name; ?></span>
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"
                       data-close-others="true" aria-expanded="false">
                        <img src="<?php echo esc_url($final_img); ?>" alt="<?php echo esc_attr($lang_name); ?>"/>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <?php
                        foreach ($languages as $lang) {
                            if ($lang['active']) {
                                $lang_link = "javascript:void(0)";
                            } else {
                                $lang_link = esc_url($lang['url']);
                            }
                            ?>
                            <li>
                                <a href="<?php echo $lang_link; ?>" class="top-lang-selection">
                                    <img src="<?php echo $lang['country_flag_url']; ?>" alt="">
                                    <span><?php echo $lang['native_name']; ?></span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <!--</ul>-->
                <?php
            }
        }
    }
}

/* ===================
 *  set url parameters
 * for links
 * (used)
 ==================== */
if (!function_exists('carspot_set_url_params_multi')) {

    function carspot_set_url_params_multi($carspot = '', $wpml_url_params = '')
    {
        if ($carspot != '') {
            $carspot = add_query_arg(($wpml_url_params), $carspot);
            $carspot = cs_page_lang_url_callback($carspot);
        }
        return $carspot;
    }

}

/*
 * Page language url
 * (used)
 */
if (!function_exists('cs_page_lang_url_callback')) {
    function cs_page_lang_url_callback($page_url = '')
    {
        global $sitepress;
        if (function_exists('icl_object_id') && $page_url != '') {
            $page_url = apply_filters('wpml_permalink', $page_url, ICL_LANGUAGE_CODE, true);
        }
        return $page_url;
    }
}

/*
 * Return page id according to language
 * especially come from theme option
 * espacially for theme options
 * (used)
 */
if (!function_exists('cs_language_page_id_callback')) {

    function cs_language_page_id_callback($page_id = '', $post_type = 'page')
    {
        global $sitepress;
        if (function_exists('icl_object_id') && function_exists('wpml_init_language_switcher') && $page_id != '' && is_numeric($page_id)) {
            $language_code = $sitepress->get_current_language();
            //$lang_page_id = icl_object_id($page_id, $post_type, false, $language_code);
            $lang_page_id = apply_filters('wpml_object_id', $page_id, $post_type, FALSE, $language_code);
            if ($lang_page_id <= 0) {
                $lang_page_id = $page_id;
            }
            return $lang_page_id;
        } else {
            return $page_id;
        }
    }
}

/*
 * @param $object_id integer|string|array The ID/s of the objects to check and return
 * @param $type the object type: post, page, {custom post type name}, nav_menu, nav_menu_item, category, tag etc.
 * @return string or array of object ids
 * (used)
 */
if (!function_exists('carspot_translate_object_id_callback')) {

    function carspot_translate_object_id_callback($object_id, $type)
    {
        $current_language = apply_filters('wpml_current_language', NULL);
        /* if array */
        if (is_array($object_id)) {
            $translated_object_ids = array();
            foreach ($object_id as $id) {
                $translated_object_ids[] = apply_filters('wpml_object_id', $id, $type, true, $current_language);
            }
            return $translated_object_ids;
        } /* if string */
        elseif (is_string($object_id)) {
            /* check if we have a comma separated ID string */
            $is_comma_separated = strpos($object_id, ",");
            if ($is_comma_separated !== FALSE) {
                /* explode the comma to create an array of IDs */
                $object_id = explode(',', $object_id);
                $translated_object_ids = array();
                foreach ($object_id as $id) {
                    $translated_object_ids[] = apply_filters('wpml_object_id', $id, $type, true, $current_language);
                }
                /* make sure the output is a comma separated string (the same way it came in!) */
                return implode(',', $translated_object_ids);
            } /* if we don't find a comma in the string then this is a single ID */
            else {
                return apply_filters('wpml_object_id', intval($object_id), $type, true, $current_language);
            }
        } /* if int */
        else {
            return apply_filters('wpml_object_id', $object_id, $type, true, $current_language);
        }
    }
}

/* =====================
 * reset taxonomy data.
 * (used)
  ====================== */
if (!function_exists('cs_wpml_taxonomy_data')) {

    function cs_wpml_taxonomy_data()
    {
        global $sitepress;
        remove_filter('get_terms_args', array($sitepress, 'get_terms_args_filter'), 10);
        remove_filter('get_term', array($sitepress, 'get_term_adjust_id'), 1);
        remove_filter('terms_clauses', array($sitepress, 'terms_clauses'), 10);
    }

}


/* ===========================
 * wpml functions for framwork
 * Duplicate post from backend
 * (used)
   =========================== */
if (in_array('sitepress-multilingual-cms/sitepress.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    $cs_duplicate_posts = false;
    $cs_theme_option = get_option('carspot_theme');
    $cs_display_post = isset($cs_theme_option['cs_duplicate_post']);
    if (class_exists('Redux')) {
        $cs_duplicate_posts = $cs_display_post;
    }
    if ($cs_duplicate_posts) {
        add_action('wp_insert_post', 'post_duplicate_on_publish');
        function post_duplicate_on_publish($post_id)
        {
            $post = get_post($post_id);
            if ($post->post_type == 'ad_post' || $post->post_type == 'reviews' || $post->post_type == 'comparison') {
                /* don't save for autosave */
                if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                    return $post_id;
                }
                /* dont save for revisions */
                if (isset($post->post_type) && $post->post_type == 'revision') {
                    return $post_id;
                }
                /* we need this to avoid recursion see add_action at the end */
                remove_action('wp_insert_post', 'post_duplicate_on_publish');
                /* make duplicates if the post being saved */
                /* #1. itself is not a duplicate of another or */
                /* #2. does not already have translations */
                $is_translated = apply_filters('wpml_element_has_translations', '', $post_id, $post->post_type);
                if (!$is_translated) {
                    do_action('wpml_admin_make_post_duplicates', $post_id);
                }
                /* must hook again - see remove_action further up */
                add_action('wp_insert_post', 'post_duplicate_on_publish');
            }
        }
    }
}

/*
 * get url of post/post-type
 * according to language
 * (used)
 * */

if (!function_exists('get_correct_link_by_postID')) {
    function get_correct_link_by_postID($pid = '')
    {
        if ($pid != '') {
            if (carspot_check_wpml_installed()) {
                $post_language_information = wpml_get_language_information($pid);
                $pid_url = apply_filters('wpml_permalink', get_post_permalink($pid), $post_language_information['language_code']);
                $pid_url_ = $pid_url;
            } else {
                $pid_url_ = get_post_permalink($pid);
            }
            return $pid_url_;
        }
    }
}

/*
 * get url of category/term
 * according to language
 * (used)
 * */
if (!function_exists('get_correct_link_by_catID')) {
    function get_correct_link_by_catID($catID = '')
    {
        if ($catID != '') {
            if (carspot_check_wpml_installed()) {
                $post_language_information = wpml_get_language_information($catID);
                $catID_url = apply_filters('wpml_permalink', get_term_link($catID), $post_language_information['language_code']);
            } else {
                $catID_url = get_term_link($catID);
            }
            return $catID_url;
        }
    }
}
/*
 * test function for duplicate post backend
 */
if (!function_exists('post_duplicate_on_publish_test')) {
    function post_duplicate_on_publish_test($post_id)
    {
        $post = get_post($post_id);
        if ($post->post_type == 'comparison') {
            /* don't save for autosave */
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return $post_id;
            }
            /* dont save for revisions */
            if (isset($post->post_type) && $post->post_type == 'revision') {
                return $post_id;
            }
            /* we need this to avoid recursion see add_action at the end */
            remove_action('wp_insert_post', 'post_duplicate_on_publish');
            /* make duplicates if the post being saved */
            /* #1. itself is not a duplicate of another or */
            /* #2. does not already have translations */
            $is_translated = apply_filters('wpml_element_has_translations', '', $post_id, $post->post_type);
            if (!$is_translated) {
                do_action('wpml_admin_make_post_duplicates', $post_id);
            }
            /* must hook again - see remove_action further up */
            add_action('wp_insert_post', 'post_duplicate_on_publish');
        }
    }
}
//========================
/*
 * show record in all language.
 * related to specific taxonomy.
 * related to specific custom tags.
 * related to specific custom region.
 * 1 => if display all post switch ON.
 * 2 => if WPML is active.
 */
if (!function_exists('cs_show_taxonomy_all')) {
    function cs_show_taxonomy_all($taxo_id, $taxo_nme)
    {
        global $sitepress;
        $cs_show_posts = false;
        $cs_theme_option = get_option('carspot_theme');
        $cs_display_post = ($cs_theme_option['cs_display_post']);
        if (class_exists('Redux')) {
            $cs_show_posts = $cs_display_post;
        }
        if (carspot_check_wpml_installed() && $cs_show_posts) {
            $languages = apply_filters('wpml_active_languages', NULL, 'orderby=id&order=desc');
            $taxo = array();
            foreach ($languages as $val) {
                $taxo[] = apply_filters('wpml_object_id', $taxo_id, $taxo_nme, FALSE, $val['code']);
            }
            /*return original id if only one language.*/
            return $taxo;
        } else {
            return $taxo_id;
        }
    }
}

/* ======================
 *  include hidden value
 * for language parameter
 ======================== */
if (!function_exists('cs_form_lang_field_callback')) {
    function cs_form_lang_field_callback($echo = false)
    {
        global $sitepress;
        $hidden_lang_html = '';
        if (class_exists('SitePress')) {
            if (carspot_check_wpml_installed()) {
                if ($sitepress->get_setting('language_negotiation_type') == 3) {
                    $hidden_lang_html = '<input name="lang" id="lang" type="hidden" value="' . ICL_LANGUAGE_CODE . '">';
                }
            }
        }
        if ($echo) {
            return carspot_returnEcho($hidden_lang_html);
        } else {
            return $hidden_lang_html;
        }
    }
}

/* ==================================
 wpml function for duplicate post in
 all language or in current language.
 (used)
 ==================================== */
add_action('cs_duplicate_posts_lang_wpml', 'cs_duplicate_posts_lang', 10, 4);

function cs_duplicate_posts_lang($org_post_id = 0, $pst_nme = '', $theme_option_ky = 'carspot_theme', $wpml_duplicate_post = 'cs_duplicate_post')
{
    global $sitepress;
    $cs_duplicate_post = false;
    $cs_theme_option = get_option($theme_option_ky);
    $cs_display_post = isset($cs_theme_option[$wpml_duplicate_post]);
    if (class_exists('Redux')) {
        $cs_duplicate_post = $cs_display_post;
    }
    if (function_exists('icl_object_id') && $org_post_id != 0 && $cs_duplicate_post) {
        $language_details_original = $sitepress->get_element_language_details($org_post_id, "post_'.$pst_nme.'");
        if (!class_exists('TranslationManagement')) {
            include(ABSPATH . 'wp-content/plugins/sitepress-multilingual-cms/inc/translation-management/translation-management.class.php');
        }
        foreach ($sitepress->get_active_languages() as $lang => $details) {
            if ($lang != $language_details_original->language_code) {
                $iclTranslationManagement = new TranslationManagement();
                $iclTranslationManagement->make_duplicate($org_post_id, $lang);
            }
        }
    }
}