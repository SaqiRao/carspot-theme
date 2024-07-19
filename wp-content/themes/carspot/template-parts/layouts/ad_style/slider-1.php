
<div id="single-slider" class="flexslider">
    <ul class="slides">
        <?php
        global $carspot_theme;
        $ad_id = get_the_ID();
        $media = carspot_fetch_listing_gallery($ad_id);
        $title = get_the_title();
        /* video for slider */
        if ($carspot_theme['allow_upload_video'] == true) {
            $video_url = $video_attachment_id_arr = '';
            /* get attachment id by post ID */
            $video_attachment_id = get_post_meta($ad_id, 'carspot_video_uploaded_attachment_', true);
            if ($video_attachment_id != '' && $video_attachment_id != '-1') {
                $video_attachment_id_arr = explode(",", $video_attachment_id);
            }
            if (is_array($video_attachment_id_arr) && !empty($video_attachment_id_arr) && count($video_attachment_id_arr) > 0 && $video_attachment_id_arr != "-1") {
                for ($i = 0; $i < count($video_attachment_id_arr); $i++) {
                    $video_url = wp_get_attachment_url($video_attachment_id_arr[$i]);
                    $media_type = wp_get_attachment_metadata(($video_attachment_id_arr[$i]));
                    ?>
                    <li class="slide-video">
                        <video width="750" height="420" controls>
                            <source src="<?php echo $video_url; ?>" type="<?php echo $media_type['mime_type']; ?>">
                        </video>
                    </li>
                    <?php
                }
            }
        }
        /* images for slider */
        if (count((array)$media) > 0) {
            foreach ($media as $m) {
                $mid = '';
                if (isset($m->ID)) {
                    $mid = $m->ID;
                } else {
                    $mid = $m;
                }
                $img = wp_get_attachment_image_src($mid, 'carspot-single-post');
                $full_img = wp_get_attachment_image_src($mid, 'full');
                if (wp_attachment_is_image($mid)) {
                    ?>
                    <li class="imgg-slide">
                        <a href="<?php echo esc_url($full_img[0]); ?>" data-fancybox="group">
                            <img alt="<?php echo esc_attr($title); ?>" src="<?php echo esc_url($img[0]); ?>">
                        </a>
                    </li>
                    <?php
                }
            }
        } else {
            ?>
            <li>
                <a href="<?php echo esc_url($carspot_theme['default_related_image']['url']); ?>"
                   data-fancybox="group">
                    <img alt="<?php echo esc_attr($title); ?>"
                         src="<?php echo esc_url($carspot_theme['default_related_image']['url']); ?>">
                </a>
            </li>
            <?php
        }
        ?>
    </ul>
</div>
<!-- Listing Slider Thumb -->
<div id="carousel" class="flexslider">
    <ul class="slides">
        <?php
        /* small view for video */
        if ($carspot_theme['allow_upload_video'] == true) {
            $video_url = $video_attachment_id_arr = '';
            /* get attachment id by post ID */
            $video_attachment_id = get_post_meta($ad_id, 'carspot_video_uploaded_attachment_', true);
            if ($video_attachment_id != '' && $video_attachment_id != '-1') {
                $video_attachment_id_arr = explode(",", $video_attachment_id);
            }
            if (is_array($video_attachment_id_arr) && !empty($video_attachment_id_arr) && $video_attachment_id_arr != '') {
                for ($i = 0; $i < count($video_attachment_id_arr); $i++) {
                    $video_url = wp_get_attachment_url($video_attachment_id_arr[$i]);
                    $media_type = wp_get_attachment_metadata(($video_attachment_id_arr[$i]));
                    ?>
                    <li class="video-small">
                        <video class="small-video">
                            <source src="<?php echo $video_url; ?>" type="<?php echo $media_type['mime_type']; ?>">
                        </video>
                    </li>
                    <?php
                }
            }
        }
        /* small view for images */
        if (count((array)$media) > 0) {
            foreach ($media as $m) {
                $mid = '';
                if (isset($m->ID)) {
                    $mid = $m->ID;
                } else {
                    $mid = $m;
                }
                $img = wp_get_attachment_image_src($mid, 'carspot-ad-thumb');
                if (wp_attachment_is_image($mid)) {
                    ?>
                    <li class="img-small"><img alt="<?php echo esc_attr($title); ?>" draggable="false"
                                               src="<?php echo esc_url($img[0]); ?>"></li>
                    <?php
                }
            }
        } else {
            ?>
            <li><img alt="<?php echo esc_attr($title); ?>" draggable="false"
                     src="<?php echo esc_url($carspot_theme['default_related_image']['url']); ?>"></li>
            <?php
        }
        ?>
    </ul>
</div>