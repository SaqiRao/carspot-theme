<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.1
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$product = wc_get_product( get_the_ID() );
$attributes = $product->get_variation_attributes();
$available_variations = $product->get_available_variations();
$attribute_keys = array_keys( $attributes );

// making varitions for JS
$com_options	=	array();
foreach( $available_variations as $variation )
{
	if( $variation['variation_is_active'] == 1 )
	{
		$values	=	'';
		foreach( $variation['attributes'] as $val )
		{
			$values .=  str_replace(' ', '', $val) . '_';
		}
		$com_options[$values] =  $variation['display_price'] . '-' . $variation['display_regular_price'] . '-' . $variation['variation_id'];
	}
}
foreach( $com_options as $index => $value )
{
?>
    	<input type="hidden" id="<?php echo esc_attr( $index ); ?>" value="<?php echo esc_attr( $value ); ?>" />
    <?php 	
}
do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<div class="row">
<div class="product-variation">
				<?php 
					foreach ( $attributes as $attribute_name => $options ) 
					{ 
				?>
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                <label class="control-label"><?php echo wc_attribute_label( $attribute_name ); ?></label>
						<?php
                            $selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( urldecode( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ) : $product->get_variation_default_attribute( $attribute_name );
                            wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected, 'class' => 'sb_variation' ) );
                        ?>
					</div>
				<?php 
					}
				?>
     </div>           
</div>
			<?php
				/**
				 * woocommerce_before_single_variation Hook.
				 */
				do_action( 'woocommerce_before_single_variation' );
				/**
				 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */

				/**
				 * woocommerce_after_single_variation Hook.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>


	<?php do_action( 'woocommerce_after_variations_form' ); ?>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );
