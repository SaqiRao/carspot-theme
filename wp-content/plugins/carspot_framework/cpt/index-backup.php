<?php
// Register post  type and taxonomy
add_action('init', 'sb_themes_custom_types', 0);

function sb_themes_custom_types() {
    // Register Post type for Map Countries
    $args = array(
        'public' => true,
        'menu_icon' => 'dashicons-location',
        'label' => __('Map Countries', 'redux-framework'),
        'supports' => array('thumbnail', 'title')
    );
    register_post_type('_sb_country', $args);
    //Register Post type
    $args = array(
        'public' => true,
        'label' => __('Classified Ads', 'redux-framework'),
        'supports' => array('title', 'editor'),
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'has_archive' => true,
        'rewrite' => array('with_front' => false, 'slug' => 'ad')
    );
    register_post_type('ad_post', $args);

    function custom_event_permalink($post_link, $id = 0, $leavename) {
        if (strpos('%ad%', $post_link) === 'FALSE') {
            return $post_link;
        }
        $post = get_post($id);
        if (is_wp_error($post) || $post->post_type != 'ad_post') {
            return $post_link;
        }
        return str_replace('ad', 'ad/' . $post->ID, $post_link);
    }

    //Ads Cats
    register_taxonomy('ad_cats', array('ad_post'), array(
        'hierarchical' => true,
        'show_ui' => true,
        'label' => __('Categories', 'redux-framework'),
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_category'),
    ));
    //Ads tags
    register_taxonomy('ad_tags', array('ad_post'), array(
        'hierarchical' => true,
        'label' => __('Tags', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_tag'),
    ));
    //Ads Condition
    register_taxonomy('ad_condition', array('ad_post'), array(
        'hierarchical' => true,
        'label' => __('Condition', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_consition'),
        'meta_box_cb' => false,
    ));
    //Ads Type
    register_taxonomy('ad_type', array('ad_post'), array(
        'hierarchical' => true,
        'label' => __('Type', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_type'),
    ));
    //Ads warranty
    register_taxonomy('ad_warranty', array('ad_post'), array(
        'hierarchical' => true,
        'label' => __('Warranty', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_warranty'),
    ));
    //Ads Years
    register_taxonomy('ad_years', array('ad_post'), array(
        'hierarchical' => true,
        'label' => __('Year', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_year'),
        'meta_box_cb' => false,
    ));
    //Ads Body type
    register_taxonomy('ad_body_types', array('ad_post'), array(
        'hierarchical' => true,
        'label' => __('Body Type', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_body_type'),
        'meta_box_cb' => false,
    ));
    //Ads Transmission
    register_taxonomy('ad_transmissions', array('ad_post'), array(
        'hierarchical' => true,
        'label' => __('Transmission', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_transmission'),
        'meta_box_cb' => false,
    ));
    //Ads Engine Capacity
    register_taxonomy('ad_engine_capacities', array('ad_post'), array(
        'hierarchical' => true,
        'label' => __('Engine Size', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_engine_capacity'),
        'meta_box_cb' => false,
    ));
    //Ads Engine Type
    register_taxonomy('ad_engine_types', array('ad_post'), array(
        'hierarchical' => true,
        'label' => __('Engine Type', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_engine_type'),
        'meta_box_cb' => false,
    ));
    //Ads Assemble
    register_taxonomy('ad_assembles', array('ad_post'), array(
        'hierarchical' => true,
        'label' => __('Assembly', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_assemble'),
        'meta_box_cb' => false,
    ));
    //Ads Colors Family
    register_taxonomy('ad_colors', array('ad_post'), array(
        'hierarchical' => true,
        'label' => __('Color', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_color'),
        'meta_box_cb' => false,
    ));
    //Ads Insurance 
    register_taxonomy('ad_insurance', array('ad_post'), array(
        'hierarchical' => true,
        'label' => __('Insurance', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_insurance'),
        'meta_box_cb' => false,
    ));
    //Ads Features 
    register_taxonomy('ad_features', array('ad_post'), array(
        'hierarchical' => true,
        'label' => __('Features', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_feature'),
        'meta_box_cb' => false,
    ));
    //Ads Country
    register_taxonomy('ad_country', array('ad_post'), array(
        'hierarchical' => true,
        'show_ui' => true,
        'label' => __('Countries', 'redux-framework'),
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_country'),
        'meta_box_cb' => false,
    ));
}

/*  Saving Metabox data  */
add_action('save_post', 'sb_themes_meta_save_country');

function sb_themes_meta_save_country($post_id) {
    
}

// Add the fields to the "ad_cats" taxonomy, using our callback function  
add_action('ad_cats_edit_form_fields', 'ad_cats_taxonomy_custom_fields', 10, 2);

// A callback function to add a custom field to our "ad_cats" taxonomy  
function ad_cats_taxonomy_custom_fields($tag) {
    // Check for existing taxonomy meta for the term you're editing 
    $t_id = $term_meta = '';
    $t_id = $tag->term_id; // Get the ID of the term you're editing  
    $term_meta = get_option("taxonomy_term_$t_id"); // Do the check  
    if ($term_meta['ad_cat_icon'] != '') {
        $icon_val = $term_meta['ad_cat_icon'];
    } else {
        $icon_val = '';
    }
    ?>  

    <tr class="form-field">  
        <th scope="row" valign="top">  
            <label for="ad_cat_icon"><?php echo __('Icon Name', 'redux-framework'); ?></label>  
        </th>  
        <td>  
            <input type="text" name="term_meta[ad_cat_icon]" id="term_meta[ad_cat_icon]" size="25" style="width:60%;" value="<?php echo $icon_val; ?>"><br />  
            <span class="description">
                <a href="http://carspot.scriptsbundle.com/theme-icons/" target="_blank"><?php echo __('Check icons list.', 'redux-framework'); ?></a>
            </span>  
        </td>  
    </tr>  
    <?php
}

// Save the changes made on the "ad_cats" taxonomy, using our callback function  
add_action('edited_ad_cats', 'ad_cats_save_taxonomy_custom_fields', 10, 2);

// A callback function to save our extra taxonomy field(s)  
function ad_cats_save_taxonomy_custom_fields($term_id) {
    if (isset($_POST['term_meta'])) {
        $t_id = $term_id;
        $term_meta = get_option("taxonomy_term_$t_id");
        $cat_keys = array_keys($_POST['term_meta']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['term_meta'][$key])) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        //save the option array  
        update_option("taxonomy_term_$t_id", $term_meta);
    }
}

//// For Features
// Add the fields to the "ad_features" taxonomy, using our callback function  
add_action('ad_features_edit_form_fields', 'ad_features_taxonomy_custom_fields', 10, 2);

// A callback function to add a custom field to our "ad_cats" taxonomy  
function ad_features_taxonomy_custom_fields($tag) {
    // Check for existing taxonomy meta for the term you're editing  
    $t_id = $tag->term_id; // Get the ID of the term you're editing  
    $term_meta = get_option("taxonomy_term_$t_id"); // Do the check  
    if ($term_meta['ad_feature_icon'] != '') {
        $ad_feature_icon = $term_meta['ad_feature_icon'];
    } else {
        $ad_feature_icon = '';
    }
    ?>  
    <tr class="form-field">  
        <th scope="row" valign="top">  
            <label for="ad_feature_icon"><?php echo __('Icon Name', 'redux-framework'); ?></label>  
        </th>
        <td> 
            <input type="text" name="term_meta[ad_feature_icon]" id="term_meta[ad_feature_icon]" size="25" style="width:60%;" value="<?php echo $ad_feature_icon; ?>"><br />  
            <span class="description">
                <a href="http://carspot.scriptsbundle.com/theme-icons/" target="_blank"><?php echo __('Check icons list.', 'redux-framework'); ?></a>
            </span>  
        </td>  
    </tr>  
    <?php
}

// Save the changes made on the "ad_cats" taxonomy, using our callback function  
add_action('edited_ad_features', 'ad_features_save_taxonomy_custom_fields', 10, 2);

// A callback function to save our extra taxonomy field(s)  
function ad_features_save_taxonomy_custom_fields($term_id) {
    if (isset($_POST['term_meta'])) {
        $t_id = $term_id;
        $term_meta = get_option("taxonomy_term_$t_id");
        $cat_keys = array_keys($_POST['term_meta']);
        foreach ($cat_keys as $key) {
            if (isset($_POST['term_meta'][$key])) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        //save the option array  
        update_option("taxonomy_term_$t_id", $term_meta);
    }
}

add_action('admin_footer', 'loading_div_callback');

function loading_div_callback() {
    ?><div class="loading" id="sb_loading"><?php esc_html__('Loading', 'redux-framework'); ?>&#8230;</div><?php
}

// Register metaboxes for Country CPT
add_action('add_meta_boxes', 'sb_meta_box_for_countryss');

function sb_meta_box_for_countryss() {
    add_meta_box('sb_metabox_for_countryss', 'County', 'sb_render_meta_countryss', '_sb_country', 'normal', 'high');
}

function sb_render_meta_countryss($post) {
    // We'll use this nonce field later on when saving.
    wp_nonce_field('my_meta_box_nonce_countryss', 'meta_box_nonce_countryss');
    ?>
    <div class="margin_top">
        <input type="text" name="country_county" class="project_meta" placeholder="<?php echo esc_attr__('County', 'redux-framework'); ?>" size="30" value="<?php echo esc_attr(get_the_excerpt($post->ID)); ?>" id="country_county" spellcheck="true" autocomplete="off">
        <p><?php echo __('This should be follow ISO2 like', 'redux-framework'); ?> <strong><?php echo __('US', 'redux-framework'); ?></strong> <?php echo __('for USA and', 'redux-framework'); ?> <strong><?php echo __('CA', 'redux-framework'); ?></strong> <?php echo __('for Canada', 'redux-framework'); ?>, <a href="http://data.okfn.org/data/core/country-list" target="_blank"><?php echo __('Read More.', 'redux-framework'); ?></a></p>
    </div>

    <?php
}

// Saving Metabox data 
add_action('save_post', 'sb_themes_meta_save_countryss');

function sb_themes_meta_save_countryss($post_id) {
    // Bail if we're doing an auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    // if our current user can't edit this post, bail
    if (!current_user_can('edit_posts', $post_id))
        return;

    // Make sure your data is set before trying to save it
    if (isset($_POST['country_county'])) {
        //update_post_meta( $post_id, '_sb_country_county', $_POST['country_county'] );
        $my_post = array(
            'ID' => $post_id,
            'post_excerpt' => $_POST['country_county'],
        );
        global $wpdb;
        $county = $_POST['country_county'];
        $wpdb->query("UPDATE $wpdb->posts SET post_excerpt = '$county' WHERE ID = '$post_id'");
    }
}