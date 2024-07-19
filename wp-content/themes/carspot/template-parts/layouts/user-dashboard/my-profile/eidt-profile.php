<?php
global $carspot_theme;
$current_user_id = get_current_user_id();
$user_pic = carspot_get_dealer_logo($current_user_id);
$store_pic = carspot_get_dealer_store_front($current_user_id);
$current_user = wp_get_current_user();
$user_meta = '';
$user_meta = get_user_meta($current_user_id);
$user_type = get_user_meta($current_user_id, '_sb_user_type', true);
$sb_licence_require = '';
if ($carspot_theme['sb_user_license_required'] == true) {
    $sb_licence_require = 'required';
}
$sb_phone_require = '';
if ($carspot_theme['sb_user_phone_required'] == true) {
    $sb_phone_require = 'required';
}


if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'package_based') {
    if (get_user_meta($current_user_id, '_sb_simple_ads', true) != '-1') {
        $free_ads = get_user_meta($current_user_id, '_sb_simple_ads', true);
    } else {
        $free_ads = esc_html__('Unlimited', 'carspot');
    }
    if (get_user_meta($current_user_id, '_carspot_expire_ads', true) != '-1') {
        $expiry = get_user_meta($current_user_id, '_carspot_expire_ads', true);
    } else {
        $expiry = __('Never', 'carspot');
    }
    if (get_user_meta($current_user_id, '_carspot_featured_ads', true) != '-1') {
        $featured_ads = get_user_meta($current_user_id, '_carspot_featured_ads', true);
    } else {
        $featured_ads = __('Unlimited', 'carspot');
    }

    if (get_user_meta($current_user_id, '_carspot_bump_ads', true) != '-1') {
        $bump_ads = get_user_meta($current_user_id, '_carspot_bump_ads', true);
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
?>

<div class="container-fluid">
    <!-- OVERVIEW -->
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="panel  panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('Edit Profile', 'carspot') ?></h3>
                    <a href="#" data-target="#myModal"
                       data-toggle="modal"><?php echo esc_html__('Change Password', 'carspot') ?></a>
                    <p class="panel-subtitle"><?php
                        echo esc_html__('Last logged in ', 'carspot');
                        echo carspot_get_last_login($current_user_id);
                        echo esc_html__(' Ago', 'carspot');
                        ?></p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
                            <div class="panel  panel-headline">
                                <div class="profile-card">
                                    <div class="profile-card-body">
                                        <div class="contact-box">
                                            <div class="contact-box-bg" id="store-image"
                                                 <?php if ($store_pic != "") { ?>style="background-image:url(<?php echo esc_url($store_pic) ?>)" <?php } ?>></div>
                                            <div class="contact-img">
                                                <a href="<?php echo esc_url(get_author_posts_url($current_user_id)); ?>"><img
                                                            src="<?php echo esc_url($user_pic) ?>"
                                                            class="img-responsive" id="profile-image"
                                                            alt="<?php echo esc_html__('Profile Picture', 'carspot') ?>"></a>
                                            </div>
                                            <div class="contact-caption">
                                                <h4><?php echo esc_html($current_user->display_name); ?></h4>

                                                <?php
                                                if (isset($carspot_theme['sb_enable_user_ratting']) && $carspot_theme['sb_enable_user_ratting']) {
                                                    echo avg_user_rating($current_user_id) . ' (';
                                                    echo carspot_dealer_review_count($current_user_id) . ')';
                                                }
                                                ?>
                                                <div class="clearfix"></div>
                                                <div class="upload-btn-wrapper">
                                                    <?php
                                                    if (isset($carspot_theme['sb_demo_mode']) && $carspot_theme['sb_demo_mode'] == true) {
                                                        ?>
                                                        <span class="tooltip-disabled" data-toggle="tooltip"
                                                              title="<?php echo esc_html__('Disabled in demo', 'carspot') ?>">
                                                            <button class="btn-profile"> <?php echo esc_html__('Profile Photo', 'carspot') ?></button>
                                                            <input type="file" id="imgInp" name="my_file_upload"
                                                                   accept="image/*" disabled/>
                                                        </span>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <button class="btn-profile"> <?php echo esc_html__('Profile Photo', 'carspot') ?></button>
                                                        <input type="file" id="imgInp" name="my_file_upload"
                                                               accept="image/*" class="sb_files-data"/>
                                                        <input type="hidden" id="profile_pic_nonce"
                                                               value="<?php echo wp_create_nonce('carspot_profile_pic_secure') ?>"/>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel  panel-headline">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo esc_html__('Profile Details', 'carspot') ?></h3>
                                </div>
                                <div class="panel-body">
                                    <ul class="profile-details">
                                        <li>
                                            <i class="la la-user"></i>
                                            <div class="profile-meta">
                                                <h6><?php echo esc_html__('Full Name', 'carspot') ?></h6>
                                                <span><?php echo esc_html($current_user->display_name); ?></span>
                                            </div>
                                        </li>
                                        <li>
                                            <i class="la la-envelope"></i>
                                            <div class="profile-meta">
                                                <h6> <?php echo esc_html__('Email', 'carspot') ?></h6>
                                                <span><?php echo esc_html($current_user->user_email); ?></span>
                                            </div>
                                        </li>
                                        <li>
                                            <i class="la la-mobile-phone"></i>
                                            <div class="profile-meta">
                                                <h6><?php echo esc_html__('Phone number', 'carspot') ?></h6>
                                                <span>
                                                    <?php echo esc_html(get_user_meta($current_user_id, '_sb_contact', true)); ?></span>
                                            </div>
                                        </li>
                                        <?php
                                        if ($user_type == 'dealer') {
                                            ?>
                                            <li>
                                                <i class="la la-globe"></i>
                                                <div class="profile-meta">
                                                    <h6><?php echo esc_html__('Website Address', 'carspot') ?></h6>
                                                    <span><?php echo esc_url(get_user_meta($current_user_id, '_sb_user_web_url', true)); ?></span>
                                                </div>
                                            </li>
                                            <li>
                                                <i class="la la-map-marker"></i>
                                                <div class="profile-meta">
                                                    <h6><?php echo esc_html__('Location', 'carspot') ?></h6>
                                                    <span><?php echo esc_html(get_user_meta($current_user_id, '_sb_address', true)); ?></span>
                                                </div>
                                            </li>
                                        <?php } ?>
                                        <li>
                                            <i class="la la-users"></i>
                                            <div class="profile-meta">
                                                <h6>  <?php echo esc_html__('Account Type', 'carspot') ?></h6>
                                                <span> 
                                                    <?php
                                                    if (is_super_admin()) {
                                                        echo esc_html__('Admin', 'carspot');
                                                    } else {
                                                        if ($user_type == 'dealer') {
                                                            echo esc_html__('Dealer', 'carspot');
                                                        } else {
                                                            echo esc_html__('Individual', 'carspot');
                                                        }
                                                    }
                                                    ?>
                                                </span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <?php
                            if (isset($carspot_theme['carspot_package_type']) && $carspot_theme['carspot_package_type'] == 'package_based') {
                                ?>
                                <div class="panel  panel-headline colored-panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?php echo esc_html__('Package Details', 'carspot') ?></h3>
                                    </div>
                                    <div class="panel-body">
                                        <ul class="profile-details">
                                            <li>
                                                <i class="la la-plus"></i>
                                                <div class="profile-meta">
                                                    <h6><?php echo esc_html__('Simple Ads', 'carspot') ?></h6>
                                                    <span><?php echo esc_html($free_ads); ?></span>
                                                </div>
                                            </li>
                                            <li>
                                                <i class="la la-star"></i>
                                                <div class="profile-meta">
                                                    <h6> <?php echo esc_html__('Featured Ads', 'carspot') ?></h6>
                                                    <span><?php echo esc_html($featured_ads); ?></span>
                                                </div>
                                            </li>
                                            <li>
                                                <i class="la la-retweet"></i>
                                                <div class="profile-meta">
                                                    <h6><?php echo esc_html__('Bump up Ads', 'carspot') ?></h6>
                                                    <span><?php echo esc_html($bump_ads); ?></span>
                                                </div>
                                            </li>
                                            <li>
                                                <i class="la la-calendar"></i>
                                                <div class="profile-meta">
                                                    <h6><?php echo esc_html__('Package Expiry date', 'carspot') ?></h6>
                                                    <span>
                                                        <?php
                                                        $curr_date = strtotime(date("F j, Y"));
                                                        $expiry_date = strtotime($expiry);
                                                        if ($expiry == __('Never', 'carspot') || $expiry == '-1') {
                                                            echo esc_html__('Never Expire', 'carspot');
                                                        } else if ($curr_date > $expiry_date) {
                                                            echo esc_html__('Package Expired', 'carspot');
                                                        } else {
                                                            //echo date_i18n("F jS, Y", strtotime($expiry));
                                                            echo date_i18n(get_option('date_format'), strtotime($expiry), false);
                                                        }
                                                        ?>
                                                    </span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
                            <div class="edit-profile-form">
                                <form id="sb_update_profile" data-parsley-validate="">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label"><?php echo esc_html__('Full Name', 'carspot') ?></label>
                                                <input class="form-control" type="text" name="sb_user_name"
                                                       value="<?php echo esc_html($current_user->display_name); ?>"
                                                       data-parsley-error-message="<?php echo esc_html__('This value is required.', 'carspot') ?>"
                                                       required/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label protip"><?php echo esc_html__('Email Address', 'carspot') ?></label>
                                                <input class="protip form-control" type="email" name="user_email"
                                                       value="<?php echo esc_attr($current_user->user_email); ?>"
                                                       readonly
                                                       data-pt-title=" <?php echo esc_attr__('You can not edit email address', 'carspot') ?>"
                                                       data-pt-position="top" data-pt-scheme="dark-transparent"
                                                       data-pt-size="small"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label"><?php echo esc_html__('Mobile No', 'carspot') ?></label>
                                                <input class="form-control"
                                                       data-parsley-error-message="<?php echo esc_html__('This value is required.', 'carspot') ?>" <?php echo $sb_phone_require; ?>
                                                       data-parsley-type="number" type="text" name="sb_user_contact"
                                                       value="<?php echo esc_attr(get_user_meta($current_user_id, '_sb_contact', true)); ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if ($user_type == 'dealer') {
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                <h3 class="dashboard-heading"> <?php echo esc_html__('Dealers Detail', 'carspot') ?></h3>
                                            </div>
                                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo esc_html__('Company Name', 'carspot') ?></label>
                                                    <input class="form-control" type="text" name="sb_camp_name"
                                                           value="<?php echo esc_attr(get_user_meta($current_user_id, '_sb_camp_name', true)); ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo esc_html__('Website URL', 'carspot') ?></label>
                                                    <input class="form-control" type="url" data-parsley-type="url"
                                                           name="sb_user_web_url"
                                                           value="<?php echo esc_url(get_user_meta($current_user_id, '_sb_user_web_url', true)); ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo esc_html__('License No.', 'carspot') ?></label>
                                                    <input class="form-control"
                                                           type="text" <?php echo $sb_licence_require; ?>
                                                           name="sb_user_lisence"
                                                           value="<?php echo esc_attr(get_user_meta($current_user_id, '_sb_user_lisence', true)); ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo esc_html__('Opening Hours', 'carspot') ?></label>
                                                    <input class="form-control" type="text" name="sb_user_timings"
                                                           placeholder="<?php echo __('e.g Monday - Friday 8am to 6pm', 'carspot'); ?>"
                                                           value="<?php echo esc_attr(get_user_meta($current_user_id, '_sb_user_timings', true)); ?>"/>
                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                    carspot_load_search_countries(1);
                                    $ad_map_lat = get_user_meta($current_user_id, '_sb_user_address_lat', true);
                                    $ad_map_long = get_user_meta($current_user_id, '_sb_user_address_long', true);

                                    if ($ad_map_lat == "" && $ad_map_long == "" && isset($carspot_theme['sb_default_lat']) && $carspot_theme['sb_default_lat'] && isset($carspot_theme['sb_default_long']) && $carspot_theme['sb_default_long']) {
                                        $ad_map_lat = $carspot_theme['sb_default_lat'];
                                        $ad_map_long = $carspot_theme['sb_default_long'];
                                    }

                                    $mapType = carspot_mapType();
                                    if ($mapType == 'google_map') {
                                        wp_enqueue_script('google-map-callback', '//maps.googleapis.com/maps/api/js?key=' . $carspot_theme['gmap_api_key'] . '&libraries=places&callback=' . 'carspot_location', false, false, true);
                                    }
                                    if ($mapType == 'google_map') {
                                    if (isset($carspot_theme['allow_lat_lon']) && !$carspot_theme['allow_lat_lon']) {

                                    } else {
                                    ?>
                                        <script type="text/javascript">
                                            var markers = [
                                                {
                                                    "title": "",
                                                    "lat": "<?php echo esc_html($ad_map_lat); ?>",
                                                    "lng": "<?php echo esc_html($ad_map_long); ?>"
                                                }
                                            ];
                                            window.onload = function () {
                                                my_g_map(markers);
                                            }

                                            function my_g_map(markers1) {
                                                var mapOptions = {
                                                    center: new google.maps.LatLng(markers1[0].lat, markers1[0].lng),
                                                    zoom: 12,
                                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                                };
                                                var infoWindow = new google.maps.InfoWindow();
                                                var latlngbounds = new google.maps.LatLngBounds();
                                                var geocoder = geocoder = new google.maps.Geocoder();
                                                var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
                                                var data = markers1[0]
                                                var myLatlng = new google.maps.LatLng(data.lat, data.lng);
                                                var marker = new google.maps.Marker({
                                                    position: myLatlng,
                                                    map: map,
                                                    title: data.title,
                                                    draggable: true,
                                                    animation: google.maps.Animation.DROP
                                                });
                                                (function (marker, data) {
                                                    google.maps.event.addListener(marker, "click", function (e) {
                                                        infoWindow.setContent(data.description);
                                                        infoWindow.open(map, marker);
                                                    });
                                                    google.maps.event.addListener(marker, "dragend", function (e) {
                                                        // document.getElementById("sb_loading").style.display	= "block";
                                                        var lat, lng, address;
                                                        geocoder.geocode({"latLng": marker.getPosition()}, function (results, status) {

                                                            if (status === google.maps.GeocoderStatus.OK) {
                                                                lat = marker.getPosition().lat();
                                                                lng = marker.getPosition().lng();
                                                                address = results[0].formatted_address;

                                                                document.getElementById("sb_user_address").value = address;
                                                                document.getElementById('ad_map_lat').value = lat;
                                                                document.getElementById('ad_map_long').value = lng;
                                                                document.getElementById("sb_loading").style.display = "none";
                                                                //alert("Latitude: " + lat + "\nLongitude: " + lng + "\nAddress: " + address);
                                                            }
                                                        });
                                                    });
                                                })(marker, data);
                                                latlngbounds.extend(marker.position);
                                            }

                                            /*var bounds = new google.maps.LatLngBounds();
                                             map.setCenter(latlngbounds.getCenter());
                                             map.fitBounds(latlngbounds);*/
                                        </script><?php
                                    }
                                    }
                                    ?>
                                        <div class="row">

                                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo esc_html__('Store Front Image', 'carspot'); ?></label>
                                                    <div class="contact-caption">
                                                        <div class="upload-btn-wrapper">

                                                            <?php
                                                            if (isset($carspot_theme['sb_demo_mode']) && $carspot_theme['sb_demo_mode'] == true) {
                                                                ?>
                                                                <span class="tooltip-disabled" data-toggle="tooltip"
                                                                      title="<?php echo esc_html__('Disabled in demo', 'carspot') ?>">
                                                                    <button class="btn-profile"> <?php echo esc_html__('Upload Imagesss', 'carspot') ?></button>
                                                                    <input type="file" id="imgInps" name="my_store_file"
                                                                           accept="image/*" disabled/>
                                                                </span>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <button class="btn-profile"> <?php echo esc_html__('Upload Image', 'carspot') ?></button>
                                                                <input type="file" id="imgInps" name="my_store_file"
                                                                       accept="image/*" class="sb_store_img"/>
                                                                <input type="hidden" id="cover_pic_nonce"
                                                                       value="<?php echo wp_create_nonce('carspot_cover_secure') ?>"/>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo esc_html__('Address', 'carspot') ?></label>
                                                    <input class="form-control" autocomplete="off" type="text"
                                                           name="sb_user_address" id="sb_user_address"
                                                           value="<?php echo esc_attr(get_user_meta($current_user_id, '_sb_address', true)); ?>"
                                                           placeholder="<?php echo __("Enter a location", "carspot"); ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    if ($mapType != 'no_map') {
                                    ?>
                                        <div class="row">
                                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo esc_html__('Latitude', 'carspot') ?></label>
                                                    <input class="form-control" type="text" name="sb_user_address_lat"
                                                           id="ad_map_lat"
                                                           value="<?php echo esc_attr($ad_map_lat); ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo esc_html__('Longitude', 'carspot') ?></label>
                                                    <input class="form-control" type="text" name="sb_user_address_long"
                                                           id="ad_map_long"
                                                           value="<?php echo esc_attr($ad_map_long); ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                <div class="form-group">
                                                    <div id="dvMap" style=" height: 300px"></div>
                                                    <em><small><?php echo esc_html__('Drag pin for your pin-point location.', 'carspot') ?></small></em>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                    }
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="control-label"><?php echo esc_html__('About Yourself', 'carspot') ?></label>
                                                <textarea class="form-control" name="sb_user_about"
                                                          rows="10"><?php echo esc_html(get_user_meta($current_user_id, '_sb_user_about', true)); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if ($user_type == 'dealer') {
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                                <h3 class="dashboard-heading"> <?php echo esc_html__('Social Links', 'carspot') ?></h3>
                                            </div>
                                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo esc_html__('Facebook Link', 'carspot') ?></label>
                                                    <input class="form-control" type="url" data-parsley-type="url"
                                                           name="sb_user_facebook"
                                                           value="<?php echo esc_url(get_user_meta($current_user_id, '_sb_user_facebook', true)); ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo esc_html__('Twitter Link', 'carspot') ?></label>
                                                    <input class="form-control" type="url" data-parsley-type="url"
                                                           name="sb_user_twitter"
                                                           value="<?php echo esc_url(get_user_meta($current_user_id, '_sb_user_twitter', true)); ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo esc_html__('LinkedIn Profile', 'carspot') ?></label>
                                                    <input class="form-control" type="url" data-parsley-type="url"
                                                           name="sb_user_linkedin"
                                                           value="<?php echo esc_url(get_user_meta($current_user_id, '_sb_user_linkedin', true)); ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo esc_html__('Youtube Channel', 'carspot') ?></label>
                                                    <input class="form-control" type="url" data-parsley-type="url"
                                                           name="sb_user_youtube"
                                                           value="<?php echo esc_url(get_user_meta($current_user_id, '_sb_user_youtube', true)); ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6 col-lg-push-6 col-md-push-6 col-sm-push-6">
                                            <?php
                                            if (isset($carspot_theme['sb_demo_mode']) && $carspot_theme['sb_demo_mode'] == true) {
                                                ?>
                                                <div class="form-group">
                                                    <span class="tooltip-disabled pull-right" data-toggle="tooltip"
                                                          title="<?php echo esc_html__('Disabled in demo', 'carspot') ?>">
                                                        <input class="btn btn-theme <?php if (is_rtl()) { ?> pull-left <?php } else { ?>pull-right<?php } ?>"
                                                               type="submit"
                                                               value="<?php echo esc_html__('Update profile', 'carspot') ?>"
                                                               disabled/>
                                                    </span>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="form-group">
                                                    <input class="btn btn-theme <?php if (is_rtl()) { ?> pull-left <?php } else { ?>pull-right<?php } ?>"
                                                           type="submit"
                                                           value="<?php echo esc_html__('Update profile', 'carspot') ?>"
                                                           id="sb_user_profile_update"/>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-xs-12 col-sm-6 col-lg-pull-6 col-md-pull-6 col-sm-pull-6">


                                            <?php
                                            if (isset($carspot_theme['sb_demo_mode']) && $carspot_theme['sb_demo_mode'] == true) {
                                                ?>
                                                <div class="form-group">
                                                    <div class="tooltip-disabled pull-left" data-toggle="tooltip"
                                                         title="<?php echo esc_html__('Disabled in demo', 'carspot') ?>">
                                                        <input class="btn btn-default protip" type="button"
                                                               value="<?php echo esc_html__('Delete Account?', 'carspot') ?>"
                                                               disabled>
                                                    </div>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="form-group">
                                                    <input class="btn btn-default"
                                                           data-userid="<?php echo esc_attr($current_user_id); ?>"
                                                           type="button"
                                                           value="<?php echo esc_html__('Delete Account?', 'carspot') ?>"
                                                           id="carspot_delete_account"/>
                                                    <input type="hidden" id="del_profile_nonce"
                                                           value="<?php echo wp_create_nonce('carspot_del_profile_secure') ?>"/>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <input type="hidden" id="save_profile_nonce"
                                           value="<?php echo wp_create_nonce('carspot_profile_secure') ?>"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal fade change-psw" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header rte">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"> ✕ </span></button>
                <h2 class="modal-title"><?php echo esc_html__('Password Change', 'carspot'); ?></h2>
            </div>
            <form id="sb-change-password">
                <div class="modal-body">
                    <div class="form-group">
                        <label><?php echo esc_html__('Current Password', 'carspot'); ?></label>
                        <input placeholder="<?php echo esc_html__('Current Password', 'carspot'); ?>"
                               class="form-control" type="password" name="current_pass" id="current_pass">
                    </div>
                    <div class="form-group">
                        <label><?php echo esc_html__('New Password', 'carspot'); ?></label>
                        <input placeholder="<?php echo esc_html__('New Password', 'carspot'); ?>" class="form-control"
                               type="password" name="new_pass" id="new_pass">
                    </div>
                    <div class="form-group">
                        <label><?php echo esc_html__('Confirm New Password', 'carspot'); ?></label>
                        <input placeholder="<?php echo esc_html__('Confirm Password', 'carspot'); ?>"
                               class="form-control" type="password" name="con_new_pass" id="con_new_pass">
                    </div>

                    <?php
                    if (isset($carspot_theme['sb_demo_mode']) && $carspot_theme['sb_demo_mode'] == true) {
                        ?>
                        <div class="form-group">
                            <span class="tooltip-disabled pull-left" data-toggle="tooltip"
                                  title="<?php echo esc_html__('Disabled in demo', 'carspot') ?>">
                                <button class="btn btn-theme btn-block" type="button"
                                        disabled><?php echo esc_html__('Reset My Password', 'carspot'); ?></button>
                            </span>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="form-group">
                            <button class="btn btn-theme btn-block" type="button"
                                    id="change_pwd"><?php echo esc_html__('Reset My Password', 'carspot'); ?></button>
                            <input type="hidden" id="reset_psw_nonce"
                                   value="<?php echo wp_create_nonce('carspot_reset_psw_secure') ?>"/>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>
