<?php get_header(); ?>
<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
global $carspot_theme;
//wp_redirect( get_the_permalink( $carspot_theme['sb_packages_page'] ) );
while (have_posts()) : the_post();
    $product = new WC_Product(get_the_ID());
    $product->get_type();
    if (false) {
        // will not come in...
    } else {
        ?>
        <section class="section-padding  product-single ">
            <!-- Main Container -->
            <div class="container">
                <!-- Row -->
                <div class="row">
                    <!-- Middle Content Area -->
                    <div class="col-md-12 col-lg-12 col-xs-12">
                        <div class="row">
                            <div class="col-md-5 col-sm-6 col-xs-12">
                                <?php get_template_part('woocommerce/looping/gallery', ''); ?>
                            </div>
                            <div class="product-shop col-lg-7 col-sm-6 col-xs-12">
                                <?php get_template_part('woocommerce/looping/title', ''); ?>
                                <?php get_template_part('woocommerce/looping/ratting', ''); ?> 
                                <?php get_template_part('woocommerce/looping/price', ''); ?>

                                <div class="info-orther">
                                    <?php
                                    if ($product->get_sku() && $product->get_sku() != "") {
                                        ?>
                                        <p><?php echo esc_html__('Item Code:', 'carspot'); ?> <?php echo esc_html('#' . $product->get_sku()); ?></p>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    $stock = '';
                                    $class = '';
                                    if ($product->is_in_stock()) {
                                        $class = 'in-stock';
                                        $stock = esc_html__('In stock', 'carspot');
                                    } else {
                                        $class = 'out-stock';
                                        $stock = esc_html__('Out of stock', 'carspot');
                                    }
                                    ?>
                                    <p><?php echo esc_html__('Availability:', 'carspot'); ?> <span class="<?php echo esc_html($class); ?>"><?php echo esc_html($stock); ?></span></p>
                                </div>
                                <?php get_template_part('woocommerce/looping/description', ''); ?>
                                <?php
                                if ($product->get_type() == 'variable') {
                                    get_template_part('woocommerce/product_type/variable', '');
                                }
                                get_template_part('woocommerce/product_type/add_cart_btn', '');
                                ?>              
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <?php get_template_part('woocommerce/looping/reviews', ''); ?>
                            </div> 
                        </div>

                    </div>
                    <!-- Middle Content Area  End -->
                </div>
                <!-- Row End -->

            </div>
            <!-- Main Container End -->
        </section>
        <?php
    }
endwhile; // end of the loop.

if (isset($carspot_theme['related_products']) && $carspot_theme['related_products'] == '1') {
    ?>
    <section class="custom-padding gray over-hidden">
        <!-- Main Container -->
        <div class="container">
            <!-- Row -->
            <div class="row">
                <!-- Heading Area -->
                <?php
                if (isset($carspot_theme['related_products_title']) && $carspot_theme['related_products_title'] != '') {
                    ?>
                    <div class="heading-panel">
                        <div class="col-xs-12 col-md-12 col-sm-12 left-side">
                            <!-- Main Title -->
                            <h1><?php echo carspot_color_text($carspot_theme['related_products_title']); ?></h1>
                        </div>
                    </div>
                <?php } ?>
                <!-- Middle Content Box -->
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="row">
                        <div class="featured-slider-shop container owl-carousel owl-theme">
                            <?php
                            $cats = wp_get_post_terms(get_the_ID(), 'product_cat');
                            $categories = array();
                            foreach ($cats as $cat) {
                                $categories[] = $cat->term_id;
                            }
                            $loop_args = array(
                                'post_type' => 'product',
                                'posts_per_page' => $carspot_theme['max_related_products'],
                                'order' => 'DESC',
                                'post__not_in' => array(get_the_ID()),
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field' => 'id',
                                        'terms' => $categories
                            )));
                            $related_products = new WP_Query($loop_args);
                            while ($related_products->have_posts()) {
                                $related_products->the_post();
                                $product = wc_get_product(get_the_ID());
                                if ($product->get_type() == 'carspot_category_pricing')
                                    continue;
                                $img = $product->get_image_id();
                                $photo = wp_get_attachment_image_src($img, 'medium');
                                if ($photo != '') {
                                    $photo = wp_get_attachment_image_src($img, 'medium');
                                } else {
                                    $photo = '';
                                }
                                ?> 
                                <div class="item">
                                    <div class="shop-grid">
                                        <div class="shop-product">
                                            <?php
                                            if ($photo != "") {
                                                if ($photo[0] != '') {
                                                    ?>
                                                    <img class="img-responsive" alt="<?php echo esc_attr(get_the_title(get_the_ID())); ?>" src="<?php echo esc_url($photo[0]); ?>">
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <img class="img-responsive" alt="<?php echo esc_attr(get_the_title(get_the_ID())); ?>" src="<?php echo esc_url(wc_placeholder_img_src()); ?>">

                                                <?php
                                            }
                                            ?>
                                            <!-- end shop-product -->
                                            <div class="shop-product-description">
                                                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                                <?php
                                                $is_ratting = WC_Admin_Settings::get_option('woocommerce_enable_review_rating');
                                                if ($is_ratting == 'yes' && comments_open(get_the_ID())) {
                                                    ?>
                                                    <div class="rating-stars">
                                                        <?php
                                                        $reviews = $product->get_review_count() . " " . esc_html__('Reviews', 'carspot');
                                                        $ratting = $product->get_average_rating();
                                                        for ($star = 1; $star <= 5; $star++) {
                                                            $is_filled = '';
                                                            if ($star <= $ratting) {
                                                                $is_filled = 'filled';
                                                            }
                                                            ?>
                                                            <i class="fa fa-star-o <?php echo esc_html($is_filled); ?>"></i>
                                                            <?php
                                                        }
                                                        ?>
                                                        <a href="javascript:void(0)">(<?php echo esc_html($reviews); ?>)</a>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <span>
                                                    <?php
                                                    if ($product->get_type() != 'grouped') {
                                                        if ($product->get_type() == 'variable') {
                                                            echo wc_price(get_post_meta(get_the_ID(), '_min_variation_price', true));
                                                            echo '-' . wc_price(get_post_meta(get_the_ID(), '_max_variation_price', true));
                                                        } else {
                                                            echo wc_price($product->get_sale_price());
                                                        }
                                                    }
                                                    ?>
                                                </span> 
                                            </div>
                                            <!-- end shop-product-description -->
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<?php get_footer(); ?>