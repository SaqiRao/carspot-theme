<?php
global $carspot_theme;
$ad_id = get_the_ID();
$media = carspot_fetch_listing_gallery($ad_id);
$title = get_the_title();
$big_img = '';
$small_img = '';
$small_img2 = '';
$hidden = '';

$ribbon_html = '';
if (get_post_meta($ad_id, '_carspot_is_feature', true) == '1' && get_post_meta($ad_id, '_carspot_ad_status_', true) == 'active') {
    $ribbion = 'featured-ribbon';
    if (is_rtl()) {
        $ribbion = 'featured-ribbon-rtl';
    }

    $ribbon_html = '<div class="' . esc_attr($ribbion) . '">
<span>' . esc_html__('Featured', 'carspot') . '</span>
</div>';
}

if (count((array) $media) > 0) {
    $counter = 1;

    foreach ($media as $m) {
        $mid = '';
        if (isset($m->ID)) {
            $mid = $m->ID;
        } else {
            $mid = $m;
        }
        $img = wp_get_attachment_image_src($mid, 'carspot-single-post');
        $full_img = wp_get_attachment_image_src($mid, 'full');
        if ($counter == 1) {
            if (wp_attachment_is_image($mid)) {
                $big_img .= '<a href="' . esc_url($full_img[0]) . '" data-fancybox="group" >
				<img alt="' . esc_html__("alt", "carspot") . '" src="' . esc_url($img[0]) . '" title="' . esc_html__("img", "carspot") . '"></a>
							 <div class="total-images"><strong>' . count($media) . '</strong> ' . esc_html__('Photos', 'carspot') . ' </div>';
            } else {
                $big_img .= '<a href="' . esc_url($full_img[0]) . '" data-fancybox="group" >
				<img alt="' . esc_html__("alt", "carspot") . '" src="' . esc_url($carspot_theme['default_related_image']['url']) . '" title="' . esc_html__("img", "carspot") . '"></a>
							 <div class="total-images"><strong>' . count($media) . '</strong> ' . esc_html__('Photos', 'carspot') . ' </div>';
            }
        } else if ($counter == 2) {
            if (wp_attachment_is_image($mid)) {
                $small_img2 .= '<div class="img-thumb first">
				<a href="' . esc_url($full_img[0]) . '" data-fancybox="group">
				<img alt="' . esc_html__("alt", "carspot") . '" src="' . esc_url($img[0]) . '" title="' . esc_html__("img", "carspot") . '"></a>
				</div>';
            } else {
                $small_img2 .= '<div class="img-thumb first">
				<a href="' . esc_url($full_img[0]) . '" data-fancybox="group">
				<img alt="' . esc_html__("alt", "carspot") . '" src="' . esc_url($carspot_theme['default_related_image']['url']) . '" title="' . esc_html__("img", "carspot") . '"></a>
				</div>';
            }
        } else if ($counter == 3) {
            if (wp_attachment_is_image($mid)) {
                $small_img2 .= '<div class="img-thumb first">
				<a href="' . esc_url($full_img[0]) . '" data-fancybox="group">
					<img alt="' . esc_html__("alt", "carspot") . '" src="' . esc_url($img[0]) . '" title="' . esc_html__("img", "carspot") . '"></a>
				</div>';
            } else {
                $small_img2 .= '<div class="img-thumb first">
				<a href="' . esc_url($full_img[0]) . '" data-fancybox="group">
					<img alt="' . esc_html__("alt", "carspot") . '" src="' . esc_url($carspot_theme['default_related_image']['url']) . '" title="' . esc_html__("img", "carspot") . '"></a>
				</div>';
            }
        } else {
            $hidden .= '<a href="' . esc_url($full_img[0]) . '" data-fancybox="group">
				<img alt="' . esc_html__("alt", "carspot") . '" src="' . esc_url($img[0]) . '" title="' . esc_html__("img", "carspot") . '"></a>';
        }
        $counter++;
    }
}

echo '<div class="gallery-style-post clearfix">
		<div class="col-sm-8 col-md-8 col-xs-12 big-section">
		 ' . $ribbon_html . '
			' . $big_img . '
			<div class="total-images"><strong>' . count($media) . '</strong> photos </div>
		</div>
		<div class="col-sm-4 col-md-4 col-xs-12 small-section">' . $small_img2 . '</div>
		 <div class="extra-images hidden">' . $hidden . '</div>
	</div>';
