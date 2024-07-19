<?php
/* Recent Ads Widget */
add_action('widgets_init', function () {
    register_widget('carspot_search_recent_ad');
});
if (!class_exists('carspot_search_recent_ad')) {

    class carspot_search_recent_ad extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_search_recent_ad',
                'description' => esc_html__('Only for search and single ad sidebar.', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Ads Recent', 'carspot'), $widget_ops);
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
            $max_ads = $instance['max_ads'];
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
                        <?php
                        $f_args = array(
                            'post_type' => 'ad_post',
                            'posts_per_page' => $max_ads,
                            'post_status' => 'publish',
                            'orderby' => 'ID',
                            'order' => 'DESC',
                        );
                        $f_ads = new WP_Query($f_args);
                        if ($f_ads->have_posts()) {
                            $number = 0;
                            while ($f_ads->have_posts()) {
                                $f_ads->the_post();
                                $pid = get_the_ID();
                                $author_id = get_post_field('post_author', $pid);;
                                $author = get_user_by('ID', $author_id);

                                $img = $carspot_theme['default_related_image']['url'];
                                $media = carspot_fetch_listing_gallery($pid);
                                $total_imgs = count((array)$media);
                                if (count((array)$media) > 0) {
                                    foreach ($media as $m) {
                                        $mid = '';
                                        if (isset($m->ID)) {
                                            $mid = $m->ID;
                                        } else {
                                            $mid = $m;
                                        }

                                        $image = wp_get_attachment_image_src($mid, 'carspot-listing-small');
                                        $img = isset($image[0])  ?  $image[0] : "" ;
                                        break;
                                    }
                                }
                                ?>
                                <div class="recent-ads-list">
                                    <div class="recent-ads-container">
                                        <div class="recent-ads-list-image">
                                            <a href="<?php the_permalink(); ?>" class="recent-ads-list-image-inner">
                                                <img alt="<?php echo esc_attr(get_the_title()); ?>"
                                                     src="<?php echo esc_url($img); ?>">
                                            </a><!-- /.recent-ads-list-image-inner -->
                                        </div>
                                        <!-- /.recent-ads-list-image -->
                                        <div class="recent-ads-list-content">
                                            <h3 class="recent-ads-list-title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h3>
                                            <ul class="recent-ads-list-location">
                                                <li>
                                                    <a href="javascript:void(0);"><?php echo esc_html(get_post_meta(get_the_ID(), '_carspot_ad_location', true)); ?></a>
                                                </li>
                                            </ul>
                                            <div class="recent-ads-list-price">
                                                <?php echo(carspot_adPrice(get_the_ID())); ?>
                                            </div>
                                            <!-- /.recent-ads-list-price -->
                                        </div>
                                        <!-- /.recent-ads-list-content -->
                                    </div>
                                    <!-- /.recent-ads-container -->
                                </div>
                                <?php
                            }
                        }
                        wp_reset_postdata();
                        ?>
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
                $title = esc_html__('Recent Ads', 'carspot');
            }
            if (isset($instance['max_ads'])) {
                $max_ads = $instance['max_ads'];
            } else {
                $max_ads = 5;
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
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('max_ads')); ?>">
                    <?php echo esc_html__('Max # of Ads:', 'carspot'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('max_ads')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('max_ads')); ?>" type="text"
                       value="<?php echo esc_attr($max_ads); ?>">
            </p>
            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
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
            $instance['max_ads'] = (!empty($new_instance['max_ads'])) ? strip_tags($new_instance['max_ads']) : '';
            return $instance;
        }
    }
}