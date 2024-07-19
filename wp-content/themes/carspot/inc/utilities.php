<?php
/*
  Basic functions.
 */

/* ------------------------------------------------ */
/* carspot get template ID */
/* ------------------------------------------------ */
if (!function_exists('carspot_getTemplateID')) {

    function carspot_getTemplateID($type = 'dynamic', $is_show = '')
    {
        if (isset($_GET['cat_id']) && $_GET['cat_id'] != "" && is_numeric($_GET['cat_id'])) {
            $term_id = $_GET['cat_id'];
            $result = carspot_dynamic_templateID($term_id);
            $templateID = get_term_meta($result, '_sb_dynamic_form_fields', true);

            if (isset($templateID) && $templateID != "") {
                if ($type == 'static') {
                    $formData = sb_custom_form_data($templateID, $is_show);
                } else if ($type == 'taxconomy') {

                    $formData = sb_text_field_value($result, $is_show);
                } else {
                    $formData = sb_dynamic_form_data($templateID);
                }
                return $formData;
            } else {
                return 1;
            }
        } else {
            return 1;
        }
    }

}

/* ------------------------------------------------ */
/* carspot_close_tags */
/* ------------------------------------------------ */
if (!function_exists('carspot_close_tags')) {

    function carspot_close_tags($html = '')
    {
        preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $openedtags = $result[1];   #put all closed tags into an array
        preg_match_all('#</([a-z]+)>#iU', $html, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);
        if (count($closedtags) == $len_opened) {
            return $html;
        }
        $openedtags = array_reverse($openedtags);
        for ($i = 0; $i < $len_opened; $i++) {

            if (!in_array($openedtags[$i], $closedtags)) {

                $html .= '</' . $openedtags[$i] . '>';
            } else {

                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    }

}

/* ------------------------------------------------ */
/* Comments */
/* ------------------------------------------------ */

if (!function_exists('carspot_comments_list')) :

    function carspot_comments_list($comment = '', $args = '', $depth = '')
    {
        $GLOBALS['comment'] = $comment;
        $img = '';
        if (get_avatar_url($comment, 44) != "") {
            $img = '<img class="pull-left hidden-xs img-circle" alt="' . esc_html__('Avatar', 'carspot') . '" src="' . esc_url(get_avatar_url($comment, 22)) . '" />';
        }
        ?>

        <li class="comment" id="comment-<?php esc_attr(comment_ID()); ?>">
        <div class="comment-info">
            <?php echo "" . $img; ?>
            <div class="author-desc">
                <div class="author-title">
                    <strong><?php comment_author(); ?></strong>
                    <ul class="list-inline">
                        <li>
                            <a href="javascript:void(0);"><?php echo esc_html(get_comment_date()) . " " . esc_html(get_comment_time()); ?></a>
                        </li>
                        <?php
                        $myclass = ' active-color';
                        $reply_link = preg_replace('/comment-reply-link/', 'comment-reply-link ' . $myclass, get_comment_reply_link(array_merge($args, array('reply_text' => esc_html__('Reply', 'carspot'), 'depth' => $depth, 'max_depth' => $args['max_depth']))), 1);
                        ?>
                        <?php
                        if ($reply_link != "") {
                        ?>
                        <li><?php echo wp_kses($reply_link, carspot_required_tags()); ?>
                            <?php
                            }
                            ?>
                        </li>
                    </ul>
                </div>
                <?php comment_text(); ?>
            </div>
        </div>
        <?php
        if ($args['has_children'] == "") {
            echo '</li>';
        }
        ?>
        <?php
    }

endif;
/* ------------------------------------------------ */
/* Pagination for Blog */
/* ------------------------------------------------ */

if (!function_exists('carspot_pagination')) {

    function carspot_pagination()
    {
        if (is_singular())
            return;
        global $wp_query;
        /** Stop execution if there's only 1 page */
        if ($wp_query->max_num_pages <= 1) {
            return;
        }
        $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
        $max = intval($wp_query->max_num_pages);
        /* Add current page to the array */
        if ($paged >= 1)
            $links[] = $paged;

        /**    Add the pages around the current page to the array */
        if ($paged >= 3) {
            $links[] = $paged - 1;
            $links[] = $paged - 2;
        }

        if (($paged + 2) <= $max) {
            $links[] = $paged + 2;
            $links[] = $paged + 1;
        }

        echo '<ul class="pagination pagination-large">' . "\n";

        if (get_previous_posts_link())
            printf('<li>%s</li>' . "\n", get_previous_posts_link());

        /**    Link to first page, plus ellipses if necessary */
        if (!in_array(1, $links)) {
            $class = 1 == $paged ? ' class="active"' : '';

            printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

            if (!in_array(2, $links))
                echo '<li><a href="javascript:void(0);">...</a></li>';
        }

        /**    Link to current page, plus 2 pages in either direction if necessary */
        sort($links);
        foreach ((array)$links as $link) {
            $class = $paged == $link ? ' class="active"' : '';
            printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
        }

        /**    Link to last page, plus ellipses if necessary */
        if (!in_array($max, $links)) {
            if (!in_array($max - 1, $links))
                echo '<li><a href="javascript:void(0);">...</a></li>' . "\n";
            $class = $paged == $max ? ' class="active"' : '';
            printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
        }

        if (get_next_posts_link())
            printf('<li>%s</li>' . "\n", get_next_posts_link());
        echo '</ul>' . "\n";
    }
}

if (!function_exists('carspot_pagination_search')) {

    function carspot_pagination_search($wp_query = '')
    {
        if (is_singular())
            //return;
            //global $wp_query;
            /** Stop execution if there's only 1 page */
            if ($wp_query->max_num_pages <= 1)
                return;
        if (is_front_page()) {
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }
        //$paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
        $max = intval($wp_query->max_num_pages);

        /**    Add current page to the array */
        if ($paged >= 1) {
            $links[] = $paged;
        }
        /**    Add the pages around the current page to the array */
        if ($paged >= 3) {
            $links[] = $paged - 1;
            $links[] = $paged - 2;
        }

        if (($paged + 2) <= $max) {
            $links[] = $paged + 2;
            $links[] = $paged + 1;
        }

        echo '<ul class="pagination pagination-lg">' . "\n";

        if (get_previous_posts_link())
            printf('<li>%s</li>' . "\n", get_previous_posts_link());

        /**    Link to first page, plus ellipses if necessary */
        if (!in_array(1, $links)) {
            $class = (1 == $paged) ? ' class="active"' : '';

            printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

            if (!in_array(2, $links))
                echo '<li><a href="javascript:void(0);">...</a></li>';
        }

        /**    Link to current page, plus 2 pages in either direction if necessary */
        sort($links);
        foreach ((array)$links as $link) {

            $class = ($paged == $link) ? ' class="active"' : '';
            printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
        }

        /**    Link to last page, plus ellipses if necessary */
        if (!in_array($max, $links)) {
            if (!in_array($max - 1, $links)) {
                echo '<li><a href="javascript:void(0);">...</a></li>' . "\n";
            }
            $class = ($paged == $max) ? ' class="active"' : '';
            printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
        }


        if (get_next_posts_link_custom($wp_query))
            printf('<li>%s</li>' . "\n", get_next_posts_link_custom($wp_query));

        echo '</ul>' . "\n";
    }

}

if (!function_exists('get_next_posts_link_custom')) {

    function get_next_posts_link_custom($wp_query = '', $label = null, $max_page = 0)
    {
        global $paged;
        if (!$max_page)
            $max_page = $wp_query->max_num_pages;

        if (!$paged)
            $paged = 1;

        $nextpage = intval($paged) + 1;

        if (null === $label)
            $label = esc_html__('Next Page &raquo;', 'carspot');

        if ($nextpage <= $max_page) {
            /**
             * Filters the anchor tag attributes for the next posts page link.
             *
             * @param string $attributes Attributes for the anchor tag.
             * @since 2.7.0
             *
             */
            $attr = apply_filters('next_posts_link_attributes', '');

            return '<a href="' . next_posts($max_page, false) . "\" $attr>" . preg_replace('/&([^#])(?![a-z]{1,8};)/i', '&#038;$1', $label) . '</a>';
        }
    }

}

if (!function_exists('carspot_getCatID')) {

// Return Category ID
    function carspot_getCatID()
    {
        return esc_html(get_cat_id(single_cat_title("", false)));
    }

}
// Breadcrumb

if (!function_exists('carspot_breadcrumb')) {

    function carspot_breadcrumb()
    {
        $string = '';
        if (is_category()) {
            $string .= esc_html(get_cat_name(carspot_getCatID()));
        } else if (is_single()) {
            $string .= esc_html(get_the_title());
        } elseif (is_page()) {
            $string .= esc_html(get_the_title());
        } elseif (is_tag()) {
            $string .= esc_html(single_tag_title("", false));
        } elseif (is_search()) {
            $string .= esc_html(get_search_query());
        } elseif (is_404()) {
            $string .= esc_html__('Page not Found', 'carspot');
        } elseif (is_author()) {
            $string .= esc_html__('Author', 'carspot');
        } else if (is_tax()) {
            $string .= esc_html(single_cat_title("", false));
        } elseif (is_archive()) {
            $string .= esc_html__('Archive', 'carspot');
        } else if (is_home()) {
            $string = esc_html__('Latest News & Trends', 'carspot');
        }

        return $string;
    }

}

// Get BreadCrumb Heading
if (!function_exists('carspot_bread_crumb_heading')) {

    function carspot_bread_crumb_heading()
    {
        $page_heading = '';
        global $carspot_theme;
        if (is_search()) {
            $string = esc_html__('entire web', 'carspot');
            if (get_search_query() != "") {
                $string = get_search_query();
            }
            $page_heading = sprintf(esc_html__('Search Results for: %s', 'carspot'), esc_html($string));
        } else if (is_category()) {
            $page_heading = esc_html(single_cat_title("", false));
        } else if (is_tag()) {
            $page_heading = esc_html__('Tag: ', 'carspot') . esc_html(single_tag_title("", false));
        } else if (is_404()) {
            $page_heading = esc_html__('Page not found', 'carspot');
        } else if (is_author()) {
            $author_id = get_query_var('author');
            $author = get_user_by('ID', $author_id);
            $page_heading = $author->display_name;
        } else if (is_tax()) {
            $page_heading = esc_html(single_cat_title("", false));
        } else if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && is_shop()) {
            $page_heading = esc_html__('All Products', 'carspot');
        } else if (is_archive()) {
            $page_heading = esc_html__('Blog Archive', 'carspot');
        } else if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) && is_product_category()) {
            $page_heading = esc_html__('Shop ', 'carspot');
        } else if (is_home()) {
            if (isset($carspot_theme['sb_blog_page_title']) && $carspot_theme['sb_blog_page_title'] != "") {
                $page_heading = $carspot_theme['sb_blog_page_title'];
            } else {
                $page_heading = esc_html__('Latest Stories', 'carspot');
            }
        } else if (is_singular('post')) {
            if (isset($carspot_theme['sb_blog_single_title']) && $carspot_theme['sb_blog_single_title'] != "") {
                $page_heading = $carspot_theme['sb_blog_single_title'];
            } else {
                $page_heading = '';
            }
        } else if (is_singular('page')) {
            $page_heading = get_the_title();
        } else if (is_singular('ad_post')) {
            $page_heading = get_the_title();
        } else if (is_singular('reviews')) {
            $page_heading = get_the_title();
        }

        return $page_heading;
    }

}

// ------------------------------------------------ //
// Get and Set Post Views //
// ------------------------------------------------ //
if (!function_exists('carspot_getPostViews')) {

    function carspot_getPostViews($postID = '')
    {
        $postID = esc_html($postID);
        $count_key = 'sb_post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if ($count == '') {
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
            return "0";
        }
        return $count;
    }

}
if (!function_exists('carspot_setPostViews')) {

    function carspot_setPostViews($postID = '')
    {
        $postID = esc_html($postID);
        $count_key = 'sb_post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if ($count == '') {
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        } else {
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }

}

// get post description as per need.
if (!function_exists('carspot_words_count')) {

    function carspot_words_count($contect = '', $limit = 180)
    {
        $string = '';
        $contents = strip_tags(strip_shortcodes($contect));
        $contents = carspot_removeURL($contents);
        $removeSpaces = str_replace(" ", "", $contents);
        $contents = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $contents);
        if (strlen($removeSpaces) > $limit) {
            return substr(str_replace("&nbsp;", "", $contents), 0, $limit) . '...';
        } else {
            return str_replace("&nbsp;", "", $contents);
        }
    }

}


if (!function_exists('carspot_required_attributes')) {

    function carspot_required_attributes()
    {
        return $default_attribs = array(
            'id' => array(),
            'src' => array(),
            'href' => array(),
            'target' => array(),
            'class' => array(),
            'title' => array(),
            'type' => array(),
            'style' => array(),
            'data' => array(),
            'role' => array(),
            'aria-haspopup' => array(),
            'aria-expanded' => array(),
            'data-toggle' => array(),
            'data-hover' => array(),
            'data-animations' => array(),
            'data-mce-id' => array(),
            'data-mce-style' => array(),
            'data-mce-bogus' => array(),
            'data-href' => array(),
            'data-tabs' => array(),
            'data-small-header' => array(),
            'data-adapt-container-width' => array(),
            'data-height' => array(),
            'data-hide-cover' => array(),
            'data-show-facepile' => array(),
        );
    }

}

if (!function_exists('carspot_required_tags')) {

    function carspot_required_tags()
    {
        return $allowed_tags = array(
            'div' => carspot_required_attributes(),
            'span' => carspot_required_attributes(),
            'p' => carspot_required_attributes(),
            'a' => array_merge(carspot_required_attributes(), array(
                'href' => array(),
                'target' => array('_blank', '_top'),
            )),
            'u' => carspot_required_attributes(),
            'br' => carspot_required_attributes(),
            'i' => carspot_required_attributes(),
            'q' => carspot_required_attributes(),
            'b' => carspot_required_attributes(),
            'ul' => carspot_required_attributes(),
            'ol' => carspot_required_attributes(),
            'li' => carspot_required_attributes(),
            'br' => carspot_required_attributes(),
            'hr' => carspot_required_attributes(),
            'strong' => carspot_required_attributes(),
            'blockquote' => carspot_required_attributes(),
            'del' => carspot_required_attributes(),
            'strike' => carspot_required_attributes(),
            'em' => carspot_required_attributes(),
            'code' => carspot_required_attributes(),
            'style' => carspot_required_attributes(),
            'script' => carspot_required_attributes(),
            'img' => carspot_required_attributes(),
        );
    }

}

// pages links
paginate_comments_links();
the_post_thumbnail();
// get feature image

if (!function_exists('carspot_get_feature_image')) {

    function carspot_get_feature_image($post_id = '', $image_size = '')
    {
        return wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $image_size);
    }

}

/* Add Next Page Button in First Row */
add_filter('mce_buttons', 'carspot_my_next_page_button', 1, 2); // 1st row
/**
 * Add Next Page/Page Break Button
 * in WordPress Visual Editor
 */
if (!function_exists('carspot_my_next_page_button')) {

    function carspot_my_next_page_button($buttons = '', $id = '')
    {

        /* only add this for content editor */
        if ('content' != $id)
            return $buttons;

        /* add next page after more tag button */
        array_splice($buttons, 13, 0, 'wp_page');

        return $buttons;
    }

}


// search only within posts.
if (!function_exists('carspot_search_filter')) {

    function carspot_search_filter($query = '')
    {

        if ($query->is_author) {
            $query->set('post_type', array('ad_post'));
        }

        return $query;
    }

}

if (!is_admin() && isset($_GET['type']) && $_GET['type'] == 'ads') {
    add_filter('pre_get_posts', 'carspot_search_filter');
}

// get post format icon
if (!function_exists('carspot_post_format_icon')) {

    function carspot_post_format_icon($format = '')
    {
        if ($format == "") {
            return 'ion-ios-star';
        }
        $format_icons = array('audio' => 'ion-volume-medium', 'video' => 'ion-videocamera', 'image' => 'ion-images', 'quote' => 'ion-quote');
        return $format_icons[$format];
    }

}

// get current page url
if (!function_exists('carspot_get_current_url')) {

    function carspot_get_current_url()
    {
        return $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

}


// return numbers array
if (!function_exists('carspot_addNumbers')) {

    function carspot_addNumbers($r = 20)
    {
        $numArr = '';
        for ($i = 1; $i <= $r; $i++) {
            $numArr[$i] = $i;
        }
        return $numArr;
    }

}

// check post format if exist
if (!function_exists('carspot_post_format_exist')) {

    function carspot_post_format_exist($format = '')
    {
        $formats = array('', 'image', 'audio', 'video', 'quote');
        if (in_array($format, $formats)) {
            return true;
        } else {
            return false;
        }
    }

}

if (!function_exists('carspot_get_cats')) {

    function carspot_get_cats($taxonomy = 'category', $parent_of = 0, $child_of = 0)
    {
        $defaults = array(
            'taxonomy' => $taxonomy,
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => 0,
            'exclude' => array(),
            'exclude_tree' => array(),
            'number' => '',
            'offset' => '',
            'fields' => 'all',
            'name' => '',
            'slug' => '',
            'hierarchical' => true,
            'search' => '',
            'name__like' => '',
            'description__like' => '',
            'pad_counts' => false,
            'get' => '',
            'child_of' => $child_of,
            'parent' => $parent_of,
            'childless' => false,
            'cache_domain' => 'core',
            'update_term_meta_cache' => true,
            'meta_query' => ''
        );
        $defaults = carspot_wpml_show_all_posts_callback($defaults);
        return get_terms($defaults);
    }

}

// Modifying search form
add_filter('get_search_form', 'carspot_search_form');
if (!function_exists('carspot_search_form')) {

    function carspot_search_form($text = '')
    {

        $text = str_replace('<label>', '<div class="search-blog"><div class="input-group stylish-input-group">', $text);
        $text = str_replace('</label>', '<span class="input-group-addon">
							<button type="submit"> <span class="fa fa-search"></span> </button>
												</span></div></div>', $text);
        $text = str_replace('<span class="screen-reader-text">Search for:</span>', '', $text);
        $text = str_replace('class="search-field"', 'class="form-control" id="serch"', $text);
        return $text;
    }

}
// remove url from excerpt
if (!function_exists('carspot_removeURL')) {

    function carspot_removeURL($string = '')
    {
        return preg_replace("/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i", '', $string);
    }

}

// Get param value of VC
if (!function_exists('carspot_get_param_vc')) {

    function carspot_get_param_vc($break = '', $string = '')
    {
        $arr = explode($break, $string);
        $res = explode(' ', $arr[1]);
        $r = explode('"', $res[0]);
        return $r[1];
    }

}

/*
 * Hook in on activation
 *
 */
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_action('init', 'carspot_woocommerce_image_dimensions', 1);
}
/**
 * Define image sizes
 */
if (!function_exists('carspot_woocommerce_image_dimensions')) {

    function carspot_woocommerce_image_dimensions()
    {
        $catalog = array(
            'width' => '358',
            'height' => '269',
            'crop' => 1,
        );

        $single = array(
            'width' => '396',
            'height' => '302',
            'crop' => 1,
        );

        $thumbnail = array(
            'width' => '100',
            'height' => '100',
            'crop' => 1,
        );

        // Image sizes
        update_option('shop_catalog_image_size', $catalog);
        update_option('shop_single_image_size', $single);
        update_option('shop_thumbnail_image_size', $thumbnail);
    }

}

// getting social icon array
if (!function_exists('carspot_social_icons')) {

    function carspot_social_icons($social_network = '')
    {
        $social_icons = array(
            'Facebook' => 'fa fa-facebook',
            'Twitter' => 'fa fa-twitter ',
            'Linkedin' => 'fa fa-linkedin ',
            'Google' => 'fa fa-google-plus',
            'YouTube' => 'fa fa-youtube-play',
            'Vimeo' => 'fa fa-vimeo ',
            'Pinterest' => 'fa fa-pinterest ',
            'Tumblr' => 'fa fa-tumblr ',
            'Instagram' => 'fa fa-instagram',
            'Reddit' => 'fa fa-reddit ',
            'Flickr' => 'fa fa-flickr ',
            'StumbleUpon' => 'fa fa-stumbleupon',
            'Delicious' => 'fa fa-delicious ',
            'dribble' => 'fa fa-dribbble ',
            'behance' => 'fa fa-behance',
            'DeviantART' => 'fa fa-deviantart',
        );
        return $social_icons[$social_network];
    }

}

add_filter('wp_list_categories', 'opportunies_cat_count_span');
if (!function_exists('opportunies_cat_count_span')) {

    function opportunies_cat_count_span($links = '')
    {
        $links = str_replace('</a> (', '</a> <span class="pull-right">(', $links);
        $links = str_replace(')', ')</span>', $links);
        return $links;
    }

}
if (!function_exists('carspot_sample_admin_notice_activate')) {

    function carspot_sample_admin_notice_activate()
    {
        if (get_option('_sb_purchase_code') != "") {
            return;
        }
        ?>
        <div class="notice notice-error is-dismissible">
            <h4><?php echo esc_html__('Attention!', 'carspot'); ?></h4>
            <p><?php echo esc_html__('Please Verify your PURCHASE code in order to work this theme.', 'carspot'); ?></p>
            <p>
                <?php echo esc_html__('Purchase Code:', 'carspot'); ?>
                <input type="text" name="carspot_code" id="carspot_code" size="50"/>
                <input type="button" id="verify_it" value="Verify"/>
            </p>
        </div>
        <?php
    }

}
add_action('admin_notices', 'carspot_sample_admin_notice_activate');

add_action('wp_ajax_verify_code', 'carspot_verify_code');
if (!function_exists('carspot_verify_code')) {

    function carspot_verify_code()
    {
        $code = $_POST['code'];
        $my_theme = wp_get_theme();
        $theme_name = $my_theme->get('Name');
        $data = "?purchase_code=" . $code . "&id=" . get_option('admin_email') . '&url=' . get_option('siteurl') . '&theme_name=' . $theme_name;
        $url = esc_url("http://authenticate.scriptsbundle.com/carspot/verify_code.php") . $data;
        $response = wp_remote_get($url);
        $res = $response['body'];
        if ($res == 'verified') {
            update_option('_sb_purchase_code', $code);
            echo('Looks good, now you can install required plugins.');
        } else {
            echo('Invalid valid purchase code.');
        }
        die();
    }

}
if (!function_exists('carspot_make_link')) {

    function carspot_make_link($url = '', $text = '')
    {
        return wp_kses("<a href='" . esc_url($url) . "' target='_blank'>", carspot_required_tags()) . $text . wp_kses('</a>', carspot_required_tags());
    }

}

// Translation
if (!function_exists('carspot_translate')) {

    function carspot_translate($index = '')
    {
        $strings = array(
            'variation_not_available' => esc_html__('This product is currently out of stock and unavailable.', 'carspot'),
            'adding_to_cart' => esc_html__('Adding...', 'carspot'),
            'add_to_cart' => esc_html__('add to cart', 'carspot'),
            'view_cart' => esc_html__('View Cart', 'carspot'),
            'cart_success_msg' => esc_html__('Product Added successfully.', 'carspot'),
            'cart_success' => esc_html__('Success', 'carspot'),
            'cart_error_msg' => esc_html__('Something went wrong, please try it again.', 'carspot'),
            'cart_error' => esc_html__('Error', 'carspot'),
            'email_error_msg' => esc_html__('Please add valid email.', 'carspot'),
            'mc_success_msg' => esc_html__('Thank you, we will get back to you.', 'carspot'),
            'mc_error_msg' => esc_html__('There is some error, please check your API-KEY and LIST-ID.', 'carspot'),
        );


        return $strings[$index];
    }

}
if (!function_exists('carspot_get_comments')) {

    function carspot_get_comments()
    {
        echo esc_html(get_comments_number()) . " " . esc_html__('comments', 'carspot');
    }

}
if (!function_exists('carspot_get_date')) {

    function carspot_get_date($PID = '')
    {
        echo esc_html(get_the_date(get_option('date_format'), $PID));
    }

}

if (isset($_GET['post_status']) && $_GET['post_status'] == 'trash' && $_GET['post_type'] == '_sb_country') {
    add_action('admin_notices', 'carspot_notice_for_delete_country');
}
if (!function_exists('carspot_notice_for_delete_country')) {

    function carspot_notice_for_delete_country()
    {
        ?>
        <div class="notice notice-info">
            <strong>
                <p><?php echo esc_html__('If you delete country permanently then all associated states and cities will be deleted with it.', 'carspot'); ?></p>
            </strong>
        </div>
        <?php
    }

}

if (isset($_GET['post_type'])) {
    if ($_GET['post_type'] == '_sb_country') {
        add_action('admin_notices', 'carspot_notice_for_add_country');
    }
}
if (!function_exists('carspot_notice_for_add_country')) {

    function carspot_notice_for_add_country()
    {
        ?>
        <div class="notice notice-info">
            <p><?php echo esc_html__('Must need to aad country NAME as google list like United Arab Emirates, check it', 'carspot'); ?>
                <a href="https://developers.google.com/public-data/docs/canonical/countries_csv" target="_blank">
                    <strong><?php echo esc_html__('HERE', 'carspot'); ?></strong>
                </a>
            </p>
        </div>
        <?php
    }

}
if (!function_exists('carspot_redirect')) {

    function carspot_redirect($url = '')
    {
        return '<script>window.location = "' . $url . '";</script>';
    }

}

add_action('init', 'carspot_StartSession', 1);
if (!function_exists('carspot_StartSession')) {

    function carspot_StartSession()
    {
        //if (!session_id()) {
        if (!headers_sent() && '' == session_id()) {
            session_start();
        }
    }

}

// Bad word filter
if (!function_exists('carspot_badwords_filter')) {

    function carspot_badwords_filter($words = array(), $string = '', $replacement = '')
    {
        foreach ($words as $word) {
            $string = str_replace($word, $replacement, $string);
        }
        return $string;
    }

}
// Post statuses
if (!function_exists('carspot_ad_statues')) {

    function carspot_ad_statues($index = '')
    {
        $sb_status = array('active' => esc_html__('Active', 'carspot'), 'expired' => esc_html__('Expired', 'carspot'), 'sold' => esc_html__('Sold', 'carspot'));
        return $sb_status[$index];
    }

}

// Time Ago
if (!function_exists('carspot_timeago')) {

    function carspot_timeago($date = '')
    {
        $timestamp = strtotime($date);

        $strTime = array(esc_html__('second', 'carspot'), esc_html__('minute', 'carspot'), esc_html__('hour', 'carspot'), esc_html__('day', 'carspot'), esc_html__('month', 'carspot'), esc_html__('year', 'carspot'));
        $length = array("60", "60", "24", "30", "12", "10");

        $currentTime = time();
        if ($currentTime >= $timestamp) {
            $diff = time() - $timestamp;
            for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
                $diff = $diff / $length[$i];
            }

            $diff = round($diff);
            return $diff . " " . $strTime[$i] . esc_html__('(s) ago', 'carspot');
        }
    }

}

// Redirect
if (!function_exists('carspot_redirect_with_msg')) {

    function carspot_redirect_with_msg($url = '', $msg = '')
    {

        echo '
	<script type="text/javascript" src="' . trailingslashit(get_template_directory_uri()) . 'js/toastr.min.js"></script>
	<script type="text/javascript">
			toastr.error("' . $msg . '", "", {timeOut: 5500,"closeButton": true, "positionClass": "toast-bottom-right"});
			window.location	=	"' . $url . '";
		</script>';
        exit;
    }

}

// Time difference n days
if (!function_exists('carspot_days_diff')) {

    function carspot_days_diff($now = '', $from = '')
    {
        $datediff = $now - $from;

        return floor($datediff / (60 * 60 * 24));
    }

}

// Color of Ads
if (!function_exists('carspot_ads_status_color')) {

    function carspot_ads_status_color($status = '')
    {
        $colors = array('active' => 'status_active', 'expired' => 'status_expired', 'sold' => 'status_sold');
        return isset($colors[$status]) ? $colors[$status] : '';
    }

}

// carspot search params
if (!function_exists('carspot_search_params')) {

    function carspot_search_params($index = '', $second = '', $third = '', $four = '')
    {
        $param = $_SERVER['QUERY_STRING'];
        $res = '';
        if (isset($param)) {
            parse_str($_SERVER['QUERY_STRING'], $vars);
            foreach ($vars as $key => $val) {
                if ($key == $index)
                    continue;
                if ($second != "") {
                    if ($key == $second)
                        continue;
                }
                if ($third != "") {
                    if ($key == $third)
                        continue;
                }
                if ($four != "") {
                    if ($key == $four)
                        continue;
                }
                if (isset($vars['custom']) && count($vars['custom']) > 0 && 'custom' == $key) {
                    foreach ($vars['custom'] as $ckey => $cval) {
                        $name = "custom[$ckey]";
                        if ($name == $index) {
                            continue;
                        }
                        $res .= '<input type="hidden" name="' . esc_attr($name) . '" value="' . esc_attr($cval) . '" />';
                    }
                } else {

                    if (isset($val) && !empty($val) && is_array($val)) {
                        foreach ($val as $keyy => $vall) {
                            $key_new = apply_filters('carspot_search_option_name', $key);
                            $res .= '<input type="hidden" name="' . esc_attr($key_new) . '" value="' . esc_attr($vall) . '" />';
                        }
                    } else {
                        $res .= '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($val) . '" />';
                    }
                }
            }
        }
        return $res;
    }

}

// Get parents of custom taxonomy
if (!function_exists('carspot_get_taxonomy_parents')) {

    function carspot_get_taxonomy_parents($id = '', $taxonomy = '', $link = true, $separator = ' &raquo; ', $nicename = false, $visited = array())
    {

        $chain = '';

        $parent = get_term($id, $taxonomy);

        if (is_wp_error($parent)) {
            echo "fail";
            return $parent;
        }

        if ($nicename) {
            $name = $parent->slug;
        } else {
            $name = $parent->name;
        }

        if ($parent->parent && ($parent->parent != $parent->term_id) && !in_array($parent->parent, $visited)) {

            $visited[] = $parent->parent;

            $chain .= carspot_get_taxonomy_parents($parent->parent, $taxonomy, $link, $separator, $nicename, $visited);
        }

        if ($link) {
            $chain .= '<a href="' . esc_url(get_term_link((int)$parent->term_id, $taxonomy)) . '" title="' . esc_attr(sprintf(esc_html__("View all posts in %s", 'carspot'), $parent->name)) . '">' . $name . '</a>' . $separator;
        } else {
            $chain .= $separator . $name;
        }
        return $chain;
    }

}

if (!function_exists('carspot_display_cats')) {

    function carspot_display_cats($pid = '')
    {
        global $carspot_theme;
        $type = '';
        $link = '';
        if (isset($carspot_theme['cat_and_location']) && $carspot_theme['cat_and_location'] != '') {
            $type = $carspot_theme['cat_and_location'];
            $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
            $cats_html = '';
            foreach ($post_categories as $c) {
                $cat = get_term($c);
                if ($type == 'search') {
                    $sb_search_page = cs_language_page_id_callback($carspot_theme['sb_search_page']);
                    $link = carspot_set_url_params_multi(get_the_permalink($sb_search_page), array('cat_id' => $cat->term_id));
                } else {
                    $link = get_correct_link_by_catID($cat->term_id);
                }
                $cats_html .= '<span class="padding_cats"><a href="' . $link . '">' . esc_html($cat->name) . '</a></span>';
            }
            return $cats_html;
        }
    }

}

if (!function_exists('carspot_display_adLocation')) {

    function carspot_display_adLocation($pid = '')
    {
        global $carspot_theme;
        $ad_country = '';
        $type = '';
        $type = $carspot_theme['cat_and_location'];
        $ad_country = wp_get_object_terms($pid, array('ad_country'), array('orderby' => 'term_group'));
        $all_locations = array();
        foreach ($ad_country as $ad_count) {
            $country_ads = get_term($ad_count);
            $item = array(
                'term_id' => $country_ads->term_id,
                'location' => $country_ads->name
            );
            $all_locations[] = $item;
        }
        $location_html = '';
        if (count($all_locations) > 0) {
            $limit = count($all_locations) - 1;
            for ($i = $limit; $i >= 0; $i--) {
                if ($type == 'search') {
                    $sb_search_page = cs_language_page_id_callback($carspot_theme['sb_search_page']);
                    $link = carspot_set_url_params_multi(get_the_permalink($sb_search_page), array('country_id' => $all_locations[$i]['term_id']));
                    $location_html .= '<a href="' . $link . '">' . esc_html($all_locations[$i]['location']) . '</a>, ';
                } else {
                    $loca_url = get_correct_link_by_catID($all_locations[$i]['term_id']);

                    $location_html .= '<a href="' . $loca_url . '">' . esc_html($all_locations[$i]['location']) . '</a>, ';
                }
            }
        }
        return rtrim($location_html, ', ');
    }

}

if (!function_exists('carspot_removeCPTCommentsFromWidget')) {

    function carspot_removeCPTCommentsFromWidget($example = '')
    {
        $ar = array('post_type' => 'post');
        return $ar;
    }

}

add_filter('widget_comments_args', 'carspot_removeCPTCommentsFromWidget');

//Allow Pending products to be viewed by listing/product owner
if (!function_exists('posts_for_current_author')) {

    function posts_for_current_author($query = '')
    {
        if (isset($_GET['post_type']) && $_GET['post_type'] == "ad_post" && isset($_GET['p'])) {
            $post_id = $_GET['p'];
            $post_author = get_post_field('post_author', $post_id);
            if (is_user_logged_in() && get_current_user_id() == $post_author) {
                $query->set('post_status', array('publish', 'pending'));
                return $query;
            } else {
                return $query;
            }
        } else {
            return $query;
        }
    }

}
add_filter('pre_get_posts', 'posts_for_current_author');

if (!function_exists('carspot_get_all_countries')) {

    function carspot_get_all_countries()
    {
        $args = array(
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'post_type' => '_sb_country',
            'post_status' => 'publish',
        );
        $countries = get_posts($args);
        $res = array();
        foreach ($countries as $country) {
            $res[$country->post_excerpt] = $country->post_title;
        }
        return $res;
    }

}

if (!function_exists('carspot_adPrice')) {

    function carspot_adPrice($id = '')
    {
        $price = 0;

        if (get_post_meta($id, '_carspot_ad_price_type', true) == "on_call") {
            return esc_html__("Price On Call", 'carspot');
        }
        if (get_post_meta($id, '_carspot_ad_price_type', true) == "free") {
            return esc_html__("Free", 'carspot');
        }
        if (get_post_meta($id, '_carspot_ad_price_type', true) == "no_price") {
            return '';
        }
        if (get_post_meta($id, '_carspot_ad_price', true) == "") {
            return '';
        }


        global $carspot_theme;
        $thousands_sep = ",";
        if (isset($carspot_theme['sb_price_separator'])) {
            $thousands_sep = $carspot_theme['sb_price_separator'];
        }
        $decimals = 0;
        if (isset($carspot_theme['sb_price_decimals'])) {
            $decimals = $carspot_theme['sb_price_decimals'];
        }
        $decimals_separator = ".";
        if (isset($carspot_theme['sb_price_decimals_separator'])) {
            $decimals_separator = $carspot_theme['sb_price_decimals_separator'];
        }
        if ($id != "") {
            $price = number_format(get_post_meta($id, '_carspot_ad_price', true), $decimals, $decimals_separator, $thousands_sep);
            $price = (isset($price) && $price != "") ? $price : 0;

            if (isset($carspot_theme['sb_price_direction']) && $carspot_theme['sb_price_direction'] == 'right') {
                $price = $price . $carspot_theme['sb_currency'];
            } else if (isset($carspot_theme['sb_price_direction']) && $carspot_theme['sb_price_direction'] == 'left') {
                $price = $carspot_theme['sb_currency'] . $price;
            } else {
                $price = $carspot_theme['sb_currency'] . $price;
            }
        }

        /* Price type fixed or ... */
        $price_type_html = '';
        $class = '';
        if (get_post_meta($id, '_carspot_ad_price_type', true) != "") {
            $price_type = get_post_meta($id, '_carspot_ad_price_type', true);
            if (get_post_meta($id, '_carspot_ad_price_type', true) == 'Fixed') {
                $price_type = esc_html__('Fixed', 'carspot');
            } else if (get_post_meta($id, '_carspot_ad_price_type', true) == 'Negotiable') {
                $price_type = esc_html__('Negotiable', 'carspot');
            } else if (get_post_meta($id, '_carspot_ad_price_type', true) == 'auction') {
                $price_type = esc_html__('auction', 'carspot');
            }
            $price_type_html = '<span class="' . esc_attr($class) . '"> (' . $price_type . ')</span>';
        }

        return $price . $price_type_html;
    }

}

if (!function_exists('carspot_get_static_form')) {

    function carspot_get_static_form($term_id = '', $post_id = '')
    {
        $html = '';
        $display_size = '';
        $price = '';
        $required = '';
        global $carspot_theme;
        $size_arr = explode('-', $carspot_theme['sb_upload_size']);
        $display_size = $size_arr[1];
        $actual_size = $size_arr[0];

        $vals[] = array(
            'type' => 'textfield',
            'post_meta' => '_carspot_ad_price',
            'is_show' => '_sb_default_cat_price_show',
            'is_req' => '_sb_default_cat_price_required',
            'main_title' => esc_html__('Price', 'carspot'),
            'sub_title' => $carspot_theme['sb_currency'] . " " . esc_html__('only', 'carspot'),
            'field_name' => 'ad_price',
            'field_id' => 'ad_price',
            'field_value' => $price,
            'field_req' => $required,
            'cat_name' => '',
            'field_class' => '',
            'columns' => '12',
            'data-parsley-type' => 'digits',
            'data-parsley-message' => esc_html__('Can\'t be empty and only integers allowed.', 'carspot'),
        );

        $vals[] = array(
            'type' => 'select_custom',
            'post_meta' => '_carspot_ad_price_type',
            'is_show' => '_sb_default_cat_price_type_show',
            'is_req' => '_sb_default_cat_price_type_required',
            'main_title' => esc_html__('Price Type', 'carspot'),
            'sub_title' => '',
            'field_name' => 'ad_price_type',
            'field_id' => 'ad_price_type',
            'field_value' => array("Fixed" => esc_html__('Fixed', 'carspot'), "Negotiable" => esc_html__('Negotiable', 'carspot'), "on_call" => esc_html__('Price on call', 'carspot'), "free" => esc_html__('Free', 'carspot'), "no_price" => esc_html__('No Price', 'carspot')),
            'field_req' => $required,
            'cat_name' => '',
            'field_class' => ' category ',
            'columns' => '12',
            'data-parsley-type' => '',
            'data-parsley-message' => esc_html__('This field is required.', 'carspot'),
        );


        $vals[] = array(
            'type' => 'textfield',
            'post_meta' => '_carspot_ad_yvideo',
            'is_show' => '_sb_default_cat_video_show',
            'is_req' => '_sb_default_cat_video_required',
            'main_title' => esc_html__('Youtube Video Link', 'carspot'),
            'sub_title' => '',
            'field_name' => 'ad_yvideo',
            'field_id' => 'ad_yvideo',
            'field_value' => '',
            'field_req' => $required,
            'cat_name' => '',
            'field_class' => '',
            'columns' => '12',
            'data-parsley-type' => 'url',
            'data-parsley-message' => esc_html__('This field is required.', 'carspot'),
        );


        $vals[] = array(
            'type' => 'image',
            'post_meta' => '',
            'is_show' => '_sb_default_cat_image_show',
            'is_req' => '_sb_default_cat_image_required',
            'main_title' => esc_html__('Click the box below to ad photos!', 'carspot'),
            'sub_title' => esc_html__('upload only jpg, png and jpeg files with a max file size of ', 'carspot') . $display_size,
            'field_name' => 'dropzone',
            'field_id' => 'dropzone',
            'field_value' => '',
            'field_req' => $required,
            'cat_name' => '',
            'field_class' => 'dropzone',
            'columns' => '12',
            'data-parsley-type' => '',
            'data-parsley-message' => esc_html__('This field is required.', 'carspot'),
        );


        $vals[] = array(
            'type' => 'textfield',
            'post_meta' => '',
            'is_show' => '_sb_default_cat_tags_show',
            'is_req' => '_sb_default_cat_tags_required',
            'main_title' => esc_html__('Tags', 'carspot'),
            'sub_title' => esc_html__('Comma(,) separated', 'carspot'),
            'field_name' => 'tags',
            'field_id' => 'tags',
            'field_value' => '',
            'field_req' => $required,
            'cat_name' => 'ad_tags',
            'field_class' => '',
            'columns' => '12',
            'data-parsley-type' => '',
            'data-parsley-message' => esc_html__('This field is required.', 'carspot'),
        );


        foreach ($vals as $val) {
            $type = $val['type'];
            $html .= carspot_return_input($type, $post_id, $term_id, $val);
        }

        return '<div class="row ">' . $html . '</div>';
    }

}

if (!function_exists('carspot_get_term_form')) {

    function carspot_get_term_form($term_id = '', $post_id = '', $formType = 'dynamic', $is_array = '')
    {
        global $carspot_theme;
        $data = ($formType == 'dynamic' && $term_id != "") ? sb_text_field_value($term_id) : sb_getTerms('custom');
        /* data have default fields for category */
        if ($is_array == 'arr')
            return $data;

        $dataHTML = '';
        foreach ($data as $d) {
            $name = $d['name'];
            $slug = $d['slug'];

            if (function_exists('carspot_string_translate')) {
                $name = carspot_string_translate($slug, $name);
            }
            if ($formType == 'static') {
                $showme = 1;
                if (isset($carspot_theme["allow_tax_condition"]) && $slug == 'ad_condition') {
                    $showme = $carspot_theme["allow_tax_condition"];
                }
                if (isset($carspot_theme["allow_tax_warranty"]) && $slug == 'ad_warranty') {
                    $showme = $carspot_theme["allow_tax_warranty"];
                }
                if (isset($carspot_theme["allow_ad_years"]) && $slug == 'ad_years') {
                    $showme = $carspot_theme["allow_ad_years"];
                }
                if (isset($carspot_theme["allow_ad_body_types"]) && $slug == 'ad_body_types') {
                    $showme = $carspot_theme["allow_ad_body_types"];
                }
                if (isset($carspot_theme["allow_ad_transmissions"]) && $slug == 'ad_transmissions') {
                    $showme = $carspot_theme["allow_ad_transmissions"];
                }
                if (isset($carspot_theme["allow_ad_engine_capacities"]) && $slug == 'ad_engine_capacities') {
                    $showme = $carspot_theme["allow_ad_engine_capacities"];
                }
                if (isset($carspot_theme["allow_ad_engine_types"]) && $slug == 'ad_engine_types') {
                    $showme = $carspot_theme["allow_ad_engine_types"];
                }
                if (isset($carspot_theme["allow_ad_assembles"]) && $slug == 'ad_assembles') {
                    $showme = $carspot_theme["allow_ad_assembles"];
                }
                if (isset($carspot_theme["allow_ad_colors"]) && $slug == 'ad_colors') {
                    $showme = $carspot_theme["allow_ad_colors"];
                }
                if (isset($carspot_theme["allow_ad_insurance"]) && $slug == 'ad_insurance') {
                    $showme = $carspot_theme["allow_ad_insurance"];
                }
                if (isset($carspot_theme["allow_ad_features"]) && $slug == 'ad_features') {
                    $showme = $carspot_theme["allow_ad_features"];
                }

                $is_show = $showme;
                $is_this_req = 1;
            } else {
                $is_show = $d['is_show'];

                $is_this_req = $d['is_req'];
            }

            $is_req = $is_this_req;
            $is_search = $d['is_search'];
            $is_type = $d['is_type'];
            $value_require = 'data-parsley-error-message="' . esc_html__('This value is required', 'carspot') . '"';
            $required = (isset($is_req) && $is_req == 1) ? ' required="required"' : '';
            if ($is_show == 1) {
                if ($is_type == 'textfield') {
                    $inputVal = get_post_meta($post_id, '_carspot_' . $slug, true);
                    $dataHTML .= '
				<div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
				<label class="control-label">' . ucfirst($name) . '</label>
				<input class="form-control" name="' . $slug . '" id="' . $slug . '" value="' . $inputVal . '" ' . $required . ' type="text" ' . $value_require . '/>
				</div>';
                } else if ($slug == 'ad_features') {
                    $required = '';
                    $adfeatures = '';
                    $frs = array();
                    $dataHTML .= '<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
						  <label class="control-label">' . $name . '</label>
						  <div class="skin-minimal"><ul class="list">';
                    $ad_features = carspot_get_cats('ad_features', 0);
                    $count = 1;
                    $adfeatures = get_post_meta($post_id, '_carspot_' . $slug, true);
                    if ($adfeatures != "") {
                        $frs = explode('|', $adfeatures);
                    }
                    foreach ($ad_features as $feature) {
                        $selected = (in_array($feature->name, $frs)) ? 'checked="checked"' : '';
                        $dataHTML .= '<li class="col-md-4 col-sm-6 col-xs-12 no-padding"><input tabindex="7" type="checkbox" id="minimal-radio-' . esc_attr($count) . '" name="ad_features[]" value="' . $feature->name . '"' . $selected . ' ' . $required . '><label  for="minimal-radio-' . esc_attr($count) . '">' . $feature->name . '</label></li>';

                        $count++;
                    }
                    $dataHTML .= '</ul></div></div>';
                } else {
                    if ($slug != 'ad_review_stamp') {
                        $values = carspot_get_cats($slug, 0);
                        if (!empty($values) && count((array)$values) > 0) {
                            $dataHTML .= '
						  <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6 margin-bottom-20">
						  <label class="control-label">' . $name . '</label><select  class="category form-control select-2" id="' . $slug . '" name="_carspot_' . $slug . '" ' . $required . ' data-parsley-error-message="' . esc_html__('This field is required', 'carspot') . ' ">
									<option value="">' . esc_html__('Select Option', 'carspot') . '</option>';
                            $adfeaturesName = get_post_meta($post_id, '_carspot_' . $slug, true);
                            foreach ($values as $val) {
                                if (isset($val->term_id) && $val->term_id != "") {
                                    $id = $val->term_id;
                                    $name = $val->name;
                                    $selected = ($adfeaturesName == $val->name) ? 'selected="selected"' : '';
                                    $dataHTML .= '<option value="' . $id . '|' . $name . '"' . $selected . '>' . $name . '</option>';
                                }
                            }
                            $dataHTML .= '</select></div>';
                        }
                    }
                }
            }
        }
        return '<div class="row ">' . $dataHTML . '</div>';
    }

}

/* Translate Strings that create
* issues in category template
*/
if (!function_exists('carspot_string_translate')) {
    function carspot_string_translate($trans_key_val = '', $trans_val2 = '')
    {

        $string_translate = array(
            'ad_mileage' => __('Mileage', 'carspot'),
            'ad_avg_city' => __('Average in City', 'carspot'),
            'ad_avg_hwy' => __('Average in Highway', 'carspot')
        );

        return array_key_exists($trans_key_val, $string_translate) ? $string_translate[$trans_key_val] : $trans_val2;
    }
}


/* Remove Extra Columns Starts */
if (!function_exists('carspot_ad_post_remove_columns')) {

    function carspot_ad_post_remove_columns($columns = '')
    {
        $arr = array("ad_condition", "ad_type", "ad_warranty", "ad_years", "ad_body_types", "ad_transmissions", "ad_engine_capacities", "d_engine_types", "ad_assembles", "ad_colors", "ad_insurance", "ad_features", "ad_engine_types");
        foreach ($arr as $r) {
            $column_remove = '';
            $column_remove = 'taxonomy-' . $r;
            unset($columns["$column_remove"]);
        }
        return $columns;
    }

}
add_filter('manage_edit-ad_post_columns', 'carspot_ad_post_remove_columns');
if (!function_exists('carspot_ad_reviews_remove_columns')) {

    function carspot_ad_reviews_remove_columns($columns = '')
    {
        unset($columns["taxonomy-custom_fields"]);
        unset($columns["taxonomy-verdict"]);
        return $columns;
    }

}
add_filter('manage_edit-reviews_columns', 'carspot_ad_reviews_remove_columns');
if (!function_exists('carspot_ad_comparison_remove_columns')) {

    function carspot_ad_comparison_remove_columns($columns = '')
    {
        unset($columns["taxonomy-comparison_by"]);
        return $columns;
    }

}
add_filter('manage_edit-comparison_columns', 'carspot_ad_comparison_remove_columns');
/* Remove Extra Columns Starts */

if (!function_exists('carspot_randomString')) {

    function carspot_randomString($length = 50)
    {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

}


add_filter('register_post_type_args', 'carspot_register_post_type_args', 10, 2);
if (!function_exists('carspot_register_post_type_args')) {

    function carspot_register_post_type_args($args = '', $post_type = '')
    {
        $carspot_theme_values = get_option('carspot_theme');

        if (isset($carspot_theme_values['sb_url_rewriting_enable']) && $carspot_theme_values['sb_url_rewriting_enable'] && isset($carspot_theme_values['sb_ad_slug']) && $carspot_theme_values['sb_ad_slug'] != "") {
            if ('ad_post' === $post_type) {
                $old_slug = 'ad';
                if (get_option('sb_ad_old_slug') != "") {
                    $old_slug = get_option('sb_ad_old_slug');
                }
                $args['rewrite']['slug'] = $carspot_theme_values['sb_ad_slug'];
                update_option('sb_ad_old_slug', $carspot_theme_values['sb_ad_slug']);
                if (($current_rules = get_option('rewrite_rules'))) {
                    foreach ($current_rules as $key => $val) {
                        if (strpos($key, $old_slug) !== false) {
                            add_rewrite_rule(str_ireplace($old_slug, $carspot_theme_values['sb_ad_slug'], $key), $val, 'top');
                        }
                    }
                    // ...and we flush the rules
                    flush_rewrite_rules();
                }
            }
        }
        return $args;
    }

}


add_action('wp_ajax_select_parent_make', 'carspot_get_parent_make');
add_action('wp_ajax_nopriv_select_parent_make', 'carspot_get_parent_make');
if (!function_exists('carspot_get_parent_make')) {

    function carspot_get_parent_make()
    {
        global $carspot_theme;
        $cat_id = $_POST['cat_id'];
        $ad_cats = carspot_get_cats('ad_cats', $cat_id);
        $res = '';
        if (count((array)$ad_cats) > 0) {
            $res .= '<option label="' . esc_html__('Select Option', 'carspot') . '"></option>';
            foreach ($ad_cats as $ad_cat) {
                $res .= '<option value=' . esc_attr($ad_cat->term_id) . '>' . esc_html($ad_cat->name) . '&nbsp;' . '(' . $ad_cat->count . ')' . '</option>';
            }
            echo($res);
        }
        die();
    }

}

if (!function_exists('carspot_returnEcho')) {

    function carspot_returnEcho($string = '')
    {
        return $string;
    }

}

if (!function_exists('carspot_static_strings')) {

    function carspot_static_strings()
    {
        global $carspot_theme;
        if (isset($carspot_theme['sb_default_lat']) && $carspot_theme['sb_default_lat'] && isset($carspot_theme['sb_default_long']) && $carspot_theme['sb_default_long']) {
            $pin_lat = $carspot_theme['sb_default_lat'];
            $pin_long = $carspot_theme['sb_default_long'];
        }
        $mapType = carspot_mapType();
        wp_localize_script(
            'carspot-custom', // name of js file
            'get_strings', array(
                'carspot_map_type' => $mapType,
                'one' => __('One Star', 'carspot'),
                'two' => __('Two Stars', 'carspot'),
                'three' => __('Three Stars', 'carspot'),
                'four' => __('Four Stars', 'carspot'),
                'five' => __('Five Stars', 'carspot'),
                'noStars' => __('Not Rated', 'carspot'),
                'Sunday' => __('Sunday', 'carspot'),
                'Monday' => __('Monday', 'carspot'),
                'Tuesday' => __('Tuesday', 'carspot'),
                'Wednesday' => __('Wednesday', 'carspot'),
                'Thursday' => __('Thursday', 'carspot'),
                'Friday' => __('Friday', 'carspot'),
                'Saturday' => __('Saturday', 'carspot'),
                'Sun' => __('Sun', 'carspot'),
                'Mon' => __('Mon', 'carspot'),
                'Tue' => __('Tue', 'carspot'),
                'Wed' => __('Wed', 'carspot'),
                'Thu' => __('Thu', 'carspot'),
                'Fri' => __('Fri', 'carspot'),
                'Sat' => __('Sat', 'carspot'),
                'Su' => __('Su', 'carspot'),
                'Mo' => __('Mo', 'carspot'),
                'Tu' => __('Tu', 'carspot'),
                'We' => __('We', 'carspot'),
                'Th' => __('Th', 'carspot'),
                'Fr' => __('Fr', 'carspot'),
                'Sa' => __('Sa', 'carspot'),
                'January' => __('January', 'carspot'),
                'February' => __('February', 'carspot'),
                'March' => __('March', 'carspot'),
                'April' => __('April', 'carspot'),
                'May' => __('May', 'carspot'),
                'June' => __('June', 'carspot'),
                'July' => __('July', 'carspot'),
                'August' => __('August', 'carspot'),
                'September' => __('September', 'carspot'),
                'October' => __('October', 'carspot'),
                'November' => __('November', 'carspot'),
                'December' => __('December', 'carspot'),
                'Jan' => __('Jan', 'carspot'),
                'Feb' => __('Feb', 'carspot'),
                'Mar' => __('Mar', 'carspot'),
                'Apr' => __('Apr', 'carspot'),
                'May' => __('May', 'carspot'),
                'Jun' => __('Jun', 'carspot'),
                'Jul' => __('July', 'carspot'),
                'Aug' => __('Aug', 'carspot'),
                'Sep' => __('Sep', 'carspot'),
                'Oct' => __('Oct', 'carspot'),
                'Nov' => __('Nov', 'carspot'),
                'Dec' => __('Dec', 'carspot'),
                'Today' => __('Today', 'carspot'),
                'Clear' => __('Clear', 'carspot'),
                'dateFormat' => __('dateFormat', 'carspot'),
                'timeFormat' => __('timeFormat', 'carspot'),
                'alt' => __('Confirm', 'carspot'),
                'altMsg' => __('Are you sure you want to do this?', 'carspot'),
                'acDelMsg' => __('Caution: your account will be deleted permanently?', 'carspot'),
                'showNumber' => __('Show number', 'carspot'),
                'addToCompare' => __('Added to compare list', 'carspot'),
                'alreadyToCompare' => __('Already added two cars', 'carspot'),
                'removeToCompare' => __('Removed from compare list', 'carspot'),
                'alertConfirm' => __('confirm', 'carspot'),
                'alertCancle' => __('cancel', 'carspot'),
            )
        );
    }

    add_action('wp_enqueue_scripts', 'carspot_static_strings', 100);
}


if (!function_exists('carspot_static_profile_strings')) {

    function carspot_static_profile_strings()
    {
        global $carspot_theme;
        $pin_lat = $pin_long = '';
        if (isset($carspot_theme['sb_default_lat']) && $carspot_theme['sb_default_lat'] && isset($carspot_theme['sb_default_long']) && $carspot_theme['sb_default_long']) {
            $pin_lat = $carspot_theme['sb_default_lat'];
            $pin_long = $carspot_theme['sb_default_long'];
        }
        $mapType = carspot_mapType();
        wp_localize_script(
            'carspot-profile', // name of js file
            'profile_strings', array(
                'carspot_map_type' => $mapType,
                'default_lat' => $pin_lat,
                'default_long' => $pin_long,
            )
        );
    }

    add_action('wp_enqueue_scripts', 'carspot_static_profile_strings', 100);
}


/* GET ALL DEALER REVIEW COUNT */

if (!function_exists('carspot_dealer_review_count')) {

    function carspot_dealer_review_count($author_id = '')
    {
        $new_reviews = '';
        $args = array(
            'user_id' => $author_id,
            'type' => 'dealer_review',
        );
        $total_reviews = count((array)get_comments($args));
        return $total_reviews;
    }

    add_action('wp_enqueue_scripts', 'carspot_dealer_review_count', 100);
}


if (!function_exists('review_pagination')) {

    function review_pagination($total_records = '', $current_page = '')
    {
        //$total_record.'' ;
        //$current_page.'b';
        // Check if a records is set.
        if (!isset($total_records))
            return;
        if (!isset($current_page))
            return;
        $next_text = esc_html__('Next Page »', 'carspot');
        $prev_text = esc_html__('« Previous Page', 'carspot');
        $args = array(
            'base' => add_query_arg('paged', '%#%'),
            'format' => '?paged=%#%',
            'total' => $total_records,
            'current' => $current_page,
            'show_all' => false,
            'end_size' => 1,
            'mid_size' => 2,
            'prev_next' => true,
            'prev_text' => $prev_text,
            'next_text' => $next_text,
            'type' => 'plain');
        return paginate_links($args);
    }

}
if (!function_exists('get_page_id')) {

    function get_page_id($page_name = '')
    {
        global $wpdb;
        $page_name = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '" . $page_name . "'");
        return $page_name;
    }

}

if (!function_exists('get_post_total_count')) {

    function get_post_total_count($user_id = '', $status = '', $featured = '')
    {
        $f_meta_value_key = '';
        $status_meta_value_key = '';
        if ($featured != "") {
            $f_meta_value_key = array(
                'key' => '_carspot_is_feature',
                'value' => '1',
                'compare' => '=',
            );
        }
        if ($status != "") {
            $status_meta_value_key = array(
                'key' => '_carspot_ad_status_',
                'value' => $status,
                'compare' => '=',
            );
        }
        $args = array(
            'author__in' => array($user_id),
            'post_type' => 'ad_post',
            'meta_query' => array(
                $status_meta_value_key,
                $f_meta_value_key,
            ),
            'post_status' => 'publish'
        );
        $args = carspot_wpml_show_all_posts_callback($args);
        $the_query = new WP_Query($args);
        $total_count = $the_query->found_posts;
        return $total_count;
    }

}

if (!function_exists('avg_user_rating')) {

    function avg_user_rating($user_id = '')
    {
        $total_ratings_count = carspot_dealer_review_count($user_id);
        $args = array(
            'user_id' => $user_id,
            'type' => 'dealer_review',
        );

        $get_rating = get_comments($args);
        if (count((array)$get_rating) > 0) {
            $avg_array = array();
            foreach ($get_rating as $get_ratings) {
                $comment_ids = $get_ratings->comment_ID;

                $service_stars = get_comment_meta($comment_ids, '_rating_service', true);
                $process_stars = get_comment_meta($comment_ids, '_rating_proces', true);
                $selection_stars = get_comment_meta($comment_ids, '_rating_selection', true);

                $single_avg = 0;
                $total_stars = $service_stars + $process_stars + $selection_stars;
                $single_avg = round($total_stars / "3", 1);


                $avg_array[] = $single_avg;
            }
            $total_sum = array_sum($avg_array);

            $total_avg = round($total_sum / $total_ratings_count, 1);
            //return $avg_array ;
            $html = '<ul class="review-stars">';
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $total_avg)
                    $html .= '<li class="star colored-star"><i class="fa fa-star"></i></li>';
                else
                    $html .= '<li class="star"><i class="fa fa-star"></i></li>';
            }
            $html .= '</ul>';
            return $html;
        }
    }

}


if (!function_exists('old_rating_importer')) {

    function old_rating_importer($user_id = '')
    {
        if (get_user_meta($user_id, '_is_old_rating_imported', true) != "yes") {
            $ratings = carspot_get_all_ratings($user_id);
            if (count((array)$ratings) > 0) {

                foreach ($ratings as $rating) {
                    $data = explode('_separator_', $rating->meta_value);
                    $rated = $data[0];
                    $comments = $data[1];
                    $date = $data[2];
                    $reply = '';
                    $reply_date = '';
                    if (isset($data[3])) {
                        $reply = $data[3];
                    }
                    if (isset($data[4])) {
                        $reply_date = $data[4];
                    }
                    $_arr = explode('_user_', $rating->meta_key);
                    $rator = $_arr[1];
                    $user = get_user_by('ID', $rator);

                    $flip_it = '';
                    if (is_rtl()) {
                        $flip_it = 'flip';
                    }

                    /* echo esc_attr( $user->display_name );
                      echo '<br>';
                      echo esc_attr( $user->user_email );
                      echo '<br>';
                      echo -$rated;
                      echo '<br>';
                      echo -$comments;
                      echo '<br>';
                      echo -$date;
                      echo '<br>';
                      echo -$reply.' reply';
                      echo '<br>';
                      echo -$reply_date.' reply date';
                      echo '<br>';
                      echo -$rator;
                      echo '<br>';
                      $time = current_time('mysql');

                      echo -$time; */

                    $data = array(
                        'comment_post_ID' => $rator,
                        'comment_author' => esc_attr($user->display_name),
                        'comment_author_email' => esc_attr($user->user_email),
                        'comment_author_url' => '',
                        'comment_content' => $comments,
                        'comment_type' => 'dealer_review',
                        'comment_parent' => 0,
                        'user_id' => $user_id,
                        'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
                        'comment_date' => $date,
                        'comment_approved' => 1,
                    );


                    $comment_id = wp_insert_comment($data);


                    update_comment_meta($comment_id, '_rating_service', $rated);
                    update_comment_meta($comment_id, '_rating_proces', $rated);
                    update_comment_meta($comment_id, '_rating_selection', $rated);
                    update_comment_meta($comment_id, '_rating_title', '');
                    update_comment_meta($comment_id, '_rating_recommand', '');
                    update_user_meta($user_id, '_is_rated_' . $rator, $rator);

                    update_user_meta($user_id, '_is_old_rating_imported', 'yes');

                    if ($reply != '') {
                        update_comment_meta($comment_id, '_rating_reply', $reply);
                    }
                }
            }
        }
    }

}

function pending_pots_meta_box()
{
    add_meta_box("pending-post-meta-box", __('Pending Post Message', 'carspot'), "pending_post_box_markup", "ad_post", "side", "core", null);
}

add_action("add_meta_boxes", "pending_pots_meta_box");

function pending_post_box_markup($object = '')
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");
    ?>
    <div>
        <label for="meta-box-text"><?php echo __('Reason to show user why its been pending ', 'carspot') ?></label>
        <textarea name="pending_post_msg" class="widefat"
                  rows="5"><?php echo esc_html(get_post_meta($object->ID, "pending_post_msg", true)); ?></textarea>
        <br>
    </div>
    <?php
}

function save_pending_pots_meta_box($post_id = '', $post = '', $update = '')
{
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if (!current_user_can("edit_post", $post_id))
        return $post_id;

    if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "ad_post";
    if ($slug != $post->post_type)
        return $post_id;

    $pending_post_msg_value = "";

    if (isset($_POST["pending_post_msg"])) {
        $pending_post_msg_value = sanitize_text_field($_POST["pending_post_msg"]);
    }
    update_post_meta($post_id, "pending_post_msg", $pending_post_msg_value);
}

add_action("save_post", "save_pending_pots_meta_box", 10, 3);


/* Fetch listing gallery */
if (!function_exists('carspot_fetch_listing_gallery')) {

    function carspot_fetch_listing_gallery($gall_id = '')
    {
        global $dwt_listing_options;
        $re_order = get_post_meta($gall_id, 'carspot_photo_arrangement_', true);
        if ($re_order != "") {
            return explode(',', $re_order);
        } else {
            global $wpdb;
            $query = "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND post_parent = '" . $gall_id . "'";
            $results = $wpdb->get_results($query, OBJECT);
            return $results;
        }
    }

}

/* fetch listing attach media from Dropzone */
if (!function_exists('carspot_fetch_listing_media')) {

    function carspot_fetch_listing_media($add_id = '', $saved_key = '')
    {
        $re_order = get_post_meta($add_id, $saved_key, true);
        if ($re_order != "") {
            return explode(',', $re_order);
        }
    }

}

/* == check ads is ending on ad-detail == */
if (!function_exists('cs_ads_check_expiry')) {

    function cs_ads_check_expiry($ad_id = '')
    {
        if ($ad_id == '') {
            return '';
        }
        global $carspot_theme;
        /* get post author */
        $author_id = get_post_field('post_author', $ad_id);
        /* exiry days in theme options */
        $expiry_days_option = $carspot_theme['cs_ads_expiry_days'];
        /* move to trash or in expirty tab */
        $trash_expiry = $carspot_theme['cs_expiry_ad_move_trash'];
        /* wp selected date format */
        $wp_date_format = get_option('date_format');
        /* get current psot date */
        $ad_date = (get_the_date('d-m-Y', $ad_id));
        $ad_date_str = strtotime($ad_date);
        if ($expiry_days_option != '-1') {
            /* date after add theme options days */
            //$total_days = strtotime(date("$wp_date_format", strtotime($ad_date . " + $expiry_days_option days")));
            $total_days = strtotime("+$expiry_days_option days", $ad_date_str);
            //$current_date = strtotime(date(get_option('date_format')));
            $current_date = strtotime(date('d-m-Y'));

            if ($current_date > $total_days) {
                if ($trash_expiry == "expire") {
                    $status = "expired";
                    update_post_meta($ad_id, '_carspot_ad_status_', $status);
                } else {
                    wp_trash_post($ad_id);
                }
                //send email when ad expired or trashed
//                if (function_exists('cs_email_notify_on_simple_ad_expire')) {
//                        cs_email_notify_on_simple_ad_expire($ad_id);
//                    }
            }
        }
    }

}

/*
 *allow some tags.
 */
if (!function_exists('carspot_get_formated_description')) {
    function carspot_get_formated_description($content = '')
    {
        $allow_tags = array(
            'br' => array(),
            'em' => array(),
            'strong' => array(),
            'ul' => carspot_required_attributes(),
            'ol' => carspot_required_attributes(),
            'p' => carspot_required_attributes(),
            'b' => array(),
            'i' => array(),
            'u' => array(),
            'li' => array(),
        );
        $string = wp_kses($content, $allow_tags);
        return nl2br($string);
    }
}
/* avoid echo $ */
if (!function_exists('carspot_returnEcho')) {

    function carspot_returnEcho($html = '') {
        return $html;
    }

}
add_filter('carspot_category_widget_form_action', 'carspot_category_widget_form_action', 10, 2);
if (!function_exists('carspot_category_widget_form_action')) {

    function carspot_category_widget_form_action($sb_search_page, $widget_action = '') {
        global $template, $wp;
        $page_template = basename($template);
        if ($page_template == 'taxonomy-ad_cats.php') {
            $sb_search_page = home_url($wp->request);
            if ($widget_action == 'cat_page') {
                $sb_search_page = 'javascript:void(0)';
            }
        }
        if ($page_template == 'taxonomy-ad_country.php') {
            $sb_search_page = home_url($wp->request);
            if ('location_page' == $widget_action) {
                $sb_search_page = 'javascript:void(0)';
            }
        }
        return $sb_search_page;
    }

}
if (!function_exists('carspot_cat_link_page')) {

    function carspot_cat_link_page($category_id, $type = '', $tax = 'cat_id') {
        global $carspot_theme;

        $sb_search_page = apply_filters('carspot_language_page_id', $carspot_theme['sb_search_page']);
        //$link = get_the_permalink($sb_search_page) . "?$tax=" . $category_id;
        $link = carspot_set_url_param(get_the_permalink($sb_search_page), $tax, $category_id);
        if ($type == 'category') {
            $link = get_term_link((int) $category_id);
        }
        return $link;
    }
}
/* set url params */
if (!function_exists('carspot_set_url_param')) {

    function carspot_set_url_param($carspot_url = '', $key = '', $value = '') {
        if ($carspot_url != '') {
            $carspot_url = add_query_arg(array($key => $value), $carspot_url);
            $carspot_url = apply_filters('carspot_page_lang_url', $carspot_url);
        }
        return $carspot_url;
    }

}
if (!function_exists('carspot_display_cats')) {

    function carspot_display_cats($pid, $class = "") {

        global $carspot_theme;
        $post_categories = wp_get_object_terms($pid, 'ad_cats');
        $cats_html = '';
        $cat_link_page     =    isset($carspot_theme['cat_and_location'])  ?  ($carspot_theme['cat_and_location'])  : 'search' ;

        foreach ($post_categories as $c) {
            $cat = get_term($c);
            $cats_html .= '<span class="padding_cats"><a href="' . carspot_cat_link_page($cat->term_id, $cat_link_page, 'cat_id') . '" class="' . $class . '">' . esc_html($cat->name) . '</a></span>';
        }
        return $cats_html;
    }
}
add_filter('carspot_filter_taxonomy_popup_actions', 'carspot_filter_taxonomy_popup_actions_callback', 10, 3);

if (!function_exists('carspot_filter_taxonomy_popup_actions_callback')) {

    function carspot_filter_taxonomy_popup_actions_callback($sb_search_page, $tax_id = '', $tax_name = 'ad_cats') {
        global $template, $wp;
        $page_template = basename($template);

        if ($page_template == 'taxonomy-ad_cats.php' && $tax_name == 'ad_cats') {
            if (isset($tax_id) && $tax_id != '') {
                $sb_search_page = get_term_link($tax_id, $tax_name);
            }
        }

        if ($page_template == 'taxonomy-ad_country.php' && $tax_name == 'ad_country') {
            if (isset($tax_id) && $tax_id != '') {
                $sb_search_page = get_term_link($tax_id, $tax_name);
            }
        }

        return $sb_search_page;
    }

}

if (!function_exists('carspot_validateDateFormat')) {

    function carspot_validateDateFormat($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

}