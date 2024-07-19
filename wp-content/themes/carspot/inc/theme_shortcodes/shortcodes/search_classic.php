<?php
/* ------------------------------------------------ */
/* Search Classic */
/* ------------------------------------------------ */
if (!function_exists('search_classic_short')) {
function search_classic_short()
{
	vc_map(array(
		"name" => esc_html__("Search - Classic", 'carspot') ,
		"base" => "search_classic_short_base",
		"category" => esc_html__("Theme Shortcodes", 'carspot') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'carspot' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'carspot' ),
		   'param_name' => 'order_field_key',
		   'description' => carspot_VCImage('search-classic.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'carspot' ),
		  ),	
		array(
			"group" => esc_html__("Basic", "carspot"),
			"type" => "attach_image",
			"holder" => "bg_img",
			"class" => "",
			"heading" => esc_html__( "Background Image", 'carspot' ),
			"param_name" => "bg_img",
			"description" => esc_html__("1280x800", 'carspot'),
		),
		array(
			"group" => esc_html__("Basic", "'carspot"),
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__( "Section Title", 'carspot' ),
			"param_name" => "section_title",
		),	
		
		array(
			"group" => esc_html__("Car By Detail", "carspot"),
			"type" => "dropdown",
			"heading" => esc_html__("Do you want to show category with their childs?", 'carspot') ,
			"param_name" => "want_to_show",
			"admin_label" => true,
			"value" => array(
				esc_html__('yes', 'carspot') => 'yes',
				esc_html__('no', 'carspot') => 'no',
			) ,
			'edit_field_class' => 'vc_col-sm-12 vc_column',
			"std" => '',
		),
		
		array
		(
			'group' => esc_html__( 'Categories', 'carspot' ),
			'type' => 'param_group',
			'heading' => esc_html__( 'Select Category ( All or Selective )', 'carspot' ),
			'param_name' => 'cats',
			'value' => '',
			'params' => array
			(
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Category", 'carspot') ,
					"param_name" => "cat",
					"admin_label" => true,
					"value" => carspot_cats(),
				),

			)
		),
		),
	));
}
}

add_action('vc_before_init', 'search_classic_short');

if (!function_exists('search_classic_short_base_func')) {
function search_classic_short_base_func($atts, $content = '')
{
	extract(shortcode_atts(array(
		'bg_img' => '',
		'section_title' => '',
		'section_tag_line' => '',
		'max_tags_limit' => '',
		'is_display_tags' => '',
		'cats' => '',
		'want_to_show' => '',
	) , $atts));
	global $carspot_theme;

		$rows = vc_param_group_parse_atts( $atts['cats'] );
		$cats	=	false;
		$cats_html	=	'';
		if( count((array) $rows ) > 0 )
		{
			$cats_html .= '';
			foreach($rows as $row )
			{
				if( isset( $row['cat'] )  )
				{
					if($row['cat'] == 'all' )
					{
						$cats = true;
						$cats_html = '';
						break;
					}
					$category = get_term_by('slug', $row['cat'], 'ad_cats');
					if( count((array) $category ) == 0 )
					continue;
					if(isset($want_to_show) && $want_to_show == "yes")
					{
					
						$ad_cats_sub	=	carspot_get_cats('ad_cats' , $category->term_id );
						if(count($ad_cats_sub) > 0 )
						{
							$cats_html .= '<option value="'.$category->term_id.'" >'.$category->name.'  ('.$category->count.')' ;
							foreach( $ad_cats_sub as $ad_cats_subz )
							{
								$cats_html .= '<option value="'.$ad_cats_subz->term_id.'">'.'&nbsp;&nbsp; - &nbsp;' .$ad_cats_subz->name.'  ('.$ad_cats_subz->count.') </option>';
							}
							$cats_html .='</option>';
						}
						else
						{
							$cats_html .= '<option value="'.$category->term_id.'">'.$category->name. '   ('.$category->count.')</option>';
						}
					}
					else
					{
						$cats_html .= '<option value="'.$category->term_id.'">'.$category->name. '   ('.$category->count.')</option>';
					}
				}
			}
			
			if( $cats )
			{
				$ad_cats = carspot_get_cats('ad_cats', 0 );
				foreach( $ad_cats as $cat )
				{
				
					if(isset($want_to_show) && $want_to_show == "yes")
					{
					//sub cat
						$ad_sub_cats	=	carspot_get_cats('ad_cats' , $cat->term_id );
						if(count($ad_sub_cats) > 0 )
						{
							$cats_html .= '<option value="'.$cat->term_id.'" >'.$cat->name.'  ('.$cat->count.')' ;
							foreach( $ad_sub_cats as $sub_cat )
							{
								$cats_html .= '<option value="'.$sub_cat->term_id.'">'.'&nbsp;&nbsp; - &nbsp;' .$sub_cat->name.'  ('.$sub_cat->count.') </option>';
							}
							$cats_html .='</option>';	
						}
						else
						{
							$cats_html .= '<option value="'.$cat->term_id.'">'.$cat->name.'   ('.$cat->count.')</option>';
						}
					}
					else
					{
						$cats_html .= '<option value="'.$cat->term_id.'">'.$cat->name.'   ('.$cat->count.')</option>';
					}
				}
				
			}
		}

$style = '';
if( $bg_img != "" )
{
$bgImageURL	=	carspot_returnImgSrc( $bg_img );
$style = ( $bgImageURL != "" ) ? ' style="background: rgba(0, 0, 0, 0) url('.$bgImageURL.') fixed center center no-repeat; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;"' : "";
}
carspot_load_search_countries();
wp_enqueue_script( 'google-map-callback');

return '<div id="banner" '.$style.'>
         <div class="container">
            <div class="search-container">
               <h2>'.esc_html($section_title).'</h2>
               <form method="get" action="'.get_the_permalink($carspot_theme['sb_search_page']).'">
                  <div class="col-md-4 col-sm-6 col-xs-12 no-padding">
                     <div class="form-group">
                        <input type="text" autocomplete="off" name="ad_title" placeholder="'.esc_html__('Search here...','carspot').'" class="form-control banner-icon-search"> 
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-6 col-xs-12 no-padding">
                     <div class="form-group">
                        <input type="text" class="form-control" name="location" id="sb_user_address" placeholder="'.esc_html__('Location...','carspot').'">
                     </div>
                  </div>
                  <div class="col-md-3 col-sm-9 col-xs-12 no-padding">
                     <div class="form-group">
                        <select class="category form-control" name="cat_id">
							<option label="'.esc_html__('Select Category','carspot').'" value="">'.esc_html__('Select Category','carspot').'</option>
				  		'.$cats_html.'
                        </select>
                     </div>
                  </div>
                  <div class="col-md-2 col-sm-3 col-xs-12 no-padding">
                     <div class="form-group form-action">
                        <button type="submit" class="btn btn-theme btn-search-submit">'.esc_html__('Search','carspot').'</button>
                     </div>
                  </div>
                  '. cs_form_lang_field_callback(true) .'
               </form>
            </div>
         </div>
      </div>';

}
}

if (function_exists('carspot_add_code'))
{
	carspot_add_code('search_classic_short_base', 'search_classic_short_base_func');
}