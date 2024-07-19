<?php
/* Custom Dynamic Widgets */
add_action('widgets_init', function () {
    register_widget('carspot_search_custom_fields');
});
if (!class_exists('carspot_search_custom_fields')) {

    class carspot_search_custom_fields extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_search_custom_fields',
                'description' => esc_html__('Only for search and single ad sidebar.', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Custom Fields Search', 'carspot'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         * @see WP_Widget::widget()
         *
         */
        public function widget($args, $instance)
        {
            global $carspot_theme;
            extract($args);
            $title = apply_filters('widget_title', $instance['title']);
            $ad_code = isset($instance['ad_code']) ? $instance['ad_code'] : '';

            ?>
            <?php
            $term_id = '';
            $customHTML = '';
            if (isset($_GET['cat_id']) && $_GET['cat_id'] != "" && is_numeric($_GET['cat_id'])) {
                $term_id = $_GET['cat_id'];
                $result = carspot_dynamic_templateID($term_id);
                //$result =  carspot_dynamic_templateID($cat_id);
                $templateID = get_term_meta($result, '_sb_dynamic_form_fields', true);

                if (isset($templateID) && $templateID != "") {
                    $formData = sb_dynamic_form_data($templateID);
                    $customHTML .= '';
                    if (is_array($formData) && !empty($formData)) {
                        foreach ($formData as $r) {
                            if (isset($r['types']) && trim($r['types']) != "") {

                                if (isset($r['types']) && $r['types'] == 5) {
                                    continue;
                                }

                                $in_search = (isset($r['in_search']) && $r['in_search'] == "yes") ? 1 : 0;
                                if ($r['titles'] != "" && $r['slugs'] != "" && $in_search == 1) {

                                    $customHTML .= '<div class="panel panel-default" id="red-types">
  <div class="panel-heading" >
     <h4 class="panel-title"><a>' . $title . ' ' . esc_html__($r['titles'], 'carspot') . '</a></h4>
  </div>
  <div class="panel-collapse">
     <div class="panel-body recent-ads">
	 	<div class="skin-minimal">
			<form method="get" action="' . get_the_permalink($carspot_theme['sb_search_page']) . '#red-types" class="custom-search-form">';
                                    $fieldName = "custom[" . esc_attr($r['slugs']) . "]";
                                    $fieldValue = isset($_GET["custom"]) ? @$_GET['custom'][esc_attr($r['slugs'])] : '';
                                    if (isset($r['types']) && $r['types'] == 1) {
                                        $customHTML .= '<div class="search-widget"><input placeholder="' . esc_attr($r['titles']) . '" name="' . $fieldName . '" value="' . $fieldValue . '" type="text"><button type="submit"><i class="fa fa-search"></i></button></div>';
                                    }
                                    if (isset($r['types']) && $r['types'] == 2) {
                                        $options = '';
                                        if (isset($r['values']) && $r['values'] != 1) {
                                            $varArrs = @explode("|", $r['values']);
                                            $options .= '<option value="0">' . esc_html__("Select Option", "carspot") . '</option>';
                                            foreach ($varArrs as $varArr) {
                                                $selected = ($fieldValue == $varArr) ? 'selected="selected"' : '';
                                                $options .= '<option value="' . esc_attr($varArr) . '" ' . $selected . '>' . esc_html($varArr) . '</option>';
                                            }
                                        }
                                        $customHTML .= '<select name="' . $fieldName . '" class="custom-search-select" >' . $options . '</select>';
                                    }
                                    if (isset($r['types']) && $r['types'] == 3) {
                                        $options = '';
                                        if (isset($r['values']) && $r['values'] != "") {
                                            $varArrs = @explode("|", $r['values']);

                                            $loop = 1;
                                            if (count($varArrs) > 0) {
                                                $options = '<select name="' . $fieldName . '" class="submit_on_select"><option></option>';
                                            }
                                            foreach ($varArrs as $val) {

                                                $checked = '';
                                                if (isset($fieldValue) && $fieldValue != "") {
                                                    //$checked = in_array($val, $fieldValue) ? 'checked="checked"' : '';
                                                    $checked = ($val == $fieldValue) ? 'selected="selected"' : '';
                                                }

                                                $options .= '<option value="' . $val . '"' . $checked . '>' . esc_html($val) . '</option>';
                                                $loop++;
                                            }
                                            $options .= '</select>';
                                        }
                                        //$customHTML .= '<select name="'.$fieldName.'" class="custom-search-select" >'.$options.'</select>';
                                        $customHTML .= '<div class="skin-minimal"><ul class="list">' . $options . '</ul></div>';
                                    }
                                    if (isset($r['types']) && $r['types'] == 4) {
                                        $customHTML .= '<div class="search-widget"><input placeholder="' . esc_attr($r['titles']) . '" name="' . $fieldName . '" value="' . $fieldValue . '" type="text" class="dynamic-form-date-fields"><button type="submit" onclick="return false;"><i class="fa fa-calendar"></i></button></div>';
                                    }

                                    /* if(isset($r['types'] ) && $r['types'] == 5){ This is for website URL When Required} */

                                    $customHTML .= carspot_search_params($fieldName);
                                    $customHTML .= '</form></div></div></div></div> ';
                                }
                            }
                        }
                    }
                }
            }
            echo "" . $customHTML;

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