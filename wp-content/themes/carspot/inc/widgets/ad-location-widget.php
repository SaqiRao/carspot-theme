<?php
/* Ad Location */
add_action('widgets_init', function () {
    register_widget('carspot_search_ad_location');
});
if (!class_exists('carspot_search_ad_location')) {

    class carspot_search_ad_location extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_search_ad_location',
                'description' => esc_html__('Only for search and single ad sidebar.', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Ad Location', 'carspot'), $widget_ops);
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
            $is_show = carspot_getTemplateID('taxconomy', 'ad_country');
            if ($is_show == '' || $is_show == 1) {
            } else {
                return;
            }
            $expand = "";
            if (isset($_GET['country_id']) && $_GET['country_id'] != "") {
                $expand = "in";
            }

            ?>
            <div class="panel panel-default" id="red-country">
                <!-- Heading -->
                <div class="panel-heading" role="tab" id="location_heading">
                    <!-- Title -->
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#ad-location"
                           aria-expanded="true" aria-controls="ad-location">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            <?php echo $title; ?>
                        </a>
                    </h4>
                    <!-- Title End -->
                </div>
                <!-- Content -->
                <form method="get" id="search_countries"
                      action="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>#red-country">
                    <div id="ad-location" class="panel-collapse collapse <?php echo esc_attr($expand); ?>"
                         role="tabpanel" aria-labelledby="location_heading">

                        <?php
                        $countries = carspot_get_cats('ad_country', 0);
                        if (is_array($countries) && count($countries) > 0) {
                            ?>
                            <div class="panel-body countries">
                                <?php
                                if (isset($_GET['country_id']) && $_GET['country_id'] != "") {
                                    echo carspot_get_taxonomy_parents($_GET['country_id'], 'ad_country', false);
                                }
                                ?>
                                <ul>
                                    <?php
                                    foreach ($countries as $country) {
                                        $category = get_term($country->term_id);
                                        $count = $category->count;
                                        ?>
                                        <li>
                                            <a href="javascript:void(0);"
                                               data-country-id="<?php echo esc_attr($country->term_id); ?>">
                                                <?php echo esc_html($country->name); ?>
                                                <span>(<?php echo esc_html($count); ?>)</span>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <input type="hidden" name="country_id" id="country_id" value=""/>
                    <?php echo carspot_search_params('country_id'); ?>
                </form>
                <div class="search-modal modal fade states_model" id="states_model" tabindex="-1" role="dialog"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&#10005;</span><span
                                        class="sr-only">Close</span></button>
                                <h3 class="modal-title text-center">
                                    <i class="icon-gears"></i>
                                    <?php echo esc_html__('Select Your Location', 'carspot'); ?>
                                </h3>
                            </div>
                            <div class="modal-body">
                                <!-- content goes here -->
                                <div class="search-block">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 col-sm-12 popular-search"
                                             id="countries_response"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="country-btn"
                                        class="btn btn-lg btn-block"> <?php echo esc_html__('Submit', 'carspot'); ?> </button>
                            </div>
                        </div>
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
                $title = esc_html__('Ad Location', 'carspot');
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