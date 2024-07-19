<?php
	global $carspot_theme; 
	$pid	=	get_the_ID();
   ?>
   <div class="short-features">
                <div class="heading-panel">
                     <h3 class="main-title text-left">
                         <?php echo esc_html__('All Bids','carspot'); ?>
                     </h3>
                  </div>
                <div class="short-feature-body no-padding">
                    <div class="bidding">
                        <?php echo carspot_bidding_html_v2( $pid ); ?> 
                    </div>
                </div>
                <div class="chat-form">
          <form id="sb_bid_ad" >
             <?php
			 $col	=	8;
			 ?>
             <div class="col-md-2 col-sm-12 col-xs-12 no-padding">
                <input name="bid_amount" placeholder="<?php echo esc_html__('Bid','carspot'); ?>" class="form-control" type="text" data-parsley-required="true" data-parsley-type="integer" data-parsley-error-message="<?php echo esc_html__( 'Only integers.', 'carspot' ); ?>" autocomplete="off" />
             </div>
             <div class="col-md-<?php echo esc_attr($col); ?> col-sm-12 col-xs-12 no-padding">   
                <input name="bid_comment" data-parsley-required="true" data-parsley-error-message="<?php echo esc_html__( 'This field is required.', 'carspot' ); ?>" placeholder="<?php echo esc_html__('Comments...','carspot'); ?>" class="form-control" type="text" autocomplete="off">
                <small><em><?php echo esc_html( $carspot_theme['sb_comments_section_note']); ?></em></small>
             </div>   
            <div class="col-md-2 col-sm-12 col-xs-12 no-padding">
             <button class="btn btn-theme btn-block " type="submit"><?php echo esc_html__('Send','carspot'); ?></button>
             <input type="hidden" name="ad_id" value="<?php echo esc_attr($pid) ?>" />
             <input type="hidden" id="bidding_nonce" value="<?php echo wp_create_nonce('carspot_bidding_secure'); ?>"  />
             </div>
          </form>
       </div>
             </div>
                        
                   
