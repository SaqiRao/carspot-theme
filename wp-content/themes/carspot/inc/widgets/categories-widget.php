<?php
// Ad Categories widget
add_action('widgets_init', function () {
    register_widget('carspot_search_cats');
});
if (!class_exists('carspot_search_cats')) {

    class carspot_search_cats extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_search_cats',
                'description' => esc_html__('Only for search and single ad sidebar.', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Ad Categories', 'carspot'), $widget_ops);
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
            $new = '';
            $used = '';
            $expand = "";
            if (isset($_GET['cat_id']) && $_GET['cat_id'] != "") {
                $expand = "in";
            }
            ?>
            <div class="panel panel-default" id="red-category">
                <!-- Heading -->
                <div class="panel-heading" role="tab" id="headingOne">
                    <!-- Title -->
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                           aria-expanded="true" aria-controls="collapseOne">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            <?php echo $title; ?>
                        </a>
                    </h4>
                    <!-- Title End -->
                </div>
                <!-- Content -->
                <form method="get" id="make_search"
                      action="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>#red-category">
                    <div id="collapseOne" class="panel-collapse collapse <?php echo esc_attr($expand); ?>"
                         role="tabpanel" aria-labelledby="headingOne">

                        <?php
                        global $carspot_theme;
                        $heading = '';
                        if (isset($carspot_theme['cat_level_1']) && $carspot_theme['cat_level_1'] != "") {
                            $heading = $carspot_theme['cat_level_1'];
                        }
                        $ad_cats = carspot_get_cats('ad_cats', 0);
                        if (is_array($ad_cats) && count((array)$ad_cats) > 0) {
                            ?>
                            <div class="panel-body">

                                <?php
                                if (isset($_GET['cat_id']) && $_GET['cat_id'] != "") {
                                    ?>
                                    <div class="cat_head">
                                        <span><?php echo carspot_get_taxonomy_parents($_GET['cat_id'], 'ad_cats', false); ?></span>
                                    </div>
                                    <?php
                                }
                                ?>
                                <label class="control-label"> <?php echo esc_attr($heading); ?> </label>
                                <select class="search-select form-control" id="make_id">
                                    <option value=""> <?php echo esc_html__('Select Any Category', 'carspot'); ?> </option>
                                    <?php
                                    foreach ($ad_cats as $ad_cat) {
                                        $category = get_term($ad_cat->term_id);
                                        $cat_meta = get_option("taxonomy_term_$ad_cat->term_id");
                                        ?>
                                        <option value="<?php echo esc_attr($ad_cat->term_id); ?>"><?php echo esc_html($ad_cat->name); ?> </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <div id="select_modal" class="margin-top-10"></div>

                                <div id="select_modals" class="margin-top-10"></div>

                                <div id="select_forth_div" class="margin-top-10"></div>

                                <input type="submit" class="btn btn-theme btn-sm margin-top-10 margin-bottom-10"
                                       id="search_make" value="<?php echo esc_html__('Search', 'carspot'); ?>"/>

                            </div>

                            <?php
                        }
                        ?>
                    </div>
                    <input type="hidden" name="cat_id" id="cat_id" value=""/>

                    <?php echo carspot_search_params('cat_id'); ?>
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
                $title = esc_html__('Categories', 'carspot');
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

    // Categories widget
}
