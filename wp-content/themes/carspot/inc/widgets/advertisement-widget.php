<?php
/* Advertisement  Widget */
add_action('widgets_init', function () {
    register_widget('carspot_search_advertisement');
});
if (!class_exists('carspot_search_advertisement')) {

    class carspot_search_advertisement extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_search_advertisement',
                'description' => esc_html__('Only for search and single ad sidebar.', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Advertisement', 'carspot'), $widget_ops);
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
            $ad_code = $instance['ad_code'];
            ?>

            <div class="panel panel-default">
                <!-- Heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a>
                            <?php echo $title; ?>
                        </a>
                    </h4>
                </div>
                <!-- Content -->
                <div class="panel-collapse">
                    <div class="panel-body recent-ads">
                        <?php echo "" . $ad_code; ?>
                    </div>
                </div>
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
                $title = esc_html__('Advertisement', 'carspot');
            }
            $ad_code = '';
            if (isset($instance['ad_code'])) {
                $ad_code = $instance['ad_code'];
            }
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                    <?php echo esc_html__('300 X 250 Ad', 'carspot'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text"
                       value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('ad_code')); ?>">
                    <?php echo esc_html__('Code:', 'carspot'); ?>
                </label>
                <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('ad_code')); ?>"
                          name="<?php echo esc_attr($this->get_field_name('ad_code')); ?>"
                          type="text"><?php echo esc_attr($ad_code); ?></textarea>
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
            $instance['ad_code'] = (!empty($new_instance['ad_code'])) ? $new_instance['ad_code'] : '';
            return $instance;
        }

    }

}