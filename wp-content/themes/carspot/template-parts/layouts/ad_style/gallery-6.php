<?php
global $carspot_theme;
$ad_id = get_the_ID();
$media = carspot_fetch_listing_gallery($ad_id);
$title = get_the_title();
/* images for slider */
if (count((array)$media) > 0) {
    $slider_img_count = 0;
    foreach ($media as $m) {
        $mid = '';
        $slider_img_count = $slider_img_count + 1;
        if (isset($m->ID)) {
            $mid = $m->ID;
        } else {
            $mid = $m;
        }
        $img = wp_get_attachment_image_src($mid, 'carspot-category');
        $full_img = wp_get_attachment_image_src($mid, 'full');
        if (wp_attachment_is_image($mid)) {
            ?>

            <div class="item 1212">
                <a href="<?php echo esc_url($full_img[0]); ?>" data-fancybox="group"><img
                            alt="<?php echo esc_attr($title); ?>" class="img-responsive"
                            src="<?php echo esc_attr($img[0]); ?>"></a>
                <div class="extra-links">
                    <a href="<?php echo esc_attr($img[0]); ?>" data-fancybox="group"><span class="imgs-range">
                                    <span class="iconify img" data-icon="fa-solid:images"></span> <?php echo "Images" ?> </span></a>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="item 4334">
                <a href="<?php echo esc_url($carspot_theme['default_related_image']['url']); ?>"
                   data-fancybox="group"><img alt="<?php echo esc_attr($title); ?>" class="img-responsive"
                                              src="<?php echo esc_url($carspot_theme['default_related_image']['url']); ?>"></a>
                <div class="extra-links">
                    <!--                    <a href="#"><span class="iconify play" data-icon="gg:play-button"></span></a>-->
                    <a href="<?php echo esc_url($carspot_theme['default_related_image']['url']); ?>"
                       data-fancybox="group"><span class="imgs-range"><span class="iconify img"
                                                                            data-icon="fa-solid:images"></span><span>15 to 30</span></a>

                </div>
            </div>

            <?php
        }
    }
} else {
    ?>
    <div class="item">
        <a href="<?php echo esc_url($carspot_theme['default_related_image']['url']) ?>" data-fancybox="group"><img
                    alt="<?php echo esc_attr($title); ?>" class="img-responsive"
                    src="<?php echo esc_url($carspot_theme['default_related_image']['url']) ?>"></a>
        <div class="extra-links">
        </div>
    </div>
    <?php
}