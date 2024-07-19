<?php
global $carspot_theme;
$ad_id = get_the_ID();
$media = carspot_fetch_listing_gallery($ad_id);
$title = get_the_title();
$big_img = '';
$small_img = '';
$hidden = '';
if (count((array) $media) > 0) {
    $counter = 0;
    foreach ($media as $m) {
        $mid = '';
        if (isset($m->ID)) {
            $mid = $m->ID;
        } else {
            $mid = $m;
        }
        $img = wp_get_attachment_image_src($mid, 'carspot-single-post');
        $full_img = wp_get_attachment_image_src($mid, 'full');
        if ($counter == 0) {
            if (wp_attachment_is_image($mid)) {
                $big_img .= '<a href="' . esc_url($full_img[0]) . '" data-fancybox="group" >
				<img alt="' . esc_html__("alt", "carspot") . '" src="' . esc_url($img[0]) . '" title="' . esc_html__("img", "carspot") . '"></a>
							 <div class="total-images"><strong>' . count($media) . '</strong>  ' . esc_html__('Photos', 'carspot') . ' </div>';
            } else {
                $big_img .= '<a href="' . esc_url($carspot_theme['default_related_image']['url']) . '" data-fancybox="group" >
				<img alt="' . esc_html__("alt", "carspot") . '" src="' . esc_url($carspot_theme['default_related_image']['url']) . '" title="' . esc_html__("img", "carspot") . '" class="img-responsive width100"></a>
							 <div class="total-images"><strong>' . count($media) . '</strong>  ' . esc_html__('Photos', 'carspot') . ' </div>';
            }
        } else {
            $hidden .= '<a href="' . esc_url($full_img[0]) . '" data-fancybox="group">
			<img alt="' . esc_html__("alt", "carspot") . '" src="' . esc_url($img[0]) . '" title="' . esc_html__("img", "carspot") . '"></a>';
        }
        ++$counter;
    }
}
echo '<div class="feuture-posts clearfix">
	<div class="row">
			<div class="col-sm-12 col-md-12 col-xs-12 big-section">
				' . $big_img . '
			</div>
	</div>
			 <div class="extra-images hidden"> ' . $hidden . ' </div>
     </div>';
