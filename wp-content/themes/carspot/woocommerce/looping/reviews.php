<div class="product-single-detail">
<div class="tab" role="tabpanel">  
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab"><?php echo esc_html__( 'description', 'carspot' ); ?></a></li>
        <li role="presentation"><a href="#Section2" aria-controls="profile" role="tab" data-toggle="tab"><?php echo esc_html__( 'reviews', 'carspot' ); ?></a></li>
        <?php
        $product	=	new WC_Product( get_the_ID() );
        $attributes = $product->get_attributes();
        $attrs	=	array();
        foreach( $attributes as $attribute )
        {
            $attr_array	= explode( 'pa_', $attribute['name'] );
			if ( ! isset($attr_array[1])) {
				$attrs[] = null;
			}
			else
			{
            	$attrs[]	=	$attr_array[1];
			}
        }
		if( count( $attrs ) > 0 )
		{
		?>
        <li role="presentation"><a href="#Section3" aria-controls="messages" role="tab" data-toggle="tab"><?php echo esc_html__( 'Additional Information', 'carspot' ); ?></a></li>
        <?php
		}
		?>
    </ul>
                 <div class="tab-content tabs">
                <div role="tabpanel" class="tab-pane fade in active" id="Section1">
                            <h3><?php echo esc_html__( 'Product Description', 'carspot' ); ?></h3>
                            <p><?php the_content(); ?></p>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="Section2">
                            <h3><?php echo esc_html__( 'Product Reviews', 'carspot' ); ?></h3>
                            <div class="comments">
								<?php comments_template('', true); ?>
							</div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="Section3">
                            <h3><?php echo esc_html__( 'Features', 'carspot' ); ?></h3>
                            <div class="table-responsive">
    <table class="table table-bordered table-striped">
    <colgroup>
    <col class="col-xs-6">
    <col class="col-xs-6">
    </colgroup>
    <tbody>
    <?php
	 if( count( $attrs ) > 0 )
	 {
		 foreach( $attrs as $attr )
		 {
			 $values = $product->get_attribute( 'pa_' . $attr );

	?>
    <tr>
        <th><?php echo esc_html( $attr ); ?></th>
        <td><span><?php echo ($values); ?></span></td>
    </tr>
    <?php
		 }
	 }
	 ?>
    </tbody>
    </table>
    </div>
</div>
</div>
</div> 
</div>