<?php
if (!class_exists('carspot_profile')) {

    class carspot_profile
    {

        /* user object */
        var $user_info;

        public function __construct()
        {
            $this->user_info = get_userdata(get_current_user_id());
        }

        /* Full Width Profile Top */

        function carspot_profile_full_top()
        {
            $user_pic = carspot_get_user_dp($this->user_info->ID, 'carspot-user-profile');
            global $carspot_theme;
            $msgs = '';
            if ($carspot_theme['communication_mode'] == 'both' || $carspot_theme['communication_mode'] == 'message') {
                $msgs = '				<li>
				  <a href="javascript:void(0);">
					 <div class="menu-name" sb_action="my_msgs">' . esc_html__('Messages', 'carspot') . '</div>
				  </a>
			   </li>';
            }
            $acn_history = '';
            if (class_exists('WooCommerce')) {
                $acn_history = '<li>
				  <a href="' . get_permalink(get_option('woocommerce_myaccount_page_id')) . '" target="_blank">
					 <div class="menu-names" >' . esc_html__('Order History', 'carspot') . '</div>
				  </a>
			   </li>';
            }


            $rating = '';
            if (isset($carspot_theme['user_public_profile']) && $carspot_theme['user_public_profile'] != "" && $carspot_theme['user_public_profile'] == "modern" && isset($carspot_theme['sb_enable_user_ratting']) && $carspot_theme['sb_enable_user_ratting']) {

                $rating = '<a href="' . get_author_posts_url($this->user_info->ID) . '?type=1">
			<div class="rating">';
                $got = get_user_meta($this->user_info->ID, "_carspot_rating_avg", true);
                if ($got == "") {
                    $got = 0;
                }
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= round($got)) {
                        $rating .= '<i class="fa fa-star"></i>';
                    } else {
                        $rating .= '<i class="fa fa-star-o"></i>';
                    }
                }
                $rating .= '<span class="rating-count">
			   (';
                if (get_user_meta($this->user_info->ID, "_carspot_rating_count", true) != "") {
                    $rating .= get_user_meta($this->user_info->ID, "_carspot_rating_count", true);
                } else {
                    $rating .= 0;
                }
                $rating .= ')
			   </span>
			</div>
			</a>';
            }

            $badge = '';
            if (get_user_meta($this->user_info->ID, '_sb_badge_type', true) != "" && get_user_meta($this->user_info->ID, '_sb_badge_text', true) != "" && isset($carspot_theme['sb_enable_user_badge']) && $carspot_theme['sb_enable_user_badge'] && $carspot_theme['sb_enable_user_badge'] && isset($carspot_theme['user_public_profile']) && $carspot_theme['user_public_profile'] != "" && $carspot_theme['user_public_profile'] == "modern") {
                $badge = ' <span class="label ' . get_user_meta($this->user_info->ID, '_sb_badge_type', true) . '">
	' . get_user_meta($this->user_info->ID, '_sb_badge_text', true) . '</span>';
            }

            return '<div class="row">
	  <!-- Middle Content Area -->
	  
	  <div class="col-md-12 col-xs-12 col-sm-12">
		<section class="search-result-item">
		   <a class="image-link" href="javascript:void(0);">
		   <img class="image" alt="' . esc_html__('Profile Picture', 'carspot') . '" src="' . esc_url($user_pic) . '" id="user_dp">
		   </a>
		   <div class="search-result-item-body">
			  <div class="row">
				 <div class="col-md-5 col-sm-12 col-xs-12">
					
					<h4 class="search-result-item-heading sb_put_user_name">' . $this->user_info->display_name . '</h4>
					<p class="info">
					<span class="profile_tabs" sb_action="get_profile"><i class="fa fa-user"></i>&nbsp; ' . esc_html__('Profile', 'carspot') . '</span> 
					<span class="profile_tabs" sb_action="update_profile"><i class="fa fa-edit"></i>&nbsp; ' . esc_html__('Edit Profile', 'carspot') . '</span>
				  </p>
					<p class="info sb_put_user_address">' . get_user_meta($this->user_info->ID, '_sb_address', true) . '</p>
					<p class="description">' . esc_html__('You last logged in at', 'carspot') . ': ' . carspot_get_last_login($this->user_info->ID) . ' ' . esc_html__('Ago', 'carspot') . '</p>
					
					' . $badge . '
					' . $rating . '
				 </div>
				 <div class="col-md-7 col-sm-12 col-xs-12">
				  <div class="row ad-history">
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="user-stats">
								<h2>' . carspot_get_sold_ads($this->user_info->ID) . '</h2>
								<small>' . esc_html__('Ad Sold', 'carspot') . '</small>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="user-stats">
								<h2>' . carspot_get_all_ads($this->user_info->ID) . '</h2>
								<small>' . esc_html__('Total Listings', 'carspot') . '</small>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="user-stats">
								<h2>' . carspot_get_disbale_ads($this->user_info->ID) . '</h2>
								<small>' . esc_html__('Inactve ads', 'carspot') . '</small>
							</div>
						</div>
					</div>
				 </div>
				 
				 
				 
				 
				 
			  </div>
		   </div>
		</section>
		
		<div class="dashboard-menu-container">
			<ul>
			   
			   <li>
				  <a href="javascript:void(0);">
					 <div class="menu-name" sb_action="my_ads">' . esc_html__('My Ads', 'carspot') . '</div>
				  </a>
			   </li>
			   <li>
				  <a href="javascript:void(0);">
					 <div class="menu-name" sb_action="my_inactive_ads">' . esc_html__('Inactive Ads', 'carspot') . '</div>
				  </a>
			   </li>
			   <li>
				  <a href="javascript:void(0);">
					 <div class="menu-name" sb_action="my_feature_ads">' . esc_html__('Featured Ads', 'carspot') . '</div>
				  </a>
			   </li>
			   <li>
				  <a href="javascript:void(0);">
					 <div class="menu-name" sb_action="my_fav_ads">' . esc_html__('Fav Ads', 'carspot') . '</div>
				  </a>
			   </li>
				' . $msgs . '
				' . $acn_history . '
			</ul>
		 </div>
	  </div>
	  <!-- Middle Content Area  End -->
   </div>
		';
        }

// Full Width Profile Body
        function carspot_profile_full_body()
        {
            if (isset($_GET['sb_action']) && isset($_GET['ad_id']) && isset($_GET['uid']) && $_GET['sb_action'] == 'sb_load_messages') {

                $script = "<script>	jQuery(document).ready(function($){
   					carspot_select_msg('$_GET[ad_id]', '$_GET[uid]', 'no');
	});
	</script>
";
                $ads = new ads();

                return '<div id="carspot_res">
			 ' . $ads->carspot_load_messages($_GET['ad_id']) . '
		  </div>
		  ' . $script . '
		';
                echo 'first';
            } else if (isset($_GET['sb_action']) && isset($_GET['ad_id']) && isset($_GET['uid']) && isset($_GET['user_id']) && $_GET['sb_action'] == 'sb_get_messages') {

                $script = "<script>	jQuery(document).ready(function($){
   					carspot_select_msg('$_GET[ad_id]', '$_GET[uid]', 'yes');
	});
	</script>
";
                $ads = new ads();

                return '<div id="carspot_res">
			 ' . $ads->carspot_get_messages($_GET['user_id']) . '
		  </div>
		  ' . $script . '
		';
            } else {
                return '<div id="carspot_res">
			 ' . $this->carspot_profile_get() . '
		  </div>
		';
            }
        }

// Getting profile details
        function carspot_profile_get()
        {

            global $carspot_theme;
            $new_simple = $free_ads = $new_expiry = $new_featureds = $new_bumps = '';
            if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'package_based') {
                if (get_user_meta($this->user_info->ID, '_sb_simple_ads', true) != '-1') {
                    $free_ads = get_user_meta($this->user_info->ID, '_sb_simple_ads', true);
                } else {
                    $free_ads = esc_html__('Unlimited', 'carspot');
                }
                if (get_user_meta($this->user_info->ID, '_carspot_expire_ads', true) != '-1') {
                    $expiry = get_user_meta($this->user_info->ID, '_carspot_expire_ads', true);
                } else {
                    $expiry = __('Never', 'carspot');
                }
                if (get_user_meta($this->user_info->ID, '_carspot_featured_ads', true) != '-1') {
                    $featured_ads = get_user_meta($this->user_info->ID, '_carspot_featured_ads', true);
                } else {
                    $featured_ads = __('Unlimited', 'carspot');
                }

                if (get_user_meta($this->user_info->ID, '_carspot_bump_ads', true) != '-1') {
                    $bump_ads = get_user_meta($this->user_info->ID, '_carspot_bump_ads', true);
                } else {
                    $bump_ads = __('Unlimited', 'carspot');
                }

                $new_simple = '<dt><strong>' . __('Simple Ads ', 'carspot') . ' </strong></dt>
		<dd>
		   ' . $free_ads . '
		</dd>';

                $new_featureds = '<dt><strong>' . __('Feature Ads ', 'carspot') . ' </strong></dt>
			<dd>
			   ' . $featured_ads . '
			</dd>';

                $new_bumps = '<dt><strong>' . __('Bump-up Ads ', 'carspot') . ' </strong></dt>
			<dd>
			   ' . $bump_ads . '
			</dd>';
                $new_expiry = '<dt><strong>' . __('Package Expiry', 'carspot') . ' </strong></dt>
			<dd>
			   ' . $expiry . '
			</dd>';
            }
            $res = '
	<div class="profile-section margin-bottom-20">
		<div class="profile-tabs">
		   <div class="tab-content">
			  <div class="profile-edit tab-pane fade in active" id="profile">
				 <h2 class="heading-md">' . esc_html__('Manage your profile', 'carspot') . '</h2>
				 <dl class="dl-horizontal">
					<dt><strong>' . esc_html__('Your name', 'carspot') . '</strong></dt>
					<dd>
					   ' . $this->user_info->display_name . '
					</dd>
					<dt><strong>' . esc_html__('Email Address', 'carspot') . ' </strong></dt>
					<dd>
					   ' . $this->user_info->user_email . '
					</dd>
					<dt><strong>' . esc_html__('Phone Number', 'carspot') . ' </strong></dt>
					<dd>
					   ' . get_user_meta($this->user_info->ID, '_sb_contact', true) . '
					</dd>
					' . $new_simple . '
					' . $new_featureds . '
					' . $new_bumps . '
					' . $new_expiry . '
				 </dl>
			  </div>
		   </div>
		</div>
	 </div>
	 ';

            return $res;
        }

        function carspot_profile_update_form()
        {
            $user_pic = carspot_get_user_dp($this->user_info->ID);


            $delete_my_account = '';
            $change_password_html = '';
            $my_url = carspot_get_current_url();
            if (strpos($my_url, 'carspot.scriptsbundle.com') !== false) {
                $change_password_html = '<a data-toggle="tooltip" data-placement="top" data-original-title="' . esc_html__('Disable for Demo', 'carspot') . '">' . esc_html__('Change Password', 'carspot') . '</a>';

                $delete_my_account = '<button disabled class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="' . esc_html__('Disable for Demo', 'carspot') . '">' . esc_html__('Delete My Account', 'carspot') . '</button>';
            } else {
                $change_password_html = '<a data-target="#myModal" data-toggle="modal">' . esc_html__('Change Password', 'carspot') . '</a>';
                $delete_my_account = ' <a href="javascript:void(0);" data-userid="' . $this->user_info->ID . '" data-btn-ok-label="' . __('Yes', 'carspot') . '" data-btn-cancel-label="' . __('No', 'carspot') . '" data-toggle="confirmation" data-singleton="true" data-title="' . esc_html__('Are you sure?', 'carspot') . '" type="button" class="btn btn-primary btn-sm carspot_delete_account" id="carspot_delete_account">
						  ' . esc_html__('Delete My Account', 'carspot') . '
						  </a>';
            }

            return '
	<div class="profile-section margin-bottom-20">
		<div class="profile-tabs">
		   <div class="tab-content">
			<div class="profile-edit tab-pane fade in active" id="edit">
				 <h2 class="heading-md">' . esc_html__('Manage your Security Settings', 'carspot') . '</h2>
				 <p>' . esc_html__('Manage Your Account', 'carspot') . '</p>
				 <div class="clearfix"></div>
				 <form id="sb_update_profile" enctype="multipart/form-data">
					<div class="row">
					  
					   <div class="col-md-6 col-sm-6 col-xs-12">
						  <label>' . esc_html__('Your Name', 'carspot') . '</label>
						  <input type="text" class="form-control margin-bottom-20" value="' . esc_attr($this->user_info->display_name) . '" name="sb_user_name">
					   </div>
					   <div class="col-md-6 col-sm-6 col-xs-12">
						  <label>' . esc_html__('Email Address', 'carspot') . ' <span class="color-red">*</span></label>
						  <input type="text" class="form-control margin-bottom-20" value="' . esc_attr($this->user_info->user_email) . '" readonly>
					   </div>
					   <div class="col-md-6 col-sm-12 col-xs-12">  
						  <label>' . esc_html__('Contact Number', 'carspot') . '<span class="color-red">*</span></label>
						  <input type="text" class="form-control margin-bottom-20" name="sb_user_contact" value="' . esc_attr(get_user_meta($this->user_info->ID, '_sb_contact', true)) . '">
					   </div>
					   
					   <div class="form-group">
						  <div class="col-md-5 col-sm-12 col-xs-12 ">
						   <label>' . esc_html__('Profile Picture', 'carspot') . '<span class="color-red">*</span></label>
							 <div class="input-group">
								<span class="input-group-btn">
								<span class="btn btn-default btn-file">
								' . esc_html__('Profile Picture', 'carspot') . '
								<input type="file" id="imgInp" name="my_file_upload[]" accept = "image/*" class="sb_files-data form-control">
								</span>
								</span>
								<input type="text" class="form-control" readonly>
							 </div>
						  </div>
						  <div class="col-md-1 col-xs-12 col-sm-12 no-padding">
							 <img id="img-upload" class="img-responsive" src="' . esc_url($user_pic) . '" alt="' . esc_html__('Profile Picture', 'carspot') . '" width="100" height="100" />
						  </div>
					   </div>
					</div>
					<div class="clearfix"></div>
					<div class="row">
					   <div class="col-md-8 col-sm-8 col-xs-12">
					  	 
					   </div>
					   <div class="col-md-4 col-sm-12 col-xs-12 text-right">
					   <p class="help-block">
						  	' . $change_password_html . '
						  </p>
						  <div class="clearfix"></div>
						 ' . $delete_my_account . '
						  <button type="button" class="btn btn-theme btn-sm" id="sb_user_profile_update">
						  ' . esc_html__('Update My Info', 'carspot') . '
						  </button>
					   </div>
					</div>
				 </form>
			  </div>
			  <div class="custom-modal">
         <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
               <!-- Modal content-->
               <div class="modal-content">
                  <div class="modal-header rte">
                     <h2 class="modal-title">' . esc_html__('Password Change', 'carspot') . '</h2>
                  </div>
					<form id="sb-change-password">
				 <div class="modal-body">
					<div class="form-group">
					  <label>' . esc_html__('Current Password', 'carspot') . '</label>
					  <input placeholder="' . esc_html__('Current Password', 'carspot') . '" class="form-control" type="password"  name="current_pass" id="current_pass">
					</div>
					<div class="form-group">
					  <label>' . esc_html__('New Password', 'carspot') . '</label>
					  <input placeholder="' . esc_html__('New Password', 'carspot') . '" class="form-control" type="password" name="new_pass" id="new_pass">
					</div>
					<div class="form-group">
					  <label>' . esc_html__('Confirm New Password', 'carspot') . '</label>
					  <input placeholder="' . esc_html__('Confirm Password', 'carspot') . '" class="form-control" type="password" name="con_new_pass" id="con_new_pass">
					</div>
				 </div>
				 <div class="modal-footer">
					   <button class="btn btn-theme btn-sm" type="button" id="change_pwd">' . esc_html__('Reset My Account', 'carspot') . '</button>
					
				 </div>
		  </form>
               </div>
            </div>
         </div>
					   
					</div>

		';
        }

        // Get met Ads
        function carspot_my_ads($args, $paged, $show_pagination, $fav_ads)
        {
            $ads = new ads();

            return $ads->carspot_get_ads_grid($args, $paged, $show_pagination, $fav_ads);
        }

    }

}
if (!function_exists('carspot_load_search_countries')) {

    function carspot_load_search_countries($action_on_complete = '')
    {
        global $carspot_theme;
        $stricts = '';
        if (isset($carspot_theme['sb_location_allowed']) && !$carspot_theme['sb_location_allowed'] && isset($carspot_theme['sb_list_allowed_country'])) {
            $stricts = "componentRestrictions: {country: " . json_encode($carspot_theme['sb_list_allowed_country']) . "}";
        }
        $types = "'(cities)'";
            if (isset($carspot_theme['address_type_id']) && $carspot_theme['address_type_id'] != "") {
                if ($carspot_theme['address_type_id'] == 'addresses')
                    $types = "";
                else
                    $types = "'(cities)'";
            }

        echo "<script>
	   function carspot_location() {
	   
      var input = document.getElementById('sb_user_address');
	  var action_on_complete	=	'" . $action_on_complete . "';
	  var options = {
        types: [" . $types . "],
  " . $stricts . "
 };
      var autocomplete = new google.maps.places.Autocomplete(input, options); 
	  if( action_on_complete )
	  {
	   new google.maps.event.addListener(autocomplete, 'place_changed', function() { 
	  // document.getElementById('sb_loading').style.display	= 'block';
    var place = autocomplete.getPlace();
	document.getElementById('ad_map_lat').value = place.geometry.location.lat();
	document.getElementById('ad_map_long').value = place.geometry.location.lng();
	var markers = [
        {
            'title': '',
            'lat': place.geometry.location.lat(),
            'lng': place.geometry.location.lng(),
        },
    ];
	
	my_g_map(markers);
	//document.getElementById('sb_loading').style.display	= 'none';
});
	   }

   }
   </script>";
    }

}


// Ajax handler for add to cart
add_action('wp_ajax_sb_add_cart', 'carspot_add_to_cart');
add_action('wp_ajax_nopriv_sb_add_cart', 'carspot_add_to_cart');
if (!function_exists('carspot_add_to_cart')) {

    function carspot_add_to_cart()
    {
        check_ajax_referer('carspot_package_secure', 'security');
        global $carspot_theme;

        if (get_current_user_id() == 0) {
            $cs_sign_in_page = cs_language_page_id_callback($carspot_theme['sb_sign_in_page']);
            echo '0|' . esc_html__("You must need to logged in.", 'carspot') . '|' . get_the_permalink($cs_sign_in_page);
            die();
        }

        $product_id = $_POST['product_id'];
        $qty = $_POST['qty'];
        global $woocommerce;
        if ($woocommerce->cart->add_to_cart($product_id, $qty)) {
            echo '1|' . esc_html__("Added to cart.", 'carspot') . '|' . $woocommerce->cart->get_cart_url();
        } else {
            echo '1|' . esc_html__("Already in your cart.", 'carspot') . '|' . $woocommerce->cart->get_cart_url();
        }
        die();
    }

}

// Ajax handler for My ads
add_action('wp_ajax_sb_load_messages', 'carspot_load_messages');
if (!function_exists('carspot_load_messages')) {

    function carspot_load_messages()
    {
        $ad_id = $_POST['ad_id'];
        $profile = new carspot_profile();
        $args = array(
            'post_type' => 'ad_post',
            'author' => $profile->user_info->ID,
            'post_status' => 'any',
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => $paged,
            'order' => 'DESC',
            'orderby' => 'date'
        );


        $ads = new ads();
        echo($ads->carspot_load_messages($ad_id));

        die();
    }

}

// Ajax handler for messages
add_action('wp_ajax_my_msgs', 'carspot_my_msgs');
if (!function_exists('carspot_my_msgs')) {

    function carspot_my_msgs()
    {
        $profile = new carspot_profile();
        $ads = new ads();
        echo($ads->carspot_get_messages($profile->user_info->ID));

        die();
    }

}

// ajax handler for featured Ads

add_action('wp_ajax_my_feature_ads', 'carspot_my_feature_ads');
if (!function_exists('carspot_my_feature_ads')) {

    function carspot_my_feature_ads()
    {
        $profile = new carspot_profile();
        $paged = $_POST['paged'];
        if (!isset($paged)) {
            $paged = 1;
        }
        $args = array(
            'post_type' => 'ad_post',
            'author' => $profile->user_info->ID,
            'post_status' => 'any',
            'posts_per_page' => get_option('posts_per_page'),
            'meta_key' => '_carspot_is_feature',
            'meta_value' => '1',
            'paged' => $paged,
            'order' => 'DESC',
            'orderby' => 'date'
        );
        $fav_ads = 'no';
        $show_pagination = 1;
        $ads = new ads();
        echo($ads->carspot_get_featured_ads_grid($args, $paged, $show_pagination, $fav_ads));

        die();
    }

}

// Ajax handler for My ads
add_action('wp_ajax_my_ads', 'carspot_my_ads');
if (!function_exists('carspot_my_ads')) {

    function carspot_my_ads()
    {
        $profile = new carspot_profile();
        $paged = $_POST['paged'];
        if (!isset($paged)) {
            $paged = 1;
        }
        $args = array(
            'post_type' => 'ad_post',
            'author' => $profile->user_info->ID,
            'post_status' => 'publish',
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => $paged,
            'order' => 'DESC',
            'orderby' => 'date'
        );
        $fav_ads = 'no';
        $show_pagination = 1;
        echo($profile->carspot_my_ads($args, $paged, $show_pagination, $fav_ads));

        die();
    }

}

// Ajax handler my_ads_msgs
add_action('wp_ajax_received_msgs_ads_list', 'carspot_received_msgs_ads_list');
if (!function_exists('carspot_received_msgs_ads_list')) {

    function carspot_received_msgs_ads_list()
    {
        $ads = new ads();
        echo($ads->carspot_get_user_ads_list());

        die();
    }

}
// Ajax handler for My ads
add_action('wp_ajax_my_inactive_ads', 'carspot_my_inactive_ads');
if (!function_exists('carspot_my_inactive_ads')) {

    function carspot_my_inactive_ads()
    {

        $profile = new carspot_profile();
        $paged = $_POST['paged'];
        if (!isset($paged)) {
            $paged = 1;
        }
        $args = array(
            'post_type' => 'ad_post',
            'author' => $profile->user_info->ID,
            'post_status' => 'pending',
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => $paged,
            'order' => 'DESC',
            'orderby' => 'date'
        );
        $show_pagination = 1;

        $ads = new ads();
        echo($ads->carspot_get_ads_grid_inactive($args, $paged, $show_pagination));
        die();
    }

}
// Ajax handler for My ads
add_action('wp_ajax_my_fav_ads', 'carspot_my_fav_ads');
if (!function_exists('carspot_my_fav_ads')) {

    function carspot_my_fav_ads()
    {
        $profile = new carspot_profile();
        $paged = $_POST['paged'];
        if (!isset($paged)) {
            $paged = 1;
        }

        // Getting most ID of fav ads
        global $wpdb;
        $uid = $profile->user_info->ID;
        $rows = $wpdb->get_results("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$uid' AND meta_key LIKE '_sb_fav_id_%'");
        $pids = array(0);
        foreach ($rows as $row) {
            $pids[] = $row->meta_value;
        }
        $args = array(
            'post_type' => 'ad_post',
            'post__in' => $pids,
            'post_status' => 'publish',
            'posts_per_page' => get_option('posts_per_page'),
            'paged' => $paged,
            'order' => 'DESC',
            'orderby' => 'date'
        );
        $show_pagination = 1;
        $fav_ads = 'yes';
        echo($profile->carspot_my_ads($args, $paged, $show_pagination, $fav_ads));
        die();
    }

}


// Ajax hander for get profile
add_action('wp_ajax_get_profile', 'carspot_profile_get_ajax');
if (!function_exists('carspot_profile_get_ajax')) {

    function carspot_profile_get_ajax()
    {
        $profile = new carspot_profile();
        echo($profile->carspot_profile_get());
        die();
    }

}

// Ajax hander for update profile
add_action('wp_ajax_update_profile', 'carspot_profile_update_ajax');
if (!function_exists('carspot_profile_update_ajax')) {

    function carspot_profile_update_ajax()
    {
        $profile = new carspot_profile();
        echo($profile->carspot_profile_update_form());
        die();
    }

}

// Ajax hander for update profile processing
add_action('wp_ajax_sb_update_profile', 'carspot_profile_update_ajax_processed');
if (!function_exists('carspot_profile_update_ajax_processed')) {

    function carspot_profile_update_ajax_processed()
    {
        // Getting values
        check_ajax_referer('carspot_profile_secure', 'security');
        $params = array();
        parse_str($_POST['sb_data'], $params);
        // explode address
        $address = explode(',', sanitize_text_field($params['sb_user_address']));
        if (count((array)$address) == 3) {
            $city = trim($address[0]);
            $state = trim($address[1]);
            $country = trim($address[2]);
            update_user_meta($uid, '_sb_country', $country);
            update_user_meta($uid, '_sb_state', $state);
            update_user_meta($uid, '_sb_city', $city);
        } else if (count((array)$address) == 2) {
            $city = trim($address[0]);
            $country = trim($address[1]);
            update_user_meta($uid, '_sb_country', $country);
            update_user_meta($uid, '_sb_city', $city);
        }

        $profile = new carspot_profile();
        $uid = $profile->user_info->ID;

        wp_update_user(array('ID' => $uid, 'display_name' => sanitize_text_field($params['sb_user_name'])));
        update_user_meta($uid, '_sb_contact', sanitize_text_field($params['sb_user_contact']));
        update_user_meta($uid, '_sb_user_web_url', sanitize_text_field($params['sb_user_web_url']));
        update_user_meta($uid, '_sb_address', sanitize_text_field($params['sb_user_address']));
        update_user_meta($uid, '_sb_user_address_lat', sanitize_text_field($params['sb_user_address_lat']));
        update_user_meta($uid, '_sb_user_address_long', sanitize_text_field($params['sb_user_address_long']));
        update_user_meta($uid, '_sb_user_about', sanitize_text_field($params['sb_user_about']));

        update_user_meta($uid, '_sb_camp_name', sanitize_text_field($params['sb_camp_name']));
        update_user_meta($uid, '_sb_user_lisence', sanitize_text_field($params['sb_user_lisence']));
        update_user_meta($uid, '_sb_user_timings', sanitize_text_field($params['sb_user_timings']));
        update_user_meta($uid, '_sb_user_facebook', sanitize_text_field($params['sb_user_facebook']));
        update_user_meta($uid, '_sb_user_twitter', sanitize_text_field($params['sb_user_twitter']));
        update_user_meta($uid, '_sb_user_linkedin', sanitize_text_field($params['sb_user_linkedin']));
        update_user_meta($uid, '_sb_user_youtube', sanitize_text_field($params['sb_user_youtube']));


        //update_user_meta($uid, '_sb_user_type', $params['sb_user_type']);

        echo '1';
        die();
    }

}

add_action('wp_ajax_upload_user_pic', 'carspot_user_profile_pic');

if (!function_exists('carspot_user_profile_pic')) {

    function carspot_user_profile_pic()
    {
        check_ajax_referer('carspot_profile_pic_secure', 'security');
        /* img upload */
        $condition_img = 7;
        $img_count = count((array)explode(',', $_POST["image_gallery"]));

        if (!empty($_FILES["my_file_upload"])) {

            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';


            $files = $_FILES["my_file_upload"];

            $attachment_ids = array();
            $attachment_idss = '';

            if ($img_count >= 1) {
                $imgcount = $img_count;
            } else {
                $imgcount = 1;
            }


            $ul_con = '';

            foreach ($files['name'] as $key => $value) {
                if ($files['name'][$key]) {
                    $file = array(
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );

                    $_FILES = array("my_file_upload" => $file);

// Allow certain file formats
                    $imageFileType = end(explode('.', $file['name']));
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        echo '0|' . esc_html__("Sorry, only JPG, JPEG, PNG & GIF files are allowed.", 'carspot');
                        die();
                    }

                    // Check file size
                    if ($file['size'] > 300000) {
                        echo '0|' . esc_html__("Max allowd image size is 300KB", 'carspot');
                        die();
                    }


                    foreach ($_FILES as $file => $array) {

                        if ($imgcount >= $condition_img) {
                            break;
                        }
                        $attach_id = media_handle_upload($file, $post_id);
                        $attachment_ids[] = $attach_id;

                        $image_link = wp_get_attachment_image_src($attach_id, 'full');
                    }
                    if ($imgcount > $condition_img) {
                        break;
                    }
                    $imgcount++;
                }
            }
        }
        /* img upload */
        $attachment_idss = array_filter($attachment_ids);
        $attachment_idss = implode(',', $attachment_idss);


        $arr = array();
        $arr['attachment_idss'] = $attachment_idss;
        $arr['ul_con'] = $ul_con;

        $profile = new carspot_profile();
        $uid = $profile->user_info->ID;
        update_user_meta($uid, '_sb_user_pic', $attach_id);
        echo '1|' . $image_link[0];
        die();
    }

}

/* CARSPOT DEALER STORE FRONT UPLOAD */
add_action('wp_ajax_upload_store_pic', 'carspot_dealer_store_pic');

if (!function_exists('carspot_dealer_store_pic')) {

    function carspot_dealer_store_pic()
    {

        check_ajax_referer('carspot_cover_secure', 'security');
        /* img upload */
        $condition_img = 7;
        $img_count = count((array)explode(',', $_POST["image_gallery"]));

        if (!empty($_FILES["my_store_file"])) {

            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';


            $files = $_FILES["my_store_file"];

            $attachment_ids = array();
            $attachment_idss = '';

            if ($img_count >= 1) {
                $imgcount = $img_count;
            } else {
                $imgcount = 1;
            }


            $ul_con = '';

            foreach ($files['name'] as $key => $value) {
                if ($files['name'][$key]) {
                    $file = array(
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    );

                    $_FILES = array("my_store_file" => $file);

                    // Allow certain file formats
                    $imageFileType = end(explode('.', $file['name']));
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        echo '0|' . esc_html__("Sorry, only JPG, JPEG, PNG & GIF files are allowed.", 'carspot');
                        die();
                    }

                    // Check file size
                    if ($file['size'] > 300000) {
                        echo '0|' . esc_html__("Max allowd image size is 300KB", 'carspot');
                        die();
                    }


                    foreach ($_FILES as $file => $array) {

                        if ($imgcount >= $condition_img) {
                            break;
                        }
                        $attach_id = media_handle_upload($file, $post_id);
                        $attachment_ids[] = $attach_id;

                        $image_link = wp_get_attachment_image_src($attach_id, 'full');
                    }
                    if ($imgcount > $condition_img) {
                        break;
                    }
                    $imgcount++;
                }
            }
        }
        /* img upload */
        $attachment_idss = array_filter($attachment_ids);
        $attachment_idss = implode(',', $attachment_idss);


        $arr = array();
        $arr['attachment_idss'] = $attachment_idss;
        $arr['ul_con'] = $ul_con;

        $profile = new carspot_profile();
        $uid = $profile->user_info->ID;
        update_user_meta($uid, '_sb_store_pic', $attach_id);
        echo '1|' . $image_link[0];
        die();
    }

}


if (!function_exists('carspot_get_all_ads')) {

    function carspot_get_all_ads($user_id)
    {
        global $wpdb;
        $total = $wpdb->get_var("SELECT COUNT(*) AS total FROM  $wpdb->posts WHERE post_type = 'ad_post' AND post_status = 'publish' AND post_author = '$user_id'");

        return $total;
    }

}

if (!function_exists('carspot_get_sold_ads')) {

    function carspot_get_sold_ads($user_id)
    {
        global $wpdb;
        $total = $wpdb->get_var("SELECT COUNT(*) AS total FROM $wpdb->posts WHERE post_type = 'ad_post' AND post_author = '$user_id' AND post_status = 'publich' ");

        $args = array(
            'post_type' => 'ad_post',
            'author' => $user_id,
            'post_status' => 'publish',
            'meta_key' => '_carspot_ad_status_',
            'meta_value' => 'sold',
        );

        $query = new WP_Query($args);

        return $query->post_count;
    }

}

if (!function_exists('carspot_get_fav_ads')) {

    function carspot_get_fav_ads($user_id)
    {
        global $wpdb;
        $rows = $wpdb->get_results("SELECT meta_value FROM $wpdb->usermeta WHERE user_id = '$user_id' AND meta_key LIKE  '_sb_fav_id%' ");
        $total = 0;
        foreach ($rows as $row) {
            if (get_post_status($row->meta_value) == 'publish') {
                $total++;
            }
        }

        return $total;
    }

}


if (!function_exists('carspot_get_disbale_ads')) {

    function carspot_get_disbale_ads($user_id)
    {
        global $wpdb;
        /* $rows = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_author = '$user_id' AND post_type='ad_post' AND post_status = 'pending'" );
          return count((array) $rows ); */

        $querystr = "SELECT ID FROM $wpdb->posts, $wpdb->postmeta WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->posts.post_author = '$user_id' AND $wpdb->posts.post_type='ad_post' AND $wpdb->posts.post_status = 'pending' AND $wpdb->postmeta.meta_key = '_carspot_ad_status_'";
        $pageposts = $wpdb->get_results($querystr, OBJECT);

        return count((array)$pageposts);
    }

}

// Add to favourites
add_action('wp_ajax_sb_fav_ad', 'carspot_sb_fav_ad');
add_action('wp_ajax_nopriv_sb_fav_ad', 'carspot_sb_fav_ad');
if (!function_exists('carspot_sb_fav_ad')) {

    function carspot_sb_fav_ad()
    {
        check_ajax_referer('carspot_fav_ad_secure', 'security');
        carspot_authenticate_check();

        $ad_id = $_POST['ad_id'];

        if (get_user_meta(get_current_user_id(), '_sb_fav_id_' . $ad_id, true) == $ad_id) {
            echo '0|' . esc_html__("You have added already.", 'carspot');
        } else {
            update_user_meta(get_current_user_id(), '_sb_fav_id_' . $ad_id, $ad_id);
            echo '1|' . esc_html__("Added to your favourites.", 'carspot');
        }


        die();
    }

}
// Remove to favourites
add_action('wp_ajax_sb_fav_remove_ad', 'carspot_sb_fav_remove_ad');
if (!function_exists('carspot_sb_fav_remove_ad')) {

    function carspot_sb_fav_remove_ad()
    {
        check_ajax_referer('carspot_edit_post_secure', 'security');
        carspot_authenticate_check();

        $ad_id = $_POST['ad_id'];

        if (delete_user_meta(get_current_user_id(), '_sb_fav_id_' . $ad_id)) {
            echo '1|' . esc_html__("Ad removed successfully.", 'carspot');
        } else {
            echo '0|' . esc_html__("There'is some problem, please try again later.", 'carspot');
        }
        die();
    }

}
// Remove Ad
add_action('wp_ajax_sb_remove_ad', 'carspot_sb_remove_ad');
if (!function_exists('carspot_sb_remove_ad')) {

    function carspot_sb_remove_ad()
    {
        check_ajax_referer('carspot_edit_post_secure', 'security');
        carspot_authenticate_check();

        $ad_id = $_POST['ad_id'];
        if (wp_trash_post($ad_id)) {
            echo '1|' . esc_html__("Ad removed successfully.", 'carspot');
        } else {
            echo '0|' . esc_html__("There'is some problem, please try again later.", 'carspot');
        }


        die();
    }

}


// UPDATE AD STATUS
add_action('wp_ajax_sb_update_ad_status', 'carspot_sb_update_ad_status');
if (!function_exists('carspot_sb_update_ad_status')) {

    function carspot_sb_update_ad_status()
    {
        check_ajax_referer('carspot_edit_post_secure', 'security');
        carspot_authenticate_check();
        $ad_id = $_POST['ad_id'];
        $status = $_POST['status'];
        update_post_meta($ad_id, '_carspot_ad_status_', $status);
        echo '1|' . esc_html__("Updated successfully.", 'carspot');
        die();
    }

}

// check permission for ad posting
if (!function_exists('carspot_check_validity')) {

    function carspot_check_validity()
    {
        global $carspot_theme;
        $uid = get_current_user_id();
        if (get_user_meta($uid, '_sb_simple_ads', true) == 0 || get_user_meta($uid, '_sb_simple_ads', true) == "") {
            carspot_redirect_with_msg(get_the_permalink($carspot_theme['sb_packages_page']), esc_html__('Please subcribe package for ad posting.', 'carspot'));
            exit;
        }
    }

}
if (!function_exists('carspot_load_countries')) {

    function carspot_load_countries()
    {
        global $wpdb;
        $res = $wpdb->get_results("SELECT post_excerpt FROM $wpdb->posts WHERE post_type = '_sb_country' AND post_status = 'publish'");
        $countries = array();
        foreach ($res as $r) {
            $countries[] = $r->post_excerpt;
        }

        return json_encode($countries);
    }

}

// Ajax handler for Change Password
add_action('wp_ajax_sb_change_password', 'carspot_change_password');
if (!function_exists('carspot_change_password')) {

    function carspot_change_password()
    {
        check_ajax_referer('carspot_reset_psw_secure', 'security');
        carspot_authenticate_check();
        global $carspot_theme;
        // Getting values
        $params = array();
        parse_str($_POST['sb_data'], $params);
        $current_pass = $params['current_pass'];
        $new_pass = sanitize_text_field($params['new_pass']);
        $con_new_pass = $params['con_new_pass'];
        if ($current_pass == "" || $new_pass == "" || $con_new_pass == "") {
            echo '0|' . esc_html__("All fields are required.", 'carspot');
            die();
        }
        if ($new_pass != $con_new_pass) {
            echo '0|' . esc_html__("New password not matched.", 'carspot');
            die();
        }
        $user = get_user_by('ID', get_current_user_id());
        if ($user && wp_check_password($current_pass, $user->data->user_pass, $user->ID)) {
            wp_set_password($new_pass, $user->ID);
            echo '1|' . esc_html__("Password changed successfully.", 'carspot');
        } else {
            echo '0|' . esc_html__("Current password not matched.", 'carspot');
        }

        die();
    }

}

// Check Notification
add_action('wp_ajax_nopriv_sb_check_messages', 'carspot_check_messages');
add_action('wp_ajax_sb_check_messages', 'carspot_check_messages');
if (!function_exists('carspot_check_messages')) {

    function carspot_check_messages()
    {
        global $wpdb;
        carspot_authenticate_check();
        $user_id = get_current_user_id();
        $current_msgs = $_POST['new_msgs'];
        $unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND meta_value = '0' ");
        if ($unread_msgs > $current_msgs) {
            global $carspot_theme;
            echo '1|' . str_replace('%count%', $unread_msgs, $carspot_theme['msg_notification_text']) . '|' . $unread_msgs;
        }
        die();
    }

}
// Check Notification
add_action('wp_ajax_sb_get_notifications', 'carspot_get_notifications');
if (!function_exists('carspot_get_notifications')) {

    function carspot_get_notifications()
    {
        global $wpdb;
        global $carspot_theme;
        $user_id = get_current_user_id();
        $notes = $wpdb->get_results("SELECT * FROM $wpdb->commentmeta WHERE comment_id = '$user_id' AND  meta_value = 0 ORDER BY meta_id DESC LIMIT 5", OBJECT);
        if (count((array)$notes) > 0) {
            $list = '';
            foreach ($notes as $note) {
                $ad_img = $carspot_theme['default_related_image']['url'];
                $get_arr = explode('_', $note->meta_key);
                $ad_id = $get_arr[0];
                $media = get_attached_media('image', $ad_id);
                if (count((array)$media) > 0) {
                    $counting = 1;
                    foreach ($media as $m) {
                        if ($counting > 1) {
                            $image = wp_get_attachment_image_src($m->ID, 'carspot-single-small');
                            if ($image[0] != "") {
                                $ad_img = $image[0];
                            }
                            break;
                        }
                        $counting++;
                    }
                }

                $action = get_the_permalink($carspot_theme['new_dashboard']) . '?page-type=my-messages&?sb_action=sb_get_messages' . '&ad_id=' . $ad_id . '&user_id=' . $user_id . '&uid=' . $get_arr[1];
                $poster_id = get_post_field('post_author', $ad_id);
                if ($poster_id == $user_id) {
                    $action = get_the_permalink($carspot_theme['new_dashboard']) . '?page-type=my-messages&?sb_action=sb_load_messages' . '&ad_id=' . $ad_id . '&uid=' . $get_arr[1];
                }
                $user_data = get_userdata($get_arr[1]);
                $user_pic = carspot_get_user_dp($get_arr[1]);
                $list .= '<a href="' . esc_url($action) . '"><div class="user-img"> <img src="' . esc_url($user_pic) . '" alt="' . $user_data->display_name . '" width="30" height="50" > </div><div class="mail-contnet"><h5>' . $user_data->display_name . '</h5> <span class="mail-desc">' . get_the_title($ad_id) . '</span></div></a>';
            }
            echo "" . ($list);
        }
        die();
    }

}
// RATE DEALER
add_action('wp_ajax_sb_post_user_ratting', 'carspot_post_user_ratting');
add_action('wp_ajax_nopriv_sb_post_user_ratting', 'carspot_post_user_ratting');
if (!function_exists('carspot_post_user_ratting')) {
    function carspot_post_user_ratting()
    {
        check_ajax_referer('carspot_rating_secure', 'security');
        global $carspot_theme;
        carspot_authenticate_check();

        // Getting values
        $params = array();
        $current_user = wp_get_current_user();
        parse_str($_POST['sb_data'], $params);
        if (isset($carspot_theme['google_api_secret']) && isset($carspot_theme['google_api_key']) && $carspot_theme['google_api_secret'] != '' && $carspot_theme['google_api_key'] != '') {
            if (carspot_recaptcha_verify($carspot_theme['google_api_secret'], $params['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'], $params['dealer_review_captcha'])) {

                $rating_service_stars = $params['rating_service'];
                $rating_process_stars = $params['rating_process'];
                $rating_selection_stars = $params['rating_selection'];
                $review_title = $params['review_title'];
                $rating_recommand = $params['rating_recommand'];
                $review_message = $params['review_message'];
                $dealer_id = $params['dealer_id'];
                $rator = get_current_user_id();

                if ($dealer_id == $rator) {
                    echo '0|' . esc_html__("You can't rate yourself.", 'carspot');
                    die();
                }

                if (get_user_meta($dealer_id, '_is_rated_' . $rator, true) == $rator) {
                    echo '0|' . esc_html__("You already rated this vendor.", 'carspot');
                    die();
                } else {
                    $time = current_time('mysql');

                    $data = array(
                        'comment_post_ID' => $rator,
                        'comment_author' => $current_user->display_name,
                        'comment_author_email' => $current_user->user_email,
                        'comment_author_url' => '',
                        'comment_content' => sanitize_text_field($review_message),
                        'comment_type' => 'dealer_review',
                        'comment_parent' => 0,
                        'user_id' => $dealer_id,
                        'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
                        'comment_date' => $time,
                        'comment_approved' => 1,
                    );

                    $comment_id = wp_insert_comment($data);
                    update_comment_meta($comment_id, '_rating_service', sanitize_text_field($rating_service_stars));
                    update_comment_meta($comment_id, '_rating_proces', sanitize_text_field($rating_process_stars));
                    update_comment_meta($comment_id, '_rating_selection', sanitize_text_field($rating_selection_stars));
                    update_comment_meta($comment_id, '_rating_title', sanitize_text_field($review_title));
                    update_comment_meta($comment_id, '_rating_recommand', sanitize_text_field($rating_recommand));
                    update_user_meta($dealer_id, '_is_rated_' . $rator, $rator);

                    $total_stars = $rating_service_stars + $rating_process_stars + $rating_selection_stars;
                    $ratting = round($total_stars / "3", 1);
                    // Send email if enabled

                    if (isset($carspot_theme['email_to_user_on_rating']) && $carspot_theme['email_to_user_on_rating']) {
                        carspot_send_email_new_rating($rator, $dealer_id, $ratting, $review_message);
                    }
                    echo '1|' . esc_html__("You've rated this user.", 'carspot');
                }
                die();
            } else {
                echo '0|' . __("Please verify captcha.", 'carspot');
                die();
            }
        } else {
            $rating_service_stars = $params['rating_service'];
            $rating_process_stars = $params['rating_process'];
            $rating_selection_stars = $params['rating_selection'];
            $review_title = $params['review_title'];
            $rating_recommand = $params['rating_recommand'];
            $review_message = $params['review_message'];
            $dealer_id = $params['dealer_id'];
            $rator = get_current_user_id();

            if ($dealer_id == $rator) {
                echo '0|' . esc_html__("You can't rate yourself.", 'carspot');
                die();
            }

            if (get_user_meta($dealer_id, '_is_rated_' . $rator, true) == $rator) {
                echo '0|' . esc_html__("You already rated this vendor.", 'carspot');
                die();
            } else {
                $time = current_time('mysql');

                $data = array(
                    'comment_post_ID' => $rator,
                    'comment_author' => $current_user->display_name,
                    'comment_author_email' => $current_user->user_email,
                    'comment_author_url' => '',
                    'comment_content' => sanitize_text_field($review_message),
                    'comment_type' => 'dealer_review',
                    'comment_parent' => 0,
                    'user_id' => $dealer_id,
                    'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
                    'comment_date' => $time,
                    'comment_approved' => 1,
                );
                $comment_id = wp_insert_comment($data);
                update_comment_meta($comment_id, '_rating_service', sanitize_text_field($rating_service_stars));
                update_comment_meta($comment_id, '_rating_proces', sanitize_text_field($rating_process_stars));
                update_comment_meta($comment_id, '_rating_selection', sanitize_text_field($rating_selection_stars));
                update_comment_meta($comment_id, '_rating_title', sanitize_text_field($review_title));
                update_comment_meta($comment_id, '_rating_recommand', sanitize_text_field($rating_recommand));
                update_user_meta($dealer_id, '_is_rated_' . $rator, $rator);

                $total_stars = $rating_service_stars + $rating_process_stars + $rating_selection_stars;
                $ratting = round($total_stars / "3", 1);
                // Send email if enabled

                if (isset($carspot_theme['email_to_user_on_rating']) && $carspot_theme['email_to_user_on_rating']) {
                    carspot_send_email_new_rating($rator, $dealer_id, $ratting, $review_message);
                }
                echo '1|' . esc_html__("You've rated this user.", 'carspot');
            }
            die();
        }
    }

}

// Reply Rator
add_action('wp_ajax_sb_reply_user_rating', 'carspot_reply_rator');
add_action('wp_ajax_nopriv_sb_reply_user_rating', 'carspot_reply_rator');
if (!function_exists('carspot_reply_rator')) {
    function carspot_reply_rator()
    {
        check_ajax_referer('carspot_rating_reply_secure', 'security');
        carspot_authenticate_check();
        $params = array();
        parse_str($_POST['sb_data'], $params);
        //$review_reply	=	$params['review-reply'];
        //$comment_id	=	$params['comment_id'];
        $comment_id = $_POST['cid'];
        $reply_text = $_POST['reply_text'];
        if (!get_comment_meta($comment_id, '_rating_reply', true)) {
            update_comment_meta($comment_id, '_rating_reply', sanitize_text_field($reply_text));
            echo '1|' . esc_html__("Your reply posted", 'carspot');
        } else {
            echo '0|' . esc_html__("You have already replied to this rating.", 'carspot');
        }
        die();
    }

}

if (!function_exists('carspot_get_all_ratings')) {
    function carspot_get_all_ratings($user_id)
    {
        global $wpdb;
        $ratings = $wpdb->get_results("SELECT * FROM $wpdb->usermeta WHERE user_id = '$user_id' AND  meta_key like  '_user_%' ORDER BY umeta_id DESC", OBJECT);
        return $ratings;
    }
}
// Submit bid
add_action('wp_ajax_sb_submit_bid', 'carspot_submit_bid');
add_action('wp_ajax_nopriv_sb_submit_bid', 'carspot_submit_bid');
if (!function_exists('carspot_submit_bid')) {

    function carspot_submit_bid()
    {
        check_ajax_referer('carspot_bidding_secure', 'security');
        carspot_authenticate_check();
        global $carspot_theme;
        $params = array();
        parse_str($_POST['sb_data'], $params);
        $comments = sanitize_text_field($params['bid_comment']);
        $offer = sanitize_text_field($params['bid_amount']);
        $ad_id = $params['ad_id'];
        $min_bid = get_post_meta($ad_id, 'ad_min_bid_key', true);
        $dif_bid = get_post_meta($ad_id, 'ad_dif_bid_key', true);
        $offer_by = get_current_user_id();
        $ad_author = get_post_field('post_author', $ad_id);
        global $wpdb;
        $biddings = $wpdb->get_results("SELECT meta_key FROM $wpdb->postmeta WHERE post_id = '$ad_id' AND  meta_key like  '_carspot_bid_%' ORDER BY meta_id DESC", OBJECT);
        foreach($biddings as $userData ){
               $meta_key = $userData->meta_key;
               $meta_key = explode("_",$meta_key);
               $user_id = $meta_key["3"];
        }
        if ($offer_by == $ad_author) {
            echo '0|' . esc_html__("Ad author can't post bid.", 'carspot');
            die();
        }
        $bid = '';
        if ($offer == "") {
            $bid = date('Y-m-d') . "_separator_" . $comments . "_separator_" . $offer_by;
        } else {
            $bid = date('Y-m-d') . "_separator_" . $comments . "_separator_" . $offer_by . "_separator_" . $offer;
        }
     
       

        if (isset($carspot_theme['sb_email_on_new_bid_on']) && $carspot_theme['sb_email_on_new_bid_on']) {
            carspot_send_email_new_bid($offer_by, $ad_author, $offer, $comments, $ad_id);
        }

       /*  max Bidding Code starts     */
        $bids_res = carspot_get_all_biddings_array($ad_id);
        $total_bids = count((array)$bids_res);
        $max = 0;
        if ($total_bids > 0) {
            $max = max($bids_res);
         
        }
        $thousands_sep = ",";
        if (isset($carspot_theme['sb_price_separator'])) {
            $thousands_sep = $carspot_theme['sb_price_separator'];
        }
        $decimals = 0;
        if (isset($carspot_theme['sb_price_decimals'])) {
            $decimals = $carspot_theme['sb_price_decimals'];
        }
        $decimals_separator = ".";
        if (isset($carspot_theme['sb_price_decimals_separator'])) {
            $decimals_separator = $carspot_theme['sb_price_decimals_separator'];
        }
        // Price format
        $max = number_format((int)$max, $decimals, $decimals_separator, $thousands_sep);
        $var = intval(preg_replace('/[^\d.]/', '', $max));
        /*  max Bidding Code  End    */
            $last_offer = $var + $dif_bid; 
            $min_bid_price = $min_bid + $dif_bid;

         if($min_bid_price <= $offer){
            
         if($last_offer ==""|| $last_offer <= $offer ){  
            
            $is_exist = get_post_meta($ad_id, "_carspot_bid_" . $offer_by, true);
        if ($is_exist != "") {

            update_post_meta($ad_id, "_carspot_bid_" . $offer_by, $bid);
            echo '1|' . esc_html__("Posted successfully.", 'carspot');

            if (isset($carspot_theme['sb_enable_Email_offer']) && $carspot_theme['sb_enable_Email_offer'] == '1') {

                carspot_send_user_max_bid_email($offer_by, $user_id, $ad_author, $offer, $ad_id);

            }


        } else {
            update_post_meta($ad_id, "_carspot_bid_" . $offer_by, $bid);
            echo '1|' . esc_html__("Posted successfully.", 'carspot');

            if (isset($carspot_theme['sb_enable_Email_offer']) && $carspot_theme['sb_enable_Email_offer'] == '1') {
                
                carspot_send_user_max_bid_email($offer_by, $user_id, $ad_author, $offer, $ad_id);


            }
        }
        die();

         }else{

        echo '0|' . esc_html__("Minimum Bidding Price Is  $$last_offer.", 'carspot');  

        die();  
         }

         }else{

         
            echo '0|' . esc_html__("Your Bidding Price Is Lower Then $$min_bid_price.", 'carspot');  
            die();
             
         }

        
        

}


if (!function_exists('carspot_get_all_biddings')) {

    function carspot_get_all_biddings($ad_id)
    {
        global $wpdb;
        $biddings = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE post_id = '$ad_id' AND  meta_key like  '_carspot_bid_%' ORDER BY meta_id DESC", OBJECT);

        return $biddings;
    }

}

if (!function_exists('carspot_get_all_biddings_array')) {

    function carspot_get_all_biddings_array($ad_id)
    {
        global $wpdb;
        $biddings = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE post_id = '$ad_id' AND  meta_key like  '_carspot_bid_%' ORDER BY meta_id DESC", OBJECT);
        $bid_array = array();
        if (count((array)$biddings) > 0) {
            foreach ($biddings as $bid) {
                // date - comment - user - offer
                $data_array = explode('_separator_', $bid->meta_value);
                $bid_array[] = $data_array[3];
            }
        }

        return $bid_array;
    }

}

if (!function_exists('carspot_bidding_html')) {

    function carspot_bidding_html($ad_id)
    {
        global $carspot_theme;
        $biddings = carspot_get_all_biddings($ad_id);

        $html = '';
        if (count((array)$biddings) > 0) {
            foreach ($biddings as $bid) {               // date - comment - user - offer
                $data_array = explode('_separator_', $bid->meta_value);
                $date = $data_array[0];
                $comments = $data_array[1];
                $user = $data_array[2];

                $offer = '';
                $user_info = get_user_by('ID', $user);
                if ($user_info == "") {
                    continue;
                }
                $current_user = get_current_user_id();
                $ad_owner = get_post_field('post_author', $ad_id);
                $cls = '';
                $admin_html = '';
                if ($current_user == $ad_owner && $user_info->_sb_contact != "") {
                    $cls = 'admin';
                    $admin_html = '<div>' . $user_info->_sb_contact . '</div>';
                }

                $offer = $data_array[3];
                $thousands_sep = ",";
                if (isset($carspot_theme['sb_price_separator'])) {
                    $thousands_sep = $carspot_theme['sb_price_separator'];
                }
                $decimals = 0;
                if (isset($carspot_theme['sb_price_decimals'])) {
                    $decimals = $carspot_theme['sb_price_decimals'];
                }
                $decimals_separator = ".";
                if (isset($carspot_theme['sb_price_decimals_separator'])) {
                    $decimals_separator = $carspot_theme['sb_price_decimals_separator'];
                }
                // Price format
                $price = number_format((int)$offer, $decimals, $decimals_separator, $thousands_sep);
                $price = (isset($price) && $price != "") ? $price : 0;

                if (isset($carspot_theme['sb_price_direction']) && $carspot_theme['sb_price_direction'] == 'right') {
                    $price = $price . $carspot_theme['sb_currency'];
                } else if (isset($carspot_theme['sb_price_direction']) && $carspot_theme['sb_price_direction'] == 'left') {
                    $price = $carspot_theme['sb_currency'] . $price;
                } else {
                    $price = $carspot_theme['sb_currency'] . $price;
                }


                $col = '8';
                $html .= '<div class="panel panel-default event" id="sb_bids">
                      <div class="panel-body"><div class="author col-xs-4 col-sm-2">
        <div class="profile-image"><a href="' . get_author_posts_url($user_info->ID) . '?type=ads">
  <img alt="' . __('image not found', 'carspot') . '" src="' . esc_url(carspot_get_user_dp($user_info->ID)) . '"/></a></div></div>
  <div class="info col-xs-' . esc_attr($col) . ' col-sm-' . esc_attr($col) . '">
    <p class="no-margin-8"><strong>' . date(get_option('date_format'), strtotime($date)) . '</strong></p>
      <p>' . esc_html($comments) . ' - <strong><a href="' . get_author_posts_url($user_info->ID) . '?type=ads">' . $user_info->display_name . '</a></strong></p>
    </div>';
                $html .= '<div class="rsvp col-xs-12 col-sm-2">
      <i class="' . esc_attr($cls) . '">' . $price . '</i>
   ' . $admin_html . '
    </div>';
                $html .= '</div></div>';
            }
        }

        return $html;
    }

}


if (!function_exists('carspot_bidding_html_v2')) {

    function carspot_bidding_html_v2($ad_id)
    {
        global $carspot_theme;
        $biddings = carspot_get_all_biddings($ad_id);

        $html = '';
        if (count((array)$biddings) > 0) {
            foreach ($biddings as $bid) {
                // date - comment - user - offer
                $data_array = explode('_separator_', $bid->meta_value);
                $date = $data_array[0];
                $comments = $data_array[1];
                $user = $data_array[2];

                $offer = '';
                $user_info = get_user_by('ID', $user);
                if ($user_info == "") {
                    continue;
                }
                $current_user = get_current_user_id();
                $ad_owner = get_post_field('post_author', $ad_id);
                $cls = '';
                $admin_html = '';
                if ($current_user == $ad_owner && $user_info->_sb_contact != "") {
                    $cls = 'admin';
                    $admin_html = '<div> <a href="tel:' . $user_info->_sb_contact . '">' . $user_info->_sb_contact . '</a></div>';
                }

                $offer = $data_array[3];
                $thousands_sep = ",";
                if (isset($carspot_theme['sb_price_separator'])) {
                    $thousands_sep = $carspot_theme['sb_price_separator'];
                }
                $decimals = 0;
                if (isset($carspot_theme['sb_price_decimals'])) {
                    $decimals = $carspot_theme['sb_price_decimals'];
                }
                $decimals_separator = ".";
                if (isset($carspot_theme['sb_price_decimals_separator'])) {
                    $decimals_separator = $carspot_theme['sb_price_decimals_separator'];
                }
                // Price format
                $price = number_format((int)$offer, $decimals, $decimals_separator, $thousands_sep);
                $price = (isset($price) && $price != "") ? $price : 0;

                if (isset($carspot_theme['sb_price_direction']) && $carspot_theme['sb_price_direction'] == 'right') {
                    $price = $price . $carspot_theme['sb_currency'];
                } else if (isset($carspot_theme['sb_price_direction']) && $carspot_theme['sb_price_direction'] == 'left') {
                    $price = $carspot_theme['sb_currency'] . $price;
                } else {
                    $price = $carspot_theme['sb_currency'] . $price;
                }

                $col = '8';
                $html .= '<div class="bidding-new-box">
				<div class="bidding-new-title">
					<div class="bidding-new-meta">
						<div class="bid-meta-img">
							<a href="' . get_author_posts_url($user_info->ID) . '?type=ads"><img src="' . esc_url(carspot_get_user_dp($user_info->ID)) . '" class="img-responsive" alt="' . esc_html__('bidder image', 'carspot') . '"></a>
						</div>
						<div class="bid-meta-name">
							<p>' . date(get_option('date_format'), strtotime($date)) . '</p>
							<h3> <a href="' . get_author_posts_url($user_info->ID) . '?type=ads">' . $user_info->display_name . '</a> </h3>
						</div>
					</div>
					<div class="bidding-new-bids">
						<span>' . $price . '</span>
						' . $admin_html . '
					</div>
				</div>
				<div class="bidding-new-desc">
					<p>' . esc_html($comments) . ' </p>
				</div>
			</div>';
            }
        }

        return $html;
    }

}


if (!function_exists('carspot_bidding_stats')) {

    function carspot_bidding_stats($ad_id)
    {
        global $carspot_theme;
        $html = '';
        $bids_res = carspot_get_all_biddings_array($ad_id);
        $total_bids = count((array)$bids_res);
        $max = 0;
        $min = 0;
        if ($total_bids > 0) {
            $max = max($bids_res);
            $min = min($bids_res);
        }
        $thousands_sep = ",";
        if (isset($carspot_theme['sb_price_separator'])) {
            $thousands_sep = $carspot_theme['sb_price_separator'];
        }
        $decimals = 0;
        if (isset($carspot_theme['sb_price_decimals'])) {
            $decimals = $carspot_theme['sb_price_decimals'];
        }
        $decimals_separator = ".";
        if (isset($carspot_theme['sb_price_decimals_separator'])) {
            $decimals_separator = $carspot_theme['sb_price_decimals_separator'];
        }
        // Price format
        $max = number_format((int)$max, $decimals, $decimals_separator, $thousands_sep);
        $min = number_format((int)$min, $decimals, $decimals_separator, $thousands_sep);
        if (isset($carspot_theme['sb_price_direction']) && $carspot_theme['sb_price_direction'] == 'right') {
            $max = $max . '<span>' . $carspot_theme['sb_currency'] . '</small>';
            $min = $min . '<small>' . $carspot_theme['sb_currency'] . '</small>';
        } else if (isset($carspot_theme['sb_price_direction']) && $carspot_theme['sb_price_direction'] == 'left') {
            $max = '<small>' . $carspot_theme['sb_currency'] . '</small>' . $max;
            $min = '<small>' . $carspot_theme['sb_currency'] . '</small>' . $min;
        } else {
            $max = '<small>' . $carspot_theme['sb_currency'] . '</small>' . $max;
            $min = '<small>' . $carspot_theme['sb_currency'] . '</small>' . $min;
        }
        if (isset($carspot_theme['single_ad_style']) && $carspot_theme['single_ad_style'] == "2") {
            $html = '<ul class="">
                           			<li>
                                    	<h4> ' . esc_html__('Total Bids', 'carspot') . '</h4>
                                        <p>' . esc_html($total_bids) . '</p>
                                    </li>
                                    <li>
                                    	<h4>' . esc_html__(' Highest Bid', 'carspot') . '</h4>
                                        <p>' . $max . '</p>
                                    </li>
                                    <li>
                                    	<h4>' . esc_html__('Lowest Bid', 'carspot') . ' </h4>
                                        <p>' . $min . '</p>
                                    </li>
                           		</ul>';
        } else {
            $html = '<div class="bid-info">
                               <div class="small-box  col-md-4 col-sm-4 col-xs-12">
                                <h4>' . esc_html__('Total Bids', 'carspot') . '</h4>
                                <a href="#tab1default">' . esc_html($total_bids) . '</a>
                               </div>
                               <div class="small-box  col-md-4 col-sm-4 col-xs-12">
                                <h4>' . esc_html__('Higest', 'carspot') . '</h4>
                                <a href="#tab1default">' . $max . '</a></div>
                               <div class="small-box  col-md-4 col-sm-4 col-xs-12">
                                <h4>' . esc_html__('Lowest', 'carspot') . '</h4>
                                <a href="#tab1default">' . $min . '</a>
                               </div>
                         </div>';
        }

        return $html;
    }

}


// check permission for ad posting
if (!function_exists('carspot_check_validity')) {

    function carspot_check_validity()
    {
        global $carspot_theme;
        $uid = get_current_user_id();
        if (get_user_meta($uid, '_sb_simple_ads', true) == 0 || get_user_meta($uid, '_sb_simple_ads', true) == "") {
            carspot_redirect_with_msg(get_the_permalink($carspot_theme['sb_packages_page']), __('Please subscribe to a package to post an ad.', 'carspot'));
            exit;
        } else {

            if (get_user_meta($uid, '_carspot_expire_ads', true) != '-1') {
                if (get_user_meta($uid, '_carspot_expire_ads', true) < date('Y-m-d')) {
                    update_user_meta($uid, '_sb_simple_ads', 0);
                    update_user_meta($uid, '_carspot_featured_ads', 0);
                    carspot_redirect_with_msg(get_the_permalink($carspot_theme['sb_packages_page']), __("Your package has been expired.", 'carspot'));
                    exit;
                }
            }
        }
    }

}

/* Redirect to country on Topbar Selected */
//add_action('wp_ajax_carspot_redirect_to_country_search', 'carspot_redirect_to_country_search');
//add_action('wp_ajax_nopriv_carspot_redirect_to_country_search', 'carspot_redirect_to_country_search');
//if (!function_exists('carspot_redirect_to_country_search')) {
//
//    function carspot_redirect_to_country_search()
//    {
//        global $carspot_theme;
//        $country_id = $_POST['country_id'];
//        if($country_id !=''){
//            $search_page = get_the_permalink($carspot_theme['sb_search_page']);
//            if($search_page !=''){
//                setcookie( 'my_country_id', $country_id, current_time( 'timestamp' ) + ( DAY_IN_SECONDS * 1 ) );
//                echo $search_page;
//            }else{
//                echo '';
//            }
//
//        } else {
//            echo '';
//        }
//    die();
//    }
//}


// Make ad featured
add_action('wp_ajax_carspot_load_child_categories', 'load_first_child_categories');
add_action('wp_ajax_nopriv_carspot_load_child_categories', 'load_first_child_categories');
if (!function_exists('load_first_child_categories')) {

    function load_first_child_categories()
    {
        global $carspot_theme;
        $categ_id = $_POST['categ_id'];
        /*
         * Price Slider
         * */
        wp_enqueue_script('price-slider-custom2', trailingslashit(get_template_directory_uri()) . 'js/price_slider_shortcode.js', array('jQuery'), false, true);

        /* categories */
        $cats_html = '';
        $cats_html .= '<select class="form-select" id="new_hero_cat" aria-label="Default select example" name="cat_id">';
        $cats_html .= '<option label="' . esc_html__('Select Make', 'carspot') . '" value="">' . esc_html__('Select Make', 'carspot') . '</option>';
        $ad_cats = carspot_get_cats('ad_cats', $categ_id);
        if (count((array)$ad_cats) > 0) {
            foreach ($ad_cats as $ad_cat) {
                $cats_html .= '<option value="' . $ad_cat->term_id . '">' . $ad_cat->name . '</option>';
            }
        }
        $cats_html .= '</select>';
        echo $cats_html;
        die;
    }
}


// Make ad featured
add_action('wp_ajax_carspot_make_featured', 'carspot_make_featured_ad');
if (!function_exists('carspot_make_featured_ad')) {

    function carspot_make_featured_ad()
    {
        $ad_id = $_POST['ad_id'];
        $user_id = get_current_user_id();

        if (get_post_field('post_author', $ad_id) == $user_id) {

            if (get_user_meta($user_id, '_carspot_featured_ads', true) != 0) {
                if (get_user_meta($user_id, '_carspot_expire_ads', true) != '-1') {
                    if (get_user_meta($user_id, '_carspot_expire_ads', true) < date('Y-m-d')) {
                        echo '0|' . __("Your package has expired.", 'carspot');
                        die();
                    }
                }
                $feature_ads = get_user_meta($user_id, '_carspot_featured_ads', true);
                $feature_ads = $feature_ads - 1;
                update_user_meta($user_id, '_carspot_featured_ads', $feature_ads);

                update_post_meta($ad_id, '_carspot_is_feature', '1');
                update_post_meta($ad_id, '_carspot_is_feature_date', date('Y-m-d'));
                echo '1|' . __("This ad has been featured successfullly.", 'carspot');
            } else {
                echo '0|' . __("Get package in order to make it feature.", 'carspot');
            }
        } else {
            echo '0|' . __("You must be the Ad owner to make it featured.", 'carspot');
        }

        die();
    }

}


// Delete user
add_action('wp_ajax_carspot_delete_account', 'carspot_delete_my_account');
if (!function_exists('carspot_delete_my_account')) {

    function carspot_delete_my_account()
    {
        check_ajax_referer('carspot_del_profile_secure', 'security');
        carspot_authenticate_check();
        if (is_super_admin()) {
            echo '0|' . __("Admin can not delete his account.", 'carspot');
            die();
        } else {
            $user_id = $_POST['user_id'];
            // delete comment with that user id
            $c_args = array('user_id' => $user_id, 'post_type' => 'any', 'status' => 'all');
            $comments = get_comments($c_args);
            if (count((array)$comments) > 0) {
                foreach ($comments as $comment) :
                    wp_delete_comment($comment->comment_ID, true);
                endforeach;
            }
            // delete user posts
            $args = array('numberposts' => -1, 'post_type' => 'any', 'author' => $user_id);
            $user_posts = get_posts($args);
            // delete all the user posts
            if (count((array)$user_posts) > 0) {
                foreach ($user_posts as $user_post) {
                    wp_delete_post($user_post->ID, true);
                }
            }
            //now delete actual user
            wp_delete_user($user_id);
            echo '1|' . __("Account is deleted successfully", 'carspot') . '|' . esc_url(get_home_url());
            die();
        }
    }

}

}