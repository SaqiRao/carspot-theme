<?php
/* ------------------------------------------------ */
/* Search Minimal */
/* ------------------------------------------------ */
if (!function_exists('search_minimal_short')) {
function search_minimal_short()
{
	vc_map(array(
		"name" => esc_html__("Search - Minimal", 'carspot') ,
		"base" => "search_minimal_short_base",
		"category" => esc_html__("Theme Shortcodes", 'carspot') ,
		"params" => array(
		array(
		   'group' => esc_html__( 'Shortcode Output', 'carspot' ),  
		   'type' => 'custom_markup',
		   'heading' => esc_html__( 'Shortcode Output', 'carspot' ),
		   'param_name' => 'order_field_key',
		   'description' => carspot_VCImage('search-minimal.png').esc_html__( 'Ouput of the shortcode will be look like this.', 'carspot' ),
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

add_action('vc_before_init', 'search_minimal_short');

if (!function_exists('search_minimal_short_base_func')) {
function search_minimal_short_base_func($atts, $content = '')
{
	extract(shortcode_atts(array(
		'cats' => '',
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
					$cats_html .= '<option value="'.$category->term_id.'">'.$category->name.'</option>';
				}
			}
			
			if( $cats )
			{
				$ad_cats = get_terms( 'ad_cats', array( 'hide_empty' => 0 ) );
				foreach( $ad_cats as $cat )
				{
					$cats_html .= '<option value="'.$cat->term_id.'">'.$cat->name.'</option>';
				}
			}
		}

	
	
carspot_load_search_countries();
wp_enqueue_script( 'google-map-callback');

return '<div id="search-section">
         <div class="container">
            <div class="row">
            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
				  <form method="get" action="'.get_the_permalink($carspot_theme['sb_search_page']).'" class="search-form">
                     <div class="col-md-3 col-xs-12 col-sm-4 no-padding">
                        <select class="category form-control" name="cat_id">
							<option label="'.esc_html__('Select Category','carspot').'" value="">'.esc_html__('Select Category','carspot').'</option>
				  		'.$cats_html.'
                        </select>
                     </div>
                     <!-- Search Field -->
                     <div class="col-md-6 col-xs-12 col-sm-4 no-padding">
                        <input type="text" autocomplete="off" name="ad_title" class="form-control" placeholder="'.esc_html__('What Are You Looking For...','carspot').'" />
                     </div>
                     <div class="col-md-3 col-xs-12 col-sm-4 no-padding">
                        <button type="submit" class="btn btn-block btn-light">'.esc_html__('Search','carspot').'</button>
                     </div>
                     '. cs_form_lang_field_callback(true) .'
                  </form>
                  </div>
               </div>
         </div>
      </div>';

}
}

if (function_exists('carspot_add_code'))
{
	carspot_add_code('search_minimal_short_base', 'search_minimal_short_base_func');
}