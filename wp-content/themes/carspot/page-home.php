<?php
/* Template Name: Home */
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Carspot
 */
get_header();
global $carspot_theme;
if (have_posts()) {
    the_post();
    $post = get_post();
    if (cs_check_is_elementor($post->ID)) {
        the_content();
    } else if ($post && (preg_match('/vc_row/', $post->post_content) || preg_match('/post_job/', $post->post_content))) {
        the_content();
    } else {
        ?>
        <section <?php post_class('faqs section-padding-80'); ?>>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                        <p><?php the_content(); ?></p>
                    </div>
                </div>
            </div>
        </section>
    <?php }
} ?>
<?php get_footer();