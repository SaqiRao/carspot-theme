<?php
/* ------------------------------------------------ */
/* Search Modern */
/* ------------------------------------------------ */
if (!function_exists('search_modern_short')) {
	function search_modern_short()
	{
		vc_map(array(
			"name" => esc_html__("Search - Modern", 'carspot'),
			"base" => "search_modern_short_base",
			"category" => esc_html__("Theme Shortcodes", 'carspot'),
			"params" => array(
				array(
					'group' => esc_html__('Shortcode Output', 'carspot'),
					'type' => 'custom_markup',
					'heading' => esc_html__('Shortcode Output', 'carspot'),
					'param_name' => 'order_field_key',
					'description' => carspot_VCImage('search-modern.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
				),
				array(
					"group" => esc_html__("Basic", "carspot"),
					"type" => "attach_image",
					"holder" => "bg_img",
					"class" => "",
					"heading" => esc_html__("Background Image", 'carspot'),
					"param_name" => "bg_img",
					"description" => esc_html__("1280x800", 'carspot'),
				),
				array(
					"group" => esc_html__("Basic", "'carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Section Title", 'carspot'),
					"param_name" => "section_title",
				),
				array(
					"group" => esc_html__("Basic", "'carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Section Tagline", 'carspot'),
					"description" => esc_html__("%count% for total ads.", 'carspot'),
					"param_name" => "section_tag_line",
				),

				array(
					'group' => esc_html__('Categories', 'carspot'),
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
					'group' => esc_html__('Categories', 'carspot'),
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


			),
		));
	}
}

add_action('vc_before_init', 'search_modern_short');
if (!function_exists('search_modern_short_base_func')) {
	function search_modern_short_base_func($atts, $content = '')
	{
		extract(shortcode_atts(array(
			'bg_img' => '',
			'section_title' => '',
			'section_tag_line' => '',
			'cats' => '',
			'years' => '',
			'want_to_show' => '',
		), $atts));
		global $carspot_theme;

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



		$style = '';
		if ($bg_img != "") {
			$bgImageURL	=	carspot_returnImgSrc($bg_img);
			$style = ($bgImageURL != "") ? ' style="background: rgba(0, 0, 0, 0) url(' . $bgImageURL . ') no-repeat scroll center center / cover;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;"' : "";
		}

		$count_posts = wp_count_posts('ad_post');
		return  ' <section class="main-search parallex " ' . $style . '>
<div class="container">
      <div class="row">
      <div class="col-md-12">
         <div class="main-search-title">
            <h1>' . esc_html($section_title) . '</h1>
            <p>' . str_replace('%count%', '<strong>' . $count_posts->publish . '</strong>', $section_tag_line) . '</p>
         </div>
         <form method="get" action="' . get_the_permalink($carspot_theme['sb_search_page']) . '">
         <div class="search-section">
            <div id="form-panel">
               <ul class="list-unstyled search-options clearfix">
                  <li>
					<select class="category form-control" name="cat_id">
					<option label="' . esc_html__('Select Make : Any make', 'carspot') . '" value="">' . esc_html__('Select Make : Any make', 'carspot') . '</option>
				  		' . $cats_html . '
					</select>	
                  </li>
                  <li>
                     <input type="text" autocomplete="off" id="autocomplete-dynamic" class="form-control banner-icon-search" name="ad_title" placeholder="' . esc_html__('Audi A4 For Sale....', 'carspot') . '">
                  </li>
                   <li>
					  <select class="form-control" name="year_from">
							<option label="' . esc_html__('Select Year : Any Year', 'carspot') . '" value="">' . esc_html__('Select Year : Any Year', 'carspot') . '</option>
							' . $years_html . '
					  </select>
                  </li>
                  <li>
                     <button type="submit" class="btn btn-danger btn-lg btn-block">' . esc_html__('Search', 'carspot') . '</button>
                  </li>
               </ul>
            </div>
         </div>
         '. cs_form_lang_field_callback(true) .'
		 </form>
         </div>
         </div>
       </div>
      
      </section>
							  ';
	}
}
if (function_exists('carspot_add_code')) {
	carspot_add_code('search_modern_short_base', 'search_modern_short_base_func');
}
