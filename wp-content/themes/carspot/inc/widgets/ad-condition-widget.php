<?php
/* Ad type condition */
add_action('widgets_init', function () {
    register_widget('carspot_search_condition');
});
if (!class_exists('carspot_search_condition')) {

    class carspot_search_condition extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_search_conidtion',
                'description' => esc_html__('Only for search and single ad sidebar.', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Ad Condition', 'carspot'), $widget_ops);
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
            $expand = $cur_con = '';
            $is_show = carspot_getTemplateID('taxconomy', 'ad_condition');
            if ($is_show == '' || $is_show == 1) {
            } else {
                return;
            }
            if (isset($_GET['condition']) && $_GET['condition'] != "") {
                $cur_con = $_GET['condition'];
                $expand = "in";
            }
            ?>
            <div class="panel panel-default" id="red-condition">
                <!-- Heading -->
                <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            <?php echo $title; ?>
                        </a>
                    </h4>
                </div>
                <!-- Content -->
                <form method="get"
                      action="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>#red-condition">
                    <?php
                    $conditions = carspot_get_cats('ad_condition', 0);
                    echo carspot_search_params('condition');
                    if (is_array($conditions) && count((array)$conditions) > 0) {
                        $field_name = 'condition';
                        $field_name = apply_filters('carspot_search_option_name', $field_name);
                        ?>
                        <div id="collapseThree" class="panel-collapse collapse <?php echo esc_attr($expand); ?>"
                             role="tabpanel" aria-labelledby="headingThree">
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
                                                do_action('carsport_search_option_checked', 'condition', $con->name);
                                                ?> >
                                                <label for="minimal-radio-<?php echo esc_attr($con->term_id); ?>"><?php echo esc_html($con->name); ?></label>
                                                <?php do_action('carsport_search_category_count', '_carspot_ad_condition', $con->name); ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
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
                $title = esc_html__('Condition', 'carspot');
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