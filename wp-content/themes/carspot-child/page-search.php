<?php
/* Template Name: Ad Search */
global $carspot_theme;
if (isset($carspot_theme['search_page_layout']) && $carspot_theme['search_page_layout'] == 'search_layout_one') {
    get_template_part('template-parts/search/search', '1');
} else {
    get_template_part('template-parts/search/search', '2');
}