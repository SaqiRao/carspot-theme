<?php $product	=	new WC_Product( get_the_ID() ); ?>
<div class="price-section">
<?php if($product->get_sale_price() != '') { ?>
  <div class="price-box">
    <p class="special-price"> <span class="price-label" ><?php echo esc_html__('Special Price:','carspot'); ?></span> <span class="price" id="sale_price"> <?php echo wc_price( $product->get_price() );  ?> </span> </p>
    <p class="old-price"> <span class="price-label" ><?php echo esc_html__('Regular Price:','carspot'); ?></span> <span class="price" id="old_price"> <?php echo wc_price( $product->get_regular_price() );  ?> </span> </p>
  </div>
<?php  } else { ?>
<div class="price-box">
    <p class="special-price"> <span class="price-label" ><?php echo esc_html__('Regular Price:','carspot'); ?></span> <span class="price" id="sale_price"> <?php echo wc_price( $product->get_regular_price() );  ?> </span> </p>
  </div>
<?php } ?>
  <span id="v_msg"></span>
</div>