<?php
// Ad Price Widget
add_action('widgets_init', function () {
    register_widget('carspot_search_ad_price');
});
if (!class_exists('carspot_search_ad_price')) {

    class carspot_search_ad_price extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_search_ad_price',
                'description' => esc_html__('Only for search and single ad sidebar.', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Ad Price', 'carspot'), $widget_ops);
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
            $is_show = carspot_getTemplateID('static', '_sb_default_cat_price_show');
            if ($is_show == '' || $is_show == 1) {
            } else {
                return;
            }
            $min_price = $instance['min_price'];
            if (isset($_GET['min_price']) && $_GET['min_price'] != "") {
                $expand = "in";
                $min_price = $_GET['min_price'];
            }
            $max_price = $instance['max_price'];
            if (isset($_GET['max_price']) && $_GET['max_price'] != "") {
                $max_price = $_GET['max_price'];
            }
            $min = 0;
            if (isset($instance['min_price'])) {
                $min = $instance['min_price'];
            }
            global $carspot_theme;
            $form_style = isset($instance['form_style']) && !empty($instance['form_style']) ? $instance['form_style'] : 'style_1';
            add_action('wp_footer', function () use ($form_style) {
                if ($form_style == 'style_2') {
                    ?>
                    <script>
                        (function ($) {
                            $('#price-slider').on('change', function () {
                                setTimeout(function () {
                                    $(".carspot-price-form").submit();
                                }, 2000);
                            });

                            $('#min_selected').on('change paste keyup', function () {
                                setTimeout(function () {
                                    $(".carspot-price-form").submit();
                                }, 1200);
                            });
                            $('#max_selected').on('change paste keyup', function () {
                                setTimeout(function () {
                                    $(".carspot-price-form").submit();
                                }, 1200);
                            });
                        })(jQuery);
                    </script>
                    <?php
                }
            });
            $price_style = '';
            if ($form_style == 'style_2') {
                //$price_style = ' style="display:none;"';
            }
            ?>
            <div class="panel panel-default" id="red-price">
                <!-- Heading -->
                <div class="panel-heading" role="tab" id="headingfour">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            <?php echo $title; ?>
                        </a>
                    </h4>
                </div>
                <!-- Content -->
                <form method="get"
                      action="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>#red-price"
                      class="carspot-price-form">
                    <div id="collapsefour" class="panel-collapse collapse <?php echo esc_attr($expand); ?>"
                         role="tabpanel" aria-labelledby="headingfour">
                        <div class="panel-body">
                            <span class="price-slider-value"><?php echo esc_html__('Price', 'carspot'); ?>
                                (<?php echo esc_html($carspot_theme['sb_currency']); ?>)
                                <span id="price-min"></span>
                                -
                                <span id="price-max"></span>
                            </span>
                            <div id="price-slider"></div>

                            <div class="input-group margin-top-10"<?php echo carspot_returnEcho($price_style); ?>>
                                <input type="text" class="form-control" name="min_price" id="min_selected"
                                       value="<?php echo esc_attr($min_price); ?>" autocomplete="off"/>
                                <span class="input-group-addon">-</span>
                                <input type="text" class="form-control" name="max_price" id="max_selected"
                                       value="<?php echo esc_attr($max_price); ?>" autocomplete="off"/>
                            </div>

                            <input type="hidden" id="min_price"
                                   value="<?php echo esc_attr($instance['min_price']); ?>"/>
                            <input type="hidden" id="max_price"
                                   value="<?php echo esc_attr($instance['max_price']); ?>"/>
                            <?php if ($form_style == 'style_1') { ?>
                                <input type="submit" class="btn btn-theme btn-sm margin-top-10"
                                       value="<?php echo esc_html__('Search', 'carspot'); ?>"/>
                            <?php } ?>
                        </div>
                    </div>
                    <?php echo carspot_search_params('min_price', 'max_price'); ?>
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
                $title = esc_html__('Ad Price', 'carspot');
            }

            if (isset($instance['min_price'])) {
                $min_price = $instance['min_price'];
            } else {
                $min_price = 1;
            }

            if (isset($instance['max_price'])) {
                $max_price = $instance['max_price'];
            } else {
                $max_price = esc_html__('100000', 'carspot');
            }
            $form_style1 = isset($instance['form_style']) && !empty($instance['form_style']) && $instance['form_style'] == 'style_1' ? ' selected' : '';
            $form_style2 = isset($instance['form_style']) && !empty($instance['form_style']) && $instance['form_style'] == 'style_2' ? ' selected' : '';
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
                <label for="<?php echo esc_attr($this->get_field_id('min_price')); ?>">
                    <?php echo esc_html__('Min Price:', 'carspot'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('min_price')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('min_price')); ?>" type="text"
                       value="<?php echo esc_attr($min_price); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('max_price')); ?>">
                    <?php echo esc_html__('Max Price:', 'carspot'); ?>
                </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('max_price')); ?>"
                       name="<?php echo esc_attr($this->get_field_name('max_price')); ?>" type="text"
                       value="<?php echo esc_attr($max_price); ?>">
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('form_style')); ?>">
                    <?php echo esc_html__('Style : ', 'carspot'); ?>
                </label>
                <select class="search-select form-control"
                        name="<?php echo esc_attr($this->get_field_name('form_style')); ?>">
                    <option value="style_1"<?php echo esc_attr($form_style1); ?>> <?php echo esc_html__('Style 1', 'carspot'); ?> </option>
                    <option value="style_2"<?php echo esc_attr($form_style2); ?>> <?php echo esc_html__('Style 2', 'carspot'); ?> </option>
                </select>
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
            $instance['min_price'] = (!empty($new_instance['min_price'])) ? strip_tags($new_instance['min_price']) : '';
            $instance['max_price'] = (!empty($new_instance['max_price'])) ? strip_tags($new_instance['max_price']) : '';
            $instance['form_style'] = (!empty($new_instance['form_style'])) ? strip_tags($new_instance['form_style']) : '';
            return $instance;
        }
    }
}
