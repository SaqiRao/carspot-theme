<?php
/* ------------------------------------------------ */
/* Cats Classic */
/* ------------------------------------------------ */
if (!function_exists('cats_classic_short')) {
    function cats_classic_short()
    {
        vc_map(array(
            "name" => __("Categories - Classic", 'carspot'),
            "base" => "cats_classic_short_base",
            "category" => __("Theme Shortcodes", 'carspot'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'carspot'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'carspot'),
                    'param_name' => 'order_field_key',
                    'description' => carspot_VCImage('fancy_cats.png') . __('Ouput of the shortcode will be look like this.', 'carspot'),
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
                    "description" => esc_html__('For color ', 'carspot') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . esc_html__('warp text within this tag', 'carspot') . '<strong>' . esc_html('{/color}') . '</strong>',
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
                    "group" => __("Basic", "'carspot"),
                    "type" => "dropdown",
                    "heading" => __("Sub cats limit", 'carspot'),
                    "param_name" => "sub_limit",
                    "admin_label" => true,
                    "value" => range(0, 50),
                ),

                array
                (
                    'group' => __('Categories', 'carspot'),
                    'type' => 'param_group',
                    'heading' => __('Select Category', 'carspot'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                    (
                        array(
                            "type" => "dropdown",
                            "heading" => __("Category", 'carspot'),
                            "param_name" => "cat",
                            "admin_label" => true,
                            "value" => carspot_get_parests('ad_cats', 'no'),
                        ),
                        array(
                            'type' => 'iconpicker',
                            'heading' => __('Icon', 'carspot'),
                            'param_name' => 'icon',
                            'settings' => array(
                                'emptyIcon' => false,
                                'type' => 'classified',
                                'iconsPerPage' => 100, // default 100, how many icons per/page to display
                            ),
                        ),

                    )
                ),

            ),
        ));
    }
}

add_action('vc_before_init', 'cats_classic_short');

if (!function_exists('cats_classic_short_base_func')) {
    function cats_classic_short_base_func($atts, $content = '')
    {
        global $carspot_theme;

        $bg_bootom = 'yes';
        require trailingslashit(get_template_directory()) . "inc/theme_shortcodes/shortcodes/layouts/header_layout.php";
        $parallex = '';
        if ($section_bg == 'img') {
            $parallex = 'parallex';
        }
        $categories_html = '';
        if (isset($atts['cats'])) {
            $rows = vc_param_group_parse_atts($atts['cats']);
            $counter = 1;
            if (count((array)$rows) > 0) {
                foreach ($rows as $row) {
                    if (isset($row['cat']) && isset($row['icon']) && $row['cat'] != "") {

                        $category = get_term_by('slug', $row['cat'], 'ad_cats');
                        if (count((array)$category) == 0)
                            continue;
                        $sub_cat_html = '';
                        $ad_sub_cats = carspot_get_cats('ad_cats', $category->term_id);
                        $i = 1;
                        if ($sub_limit != 0) {
                            foreach ($ad_sub_cats as $sub_cat) {
                                $sub_cat_html .= '<li>
							<a href="' . carspot_cat_link_page($sub_cat->term_id, $cat_link_page) . '">
							' . $sub_cat->name . '<span>' . $sub_cat->count . '</span>
							</a>
							</li>';
                                if ($i == $sub_limit) {
                                    break;
                                }
                                $i++;
                            }
                        }
                        $categories_html .= '
					<div class="col-md-3 col-sm-6">
                        <div class="category-classic">
                           <div class="category-classic-icon">
                              <i class="' . $row['icon'] . '"></i>
                              <div class="category-classic-title">
                                 <h5>
								 <a href="' . carspot_cat_link_page($category->term_id, $cat_link_page) . '">
								 ' . $category->name . '
								 </a>
								 </h5>
                              </div>
                           </div>
                           <ul class="category-classic-data">
                              ' . $sub_cat_html . '
                           </ul>
						   <div class="clearfix"></div>
                           <div class="traingle"></div>
                           <div class="post-tag-section clearfix">
						   <a href="' . carspot_cat_link_page($category->term_id, $cat_link_page) . '">
						   <div class="cat-all">' . __('View All', 'carspot') . '</div>
						   </a>
						   </div>
                        </div>
                     </div>
					';
                        if ($counter % 4 == 0) {
                            $categories_html .= '<div class="clearfix"></div>';
                        }
                        $counter++;
                    }
                }
            }
        }

        return '<section class="custom-padding categories  ' . $parallex . ' ' . $bg_color . ' ' . $top_padding . '"' . $style . '>
            <div class="container">
               <div class="row">
			   		' . $header . '
                  <div class="col-md-12 col-xs-12 col-sm-12">
				  	<div class="row">
				  		' . $categories_html . '
					</div>	
				</div>
			   </div>
            </div>
         </section>
';
    }
}

if (function_exists('carspot_add_code')) {
    carspot_add_code('cats_classic_short_base', 'cats_classic_short_base_func');
}

?>
