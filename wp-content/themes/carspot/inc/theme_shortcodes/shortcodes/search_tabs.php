<?php
/* ------------------------------------------------ */
/* Advance Search - Tabs*/
/* ------------------------------------------------ */
if (!function_exists('search_tabs')) {
	function search_tabs()
	{
		vc_map(array(
			"name" => esc_html__("Advance Search - Tabs", 'carspot'),
			"base" => "search_tabs",
			"category" => esc_html__("Theme Shortcodes", 'carspot'),
			"params" => array(
				array(
					'group' => esc_html__('Shortcode Output', 'carspot'),
					'type' => 'custom_markup',
					'heading' => esc_html__('Shortcode Output', 'carspot'),
					'param_name' => 'order_field_key',
					'description' => carspot_VCImage('search_tabs.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
							"value" => carspot_get_parests('ad_body_types', 'no'),
						),
						array(
							"group" => esc_html__("Basic", "carspot"),
							"type" => "attach_image",
							"holder" => "img",
							"heading" => esc_html__("Body Type Image", 'carspot'),
							"param_name" => "img",
							"description" => esc_html__('250x112', 'carspot'),
						),
					)
				),


			),
		));
	}
}

add_action('vc_before_init', 'search_tabs');

if (!function_exists('search_tabs_short_base_func')) {
	function search_tabs_short_base_func($atts, $content = '')
	{
		require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";

		extract(shortcode_atts(array(
			'cats' => '',
			'years' => '',
			'want_to_show' => '',
		), $atts));
		global $carspot_theme;

		if (isset($want_to_show) && $want_to_show == "yes") {
		}

		//For Make
		$rows = array();
		$cats	=	false;
		$cats_html	=	'';
		if(isset($atts['cats'])){
		$rows = vc_param_group_parse_atts($atts['cats']);
		}
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
		$rows_years = array();
		if(isset($atts['years'])){
		$rows_years = vc_param_group_parse_atts($atts['years']);
		}
		$year_cats	=	false;
		$years_html	=	'';
		$get_year = '';
		if (count((array) $rows_years) > 0) {
			$years_html .= '';
			foreach ($rows_years as $rows_year) {
				if (isset($rows_year['year'])) {
					if ($rows_year['year'] == 'all') {
						$year_cats = true;
						$years_html = '';
						break;
					}
					$get_year = get_term_by('slug', $rows_year['year'], 'ad_years');
					if (count((array) $get_year) == 0)
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

		$body_html	=	'';
		if (isset($atts['body_types'])) {
			$rows_body = vc_param_group_parse_atts($atts['body_types']);

			if (count((array) $rows_body) > 0) {
				foreach ($rows_body as $row_bodytypes) {
					if (isset($row_bodytypes['body_type']) && isset($row_bodytypes['img']) && $row_bodytypes['body_type'] != '') {
						$category = get_term_by('slug', $row_bodytypes['body_type'], 'ad_body_types');
						if (count((array) $category) == 0)
							continue;
						$bgImageURL	=	carspot_returnImgSrc($row_bodytypes['img']);
						if (isset($category->name) && $bgImageURL != "" && $category->name != "") {
							$body_html .= '<div class="col-md-2 col-sm-4 col-xs-6">
                     <div class="box">
					 <a href="' . carspot_texnomy_link_page($category->name, $cat_link_page) . '">
                         <img alt="' . $category->name . '" src="' . $bgImageURL . '">
                        <h4>' . $category->name . '</h4>
                       </a> 
                     </div>
                  </div>';
						}
					}
				}
			}
		}

		$flip_it = '';
		if (is_rtl()) {
			$flip_it = 'flip';
		}

		

		return   '<div class="advance-search">
         <div class="section-search search-style-2">
            <div class="container">
               <div class="row">
                  <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                     <!-- Nav tabs -->
                     <ul class="nav nav-tabs">
                        <li class="nav-item active">
                           <a class="nav-link" data-toggle="tab" href="#tab1">' . esc_html__('Search Car In Details', 'carspot') . ' </a>
                        </li>
						<li class="nav-item">
                           <a class="nav-link" data-toggle="tab" href="#tab2" >' . esc_html__('Search Car By Type', 'carspot') . '</a>
                        </li>
                     </ul>
                     <!-- Tab panes -->
                     <div class="tab-content clearfix">
                        <div class="tab-pane fade in active" id="tab1">
                           <form method="get" action="' . get_the_permalink($carspot_theme['sb_search_page']) . '">
                              <div class="search-form pull-left ' . esc_attr($flip_it) . '">
                                 <div class="search-form-inner pull-left ' . esc_attr($flip_it) . '">
                                    <div class="col-md-4 no-padding">
                                       <div class="form-group">
                                          <label>' . esc_html__('Keyword', 'carspot') . '</label>
										  <input autocomplete="off" name="ad_title" id="autocomplete-dynamic" class="form-control banner-icon-search" placeholder="' . esc_html__('What Are You Looking For...', 'carspot') . '" type="text">
                                       </div>
                                    </div>
                                    <div class="col-md-4 no-padding">
                                       <div class="form-group">
                                          <label>' . esc_html__('Select Make', 'carspot') . '</label>
										  <select class="form-control select-make" name="cat_id">
												<option label="' . esc_html__('Select Make', 'carspot') . '" value="">' . esc_html__('Select Make', 'carspot') . '</option>
												' . $cats_html . '
										  </select>
										  
                                       </div>
                                    </div>
                                    <div class="col-md-4 no-padding">
                                       <div class="form-group">
                                          <label>' . esc_html__('Select Year', 'carspot') . '</label>
										  <select class=" orm-control" name="year_from">
												<option label="' . esc_html__('Select Year', 'carspot') . '" value="">' . esc_html__('Select Year', 'carspot') . '</option>
												' . $years_html . '
										  </select>
                                         
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group pull-right ' . esc_attr($flip_it) . '">
                                    <button type="submit" id="submit_loader" value="submit" class="btn btn-lg btn-theme" >' . esc_html__('Search Now', 'carspot') . '</button>
                                 </div>
                              </div>
                              '. cs_form_lang_field_callback(true) .'
                           </form>
                        </div>
						
						<div class="tab-pane fade" id="tab2" >
                           <form>
                              <div class="search-form">
                                 <div class="search-form-inner-type">                                  
                                       ' . $body_html . '                                   
                                 </div>                                 
                              </div>
                              '. cs_form_lang_field_callback(true) .'
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>';
	}
}

if (function_exists('carspot_add_code')) {
	carspot_add_code('search_tabs', 'search_tabs_short_base_func');
}
