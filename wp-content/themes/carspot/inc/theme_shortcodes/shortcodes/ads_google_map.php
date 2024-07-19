<?php
/* ------------------------------------------------ */
/* Ads- in Google Map */
/* ------------------------------------------------ */
if (!function_exists('ads_google_map_short')) {
    function ads_google_map_short()
    {
        vc_map(array(
            "name" => esc_html__("ADs - Google Map", 'carspot'),
            "base" => "ads_google_map_short_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('ad_google_map.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
                ),
                array(
                    "group" => esc_html__("Ads Settings", "'carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Ads Type", 'carspot'),
                    "param_name" => "ad_type",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Ads Type', 'carspot') => '',
                        esc_html__('Featured Ads', 'carspot') => 'feature',
                        esc_html__('Simple Ads', 'carspot') => 'regular'
                    ),
                ),
                array(
                    "group" => esc_html__("Map", "'carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Map Zoom", 'carspot'),
                    "param_name" => "map_zoom",
                    "admin_label" => true,
                    "value" => range(1, 6),
                    "std" => 5,
                ),
                array(
                    "group" => esc_html__("Map", "'carspot"),
                    "type" => "textfield",
                    "heading" => esc_html__("Latitude", 'carspot'),
                    "description" => esc_html__("That Area will be display in map after loading but user can change it by dragging.", 'carspot'),
                    "param_name" => "map_latitude",
                ),
                array(
                    "group" => esc_html__("Map", "'carspot"),
                    "type" => "textfield",
                    "heading" => esc_html__("Longitude", 'carspot'),
                    "param_name" => "map_longitude",
                ),
                array(
                    "group" => esc_html__("Ads Settings", "'carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Number fo Ads for each category", 'carspot'),
                    "param_name" => "no_of_ads",
                    "admin_label" => true,
                    "value" => range(1, 50),
                ),
                //Group For Left Section
                array
                (
                    'group' => esc_html__('Categories', 'carspot'),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Category', 'carspot'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                    (
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Category", 'carspot'),
                            "param_name" => "cat",
                            "admin_label" => true,
                            "value" => carspot_get_parests('ad_cats', 'no'),
                        ),
                        array(
                            "type" => "attach_image",
                            "holder" => "bg_img",
                            "class" => "",
                            "heading" => esc_html__("Category Marker Image", 'carspot'),
                            "param_name" => "img",
                            "description" => esc_html__("50x77", 'carspot'),
                        ),
                    )
                ),

            ),
        ));
    }
}

add_action('vc_before_init', 'ads_google_map_short');

if (!function_exists('ads_google_map_short_base_func')) {
    function ads_google_map_short_base_func($atts, $content = '')
    {
        global $carspot_theme;
        extract(shortcode_atts(array(
            'cats' => '',
            'ad_type' => '',
            'no_of_ads' => '',
            'map_latitude' => '',
            'map_longitude' => '',
            'map_zoom' => '',

        ), $atts));


        $mapType = carspot_mapType();
        if ($mapType == 'leafletjs_map') {

        } else if ($mapType == 'google_map') {

        }
        $rows = vc_param_group_parse_atts($atts['cats']);


        if ($mapType == 'leafletjs_map') {
            $listing_json = '<script>var listing_markers = [';
        } else if ($mapType == 'google_map') {

            $listing_json = '<script>  var locations = [';
        }
        if (count((array)$rows) > 0) {
            foreach ($rows as $row) {
                if (isset($row['cat'])) {
                    $marker = '';
                    if (isset($row['img'])) {
                        $marker = carspot_returnImgSrc($row['img']);
                    } else {
                        $marker = trailingslashit(get_template_directory_uri()) . 'images/car-marker.png';
                    }
                    $category = array(
                        array(
                            'taxonomy' => 'ad_cats',
                            'field' => 'slug',
                            'terms' => $row['cat'],
                        ),
                    );
                    $is_feature = '';
                    if ($ad_type == 'feature') {
                        $is_feature = array(
                            'key' => '_carspot_is_feature',
                            'value' => 1,
                            'compare' => '=',
                        );
                    } else {
                        $is_feature = array(
                            'key' => '_carspot_is_feature',
                            'value' => 0,
                            'compare' => '=',
                        );
                    }

                    $args = array(
                        'post_type' => 'ad_post',
                        'post_status ' => 'publish',
                        'posts_per_page' => $no_of_ads,
                        'meta_query' => array(
                            $is_feature,
                        ),
                        'tax_query' => array(
                            $category,
                        ),
                        'orderby' => 'ID',
                        'order' => 'DESC',

                    );
                    $args = carspot_wpml_show_all_posts_callback($args);
                    $results = new WP_Query($args);

                    if ($results->have_posts()) {
                        $count1 = 1;
                        $ad_class = '';
                        while ($results->have_posts()) {
                            $results->the_post();
                            $pid = get_the_ID();
                            $title = get_the_title();
                            $img = '';
                            $media = carspot_fetch_listing_gallery($pid);
                            if (count((array)$media) > 0) {
                                foreach ($media as $m) {
                                    $mid = '';
                                    if (isset($m->ID)) {
                                        $mid = $m->ID;
                                    } else {
                                        $mid = $m;
                                    }

                                    $image = wp_get_attachment_image_src($mid, 'carspot-ad-related');
                                    if ($image != '') {
                                        $img = $image[0];
                                        break;
                                    }

                                }
                            } else {
                                $img = $carspot_theme['default_related_image']['url'];
                            }
                            $price = carspot_adPrice(get_the_ID());
                            $p_date = get_the_date(get_option('date_format'), get_the_ID());


                            $post_categories = wp_get_object_terms($pid, array('ad_cats'), array('orderby' => 'term_group'));
                            $cat_name = '';
                            $cat_link = '';
                            foreach ($post_categories as $c) {
                                $cat = get_term($c);
                                $cat_name = $cat->name;
                                $cat_link = get_term_link($cat->term_id);
                            }

                            $flip_it = '';
                            $ribbion = 'featured-ribbon';
                            if (is_rtl()) {
                                $flip_it = 'flip';
                                $ribbion = 'featured-ribbon-rtl';
                            }
                            $is_feature = '';
                            if (get_post_meta($pid, '_carspot_is_feature', true) == '1') {
                                $is_feature = '<div class="' . esc_attr($ribbion) . '"><span>' . esc_html__('Featured', 'carspot') . '</span></div>';
                            }

                            $lat = '';
                            $lon = '';

                            $lat = get_post_meta($pid, '_carspot_ad_map_lat', true);
                            $lon = get_post_meta($pid, '_carspot_ad_map_long', true);
                            if ($lat == "" || $lon == "") {
                                continue;
                            }


                            if ($mapType == 'leafletjs_map') {
                                $price = strip_tags($price);
                                $listing_json .= '{
						"img":"' . esc_url($img) . '",
						"price":"' . ($price) . '",
						"ad_class":"' . ($ad_class) . '",
						"cat_link":"' . ($cat_link) . '",
						"cat_name":"' . ($cat_name) . '",
						"title":"' . ($title) . '",
						"location":"",
						"ad_link":"' . get_the_permalink($pid) . '",
						"p_date":"' . ($p_date) . '",
						"lat":"' . ($lat) . '",
						"lon":"' . ($lon) . '",
						"marker_counter":"' . ($count1) . '",
						"marker2":"' . $marker . '",
						"imageUrl":"",
					},';
                            } else if ($mapType == 'google_map') {

                                $func = '<div class="category-grid-box-1"><div class="image"><img alt="' . $title . '" src="' . esc_url($img) . '" class="img-responsive">' . $is_feature . '<div class="price-tag"><div class="price"><span>' . $price . ' </span></div></div></div><div class="short-description-1 clearfix"><div class="category-title"> <span><a href="' . esc_url($cat_link) . ' ">' . $cat_name . '</a></span> </div><h3><a href="' . get_the_permalink($pid) . '">' . $title . '</a></h3></div><div class="ad-info-1"><p><i class="flaticon-calendar"></i> &nbsp;<span></span>' . $p_date . ' </p></div></div>';

                                $listing_json .= "['$func', $lat, $lon, $count1, '$marker'],";

                            }

                            $count1++;
                        }
                    }

                }
            }
        }


        if ($mapType == 'leafletjs_map') {
            $listing_json .= '];</script>';
        } else if ($mapType == 'google_map') {

            $listing_json .= ']; var map_lat = "' . $map_latitude . '"; var map_lon = "' . $map_longitude . '"; var zoom_option = ' . $map_zoom . '</script>';


        }

        wp_reset_postdata();


        $leaflet_jsJS = $prev_next_html = '';
        if ($mapType == 'leafletjs_map') {

            $marker_url = trailingslashit(get_template_directory_uri()) . 'images/car-marker.png';
            if ($marker != "") {
                $marker_url = $marker;
            }

            $leaflet_jsJS = '<script type="text/javascript">
			
			var map_lat = "' . $map_latitude . '";
			var map_long = "' . $map_longitude . '";
			
			
			if(map_lat  &&  map_long )
			{		
				
			var my_icons = "' . $marker_url . '";
			if(jQuery("#map").length){
			var map = L.map("map").setView([map_lat, map_long], "' . $map_zoom . '");
			L.tileLayer("https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png").addTo( map );
			var myIcon = L.icon({
				  iconUrl:  my_icons,
				  iconRetinaUrl:   my_icons,
				  iconSize: [25, 40],
				  iconAnchor: [10, 30],
				  popupAnchor: [0, -35]
			});
				carspot_mapCluster();
			}
			}
				
			function carspot_mapCluster()
			{
				var markerClusters = L.markerClusterGroup();
				var popup = "";
				for ( var i = 0; i < listing_markers.length; ++i )
				{
						
						if(listing_markers[i].lat && listing_markers[i].lon ){
						
						
						var popup = \'<div class="category-grid-box-1"><div class="image"><img alt="\' + listing_markers[i].title + \'" src="\' + listing_markers[i].img + \'" class="img-responsive">\' + listing_markers[i].ad_class + \'<div class="price-tag"><div class="price"><span>\' + listing_markers[i].price + \' </span></div></div></div><div class="short-description-1 clearfix"><div class="category-title"> <span><a href="\' + listing_markers[i].cat_link + \'">\' + listing_markers[i].cat_name + \'</a></span> </div><h3><a href="\' + listing_markers[i].ad_link + \'">\' + listing_markers[i].title + \'</a></h3></div><div class="ad-info-1"><p><i class="flaticon-calendar"></i> &nbsp;<span></span>\' + listing_markers[i].p_date + \' </p></div>\';
						
						
						}
						
						
					  var m = L.marker( [listing_markers[i].lat, listing_markers[i].lon], {icon: myIcon} ).bindPopup(popup,{minWidth:270,maxWidth:270});
					  markerClusters.addLayer( m );
					  map.addLayer( markerClusters );
					  map.fitBounds(markerClusters.getBounds());
				}				
				map.scrollWheelZoom.disable();
				map.invalidateSize();
		    }    
		    
        </script>';


            $prev_next_html = '';


        } else if ($mapType == 'google_map') {
            if ($carspot_theme['gmap_api_key'] != "") {
                /* Only need on this page so inluded here don't want to increase page size for optimizaion by adding extra scripts in all the web */
                wp_enqueue_script('google-map');
                wp_enqueue_script('infobox', trailingslashit(get_template_directory_uri()) . 'js/infobox.js', array('google-map'), false, false);
                wp_enqueue_script('marker-clusterer', trailingslashit(get_template_directory_uri()) . 'js/markerclusterer.js', false, false, false);
                wp_enqueue_script('marker-clusterer-sprinter', '//cdnjs.cloudflare.com/ajax/libs/OverlappingMarkerSpiderfier/1.0.3/oms.min.js', false, false, false);
                wp_enqueue_script('marker-map', trailingslashit(get_template_directory_uri()) . 'js/markers-map.js', false, false, false);
           
            }

            $prev_next_html = '<ul id="google-map-btn">
         <li><a href="#" id="prevpoint" title="' . esc_html__('Previous point on map', 'carspot') . '">' . esc_html__('Prev', 'carspot') . '</a></li>
         <li><a href="#" id="nextpoint" title="' . esc_html__('Next point on map', 'carspot') . '">' . esc_html__('Next', 'carspot') . '</a></li>
      </ul>';

        }


        return $listing_json . '<div id="map"></div>
      <!-- Map Navigation -->
      ' . $prev_next_html
            . $leaflet_jsJS;
    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('ads_google_map_short_base', 'ads_google_map_short_base_func');
}