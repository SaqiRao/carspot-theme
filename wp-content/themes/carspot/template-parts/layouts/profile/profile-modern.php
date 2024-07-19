<?php global $carspot_theme; ?>
<?php
	$author_id = get_query_var( 'author' );
	$author = get_user_by( 'ID', $author_id );
	$user_pic =	carspot_get_user_dp( $author_id, 'carspot-user-profile' );
	
	$top_padding ='no-top';
	if(isset( $carspot_theme['sb_header'] ) &&  $carspot_theme['sb_header'] == 'transparent' || $carspot_theme['sb_header'] == 'transparent2' )
	{
		$top_padding ='';	
	}

?>
<section class="section-padding gray <?php echo carspot_returnEcho($top_padding) ?>" >
    <div class="container">
        <div class="row">
              <div class="col-md-12 col-xs-12 col-sm-12 margin-bottom-40">
                    <section class="search-result-item">
                               <a class="image-link" href="javascript:void(0);">
                               <img class="image" alt="<?php echo esc_html__('Profile Picture','carspot'); ?>" src="<?php echo esc_url($user_pic); ?>" id="user_dp">
                               </a>
                               <div class="search-result-item-body">
                                  <div class="row">
                                     <div class="col-md-5 col-sm-12 col-xs-12">
                                        <h4 class="search-result-item-heading sb_put_user_name"><?php echo esc_html($author->display_name); ?></h4>
                                        <p class="info sb_put_user_address">
                                          <?php echo esc_html(get_user_meta($author->ID, '_sb_address', true )); ?></p>
                                        <p class="description"><?php echo esc_html__('Logged in at', 'carspot') . ': '.carspot_get_last_login( $author->ID ). ' ' . esc_html__('Ago','carspot'); ?></p>
                                        <?php
                                        if( get_user_meta($author->ID, '_sb_badge_type', true ) != "" && get_user_meta($author->ID, '_sb_badge_text', true ) != "" && isset( $carspot_theme['sb_enable_user_badge'] ) && $carspot_theme['sb_enable_user_badge'] && $carspot_theme['sb_enable_user_badge'] && isset( $carspot_theme['user_public_profile'] ) && $carspot_theme['user_public_profile'] != "" && $carspot_theme['user_public_profile'] == "modern" )
										{
										?>
                                        <span class="label <?php echo esc_attr(get_user_meta($author->ID, '_sb_badge_type', true )); ?>">
										                      <?php echo esc_html(get_user_meta($author->ID, '_sb_badge_text', true )); ?>
                                        </span>
                                        <?php
										}
										?>
                                        <p></p>
                                        <?php
                                        if( isset( $carspot_theme['user_public_profile'] ) && $carspot_theme['user_public_profile'] != "" && $carspot_theme['user_public_profile'] == "modern" && isset($carspot_theme['sb_enable_user_ratting']) && $carspot_theme['sb_enable_user_ratting'] )
										{
											
										?>
                                        <a href="<?php echo esc_url(get_author_posts_url( $author->ID )); ?>?type=1">
                                        <div class="rating">
                                    <?php
									$got	=	get_user_meta($author->ID, "_carspot_rating_avg", true );
									if( $got == "" )
										$got = 0;
										for( $i = 1; $i<=5; $i++ )
										{
											if( $i <= round( $got ) )
												echo '<i class="fa fa-star"></i>';
											else
												echo '<i class="fa fa-star-o"></i>';	
										}
									?>
                                           <span class="rating-count">
                                           (<?php 
										   if( get_user_meta($author->ID, "_carspot_rating_count", true ) != "" )
										   		echo esc_html(get_user_meta($author->ID, "_carspot_rating_count", true )); 
											else
												echo 0;
										   ?>)
                                           </span>
                                        </div>
                                        </a>
                                       <?php
										}
										?>
                                     </div>
                                     <div class="col-md-7 col-sm-12 col-xs-12">
                                      <div class="row ad-history">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                    
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <div class="user-stats">
                                                    <h2><?php echo carspot_get_sold_ads( $author->ID ); ?></h2>
                                                    <small><?php echo esc_html__( 'Ad Sold', 'carspot' ); ?></small>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <div class="user-stats">
                                                    <h2><?php echo carspot_get_all_ads( $author->ID ); ?></h2>
                                                    <small><?php echo esc_html__( 'Total Listings', 'carspot' ); ?></small>
                                                </div>
                                            </div>
                                        </div>
                                     </div>
                                     
                                     
                                     
                                     
                                     
                                  </div>
                               </div>
                            </section>
                </div>
                <div class="clearfix"></div>
              <div class="col-md-12 col-lg-12 col-sx-12">
                 <!-- Row -->
                 <div class="row">
                 <?php
               if( have_posts() > 0 && in_array( 'carspot_framework/index.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
                    {
                 ?>
                    <div class="posts-masonry">
                       <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                          <ul class="list-unstyled">
                         <?php
                            while( have_posts() )
                            {
                                the_post();
                                $pid	=	get_the_ID();
                                $ad	= new ads();
                                echo($ad->carspot_search_layout_list($pid));
                            }
                        ?>
                          </ul>
                       </div>
                    </div>
                    <!-- Ads Archive End -->  
                    <div class="clearfix"></div>
                    <!-- Pagination -->  
                    <div class="col-md-12 col-xs-12 col-sm-12">
                       <?php carspot_pagination(); ?>
                    </div>
                    <!-- Pagination End -->
               <?php
                    }
                    else
                    {
                        echo '<div class="col-md-8 col-sm-12 col-xs-12">
<h2>' .  esc_html__('No Ad(s) result found.','carspot') . '</h2></div><br /><br /><br /><br />';
                    }
                ?>
                 </div>
                 <!-- Row End -->
              </div>
                </div>
    </div>
</section>