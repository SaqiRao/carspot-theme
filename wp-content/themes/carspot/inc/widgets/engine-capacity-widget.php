<?php
/* Engine Type Capacity */
add_action('widgets_init', function () {
    register_widget('carspot_search_ad_engine_engine_capacity');
});
if (!class_exists('carspot_search_ad_engine_engine_capacity')) {

    class carspot_search_ad_engine_engine_capacity extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_search_ad_engine_engine_capacity',
                'description' => esc_html__('Only for search and single ad sidebar.', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Ad Engine Capacity ', 'carspot'), $widget_ops);
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
            $is_show = carspot_getTemplateID('taxconomy', 'ad_engine_capacities');
            if ($is_show == '' || $is_show == 1) {
            } else {
                return;
            }
            $expand = "";

            if (isset($_GET['engine_capacity']) && $_GET['engine_capacity'] != "") {
                $expand = "in";
            }
            ?>
            <div class="panel panel-default" id="red-engine-capacity">
                <!-- Heading -->
                <div class="panel-heading" role="tab" id="engince-capacity">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#engine_capacity" aria-expanded="true" aria-controls="engince-capacity">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            <?php echo $title; ?>
                        </a>
                    </h4>
                </div>
                <!-- Content -->
                <form method="get"
                      action="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>#red-engine-capacity">

                    <?php
                    $ad_engine_capacities = carspot_get_cats('ad_engine_capacities', 0);
                    if (is_array($ad_engine_capacities) && count($ad_engine_capacities) > 0) {
                        $field_name = 'engine_capacity';
                        $field_name = apply_filters('carspot_search_option_name', $field_name);
                        ?>
                        <div id="engine_capacity" class="panel-collapse collapse <?php echo esc_attr($expand); ?>"
                             role="tabpanel" aria-labelledby="engince-capacity">
                            <div class="panel-body">
                                <div class="skin-minimal">
                                    <ul class="list">
                                        <?php
                                        foreach ($ad_engine_capacities as $ad_engine_capacity) {
                                            ?>
                                            <li>
                                                <input type="<?php do_action('carsport_search_option_type'); ?>"
                                                       id="engine-capacity-<?php echo esc_attr($ad_engine_capacity->term_id); ?>"
                                                       value="<?php echo esc_attr($ad_engine_capacity->name); ?>" <?php
                                                do_action('carsport_search_option_checked', 'engine_capacity', $ad_engine_capacity->name);
                                                ?> name="<?php echo esc_attr($field_name); ?>">
                                                <label for="engine-capacity-<?php echo esc_attr($ad_engine_capacity->term_id); ?>"><?php echo esc_html($ad_engine_capacity->name); ?><?php echo esc_html($carspot_theme['sb_power_unit']); ?></label>
                                                <?php do_action('carsport_search_category_count', '_carspot_ad_engine_capacities', $ad_engine_capacity->name); ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    echo carspot_search_params('engine_capacity');
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
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = esc_html__('Ad Engine Capacity', 'carspot');
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