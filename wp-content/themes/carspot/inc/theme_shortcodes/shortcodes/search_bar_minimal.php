<?php
/* ------------------------------------------------ */
/* Minimal Search Bar */
/* ------------------------------------------------ */
if (!function_exists('minimal_search_bar')) {
    function minimal_search_bar()
    {
        vc_map(array(
            "name" => esc_html__("Minimal Search Bar", 'carspot'),
            "base" => "minimal_searchbar_base",
            "category" => esc_html__("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('minimal_searchbar_bar.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
                ),

                array(
                    "group" => esc_html__("Keyword", "carspot"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Field Heading", 'carspot'),
                    "param_name" => "loc_field_heading",
                ),

                array(
                    "group" => esc_html__("Keyword", "carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Choose Field Type", 'carspot'),
                    "param_name" => "loc_srch_type_field",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Title Search', 'carspot') => 'title_search',
                        esc_html__('Location Search', 'carspot') => 'location_search',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                ),

                array(
                    "group" => esc_html__("Keyword", "carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Choose Location Search Type", 'carspot'),
                    "param_name" => "loc_srch_type",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Default', 'carspot') => 'default',
                        esc_html__('Google', 'carspot') => 'google',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                    'dependency' => array(
                        'element' => 'loc_srch_type_field',
                        'value' => 'location_search',
                    ),
                ),

                array(
                    "group" => esc_html__("Keyword", "carspot"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Placeholder Title", 'carspot'),
                    "param_name" => "loc_place_title",
                ),

                array(
                    "group" => esc_html__("Select Make", "carspot"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Do you want to show make with their models?", 'carspot'),
                    "param_name" => "want_to_show",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('yes', 'carspot') => 'yes',
                        esc_html__('no', 'carspot') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                ),


                array(
                    "group" => esc_html__("Select Make", "carspot"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Make ( All or Selective )', 'carspot'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array(
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Category", 'carspot'),
                            "param_name" => "cat",
                            "admin_label" => true,
                            "value" => carspot_get_parests('ad_cats', 'yes'),
                        ),

                    )
                ),

                array(
                    "group" => esc_html__("Years", "carspot"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Year ( All or Selective )', 'carspot'),
                    'param_name' => 'years',
                    'value' => '',
                    'params' => array(
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Select Year", 'carspot'),
                            "param_name" => "year",
                            "admin_label" => true,
                            "value" => carspot_get_all('ad_years', 'yes'),
                        ),

                    )
                ),


                array(
                    "group" => esc_html__("Body Type", "carspot"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Year ( All or Selective )', 'carspot'),
                    'param_name' => 'body_types',
                    'value' => '',
                    'params' => array(
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Select Body Type", 'carspot'),
                            "param_name" => "body_type",
                            "admin_label" => true,
                            "value" => carspot_get_all('ad_body_types', 'yes'),
                        ),

                    )
                ),


            ),
        ));
    }
}

add_action('vc_before_init', 'minimal_search_bar');

if (!function_exists('minimal_searchbar_base_func')) {
    function minimal_searchbar_base_func($atts, $content = '')
    {
        extract(shortcode_atts(array(
            'loc_field_heading' => '',
            'loc_srch_type_field' => '',
            'loc_srch_type' => '',
            'loc_place_title' => '',
            'cats' => '',
            'years' => '',
            'field_heading' => '',
            'place_title' => '',
            'want_to_show' => '',
        ), $atts));
        global $carspot_theme;


        /* Location */
        $location_heading = (isset($loc_field_heading) && $loc_field_heading != '') ? $loc_field_heading : esc_html__("Location", "carspot");
        $loc_srch_type_field = (isset($loc_srch_type_field) && $loc_srch_type_field == 'title_search') ? 'title_search' : 'location_search';
        $loc_search_type = (isset($loc_srch_type) && $loc_srch_type != '') ? $loc_srch_type : 'default';
        $loc_placeholder_txt = (isset($loc_place_title) && $loc_place_title != '') ? $loc_place_title : esc_html__("Location..", "carspot");


        $location = '';
        $mapType = carspot_mapType();
        if ($mapType == 'google_map') {
            wp_enqueue_script('google-map-callback', '//maps.googleapis.com/maps/api/js?key=' . $carspot_theme['gmap_api_key'] . '&libraries=places&callback=' . 'carspot_location', false, false, true);
        }

        $location_html = '';
        if (isset($loc_srch_type_field) && $loc_srch_type_field == 'title_search') {
            /* simple textfield search */
            $location_html .= '<input autocomplete="off" name="ad_title" id="autocomplete-dynamic" class="form-control banner-icon-search" placeholder="' . $place_title . '" type="text">';
        } else {
            if (isset($loc_search_type) && $loc_search_type == 'default') {
                /* get all parent countries */
                $ad_country = carspot_get_cats('ad_country', 0);
                $country_html = '';
                if (is_array($ad_country) && !empty($ad_country)) {
                    foreach ($ad_country as $country) {
                        $country_html .= '<option value="' . $country->term_id . '">' . $country->name . '</option>';
                    }
                }

                /* make coutries dropdown */
                $location_html .= '<select name="country_id" id="country_id" autocomplete="off">
                    <option value="">' . esc_html__($loc_placeholder_txt, "carspot") . '</option>
                    ' . $country_html . '
                </select>';
            } else {
                /* google countries search */
                carspot_load_search_countries(1);
                $location_html .= '<input class="form-control pac-target-input" autocomplete="off" type="text" name="cs_srch_address" id="sb_user_address" value="" placeholder="'.$loc_placeholder_txt.'">';
            }
        }

        //For Make
        $rows = vc_param_group_parse_atts($atts['cats']);
        $cats = false;
        $cats_html = '';
        if (count((array)$rows) > 0) {
            $cats_html .= '';
            foreach ($rows as $row) {
                if (isset($row['cat'])) {
                    if ($row['cat'] == 'all') {
                        $cats = true;
                        $cats_html = '';
                        break;
                    }
                    $category = get_term_by('slug', $row['cat'], 'ad_cats');
                    if (count((array)$category) == 0)
                        continue;

                    if (isset($want_to_show) && $want_to_show == "yes") {

                        $ad_cats_sub = carspot_get_cats('ad_cats', $category->term_id);
                        if (count($ad_cats_sub) > 0) {
                            $cats_html .= '<option value="' . $category->term_id . '" >' . $category->name . '  (' . $category->count . ')';
                            foreach ($ad_cats_sub as $ad_cats_subz) {
                                $cats_html .= '<option value="' . $ad_cats_subz->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $ad_cats_subz->name . '  (' . $ad_cats_subz->count . ') </option>';
                            }
                            $cats_html .= '</option>';
                        } else {
                            $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                        }
                    } else {
                        $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                    }
                }
            }

            if ($cats) {
                $ad_cats = carspot_get_cats('ad_cats', 0);
                foreach ($ad_cats as $cat) {

                    if (isset($want_to_show) && $want_to_show == "yes") {
                        //sub cat
                        $ad_sub_cats = carspot_get_cats('ad_cats', $cat->term_id);
                        if (count($ad_sub_cats) > 0) {
                            $cats_html .= '<option value="' . $cat->term_id . '" >' . $cat->name . '  (' . $cat->count . ')';
                            foreach ($ad_sub_cats as $sub_cat) {
                                $cats_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                            }
                            $cats_html .= '</option>';
                        } else {
                            $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                        }
                    } else {
                        $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                    }
                }
            }
        }

        //For Years
        $rows_years = vc_param_group_parse_atts($atts['years']);
        $year_cats = false;
        $years_html = '';
        $get_year = '';
        if (count((array)$rows_years) > 0) {
            $years_html .= '';
            foreach ($rows_years as $rows_year) {
                if (isset($rows_year['year'])) {
                    if ($rows_year['year'] == 'all') {
                        $year_cats = true;
                        $years_html = '';
                        break;
                    }
                    $get_year = get_term_by('slug', $rows_year['year'], 'ad_years');
                    if (count((array)$get_year) == 0)
                        continue;
                    $years_html .= '<option value="' . $get_year->name . '">' . $get_year->name . '</option>';
                }
            }

            if ($year_cats) {
                $all_years = carspot_get_cats('ad_years', 0);
                foreach ($all_years as $all_year) {
                    $years_html .= '<option value="' . $all_year->name . '">' . $all_year->name . '</option>';
                }
            }
        }


        //For Body Types
        $rows_body = vc_param_group_parse_atts($atts['body_types']);
        $body_cats = false;
        $get_body = '';
        $body_html = '';
        if (count((array)$rows_body) > 0) {
            $body_html .= '';
            foreach ($rows_body as $rows_bodytype) {
                if (isset($rows_bodytype['body_type'])) {
                    if ($rows_bodytype['body_type'] == 'all') {
                        $body_cats = true;
                        $body_html = '';
                        break;
                    }
                    $get_body = get_term_by('slug', $rows_bodytype['body_type'], 'ad_body_types');
                    if (count((array)$get_body) == 0)
                        continue;
                    $body_html .= '<option value="' . $get_body->name . '">' . $get_body->name . '</option>';
                }
            }

            if ($body_cats) {
                $all_types = carspot_get_cats('ad_body_types', 0);
                foreach ($all_types as $all_type) {
                    $body_html .= '<option value="' . $all_type->name . '">' . $all_type->name . '</option>';
                }
            }
        }

        $flip_it = '';
        if (is_rtl()) {
            $flip_it = 'flip';
        }

        return '<div class="search-bar">
            <div class="section-search search-style-2">
               <div class="container">
                  <div class="row">
                     <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                        <div class="clearfix">
                           <form method="get" action="' . get_the_permalink($carspot_theme['sb_search_page']) . '">
                              <div class="search-form pull-left ' . esc_attr($flip_it) . '">
                                 <div class="search-form-inner pull-left ' . esc_attr($flip_it) . '">
                                    <div class="col-md-3 col-sm-6 col-xs-12 no-padding">
                                       <div class="form-group">
                                         <label>' . $location_heading . '</label>
										 ' . $location_html . '
                                       </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12 no-padding">
                                       <div class="form-group">
                                          <label>' . esc_html__('Select Make', 'carspot') . '</label>
										  <select class="form-control" name="cat_id">
												<option label="' . esc_html__('Select Make', 'carspot') . '" value="">' . esc_html__('Select Make', 'carspot') . '</option>
												' . $cats_html . '
										  </select>
                                       </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12 no-padding">
                                       <div class="form-group">
                                         <label>' . esc_html__('Select Year', 'carspot') . '</label>
										  <select class=" form-control" name="year_from">
												<option label="' . esc_html__('Select Year', 'carspot') . '" value="">' . esc_html__('Select Year', 'carspot') . '</option>
												' . $years_html . '
										  </select>
                                       </div>
                                    </div>
									<div class="col-md-3 col-sm-6 col-xs-12 no-padding">
                                       <div class="form-group">
                                         <label>' . esc_html__('Body Type', 'carspot') . '</label>
										  <select class=" form-control" name="body_type">
												<option label="' . esc_html__('Select Body Type', 'carspot') . '" value="">' . esc_html__('Select Body Type', 'carspot') . '</option>
												' . $body_html . '
										  </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group pull-right ' . esc_attr($flip_it) . '">
                                    <button type="submit" id="submit_loader" value="submit" class="btn btn-lg btn-theme" >' . esc_html__('Search Now', 'carspot') . '</button>
                                 </div>
                              </div>
                              ' . cs_form_lang_field_callback(true) . '
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>';
    }
}
if (function_exists('carspot_add_code')) {
    carspot_add_code('minimal_searchbar_base', 'minimal_searchbar_base_func');
}