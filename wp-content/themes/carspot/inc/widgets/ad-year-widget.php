<?php
/* Ad Years */
add_action('widgets_init', function () {
    register_widget('carspot_search_ad_year');
});
if (!class_exists('carspot_search_ad_year')) {

    class carspot_search_ad_year extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_search_ad_years',
                'description' => esc_html__('Only for search and single ad sidebar.', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Ad Year', 'carspot'), $widget_ops);
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
            $is_show = carspot_getTemplateID('taxconomy', 'ad_years');
            if ($is_show == '' || $is_show == 1) {
            } else {
                return;
            }
            $year_from = '';
            $year_to = '';
            $expand = "";
            if (isset($_GET['year_from']) && $_GET['year_from'] != "") {
                $year_from = $_GET['year_from'];
            }
            if (isset($_GET['year_to']) && $_GET['year_to'] != "") {
                $year_to = $_GET['year_to'];
            }
            if ($year_from != '' && $year_to != '') {
                $expand = "in";
            }
            ?>
            <div class="panel panel-default" id="red-years">
                <!-- Heading -->
                <div class="panel-heading" role="tab" id="headingYear">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#Yearcollapse" aria-expanded="true" aria-controls="Yearcollapse">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            <?php echo $title; ?>
                        </a>
                    </h4>
                </div>
                <!-- Content -->
                <form method="get"
                      action="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>#red-years">
                    <?php
                    $ad_year = carspot_get_cats('ad_years', 0);
                    if (is_array($ad_year) && count((array)$ad_year) > 0) {
                        ?>
                        <div id="Yearcollapse" class="panel-collapse collapse <?php echo esc_attr($expand); ?>"
                             role="tabpanel" aria-labelledby="headingYear">
                            <div class="panel-body">
                                <div class="input-group  margin-top-10">
                                    <span class="input-group-addon"><?php echo esc_html__("From", "carspot") ?></span>
                                    <select id="year_from" name="year_from" class="form-control">
                                        <?php
                                        foreach ($ad_year as $ad_years) {
                                            ?>
                                            <option value="<?php echo esc_attr($ad_years->name); ?>"<?php echo "" . ($ad_years->name == $year_from) ? ' selected="selected"' : ''; ?>><?php echo esc_html($ad_years->name); ?> </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><?php echo esc_html__("To", "carspot") ?></span>
                                    <select id="year_to" name="year_to" class="form-control">
                                        <?php
                                        foreach ($ad_year as $ad_years) {
                                            ?>
                                            <option value="<?php echo esc_attr($ad_years->name); ?>"<?php echo "" . ($ad_years->name == $year_to) ? ' selected="selected"' : ''; ?>><?php echo esc_html($ad_years->name); ?> </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <input type="submit" id="ad_year" class="btn btn-theme btn-sm margin-top-10"
                                       value="<?php echo esc_html__('Search', 'carspot'); ?>"/>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    echo carspot_search_params('year_from', 'year_to');
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
                $title = esc_html__('Ad Year', 'carspot');
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