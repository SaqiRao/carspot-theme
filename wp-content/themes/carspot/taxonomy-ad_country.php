<?php
get_header();
global $carspot_theme; ?>
    <div class="main-content-area clearfix">
        <section class="section-padding no-top " style="margin-top:50px;">
            <!-- Main Container -->
            <div class="container-fluid">
                <!-- Row -->
                <div class="row">
                    <!-- Middle Content Area -->
                    <div class="col-md-12 col-lg-12 col-sx-12">
                        <!-- Row -->
                        <div class="row">
                            <div class="col-md-4 col-xs-12 col-sm-12 col-lg-2 padding-top-20">
                                <?php  if (is_active_sidebar('sb_themes_sidebar_archive')) {
                                    dynamic_sidebar('sb_themes_sidebar_archive');
                                }?>
                            </div>
                            <?php
                            if (have_posts()) { ?>
                                <!-- Ads Archive -->
                                <div class="posts-masonry gray">
                                    <div class="cat-description">
                                        <?php echo category_description(); ?>
                                    </div>
                                    <div class="col-md-8 col-xs-12 col-sm-12 col-lg-10">
                                        <ul class="list-unstyled">
                                            <?php
                                            while (have_posts()) {
                                                the_post();
                                                $pid = get_the_ID();
                                                $ad = new ads();
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
                            } else {
                                get_template_part('template-parts/content', 'none');
                            }
                            ?>
                        </div>
                        <!-- Row End -->
                    </div>
                    <!-- Middle Content Area  End -->
                </div>
                <!-- Row End -->
            </div>
            <!-- Main Container End -->
        </section>
    </div>
<?php get_footer();