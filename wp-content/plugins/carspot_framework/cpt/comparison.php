<?php
// Register post  type and taxonomy
add_action('init', 'carspot_theme_custom_types', 0);
function carspot_theme_custom_types()
{
    //comparison Post type
    $args = array(
        'public' => true,
        'label' => __('Comparison', 'redux-framework'),
        'supports' => array('title'),
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'has_archive' => true,
        'rewrite' => array('with_front' => false, 'slug' => 'comparison'),
        'supports' => array('title', 'thumbnail'),
    );
    register_post_type('comparison', $args);
    //Ads Cats
    register_taxonomy('comparison_by', array('comparison'), array(
        'hierarchical' => true,
        'tax_position' => true,
        'show_ui' => true,
        'label' => __('Categories', 'redux-framework'),
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'comparison_by'),
    ));
}

/* Term Meta */
function carspot_add_template_to_cat()
{
    $term_id = isset($_GET['tag_ID']) ? $_GET['tag_ID'] : '';
    $result = get_term_meta($term_id, '_carspot_comparison_field_type', true);
    $selected = ($result == 0) ? 'selected="selected"' : '';
    $selected1 = ($result == 1) ? 'selected="selected"' : '';
    ?>

    <tr class="form-field term-parent-wrap">
        <th scope="row"><label for="parent"><?php _e('Select Field Type', 'redux-framework'); ?></label></th>
        <td>
            <select name="carspot_comparison_field_type">
                <option value="0" <?php echo($selected); ?>><?php echo __('Input', 'redux-framework'); ?></option>
                <option value="1" <?php echo($selected1); ?>><?php echo __('Select', 'redux-framework'); ?></option>

            </select>
            <p class="description"><?php echo __('some description', 'redux-framework'); ?></p>
            <br/></td>
    </tr>

    <?php
}

add_action('comparison_by_add_form_fields', 'carspot_add_template_to_cat', 10, 2);
add_action('comparison_by_edit_form_fields', 'carspot_add_template_to_cat', 10, 2);
/* Asign template to category */
function carspot_assign_template_to_comparison($term_id)
{
    if (isset($_POST)) {
        $type = ($_POST['carspot_comparison_field_type']);
        if ($type != "") {
            update_term_meta($term_id, '_carspot_comparison_field_type', $type);
        }
    }
}

add_action('create_comparison_by', 'carspot_assign_template_to_comparison');
add_action('edit_comparison_by', 'carspot_assign_template_to_comparison');

//Custom Fields Meta Box
class carspot_compariosn_fields
{
    public function __construct()
    {
        if (is_admin()) {
            add_action('load-post.php', array($this, 'init_metabox'));
            add_action('load-post-new.php', array($this, 'init_metabox'));
        }
    }

    public function init_metabox()
    {
        add_action('add_meta_boxes', array($this, 'add_metabox'));
        add_action('save_post', array($this, 'save_metabox'), 10, 2);

    }

    public function add_metabox()
    {
        add_meta_box(
            'comparison_fields',
            __('Compariosn Fields', 'redux-framework'),
            array($this, 'render_metabox'),
            'comparison',
            'advanced',
            'default'
        );
    }

    public function render_metabox($post)
    {
        $taxonomies = array('comparison_by',);
        $args = array(
            'orderby' => 'id',
            'order' => 'ASC',
            'hide_empty' => false,
            'fields' => 'all',
            'parent' => 0,
            'hierarchical' => true,
            'child_of' => 0,
            'pad_counts' => false,
        );
        $terms = get_terms($taxonomies, $args);
        ?>
        <style>
            ul.tree, ul.tree ul {
                list-style: none;
                margin: 0;
                padding: 0;
            }

            ul.tree ul {
                margin-left: 10px;
            }

            ul.tree li {
                margin: 0;
                padding: 10px 7px;
                font-size: 16px;
                line-height: 20px;
                color: #000;
                border-left: 1px solid rgb(100, 100, 100);

            }

            ul.tree li span {
                width: 30%;
            }

            ul.tree li:last-child {
                border-left: none;
            }

            ul.tree li:before {
                position: relative;
                top: -0.3em;
                height: 1em;
                width: 12px;
                color: white;
                border-bottom: 1px solid rgb(100, 100, 100);
                content: "";
                display: inline-block;
                left: -7px;
            }
            ul.tree li:last-child:before {
                border-left: 1px solid rgb(100, 100, 100);
            }
        </style>
        <?php
        echo '<ul class="tree">';
        foreach ($terms as $term) {
            echo '<li>' . esc_attr($term->name) . '';
            $subterms = get_terms($taxonomies, array(
                'parent' => $term->term_id,
                'hide_empty' => false,
                'orderby' => 'id',
                'order' => 'ASC',
            ));
            foreach ($subterms as $subterm) {
                $inputName = 'car_comparison_list[' . $subterm->slug . ']';
                //echo '    -  ' . $subterm->slug;
                $val = get_post_meta($post->ID, 'car_comparison_' . $subterm->slug, true);
                $type = get_term_meta($subterm->term_id, '_carspot_comparison_field_type', true);
                if ($type == 1) {
                    $selected = ($val == 1) ? 'selected="selected"' : '';
                    $selected1 = ($val != 1) ? 'selected="selected"' : '';
                    $fieldHtml = '<select id="car_comparison_' . $subterm->slug . '" name="' . $inputName . '" >
				   <option value="1" ' . $selected . '>' . __('Yes', 'redux-framework') . '</option>
				   <option value="0" ' . $selected1 . '>' . __('No', 'redux-framework') . '</option></select>';
                } else {
                    $fieldHtml = '<label><input type="text" id="car_comparison_' . $subterm->slug . '" name="' . $inputName . '" class="widefats" placeholder="' . esc_attr__('', 'redux-framework') . '" value="' . esc_html($val) . '"></label>';
                }
                echo '<ul><li><span>' . esc_attr($subterm->name) . '</span>:' . $fieldHtml . '</li></ul>';
            }
        }
        echo '</li></ul>';
    }

    public function save_metabox($post_id, $post)
    {
        global $carspot_theme;
        /* Check if the user has permissions to save data. */
        if (!current_user_can('edit_posts', $post_id))
            return;

        /* Check if it's not an autosave.*/
        if (wp_is_post_autosave($post_id))
            return;

        /* Check if it's not a revision.*/
        if (wp_is_post_revision($post_id))
            return;
        /* Sanitize user input. */
        if (isset($_POST['car_comparison_list'])) {
            $data = ($_POST['car_comparison_list']);
            foreach ($data as $key => $d) {
                $value = sanitize_text_field($d);
                update_post_meta($post_id, 'car_comparison_' . $key, $value);
            }
        }

        if (in_array('sitepress-multilingual-cms/sitepress.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            $cs_duplicate_posts = false;
            $cs_theme_option = get_option('carspot_theme');
            if (class_exists('Redux')) {
                $cs_duplicate_posts = $cs_theme_option['cs_duplicate_post'];
            }
            if ($cs_duplicate_posts) {
                post_duplicate_on_publish_test($post_id);
            }
        }
    }
}

new carspot_compariosn_fields;

//Review Rating
class carspot_comparisonRating
{
    public function __construct()
    {
        if (is_admin()) {
            add_action('load-post.php', array($this, 'init_metabox'));
            add_action('load-post-new.php', array($this, 'init_metabox'));
        }
    }

    public function init_metabox()
    {
        add_action('add_meta_boxes', array($this, 'add_metabox'));
        add_action('save_post', array($this, 'save_metabox'), 10, 2);
    }

    public function add_metabox()
    {
        add_meta_box(
            'comparison_rating',
            __('Review Rating', 'redux-framework'),
            array($this, 'render_metabox'),
            'comparison',
            'side',
            'default'
        );
    }

    public function render_metabox($post)
    {
        // Retrieve an existing value from the database.
        $review_rating = get_post_meta($post->ID, 'comparison_rating', true);
        // Set default values.
        if (empty($review_rating)) $review_rating = '';

        // Form fields.
        echo '<table class="form-table">';
        echo '	<tr>';
        echo '		<th><label for="review_rating" class="review_rating_label">' . __('Rating', 'redux-framework') . '</label></th>';
        echo '		<td>';
        echo '			<select id="review_rating" name="comparison_rating" class="review_rating_field">';
        echo '			<option value="1" ' . selected($review_rating, '1', false) . '> ' . __('1 Star', 'redux-framework');
        echo '			<option value="2" ' . selected($review_rating, '2', false) . '> ' . __('2 Star', 'redux-framework');
        echo '			<option value="3" ' . selected($review_rating, '3', false) . '> ' . __('3 Star', 'redux-framework');
        echo '			<option value="4" ' . selected($review_rating, '4', false) . '> ' . __('4 Star', 'redux-framework');
        echo '			<option value="5" ' . selected($review_rating, '5', false) . '> ' . __('5 Star', 'redux-framework');
        echo '			</select>';
        echo '		</td>';
        echo '	</tr>';
        echo '</table>';

    }

    public function save_metabox($post_id, $post)
    {
        // Check if the user has permissions to save data.
        if (!current_user_can('edit_posts', $post_id))
            return;
        // Check if it's not an autosave.
        if (wp_is_post_autosave($post_id))
            return;
        // Check if it's not a revision.
        if (wp_is_post_revision($post_id))
            return;
        // Sanitize user input.
        $new_rating = isset($_POST['comparison_rating']) ? $_POST['comparison_rating'] : '';
        // Update the meta field in the database.
        update_post_meta($post_id, 'comparison_rating', $new_rating);
    }
}
new carspot_comparisonRating;