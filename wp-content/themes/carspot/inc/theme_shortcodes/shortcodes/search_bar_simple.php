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
					'description' => carspot_VCImage('minimal_searchbar_base.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
				),

				array(
					"group" => esc_html__("Car By Detail", "carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Section Title", 'carspot'),
					"param_name" => "section_title",
				),
				array(
					"group" => esc_html__("Car By Detail", "carspot"),
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
					"group" => esc_html__("Car By Detail", "carspot"),
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
							"value" => carspot_get_parests('ad_years', 'yes'),
						),

					)
				),




				array(
					"group" => esc_html__("Tab 2", "carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Section Title", 'carspot'),
					"param_name" => "section_title",
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
							"value" => carspot_get_parests('ad_body_types', 'yes'),
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
			'cats' => '',
			'years' => '',
			'want_to_show' => '',
		), $atts));
		global $carspot_theme;

		//For Make
		$rows = vc_param_group_parse_atts($atts['cats']);
		$cats	=	false;
		$cats_html	=	'';
		if (count((array) $rows) > 0) {
			$cats_html .= '';
			foreach ($rows as $row) {
				if (isset($row['cat'])) {
					if ($row['cat'] == 'all') {
						$cats = true;
						$cats_html = '';
						break;
					}
					$category = get_term_by('slug', $row['cat'], 'ad_cats');
					if (count((array) $category) == 0)
						continue;

					if (isset($want_to_show) && $want_to_show == "yes") {

						$ad_cats_sub	=	carspot_get_cats('ad_cats', $category->term_id);
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
						$ad_sub_cats	=	carspot_get_cats('ad_cats', $cat->term_id);
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
		$year_cats	=	false;
		$years_html	=	'';
		if (count((array) $rows_years) > 0) {
			$years_html .= '';
			foreach ($rows_years as $rows_year) {
				if (isset($rows_year['year'])) {
					if ($rows_year['year'] == 'all') {
						$year_cats = true;
						$years_html = '';
						break;
					}
					$term_get =  get_term($rows_year['year']);
					$years_html .= '<option value="' . $rows_year['year'] . '">' . $term_get->name . '</option>';
				}
			}

			if ($year_cats) {

				$all_years = carspot_get_cats('ad_years', 0);
				foreach ($all_years as $all_year) {
					$years_html .= '<option value="' . $all_year->name . '">' . $all_year->name . '</option>';
				}
			}
		}
		return '<div class="search-bar">
            <div class="section-search search-style-2">
               <div class="container">
                  <div class="row">
                     <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                        <div class="clearfix">
                           <form method="get" action="' . get_the_permalink($carspot_theme['sb_search_page']) . '">
                              <div class="search-form pull-left">
                                 <div class="search-form-inner pull-left">
                                    <div class="col-md-3 col-sm-6 col-xs-12 no-padding">
                                       <div class="form-group">
                                         <label>' . esc_html__('Keyword', 'carspot') . '</label>
										  <input autocomplete="off" name="ad_title" id="autocomplete-dynamic" class="form-control banner-icon-search" placeholder="Eg Honda Civic , Audi , Ford." type="text">
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
										  <select class=" orm-control" name="year_from">
												<option label="' . esc_html__('Select Year', 'carspot') . '" value="">' . esc_html__('Select Year', 'carspot') . '</option>
												' . $years_html . '
										  </select>
                                       </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12 no-padding">
                                       <div class="form-group">
                                          <label>Select Location</label>
                                          <select class="search-loaction form-control">
                                             <option label="location"></option>
                                             <option value="0">America</option>
                                             <option value="1">Australia</option>
                                             <option value="2">Africa</option>
                                             <option value="3">Pakistan</option>
                                             <option value="4">Japan</option>
                                             <option value="5">Srilanka</option>
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group pull-right">
                                    <button type="submit" value="submit" class="btn btn-lg btn-theme" >' . esc_html__('Search Now', 'carspot') . '</button>
                                 </div>
                              </div>
                              '. cs_form_lang_field_callback(true) .'
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
