<?php
/* Ad Location */
add_action('widgets_init', function () {
    register_widget('carspot_search_ad_by_zip');
});
if (!class_exists('carspot_search_ad_by_zip')) {

    class carspot_search_ad_by_zip extends WP_Widget
    {

        /**
         * Register widget with WordPress.
         */
        function __construct()
        {
            $widget_ops = array(
                'classname' => 'carspot_search_ad_by_zip',
                'description' => esc_html__('Only for search page sidebar and can only work if google map is enabled', 'carspot'),
            );
            // Instantiate the parent object
            parent::__construct(false, esc_html__('Carspot:Ad Location with Radius', 'carspot'), $widget_ops);
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
            if (isset($_GET['radius']) && $_GET['radius'] != "") {
                $expand = "in";
            }

            ?>
            <div class="panel panel-default" id="red-radius">
                <!-- Heading -->
                <div class="panel-heading" role="tab" id="radius_search_heading">
                    <!-- Title -->
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#radius_search"
                           aria-expanded="true" aria-controls="radius_search">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            <?php echo $title; ?>
                        </a>
                    </h4>
                    <!-- Title End -->
                </div>
                <?php
                $stricts = '';
                if (isset($carspot_theme['sb_location_allowed']) && !$carspot_theme['sb_location_allowed'] && isset($carspot_theme['sb_list_allowed_country'])) {
                    $stricts = "componentRestrictions: {country: " . json_encode($carspot_theme['sb_list_allowed_country']) . "}";
                }
                $unit_radius = "KM";
                if (isset($_GET['radius_unit']) && $_GET['radius_unit'] != "" && $_GET['radius_unit'] == "Miles") {
                    $unit_radius = "Miles";
                }
                $mapType = carspot_mapType();
                if ($mapType == 'google_map') {
                    echo "<script>
			(function ($) {
				'use strict';
            	/*RADIUS SEARC PLACES ON SEARCH PAGE*/
				$( document ).ready(function() {
					function initMap() {
						var options = {
						  types: ['(regions)'],
						  " . $stricts . "
						  //componentRestrictions: {country: ['NL','BE']} 
						 };
						var input = document.getElementById('searchMapInput');
						var autocomplete = new google.maps.places.Autocomplete(input, options);
						autocomplete.addListener('place_changed', function() {
							var place = autocomplete.getPlace();
							$('#location-snap').val(place.formatted_address); 
							$('#loc_lat').val(place.geometry.location.lat());
							$('#loc_long').val(place.geometry.location.lng());
						});
					}
					initMap();
				});
				})(jQuery);
            
            </script>";
                }
                ?>
                <!-- Content -->
                <form method="get" id="radius_search_countries"
                      action="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>#red-radius">
                    <div id="radius_search" class="panel-collapse collapse <?php echo esc_attr($expand); ?>"
                         role="tabpanel" aria-labelledby="radius_search_heading">
                        <div class="panel-body">
                            <div class="form-group">
                                <input id="searchMapInput" class="form-control" type="text" name="radius_address"
                                       placeholder="<?php echo esc_html__('Search location', 'carspot'); ?>"
                                       value="<?php
                                       if (isset($_GET['radius_address']) && $_GET['radius_address'] != "") {
                                           echo esc_html($_GET['radius_address']);
                                       } else {
                                           echo '';
                                       }
                                       ?>">
                            </div>
                            <select class="search-select form-control" id="radius_number" name="radius"
                                    data-placeholder="<?php echo esc_html__('Select Radius', 'carspot'); ?>">
                                <option value=""> <?php echo esc_html__("Radius in $unit_radius", 'carspot'); ?> </option>
                                <option <?php if (isset($_GET['radius']) && $_GET['radius'] == '5') { ?> selected <?php } ?>
                                    value="<?php echo esc_html__('5', 'carspot'); ?>"><?php echo esc_html__("5 $unit_radius", 'carspot'); ?> </option>
                                <option <?php if (isset($_GET['radius']) && $_GET['radius'] == '10') { ?> selected <?php } ?>
                                    value="<?php echo esc_html__('10', 'carspot'); ?>"><?php echo esc_html__("10 $unit_radius", 'carspot'); ?> </option>
                                <option <?php if (isset($_GET['radius']) && $_GET['radius'] == '15') { ?> selected <?php } ?>
                                    value="<?php echo esc_html__('15', 'carspot'); ?>"><?php echo esc_html__("15 $unit_radius", 'carspot'); ?> </option>
                                <option <?php if (isset($_GET['radius']) && $_GET['radius'] == '20') { ?> selected <?php } ?>
                                    value="<?php echo esc_html__('20', 'carspot'); ?>"><?php echo esc_html__("20 $unit_radius", 'carspot'); ?> </option>
                                <option <?php if (isset($_GET['radius']) && $_GET['radius'] == '25') { ?> selected <?php } ?>
                                    value="<?php echo esc_html__('25', 'carspot'); ?>"><?php echo esc_html__("25 $unit_radius", 'carspot'); ?> </option>
                                <option <?php if (isset($_GET['radius']) && $_GET['radius'] == '35') { ?> selected <?php } ?>
                                    value="<?php echo esc_html__('35', 'carspot'); ?>"><?php echo esc_html__("35 $unit_radius", 'carspot'); ?> </option>
                                <option <?php if (isset($_GET['radius']) && $_GET['radius'] == '50') { ?> selected <?php } ?>
                                    value="<?php echo esc_html__('50', 'carspot'); ?>"><?php echo esc_html__("50 $unit_radius", 'carspot'); ?> </option>
                                <option <?php if (isset($_GET['radius']) && $_GET['radius'] == '100') { ?> selected <?php } ?>
                                    value="<?php echo esc_html__('100', 'carspot'); ?>"><?php echo esc_html__("100 $unit_radius", 'carspot'); ?> </option>
                                <option <?php if (isset($_GET['radius']) && $_GET['radius'] == '150') { ?> selected <?php } ?>
                                    value="<?php echo esc_html__('150', 'carspot'); ?>"><?php echo esc_html__("150 $unit_radius", 'carspot'); ?> </option>
                                <option <?php if (isset($_GET['radius']) && $_GET['radius'] == '200') { ?> selected <?php } ?>
                                    value="<?php echo esc_html__('200', 'carspot'); ?>"><?php echo esc_html__("200 $unit_radius", 'carspot'); ?> </option>
                                <option <?php if (isset($_GET['radius']) && $_GET['radius'] == '300') { ?> selected <?php } ?>
                                    value="<?php echo esc_html__('300', 'carspot'); ?>"><?php echo esc_html__("300 $unit_radius", 'carspot'); ?> </option>
                                <option <?php if (isset($_GET['radius']) && $_GET['radius'] == '500') { ?> selected <?php } ?>
                                    value="<?php echo esc_html__('500', 'carspot'); ?>"><?php echo esc_html__("500 $unit_radius", 'carspot'); ?> </option>
                                <option <?php if (isset($_GET['radius']) && $_GET['radius'] == '1000') { ?> selected <?php } ?>
                                    value="<?php echo esc_html__('1000', 'carspot'); ?>"><?php echo esc_html__("1000 $unit_radius", 'carspot'); ?> </option>
                            </select>
                            <!--<input type="submit" class="btn btn-theme btn-sm margin-top-10 margin-bottom-10" id="search_make" value="<?php echo esc_html__('Search', 'carspot'); ?>" />-->
                            <input type="hidden" name="loc_long" id="loc_long" value="<?php
                            if (isset($_GET['loc_long']) && $_GET['loc_long'] != "") {
                                echo esc_html($_GET['loc_long']);
                            } else {
                                echo '';
                            }
                            ?>"/>
                            <input type="hidden" name="loc_lat" id="loc_lat" value="<?php
                            if (isset($_GET['loc_lat']) && $_GET['loc_lat'] != "") {
                                echo esc_html($_GET['loc_lat']);
                            } else {
                                echo '';
                            }
                            ?>"/>
                            <input type="hidden" id="location-snap" value="">
                        </div>
                    </div>
                    <?php echo carspot_search_params('radius', 'loc_long', 'loc_lat', 'radius_address'); ?>

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
                $title = esc_html__('Location with radius', 'carspot');
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