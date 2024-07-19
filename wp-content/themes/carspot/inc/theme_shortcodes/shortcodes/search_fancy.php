<?php
/* ------------------------------------------------ */
/* Search Fancy */
/* ------------------------------------------------ */
if (!function_exists('search_fancy_short')) {
	function search_fancy_short()
	{
		vc_map(array(
			"name" => esc_html__("Search - Fancy", 'carspot'),
			"base" => "search_fancy_short_base",
			"category" => esc_html__("Theme Shortcodes", 'carspot'),
			"params" => array(
				array(
					'group' => esc_html__('Shortcode Output', 'carspot'),
					'type' => 'custom_markup',
					'heading' => esc_html__('Shortcode Output', 'carspot'),
					'param_name' => 'order_field_key',
					'description' => carspot_VCImage('search-fancy.png') . esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
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
					"description" => '%count% ' . esc_html__("for total ads.", 'carspot'),
					"param_name" => "section_tag_line",
				),

				array(
					'group' => esc_html__('Slider', 'carspot'),
					'type' => 'param_group',
					'heading' => esc_html__('Add Slider Image', 'carspot'),
					'param_name' => 'slides',
					'value' => '',
					'params' => array(
						array(
							"type" => "attach_image",
							"holder" => "bg_img",
							"class" => "",
							"heading" => esc_html__("Background Image", 'carspot'),
							"param_name" => "img",
							"description" => esc_html__("1280x600", 'carspot'),
						),

					)
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
			),
		));
	}
}

add_action('vc_before_init', 'search_fancy_short');

if (!function_exists('search_fancy_short_base_func')) {
	function search_fancy_short_base_func($atts, $content = '')
	{
		extract(shortcode_atts(array(
			'section_title' => '',
			'section_tag_line' => '',
			'cats' => '',
			'slides' => '',
			'want_to_show' => '',
		), $atts));
		global $carspot_theme;
		// foreach(vc_param_group_parse_atts($atts['cats']) as $row)
		// {
		// 	print_r($row['cats']);
		// }
		// print_r($atts);
        $atts = array();
		$rows = vc_param_group_parse_atts($atts['cats']);
		print_r($rows);
		$rows = is_array($rows) ? $rows : "";

		$cats	=	false;
		$cats_html	=	'';
		$row = (array)$rows;
		$check_value = $row[0];

		// if (count((array) $rows) > 0) {
		if ($check_value!=="" && $check_value!==null ) {
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

		// Getting Slides
		$slides = vc_param_group_parse_atts($atts['slides']);
		$slider_html	=	'';
		if (count((array) $slides) > 0) {
			foreach ($slides as $slide) {
				if (isset($slide['img'])) {
					$slider_html .= '<div class="item linear-overlay"><img src="' . carspot_returnImgSrc($slide['img']) . '" alt="' . esc_html__('image', 'carspot') . '"></div>';
				}
			}
		}

		$count_posts = wp_count_posts('ad_post');

		return '<div class="background-rotator">
         <!-- slider start-->
         <div class="owl-carousel owl-theme background-rotator-slider">
            ' . $slider_html . '
         </div>
         <div class="search-section">
            <!-- Find search section -->
            <div class="container">
               <div class="row">
                  <div class="col-md-12">
                     <!-- Heading -->
                     <div class="content">
                     <div class="heading-caption">
                        <h1>' . esc_html($section_title) . '</h1>
                        <p>' . str_replace('%count%', '<strong>' . $count_posts->publish . '</strong>', $section_tag_line) . '</p>
                     </div>
                     <div class="search-form">
                        <form method="get" action="' . get_the_permalink($carspot_theme['sb_search_page']) . '">
                           <div class="row">
                              <div class="col-md-4 col-xs-12 col-sm-4">
                        <select class="category form-control" name="cat_id">
							<option label="' . esc_html__('Select Category', 'carspot') . '" value="">' . esc_html__('Select Category', 'carspot') . '</option>
				  		' . $cats_html . '
                        </select>
                              </div>
                              <!-- Input Field -->
                              <div class="col-md-4 col-xs-12 col-sm-4">
                                 <input type="text" id="autocomplete-dynamic" autocomplete="off" name="ad_title" class="form-control banner-icon-search" placeholder="' . esc_html__('Eg Honda Civic , Audi , Ford...', 'carspot') . '" />
                              </div>
                              <!-- Search Button -->
                              <div class="col-md-4 col-xs-12 col-sm-4">
                                 <button type="submit" class="btn btn-theme btn-block">' . esc_html__('Search', 'carspot') . ' <i class="fa fa-search" aria-hidden="true"></i></button>
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
	carspot_add_code('search_fancy_short_base', 'search_fancy_short_base_func');
}
