<?php
global $carspot_theme; ?>
<?php
		$layout = $carspot_theme['search_layout'];
		if( isset( $type ) )
		{
			$layout = $type;
		}	
	 	$is_feature	=	'';
		$is_feature	=	array( 'key'=> '_carspot_is_feature', 'value'   => 0, 'compare' => '=', );		
		$out	=	'';
		$args = array(  'post_type' => 'ad_post', 'meta_query' => array( $is_feature, ), 'orderby'        => 'ID', 'order'        => 'DESC', );
		/*The Loop*/
	   $results = new WP_Query( $args );
        while ( $results->have_posts() )
        {
            $results->the_post();
            $pid	=	get_the_ID();
            $ads	=	 new ads();
            $option	=	$layout;
            $function	=	"carspot_search_layout_$option";
            $out	.= $ads->$function( $pid );
        }
		
		
			$is_feature	=	'';
			
			$is_feature	=	array( 'key'     => '_carspot_is_feature', 'value'   => 1, 'compare' => '=', );		
			
			
			$outz	=	'';
			
			$argss = array( 
				'post_type' => 'ad_post', 'meta_query' => array( $is_feature, ),
				'orderby'        => 'ID',
				'order'        => 'DESC',
			
			);
		/*The Loop*/
	   $resultss = new WP_Query( $argss );
        while ( $resultss->have_posts() )
        {
            $resultss->the_post();
            $pid	=	get_the_ID();
            $adss	=	 new ads();
            $option	=	$layout;
            $function	=	"carspot_search_layout_$option";
            $outz	.= $adss->$function( $pid );
        }
?>
<div class="list-style-1">
       <div class="panel with-nav-tabs panel-default">
          <div class="panel-heading">
             <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1default" data-toggle="tab"><?php echo esc_html__('Latest Ads', 'carspot'); ?></a></li>
                <li><a href="#tab2default" data-toggle="tab"><?php echo esc_html__('Featured Ads', 'carspot'); ?></a></li>
             </ul>
          </div>
          <div class="panel-body">
             <div class="tab-content">
                <div class="tab-pane fade in active" id="tab1default"><?php echo "".($out); ?></div>
                <div class="tab-pane fade" id="tab2default"><?php echo "".($outz); ?></div>
             </div>
          </div>
       </div>
    </div>