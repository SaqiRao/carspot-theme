<?php
if (!class_exists('ads')) {

    class ads
    {

        var $obj;

        public function __construct()
        {
            /* Something */
        }

        function carspot_get_ads_grid($args = '', $paged = '', $show_pagination = 0, $fav_ads = '')
        {
            $my_ads = '';
            global $carspot_theme;

            $flip_it = '';
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $flip_it = 'flip';
                $ribbion = 'featured-ribbon-rtl';
            }

            $ads = new WP_Query($args);
            if ($ads->have_posts()) {
                $number = 0;
                while ($ads->have_posts()) {
                    $ads->the_post();

                    $pid = get_the_ID();
                    $status = get_post_meta(get_the_ID(), '_carspot_ad_status_', true);
                    $status = carspot_ad_statues($status);

                    if ($status == '') {
                        $status = carspot_ad_statues('active');
                    }
                    $cats_html = carspot_display_cats($pid);
                    $features_html = '';
                    if (isset($carspot_theme['listing_features_grids']) && $carspot_theme['listing_features_grids'] == "car") {
                        $features_html = carspot_display_key_features($pid, '5');
                    } else {
                        $features_html .= '<div class="margin-top-10"></div>';
                    }


                    $messages = '';
                    if ($fav_ads == 'no') {
                        if ($carspot_theme['communication_mode'] == 'both' || $carspot_theme['communication_mode'] == 'message') {


                            $messages = '<div class="notification msgs get_msgs" ad_msg=' . $pid . '>
                                    <a class="round-btn" href="javascript:void(0);"><i class="fa fa-envelope-o"></i></a>
                                    <span>' . $this->carspot_count_ad_messages($pid) . '</span>
                     	</div>';
                        }
                    }

                    $outer_html = $price_html = $price_check = '';
                    $media = carspot_fetch_listing_gallery($pid);
                    if (count($media) > 0) {
                        $counting = 1;
                        foreach ($media as $m) {
                            if ($counting > 1) {
                                break;
                            }

                            $mid = '';
                            if (isset($m->ID)) {
                                $mid = $m->ID;
                            } else {
                                $mid = $m;
                            }
                            $image = wp_get_attachment_image_src($mid, 'carspot-ad-related');
                            /* price check */
                            $price_check = carspot_adPrice(get_the_ID());
                            if (isset($price_check) && $price_check != '') {
                                $price_html = '<div class="price-tag">
									  <div class="price"><span>' . carspot_adPrice(get_the_ID()) . '</span></div>
									</div>';
                            }

                            $outer_html = '<div class="image">
				<div class="ribbon ' . carspot_ads_status_color(get_post_meta(get_the_ID(), '_carspot_ad_status_', true)) . '">' . $status . '</div>
				<a href="' . get_the_permalink() . '"><img src="' . esc_url($image[0]) . '" alt="' . esc_attr(get_the_title()) . '" class="img-responsive"></a> 
				' . $price_html . '
				 ' . $messages . '
				</div>';
                        }
                    } else {
                        $outer_html = '<div class="image">
			<div class="ribbon ' . carspot_ads_status_color(get_post_meta(get_the_ID(), '_carspot_ad_status_', true)) . '">' . $status . '</div>
					<a href="' . get_the_permalink() . '"><img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive"></a>
					<div class="price-tag">
				  		<div class="price"><span>' . carspot_adPrice(get_the_ID()) . '</span></div>
					</div>
					 ' . $messages . '
					</div>';
                    }

                    if ($fav_ads == 'no') {

                        $ad_status = '<select class="ad_status category form-control"  adid="' . get_the_ID() . '"><option value="">' . esc_html__('Post Status', 'carspot') . '</option>';
                        if (get_post_meta(get_the_ID(), '_carspot_ad_status_', true) == 'expired') {
                            $ad_status .= '<option value="expired" selected>' . carspot_ad_statues('expired') . '</option>';
                        } else {
                            $ad_status .= '<option value="expired">' . carspot_ad_statues('expired') . '</option>';
                        }
                        if (get_post_meta(get_the_ID(), '_carspot_ad_status_', true) == 'sold') {
                            $ad_status .= '<option value="sold" selected>' . carspot_ad_statues('sold') . '</option>';
                        } else {
                            $ad_status .= '<option value="sold">' . carspot_ad_statues('sold') . '</option>';
                        }
                        if (get_post_meta(get_the_ID(), '_carspot_ad_status_', true) == 'active') {
                            $ad_status .= '<option value="active" selected>' . carspot_ad_statues('active') . '</option>';
                        } else {
                            $ad_status .= '<option value="active">' . carspot_ad_statues('active') . '</option>';
                        }
                        $ad_status .= '</select>';

                        $my_url = carspot_get_current_url();
                        if (strpos($my_url, 'carspot.scriptsbundle.com') !== false) {
                            $edit = '<li><a data-toggle="tooltip" data-placement="top" data-original-title="' . esc_html__('Edit Disable for Demo', 'carspot') . '" href="javascript:void(0);"><i class="fa fa-pencil edit"></i></a> </li>';
                        } else {
                            $edit = '<li><a data-toggle="tooltip" data-placement="top" data-original-title="' . esc_html__('Edit this Ad', 'carspot') . '" href="' . get_the_permalink($carspot_theme['sb_post_ad_page']) . '?id=' . get_the_ID() . '"><i class="fa fa-pencil edit"></i></a> </li>';
                        }

                        if (strpos($my_url, 'carspot.scriptsbundle.com') !== false) {
                            $delete = '<li>
									   <a  href="javascript:void(0);"  data-toggle="tooltip" data-placement="top" data-original-title="' . esc_html__('Delete Disable for Demo', 'carspot') . '"  >
									   <i class="fa fa-times delete"></i>
									   </a>
									</li>';
                        } else {
                            $delete = '<li>
									   <a  href="javascript:void(0);" data-adid="' . get_the_ID() . '" class="remove_ad" data-toggle="confirmation" data-singleton="true" data-title="' . esc_html__('Are you sure?', 'carspot') . '" >
									   <i class="fa fa-times delete"></i>
									   </a>
									   </li>';
                        }
                    } else {
                        $my_url = carspot_get_current_url();
                        if (strpos($my_url, 'carspot.scriptsbundle.com') !== false) {
                            $remove = '<li>
								   <a  href="javascript:void(0);"  data-toggle="tooltip" data-placement="top" data-original-title="' . esc_html__('Delete Disable for Demo', 'carspot') . '"  >
								   <i class="fa fa-times delete"></i>
								   </a>
								   </li><li></li>';
                        } else {
                            $remove = '<li>
								   <a  data-toggle="confirmation" data-singleton="true" data-title="' . esc_html__('Are you sure?', 'carspot') . '"  href="javascript:void(0);" data-adid="' . get_the_ID() . '" class="remove_fav_ad" >
								   <i class="fa fa-times delete"></i>
								   </a>
								   </li>';
                        }
                    }


                    $custom_locz = '';
                    if (carspot_display_adLocation($pid) != "") {
                        $custom_locz = '<p class="location"><i class="fa fa-map-marker"></i>' . carspot_display_adLocation($pid) . '</p>';
                    }

                    $my_ads .= '<div class="col-md-4 col-lg-4 col-sm-6 col-xs-12" id="holder-' . get_the_ID() . '">
		<div class="profile-ads-grids">
                                 <div class="category-grid-box-1">
                                 ' . $outer_html . '
                                    <div class="short-description-1 clearfix">
                                       <div class="category-title"> ' . $cats_html . ' </div>
                                       <h3> <a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>
                                      ' . $custom_locz . '
                                       ' . $features_html . '
									    ' . $ad_status . '
                                    </div>
                                    <div class="ad-info-1">
                                       <p><i class="flaticon-calendar"></i> &nbsp;<span>' . get_the_date(get_option('date_format'), get_the_ID()) . '</span> </p>
                                       <ul class="pull-right ' . esc_attr($flip_it) . '">
                                         ' . $delete . '
								   		 ' . $edit . '
								        ' . $remove . '
                                       </ul>
                                    </div>
                                 </div>
								 </div>
                                 <!-- Listing Ad Grid -->
                              </div>';
                }
                wp_reset_postdata();
            } else {
                $my_ads = get_template_part('template-parts/content', 'none');
            }
            $load_more = '';
            if ($show_pagination == 1) {
                $load_more = $this->carspot_get_pages($paged, $ads->max_num_pages, $fav_ads);
            }

            return '
       <!-- Row -->
       <div class="row">
          <!-- Middle Content Area -->
          <div class="col-md-12 col-sm-12 col-xs-12">
             <!-- Row -->
             <div class="row">
                <!-- Ads Archive -->
				<div class="grid-style-2">
						<div class="posts-masonry">
							' . $my_ads . '                   
						</div>
				</div>
                <!-- Ads Archive End -->  
                <div class="clearfix"></div>
                <!-- Pagination -->  
                <div class="col-md-12 col-xs-12 col-sm-12">
                   ' . $load_more . '
                </div>
                <!-- Pagination End -->   
             </div>
             <!-- Row End -->
          </div>
          <!-- Middle Content Area  End -->
       </div>
       <!-- Row End -->
	<input type="hidden" id="max_pages" value="' . $ads->max_num_pages . '" />
';
        }

        function carspot_get_ads_grid_inactive($args = '', $paged = '', $show_pagination = 0, $fav_ads = '')
        {
            $my_ads = '';
            global $carspot_theme;

            $flip_it = '';
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $flip_it = 'flip';
                $ribbion = 'featured-ribbon-rtl';
            }

            $ads = new WP_Query($args);
            if ($ads->have_posts()) {
                $number = 0;
                while ($ads->have_posts()) {
                    $ads->the_post();

                    $pid = get_the_ID();
                    $status = get_post_meta(get_the_ID(), '_carspot_ad_status_', true);
                    $status = carspot_ad_statues($status);

                    if ($status == '') {
                        $status = carspot_ad_statues('active');
                    }
                    $cats_html = carspot_display_cats($pid);
                    $features_html = '';
                    if (isset($carspot_theme['listing_features_grids']) && $carspot_theme['listing_features_grids'] == "car") {
                        $features_html = carspot_display_key_features($pid, '5');
                    } else {
                        $features_html .= '<div class="margin-top-10"></div>';
                    }
                    $messages = '';
                    if ($fav_ads == 'no') {
                        if ($carspot_theme['communication_mode'] == 'both' || $carspot_theme['communication_mode'] == 'message') {

                            $messages = '<div class="message-box get_msgs" ad_msg=' . $pid . '>
						<div class="message"><span>
							<i class="fa fa-envelope"></i><small>' . $this->carspot_count_ad_messages($pid) . '</small>
							</span></div>
						</div>';
                        }
                    }

                    $outer_html = '';
                    $media = carspot_fetch_listing_gallery($pid);
                    if (count((array)$media) > 0) {
                        $counting = 1;
                        foreach ($media as $m) {
                            if ($counting > 1) {
                                break;
                            }

                            $mid = '';
                            if (isset($m->ID)) {
                                $mid = $m->ID;
                            } else {
                                $mid = $m;
                            }
                            $image = wp_get_attachment_image_src($mid, 'carspot-ad-related');
                            $outer_html = '<div class="image">
				<a href="' . get_the_permalink() . '"><img src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '" class="img-responsive"></a> 
				<div class="price-tag">
				  <div class="price"><span>' . carspot_adPrice(get_the_ID()) . '</span></div>
				</div>
				 ' . $messages . '
				</div>';
                        }
                    } else {

                        /* price check */
                        $price_check = carspot_adPrice(get_the_ID());
                        if (isset($price_check) && $price_check != '') {
                            $price_html = '<div class="price-tag">
									  <div class="price"><span>' . carspot_adPrice(get_the_ID()) . '</span></div>
									</div>';
                        }

                        $outer_html = '<div class="image">
				<a href="' . get_the_permalink() . '"><img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive"></a>
				' . $price_html . '
				 ' . $messages . '
				</div>';
                    }

                    $custom_locz = '';
                    if (carspot_display_adLocation($pid) != "") {
                        $custom_locz = '<p class="location"><i class="fa fa-map-marker"></i>' . carspot_display_adLocation($pid) . '</p>';
                    }

                    $my_ads .= '<div class="col-md-4 col-lg-4 col-sm-6 col-xs-12" id="holder-' . get_the_ID() . '">
						 <div class="profile-ads-grids">
                                 <div class="category-grid-box-1">
							 ' . $outer_html . '
							 <!-- Short Description -->
							 <div class="short-description-1 ">
								<!-- Category Title -->
								<div class="category-title"> ' . $cats_html . ' </div>
								<!-- Ad Title -->
								<h3><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>
								<!-- Location -->
								' . $custom_locz . '
								 ' . $features_html . '
								  ' . $ad_status . '
							 </div>
							 <!-- Ad Meta Stats -->
							 <div class="ad-info-1">
                                   <p><i class="flaticon-calendar"></i> &nbsp;<span>' . get_the_date(get_option('date_format'), get_the_ID()) . '</span> </p>
                             </div>
						  </div>
						  </div>
					   </div>';
                }
                wp_reset_postdata();
            } else {
                $my_ads = get_template_part('template-parts/content', 'none');

                return '';
            }
            $load_more = '';
            if ($show_pagination == 1) {
                $load_more = $this->carspot_get_pages($paged, $ads->max_num_pages, $fav_ads);
            }

            return '
          <!-- Middle Content Area -->
          <div class="col-md-12 col-sm-12 col-xs-12">
		  <div class="row">
	   <div role="alert" class="alert alert-info alert-dismissible">
<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">&#10005;</span></button>
<strong>' . esc_html__('Info', 'carspot') . '</strong> - 
' . esc_html__('Waiting for admin approval.', 'carspot') . '
             </div>
             <!-- Row -->
             <div class="row">
               
                <!-- Ads Archive -->
				<div class="grid-style-2">
					<div class="posts-masonry">
						' . $my_ads . '                   
					</div>
				</div>
                <!-- Ads Archive End -->  
                <div class="clearfix"></div>
                <!-- Pagination -->  
                <div class="col-md-12 col-xs-12 col-sm-12">
                   ' . $load_more . '
                </div>
                <!-- Pagination End -->   
             </div>
             <!-- Row End -->
          </div>
          <!-- Middle Content Area  End -->
       </div>
       <!-- Row End -->
	<input type="hidden" id="max_pages" value="' . $ads->max_num_pages . '" />';
        }

        function carspot_get_featured_ads_grid($args = '', $paged = '', $show_pagination = 0, $fav_ads = '')
        {
            $my_ads = $cats_html = $ad_status = $remove = '';

            global $carspot_theme;

            $colors = array('active' => 'status_active', 'expired' => 'status_expired', 'sold' => 'status_sold');

            $flip_it = '';
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $flip_it = 'flip';
                $ribbion = 'featured-ribbon-rtl';
            }


            $ads = new WP_Query($args);
            if ($ads->have_posts()) {
                $number = 0;
                while ($ads->have_posts()) {
                    $ads->the_post();

                    $pid = get_the_ID();

                    carspot_display_cats($pid);
                    $features_html = '';
                    if (isset($carspot_theme['listing_features_grids']) && $carspot_theme['listing_features_grids'] == "car") {
                        $features_html = carspot_display_key_features($pid, '5');
                    } else {
                        $features_html .= '<div class="margin-top-10"></div>';
                    }
                    $messages = '';
                    if ($fav_ads == 'no') {
                        if ($carspot_theme['communication_mode'] == 'both' || $carspot_theme['communication_mode'] == 'message') {

                            $messages = '<div class="notification msgs get_msgs" ad_msg=' . $pid . '>
                                    <a class="round-btn" href="javascript:void(0);"><i class="fa fa-envelope-o"></i></a>
                                    <span>' . $this->carspot_count_ad_messages($pid) . '</span>
                     </div>';
                        }
                    }

                    $outer_html = '';
                    $media = carspot_fetch_listing_gallery($pid);
                    $is_feature = '';
                    if (get_post_meta($pid, '_carspot_is_feature', true) == '1') {
                        $is_feature = '<div class="' . esc_attr($ribbion) . '"><span>' . esc_html__('Featured', 'carspot') . '</span></div>';
                    }
                    if (count((array)$media) > 0) {
                        $counting = 1;
                        foreach ($media as $m) {
                            if ($counting > 1) {
                                break;
                            }
                            $mid = '';
                            if (isset($m->ID)) {
                                $mid = $m->ID;
                            } else {
                                $mid = $m;
                            }
                            $image = wp_get_attachment_image_src($mid, 'carspot-ad-related');
                            $outer_html = '<div class="image">
				' . $is_feature . '
				<a href="' . get_the_permalink() . '"><img src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '" class="img-responsive"></a> 
				<div class="price-tag">
				  <div class="price"><span>' . carspot_adPrice(get_the_ID()) . '</span></div>
				</div>
				 ' . $messages . '
				</div>';
                        }
                    } else {
                        $outer_html = '<div class="image">
			' . $is_feature . '
					<a href="' . get_the_permalink() . '"><img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive"></a>
					<div class="price-tag">
				  		<div class="price"><span>' . carspot_adPrice(get_the_ID()) . '</span></div>
					</div>
					 ' . $messages . '
					</div>';
                    }
                    if ($fav_ads == 'no') {
                        $edit = '<li>
								   <a data-toggle="tooltip" data-placement="top" data-original-title="' . esc_html__('Edit this Ad', 'carspot') . '" href="' . get_the_permalink($carspot_theme['sb_post_ad_page']) . '?id=' . get_the_ID() . '"><i class="fa fa-pencil edit"></i></a> 
								   </li>';
                        $delete = '<li>
								   <a  href="javascript:void(0);" data-adid="' . get_the_ID() . '" class="remove_ad" data-toggle="confirmation" data-singleton="true" data-title="' . esc_html__('Are you sure?', 'carspot') . '" >
								   <i class="fa fa-times delete"></i>
								   </a>
				
				
								   </li>';
                    }


                    $custom_locz = '';
                    if (carspot_display_adLocation($pid) != "") {
                        $custom_locz = '<p class="location"><i class="fa fa-map-marker"></i>' . carspot_display_adLocation($pid) . '</p>';
                    }

                    $my_ads .= '<div class="col-md-4 col-lg-4 col-sm-6 col-xs-12" id="holder-' . get_the_ID() . '">
		<div class="profile-ads-grids">
                                 <div class="category-grid-box-1">
							
                                 ' . $outer_html . '
                                    <div class="short-description-1 clearfix">
                                       <div class="category-title"> ' . $cats_html . ' </div>
                                       <h3> <a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>
                                       ' . $custom_locz . '
                                        ' . $features_html . '
									    ' . $ad_status . '
                                    </div>
                                    <div class="ad-info-1">
                                       <p><i class="flaticon-calendar"></i> &nbsp;<span>' . get_the_date(get_option('date_format'), get_the_ID()) . '</span> </p>
									    <p><i class="fa fa-eye"></i><span><a href="javascript:void(0);">' . carspot_getPostViews(get_the_ID()) . ' ' . esc_html__('Views', 'carspot') . '</a></span></p>
                                       <ul class="pull-right ' . esc_attr($flip_it) . '">
                                         ' . $delete . '
								   		 ' . $edit . '
								        ' . $remove . '
                                       </ul>
                                    </div>
                                 </div>
								 </div>
                                 <!-- Listing Ad Grid -->
                              </div>';
                }
                wp_reset_postdata();
            } else {
                $my_ads = get_template_part('template-parts/content', 'none');
            }
            $load_more = '';
            if ($show_pagination == 1) {
                $load_more = $this->carspot_get_pages($paged, $ads->max_num_pages, $fav_ads);
            }

            return '<div class="row">
          <!-- Middle Content Area -->
          <div class="col-md-12 col-sm-12 col-xs-12">
             <!-- Row -->
             <div class="row">
                <!-- Ads Archive -->
				<div class="grid-style-2">
					<div class="posts-masonry">
						' . $my_ads . '                   
					</div>
				</div>
                <!-- Ads Archive End -->  
                <div class="clearfix"></div>
                <!-- Pagination -->  
                <div class="col-md-12 col-xs-12 col-sm-12">
                   ' . $load_more . '
                </div>
                <!-- Pagination End -->   
             </div>
             <!-- Row End -->
          </div>
          <!-- Middle Content Area  End -->
       </div>
       <!-- Row End -->
	<input type="hidden" id="max_pages" value="' . $ads->max_num_pages . '" />';
        }

        function carspot_get_ads_grid_slider($args = '', $title = '', $col = 6)
        {
            $my_ads = '';
            global $carspot_theme;

            $flip_it = '';
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $flip_it = 'flip';
                $ribbion = 'featured-ribbon-rtl';
            }
            $args = carspot_wpml_show_all_posts_callback($args);
            $ads = new WP_Query($args);
            if ($ads->have_posts()) {
                $number = 0;
                while ($ads->have_posts()) {
                    $ads->the_post();
                    $pid = get_the_ID();
                    $cats_html = carspot_display_cats($pid);
                    $features_html = '';

                    if (isset($carspot_theme['listing_features_grids']) && $carspot_theme['listing_features_grids'] == "car") {
                        $features_html = carspot_display_key_features($pid, '5');
                    } else {
                        $features_html .= '<div class="margin-top-10"></div>';
                    }

                    $outer_html = '';
                    $media = carspot_fetch_listing_gallery($pid);
                    if (count((array)$media) > 0) {

                        $counting = 1;
                        foreach ($media as $m) {
                            if ($counting > 1) {
                                break;
                            }

                            $mid = '';
                            if (isset($m->ID)) {
                                $mid = $m->ID;
                            } else {
                                $mid = $m;
                            }
                            $image = wp_get_attachment_image_src($mid, 'carspot-ad-related', false);
                            if (wp_attachment_is_image($mid)) {
                                $outer_html = '<div class="image">
								' . carspot_video_icon() . '
								<a href="' . get_the_permalink() . '"><img src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '" class="img-responsive"></a> 
								<div class="price-tag">
								  <div class="price"><span>' . carspot_adPrice(get_the_ID()) . '</span></div>
								</div>
								</div>';
                            } else {
                                $outer_html = '<div class="image">
					' . carspot_video_icon() . '
					<a href="' . get_the_permalink() . '"><img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive"></a> 
					<div class="price-tag">
					  <div class="price"><span>' . carspot_adPrice(get_the_ID()) . '</span></div>
					</div>
					</div>';
                            }
                            $counting++;
                        }
                    } else {
                        $outer_html = '<div class="image">
			' . carspot_video_icon() . '
				<a href="' . get_the_permalink() . '"><img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive"></a> 
				<div class="price-tag">
				  <div class="price"><span>' . carspot_adPrice(get_the_ID()) . '</span></div>
				</div>
				</div>';
                    }
                    $is_feature = '';
                    $feature_color = '';
                    if (get_post_meta($pid, '_carspot_is_feature', true) == '1') {
                        $feature_color = 'featured_ads';
                        $is_feature = '<div class="' . esc_attr($ribbion) . '"><span>' . esc_html__('Featured', 'carspot') . '</span></div>';
                    }

                    $limit_value = '';
                    $grid_title = '';
                    if (isset($carspot_theme['ad_title_limt']) && $carspot_theme['ad_title_limt'] == "1") {
                        $limit_value = $carspot_theme['grid_title_limit'];
                        $grid_title = carspot_words_count(get_the_title(), $limit_value);
                    } else {
                        $grid_title = get_the_title();
                    }

                    $custom_locz = '';
                    if (carspot_display_adLocation($pid) != "") {
                        $custom_locz = '<p class="location"><i class="fa fa-map-marker"></i>' . carspot_display_adLocation($pid) . '</p>';
                    }
                    $my_ads .= '<div class="item"><div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="holder-' . get_the_ID() . '">
						   <div class="category-grid-box-1 ' . esc_attr($feature_color) . '">
							 ' . $is_feature . '
							 ' . $outer_html . '
							 <div class="short-description-1 clearfix">
								<div class="category-title"> ' . $cats_html . ' </div>
								<h3> <a href="' . get_the_permalink() . '">' . $grid_title . '</a></h3>
								' . $custom_locz . '
								' . $features_html . '
							 </div>
							 <!-- Ad Meta Stats -->
							 <div class="ad-info-1">
							<p><i class="flaticon-calendar"></i> &nbsp;<span>' . get_the_date(get_option('date_format'), get_the_ID()) . '</span> </p>
								<ul class="pull-right ' . esc_attr($flip_it) . '">
								  <li> <a data-toggle="tooltip" data-placement="top" data-original-title="' . esc_html__('Saved Ad', 'carspot') . '" href="javascript:void(0);" class="save-ad" data-adid="' . get_the_ID() . '"><i class="flaticon-like-1"></i></a>'
                        . '                                          <input type="hidden" id="fav_ad_nonce" value="' . wp_create_nonce('carspot_fav_ad_secure') . '"  /></li>
								  <li> <a href="' . get_the_permalink() . '"><i class="flaticon-message"></i></a></li>
								</ul>
							 </div>
						  </div>
					   </div>
					   </div>';
                }
                wp_reset_postdata();
            }
            if ($my_ads == '') {
                return '';
            }
            if ($carspot_theme['single_ad_style'] == '2') {
                $title_heading = '';
                if ($carspot_theme['feature_ads_title'] != "") {
                    $title_heading = '<div class="heading-panel"><div class="col-xs-12 col-md-12 col-sm-12"><h3 class="main-title text-left 1212">
					' . $title . '
					</h3></div></div>';
                }

                return '<div class="short-features">
							<div class="grid-style-2">
								<div class="">
								' . $title_heading . '
									<div class="short-feature-body">
										<div class="featured-slider-1 owl-carousel owl-theme">
											' . $my_ads . '
										</div>
									</div>
								</div>
							</div>
						</div>';
            } else {
                $title_heading = '';
                if ($carspot_theme['feature_ads_title'] != "") {
                    $title_heading = '<div class="heading-panel"><div class="col-xs-12 col-md-12 col-sm-12"><h3 class="main-title text-left">
		' . $title . '
		</h3></div></div>';
                }

                return '<div class="grid-style-2"><div class="">
		
		' . $title_heading . '
		
		<div class="featured-slider-1 owl-carousel owl-theme">
			' . $my_ads . '
		</div>
		</div>
		</div>
		
		';
            }
        }

        function carspot_get_ads_list_style($args = '', $title = '')
        {
            global $carspot_theme;
            $html = '';
            $cats = '';
            $ads = new WP_Query($args);
            if ($ads->have_posts()) {
                while ($ads->have_posts()) {
                    $ads->the_post();
                    $mid = '';
                    $img = $carspot_theme['default_related_image']['url'];
                    $pid = get_the_ID();
                    $media = carspot_fetch_listing_gallery($pid);
                    if (count((array)$media) > 0) {
                        foreach ($media as $m) {
                            $mid = '';
                            if (isset($m->ID)) {
                                $mid = $m->ID;
                            } else {
                                $mid = $m;
                            }
                            $image = wp_get_attachment_image_src($mid, 'carspot-ad-related');
                            if ($image != '') {
                                $img = $image[0];
                                break;
                            }
                        }
                    }
                    $cats = carspot_display_cats($pid);
                    $condition_html = '';
                    if (isset($carspot_theme['allow_tax_condition']) && $carspot_theme['allow_tax_condition'] && get_post_meta(get_the_ID(), '_carspot_ad_condition', true) != "") {
                        $condition_html = '<li>
							 <div class="custom-tooltip tooltip-effect-4">
								<span class="tooltip-item"><i class="fa fa-cog"></i></span>
								<div class="tooltip-content"> 
								<strong>' . esc_html__('Condition', 'carspot') . '</strong>
								<span class="label label-danger">
								' . get_post_meta(get_the_ID(), '_carspot_ad_condition', true) . '
								</span>
								</div>
							 </div>
						  </li>';
                    }
                    $ad_type_html = '';
                    if (get_post_meta(get_the_ID(), '_carspot_ad_type', true) != "") {
                        $ad_type_html = '<li>
							 <div class="custom-tooltip tooltip-effect-4">
								<span class="tooltip-item"><i class="fa fa-check-square-o"></i></span>
								<div class="tooltip-content"> <strong>' . esc_html__('Type', 'carspot') . '</strong> <span class="label label-danger">' . get_post_meta(get_the_ID(), '_carspot_ad_type', true) . '</span> </div>
							 </div>
						  </li>';
                    }
                    if (wp_attachment_is_image($mid)) {
                        $img_url = '<img class="img-responsive"  src="' . esc_url($img) . '" alt="' . get_the_title() . '"> ';
                    } else {
                        $img_url = '<img class="img-responsive"  src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '"> ';
                    }


                    /*
                      <ul class="add_info">
                      <!-- Contact Details -->
                      <li>
                      <div class="custom-tooltip tooltip-effect-4">
                      <span class="tooltip-item"><i class="fa fa-phone"></i></span>
                      <div class="tooltip-content">
                      <h4>'.esc_html__('Contact','carspot').'</h4>
                      '.get_post_meta(get_the_ID(), '_carspot_poster_contact', true ).'
                      </div>
                      </div>


                      </li>
                      <!-- Address -->
                      <li>
                      <div class="custom-tooltip tooltip-effect-4">
                      <span class="tooltip-item"><i class="fa fa-map-marker"></i></span>
                      <div class="tooltip-content">
                      <h4>'.esc_html__('Address','carspot').'</h4>
                      '.get_post_meta(get_the_ID(), '_carspot_ad_location', true ).'</div>
                      </div>
                      </li>
                      <!-- Ad Type -->
                      '.$condition_html.'
                      <!-- Ad Type -->
                      '.$ad_type_html.'
                      </ul>
                     */
                    $html .= '<div class="ads-list-archive">
				 <!-- Image Block -->
				 <div class="col-lg-5 col-md-5 col-sm-5 no-padding">
					<!-- Img Block -->
					<div class="ad-archive-img">
					   <a href="' . get_permalink(get_the_ID()) . '">
						  <!--<div class="ribbon popular"></div>-->
						  ' . $img_url . '
					   </a>
					</div>
					<!-- Img Block -->
				 </div>
				 <!-- Ads Listing -->
				 <div class="clearfix visible-xs-block"></div>
				 <!-- Content Block -->
				 <div class="col-lg-7 col-md-7 col-sm-7 no-padding">
					<!-- Ad Desc -->
					<div class="ad-archive-desc">
					   <!-- Price -->
					   <div class="ad-price"> ' . carspot_adPrice(get_the_ID()) . '</div>
					   <!-- Title -->
					   <h3>' . get_the_title(get_the_ID()) . '</h3>
					   <!-- Category -->
					   <div class="category-title"> 
					   <span>
					   ' . $cats . '
					   </span> 
					   </div>
					   <!-- Short Description -->
					   <div class="clearfix visible-xs-block"></div>
					   <p class="hidden-sm">' . carspot_words_count(get_the_content(get_the_ID()), 100) . '</p>
					   <!-- Ad Features -->
					   <br />
					   <!-- Ad History -->
					   <div class="clearfix archive-history">
						  <div class="last-updated">' . get_the_date() . '</div>
						  <div class="ad-meta"> <a class="btn save-ad" href="javascript:void(0);" data-adid="' . get_the_ID() . '">
						  <i class="fa fa-heart-o"></i> ' . esc_html__('Add to Favourites', 'carspot') . '
						  </a> 
						  <a class="btn btn-success" href="' . get_permalink(get_the_ID()) . '">
						  ' . esc_html__('View Details', 'carspot') . '
						  </a>
						  </div>
					   </div>
					</div>
					<!-- Ad Desc End -->
				 </div>
				 <!-- Content Block End -->
			  </div>';
                }
                wp_reset_postdata();
            }
            if ($html == '') {
                return '';
            }
            if ($carspot_theme['single_ad_style'] == '2') {
                return '<div class="short-features">
						<div class="grid-panel">
							<div class="heading-panel">
							  <h3 class="main-title text-left">
								 ' . $title . '
							  </h3>
							</div>
							<div class="short-feature-body">
								<div class="posts-masonry">
									<div class="col-md-12 col-xs-12 col-sm-12 no-padding">
										' . $html . '
									</div>
								</div>
							</div>
						</div>
					</div>';
            } else {
                return '<div class="grid-panel margin-top-30">
						<div class="heading-panel">
						<div class="col-xs-12 col-md-12 col-sm-12">
						  <h3 class="main-title text-left">
							 ' . $title . '
						  </h3>
						</div>
					</div>
					<div class="posts-masonry">
							<div class="col-md-12 col-xs-12 col-sm-12">
								' . $html . '
							</div>
						</div>
					</div>
					';
            }
        }

        function carspot_search_layout_list_ads_featured($args = '', $title = '')
        {
            global $carspot_theme;
            $html = '';
            $cats = '';
            $args = carspot_wpml_show_all_posts_callback($args);
            $ads = new WP_Query($args);
            if ($ads->have_posts()) {
                while ($ads->have_posts()) {
                    $ads->the_post();

                    $pid = get_the_ID();
                    $cats_html = carspot_display_cats($pid);
                    $price = ' <div class="ad-price">' . carspot_adPrice(get_the_ID()) . '</div>';
                    $img = '';
                    $media = carspot_fetch_listing_gallery($pid);
                    if (count((array)$media) > 0) {
                        foreach ($media as $m) {
                            $mid = '';
                            if (isset($m->ID)) {
                                $mid = $m->ID;
                            } else {
                                $mid = $m;
                            }
                            $image = wp_get_attachment_image_src($mid, 'carspot-ad-related', false);
                            $imgthumb = wp_get_attachment_image_src($mid, 'carspot-listing-small');
                            if (wp_attachment_is_image($mid)) {
                                $img = '<img src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '" class="img-responsive">';
                            } else {
                                $img = '<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">';
                            }
                            break;
                        }
                    } else {
                        $img = '<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">';
                    }
                    //for thumbs
                    $related_img = '';
                    if (count((array)$media) > 0) {
                        foreach ($media as $thumb) {
                            $midz = '';
                            if (isset($thumb->ID)) {
                                $midz = $thumb->ID;
                            } else {
                                $midz = $thumb;
                            }
                            $imgthumb = wp_get_attachment_image_src($midz, 'carspot-listing-small');
                            if (wp_attachment_is_image($mid)) {
                                $related_img .= '<li><a href="' . get_the_permalink() . '"><img  src="' . esc_attr($imgthumb[0]) . '" alt="' . get_the_title() . '"></a></li>';
                            } else {
                                $related_img .= '<li><a href="' . get_the_permalink() . '"><img  src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '"></a></li>';
                            }
                        }
                    }
                    $is_feature = '';
                    $feature_color = '';
                    if (get_post_meta(get_the_ID(), '_carspot_is_feature', true) == '1') {
                        $feature_color = 'featured_ads';
                        $is_feature = '<div class="featured-ribbon"><span>' . esc_html__('Featured', 'carspot') . '</span></div>';
                    }

                    $pid = get_the_ID();


                    $html .= '<div class="ads-list-archive ' . esc_attr($feature_color) . '">
		  <!-- Image Block -->
		  <div class="col-lg-4 col-md-4 col-sm-4 no-padding">
			 <!-- Img Block -->
			 <div class="ad-archive-img">
			 ' . carspot_video_icon() . '
				<a href="' . get_the_permalink() . '">
					' . $img . '
				</a>
				' . $is_feature . '
			 </div>
			 <!-- Img Block -->
		  </div>
		  <!-- Ads Listing -->
		  <div class="clearfix visible-xs-block"></div>
		  <!-- Content Block -->
		  <div class="col-lg-8 col-md-8 col-sm-8 no-padding">
			 <!-- Ad Desc -->
			 <div class="ad-archive-desc">
				<!-- Price -->
				' . $price . '
				<!-- Title -->
				<h3><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>
				<!-- Category -->
				<div class="category-title"> ' . $cats_html . ' </div>
				<!-- Short Description -->
				<div class="clearfix visible-xs-block"></div>
				<p class="hidden-sm">' . carspot_words_count(get_the_excerpt(), 110) . '</p>
				<!-- Ad Features -->
				<ul class="add_info">
				  ' . $related_img . '
				</ul>
				<!-- Ad History -->
				<div class="clearfix archive-history">
				   <div class="last-updated">' . esc_html__('Posted', 'carspot') . ' : ' . get_the_date(get_option('date_format'), get_the_ID()) . '</div>
				   <div class="ad-meta">
						<a  href="javascript:void(0);" data-adid="' . get_the_ID() . '" class="btn save-ad"><i class="fa fa-heart-o"></i> ' . esc_html__('Favourite', 'carspot') . '</a>
						<a href="' . get_the_permalink() . '" class="btn btn-success"><i class="fa fa-phone"></i>  ' . esc_html__('View Details', 'carspot') . '</a>
				  </div>
				</div>
			 </div>
			 <!-- Ad Desc End -->
		  </div>
		  <!-- Content Block End -->
		</div>';
                }
                wp_reset_postdata();
            }
            if ($html == '') {
                return '';
            }

            return '<div class="col-xs-12 col-md-12 col-sm-12"><div class="grid-panel">
						<div class="heading-panel">
						<div class="col-xs-12 col-md-12 col-sm-12">
						  <h3 class="main-title text-left">
							 ' . $title . '
						  </h3>
						</div>
					</div>
					<div class="posts-masonry">
							<div class="col-md-12 col-xs-12 col-sm-12">
								' . $html . '
							</div>
						</div>
					</div></div>
					';
        }

        function carspot_search_layosasasasasasasut_list_ads_featured($args = '', $title = '')
        {
            $my_ads = '';
            $number = 0;
            global $carspot_theme;
            $cats_html = carspot_display_cats($pid);
            $price = ' <div class="ad-price">' . carspot_adPrice(get_the_ID()) . '</div>';
            $img = '';
            $media = carspot_fetch_listing_gallery($pid);
            if (count((array)$media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID)) {
                        $mid = $m->ID;
                    } else {
                        $mid = $m;
                    }
                    $image = wp_get_attachment_image_src($mid, 'carspot-ad-related');
                    $imgthumb = wp_get_attachment_image_src($mid, 'carspot-listing-small');
                    if (wp_attachment_is_image($mid)) {
                        $img = '<img src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '" class="img-responsive">';
                    } else {
                        $img = '<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">';
                    }
                    break;
                }
            } else {
                $img = '<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">';
            }
            //for thumbs
            $related_img = '';
            if (count((array)$media) > 0) {
                foreach ($media as $thumb) {
                    $midz = '';
                    if (isset($thumb->ID)) {
                        $midz = $thumb->ID;
                    } else {
                        $midz = $thumb;
                    }
                    $imgthumb = wp_get_attachment_image_src($midz, 'carspot-listing-small');
                    if (wp_attachment_is_image($mid)) {
                        $related_img .= '<li><a href="' . get_the_permalink() . '"><img  src="' . esc_attr($imgthumb[0]) . '" alt="' . get_the_title() . '"></a></li>';
                    } else {
                        $related_img .= '<li><a href="' . get_the_permalink() . '"><img  src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '"></a></li>';
                    }
                }
            }
        }

        function carspot_get_pages($paged = '', $max_pages = '', $fav_ads = '')
        {
            $load_more = '';
            if ($max_pages > 1) {
                $load_more = ' <ul class="pagination pagination-lg">';
                $p = $paged - 1;
                if ($paged != 1) {
                    $load_more .= '<li> <a href="javascript:void(0);" page_no="' . $p . '" class="sb_page" ad_type="' . $fav_ads . '"><i class="fa fa-chevron-left" aria-hidden="true"></i></a></li>';
                }
                $class = '';
                for ($k = 1; $k <= $max_pages; $k++) {
                    $class = '';
                    $a_class = '';
                    if ($k == $paged) {
                        $class = 'class="active"';
                    } else {
                        $a_class = 'class="sb_page"';
                    }
                    $load_more .= '<li ' . $class . '> <a href="javascript:void(0);" page_no="' . $k . '" ' . $a_class . ' ad_type="' . $fav_ads . '">' . $k . '</a></li>';
                }
                $next = $paged + 1;
                if ($paged != $max_pages) {
                    $load_more .= '<li><a href="javascript:void(0);" page_no="' . $next . '" class="sb_page" ad_type="' . $fav_ads . '"> <i class="fa fa-chevron-right" aria-hidden="true"></i></a>';
                }
                $load_more .= '</ul>';
            }

            return $load_more;
        }

        function carspot_count_ad_messages($ad_id = '')
        {
            global $wpdb;

            $total = $wpdb->get_var("SELECT COUNT(DISTINCT(comment_author)) as total FROM $wpdb->comments WHERE comment_post_ID = '$ad_id' AND user_id != '" . get_current_user_id() . "'");

            return $total;
        }

        function carspot_load_messages($ad_id = '')
        {
            $script = '<script type="text/javascript">
         jQuery(document).ready(function($){
         "use strict";
         $(\'.message-history\').wrap(\'<div class="list-wrap"></div>\');
         function scrollbar() {
            var $scrollbar = $(\'.message-inbox .list-wrap\');
            $scrollbar.perfectScrollbar({
                maxScrollbarLength: 150,
            });
            $scrollbar.perfectScrollbar(\'update\');
         }
         scrollbar();
         $(\'.messages\').wrap(\'<div class="list-wraps"></div>\');
         function scrollbar1() {
            var $scrollbar1 = $(\'.message-details .list-wraps\');
            $scrollbar1.perfectScrollbar({
                maxScrollbarLength: 150,
            });
            $scrollbar1.perfectScrollbar(\'update\');
         }
          scrollbar1();
         });
      </script>';

            echo($script);
            global $wpdb;

            $rows = $wpdb->get_results("SELECT comment_author, user_id FROM $wpdb->comments WHERE comment_post_ID = '$ad_id'  GROUP BY user_id ORDER BY MAX(comment_date) DESC");

            $users = '';
            $messages = '';
            $author_html = '';
            $form = '<div class="text-center">' . esc_html__('No message received on this ad yet.', 'carspot') . '</div>';
            $turn = 1;
            $level_2 = '';
            foreach ($rows as $row) {
                if (get_current_user_id() == $row->user_id) {
                    continue;
                }
                $user_dp = carspot_get_user_dp($row->user_id);

                $last_date = $wpdb->get_var("SELECT comment_date FROM $wpdb->comments WHERE comment_post_ID = '$ad_id' AND user_id = '" . $row->user_id . "' AND comment_type = 'ad_post' ORDER BY comment_date DESC LIMIT 1");
                $date = explode(' ', $last_date);
                $cls = '';
                if ($turn == 1) {
                    $cls = 'message-history-active';
                }

                $msg_status = get_comment_meta(get_current_user_id(), $ad_id . "_" . $row->user_id, true);
                $status = '';
                if ($msg_status == '0') {
                    $status = '<i class="fa fa-envelope" aria-hidden="true"></i>';
                }
                $users .= '<li class="user_list ' . $cls . '" cid="' . $ad_id . '" second_user="' . $row->user_id . '" id="sb_' . $row->user_id . '_' . $ad_id . '">
						 <a href="javascript:void(0);">
							<div class="image">
							   <img src="' . esc_url($user_dp) . '" alt="' . $row->comment_author . '">
							</div>
							<div class="user-name">
							   <div class="author">
								  <span>' . $row->comment_author . '</span>
							   </div>
							   <p>' . get_the_title($ad_id) . '</p>
							   <div class="time" id="' . $row->user_id . '_' . $ad_id . '">
								  	' . $status . '
							   </div>
							</div>
						 </a>
					  </li>
';
                $authors = array($row->user_id, get_current_user_id());
                if ($turn == 1) {
                    $args = array(
                        'author__in' => $authors,
                        'post_id' => $ad_id,
                        'parent' => $row->user_id,
                        'orderby' => 'comment_date',
                        'order' => 'ASC',
                    );
                    $comments = get_comments($args);
                    if (count((array)$comments) > 0) {


                        $level_2 = '<input type="hidden" id="usr_id" name="usr_id" value="' . $row->user_id . '" />
				<input type="hidden" id="rece_id" name="rece_id" value="' . $row->user_id . '" />
				<input type="hidden" name="msg_receiver_id" id="msg_receiver_id" value="' . esc_attr($row->user_id) . '" />
				';
                        foreach ($comments as $comment) {
                            $user_pic = '';
                            $class = 'friend-message';
                            if ($comment->user_id == get_current_user_id()) {
                                $class = 'my-message';
                            }
                            $user_pic = carspot_get_user_dp($comment->user_id);
                            $messages .= '<li class="' . $class . ' clearfix">
									 <figure class="profile-picture">
										 <a href="' . get_author_posts_url($comment->user_id) . '?type=ads" class="link" target="_blank">
										<img src="' . esc_url($user_pic) . '" class="img-circle" alt="' . esc_html__('Profile Pic', 'carspot') . '">
										</a>
									 </figure>
									 <div class="message">
										' . $comment->comment_content . '
										<div class="time"><i class="fa fa-clock-o"></i> ' . carspot_timeago($comment->comment_date) . '</div>
									 </div>
								  </li>';
                        }
                    }
                    global $carspot_theme;
                    if (isset($carspot_theme['sb_demo_mode']) && $carspot_theme['sb_demo_mode'] == true) {
                        $send_msg_btn = '<span class="" data-toggle="tooltip" title="' . esc_html__('Disabled in demo', 'carspot') . '"><button class="btn btn-theme" type="button" inbox="no" disabled>' . esc_html__('Send', 'carspot') . '</button></span>';
                    } else {
                        $send_msg_btn = '<button class="btn btn-theme" id="send_msg" type="submit" inbox="no">' . esc_html__('Send', 'carspot') . '</button>';
                    }
                    // Message form
                    $profile = new carspot_profile();
                    $form = '<form role="form" class="form-inline" id="send_message">
                                 <div class="form-group">
								 <input type="hidden" name="ad_post_id" id="ad_post_id" value="' . $ad_id . '" />
								 <input type="hidden" name="name" value="' . $profile->user_info->display_name . '" />
								 <input type="hidden" name="email" value="' . $profile->user_info->user_email . '" />
								 ' . $level_2 . '
                                    <input name="message" id="sb_forest_message" placeholder="' . esc_html__('Type a message here...', 'carspot') . '" class="form-control message-text" autocomplete="off" type="text" data-parsley-required="true" data-parsley-error-message="' . esc_html__('This field is required.', 'carspot') . '">
									<input type="hidden" id="message_nonce" value="' . wp_create_nonce('carspot_message_secure') . '"  />
                                 </div>
                                 ' . $send_msg_btn . '
                              </form>';
                }
                $turn++;
            }
            if ($users == '') {
                $users = '<li class="padding-top-30 padding-bottom-20"><div class="user-name">' . esc_html__('No message received on this ad yet.', 'carspot') . '</div></li>';
            }
            $title = '';
            if (isset($ad_id) && $ad_id != "") {
                $title = '<a href="' . get_the_permalink($ad_id) . '" target="_blank" >' . get_the_title($ad_id) . '</a>';
            }
            $title_html = '<h2 class="sb_ad_title">' . $title . '</h2>';

            return $script . '<section class="gray">
                  <div class="message-body">
				  	<div class="row">
                     <div class="col-md-4 col-sm-5 col-xs-12">
                        <div class="message-inbox">
                           <div class="message-header">
							  <span ><a class="messages_actions active" sb_action="received_msgs_ads_list">' . esc_html__('Received Offers', 'carspot') . '</a></span>
                              <span><a class="messages_actions" sb_action="my_msgs">' . esc_html__('Sent Offers', 'carspot') . '</a></span>
							  <h4>' . esc_html__('Users', 'carspot') . '</h4>
                           </div>
							<ul class="message-history">
								' . $users . '
							</ul>
                        </div>
                     </div>
                     <div class="col-md-8 clearfix col-sm-7 col-xs-12 message-content">
					 	' . $title_html . '
                        <div class="message-details">
                           <ul class="messages" id="messages">
                              ' . $messages . '
                           </ul>
                           <div class="chat-form ">
                              ' . $form . '
                           </div>
                        </div>
                     </div>
					 </div>
                  </div>
         </section>';
        }

        function carspot_get_user_ads_list()
        {
            global $carspot_theme;
            $script = '<script type="text/javascript">
         jQuery(document).ready(function($){
         "use strict";
         $(\'.message-history\').wrap(\'<div class="list-wrap"></div>\');
         function scrollbar() {
            var $scrollbar = $(\'.message-inbox .list-wrap\');
            $scrollbar.perfectScrollbar({
                maxScrollbarLength: 150,
            });
            $scrollbar.perfectScrollbar(\'update\');
         }
         scrollbar();
         $(\'.messages\').wrap(\'<div class="list-wraps"></div>\');
         function scrollbar1() {
            var $scrollbar1 = $(\'.message-details .list-wraps\');
            $scrollbar1.perfectScrollbar({
                maxScrollbarLength: 150,
            });
            $scrollbar1.perfectScrollbar(\'update\');
         }
          scrollbar1();
         });
      </script>';

            global $wpdb;
            $profile = new carspot_profile();
            $args = array(
                'post_type' => 'ad_post',
                'author' => $profile->user_info->ID,
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'paged' => $paged,
                'order' => 'DESC',
                'orderby' => 'ID'
            );
            $ads = new WP_Query($args);
            if ($ads->have_posts()) {
                $number = 0;
                $ads_list = '';
                while ($ads->have_posts()) {
                    $ads->the_post();
                    $pid = get_the_ID();
                    $ad_img = $carspot_theme['default_related_image']['url'];
                    $media = carspot_fetch_listing_gallery($pid);
                    if (count((array)$media) > 0) {
                        foreach ($media as $m) {
                            $mid = '';
                            if (isset($m->ID)) {
                                $mid = $m->ID;
                            } else {
                                $mid = $m;
                            }
                            $img = wp_get_attachment_image_src($mid, 'carspot-ad-related');
                            $ad_img = $img[0];
                            break;
                        }
                    }

                    $is_unread_msgs = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->commentmeta WHERE comment_id = '" . get_current_user_id() . "' AND meta_value = '0' AND meta_key like '" . $pid . "_%'");

                    $status = '';
                    if ($is_unread_msgs > 0) {
                        $status = '<i class="fa fa-envelope" aria-hidden="true"></i>';
                    }

                    $ads_list .= '<li class="get_msgs" ad_msg="' . esc_attr($pid) . '"><a href="javascript:void(0);">
							<div class="image">
							   <img src="' . esc_url($ad_img) . '" alt="' . get_the_title($pid) . '">
							</div>
							<div class="user-name">
							   <div class="author">
								  <span>' . get_the_title($pid) . '</span>
							   </div>
							   <div class="time">
								  ' . $status . '
							   </div>
							</div>
						 </a>
						 </li>';
                }
            }
            $msg = '<div class="text-center">' . esc_html__('Please click to your ad in order to see messages.', 'carspot') . '</div>';

            return $script . '<div>
                   <div class="message-body">
				   <div class="row">
                     <div class="col-md-4 col-sm-5 col-xs-12">
                        <div class="message-inbox">
                           <div class="message-header">
                              
							  <span ><a class="active messages_actions" sb_action="received_msgs_ads_list"  >' . esc_html__('Recevied Offers', 'carspot') . '</a></span>
                              <span><a class="messages_actions" sb_action="my_msgs">' . esc_html__('Sent Offers', 'carspot') . '</a></span>
							  <h4>' . esc_html__('Ads', 'carspot') . '</h4>
                           </div>
							<ul class="message-history">
								' . $ads_list . '
							</ul>
                        </div>
                     </div>
                     <div class="col-md-8 clearfix col-sm-7 col-xs-12 message-content">
                        <div class="message-details">
                           <div class="chat-form ">
                              ' . $msg . '
                           </div>
                        </div>
                     </div>
					 </div>
                  </div>
               </div>';
        }

        function carspot_get_messages($user_id = '')
        {
            global $carspot_theme;
            $script = '<script type="text/javascript">
         jQuery(document).ready(function($){
         "use strict";
         $(\'.message-history\').wrap(\'<div class="list-wrap"></div>\');
         function scrollbar() {
            var $scrollbar = $(\'.message-inbox .list-wrap\');
            $scrollbar.perfectScrollbar({
                maxScrollbarLength: 150,
            });
            $scrollbar.perfectScrollbar(\'update\');
         }
         scrollbar();
         $(\'.messages\').wrap(\'<div class="list-wraps"></div>\');
         function scrollbar1() {
            var $scrollbar1 = $(\'.message-details .list-wraps\');
            $scrollbar1.perfectScrollbar({
                maxScrollbarLength: 150,
            });
            $scrollbar1.perfectScrollbar(\'update\');
         }
          scrollbar1();
         });
      </script>';

            global $wpdb;

            $rows = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_type = 'ad_post' AND user_id = '$user_id' AND comment_parent = '$user_id' GROUP BY comment_post_ID ORDER BY comment_ID DESC");

            $users = '';
            $messages = '';
            $form = '<div class="text-center">' . esc_html__('No message received on this ad yet.', 'carspot') . '</div>';
            $author_html = '';
            $turn = 1;
            $level_2 = '';
            $title_html = '';
            foreach ($rows as $row) {
                $last_date = $row->comment_date;
                $date = explode(' ', $last_date);
                $author = get_post_field('post_author', $row->comment_post_ID);
                $cls = '';
                if ($turn == 1) {
                    $cls = 'message-history-active';
                }

                $ad_img = $carspot_theme['default_related_image']['url'];
                $media = get_attached_media('image', $row->comment_post_ID);
                if (count((array)$media) > 0) {
                    foreach ($media as $m) {
                        $img = wp_get_attachment_image_src($m->ID, 'carspot-ad-related');
                        $ad_img = $img[0];
                        break;
                    }
                }


                if (isset($row->comment_post_ID) && $row->comment_post_ID != "") {
                    if ($turn == 1) {
                        $title_html .= '<h2 class="sb_ad_title" id="title_for_' . esc_attr($row->comment_post_ID) . '"><a href="' . get_the_permalink($row->comment_post_ID) . '" target="_blank" >' . get_the_title($row->comment_post_ID) . '</a></h2>';
                    } else {
                        $title_html .= '<h2 class="sb_ad_title no-display" id="title_for_' . esc_attr($row->comment_post_ID) . '" ><a href="' . get_the_permalink($row->comment_post_ID) . '" target="_blank" >' . get_the_title($row->comment_post_ID) . '</a></h2>';
                    }
                }


                $ad_id = $row->comment_post_ID;
                $comment_author = get_userdata($author);

                $msg_status = get_comment_meta(get_current_user_id(), $ad_id . "_" . $author, true);
                $status = '';
                if ($msg_status == '0') {
                    $status = '<i class="fa fa-envelope" aria-hidden="true"></i>';
                }

                $users .= '<li class="user_list ad_title_show ' . $cls . '" cid="' . $row->comment_post_ID . '" second_user="' . $author . '" inbox="yes" id="sb_' . $author . '_' . $ad_id . '">
						 <a href="javascript:void(0);">
							<div class="image">
							   <img src="' . esc_url($ad_img) . '" alt="' . $comment_author->display_name . '">
							</div>
							<div class="user-name">
							   <div class="author">
								  <span>' . get_the_title($ad_id) . '</span>
							   </div>
							   <p>' . $comment_author->display_name . '</p>
							   <div class="time" id="' . $author . '_' . $ad_id . '">
								  ' . $status . '
							   </div>
							</div>
						 </a>
					  </li>
';
                $authors = array($author, get_current_user_id());
                if ($turn == 1) {
                    $args = array(
                        'author__in' => $authors,
                        'post_id' => $ad_id,
                        'parent' => get_current_user_id(),
                        'post_type' => 'ad_post',
                        'orderby' => 'comment_date',
                        'order' => 'ASC',
                    );
                    $comments = get_comments($args);
                    if (count((array)$comments) > 0) {

                        foreach ($comments as $comment) {
                            $user_pic = '';
                            $class = 'friend-message';
                            if ($comment->user_id == get_current_user_id()) {
                                $class = 'my-message';
                            }
                            $user_pic = carspot_get_user_dp($comment->user_id);
                            $messages .= '<li class="' . $class . ' clearfix">
									 <figure class="profile-picture">
									 <a href="' . get_author_posts_url($comment->user_id) . '?type=ads" class="link" target="_blank">
										<img src="' . esc_url($user_pic) . '" class="img-circle" alt="' . esc_html__('Profile Pic', 'carspot') . '">
										</a>
									 </figure>
									 <div class="message">
										' . $comment->comment_content . '
										<div class="time"><i class="fa fa-clock-o"></i> ' . carspot_timeago($comment->comment_date) . '</div>
									 </div>
								  </li>';
                        }
                    }


                    if (isset($carspot_theme['sb_demo_mode']) && $carspot_theme['sb_demo_mode'] == true) {
                        $send_msg_btn = '<span class="" data-toggle="tooltip" title="' . esc_html__('Disabled in demo', 'carspot') . '"><button class="btn btn-theme" type="button" inbox="yes" disabled>' . esc_html__('Send', 'carspot') . '</button></span>';
                    } else {
                        $send_msg_btn = '<button class="btn btn-theme" id="send_msg" type="submit" inbox="yes">' . esc_html__('Send', 'carspot') . '</button>';
                    }

                    // Message form
                    $profile = new carspot_profile();
                    $level_2 = '<input type="hidden" name="usr_id" value="' . $user_id . '" />
			<input type="hidden" id="usr_id" value="' . $author . '" />
			<input type="hidden" id="rece_id" name="rece_id" value="' . $author . '" />
			<input type="hidden" name="msg_receiver_id" id="msg_receiver_id" value="' . esc_attr($author) . '" />
			';
                    $form = '<form role="form" class="form-inline" id="send_message">
                                 <div class="form-group">
								 <input type="hidden" name="ad_post_id" id="ad_post_id" value="' . $ad_id . '" />
								 <input type="hidden" name="name" value="' . $profile->user_info->display_name . '" />
								 <input type="hidden" name="email" value="' . $profile->user_info->user_email . '" />
								 ' . $level_2 . '
                                    <input name="message" id="sb_forest_message" placeholder="' . esc_html__('Type a message here...', 'carspot') . '" class="form-control message-text" autocomplete="off" type="text" data-parsley-required="true" data-parsley-error-message="' . esc_html__('This field is required.', 'carspot') . '">
									<input type="hidden" id="message_nonce" value="' . wp_create_nonce('carspot_message_secure') . '"  />
                                 </div>
                                 ' . $send_msg_btn . '
                              </form>';
                }
                $turn++;
            }
            if ($users == '') {
                $users = '<li class="padding-top-30 padding-bottom-20"><div class="user-name">' . esc_html__('Nothing Found.', 'carspot') . '</div></li>';
            }


            return $script . '<div>
                   <div class="message-body">
				   	<div class="row">
                     <div class="col-md-4 col-sm-5 col-xs-12">
                        <div class="message-inbox">
                           <div class="message-header">
							  <span ><a class="messages_actions" sb_action="received_msgs_ads_list" id="receive_messages">' . esc_html__('Recevied Offers', 'carspot') . '</a></span>
                              <span><a class="messages_actions active" sb_action="my_msgs">' . esc_html__('Sent Offers', 'carspot') . '</a></span>
							  <h4>' . esc_html__('Ads', 'carspot') . '</h4>
                           </div>
							<ul class="message-history">
								' . $users . '
							</ul>
                        </div>
                     </div>
                     <div class="col-md-8 clearfix col-sm-7 col-xs-12 message-content">
					 	' . $title_html . '
                        <div class="message-details">
                           <ul class="messages" id="messages">
                              ' . $messages . '
                           </ul>
                           <div class="chat-form ">
                              ' . $form . '
                           </div>
                        </div>
                     </div>
                  </div>
				  </div>
               </div>';
        }

        function carspot_search_layout_grid_1($pid = '', $col = '', $sm = 6, $holder = '')
        {
            if ($col != '') {
                $col = $col;
            } else {
                $col = 4;
            }
            $my_ads = '';
            $number = 0;
            global $carspot_theme;
            $cats_html = carspot_display_cats($pid);
            $features_html = '';
            if (isset($carspot_theme['listing_features_grids']) && $carspot_theme['listing_features_grids'] == "car") {
                $features_html = carspot_display_key_features($pid, '5');
            } else {
                $features_html .= '<div class="margin-top-10"></div>';
            }
            $flip_it = '';
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $flip_it = 'flip';
                $ribbion = 'featured-ribbon-rtl';
            }

            $ad_price = '';
            if (carspot_adPrice(get_the_ID()) != "") {
                $ad_price .= '<div class="price-tag">
				  <div class="price"><span>' . carspot_adPrice(get_the_ID()) . '</span></div>
				</div>';
            }

            $outer_html = '';
            $media = carspot_fetch_listing_gallery($pid);

            $dynamic_thumb_size = '';
            if (is_page_template('page-search.php')) {
                $dynamic_thumb_size = 'carspot-grid_small';
            } else {
                $dynamic_thumb_size = 'carspot-category';
            }

            if (count((array)$media) > 0) {
                $counting = 1;
                foreach ($media as $m) {
                    if ($counting > 1) {
                        break;
                    }

                    $mid = '';
                    if (isset($m->ID)) {
                        $mid = $m->ID;
                    } else {
                        $mid = $m;
                    }

                    $image = wp_get_attachment_image_src($mid, 'carspot-ad-related', false);
                    if (wp_attachment_is_image($mid)) {
                        $outer_html = '<div class="image">
					' . carspot_video_icon() . '
					<a href="' . get_the_permalink() . '"><img src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '" class="img-responsive"></a> 
					' . $ad_price . '
					</div>';
                    } else {
                        $outer_html = '<div class="image">
					' . carspot_video_icon() . '
					<a href="' . get_the_permalink() . '"><img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive"></a> 
					' . $ad_price . '
					</div>';
                    }
                    $counting++;
                }
            } else {
                $outer_html = '<div class="image">
			' . carspot_video_icon() . '
					<a href="' . get_the_permalink() . '"><img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive"></a>
					' . $ad_price . '
					</div>';
            }
            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_carspot_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '"><span>' . esc_html__('Featured', 'carspot') . '</span></div>';
            }
            $limit_value = '';
            $grid_title = '';
            if (isset($carspot_theme['ad_title_limt']) && $carspot_theme['ad_title_limt'] == "1") {

                $limit_value = $carspot_theme['grid_title_limit'];
                $grid_title = carspot_words_count(get_the_title(), $limit_value);
            } else {
                $grid_title = get_the_title($pid);
            }

            $custom_locz = '';
            if (carspot_display_adLocation($pid) != "") {
                $custom_locz = '<p class="location"><i class="fa fa-map-marker"></i>' . carspot_display_adLocation($pid) . '</p>';
            }

            return $my_ads = '<div class="col-md-' . esc_attr($col) . '  col-lg-' . esc_attr($col) . ' col-sm-' . esc_attr($sm) . ' col-xs-12" id="' . $holder . '.holder-' . get_the_ID() . '">
                                 <div class="category-grid-box-1">
								 ' . $is_feature . '
                                 ' . $outer_html . '
                                    <div class="short-description-1 clearfix">
                                       <div class="category-title"> ' . $cats_html . ' </div>
                                       <h3> <a href="' . get_correct_link_by_postID($pid) . '">' . $grid_title . '</a></h3>
                                       ' . $custom_locz . '
                                       ' . $features_html . '
                                    </div>
                                    <div class="ad-info-1">
                                       <p><i class="flaticon-calendar"></i> &nbsp;<span>' . get_the_date(get_option('date_format'), $pid) . '</span> </p>
                                       <ul class="pull-right ' . esc_attr($flip_it) . '">
                                          <li> <a data-toggle="tooltip" data-placement="top" data-original-title="' . esc_html__('Save Ad', 'carspot') . '" href="javascript:void(0);" class="save-ad" data-adid="' . get_the_ID() . '"><i class="flaticon-like-1"></i></a><input type="hidden" id="fav_ad_nonce" value="' . wp_create_nonce('carspot_fav_ad_secure') . '"  /> </li>
                                          <li> <a href="' . get_the_permalink() . '"><i class="flaticon-message"></i></a></li>
                                       </ul>
                                    </div>
                                 </div>
                                 <!-- Listing Ad Grid -->
                              </div>';
        }

        function carspot_search_layout_grid_2($pid = '', $col = '', $sm = 6, $holder = '')
        {
            if ($col != '') {
                $col = $col;
            } else {
                $col = 4;
            }
            $my_ads = '';
            $number = 0;
            global $carspot_theme;
            $cats_html = carspot_display_cats($pid);

            $features_html = '';
            if (isset($carspot_theme['listing_features_grids']) && $carspot_theme['listing_features_grids'] == "car") {
                $features_html = carspot_display_key_features($pid, '3');
            } else {
                $features_html .= '<ul>
							<li> <i class="fa fa-eye"></i><a href="javascript:void(0);">' . carspot_getPostViews($pid) . ' ' . __('Views', 'carspot') . '</a> </li>
							<li> <i class="fa fa-clock-o"></i>' . get_the_date(get_option('date_format'), $pid) . '</li>
						</ul>';
            }
            $img = '';
            $media = carspot_fetch_listing_gallery($pid);

            $dynamic_thumb_size = '';
            if (is_page_template('page-search.php')) {
                $dynamic_thumb_size = 'carspot-grid_small';
            } else {
                $dynamic_thumb_size = 'carspot-category';
            }


            if (count((array)$media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID)) {
                        $mid = $m->ID;
                    } else {
                        $mid = $m;
                    }
                    $image = wp_get_attachment_image_src($mid, 'carspot-ad-related', false);
                    if (wp_attachment_is_image($mid)) {
                        $img = '<img src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '" class="img-responsive">';
                    } else {
                        $img = '<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">';
                    }
                    break;
                }
            } else {
                $img = '<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_carspot_is_feature', true) == '1') {
                $is_feature = '<span class="ad-status">' . esc_html__('Featured', 'carspot') . '</span>';
            }

            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);;

            $condition_html = '';
            if (isset($carspot_theme['allow_tax_condition']) && $carspot_theme['allow_tax_condition'] && get_post_meta(get_the_ID(), '_carspot_ad_condition', true) != "") {
                $condition_html = '<p>' . esc_html__('Condition', 'carspot') . ": " . get_post_meta(get_the_ID(), '_carspot_ad_condition', true) . '</p>';
            }

            $ad_type_html = '';
            if (get_post_meta(get_the_ID(), '_carspot_ad_type', true) != "") {
                $ad_type_html = '<p>' . esc_html__('Ad Type', 'carspot') . ": " . get_post_meta(get_the_ID(), '_carspot_ad_type', true) . '</p>';
            }
            $transmission = '';
            if (get_post_meta($pid, '_carspot_ad_transmissions', true) != "") {
                $transmission = '<p>' . esc_html__('Transmission', 'carspot') . ": " . get_post_meta(get_the_ID(), '_carspot_ad_transmissions', true) . '</p>';
            }
            $body_type = '';
            if (get_post_meta($pid, '_carspot_ad_body_types', true) != "") {
                $body_type = '<p>' . esc_html__('Body Type', 'carspot') . ": " . get_post_meta(get_the_ID(), '_carspot_ad_body_types', true) . '</p>';
            }
            $color = '';
            if (get_post_meta($pid, '_carspot_ad_colors', true) != "") {
                $color = '<p>' . esc_html__('Color', 'carspot') . ": " . get_post_meta(get_the_ID(), '_carspot_ad_colors', true) . '</p>';
            }
            $limit_value = '';
            $grid_title = '';
            if (isset($carspot_theme['ad_title_limt']) && $carspot_theme['ad_title_limt'] == "1") {
                $limit_value = $carspot_theme['grid_title_limit'];
                $grid_title = carspot_words_count(get_the_title(), $limit_value);
            } else {
                $grid_title = get_the_title();
            }

            $ad_price = '';
            if (carspot_adPrice(get_the_ID()) != "") {
                $ad_price .= '<div class="price">' . carspot_adPrice(get_the_ID()) . '</div>';
            }

            return '<div class="col-md-' . esc_attr($col) . ' col-xs-12 col-sm-' . esc_attr($sm) . '">
				  <!-- Ad Box -->
				  <div class="category-grid-box">
					 <!-- Ad Img -->
					 <div class="category-grid-img">
					 ' . carspot_video_icon() . '
						' . $img . '
						<!-- Ad Status -->
						' . $is_feature . '
						<!-- User Review -->
						<div class="user-preview">
						   <a href="' . esc_url(get_author_posts_url($author_id)) . '?type=ads">
						   <img src="' . esc_url(carspot_get_user_dp($author_id)) . '" class="avatar avatar-small" alt="' . get_the_title() . '">
						   </a>
						</div>
						<!-- View Details -->
						<a href="' . get_the_permalink() . '" class="view-details">
						' . esc_html__('View Details', 'carspot') . '
						</a>
						<!-- Additional Info -->
						<div class="additional-information">
						' . $transmission . '
						' . $body_type . '
						 ' . $condition_html . '
						   <p>' . esc_html__('Posted on', 'carspot') . ": " . get_the_date(get_option('date_format'), get_the_ID()) . '</p>
						</div>
						<!-- Additional Info End-->
					 </div>
					 <!-- Ad Img End -->
					 <div class="short-description">
							<!-- Category Title -->
								<div class="category-title"> ' . $cats_html . ' </div>
								<h3><a href="' . get_correct_link_by_postID($pid) . '">' . $grid_title . '</a></h3>
						' . $ad_price . '
					 </div>
					 <!-- Addition Info -->
					<div class="ad-info">
						 ' . $features_html . '
					 </div>
				  </div>
				  <!-- Ad Box End -->
			   </div>';
        }

        function carspot_search_layout_grid_3($pid = '', $col = '', $sm = 6, $holder = '')
        {
            if ($col != '') {
                $col = $col;
            } else {
                $col = 4;
            }
            $my_ads = '';
            $number = 0;
            global $carspot_theme;
            $cats_html = carspot_display_cats($pid);
            $features_html = '';
            if (isset($carspot_theme['listing_features_grids']) && $carspot_theme['listing_features_grids'] == "car") {
                $features_html = carspot_display_key_features($pid, '3');
            } else {
                $features_html .= '<div class="margin-top-10"></div>';
            }

            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $ribbion = 'featured-ribbon-rtl';
            }

            $ad_price = '';
            if (carspot_adPrice(get_the_ID()) != "") {
                $ad_price .= '<div class="price-tag">
				  <div class="price"><span>' . carspot_adPrice(get_the_ID()) . '</span></div>
				</div>';
            }
            $img = '';
            $media = carspot_fetch_listing_gallery($pid);

            $dynamic_thumb_size = '';
            if (is_page_template('page-search.php')) {
                $dynamic_thumb_size = 'carspot-grid_small';
            } else {
                $dynamic_thumb_size = 'carspot-category';
            }


            if (count((array)$media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID)) {
                        $mid = $m->ID;
                    } else {
                        $mid = $m;
                    }
                    $image = wp_get_attachment_image_src($mid, 'carspot-ad-related', false);
                    if (wp_attachment_is_image($mid)) {
                        $img = '<img src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '" class="img-responsive">';
                    } else {
                        $img = '<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">';
                    }
                    break;
                }
            } else {
                $img = '<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">';
            }

            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_carspot_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '"><span>' . esc_html__('Featured', 'carspot') . '</span></div>';
            }

            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);;
            $limit_value = '';
            $grid_title = '';
            if (isset($carspot_theme['ad_title_limt']) && $carspot_theme['ad_title_limt'] == "1") {
                $limit_value = $carspot_theme['grid_title_limit'];
                $grid_title = carspot_words_count(get_the_title(), $limit_value);
            } else {
                $grid_title = get_the_title();
            }

            $custom_locz = '';
            if (carspot_display_adLocation($pid) != "") {
                $custom_locz = '<p class="location"><i class="fa fa-map-marker"></i>' . carspot_display_adLocation($pid) . '</p>';
            }

            return '<div class="col-md-' . esc_attr($col) . ' col-sm-' . esc_attr($sm) . ' col-xs-12 simple">
                              <div class="category-grid-box-1">
                                 <div class="image">
								 ' . carspot_video_icon() . '
                                    <a href="' . get_the_permalink() . '">' . $img . '</a>
									' . $is_feature . '
									' . $ad_price . '
                                 </div>
                                 <div class="short-description-1 clearfix">
                                    <h3><a href="' . get_correct_link_by_postID($pid) . '">' . $grid_title . '</a></h3>
									 ' . $custom_locz . '
									' . $features_html . '
                                 </div>
                                 <div class="ad-info-1">
                                    <ul>
                                        <li> <i class="fa fa-eye"></i><a href="javascript:void(0);">' . carspot_getPostViews(get_the_ID()) . ' ' . esc_html__('Views', 'carspot') . '</a> </li>
								   <li> <i class="fa fa-clock-o"></i>' . get_the_date(get_option('date_format'), get_the_ID()) . '</li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
		';
        }

        function carspot_search_layout_grid_4($pid = '', $col = '', $sm = 6, $holder = '')
        {
            if ($col != '') {
                $col = $col;
            } else {
                $col = 4;
            }
            $my_ads = '';
            $number = 0;
            global $carspot_theme;
            $cats_html = carspot_display_cats($pid);
            $features_html = '';
            if (isset($carspot_theme['listing_features_grids']) && $carspot_theme['listing_features_grids'] == "car") {

                $features_html = carspot_display_key_features($pid, '3');
            } else {
                $features_html .= '<ul>
							<li> <i class="fa fa-eye"></i><a href="javascript:void(0);">' . carspot_getPostViews($pid) . ' ' . __('Views', 'carspot') . '</a> </li>
							<li> <i class="fa fa-clock-o"></i>' . get_the_date(get_option('date_format'), $pid) . '</li>
						</ul>';
            }


            $flip_it = '';
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $flip_it = 'flip';
                $ribbion = 'featured-ribbon-rtl';
            }

            $outer_html = '';
            $media = carspot_fetch_listing_gallery($pid);
            $dynamic_thumb_size = '';
            if (is_page_template('page-search.php')) {
                $dynamic_thumb_size = 'carspot-grid_small';
            } else {
                $dynamic_thumb_size = 'carspot-category';
            }

            if (count((array)$media) > 0) {
                $counting = 1;
                foreach ($media as $m) {
                    if ($counting > 1) {
                        break;
                    }
                    $mid = '';
                    if (isset($m->ID)) {
                        $mid = $m->ID;
                    } else {
                        $mid = $m;
                    }
                    if (wp_attachment_is_image($mid)) {
                        $image = wp_get_attachment_image_src($mid, 'carspot-ad-related', false);
                        $outer_html = '<div class="image">
					 ' . carspot_video_icon() . '
					<a href="' . get_the_permalink() . '"><img src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '" class="img-responsive"></a> 
					</div>';
                    } else {
                        $outer_html = '<div class="image">
					 ' . carspot_video_icon() . '
					<a href="' . get_the_permalink() . '"><img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive"></a> 
					</div>';
                    }
                    $counting++;
                }
            } else {
                $outer_html = '<div class="image">
			 ' . carspot_video_icon() . '
					<a href="' . get_the_permalink() . '">
						<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">
					</a>
					</div>';
            }
            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_carspot_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '"><span>' . esc_html__('Featured', 'carspot') . '</span></div>';
            }
            $limit_value = '';
            $grid_title = '';
            if (isset($carspot_theme['ad_title_limt']) && $carspot_theme['ad_title_limt'] == "1") {
                $limit_value = $carspot_theme['grid_title_limit'];
                $grid_title = carspot_words_count(get_the_title(), $limit_value);
            } else {
                $grid_title = get_the_title();
            }

            $custom_locz = '';
            if (carspot_display_adLocation($pid) != "") {
                $custom_locz = '<p class="location"><i class="fa fa-map-marker"></i> ' . carspot_display_adLocation($pid) . '</p>';
            }

            return $my_ads = '<div class="col-md-' . esc_attr($col) . '  col-lg-' . esc_attr($col) . ' col-sm-' . esc_attr($sm) . ' col-xs-12" id="' . $holder . '.holder-' . get_the_ID() . '">
					  <div class="white category-grid-box-1 ">
						 <!-- Image Box -->
						 ' . $is_feature . '
						 ' . $outer_html . '
						 <!-- Short Description -->
						 <div class="short-description-1 ">
							<!-- Category Title -->
							<div class="category-title"> ' . $cats_html . ' </div>
							<!-- Ad Title -->
							<h3><a href="' . get_correct_link_by_postID($pid) . '">' . $grid_title . '</a></h3>
							<!-- Location -->
							' . $custom_locz . '
							 <span class="ad-price">' . carspot_adPrice(get_the_ID()) . '</span> 
						 </div>
						 <!-- Ad Meta Stats -->
						 <div class="ad-info-1">
							' . $features_html . '
						 </div>
					  </div>
				   </div>';
        }

        function carspot_search_layout_grid_5($pid = '', $col = '', $sm = 6, $holder = '')
        {
            if ($col != '') {
                $col = $col;
            } else {
                $col = 4;
            }
            $my_ads = '';
            $number = 0;
            global $carspot_theme;
            $cats_html = carspot_display_cats($pid);
            $features_html = '';
            if (isset($carspot_theme['listing_features_grids']) && $carspot_theme['listing_features_grids'] == "car") {
                $features_html = carspot_display_key_features($pid, '3');
            } else {
                $features_html .= '<ul>
							<li> <i class="fa fa-eye"></i><a href="javascript:void(0);">' . carspot_getPostViews($pid) . ' ' . __('Views', 'carspot') . '</a> </li>
							<li> <i class="fa fa-clock-o"></i>' . get_the_date(get_option('date_format'), $pid) . '</li>
						</ul>';
            }

            $flip_it = '';
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $flip_it = 'flip';
                $ribbion = 'featured-ribbon-rtl';
            }


            $outer_html = '';
            $media = carspot_fetch_listing_gallery($pid);
            $dynamic_thumb_size = '';
            if (is_page_template('page-search.php')) {
                $dynamic_thumb_size = 'carspot-grid_small';
            } else {
                $dynamic_thumb_size = 'carspot-category';
            }

            if (count((array)$media) > 0) {
                $counting = 1;
                foreach ($media as $m) {
                    if ($counting > 1) {
                        break;
                    }

                    $mid = '';
                    if (isset($m->ID)) {
                        $mid = $m->ID;
                    } else {
                        $mid = $m;
                    }

                    $image = wp_get_attachment_image_src($mid, 'carspot-reviews-thumb', false);
                    if (wp_attachment_is_image($mid)) {
                        $outer_html = '<div class="image">
					' . carspot_video_icon() . '
					<a href="' . get_the_permalink() . '"><img src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '" class="img-responsive"></a> 
					</div>';
                    } else {
                        $outer_html = '<div class="image">
					' . carspot_video_icon() . '
					<a href="' . get_the_permalink() . '"><img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive"></a> 
					</div>';
                    }
                    $counting++;
                }
            } else {
                $outer_html = '<div class="image">
			' . carspot_video_icon() . '
					<a href="' . get_the_permalink() . '"><img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive"></a>
					</div>';
            }
            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_carspot_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '"><span>' . esc_html__('Featured', 'carspot') . '</span></div>';
            }
            $limit_value = '';
            $grid_title = '';
            if (isset($carspot_theme['ad_title_limt']) && $carspot_theme['ad_title_limt'] == "1") {
                $limit_value = $carspot_theme['grid_title_limit'];
                $grid_title = carspot_words_count(get_the_title(), $limit_value);
            } else {
                $grid_title = get_the_title();
            }

            $custom_locz = '';
            if (carspot_display_adLocation($pid) != "") {
                $custom_locz = '<p class="location"><i class="fa fa-map-marker"></i> ' . carspot_display_adLocation($pid) . '</p>';
            }


            return $my_ads = '<div class="col-md-' . esc_attr($col) . '  col-lg-' . esc_attr($col) . ' col-sm-' . esc_attr($sm) . ' col-xs-12" id="' . $holder . '.holder-' . get_the_ID() . '">
					  <div class="white category-grid-box-1 ">
						 <!-- Image Box -->
						 ' . $is_feature . '
						 ' . $outer_html . '
						 <!-- Ad Meta Stats -->
						 <div class="ad-info-1">
							' . $features_html . '
						 </div>
						 <!-- Short Description -->
						 <div class="short-description-1 ">
							<!-- Ad Title -->
							<h3><a href="' . get_correct_link_by_postID($pid) . '">' . $grid_title . '</a></h3>
							<!-- Location -->
							' . $custom_locz . '
							<hr>
							 <span class="ad-price">' . carspot_adPrice(get_the_ID()) . '</span> 
							  <a href="' . get_the_permalink() . '" class="pull-right ' . esc_attr($flip_it) . '"> ' . esc_html__('View Details', 'carspot') . ' </a>
						 </div>
						 
					  </div>
				   </div>';
        }

        function carspot_search_layout_grid_6($pid = '', $col = '', $sm = 6, $holder = '')
        {
            if ($col != '') {
                $col = $col;
            } else {
                $col = 4;
            }
            $my_ads = '';
            $number = 0;
            global $carspot_theme;
            $cats_html = carspot_display_cats($pid);
            $features_html = '';
            if (isset($carspot_theme['listing_features_grids']) && $carspot_theme['listing_features_grids'] == "car") {
                $features_html = carspot_display_key_features($pid, '5');
            } else {
                $features_html .= '<div class="margin-top-10"></div>';
            }

            $flip_it = '';
            $ribbion = 'featured-ribbon';
            if (is_rtl()) {
                $flip_it = 'flip';
                $ribbion = 'featured-ribbon-rtl';
            }

            $ad_price = '';
            if (carspot_adPrice(get_the_ID()) != "") {
                $ad_price .= '<div class="price-tag">
				  <div class="price"><span>' . carspot_adPrice(get_the_ID()) . '</span></div>
				</div>';
            }

            $outer_html = '';
            $media = carspot_fetch_listing_gallery($pid);

            $dynamic_thumb_size = '';
            if (is_page_template('page-search.php')) {
                $dynamic_thumb_size = 'carspot-grid_small';
            } else {
                $dynamic_thumb_size = 'carspot-category';
            }


            if (count((array)$media) > 0) {
                $counting = 1;
                foreach ($media as $m) {
                    if ($counting > 1) {
                        break;
                    }

                    $mid = '';
                    if (isset($m->ID)) {
                        $mid = $m->ID;
                    } else {
                        $mid = $m;
                    }

                    $image = wp_get_attachment_image_src($mid, 'carspot-reviews-thumb', false);
                    if (wp_attachment_is_image($mid)) {
                        $outer_html = '<div class="image">
					' . carspot_video_icon() . '
					<a href="' . get_the_permalink() . '"><img src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '" class="img-responsive"></a> 
					' . $ad_price . '
					</div>';
                    } else {
                        $outer_html = '<div class="image">
					' . carspot_video_icon() . '
					<a href="' . get_the_permalink() . '"><img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive"></a> 
					' . $ad_price . '
					</div>';
                    }
                    $counting++;
                }
            } else {
                $outer_html = '<div class="image">
			' . carspot_video_icon() . '
					<a href="' . get_the_permalink() . '"><img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive"></a>
					' . $ad_price . '
					</div>';
            }
            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_carspot_is_feature', true) == '1') {
                $is_feature = '<div class="' . esc_attr($ribbion) . '"><span>' . esc_html__('Featured', 'carspot') . '</span></div>';
            }
            $limit_value = '';
            $grid_title = '';
            if (isset($carspot_theme['ad_title_limt']) && $carspot_theme['ad_title_limt'] == "1") {

                $limit_value = $carspot_theme['grid_title_limit'];
                $grid_title = carspot_words_count(get_the_title(), $limit_value);
            } else {
                $grid_title = get_the_title();
            }

            $custom_locz = '';
            if (carspot_display_adLocation($pid) != "") {
                $custom_locz = '<p class="location"><i class="fa fa-map-marker"></i>' . carspot_display_adLocation($pid) . '</p>';
            }

            return $my_ads = '<div class="col-md-4 col-xs-12 col-sm-6">
                               <div class="category-grid-box-1">
                               	<div class="title-area">
                                 <div class="category-title"> ' . $cats_html . '</div>
                                 <h3><a href="' . get_correct_link_by_postID($pid) . '">' . esc_attr($grid_title) . '</a></h3>
                                 ' . $custom_locz . '
                                 </div>
                                  <div class="image">
                                     ' . $is_feature . '
                                     ' . $outer_html . '
                                  </div>
								  
                                  <div class="short-description-1 clearfix">
								  		' . $features_html . '
                                  </div>
                                  <div class="ad-info-1">
                                       <p><i class="flaticon-calendar"></i> &nbsp;<span>' . get_the_date(get_option('date_format'), get_the_ID()) . '</span> </p>
                                       <ul class="pull-right ' . esc_attr($flip_it) . '">
                                          <li> <a data-toggle="tooltip" data-placement="top" data-original-title="' . esc_html__('Saved Ad', 'carspot') . '" href="javascript:void(0);" class="save-ad" data-adid="' . get_the_ID() . '"><i class="flaticon-like-1"></i></a><input type="hidden" id="fav_ad_nonce" value="' . wp_create_nonce('carspot_fav_ad_secure') . '"  /> </li>
                                          <li> <a href="' . get_the_permalink() . '"><i class="flaticon-message"></i></a></li>
                                       </ul>
                                    </div>
                               </div>
                               <!-- Listing Ad Grid -->
                            </div>';
        }

        function carspot_search_layout_grid_7($pid = '', $col = '', $sm = 6, $holder = '')
        {
            global $carspot_theme;
            /* ======================
             * Ads image only one
             * ===================== */
            $outer_html = '';
            $media = carspot_fetch_listing_gallery($pid);
            if (count((array)$media) > 0) {
                $counting = 1;
                foreach ($media as $m) {
                    if ($counting > 1) {
                        break;
                    }
                    $mid = '';
                    if (isset($m->ID)) {
                        $mid = $m->ID;
                    } else {
                        $mid = $m;
                    }
                    //carspot_video_icon()
                    $image = wp_get_attachment_image_src($mid, 'carspot-reviews-thumb', false);
                    if (wp_attachment_is_image($mid)) {
                        $outer_html = '<img src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '" class="img-responsive">';
                    } else {
                        $outer_html = '<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">';
                    }
                    $counting++;
                }
            } else {
                $outer_html = '<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">';
            }

            /* ======================
             * Ads is featured or not
             * ===================== */
            $is_feature = '';
            if (get_post_meta($pid, '_carspot_is_feature', true) == '1') {
                $is_feature = '<span></span><span class="iconify" data-icon="ant-design:star-filled"></span>';
            }

            /* ====================
             * Ads title with limit
             * =================== */
            if (isset($carspot_theme['ad_title_limt']) && $carspot_theme['ad_title_limt'] == "1") {
                $limit_value = $carspot_theme['grid_title_limit'];
                $grid_title = carspot_words_count(get_the_title(), $limit_value);
            } else {
                $grid_title = get_the_title();
            }

            /* =======================
             * Ad Author Image Getting
             * ======================= */
            /* author ID */
            $author_id = get_post_field('post_author', $pid);
            /* user picture */
            $user_pic = carspot_get_dealer_logo($author_id);

            return $my_ads = '<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-3 toggle-list-items">
                                                <div class="ftd-card">
                                                    <div class="card-img">
                                                        ' . $outer_html . '
                                                         ' . $is_feature . '
                                                    </div>
                                                    <div class="card-meta">
                                                        <h6>' . carspot_adPrice($pid) . '</h6>
                                                        <a href=" ' . get_the_permalink() . '">
                                                            <h4> ' . $grid_title . '</h4></a>
                                                        <div class="location">
                                                            <p><span class="iconify"
                                                                     data-icon="entypo:location-pin"></span>
                                                                 ' . carspot_display_adLocation($pid) . '</p>
                                                        </div>
                                                        <a href="javascript:void(0)">
                                                            <img class="prf-back"
                                                                 src=" ' . get_template_directory_uri() . '/images/layer-102.png' . '"
                                                                 alt="">
                                                            <img class="prf" src=" ' . esc_url($user_pic) . '"
                                                                 alt=" ' . __(" Profile", "carspot") . '">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>';
        }


        function carspot_search_layout_list($pid = '', $col = 12)
        {
            global $carspot_theme;
            $features_html = '';
            $my_class = '';
            $cats_html = '';
            $show_cats = '';
            if (isset($carspot_theme['listing_features_grids']) && $carspot_theme['listing_features_grids'] == "car") {
                $my_class = '';
                $features_html = carspot_display_key_features($pid, '5');
            } else {
                $cats_html = carspot_display_cats($pid);
                $show_cats = '<div class="category-title"> ' . $cats_html . ' </div>';
                $my_class = 'classified-select';
            }
            $author_id = get_post_field('post_author', $pid);
            $condition_html = '';
            if (isset($carspot_theme['allow_tax_condition']) && $carspot_theme['allow_tax_condition'] && get_post_meta($pid, '_carspot_ad_condition', true) != "") {
                $condition_html = '<div class="ad-stats hidden-xs">
		<span>' . esc_html__('Condition', 'carspot') . '  : </span>
		' . get_post_meta($pid, '_carspot_ad_condition', true) . '
		</div>';
            }
            $ad_type_html = '';
            if (get_post_meta($pid, '_carspot_ad_type', true) != "") {
                $ad_type_html = '<div class="ad-stats hidden-xs">
	<span>' . esc_html__('Ad Type', 'carspot') . '  : </span>
	' . get_post_meta($pid, '_carspot_ad_type', true) . '
	</div>';
            }

            $price = '<div class="price">
	<span>
	' . carspot_adPrice(get_the_ID()) . '
	</span> 
	</div>';
            $is_feature = '';
            if (get_post_meta(get_the_ID(), '_carspot_is_feature', true) == '1') {
                $is_feature = '<span class="ad-status">' . esc_html__('Featured', 'carspot') . '</span>';
            }
            $output = '<li>
				<div class="well ad-listing clearfix ' . esc_attr($my_class) . '">
				<div class="col-md-3 col-sm-5 col-xs-12 grid-style no-padding">';
            $img = $carspot_theme['default_related_image']['url'];
            $media = carspot_fetch_listing_gallery($pid);
            $total_imgs = count($media);
            if (count((array)$media) > 0) {
                $counting = 1;
                foreach ($media as $m) {
                    if ($counting > 1) {
                        break;
                    }
                    $mid = '';
                    if (isset($m->ID)) {
                        $mid = $m->ID;
                    } else {
                        $mid = $m;
                    }
                    $image = wp_get_attachment_image_src($mid, 'carspot-ad-related');
                    if (wp_attachment_is_image($mid)) {
                        $img = $image[0];
                    } else {
                        $img = esc_url($carspot_theme['default_related_image']['url']);
                    }
                    $counting++;
                }
            }


            $custom_locz = '';
            if (carspot_display_adLocation($pid) != "") {
                $custom_locz = '<li> <i class="fa fa-map-marker"></i>' . carspot_display_adLocation($pid) . ' </li>';
            }

            $output .= '<div class="img-box 222">
	' . carspot_video_icon() . '
	<img src="' . esc_url($img) . '" class="img-responsive" alt="' . get_the_title() . '">
	<div class="total-images">
	<strong>' . esc_html($total_imgs) . '</strong>
	' . esc_html__('photos', 'carspot') . '
	</div>
	<div class="quick-view">
	<a href="' . get_the_permalink() . '" class="view-button"><i class="fa fa-search"></i></a>
	</div>
	</div>
	';
            $color = carspot_ads_status_color(get_post_meta($pid, '_carspot_ad_status_', true));
            $output .= '
	' . $is_feature . '
	<div class="user-preview">
	<a href="javascript:void(0);">
	<img src="' . carspot_get_user_dp($author_id) . '" class="avatar avatar-small" alt="' . get_the_title() . '">
	</a>
	</div>
	</div>
	<div class="col-md-9 col-sm-7 col-xs-12">
	<!-- Ad Content-->
	<div class="row">
	<div class="content-area">
	<div class="col-md-9 col-sm-12 col-xs-12">
	' . $show_cats . '
	<h3>
	<a href="' . get_correct_link_by_postID($pid) . '">
	' . get_the_title() . '
	</a>
	</h3>
	<ul class="ad-meta-info">
	   ' . $custom_locz . '
	   <li> <i class="fa fa-clock-o"></i> ' . get_the_date(get_option('date_format'), get_the_ID()) . '</li>
	</ul>
	<div class="ad-details">
	<p>' . carspot_words_count(get_the_excerpt(), 115) . '</p>
	' . $features_html . '
	</div>
	</div>
	<div class="col-md-3 col-xs-12 col-sm-12">
	<!-- Ad Stats -->
	<div class="short-info">
	' . $ad_type_html . '
	' . $condition_html . '
	<div class="ad-stats hidden-xs">
	<span>' . esc_html__('Visits', 'carspot') . '  : </span>
	' . carspot_getPostViews($pid) . '
	</div>
	</div>
	<!-- Price -->
	' . $price . '
	<!-- Ad View Button -->
	<a href="' . get_the_permalink() . '" class="btn btn-block btn-theme">
	<i class="fa fa-eye" aria-hidden="true"></i>
	' . esc_html__('View Ad', 'carspot') . '
	</a>
	</div>
	</div>
	</div>
	<!-- Ad Content End -->
	</div>
	</div>
	</li>
	';

            return $output;
        }

        function carspot_search_layout_list_1($pid = '')
        {
            $my_ads = '';
            $number = 0;
            global $carspot_theme;
            $cats_html = carspot_display_cats($pid);
            $price = ' <div class="ad-price">' . carspot_adPrice(get_the_ID()) . '</div>';
            $img = '';
            $media = carspot_fetch_listing_gallery($pid);
            if (count((array)$media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID)) {
                        $mid = $m->ID;
                    } else {
                        $mid = $m;
                    }
                    $image = wp_get_attachment_image_src($mid, 'carspot-reviews-thumb', false);
                    $imgthumb = wp_get_attachment_image_src($mid, 'carspot-listing-small');
                    if (wp_attachment_is_image($mid)) {
                        $img = '<img src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '" class="img-responsive">';
                    } else {
                        $img = '<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">';
                    }
                    break;
                }
            } else {
                $img = '<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">';
            }
            //for thumbs
            $related_img = '';
            if (count((array)$media) > 0) {
                foreach ($media as $thumb) {
                    $midz = '';
                    if (isset($thumb->ID)) {
                        $midz = $thumb->ID;
                    } else {
                        $midz = $thumb;
                    }
                    $imgthumb = wp_get_attachment_image_src($midz, 'carspot-listing-small');
                    if (wp_attachment_is_image($mid)) {
                        $related_img .= '<li><a href="' . get_the_permalink() . '"><img  src="' . esc_attr($imgthumb[0]) . '" alt="' . get_the_title() . '"></a></li>';
                    } else {
                        $related_img .= '<li><a href="' . get_the_permalink() . '"><img  src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '"></a></li>';
                    }
                }
            }

            $is_feature = '';
            $feature_color = '';
            if (get_post_meta(get_the_ID(), '_carspot_is_feature', true) == '1') {
                $feature_color = 'featured_ads';
                $is_feature = '<div class="featured-ribbon"><span>' . esc_html__('Featured', 'carspot') . '</span></div>';
            }

            $pid = get_the_ID();

            return '<div class="ads-list-archive ' . esc_attr($feature_color) . '">
		  <!-- Image Block -->
		  <div class="col-lg-4 col-md-4 col-sm-4 no-padding">
			 <!-- Img Block -->
			 <div class="ad-archive-img">
			 ' . carspot_video_icon() . '
				<a href="' . get_the_permalink() . '">
					' . $img . '
				</a>
				' . $is_feature . '
			 </div>
			 <!-- Img Block -->
		  </div>
		  <!-- Ads Listing -->
		  <div class="clearfix visible-xs-block"></div>
		  <!-- Content Block -->
		  <div class="col-lg-8 col-md-8 col-sm-8 no-padding">
			 <!-- Ad Desc -->
			 <div class="ad-archive-desc">
				<!-- Price -->
				' . $price . '
				<!-- Title -->
				<h3><a href="' . get_correct_link_by_postID($pid) . '">' . get_the_title() . '</a></h3>
				<!-- Category -->
				<div class="category-title"> ' . $cats_html . ' </div>
				<!-- Short Description -->
				<div class="clearfix visible-xs-block"></div>
				<p class="hidden-sm">' . carspot_words_count(get_the_excerpt(), 110) . '</p>
				<!-- Ad Features -->
				<ul class="add_info">
				  ' . $related_img . '
				</ul>
				<!-- Ad History -->
				<div class="clearfix archive-history">
				   <div class="last-updated">' . esc_html__('Posted', 'carspot') . ' : ' . get_the_date(get_option('date_format'), get_the_ID()) . '</div>
				   <div class="ad-meta">
						<a  href="javascript:void(0);" data-adid="' . get_the_ID() . '" class="btn save-ad"><i class="fa fa-heart-o"></i> ' . esc_html__('Favourite', 'carspot') . '</a>
						<input type="hidden" id="fav_ad_nonce" value="' . wp_create_nonce('carspot_fav_ad_secure') . '"  />
						<a href="' . get_the_permalink() . '" class="btn btn-success"><i class="fa fa-phone"></i>  ' . esc_html__('View Details', 'carspot') . '</a>
				  </div>

				</div>
			 </div>
			 <!-- Ad Desc End -->
		  </div>
		  <!-- Content Block End -->
		</div>
		';
        }

        function carspot_search_layout_list_2($pid = '')
        {
            $number = 0;
            global $carspot_theme;
            $cats_html = carspot_display_cats($pid);

            $img = '';
            $media = carspot_fetch_listing_gallery($pid);
            if (count((array)$media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID)) {
                        $mid = $m->ID;
                    } else {
                        $mid = $m;
                    }
                    $image = wp_get_attachment_image_src($mid, 'carspot-reviews-thumb', false);
                    if (wp_attachment_is_image($mid)) {
                        $img = '<img src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '" class="img-responsive">';
                    } else {
                        $img = '<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">';
                    }
                    break;
                }
            } else {
                $img = '<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">';
            }

            $is_feature = '';
            $feature_color = '';
            if (get_post_meta(get_the_ID(), '_carspot_is_feature', true) == '1') {
                $feature_color = 'featured_ads';
                $is_feature = '<div class="featured-ribbon">
			  <span>' . esc_html__('Featured', 'carspot') . '</span>
		   </div>';
            }

            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);

            $custom_locz = '';
            if (carspot_display_adLocation($pid) != "") {
                $custom_locz = '<li> ' . carspot_display_adLocation($pid) . ' </li>';
            }

            $car_features = '';
            if (isset($carspot_theme['listing_features_grids']) && $carspot_theme['listing_features_grids'] == "car") {
                if (get_post_meta($pid, '_carspot_ad_engine_types', true) != "") {
                    $car_features .= '<li><a href="javascript:void(0)">' . get_post_meta($pid, '_carspot_ad_engine_types', true) . '</a></li>';
                }

                if (get_post_meta($pid, '_carspot_ad_mileage', true) != "") {
                    $car_features .= '<li><a href="javascript:void(0)">' . get_post_meta($pid, '_carspot_ad_mileage', true) . ' ' . $carspot_theme['sb_distance_unit'] . '</a></li>';
                }

                if (get_post_meta($pid, '_carspot_ad_engine_capacities', true) != "") {
                    $car_features .= '<li><a href="javascript:void(0)">' . carspot_numberFormat_pattern($pid, '_carspot_ad_engine_capacities') . ' ' . $carspot_theme['sb_power_unit'] . '</a></li>';
                }

                if (get_post_meta($pid, '_carspot_ad_colors', true) != "") {
                    $car_features .= '<li><a href="javascript:void(0)">' . get_post_meta($pid, '_carspot_ad_colors', true) . '</a></li>';
                }
            } else {
                $car_features .= '<li> ' . $custom_locz . ' </li><li><a href="javascript:void(0);">' . carspot_getPostViews($pid) . ' ' . __('Views', 'carspot') . '</a> </li>
						<li>' . get_the_date(get_option('date_format'), $pid) . '</li>
						';
            }

            return '<div class="ads-list-archive ' . esc_attr($feature_color) . '">
                                 <!-- Image Block -->
                                 <div class="col-lg-4 col-md-4 col-sm-4 no-padding">
                                    <!-- Img Block -->
									 <div class="ad-archive-img">
									 ' . carspot_video_icon() . '
										<a href="' . get_the_permalink() . '">
											' . $img . '
										</a>
										' . $is_feature . '
									 </div>
                                 </div>
                                 <!-- Ads Listing -->
                                 <div class="clearfix visible-xs-block"></div>
                                 <!-- Content Block -->
                                 <div class="col-lg-8 col-md-8 col-sm-8 no-padding">
                                    <!-- Ad Desc -->
                                    <div class="ad-archive-desc">
                                      
                                       <!-- Title -->
                                       <h3><a href="' . get_correct_link_by_postID($pid) . '">' . get_the_title() . '</a></h3>
                                       <!-- Category -->
                                       <div class="category-title">' . $cats_html . '</div>
                                       <!-- Short Description -->
                                       <div class="clearfix visible-xs-block"></div>
                                       <p class="hidden-sm">' . carspot_words_count(get_the_excerpt(), 110) . '</p>
                                       <!-- Ad Features -->
                                       <ul class="short-meta list-inline">
										' . $car_features . '
                                       </ul>
                                       <!-- Ad History -->
									    <!-- Price -->
                                       <div  class="ad-price-simple">
									   ' . carspot_adPrice(get_the_ID()) . '
									   </div>
                                       <div class="clearfix archive-history">
                                          <div class="last-updated">' . esc_html__('Posted', 'carspot') . ' : ' . get_the_date(get_option('date_format'), get_the_ID()) . '</div>
                                          <div class="ad-meta">
										  <a href="' . get_the_permalink() . '" class="btn btn-success"><i class="fa fa-phone"></i> ' . esc_html__('View Details', 'carspot') . '</a>
										   </div>
                                       </div>
                                    </div>
                                    <!-- Ad Desc End -->
                                 </div>
                                 <!-- Content Block End -->
                              </div>
		';
        }

        function carspot_search_layout_list_3($pid = '')
        {
            $number = 0;
            global $carspot_theme;
            $features_html = '';
            $my_class = '';
            if (isset($carspot_theme['listing_features_grids']) && $carspot_theme['listing_features_grids'] == "car") {
                $features_html = carspot_display_key_features($pid, '5');
            } else {
                $my_class = 'classified-select';
                $features_html .= '';
            }
            $cats_html = carspot_display_cats($pid);
            $img = '';
            $media = carspot_fetch_listing_gallery($pid);
            $total_imgs = count($media);
            if (count((array)$media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID)) {
                        $mid = $m->ID;
                    } else {
                        $mid = $m;
                    }

                    $image = wp_get_attachment_image_src($mid, 'carspot-reviews-thumb', false);
                    if (wp_attachment_is_image($mid)) {
                        $img = '<img src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '" class="img-responsive">';
                    } else {
                        $img = '<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">';
                    }
                    break;
                }
            } else {
                $img = '<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">';
            }

            //for thumbs
            $related_img = '';
            if (count((array)$media) > 0) {
                foreach ($media as $thumb) {
                    $midz = '';
                    if (isset($thumb->ID)) {
                        $midz = $thumb->ID;
                    } else {
                        $midz = $thumb;
                    }
                    $imgthumb = wp_get_attachment_image_src($midz, 'carspot-listing-small');
                    $related_img .= '<li><a href="' . get_the_permalink() . '"><img  src="' . esc_attr($imgthumb[0]) . '" alt="' . get_the_title() . '"></a></li>';
                }
            }

            $is_feature = '';
            $feature_color = '';
            if (get_post_meta(get_the_ID(), '_carspot_is_feature', true) == '1') {
                $feature_color = 'featured_ads';
                $is_feature = '<div class="featured-ribbon"><span>' . esc_html__('Featured', 'carspot') . '</span></div>';
            }

            $custom_locz = '';
            if (carspot_display_adLocation($pid) != "") {
                $custom_locz = '<li> <i class="fa fa-map-marker"></i>' . carspot_display_adLocation($pid) . ' </li>';
            }


            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);

            return '
		<li><div class="well ad-listing clearfix ' . esc_attr($feature_color) . ' ' . esc_attr($my_class) . '">
                                    <div class="col-md-4 col-sm-4 col-xs-12 grid-style no-padding">
                                       <!-- Image Box -->
                                       <div class="img-box">
									   ' . carspot_video_icon() . '
                                          ' . $img . '
                                         <div class="total-images"><strong>' . esc_html($total_imgs) . '</strong>' . esc_html__(' photos', 'carspot') . '</div>
										 <div class="quick-view">
											<a href="' . get_the_permalink() . '" class="view-button"><i class="fa fa-search"></i></a>
										</div>
                                       </div>
                                       <!-- Ad Status -->
									   ' . $is_feature . '
                                       <!-- User Preview -->
                                       <div class="user-preview">
										   <a href="' . get_author_posts_url($author_id) . '?type=ads">
										   <img src="' . esc_url(carspot_get_user_dp($author_id)) . '" class="avatar avatar-small" alt="' . get_the_title() . '">
										   </a>
									 </div>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                       <!-- Ad Content-->
                                       <div class="row">
                                          <div class="content-area">
                                             <div class="col-md-12 col-sm-12 col-xs-12">
                                                <!-- Ad Title -->
                                                 <h3><a href="' . get_correct_link_by_postID($pid) . '">' . get_the_title() . '</a></h3>
                                                <!-- Ad Meta Info -->
                                                <ul class="ad-meta-info">
                                                  ' . $custom_locz . '
                                                   <li> <i class="fa fa-clock-o"></i> ' . get_the_date(get_option('date_format'), get_the_ID()) . '</li>
                                                </ul>
                                                <!-- Ad Description-->
                                                <div class="ad-details">
<div class="clearfix visible-xs-block"></div>
                                       <p class="hidden-sm">' . carspot_words_count(get_the_excerpt(), 110) . '</p>
												' . $features_html . '
                                                </div>
                                                <div class="ad-price-simple"> ' . carspot_adPrice(get_the_ID()) . '</div>
												
                                             </div>
                                          </div>
                                       </div>
                                       <!-- Ad Content End -->
                                    </div>
                                 </div>
                              </li>';
        }

        function carspot_search_layout_list_4($pid = '')
        {
            $my_ads = '';
            $number = 0;
            global $carspot_theme;
            $cats_html = carspot_display_cats($pid);
            $price = ' <div class="ad-price">' . carspot_adPrice(get_the_ID()) . '</div>';
            $img = '';
            $media = carspot_fetch_listing_gallery($pid);
            $total_imgs = count($media);
            if (count((array)$media) > 0) {
                foreach ($media as $m) {
                    $mid = '';
                    if (isset($m->ID)) {
                        $mid = $m->ID;
                    } else {
                        $mid = $m;
                    }
                    if (wp_attachment_is_image($mid)) {
                        $image = wp_get_attachment_image_src($mid, 'carspot-ad-related');
                        $imgthumb = wp_get_attachment_image_src($mid, 'carspot-listing-small');
                        $img = '<img src="' . esc_url($image[0]) . '" alt="' . get_the_title() . '" class="img-responsive">';
                    } else {
                        $img = '<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">';
                    }
                    break;
                }
            } else {
                $img = '<img src="' . esc_url($carspot_theme['default_related_image']['url']) . '" alt="' . get_the_title() . '" class="img-responsive">';
            }
            //for thumbs
            $related_img = '';
            if (count((array)$media) > 0) {
                foreach ($media as $thumb) {
                    $midz = '';
                    if (isset($thumb->ID)) {
                        $midz = $thumb->ID;
                    } else {
                        $midz = $thumb;
                    }
                    $imgthumb = wp_get_attachment_image_src($midz, 'carspot-listing-small');
                    if (isset($imgthumb) && $imgthumb != '') {
                        $related_img .= '<li><a href="' . get_the_permalink() . '"><img  src="' . esc_attr($imgthumb[0]) . '" alt="' . get_the_title() . '"></a></li>';
                    }
                }
            }


            $is_feature = '';
            $feature_color = '';
            if (get_post_meta(get_the_ID(), '_carspot_is_feature', true) == '1') {
                $feature_color = 'featured_ads';
                $is_feature = '<span class="ad-status">' . esc_html__('Featured', 'carspot') . '</span>';
            }

            $car_features = '';
            if (isset($carspot_theme['listing_features_grids']) && $carspot_theme['listing_features_grids'] == "car") {
                if (get_post_meta($pid, '_carspot_ad_engine_types', true) != "") {
                    $car_features .= '<li><a href="javascript:void(0)"> <i class="flaticon-gas-station-1"></i>' . get_post_meta($pid, '_carspot_ad_engine_types', true) . '</a></li>';
                }

                if (get_post_meta($pid, '_carspot_ad_mileage', true) != "") {
                    $car_features .= '<li><a href="javascript:void(0)"><i class="flaticon-dashboard"></i>' . get_post_meta($pid, '_carspot_ad_mileage', true) . ' ' . $carspot_theme['sb_distance_unit'] . '</a></li>';
                }

                if (get_post_meta($pid, '_carspot_ad_engine_capacities', true) != "") {
                    $car_features .= '<li><a href="javascript:void(0)"><i class="flaticon-engine-2"></i>' . carspot_numberFormat_pattern($pid, '_carspot_ad_engine_capacities') . ' ' . $carspot_theme['sb_power_unit'] . '</a></li>';
                }
            }

            $custom_locz = '';
            if (carspot_display_adLocation($pid) != "") {
                $custom_locz = '<p><a href=""><i class="fa fa-map-marker"></i>' . carspot_display_adLocation($pid) . '</a></p>';
            }
            if (isset($carspot_theme['ad_title_limt']) && $carspot_theme['ad_title_limt'] == "1") {
                $limit_value = $carspot_theme['grid_title_limit'];
                $grid_title = carspot_words_count(get_the_title(), $limit_value);
            } else {
                $grid_title = get_the_title();
            }

            return ' <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
					<div class="trending-single-ad">
						<div class="img-container">
							<a href="' . get_the_permalink() . '">' . $img . '</a>
							' . $is_feature . '
							<div class="total-images"><strong>' . esc_html($total_imgs) . '</strong>' . esc_html__(' photos', 'carspot') . ' </div>
							<div class="quick-view">
								<a href="' . get_the_permalink() . '" class="view-button"><i class="fa fa-search"></i></a>
							</div>
						</div>
						<div class="trending-ad-detail">
							<span class="price">' . carspot_adPrice(get_the_ID()) . '</span>
							<h3><a href="' . get_correct_link_by_postID($pid) . '">' . $grid_title . '</a></h3>
							 ' . $custom_locz . '
							<p><i class="fa fa-clock-o"></i> ' . get_the_date(get_option('date_format'), get_the_ID()) . '</p>
								<ul>
									' . $car_features . '
								 </ul>
						</div>
					</div>
				</div>';
        }

    }

}