<?php
/* ------------------------------------------------ */
/* Advance Search - Tabs*/
/* ------------------------------------------------ */
if (!function_exists('search_tabs_classified')) {
	function search_tabs_classified()
	{
		vc_map(array(
			"name" => esc_html__("Classifed Search - Tabs", 'carspot'),
			"base" => "search_tabs_classified",
			"category" => esc_html__("Theme Shortcodes", 'carspot'),
			"params" => array(
				array(
					'group' => esc_html__('Shortcode Output', 'carspot'),
					'type' => 'custom_markup',
					'heading' => esc_html__('Shortcode Output', 'carspot'),
					'param_name' => 'order_field_key',
					'description' => carspot_VCImage('search_tabs_classified.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
				),

				array(
					"group" => esc_html__("Basic", "carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("First Tab Heading", 'carspot'),
					"param_name" => "first_tab",
				),
				array(
					"group" => esc_html__("Basic", "carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Second Tab Heading", 'carspot'),
					"param_name" => "second_tab",
				),

				array(
					"group" => esc_html__("General Tab", "carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Keyword Field Title", 'carspot'),
					"param_name" => "section_title",
				),


				array(
					"group" => esc_html__("General Tab", "carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Category Field Title", 'carspot'),
					"param_name" => "category_title",
				),

				array(
					"group" => esc_html__("General Tab", "carspot"),
					"type" => "dropdown",
					"heading" => esc_html__("Do you want to show category with their childs?", 'carspot'),
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
					"group" => esc_html__("General Tab", "carspot"),
					'type' => 'param_group',
					'heading' => esc_html__('Select Category ( All or Selective )', 'carspot'),
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
					"group" => esc_html__("General Tab", "carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Price Field Title", 'carspot'),
					"param_name" => "price_title",
				),

				array(
					"group" => esc_html__("General Tab", "carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Minimum Price", 'carspot'),
					"param_name" => "pricing_start",
				),
				array(
					"group" => esc_html__("General Tab", "carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => __("Maximum Price", 'carspot'),
					"param_name" => "pricing_end",
				),

				array(
					"group" => esc_html__("Category Tab", "carspot"),
					'type' => 'param_group',
					'heading' => esc_html__('Select Category', 'carspot'),
					'param_name' => 'category_types',
					'value' => '',
					'params' => array(
						array(
							"type" => "dropdown",
							"heading" => esc_html__("Category", 'carspot'),
							"param_name" => "cat",
							"admin_label" => true,
							"value" => carspot_get_parests('ad_cats', 'no'),
						),
						array(
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

add_action('vc_before_init', 'search_tabs_classified');

if (!function_exists('search_tabs_classified_short_base_func')) {
	function search_tabs_classified_short_base_func($atts, $content = '')
	{
		require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
		extract(shortcode_atts(array(
			'section_title' => '',
			'category_title' => '',
			'cats' => '',
			'years' => '',
			'pricing_start' => '',
			'pricing_end' => '',
			'price_title' => '',
			'first_tab' => '',
			'second_tab' => '',
			'want_to_show' => '',
		), $atts));
		global $carspot_theme;
		//For Category
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


		$catz_html	=	'';
		if (isset($atts['category_types'])) {
			$rows_cat = vc_param_group_parse_atts($atts['category_types']);

			if (count((array) $rows_cat) > 0) {
				$counter = 0;
				foreach ($rows_cat as $rows_cats) {
					if (isset($rows_cats['cat']) && isset($rows_cats['img']) && $rows_cats['cat'] != '') {
						$category = get_term_by('slug', $rows_cats['cat'], 'ad_cats');
						if (count((array) $category) == 0)
							continue;
						$bgImageURL	=	carspot_returnImgSrc($rows_cats['img']);
						if (isset($category->name) && $bgImageURL != "" && $category->name != "") {
							$catz_html .= '<div class="col-md-2 col-sm-4 col-xs-6">
                     <div class="box">
					 <a href="' . carspot_cat_link_page($category->term_id, $cat_link_page) . '">
                         <img alt="' . $category->name . '" src="' . $bgImageURL . '">
                        <h4>' . $category->name . '</h4>
                       </a> 
                     </div>
                  </div>';
							if (++$counter % 6 == 0) {
								$catz_html .=  "<div class='clearfix visible-md visible-lg'></div>";
							}
						}
					}
				}
			}
		}

		$flip_it = '';
		if (is_rtl()) {
			$flip_it = 'flip';
		}

		wp_enqueue_script('price-slider-custom', trailingslashit(get_template_directory_uri()) . 'js/price_slider_shortcode.js', array(), false, true);

		$price_html = '<input type="hidden" id="min_price" value="' . esc_attr($pricing_start) . '" />
          <input type="hidden" id="max_price" value="' . esc_attr($pricing_end) . '" />
          <input type="hidden" name="min_price" id="min_selected" value="" />
          <input type="hidden" name="max_price" id="max_selected" value="" />
';


		return   '<div class="advance-search">
         <div class="section-search search-style-2">
            <div class="container">
               <div class="row">
                  <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                     <!-- Nav tabs -->
                     <ul class="nav nav-tabs">
                        <li class="nav-item active">
                           <a class="nav-link" data-toggle="tab" href="#classified_tab1">' . $first_tab . '</a>
                        </li>
						<li class="nav-item">
                           <a class="nav-link" data-toggle="tab" href="#classified_tab2" >' . $second_tab . '</a>
                        </li>
                     </ul>
                     <!-- Tab panes -->
                     <div class="tab-content clearfix">
                        <div class="tab-pane fade in active" id="classified_tab1">
                           <form method="get" action="' . get_the_permalink($carspot_theme['sb_search_page']) . '">
						   ' . $price_html . '
                              <div class="search-form pull-left ' . esc_attr($flip_it) . '">
                                 <div class="search-form-inner pull-left ' . esc_attr($flip_it) . '">
                                    <div class="col-md-4 no-padding">
                                       <div class="form-group">
                                          <label>' . $section_title . '</label>
										  <input autocomplete="off" name="ad_title" id="autocomplete-dynamic" class="form-control banner-icon-search" placeholder="' . esc_html__('What Are You Looking For...', 'carspot') . '" type="text">
                                       </div>
                                    </div>
                                    <div class="col-md-4 no-padding">
                                       <div class="form-group">
                                          <label>' . $category_title . '</label>
										  <select class="form-control" name="cat_id">
												<option label="' . esc_html__('Select Option', 'carspot') . '" value="">' . esc_html__('Select Option', 'carspot') . '</option>
												' . $cats_html . '
										  </select>
										  
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
										  <span class="price-slider-value">' . $price_title . ' (' . $carspot_theme['sb_currency'] . ') <span id="price-min"></span> - <span id="price-max"></span></span>
                     <div id="price-slider"></div>
                                         
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
						
						<div class="tab-pane fade" id="classified_tab2" >
                              <div class="search-form">
                                 <div class="search-form-inner-type">                                  
                                       ' . $catz_html . '                                   
                                 </div>                                 
                              </div>
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
	carspot_add_code('search_tabs_classified', 'search_tabs_classified_short_base_func');
}
