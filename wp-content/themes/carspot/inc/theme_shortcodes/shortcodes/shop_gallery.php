<?php
/* ------------------------------------------------ */
/* Services */
/* ------------------------------------------------ */
if (!function_exists('shop_gallery')) {
	function shop_gallery()
	{
		vc_map(array(
			"name" => esc_html__("Shop Tabs", 'carspot'),
			"base" => "shop_gallery_base",
			"category" => esc_html__("Theme Shortcodes", 'carspot'),
			"params" => array(
				array(
					'group' => esc_html__('Shortcode Output', 'carspot'),
					'type' => 'custom_markup',
					'heading' => esc_html__('Shortcode Output', 'carspot'),
					'param_name' => 'order_field_key',
					'description' => carspot_VCImage('shop_tabs.png') .  esc_html__('Ouput of the shortcode will be look like this.', 'carspot'),
				),
				array(
					"group" => esc_html__("Basic", "carspot"),
					"type" => "dropdown",
					"heading" => esc_html__("Background Color", 'carspot'),
					"param_name" => "section_bg",
					"admin_label" => true,
					"value" => array(
						esc_html__('Select Background Color', 'carspot') => '',
						esc_html__('White', 'carspot') => '',
						esc_html__('Gray', 'carspot') => 'gray',
						esc_html__('Image', 'carspot') => 'img'
					),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
					"std" => '',
					"description" => esc_html__("Select background color.", 'carspot'),
				),


				array(
					"group" => esc_html__("Basic", "carspot"),
					"type" => "dropdown",
					"heading" => esc_html__("Section Top Padding", 'carspot'),
					"param_name" => "section_padding",
					"admin_label" => true,
					"value" => array(
						esc_html__('Select Section Padding', 'carspot') => '',
						esc_html__('No', 'carspot') => '',
						esc_html__('Yes', 'carspot') => 'yes',
					),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
					"std" => '',
					"description" => esc_html__("Remove Padding From Section Top.", 'carspot'),
				),


				array(
					"group" => esc_html__("Basic", "carspot"),
					"type" => "attach_image",
					"holder" => "bg_img",
					"class" => "",
					"heading" => esc_html__("Background Image", 'carspot'),
					"param_name" => "bg_img",
					'dependency' => array(
						'element' => 'section_bg',
						'value' => array('img'),
					),
				),

				array(
					"group" => esc_html__("Basic", "'carspot"),
					"type" => "dropdown",
					"heading" => esc_html__("Header Style", 'carspot'),
					"param_name" => "header_style",
					"admin_label" => true,
					"value" => array(
						esc_html__('Section Header Style', 'carspot') => '',
						esc_html__('No Header', 'carspot') => '',
						esc_html__('Classic', 'carspot') => 'classic',
						esc_html__('Regular', 'carspot') => 'regular'
					),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
					"std" => '',
					"description" => esc_html__("Chose header style.", 'carspot'),
				),
				array(
					"group" => esc_html__("Basic", "'carspot"),
					"type" => "textfield",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Section Title", 'carspot'),
					"param_name" => "section_title",
					"description" =>  esc_html__('For color ', 'carspot') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . esc_html__('warp text within this tag', 'carspot') . '<strong>' . esc_html('{/color}') . '</strong>',
					'edit_field_class' => 'vc_col-sm-12 vc_column',
					'dependency' => array(
						'element' => 'header_style',
						'value' => array('classic', 'regular'),
					),
				),

				array(
					"group" => esc_html__("Basic", "'carspot"),
					"type" => "textarea",
					"holder" => "div",
					"class" => "",
					"heading" => esc_html__("Section Description", 'carspot'),
					"param_name" => "section_description",
					"value" => "",
					'edit_field_class' => 'vc_col-sm-12 vc_column',
					'dependency' => array(
						'element' => 'header_style',
						'value' => array('classic', 'regular'),
					),
				),

				array(
					"group" => esc_html__("Products Settings", "'carspot"),
					"type" => "dropdown",
					"heading" => esc_html__("Number fo Ads", 'carspot'),
					"param_name" => "no_of_ads",
					"admin_label" => true,
					"value" => range(1, 50),
				),

				array(
					"group" => esc_html__("Products Settings", "'carspot"),
					"type" => "dropdown",
					"heading" => esc_html__("Order By", 'carspot'),
					"param_name" => "ad_order",
					"admin_label" => true,
					"value" => array(
						esc_html__('Select Ads order', 'carspot') => '',
						esc_html__('Oldest', 'carspot') => 'asc',
						esc_html__('Latest', 'carspot') => 'desc',
						esc_html__('Random', 'carspot') => 'rand'
					),
				),


				array(
					"group" => esc_html__("Products Settings", "'carspot"),
					"type" => "vc_link",
					"heading" => esc_html__("Read More Link", 'carspot'),
					"param_name" => "main_link",
					"description" => esc_html__("Link You Want To Ridirect.", "'carspot"),
				),


				array(
					'group' => esc_html__('Categories', 'carspot'),
					'type' => 'param_group',
					'heading' => esc_html__('Select Category', 'carspot'),
					'param_name' => 'cats',
					'value' => '',
					'params' => array(
						array(
							"type" => "dropdown",
							"heading" => esc_html__("Category", 'carspot'),
							"param_name" => "cat",
							"admin_label" => true,
							"value" => carspot_get_parests('product_cat', 'no'),

						),
					)
				),



			),
		));
	}
}

add_action('vc_before_init', 'shop_gallery');
if (!function_exists('shop_gallery_base_func')) {
	function shop_gallery_base_func($atts, $content = '')
	{
		require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";


		$parallex	=	'';
		if ($section_bg == 'img') {
			$parallex	=	'parallex';
		}
		$button = '';
		$button = carspot_ThemeBtn($main_link, 'btn btn-lg  btn-theme', false, false, '<i class="fa fa-refresh"></i>');

		extract(shortcode_atts(array(
			'cats' => '',
			'ad_order' => '',
			'no_of_ads' => '',
			'main_link' => '',
			'shop_type' => '',
		), $atts));
		$cats =	array();
		$rows = vc_param_group_parse_atts($atts['cats']);
		$categories_html	= '';
		$categories_contents	= '';
		$counnt = 1;
		$is_all	=	false;
		$html = '';
		if (!isset($atts['cats'])) return $html;
		if (count((array) $rows) > 0) {
			foreach ($rows as $row) {
				if (isset($row['cat'])) {
					$is_active = '';
					if ($counnt == 1) {
						$is_active = 'active';
						$counnt++;
					}
					$category = get_term_by('slug', $row['cat'], 'product_cat');
					if (count((array) $category) == 0)
						continue;

					$categories_html .= ' <li role="presentation" class="' . esc_attr($is_active) . '">
                              <a data-toggle="tab" title="' . $category->name . '" role="tab" href="#' . $category->slug . '" aria-expanded="true">' . $category->name . '</a>
                           </li>';
					$categories_contents .= '<div id="' . $category->slug . '" role="tabpanel" class="tab-pane in fade ' . esc_attr($is_active) . '">';
				}

				$category	=	'';
				if (count((array) $row['cat']) > 0) {
					$category	=	array(
						array(
							'taxonomy' => 'product_cat',
							'field'    => 'slug',
							'terms'    => $row['cat'],
						),
					);
				}

				$ordering	=	'DESC';
				$order_by	=	'date';
				if ($ad_order == 'asc') {
					$ordering	=	'ASC';
				} else if ($ad_order == 'desc') {
					$ordering	=	'DESC';
				} else if ($ad_order == 'rand') {
					$order_by	=	'rand';
				}
				$args = array(
					'post_type' => 'product',
					'posts_per_page' => $no_of_ads,
					'tax_query' => array(
						$category,
						array(
							'taxonomy' => 'product_type',
							'field' => 'slug',
							'terms' => 'carspot_packages_pricing',
							'operator' => 'NOT IN'
						),
						array(
							'taxonomy' => 'product_type',
							'field' => 'slug',
							'terms' => 'carspot_category_pricing',
							'operator' => 'NOT IN'
						),
					),
					'orderby'        => $order_by,
					'order'        => $ordering,
				);
				$results = new WP_Query($args);
				if (count((array) $results) > 0) {
					$counter = 0;
					while ($results->have_posts()) {
						$results->the_post();
						$product	=	wc_get_product(get_the_ID());
						$img	=	$product->get_image_id();
						$photo	=	 wp_get_attachment_image_src($img, 'medium');
						$final_img	=	'';
						if ($photo[0] != "") {
							$final_img	= '<img class="img-responsive" alt="' . get_the_title(get_the_ID()) . '" src="' . esc_url($photo[0]) . '">';
						} else {
							$final_img	= '<img class="img-responsive custom_holder" alt="' . get_the_title(get_the_ID()) . '" src="' . wc_placeholder_img_src() . '">';
						}
						// Start Ratiing
						$ratting	=	$product->get_average_rating();
						$ratting_html	=	'';
						for ($star = 1; $star <= 5; $star++) {
							$is_filled	=	'';
							if ($star <= $ratting) {
								$is_filled	=	'filled';
							}
							$ratting_html	.=	'<i class="fa fa-star-o ' . esc_html($is_filled) . '"></i>';
						}
						// Price
						$pricing	=	'';
						if ($product->get_type() != 'grouped') {
							if ($product->get_type() == 'variable') {
								$pricing	= wc_price(get_post_meta(get_the_ID(), '_min_variation_price', true));
								$pricing	.= '-' . wc_price(get_post_meta(get_the_ID(), '_max_variation_price', true));
							} else {
								$pricing	=	wc_price($product->get_sale_price());
							}
						}
						$reviews = '';
						$reviews	=	$product->get_review_count() . " " . esc_html__('Reviews', 'carspot');
						$categories_contents  .= '<div class="col-md-3 col-sm-6 col-xs-12 ">
                     <div class="shop-grid">
                        <div class="shop-product"> 
						' . $final_img . '
                        <div class="shop-product-description">
                           <h2><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>
                           <div class="rating-stars">' . $ratting_html . '
						   <a href="javascript:void(0)">(' . esc_html($reviews) . ')</a>
						   </div>
						   		<span>' . $pricing . '</span>
						   </div>

                     		</div>
					 </div>
					 </div>';
						if (++$counter % 4 == 0) {
							$categories_contents .=  '<div class="clearfix"></div>';
						}
					}
					wp_reset_postdata();
				}
				$categories_contents .= '</div>';
			}
		}
		return '<section class="custom-padding ' . $parallex . ' ' . $bg_color . ' ' . $top_padding . '" ' . $style . '>
				<!-- Main Container -->
				<div class="container">
				   <!-- Row -->
				   <div class="row">
						' . $header . '
					<div class="recent-tab">	
						<ul class="nav nav-tabs" role="tablist">' . $categories_html . '</ul>
					</div>
					<div class="tab-content">
							' . $categories_contents . '
					</div>
                        <div class="clearfix"></div>
                     </div>
				</div>
			</section>';
	}
}


if (function_exists('carspot_add_code')) {
	carspot_add_code('shop_gallery_base', 'shop_gallery_base_func');
}
