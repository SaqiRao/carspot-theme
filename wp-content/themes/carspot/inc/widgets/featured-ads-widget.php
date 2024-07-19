<?php
/* Featured Ads Widget */
add_action('widgets_init', function () {
    register_widget('carspot_search_featured_ad');
});
if (!class_exists('carspot_search_featured_ad')) {

    class carspot_search_featured_ad extends WP_Widget
    {
        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_search_featured_ad',
                'description' => esc_html__('Only for search and single ad sidebar.', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Ad Featured', 'carspot'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         * @see WP_Widget::widget()
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
                        <div class="featured-slider-3 owl-carousel owl-theme">
                            <!-- Featured Ads -->
                            <?php
                            $f_args = array(
                                'post_type' => 'ad_post',
                                'post_status' => 'publish',
                                'posts_per_page' => $max_ads,
                                'meta_query' => array(
                                    array(
                                        'key' => '_carspot_is_feature',
                                        'value' => 1,
                                        'compare' => '=',
                                    ),
                                ),
                                'orderby' => 'rand',
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
                                    $mid = "";
                                     if (count((array)$media) > 0) {
                                        foreach ($media as $m) {
                                            $mid = '';
                                            if (isset($m->ID)) {
                                                $mid = $m->ID;
                                            } else {
                                                $mid = $m;
                                            }

                                            $image = wp_get_attachment_image_src($mid, 'carspot-ad-related');
                                            $img = isset($image[0]) ? $image[0] : "";
                                            break;
                                        }
                                    }
                                    ?>
                                    <div class="item">
                                        <div class="col-md-12 col-xs-12 col-sm-12 no-padding">
                                            <!-- Ad Box -->
                                            <div class="category-grid-box">
                                                <!-- Ad Img -->
                                                <div class="category-grid-img">
                                                    <?php echo carspot_video_icon(); ?>
                                                    <?php
                                                    if (wp_attachment_is_image($mid)) {
                                                        ?>
                                                        <img class="img-responsive"
                                                             alt="<?php echo esc_attr(get_the_title()); ?>"
                                                             src="<?php echo esc_url($img); ?>">
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <img class="img-responsive"
                                                             alt="<?php echo esc_attr(get_the_title()); ?>"
                                                             src="<?php echo esc_url($carspot_theme['default_related_image']['url']); ?>">
                                                        <?php
                                                    }
                                                    ?>
                                                    <!-- Ad Status -->
                                                    <!-- User Review -->
                                                    <div class="user-preview">
                                                        <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>?type=ads">
                                                            <img src="<?php echo esc_url(carspot_get_user_dp($author_id)); ?>"
                                                                 class="avatar avatar-small"
                                                                 alt="<?php echo esc_attr(get_the_title()); ?>">
                                                        </a>
                                                    </div>
                                                    <!-- View Details -->
                                                    <a href="<?php echo esc_url(get_the_permalink()); ?>"
                                                       class="view-details">
                                                        <?php echo esc_html__('View Details', 'carspot'); ?>
                                                    </a>
                                                </div>
                                                <!-- Ad Img End -->
                                                <div class="short-description">
                                                    <!-- Ad Category -->
                                                    <div class="category-title">
                                                        <?php echo carspot_display_cats(get_the_ID()); ?>
                                                    </div>
                                                    <!-- Ad Title -->
                                                    <h3>
                                                        <a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title(); ?></a>
                                                    </h3>
                                                    <!-- Price -->
                                                    <div class="price">
                                                        <?php echo(carspot_adPrice(get_the_ID())); ?>
                                                    </div>
                                                </div>
                                                <!-- Addition Info -->

                                                <div class="ad-info">
                                                    <?php
                                                    if (carspot_display_adLocation(get_the_ID()) != "") {
                                                        ?>
                                                        <ul>
                                                            <li>
                                                                <i class="fa fa-map-marker"></i><?php echo carspot_display_adLocation(get_the_ID()); ?>
                                                            </li>
                                                        </ul>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <!-- Ad Box End -->
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            wp_reset_postdata();
                            ?>
                            <!-- Featured Ads -->
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
                $title = esc_html__('Featured Ads', 'carspot');
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
            $instance['max_ads'] = (!empty($new_instance['max_ads'])) ? strip_tags($new_instance['max_ads']) : '';
            return $instance;
        }

    }

}