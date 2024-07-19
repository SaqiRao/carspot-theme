<?php
/*Adons and Category Pricing Woo Commerce Functions Here*/
add_action( 'init', 'woocommerce_clear_cart_url' );
if ( ! function_exists( 'woocommerce_clear_cart_url' ) ) {
function woocommerce_clear_cart_url() {
	global $woocommerce;
	global $carspot_theme;
	if(isset($carspot_theme['sb_post_ad_page']) && $carspot_theme['sb_post_ad_page'] != "")
	{
		$post_ad_page = get_permalink($carspot_theme['sb_post_ad_page']);
		$current_url  = carspot_currenturl_without_queryparam('id');
		if($post_ad_page == $current_url) $woocommerce->cart->empty_cart(); 
	}
}
}

add_action( 'woocommerce_add_order_item_meta', 'carspot_hook_new_order_item_meta', 10, 3);
if ( ! function_exists( 'carspot_hook_new_order_item_meta' ) ) {
function carspot_hook_new_order_item_meta($item_id, $values, $cart_item_key) {
   $session_data = WC()->session->get('_carspot_ad_id');
   if(!empty($session_data))
   {
      wc_add_order_item_meta($item_id, '_carspot_ad_id', $session_data);
   }
   else
   {
      error_log(esc_html__("no session data", "carspot"), 0);
   }
}
}
/*--------------------------------------------------------*/

if ( ! function_exists( 'carspot_filter_wc_cart_item_remove_link' ) ) {
function carspot_filter_wc_cart_item_remove_link( $sprintf, $cart_item_key ) {
    return '';
};
}

add_filter( 'woocommerce_thankyou', 'carspot_update_order_status', 10, 4 );
if ( ! function_exists( 'carspot_update_order_status' ) ) {
function carspot_update_order_status( $order_id ) {
	
  if ( !$order_id ) return;
  $order = new WC_Order( $order_id );
	  if ( $order->has_status( 'processing' ) ) {
	  	global $carspot_theme;	
	  	$key = '';
		$order = new WC_Order( $order_id );
		$items = $order->get_items();
	  	if( count((array)$items)  > 0 )
		{
			foreach($items as $key => $name){ $key; }
			$orderAd_id = wc_get_order_item_meta($key, '_carspot_ad_id');
			if($orderAd_id != "")
			{
				update_post_meta( $orderAd_id, '_carspot_ad_order_id', $order_id );
				$cats = get_post_meta( $orderAd_id, '_carspot_category_based_cats', true );
				if($cats != "")
				{
					wp_set_post_terms( $orderAd_id, $cats, 'ad_cats' );
					delete_post_meta( $orderAd_id, '_carspot_category_based_cats' );
				}
				if(isset($carspot_theme['carspot_ad_order_approved']) && $carspot_theme['carspot_ad_order_approved'] == 1)
				{
					$order->update_status( 'completed' );
					carspot_after_payment_success( $order_id , 'auto');
				}
				
			}			
		}
  }
  return;
}
}

add_action( 'woocommerce_thankyou', 'carspot_add_content_thankyou' );
if ( ! function_exists( 'carspot_add_content_thankyou' ) ) {
function carspot_add_content_thankyou($order_id) {
		$ad_id  = '';
		$order = new WC_Order( $order_id );
		$items = $order->get_items();
	  	if( count((array)$items)  > 0 )
		{
			foreach($items as $key => $name){ $key; }
			$orderAd_id = wc_get_order_item_meta($key, '_carspot_ad_id');
			if($orderAd_id != "" && $ad_id == "") $ad_id = $orderAd_id;
		}
	$link = get_the_permalink( $ad_id );
echo '<h2 class="h2thanks">'.esc_html__('Get 20% off','carspot').'</h2><p class="pthanks">'.esc_html__('Thank you for making this purchase! ','carspot').'<a href="'.esc_url($link).'" >'.esc_html__('Click Here','carspot').'</a> '.esc_html__(' To View The Ad','carspot').'</p>';
}
}

add_action( 'woocommerce_order_status_completed', 'carspot_after_payment_success' );
if ( ! function_exists( 'carspot_after_payment_success' ) ) {
function carspot_after_payment_success( $order_id )
{
 	global $carspot_theme;	
	$profile	= 	new carspot_profile();
	$order 		= 	new WC_Order( $order_id );	
	$uid		=	get_post_meta( $order_id, '_customer_user', true );
	$items = $order->get_items();
	foreach ( $items as $key => $item  )
	{

		$product_id = $item['product_id'];
		$orderAd_id = wc_get_order_item_meta($key, '_carspot_ad_id');
		if( get_post_meta($product_id, "carspot_package_type", true) == 'adons_based' )
		{
			if( get_post_meta($product_id, "carspot_package_ad_type", true) == 'featured' )
			{
				update_post_meta( $orderAd_id, '_carspot_is_feature_date', date( 'Y-m-d' ) );
				update_post_meta( $orderAd_id, '_carspot_is_feature', 1 );

				if(isset($carspot_theme['carspot_ad_order_approved']) && $carspot_theme['carspot_ad_order_approved'] == 1)
				{
				 $ad_status	='publish';
				}
				else
				{
					 $ad_status	='publish';
				}
				 $my_post 	= array(
						'ID'			=> $orderAd_id,
						'post_status'   => $ad_status,
					);
		 		  wp_update_post( $my_post );
			}
			if( get_post_meta($product_id, "carspot_package_ad_type", true) == 'bump' )
			{
				$time = current_time('mysql');
				wp_update_post(
					array (
						'ID'            => $orderAd_id, 
						'post_date'     => $time,
						'post_date_gmt' => get_gmt_from_date( $time )
					)
				);	
				if(isset($carspot_theme['carspot_ad_order_approved']) && $carspot_theme['carspot_ad_order_approved'] == 1)
				{
				 $ad_status	='publish';
				}
				else
				{
					 $ad_status	='publish';
				}
				 $my_post 	= array(
						'ID'			=> $orderAd_id,
						'post_status'   => $ad_status,
					);
		 		  wp_update_post( $my_post );			
			}			
		}
		
	
		else if( get_post_meta($product_id, "carspot_package_type", true) == 'category_based' )
		{
			    $ad_status	=	'publish';
				 $my_post 	= array(
						'ID'			=> $orderAd_id,
						'post_status'   => $ad_status,
					);
		 		wp_update_post( $my_post );
		}		
	}
}
}