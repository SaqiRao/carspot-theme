<?php
global $carspot_theme;

if (have_posts()) {
    $cols = '';
    if (isset($carspot_theme['review_sidebar']) && $carspot_theme['review_sidebar'] == 'no-sidebar') {
        $cols = 'col-md-4 col-sm-6 col-xs-12';
    } else {
        $cols = 'col-md-6 col-sm-6 col-xs-12';
    }
    while (have_posts()) {
        the_post();
        ?>
        <!-- Review Post-->
        <div class="<?php echo esc_attr($cols); ?>">
            <div class="mainimage">
                <span class="badge text-uppercase badge-overlay badge-tech"><?php echo esc_html(get_queried_object()->name); ?></span>
                <?php
                $img = '';
                $response = carspot_get_feature_image(get_the_ID(), 'carspot-reviews-thumb');
                if ($response[0] != "") {
                    $img = $response[0];
                } else {
                    $img = $carspot_theme['default_related_image_review']['url'];
                }
                ?>
                <a href="<?php the_permalink(); ?>">
                    <img alt="<?php the_title(); ?>" class="img-responsive" src="<?php echo esc_url($img); ?>">
                    <div class="overlay small-font">
                        <h2><?php the_title(); ?></h2>
                    </div>
                </a>
                <div class="clearfix"></div>
            </div>
        </div>
        <?php
    }
} else {
    get_template_part('template-parts/content', 'none');
}