<?php
	global $carspot_theme;
	$pid	=	get_the_ID();
	$post_categories = wp_get_object_terms( $pid,  array('ad_cats'), array('orderby' => 'term_group') );
?>
<ul>
     <li><b><?php echo esc_html(get_the_date()); ?></b></li>
     <li><?php echo esc_html__('Category', 'carspot'); ?>: 
     <b>
     <?php
     
        foreach($post_categories as $c)
        {
            $cat = get_term( $c );
     ?>
     <a href="<?php echo esc_url(get_term_link( $cat->term_id )); ?>"><?php echo esc_html( $cat->name ); ?> </a>
     <?php
     }
     ?>
     </b>
     </li>
     <li><?php echo esc_html__('Views', 'carspot'); ?>: <b><?php echo carspot_getPostViews($pid); ?></b></li>
     <?php
	 $my_url = carspot_get_current_url();
		if (strpos($my_url, 'carspot.scriptsbundle.com') !== false) {
			
		}
		else
		{
	 	if( get_post_field( 'post_author', $pid ) == get_current_user_id() || is_super_admin( get_current_user_id() ) )
		{
	 ?>
     <li><a href="<?php echo esc_url(get_the_permalink($carspot_theme['sb_post_ad_page'])); ?>?id=<?php echo esc_attr( $pid );  ?>"><?php echo esc_html__('Edit', 'carspot'); ?></a></li>
     <?php
		}
		}
	?>
</ul>	