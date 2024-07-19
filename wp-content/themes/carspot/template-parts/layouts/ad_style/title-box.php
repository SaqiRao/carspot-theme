<?php
global $carspot_theme;
$pid	=	get_the_ID();
$f_class	=	'';
if( get_post_meta( $pid, '_carspot_is_feature', true ) == '1' && get_post_meta($pid, '_carspot_ad_status_', true ) == 'active' )
{
$ribbion = 'featured-ribbon';
if( is_rtl() )
{
	$ribbion = 'featured-ribbon-rtl';
}

	echo '<div class="'.esc_attr( $ribbion ).'">
<span>'.esc_html__('Featured','carspot').'</span>
</div>';
	$f_class = 'featured-border';
}
?>
<div class="descs-box <?php echo esc_attr( $f_class ); ?>">
   <h1><?php the_title(); ?></h1>
   <div class="short-history">
	  <?php get_template_part( 'template-parts/layouts/ad_style/short', 'summary' ); ?>
   </div>
</div>