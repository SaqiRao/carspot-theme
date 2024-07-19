<?php
global $carspot_theme;

$obj_id = get_queried_object_id();

$current_url = wp_parse_url(get_author_posts_url($obj_id), 3);

$current_user_id = get_current_user_id();
//$current_user = wp_get_current_user();
$authorID = get_query_var('author');
$user_type = get_user_meta($authorID, "_sb_user_type", true);
if ($user_type == 'dealer' || is_super_admin()) {
    get_header();
    get_template_part('template-parts/layouts/profile/profile', 'simple');
    get_footer();
} else if ($user_type == 'individual') {
    get_header();
    get_template_part('template-parts/layouts/profile/profile', 'simple');
    get_footer();
} else if (isset($_GET['type']) && $_GET['type'] == '1') {
    get_header();
    get_template_part('template-parts/layouts/profile/user', 'ratting');
    get_footer();
} else {
    require trailingslashit(get_template_directory()) . 'archive.php';
}