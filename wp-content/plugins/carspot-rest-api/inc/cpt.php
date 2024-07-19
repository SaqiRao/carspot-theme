<?php
// Register Custom Post Type
function carspotAPI_custom_post_type() {

	$labels = array(
		'name'                  => _x( 'App Pages', 'Post Type General Name', 'carspot-rest-api' ),
		'singular_name'         => _x( 'App Page', 'Post Type Singular Name', 'carspot-rest-api' ),
		'menu_name'             => __( 'App Pages', 'carspot-rest-api' ),
		'name_admin_bar'        => __( 'App Page', 'carspot-rest-api' ),
		'archives'              => __( 'Item Archives', 'carspot-rest-api' ),
		'attributes'            => __( 'Item Attributes', 'carspot-rest-api' ),
		'parent_item_colon'     => __( 'Parent Item:', 'carspot-rest-api' ),
		'all_items'             => __( 'All Items', 'carspot-rest-api' ),
		'add_new_item'          => __( 'Add New Item', 'carspot-rest-api' ),
		'add_new'               => __( 'Add New', 'carspot-rest-api' ),
		'new_item'              => __( 'New Item', 'carspot-rest-api' ),
		'edit_item'             => __( 'Edit Item', 'carspot-rest-api' ),
		'update_item'           => __( 'Update Item', 'carspot-rest-api' ),
		'view_item'             => __( 'View Item', 'carspot-rest-api' ),
		'view_items'            => __( 'View Items', 'carspot-rest-api' ),
		'search_items'          => __( 'Search Item', 'carspot-rest-api' ),
		'not_found'             => __( 'Not found', 'carspot-rest-api' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'carspot-rest-api' ),
		'featured_image'        => __( 'Featured Image', 'carspot-rest-api' ),
		'set_featured_image'    => __( 'Set featured image', 'carspot-rest-api' ),
		'remove_featured_image' => __( 'Remove featured image', 'carspot-rest-api' ),
		'use_featured_image'    => __( 'Use as featured image', 'carspot-rest-api' ),
		'insert_into_item'      => __( 'Insert into item', 'carspot-rest-api' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'carspot-rest-api' ),
		'items_list'            => __( 'Items list', 'carspot-rest-api' ),
		'items_list_navigation' => __( 'Items list navigation', 'carspot-rest-api' ),
		'filter_items_list'     => __( 'Filter items list', 'carspot-rest-api' ),
	);
	$args = array(
		'label'                 => __( 'App Page', 'carspot-rest-api' ),
		'description'           => __( 'App Page is design to set the app layouts', 'carspot-rest-api' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', ),
		'hierarchical'          => true,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,		
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
	);
	register_post_type( 'app_page', $args );

}
add_action( 'init', 'carspotAPI_custom_post_type', 0 );
