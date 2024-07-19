<?php 
	global $carspot_theme;
	$current_user_id = get_current_user_id();
	$user_pic	=	carspot_get_dealer_logo($current_user_id); 
	$store_pic = carspot_get_dealer_store_front($current_user_id);
	$current_user = wp_get_current_user();
	$user_meta = '';
	$user_meta = get_user_meta($current_user_id);
?>

<div class="container-fluid">
    <!-- OVERVIEW -->
    <div class="row">
    	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        	<div class="panel  panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('My Review and Ratings ', 'carspot' ); echo "<span>("; echo carspot_dealer_review_count($current_user_id);	?>) </span></h3>
            <p class="panel-subtitle"><?php echo esc_html__('Last logged in ', 'carspot');  echo carspot_get_last_login( $current_user_id ); echo esc_html__(' Ago','carspot'); ?></p>
                </div>
                <div class="panel-body">
                	<div class="row">
                        
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        	<div class="edit-profile-form dealers-review-section on-backend">
                                <div class="row">
                                    	<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                        
                                        <?php get_template_part( 'template-parts/layouts/profile/all-ratings' ); ?>
                                        </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>