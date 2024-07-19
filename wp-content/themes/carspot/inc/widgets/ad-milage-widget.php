<?php
/* Millage */
add_action('widgets_init', function () {
    register_widget('carspot_search_ad_mileage');
});
if (!class_exists('carspot_search_ad_mileage')) {

    class carspot_search_ad_mileage extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_search_ad_mileage',
                'description' => esc_html__('Only for search and single ad sidebar.', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Ad Mileage (Km)', 'carspot'), $widget_ops);
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
            $is_show = carspot_getTemplateID('taxconomy', 'ad_mileage');
            if ($is_show == '' || $is_show == 1) {
            } else {
                return;
            }
            $mileage = '';
            $milage_from = '';
            $mileage_to = '';
            $expand = "";
            if (isset($_GET['mileage_from']) && $_GET['mileage_from'] != "") {
                $milage_from = $_GET['mileage_from'];
            }
            if (isset($_GET['mileage_to']) && $_GET['mileage_to'] != "") {
                $mileage_to = $_GET['mileage_to'];
            }
            if ($milage_from != '' && $mileage_to != '') {
                $expand = "in";
            }

            ?>
            <div class="panel panel-default" id="red-milage">
                <!-- Heading -->
                <div class="panel-heading" role="tab" id="ad-mileage">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#mileage" aria-expanded="true" aria-controls="ad-mileage">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            <?php echo $title; ?>
                        </a>
                    </h4>
                </div>
                <!-- Content -->
                <form method="get" id="get_mileage"
                      action="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>#red-milage">
                    <div id="mileage" class="panel-collapse collapse <?php echo esc_attr($expand); ?>" role="tabpanel"
                         aria-labelledby="ad-mileage">
                        <div class="panel-body">
                            <div class="input-group margin-top-10">
                                <input type="text" class="form-control" name="mileage_from" data-parsley-type="digits"
                                       data-parsley-required="true"
                                       data-parsley-error-message="<?php echo esc_html__('Value should be numeric', 'carspot'); ?>"
                                       placeholder="<?php echo esc_html__("From", "carspot") ?>" id="mileage_from"
                                       value="<?php echo esc_attr($milage_from); ?>"/>
                                <span class="input-group-addon">-</span>
                                <input type="text" class="form-control" data-parsley-required="true"
                                       data-parsley-type="digits"
                                       data-parsley-error-message="<?php echo esc_html__('Value should be numeric', 'carspot'); ?>"
                                       placeholder="<?php echo esc_html__("To", "carspot") ?>" name="mileage_to"
                                       id="mileage_to" value="<?php echo esc_attr($mileage_to); ?>"/>

                            </div>

                            <input type="submit" class="btn btn-theme btn-sm margin-top-10"
                                   value="<?php echo esc_html__('Search', 'carspot'); ?>"/>
                        </div>
                    </div>

                    <?php echo carspot_search_params('mileage_from', 'mileage_to'); ?>
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
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Ad Mileage (Km)', 'carspot');
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('Title:', 'carspot'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                       value="<?php echo esc_attr($title); ?>">
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