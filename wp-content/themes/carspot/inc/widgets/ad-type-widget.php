<?php
/* Ad type Widget */
add_action('widgets_init', function () {
    register_widget('carspot_search_ad_type');
});
if (!class_exists('carspot_search_ad_type')) {

    class carspot_search_ad_type extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_search_ad_type',
                'description' => esc_html__('Only for search and single ad sidebar.', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Ad Type', 'carspot'), $widget_ops);
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
            $expand = "";
            $is_show = carspot_getTemplateID('taxconomy', 'ad_type');
            if ($is_show == '' || $is_show == 1) {
            } else {
                return;
            }
            if (isset($_GET['ad_type']) && $_GET['ad_type'] != "") {
                $expand = "in";
            }
            ?>
            <div class="panel panel-default" id="red-ad-type">
                <!-- Heading -->
                <div class="panel-heading" role="tab" id="headingSeven">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            <?php echo $title; ?>
                        </a>
                    </h4>
                </div>
                <!-- Content -->
                <form method="get"
                      action="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>#red-ad-type">
                    <?php
                    $conditions = carspot_get_cats('ad_type', 0);
                    if (is_array($conditions) && count((array)$conditions) > 0) {
                        $field_name = 'ad_type';
                        $field_name = apply_filters('carspot_search_option_name', $field_name);
                        ?>
                        <div id="collapseSeven" class="panel-collapse collapse <?php echo esc_attr($expand); ?>"
                             role="tabpanel" aria-labelledby="headingSeven">
                            <div class="panel-body">
                                <div class="skin-minimal">
                                    <ul class="list">
                                        <?php
                                        foreach ($conditions as $con) {
                                            ?>
                                            <li>
                                                <input tabindex="7"
                                                       type="<?php do_action('carsport_search_option_type'); ?>"
                                                       id="minimal-radio-<?php echo esc_attr($con->term_id); ?>"
                                                       name="<?php echo esc_attr($field_name); ?>"
                                                       value="<?php echo esc_attr($con->name); ?>" <?php
                                                do_action('carsport_search_option_checked', 'ad_type', $con->name);
                                                ?> >
                                                <label for="minimal-radio-<?php echo esc_attr($con->term_id); ?>"><?php echo esc_html($con->name); ?></label>
                                                <?php do_action('carsport_search_category_count', '_carspot_ad_type', $con->name); ?>
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
                    echo carspot_search_params('ad_type');
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
                $title = esc_html__('Ad Type', 'carspot');
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

    // Ad Type
}