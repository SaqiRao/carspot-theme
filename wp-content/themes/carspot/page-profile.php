<?php
/* Template Name: User Dashboard */
/**
 * The template for displaying Pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package carspot
 */
get_header();
if (is_user_logged_in()) {
    get_template_part('template-parts/layouts/user-dashboard/header', '');
    ?>
    <div id="wrapper">
        <?php get_template_part('template-parts/layouts/user-dashboard/side', 'menu'); ?>
        <!-- MAIN -->
        <div class="main dashboard-main">
            <!-- MAIN CONTENT -->
            <div class="main-content">
                <?php get_template_part('template-parts/layouts/user-dashboard/dashboard/main-redir'); ?>
            </div>
            <!-- END MAIN CONTENT -->
        </div>
        <!-- END MAIN -->
        <div class="clearfix"></div>
    </div>
    <?php get_template_part('template-parts/layouts/user-dashboard/footer', ''); ?>
    <?php
} else {
    wp_redirect(home_url());
}
get_footer();