<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;
get_header();
	global $carspot_theme;
?>
<section class="section-padding no-top gray ">
            <!-- Main Container -->
            <div class="container">
               <!-- Row -->
               <div class="row">
                  <!-- Middle Content Area -->
                  <div class="col-md-9 col-md-push-3 col-lg-9 col-sx-12">

							<div class="listingTopFilterBar">
   								 <div class="col-md-7 col-xs-12 col-sm-5 no-padding">
                                    <div class="filterAdType">
                                        	<a href="javascript:void(0);"><?php echo woocommerce_result_count(); ?></a>
                                    </div>
                                </div>
   								 <div class="col-md-5 col-xs-12 col-sm-7 no-padding">
                               	 	<div class="header-listing">
                                    <h6><?php echo esc_html__('Sort by', 'carspot' ); ?>:</h6>
                                    <div class="custom-select-box">
                                    <?php echo woocommerce_catalog_ordering(); ?>
                                    </div>
                                </div>
    							</div>
							</div>
                        <div class="clearfix"></div>

                     <div class="row">
                        <!-- Blog Archive -->
                        <div class="posts-masonry">
                           <!-- Blog Post-->
                           <?php
							if ( have_posts() ) {
								while ( have_posts() )
								{ the_post();
									$product	=	wc_get_product( get_the_ID() );
									/*if($product->get_type() == 'carspot_category_pricing' )
										continue;
									if($product->get_type() == 'carspot_packages_pricing' )
									continue;*/
							?>
                            <div class="col-md-4 col-sm-6 col-xs-12 ">
                       			 <div class="shop-grid">
                           <div class="shop-product">
				    <?php
								$img	=	$product->get_image_id();
								$photo	=	 wp_get_attachment_image_src( $img, 'medium' );
								if( $photo[0] != "" )
								{
							?>
                            <a href="<?php the_permalink(); ?>">
                            	<img class="img-responsive" alt="<?php echo esc_attr(get_the_title( get_the_ID() )); ?>" src="<?php echo esc_url( $photo[0] ); ?>">
                            </a>
                            <?php
								}
								else
								{
									?>
                                    <a href="<?php the_permalink(); ?>">
									<img class="img-responsive " alt="<?php echo esc_attr(get_the_title( get_the_ID() )); ?>" src="<?php echo esc_url( wc_placeholder_img_src() ); ?>">
                                    </a>
									
                            <?php
								}
							?>
                           <!-- end shop-product -->
                           <div class="shop-product-description">
                              <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<?php
                                    $is_ratting = WC_Admin_Settings::get_option( 'woocommerce_enable_review_rating' );
                                    if( $is_ratting == 'yes' && comments_open( get_the_ID() ) )
                                    {
                                    ?>
                                     <div class="rating-stars">
                                     <?php
									    $reviews	=	$product->get_review_count() . " " . esc_html__( 'Reviews', 'carspot' );
                                        $ratting	=	$product->get_average_rating();
                                        for( $star =1; $star <= 5; $star++ )
                                        {
                                            $is_filled	=	'';
                                            if( $star <= $ratting )
                                            {
                                                $is_filled	=	'filled';
                                            }
                                     ?>
                                            <i class="fa fa-star-o <?php echo esc_html( $is_filled ); ?>"></i>
                                     <?php
                                        }
                                     ?>
                                     <a href="javascript:void(0)">(<?php echo esc_html( $reviews ); ?>)</a>
                                     </div>
                                     <?php
									}
									?>
                              <span>
								<?php 
								if( $product->get_type() != 'grouped' )
								{
									if($product->get_type() == 'variable' )
									{
										echo wc_price( get_post_meta( get_the_ID(), '_min_variation_price', true ) );
										echo '-' . wc_price( get_post_meta( get_the_ID(), '_max_variation_price', true ) );
									}
									else
									{
										echo wc_price($product->get_regular_price());
									}
								}
								?>
                              </span> 
                              </div>
                            </div>
                        </div>
                            </div>
                            <?php
								}
							}
							else
							{
								echo esc_html__( 'No products found', 'carspot' );	
							}
							?>
                        </div>
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <?php carspot_pagination(); ?>
                        </div>
                     </div>
                  </div>
                  <!-- Left Sidebar -->
                  <?php echo (get_sidebar('shop')); ?>
               </div>
            </div>
         </section>
<?php get_footer(); ?>