<?php
global $carspot_theme;
$layout = $carspot_theme['search_layout'];

$is_demo_get = carspot_search_layouts_demo();
$layout = ($is_demo_get != "") ? $is_demo_get : $layout;

$out = '';
if ($layout == 'grid_1') {
    $out .= '<div class="grid-style-2">';
}
if ($layout == 'grid_5') {
    $out .= '<div class="grid-style-1">';
}
if ($layout == 'grid_6') {
    $out .= '<div class="grid-style-2 grid-style-3">';
}
if ($carspot_theme['search_page_layout'] == 'search_layout_two') {
    $layout = 'grid_7';
}
$out .= '<div class="posts-masonry">';
?>
<?php
$c = 4;
if (isset($col)) {
    $c = $col;
}
while ($results->have_posts()) {
    $results->the_post();
    $pid = get_the_ID();
    $ads = new ads();
    $option = $layout;
    $function = "carspot_search_layout_$option";
    $out .= $ads->$function($pid, $c);
}
?>
<?php
$out .= '</div>';
if ($layout == 'grid_1') {
    $out .= '</div>';
}
if ($layout == 'grid_5') {
    $out .= '</div>';
}
if ($layout == 'grid_6') {
    $out .= '</div>';
}
?>
<!-- Ads Archive End --> 

