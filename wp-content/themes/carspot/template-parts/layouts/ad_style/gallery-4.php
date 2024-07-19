<div class="featured-slider container owl-carousel owl-theme">
    <?php
    global $carspot_theme;
    $ad_id = get_the_ID();
    $media = carspot_fetch_listing_gallery($ad_id);
    $title = get_the_title();
    if (count((array) $media) > 0) {
        foreach ($media as $m) {
            $mid = '';
            if (isset($m->ID)) {
                $mid = $m->ID;
            } else {
                $mid = $m;
            }
            $img = wp_get_attachment_image_src($mid, 'carspot-category');
            $full_img = wp_get_attachment_image_src($mid, 'full');
            if (wp_attachment_is_image($mid)) {
                ?>
                <div class="item">
                    <div class="white category-grid-box-1">
                        <a href="<?php echo esc_url($full_img[0]); ?>" data-fancybox="group">
                            <img alt="<?php echo esc_attr($title); ?>" src="<?php echo esc_attr($img[0]); ?>">
                        </a>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="item">
                    <div class="white category-grid-box-1">
                        <a href="<?php echo esc_url($carspot_theme['default_related_image']['url']); ?>" data-fancybox="group">
                            <img alt="<?php echo esc_attr($title); ?>" src="<?php echo esc_url($carspot_theme['default_related_image']['url']); ?>">
                        </a>
                    </div>
                </div>
                <?php
            }
        }
    }
    ?>
</div>