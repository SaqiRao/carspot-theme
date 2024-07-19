<?php
global $carspot_theme;
$badge_enabled = isset($carspot_theme['sb_enable_user_badge']) ? $carspot_theme['sb_enable_user_badge']:'';
$set_badge_page = isset($carspot_theme['carspot_profile_badge']) ? $carspot_theme['carspot_profile_badge']: '';
// $product_id = $carspot_theme['carspot_profile_badge'];
$current_user_id = get_current_user_id();
$author_id       = get_query_var( 'author' );
$user_pic        = carspot_get_dealer_logo( $author_id );
$store_pic       = carspot_get_dealer_store_front( $author_id );
$current_user    = wp_get_current_user();
$author_detail   = get_userdata( $author_id );

$user_type = get_user_meta( $author_id, '_sb_user_type', true );

echo old_rating_importer( $author_id );




?>
<div class="col-12 col-sm-12 col-md-12 col-lg-12 toast-container" style="z-index:9999"></div>
<div class="main-content-area clearfix">
    <!-- =-=-=-=-=-=-= Latest Ads =-=-=-=-=-=-= -->
    <section class="section-padding pattern_dots">
        <!-- Main Container -->
        <div class="container">
            <!-- Row -->
			
            <div class="row">
                <!-- Middle Content Area -->
                <div class="col-md-12 col-lg-12 col-sx-12">
				
                    <!-- Row -->
                    <div class="row">
						<?php
						$limit = $carspot_theme['sb_reviews_count_limit'];
						if ( get_query_var( 'paged' ) ) {
							$paged = get_query_var( 'paged' );
						} else if ( get_query_var( 'page' ) ) {
							/* This will occur if on front page. */
							$paged = get_query_var( 'page' );
						} else {
							$paged = 1;
						}
						// The Query
						$the_query   = new WP_Query(
							array(
								'author__in'     => array( $author_id ),
								'post_type'      => 'ad_post',
								'meta_query'     => array(
									array(
										'key'     => '_carspot_ad_status_',
										'value'   => 'active',
										'compare' => '=',
									),
								),
								'paged'          => $paged,
								'posts_per_page' => $limit,
								'post_status'    => 'publish'
							)
						);
						$total_count = $the_query->found_posts;
						?>
                        <div class="clearfix"></div>
                        <!-- Ads Archive -->
                        <div class="dealers-single-page">
                            <div class="col-md-8 col-xs-12 col-sm-12 col-lg-8">
							
                                <div class="profile-title-box">
                                    <div class="profile-heading">
                                        <h2>
											<?php
											if ( get_user_meta( $author_id, '_sb_camp_name', true ) != "" ) {
												echo strip_tags_content( get_user_meta( $author_id, '_sb_camp_name', true ) );
											} else {
												echo strip_tags_content( $author_detail->display_name );
											}
											?>
											<?php
											if ( get_user_meta( $author_id, '_sb_badge_text', true ) != "" && get_user_meta( $author_id, '_sb_badge_type', true ) != "" ) {
												?>
                                                <span class="label <?php echo esc_attr( get_user_meta( $author_id, '_sb_badge_type', true ) ); ?>">  <?php echo esc_html( get_user_meta( $author_id, '_sb_badge_text', true ) ); ?></span>
											<?php } ?>
                                        </h2>
                                    </div>
									<div>
										<?php
										// $check_badge = check_baged_user($product_id);
										// $meta_value = get_user_meta($current_user_id, '_carspot_profile_badge', true);

										

										if($badge_enabled && $set_badge_page != '' && !(badge_validation($set_badge_page,$current_user_id)))
										{
											
										?>
											<div class="row">
													<div class="col-md-12">
														<button class="get-badge-button" id="profile-badge-btn">
															Get VIP Badge
														</button>
															<!-- <button id="profile-badge-btn">Get Badge</button> -->
													</div>
												</div>
										<?php 
										
										}

										?>
									</div>
                                    <div class="profile-meta">
                                        <ul>
											<?php
											if ( isset( $carspot_theme['sb_enable_user_ratting'] ) && $carspot_theme['sb_enable_user_ratting'] ) {
												?>
                                                <li>
                                                    <i class="la la-certificate icon"></i>
                                                    <span class="profile-meta-title"><?php echo esc_html__( 'Ratings: ', 'carspot' ); ?> </span>
													<?php
													echo avg_user_rating( $author_id ) . ' (';
													echo carspot_dealer_review_count( $author_id ) . ')';
													?>
                                                </li>
												<?php
											}
											?>
                                            <li>
                                                <i class="la la-calendar-o icon"></i>
                                                <span class="profile-meta-title"><?php echo esc_html__( 'Member since: ', 'carspot' ); ?> </span>
												<?php echo date_i18n( get_option( 'date_format' ), strtotime( $author_detail->user_registered ) ); ?>
                                            </li>
											<?php
											if ( $user_type == 'dealer' ) {
												?>
                                                <li>
                                                    <i class="la la-clock-o icon"></i>
                                                    <span class="profile-meta-title"><?php echo esc_html__( 'Working Hours: ', 'carspot' ); ?> </span>
													<?php echo esc_html( get_user_meta( $author_id, '_sb_user_timings', true ) ); ?>
                                                </li>
											<?php } ?>
											<li>
												
											</li>
                                        </ul>
                                    </div>
                                </div>
								<?php if ( $store_pic != "" ) { ?>
                                    <div class="store-front">
                                        <img src="<?php echo esc_url( $store_pic ) ?>" class="img-responsive"
                                             alt="<?php echo esc_html__( 'Dealer store picture', 'carspot' ) ?>">
                                    </div>
								<?php } ?>
                                <h3 class="profile-heading">
									<?php
									if ( isset( $carspot_theme['sb_about_title'] ) && $carspot_theme['sb_about_title'] ) {
										echo esc_html( $carspot_theme['sb_about_title'] );
									}
									?>
                                </h3>
                                <div class="profile-desc">
                                    <p><?php echo esc_html( get_user_meta( $author_id, '_sb_user_about', true ) ); ?></p>
                                </div>
                                <h3 class="profile-heading">
									<?php
									if ( isset( $carspot_theme['sb_inventory_title'] ) && $carspot_theme['sb_inventory_title'] ) {
										echo esc_html( $carspot_theme['sb_inventory_title'] );
									}
									?>
                                </h3>

								<?php
								// The Loop
								$posted_date = '';
								if ( $the_query->have_posts() ) {
									?>
                                    <ul class="list-unstyled" id="inventory">
										<?php
										while ( $the_query->have_posts() ) {
											$the_query->the_post();
											$pid         = get_the_ID();
											$cats_html   = carspot_display_cats( $pid );
											$posted_date = get_the_date( get_option( 'date_format' ), $pid );
											$outer_html  = '';
											$media       = carspot_fetch_listing_gallery( $pid );
											$total_img   = count( $media );
											$mid         = '';

											if ( count( (array) $media ) > 0 ) {
												$counting = 1;
												foreach ( $media as $m ) {
													if ( $counting > 1 ) {
														break;
													}

													$mid = '';
													if ( isset( $m->ID ) ) {
														$mid = $m->ID;
													} else {
														$mid = $m;
													}
													$image = wp_get_attachment_image_src( $mid, 'carspot-ad-related' );
													$img   = $image[0];
													break;
												}
											}

											if ( wp_attachment_is_image( $mid ) ) {
												$outer_html = '<a href="' . get_the_permalink() . '"><img src="' . esc_url( $img ) . '" alt="' . get_the_title() . '" class="img-responsive"></a> ';
											} else {
												$outer_html = '<a href="' . get_the_permalink() . '"><img src="' . esc_url( $carspot_theme['default_related_image']['url'] ) . '" alt="' . get_the_title() . '" class="img-responsive"></a> ';
											}
											$total_img_html = '<div class="total-images"> <strong>' . $total_img . '</strong> ' . esc_html__( 'photos', 'carspot' ) . ' </div>';

											$custom_locz = '';
											if ( carspot_display_adLocation( $pid ) != "" ) {
												$custom_locz = '<li> <i class="fa fa-map-marker"></i>' . carspot_display_adLocation( $pid ) . ' </li>';
											}
											$condition_html = '';
											if ( isset( $carspot_theme['allow_tax_condition'] ) && $carspot_theme['allow_tax_condition'] && get_post_meta( $pid, '_carspot_ad_condition', true ) != "" ) {
												$condition_html = '<div class="badge">' . get_post_meta( $pid, '_carspot_ad_condition', true ) . '</div>';
											}
											$features_html = '';
											$show_cats     = '';
											if ( isset( $carspot_theme['listing_features_grids'] ) && $carspot_theme['listing_features_grids'] == "car" ) {
												$features_html = carspot_display_key_features( $pid, '5', 'no_icons' );
											} else {
												$cats_html     = carspot_display_cats( $pid );
												$features_html = '<div class="category-title"> ' . $cats_html . ' </div>';
											}
											?>

                                            <li>
                                                <div class="ad-listing on-profile clearfix ">
                                                    <div class="col-md-3 col-sm-5 col-xs-12 grid-style no-padding">
                                                        <div class="img-box">
															<?php echo( $outer_html ); ?>
															<?php echo( $total_img_html ) ?>
                                                        </div>
														<?php if ( get_post_meta( $pid, '_carspot_is_feature', true ) == '1' ) {
															?>
                                                            <span class="ad-status"> 
                                                <?php echo esc_html__( 'Featured', 'carspot' ); ?>
                                                            </span>
														<?php }
														?>
                                                    </div>
                                                    <div class="col-md-9 col-sm-7 col-xs-12">
                                                        <!-- Ad Content-->
                                                        <div class="row">
                                                            <div class="content-area">
                                                                <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
																	<?php echo( $condition_html ); ?>
                                                                    <h3>
                                                                        <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
                                                                    </h3>
                                                                    <ul class="ad-meta-info">
																		<?php echo( $custom_locz ); ?>
                                                                        <li><i class="fa fa-clock-o"></i>
																			<?php echo esc_html( get_the_date( get_option( 'date_format' ), get_the_ID() ) ); ?>
                                                                        </li>
                                                                    </ul>
                                                                    <div class="ad-details">
																		<?php echo( $features_html ); ?>
                                                                    </div>

                                                                    <div class="price">
                                                                        <span> <?php echo carspot_adPrice( get_the_ID() ); ?> </span>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
										<?php } ?>
                                    </ul>
									<?php
									//$default_posts_per_page = get_option( 'posts_per_page' );
									if ( $total_count > $limit ) {
										?>
                                        <div class="extra-button">
                                            <a href="<?php echo esc_url( get_the_permalink( $carspot_theme['user_inventory'] ) ); ?>?user_id=<?php echo esc_attr( $author_id ); ?>"
                                               class="btn btn-theme pull-right">
												<?php
												echo esc_html__( 'More ads', 'carspot' ) . ' (';
												echo ( $total_count ) . ')';
												?>
                                            </a>
                                        </div>
										<?php
									}
									?>
									<?php
								} else {
									?>
                                    <div class="alert custom-alert custom-alert-info" role="alert">
                                        <div class="custom-alert_top-side">
                                            <span class="alert-icon custom-alert_icon la la-info-circle"></span>
                                            <div class="custom-alert_body">
                                                <h6 class="custom-alert_heading">
													<?php echo esc_html__( 'No inventory found. ', 'carspot' ); ?>
                                                </h6>
                                                <div class="custom-alert_content">
													<?php
													echo esc_html__( 'This user has not added inventory yet. ', 'carspot' );
													?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
								<?php } ?>
								<?php get_template_part( 'template-parts/layouts/profile/rating' ); ?>
                            </div>
							<?php get_template_part( 'template-parts/layouts/profile/profile-simple-sidebar' ); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>