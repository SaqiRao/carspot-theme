<?php
/*Adons and Category Pricing Woo Commerce Functions Here*/
/*--------------------------------------------------------*/

// Ajax handler for add to cart
add_action( 'wp_ajax_carspot_package_add_cart', 'carspot_add_to_cart_package' );
add_action('wp_ajax_nopriv_carspot_package_add_cart', 'carspot_add_to_cart_package');
if ( ! function_exists( 'carspot_add_to_cart_package' ) )
{
	function carspot_add_to_cart_package()
	{
		global $carspot_theme;
		if( get_current_user_id() == 0)
		{
			echo '0|' . __( "You need to be logged in.", 'carspot' ) .'|' . get_the_permalink( $carspot_theme['sb_sign_in_page'] );
			die();	
		}
		$product_id	= $_POST['product_id'];
		$qty	=	$_POST['qty'];
		global $woocommerce;
		if( $woocommerce->cart->add_to_cart($product_id, $qty) )
		{
			echo '1|' . __( "Added to cart.", 'carspot' ) .'|' . $woocommerce->cart->get_cart_url();
		}
		else
		{
			echo '1|' . __( "Already in your cart.", 'carspot' ) .'|' . $woocommerce->cart->get_cart_url();
		}
		die();
	}
}



// Order Complation of Checkout
add_action( 'woocommerce_order_status_completed','carspot_after_buy_package',1  );
if ( ! function_exists( 'carspot_after_buy_package' ) ) {
	function carspot_after_buy_package( $order_id )
	{
		global $carspot_theme;
		$order = new WC_Order( $order_id );
		$user = $order->get_user();
		$user_id = $order->get_user_id();
		$items = $order->get_items();
		if(count($items) > 0 )
		{
			foreach ( $items as $item ){
				$product_id = $item['product_id'];
				$product_type	=	wc_get_product($product_id);
				if($product_type->get_type() == 'carspot_packages_pricing' )
				{
					carspot_store_user_package($user_id,$product_id, $order_id);
				}
			}
		}
	}
}

//For Auto Approval order
add_filter( 'woocommerce_thankyou', 'carspot_approve_order_auto', 10, 4 );
if ( ! function_exists( 'carspot_approve_order_auto' ) ) {
	function carspot_approve_order_auto( $order_id )
	{
		 global $carspot_theme;
		 $order = new WC_Order( $order_id );
		 if ( $order->has_status( 'processing' ) )
		 {
			if(isset($carspot_theme['carspot_ad_order_approved']) && $carspot_theme['carspot_ad_order_approved'] == 1)
			{
				$order->update_status( 'completed' );
			}
		 }
	}
}