<?php
// Simple or featured ad search
add_action('widgets_init', function () {
    register_widget('carspot_search_ad_simple_feature');
});
if (!class_exists('carspot_search_ad_simple_feature')) {

    class carspot_search_ad_simple_feature extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_search_ad_simple_feature',
                'description' => esc_html__('Only for search and single ad sidebar.', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Simple or feature ad search', 'carspot'), $widget_ops);
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
            $simple = '';
            $featured = '';
            $expand = "";
            if (isset($_GET['ad']) && $_GET['ad'] != "") {
                $expand = "in";
                if ($_GET['ad'] == 0) {
                    $simple = "checked";
                }
                if ($_GET['ad'] == 1) {
                    $featured = "checked";
                }
            }

            ?>
            <div class="panel panel-default" id="red-ads-type">
                <!-- Heading -->
                <div class="panel-heading" role="tab" id="headingNine">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseNine" aria-expanded="true" aria-controls="collapseNine">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            <?php echo $title; ?>
                        </a>
                    </h4>
                </div>
                <!-- Content -->
                <form method="get"
                      action="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>#red-ads-type">
                    <div id="collapseNine" class="panel-collapse collapse <?php echo esc_attr($expand); ?>"
                         role="tabpanel" aria-labelledby="headingNine">
                        <div class="panel-body">
                            <div class="skin-minimal">
                                <ul class="list">
                                    <li>
                                        <input tabindex="7" type="radio" id="minimal-radio-sb_1" name="ad"
                                               value="0" <?php echo esc_attr($simple); ?> >
                                        <label for="minimal-radio-sb_1">
                                            <?php echo esc_html__('Simple Ads', 'carspot'); ?></label>
                                    </li>
                                    <li>
                                        <input tabindex="7" type="radio" id="minimal-radio-sb_2" name="ad"
                                               value="1" <?php echo esc_attr($featured); ?> >
                                        <label for="minimal-radio-sb_2">
                                            <?php echo esc_html__('Featured Ads', 'carspot'); ?></label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php
                    echo carspot_search_params('ad');
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
                $title = esc_html__('Simple or Featured', 'carspot');
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