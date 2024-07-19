<?php
add_action('init', 'register_cpt_reviews', 0);
//Reviews CPT
function register_cpt_reviews()
{
    $labels = array(
        'name' => esc_html__('Reviews', 'redux-framework'),
        'singular_name' => esc_html__('reviews', 'redux-framework'),
        'add_new' => esc_html__('Add New', 'redux-framework'),
        'add_new_item' => esc_html__('Add New reviews', 'redux-framework'),
        'edit_item' => esc_html__('Edit reviews', 'redux-framework'),
        'new_item' => esc_html__('New reviews', 'redux-framework'),
        'menu_icon' => 'dashicons-dashboard',
        'view_item' => esc_html__('View reviews', 'redux-framework'),
        'search_items' => esc_html__('Search Reviews', 'redux-framework'),
        'not_found' => esc_html__('No reviews found', 'redux-framework'),
        'not_found_in_trash' => esc_html__('No reviews found in Trash', 'redux-framework'),
        'parent_item_colon' => esc_html__('Parent reviews:', 'redux-framework'),
        'menu_name' => esc_html__('Reviews', 'redux-framework'),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'supports' => array('title', 'post-formats', 'content', 'excerpt', 'editor', 'thumbnail'),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => true,
        'can_export' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
    );

    register_post_type('reviews', $args);


    //Reviews Categories
    register_taxonomy('reviews_cats', array('reviews'), array(
        'hierarchical' => true,
        'show_ui' => true,
        'label' => esc_html__('Categories', 'redux-framework'),
        'show_admin_column' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'rewrite' => true,
    ));

    //Reviews Brands
    register_taxonomy('reviews_brands', array('reviews'), array(
        'hierarchical' => true,
        'show_ui' => true,
        'label' => esc_html__('Review Brands', 'redux-framework'),
        'show_admin_column' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'rewrite' => true,
    ));

    //Custom Fields For Feature
    register_taxonomy('custom_fields', array('reviews'), array(
        'hierarchical' => false,
        'tax_position' => true,
        'show_ui' => true,
        'label' => esc_html__('Custom Fields', 'redux-framework'),
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => true,
    ));

    //Verdicts
    register_taxonomy('verdict', array('reviews'), array(
        'hierarchical' => false,
        'tax_position' => true,
        'show_ui' => true,
        'label' => esc_html__('Verdict', 'redux-framework'),
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => true,
    ));

}

//Pro Cons Tabs Html
function carspot_procons()
{
    $tab_heading = '';
    $tab_heading_2 = '';
    $tab_heading_3 = '';
    $tab_heading_4 = '';
    global $post;
    $custom = get_post_custom($post->ID);
    $tab_heading = isset($custom["tab_heading"][0]) ? $custom["tab_heading"][0] : '';
    $tab_heading_2 = isset($custom["tab_heading_2"][0]) ? $custom["tab_heading_2"][0] : '';

    ?>

    <ul id="tabs">
        <li class="active"><?php echo esc_html__('Pro', 'redux-framework'); ?></li>
        <li><?php echo esc_html__('Cons', 'redux-framework'); ?></li>

    </ul>
    <ul id="tab">
        <li class="active">

            <p><label><?php echo esc_html__('Tab Heading:', 'redux-framework'); ?></label><br/>
                <input type="text" size="103" value="<?php echo esc_attr($tab_heading); ?>" name="tab_heading"></p>

            <?php
            $field_value1 = get_post_meta($post->ID, 'tab_desc_1', false);
            $desc1 = isset($field_value1[0]) ? $field_value1[0] : '';
            wp_editor($desc1, 'tab_desc_1');
            ?>
        </li>
        <li>
            <p><label><?php echo esc_html__('Tab Heading:', 'redux-framework'); ?></label><br/>
                <input type="text" size="103" value="<?php echo esc_attr($tab_heading_2); ?>" name="tab_heading_2"></p>
            <?php
            $field_value2 = get_post_meta($post->ID, 'tab_desc_2', false);
            $desc2 = isset($field_value2[0]) ? $field_value2[0] : '';
            wp_editor($desc2, 'tab_desc_2');
            ?>
        </li>
    </ul>
    <style type="text/css">
        ul#tabs {
            list-style-type: none;
            padding: 0;
            text-align: left;
        }

        ul#tabs li {
            display: inline-block;
            background-color: #32c896;
            border-bottom: solid 5px #238b68;
            padding: 5px 20px;
            margin-bottom: 4px;
            color: #fff;
            cursor: pointer;
        }

        ul#tabs li:hover {
            background-color: #238b68;
        }

        ul#tabs li.active {
            background-color: #238b68;
        }

        ul#tab {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        ul#tab li {
            display: none;
        }

        ul#tab li.active {
            display: block;
        }
    </style>

    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery("ul#tabs li").click(function (e) {
                if (!jQuery(this).hasClass("active")) {
                    var tabNum = jQuery(this).index();
                    var nthChild = tabNum + 1;
                    jQuery("ul#tabs li.active").removeClass("active");
                    jQuery(this).addClass("active");
                    jQuery("ul#tab li.active").removeClass("active");
                    jQuery("ul#tab li:nth-child(" + nthChild + ")").addClass("active");
                }
            });
        });
    </script>
    <?php
}

//Pro Cons Data Save
function carspot_procons_save()
{

    global $post;

    $tab_heading = $_POST["tab_heading"];
    update_post_meta($post->ID, "tab_heading", $tab_heading);

    $tab_heading_2 = $_POST["tab_heading_2"];
    update_post_meta($post->ID, "tab_heading_2", $tab_heading_2);

    $tab_desc_1 = $_POST["tab_desc_1"];
    update_post_meta($post->ID, "tab_desc_1", $tab_desc_1);
    $tab_desc_2 = $_POST["tab_desc_2"];
    update_post_meta($post->ID, "tab_desc_2", $tab_desc_2);
}

add_action('save_post_reviews', 'carspot_procons_save');

function carspot_youtube_link()
{
    $youtube_video = '';
    global $post;
    $custom = get_post_custom($post->ID);
    $youtube_video = isset($custom["youtube_video"][0]) ? $custom["youtube_video"][0] : '';

    ?>
    <label><?php echo esc_html__('Video ID:', 'redux-framework'); ?></label>
    <input name="youtube_video" value="<?php echo($youtube_video); ?>"/>
    <?php
}

function carspot_youtube_save()
{
    global $post;

    if (isset($_POST["youtube_video"])) {
        $youtube_video = $_POST["youtube_video"];
        update_post_meta($post->ID, "youtube_video", $youtube_video);
    }
}

add_action('save_post_reviews', 'carspot_youtube_save');
//Display Meta
function carspot_admin_init()
{
    add_meta_box("procons_tabs", "Pro & Cons Information", "carspot_procons", "reviews", "normal", "low");
    add_meta_box("youtube_video", "Youtube Video ID", "carspot_youtube_link", "reviews", "side", "low");
}

add_action("admin_init", "carspot_admin_init");

//Review Rating
class carspot_reviewRating
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
            'review_rating',
            esc_html__('Review Rating', 'redux-framework'),
            array($this, 'render_metabox'),
            'reviews',
            'side',
            'default'
        );
    }

    public function render_metabox($post)
    {
        // Retrieve an existing value from the database.
        $review_rating = get_post_meta($post->ID, 'review_rating', true);
        // Set default values.
        if (empty($review_rating)) $review_rating = '';
        // Form fields.
        echo '<table class="form-table">';
        echo '	<tr>';
        echo '		<th><label for="review_rating" class="review_rating_label">' . esc_html__('Rating', 'redux-framework') . '</label></th>';
        echo '		<td>';
        echo '			<select id="review_rating" name="review_rating" class="review_rating_field">';
        echo '			<option value="1" ' . selected($review_rating, '1', false) . '> ' . esc_html__('1 Star', 'redux-framework');
        echo '			<option value="2" ' . selected($review_rating, '2', false) . '> ' . esc_html__('2 Star', 'redux-framework');
        echo '			<option value="3" ' . selected($review_rating, '3', false) . '> ' . esc_html__('3 Star', 'redux-framework');
        echo '			<option value="4" ' . selected($review_rating, '4', false) . '> ' . esc_html__('4 Star', 'redux-framework');
        echo '			<option value="5" ' . selected($review_rating, '5', false) . '> ' . esc_html__('5 Star', 'redux-framework');
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
        $new_rating = isset($_POST['review_rating']) ? $_POST['review_rating'] : '';

        // Update the meta field in the database.
        update_post_meta($post_id, 'review_rating', $new_rating);
    }
}

new carspot_reviewRating;
//Custom Fields
$taxonomyName = "custom_fields"; // [category, tag, your_custom_taxonomy_name]
add_action($taxonomyName . '_add_form_fields', 'add_custom_tax_field_oncreate');
add_action($taxonomyName . '_edit_form_fields', 'add_custom_tax_field_onedit');

function add_custom_tax_field_oncreate($term)
{
    $taxonomyName = "custom_fields";
    echo " 
    <table class='form-table'>
      <tbody>    
		<tr class='form-field term-parent-wrap'>
		 <th scope='row'><label for='custom_term_status'>" . esc_html__('Status', 'redux-framework') . "</label></th>
		  <td>
                <select name='custom_term_status' id='custom_term_status' class='postform'>
                	<option value='active'>" . esc_html('Active', 'redux-framework') . "</option>
                    <option value='inactive'>" . esc_html('In Active', 'redux-framework') . "</option>
                </select>
             </td>
		</tr>
	   </tbody>
	 </table>    
	";
}

function add_custom_tax_field_onedit($term)
{

    $taxonomyName = "custom_fields";

    $termID = $term->term_id;
    $termMeta = get_option("$taxonomyName_$termID");
    $customfield = $termMeta['custom_term_status'];
    $active_selected = '';
    $inactive_selected = '';

    if ($customfield == "active") {
        $active_selected = 'selected="selected"';
    }
    if ($customfield == "inactive") {
        $inactive_selected = 'selected="selected"';
    }
    echo "   
    <table class='form-table'>
      <tbody>    
		<tr class='form-field term-parent-wrap'>
		 <th scope='row'><label for='custom_term_status'>Status</label></th>
		  <td>
                <select name='custom_term_status' id='custom_term_status' class='postform'>
                	<option value='active' $inactive_selected >Active</option>
                    <option value='inactive' $inactive_selected >Inactive</option>
                </select>
             </td>
		</tr>
	   </tbody>
	 </table>    
	";
}

function startfreshfinance_save_custom_tax_field($termID)
{
    $taxonomyName = "custom_fields";

    if (isset($_POST['custom_term_status'])) {
        $termMeta = get_option("$taxonomyName_$termID");
        if (!is_array($termMeta)) {
            $termMeta = array();
        }
        $termMeta['custom_term_status'] = isset($_POST['custom_term_status']) ? $_POST['custom_term_status'] : '';
        update_option("$taxonomyName_$termID", $termMeta);
    }
}

$taxonomyName = "custom_fields";
add_action("create_$taxonomyName", 'startfreshfinance_save_custom_tax_field');
add_action("edited_$taxonomyName", 'startfreshfinance_save_custom_tax_field');

//Custom Fields Meta Box
class Car_Info_Meta_Box
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
            'car_info',
            esc_html__('Car Info Custom Fields', 'redux-framework'),
            array($this, 'render_metabox'),
            'reviews',
            'advanced',
            'default'
        );
    }

    public function render_metabox($post)
    {

        $terms = get_terms('custom_fields', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC'));
        // Form fields.
        echo '<table class="form-table">';
        foreach ($terms as $term) {

            $inputName = 'carspot_review_features[' . $term->slug . ']';
            $val = get_post_meta($post->ID, 'car_features_' . $term->slug, true);
            echo '<tr><th>' . esc_attr($term->name) . '</th>
			<td>
			<input type="text" id="car_features_' . $term->slug . '" name="' . $inputName . '" class="car_field" placeholder="' . esc_attr('', 'redux-framework') . '" value="' . esc_html($val) . '">';
            '</td>';
        }
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
        if (isset($_POST['carspot_review_features'])) {
            $data = ($_POST['carspot_review_features']);
            foreach ($data as $key => $d) {
                $value = sanitize_text_field($d);
                update_post_meta($post_id, 'car_features_' . $key, $value);
            }
        }
    }
}

new Car_Info_Meta_Box;

//Custom Fields Meta Box
class Car_verdict_Meta_Box
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
            'car_verdict',
            esc_html__('Expert verdict', 'redux-framework'),
            array($this, 'render_metabox'),
            'reviews',
            'advanced',
            'default'
        );
    }

    public function render_metabox($post)
    {

        $verdict_sunnmry = get_post_meta($post->ID, 'verdict_sunnmry', true);
        $verdict_title = get_post_meta($post->ID, 'verdict_title', true);
        // Set default values.
        if (empty($verdict_sunnmry)) $verdict_sunnmry = '';
        if (empty($verdict_title)) $verdict_title = '';
        //categories
        $terms = get_terms('verdict', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC'));
        // Form fields.
        echo '<table class="form-table">';

        echo '	<tr>
		<th><label>' . esc_html__('Your Main Tagline Here', 'redux-framework') . '</label></th>
		<td>
		<input type="text" id="verdict_title" name="verdict_title" class="car_name_field" " value="' . esc_html__($verdict_title) . '">
		<p class="description">' . esc_html__('Fore example(The CarSpot expert verdict)', 'redux-framework') . '</p>
		</td>
		</tr>';

        foreach ($terms as $term) {

            $inputName = 'carspot_verdict_[' . $term->slug . ']';

            $val = get_post_meta($post->ID, 'car_verdict_' . $term->slug, true);

            echo '<tr><th>' . esc_attr($term->name) . '</th>
			<td>
			<input type="text" id="car_verdict_' . $term->slug . '" name="' . $inputName . '" class="car_field" value="' . esc_html($val) . '">';
            echo '<p class="description">' . esc_html__('Only Numeric Value eg (70).', 'redux-framework') . '</p>';
            echo '</td>';
        }
        echo '<tr>
		<th><label for="car_name" class="car_name_label">' . esc_html__('Final Summary Verdict', 'redux-framework') . '</label></th>
	    <td>
		<textarea id="verdict_sunnmry" name="verdict_sunnmry" class="widefat" cols="50" rows="6">' . esc_attr($verdict_sunnmry) . '</textarea>
		<p class="description">' . esc_html__('Final Summary about that review.', 'redux-framework') . '</p>
		</td></tr></table>';

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
        if (isset($_POST['carspot_verdict_']) && $_POST['carspot_verdict_'] != '') {
            $verdict_data = ($_POST['carspot_verdict_']);
            foreach ($verdict_data as $keys => $val) {
                //if($val != '')
                //{
                $value = sanitize_text_field($val);
                update_post_meta($post_id, 'car_verdict_' . $keys, $value);
                //}
            }
            // Sanitize user input.
            $main_title = isset($_POST['verdict_title']) ? sanitize_text_field($_POST['verdict_title']) : '';
            $summary = isset($_POST['verdict_sunnmry']) ? sanitize_text_field($_POST['verdict_sunnmry']) : '';
            update_post_meta($post_id, 'verdict_title', $main_title);
            update_post_meta($post_id, 'verdict_sunnmry', $summary);
        }
    }

}
new Car_verdict_Meta_Box;