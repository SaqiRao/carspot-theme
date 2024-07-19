<?php
// Ad Categories widget
add_action('widgets_init', function () {
    register_widget('carspot_archive_cats');
});
if (!class_exists('carspot_archive_cats')) {

    class carspot_archive_cats extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_archive_cats',
                'description' => esc_html__('Only for category page ad sidebar.', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Ad Archive Categories', 'carspot'), $widget_ops);
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
                <?php
                $sb_search_page = apply_filters('carspot_language_page_id', $carspot_theme['sb_search_page']);
                $sb_search_page = isset($sb_search_page) && $sb_search_page != '' ? get_the_permalink($sb_search_page) : 'javascript:void(0)';
                $sb_search_page = apply_filters('carspot_category_widget_form_action',$sb_search_page,'cat_page');
                ?>
                <form method="get" id="make_search" action="<?php echo carspot_returnEcho($sb_search_page);?>">
                    <div id="collapseOne" class="panel-collapse collapse <?php echo esc_attr($expand);?>" role="tabpanel" aria-labelledby="headingOne">
                        <?php
                        $ad_cats = carspot_get_cats('ad_cats', 0);
                        if (count($ad_cats) > 0) {
                            ?>
                            <div class="panel-body categories">
                                <?php
                                if (isset($_GET['cat_id']) && $_GET['cat_id'] != "") {
                                    $selected_cats = carspot_get_taxonomy_parents($_GET['cat_id'], 'ad_cats', false);
                                    $find = '&raquo;';
                                    $replace = '';
                                    $selected_cats = preg_replace("/$find/", $replace, $selected_cats, 1);
                                    echo carspot_returnEcho($selected_cats);
                                    //echo carspot_get_taxonomy_parents( $_GET['cat_id'], 'ad_cats', false);
                                }
                                ?>
                                <ul>
                                    <?php
                                    foreach ($ad_cats as $ad_cat) {
                                        $category = get_term($ad_cat->term_id);
                                        $count = ($ad_cat->count);
                                        $cat_meta = get_option("taxonomy_term_$ad_cat->term_id");
                                        $icon = (isset($cat_meta['ad_cat_icon'])) ? $cat_meta['ad_cat_icon'] : '';
                                        $cat_search_page = 'javascript:void(0);';
                                        $cat_search_page = apply_filters('carspot_filter_taxonomy_popup_actions',$cat_search_page,$ad_cat->term_id,'ad_cats');
                                        ?>
                                        <li> <a href="<?php echo carspot_returnEcho($cat_search_page);?>" data-cat-id="<?php echo esc_attr($ad_cat->term_id);?>"><i class="<?php echo esc_attr($icon);?>"></i><?php echo esc_html($ad_cat->name);?><span>(<?php echo esc_html($count);?>)</span></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                    <input type="hidden" name="cat_id" id="cat_id" value="" />
                    <?php echo carspot_search_params('cat_id');?>
                    <!--                    --><?php //apply_filters('carspot_form_lang_field', true);?>
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