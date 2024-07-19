<?php
get_header();
get_template_part('template-parts/layouts/content', 'breadcrumb-project');
the_post();
?>
    <section class="custom-padding" id="project-details">
        <div class="container">
            <!-- Row -->
            <div class="row">
                <!-- Left Content Area -->
                <div class="col-sm-12 col-xs-12 col-md-8">
                    <!-- blog-grid -->
                    <div class="news-box">
                        <!-- post image -->
                        <div class="news-thumb">
                            <!-- standard post -->
                            <?php
                            $image = carspot_get_feature_image(get_the_ID(), 'rane-single-project');
                            if ($image[0] != "") {
                                $large = carspot_get_feature_image(get_the_ID(), 'large');
                                ?>
                                <a href="<?php echo esc_url($large[0]); ?>" class="tt-lightbox">
                                    <img alt="<?php the_title(); ?>" src="<?php echo esc_url($image[0]); ?>"
                                         class="img-responsive margin-bottom-30 no-image">
                                </a>
                                <?php
                            }
                            ?>
                            <!-- standard post end -->
                        </div>
                        <!-- blog detail -->
                        <div class="news-detail single">
                            <h2><?php the_title(); ?></h2>
                            <p><?php the_content(); ?></p>
                            <ul class="portfolio-meta">
                                <?php
                                if (get_post_meta(get_the_ID(), "client", true) != "") {
                                    ?>
                                    <li>
                                <span> 
									<?php echo esc_html__('Client', 'carspot'); ?>
                                </span>
                                        <?php echo esc_html(get_post_meta(get_the_ID(), "client", true)); ?>
                                    </li>
                                    <?php
                                }
                                ?>
                                <?php
                                if (get_post_meta(get_the_ID(), "created_by", true) != "") {
                                    ?>
                                    <li>
                                <span> 
									<?php echo esc_html__('Created by', 'carspot'); ?>
                                </span>
                                        <?php echo esc_html(get_post_meta(get_the_ID(), "created_by", true)); ?>
                                    </li>
                                    <?php
                                }
                                ?>
                                <?php
                                if (get_post_meta(get_the_ID(), "completed", true) != "") {
                                    ?>
                                    <li>
                                <span> 
									<?php echo esc_html__('Completed on', 'carspot'); ?>
                                </span>
                                        <?php echo esc_html(get_post_meta(get_the_ID(), "completed", true)); ?>
                                    </li>
                                    <?php
                                }
                                ?>
                                <?php
                                if (get_post_meta(get_the_ID(), "skills", true) != "") {
                                    ?>
                                    <li>
                                <span> 
									<?php echo esc_html__('Skill(s)', 'carspot'); ?>
                                </span>
                                        <?php echo esc_html(get_post_meta(get_the_ID(), "skills", true)); ?>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <?php
                            if (get_post_meta(get_the_ID(), "project_url", true) != "") {
                                ?>
                                <a href="<?php echo esc_url(get_post_meta(get_the_ID(), "project_url", true)); ?>"
                                   class="btn btn-primary" target="_blank">
                                    <?php echo esc_html__('Visit website', 'carspot'); ?>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                        <!-- blog detail end -->
                        <?php
                        if ($carspot_theme['enable_share_project']) {
                            ?>
                            <div class="b-socials full-socials pull-right clearfix">
                                <ul class="list-unstyled">
                                    <?php echo wp_kses(carspot_social_icons(), carspot_required_tags()); ?>
                                </ul>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <!-- blog-grid end -->
                </div>
                <div class="col-sm-12 col-xs-12  col-md-4">
                    <?php get_sidebar(); ?>
                </div>
                <!-- Right Sidebar Area End -->
            </div>
            <!-- Row End -->
        </div>
        <!-- end container -->
    </section>
<?php get_footer();