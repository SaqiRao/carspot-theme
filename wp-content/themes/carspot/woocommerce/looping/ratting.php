<?php
$product	=	new WC_Product( get_the_ID() );
$is_ratting = WC_Admin_Settings::get_option( 'woocommerce_enable_review_rating' );
if( $is_ratting == 'yes' && comments_open( get_the_ID() ) )
{
?>
 <div class="rating">
 <?php
	$ratting	=	$product->get_average_rating();
	for( $star =1; $star <= 5; $star++ )
	{
		$is_filled	=	'';
		if( $star <= $ratting )
		{
			$is_filled	=	'fa fa-star';
		}
 ?>
		<i class="fa fa-star-o<?php echo esc_html( $is_filled ); ?>"></i>
 <?php
	}
	$reviews	=	$product->get_review_count() . " " . esc_html__( 'Reviews', 'carspot' );
	if( $is_ratting == 'yes' && comments_open( get_the_ID() ) )
	{
 ?>
 <p class="rating-links review_active"> <a href="javascript:void(0);"><?php echo esc_html( $reviews ); ?></a> <span class="separator">|</span> <a href="#reviews"><i class="fa fa-pencil"></i> <?php echo esc_html__( 'Write A Review', 'carspot' ); ?></a> </p>
 </div>
<?php
	}
}
?>