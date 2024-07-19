<?php

function custom_post_type() {
 
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Inspection', 'Post Type General Name', 'redux-framework' ),
        'singular_name'       => _x( 'Inspection', 'Post Type Singular Name', 'redux-framework' ),
        'menu_name'           => __( 'Inspection', 'redux-framework' ),
        'parent_item_colon'   => __( 'Parent Inspection', 'redux-framework' ),
        'all_items'           => __( 'All Inspection', 'redux-framework' ),
        'view_item'           => __( 'View Inspection', 'redux-framework' ),
        'add_new_item'        => __( 'Add New Inspection', 'redux-framework' ),
        'add_new'             => __( 'Add New', 'redux-framework' ),
        'edit_item'           => __( 'Edit Inspection', 'redux-framework' ),
        'update_item'         => __( 'Update Inspection', 'redux-framework' ),
        'search_items'        => __( 'Search Inspection', 'redux-framework' ),
        'not_found'           => __( 'Not Found', 'redux-framework' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'redux-framework' ),
    );
     
// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'inspection', 'redux-framework' ),
        'description'         => __( 'Inspection news and reviews', 'redux-framework' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest'        => true,
         
        // This is where we add taxonomies to our CPT
       
    );
 register_post_type( 'inspection', $args );

    //Ads Country
        register_taxonomy('ad_location', array('inspection'), array(
        'hierarchical' => true,
        'show_ui' => true,
        'label' => __('Location', 'redux-framework'),
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_location'),
        'meta_box_cb' => false,
    ));
  
    //Ads Maker / Model
        register_taxonomy('ad_make', array('inspection'), array(
        'hierarchical' => true,
        'show_ui' => true,
        'label' => __('Make/Model', 'redux-framework'),
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_make'),
        'meta_box_cb' => false,
    ));
 

     
    // Registering your Custom Post Type

   
 
}
 
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
 
add_action( 'init', 'custom_post_type', 0 );

//Create Custom Column
add_filter( 'manage_inspection_posts_columns', 'set_custom_edit_inspection_columns' );
add_action( 'manage_inspection_posts_custom_column' , 'custom_inspection_column', 10, 2 );

function set_custom_edit_inspection_columns($columns) {
      unset( $columns['date'] );
    $columns['title'] = __( 'User Name', 'carspot' );
    $columns['address'] = __( 'Address', 'carspot' );
    $columns['phone_number'] = __( 'Phone number', 'carspot' );
    $columns['email'] = __( 'Email', 'carspot' );
    $columns['inspection_slot'] = __( 'Inspection slot', 'carspot' );
    $columns['date'] = __( 'Date', 'carspot' );
    
    return $columns;
}


//Save Custom Column Data
function custom_inspection_column( $column, $post_id ) {
    switch ( $column ) {

        case 'address' :
            echo get_post_meta($post_id , '_carspot_insepection_address', true);
            break;

        case 'phone_number' :
            echo get_post_meta($post_id , '_carspot_insepection_number' , true ); 
            break;

        case 'inspection_slot' :
            echo get_post_meta( $post_id , '_carspot_insepection_ad_time' , true ); 
            break;

        case 'email' :
            echo get_post_meta( $post_id , '_carspot_insepection_ad_email' , true ); 
            break;
    }
}