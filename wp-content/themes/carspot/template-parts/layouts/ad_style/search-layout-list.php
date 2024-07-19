<?php
global $carspot_theme;

$layout = $carspot_theme['search_layout'];

$is_demo_get = carspot_search_layouts_demo();
$layout = ($is_demo_get != "") ? $is_demo_get : $layout;

if (isset($type)) {
    $layout = $type;
}
$out = '';
if ($layout == 'list_1') {
    $out .= '<div class="list-style-1"><div class="col-md-12 col-xs-12 col-sm-12">
		<div class="panel with-nav-tabs panel-default">
		 <div class="panel-heading">
			 <ul class="nav nav-tabs">
                 <li class="active"><a href="#tab1default" data-toggle="tab">' . esc_html__('Latest Ads', 'carspot') . '</a></li>
			</ul>
		</div>
		 <div class="panel-body">
            <div class="tab-content">
               <div class="tab-pane fade in active" id="tab1default">
		';
} else if ($layout == 'list_2') {
    $out .= '<div class="posts-masonry">
		   <div class="col-md-12 col-xs-12 col-sm-12">';
} else if ($layout == 'list_3') {
    $out .= '<div class="col-md-12 col-sm-12 col-xs-12">
   					<ul>';
}
// The Loop
while ($results->have_posts()) {
    $results->the_post();
    $pid = get_the_ID();
    $ads = new ads();
    $option = $layout;
    $function = "carspot_search_layout_$option";
    $out .= $ads->$function($pid);
}
if ($layout == 'list_1') {
    $out .= '</div></div></div></div></div></div>';
} else if ($layout == 'list_2') {
    $out .= '</div></div>';
} else if ($layout == 'list_3') {
    $out .= '</ul></div>';
}
?>
