<div class="shop-slider-main tab-content">
	 <?php
	 $product	=	new WC_Product( get_the_ID() );
	 if( $product->get_image_id() != "")
	 {
		$gallery =  carspot_GetImageUrlsByProductId(get_the_ID());
		$count_thumb	=	1;
		foreach( $gallery as $attachmentId )
		{
			$img =	wp_get_attachment_image_src( $attachmentId ,'carspot-wocommerce-single' );
			$class	= 	'';  $main_img = '';
			if( $count_thumb == 1 )
			$class	=	'active';
			 $main_img = $img[0];
			 $full_img  = wp_get_attachment_image_src($attachmentId, 'full');
	 ?>
		<div id="image-<?php echo esc_attr( $count_thumb ); ?>" class="tab-pane <?php echo esc_attr( $class ); ?>">
		   <a href="<?php echo esc_url($full_img[0]); ?>" data-fancybox="group">
		   <img class="img-responsive" alt="<?php esc_attr__( 'image not found', 'carspot' ); ?>" src="<?php echo esc_url( $main_img ); ?>"> </a>
		</div>
	 <?php
		$count_thumb++;
		}
	 ?>
	 </div>
	 <div class="product-thumb owl-carousel owl-theme">
	 <?php
		$count_thumb1	=	1;
		foreach( $gallery as $attachmentId )
		{
			$photo	=	 wp_get_attachment_image_src( $attachmentId, 'carspot-small-thumb' );
	 ?>
		<div class="item">
		   <a href="#image-<?php echo esc_attr( $count_thumb1 ); ?>" data-toggle="tab">
		   <img class="img-responsive" alt="<?php esc_html__( 'image not found', 'carspot' ); ?>" src="<?php echo esc_url( $photo[0] ); ?>"  />
		   </a>
		</div>
	 <?php
		$count_thumb1++;
		}
	 }
	 else
	 {
		 echo wc_placeholder_img( 'shop_single' );
		?>
	<?php	 
	 }
	 ?>
	 </div>