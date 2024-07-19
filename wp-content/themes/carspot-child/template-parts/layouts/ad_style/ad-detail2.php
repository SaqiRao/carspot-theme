<?php
global $carspot_theme;
$pid = get_the_ID();
$post_categories = wp_get_object_terms($pid, array('ad_cats'));

/* arrange terms from parent to childs */
$count = count($post_categories) - 1;
$term_ids = array();
foreach ($post_categories as $a) {
    $term_ids[$count] = $a->term_id;
    $count = $count - 1;
}

$class = '';
$type = $carspot_theme['cat_and_location'];
if (isset($carspot_theme['ad_slider_type']) && $carspot_theme['ad_slider_type'] == 4) {
    $class = '';
} else {
    $class = 'margin-top-20';
}
?>
<div class="content-box-grid <?php echo esc_attr($class); ?>">
    <?php
    if (get_post_meta($pid, '_carspot_ad_status_', true) == 'sold') {
        ?>
        <div class="ad-closed">
            <img class="img-responsive"
                 src="<?php echo trailingslashit(get_template_directory_uri()); ?>images/sold.png"
                 alt="<?php esc_html__('sold out', 'carspot'); ?>">
        </div>
        <?php
    }
    ?>
    <?php
    if (get_post_meta($pid, '_carspot_ad_status_', true) == 'expired') {
        ?>
        <div class="ad-expired">
            <img class="img-responsive"
                 src="<?php echo trailingslashit(get_template_directory_uri()); ?>images/expired.png"
                 alt="<?php esc_html__('sold out', 'carspot'); ?>">
        </div>
        <?php
    }
    ?>

    <div class="short-features" id="short-desc">
        <?php $current_adpost = get_option('_carspot_current_ad_post_template'); ?>
        <!-- Heading Area -->
        <div class="heading-panel">
            <h3 class="main-title text-left">
                <?php echo esc_html__('Description', 'carspot'); ?>
            </h3>
        </div>
        <div class="short-feature-body">
            <p><?php carspot_get_formated_description(the_content()); ?> </p>
            <?php
            if ($carspot_theme['enable_vehicle_review'] == true) {
                $vehicle_revi_url = '';
                $ad_vehicle_review_url = (get_post_meta($pid, '_carspot_ad_vehicle_review_url', true) != '') ? get_post_meta($pid, '_carspot_ad_vehicle_review_url', true) : '';
                $vehicle_review_enabled_opt = ($carspot_theme['vehicle_review_enabled_opt'] != '') ? $carspot_theme['vehicle_review_enabled_opt'] : '';
                $vehicle_review_title_opt = ($carspot_theme['vehicle_review_title'] != '') ? $carspot_theme['vehicle_review_title'] : '';
                $vehicle_review_url_opt = ($carspot_theme['vehicle_review_url'] != '') ? $carspot_theme['vehicle_review_url'] : '';
                $vehicle_review_logo_opt = ($carspot_theme['vehicle_review_logo'] != '') ? $carspot_theme['vehicle_review_logo']['url'] : '';

                if ($vehicle_review_url_opt != '' && $vehicle_review_enabled_opt == 'all' && $ad_vehicle_review_url == '') {
                    $vehicle_revi_url = $vehicle_review_url_opt;
                } elseif ($ad_vehicle_review_url != '' && ($vehicle_review_enabled_opt == 'specific' || $vehicle_review_enabled_opt == 'all')) {
                    $vehicle_revi_url = $ad_vehicle_review_url;
                }
                if ($vehicle_revi_url != '' && $vehicle_review_title_opt != '') {
                    ?>
                    <div class="ad-share text-center vehicle-rev-history">
                        <div class="col-md-6 col-sm-6 col-xs-12 vehicle-rev-contanr">
                            <a href="<?php echo esc_url($vehicle_revi_url); ?>" target="_blank">
                                <span class="hidetext vehicle-rev-heding"><strong><?php echo esc_html($vehicle_review_title_opt); ?></strong> <img
                                            src="<?php echo $vehicle_review_logo_opt; ?>"
                                            alt="<?php echo __('No Review Logo', 'carspot'); ?>"></span>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <?php
            if (get_post_meta($pid, '_carspot_ad_price_type', true) == "no_price" || (get_post_meta($pid, '_carspot_ad_price', true) == "" && get_post_meta($pid, '_carspot_ad_price_type', true) != "free" && get_post_meta($pid, '_carspot_ad_price_type', true) != "on_call")) {

            } else {
                ?>
                <div class="col-sm-12 col-md-12 col-xs-12 no-padding categories-exist carspot-terms">
                    <div class="terms-details">
                        <?php
                        $categ_label_detail_page_description = ($carspot_theme['cs_categ_label_detail_page_description']);
                        $valu_detail = (explode("|", $categ_label_detail_page_description));
                        for ($i = 0; $i < count($post_categories); $i++) {
                            $symb = '';
                            if ($i < (count($post_categories) - 1) && $valu_detail != '') {
                                $symb = ", ";
                            }
                            ?>
                            <span>
                            <strong>
                                <?php echo $valu_detail[$i] . $symb; ?>
                            </strong>
                        </span>
                            <?php
                        }
                        echo " :";
                        for ($a = 0; $a < count($term_ids); $a++) {
                            $cat = get_term($term_ids[$a], 'ad_cats');
                            if ($type == 'search') {
                                $link = get_the_permalink($carspot_theme['sb_search_page']) . '?cat_id=' . $cat->term_id;
                            } else {
                                $link = get_term_link($cat->term_id);
                            }
                            ?>
                            <a href="<?php echo esc_attr($link); ?>"><?php echo esc_html($cat->name); ?> </a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12 no-padding carspot-terms">
                    <div class="terms-details">
                        <span><strong><?php echo esc_html__('Price', 'carspot'); ?></strong> :</span>
                        <?php echo carspot_adPrice($pid); ?>
                    </div>
                </div>
            <?php } ?>
            <?php
            $a = '1';
            if (get_post_meta($pid, '_carspot_ad_type', true) != "" && $current_adpost != "yes" && $a == 2) {
                ?>
                <div class="col-sm-4 col-md-4 col-xs-12 no-padding carspot-terms">
                    <div class="terms-details">
                        <span><strong><?php echo esc_html__('Type', 'carspot'); ?></strong> :</span>
                        <?php echo esc_html(get_post_meta($pid, '_carspot_ad_type', true)); ?>
                    </div>
                </div>
            <?php } ?>
            <div class="col-sm-4 col-md-4 col-xs-12 no-padding carspot-terms">
                <div class="terms-details">
                    <span><strong><?php echo esc_html__('Date', 'carspot'); ?></strong> :</span>
                    <?php echo esc_html(get_the_date()); ?>
                </div>
            </div>
            <?php
            if (get_post_meta($pid, '_carspot_ad_condition', true) != "" && isset($carspot_theme['allow_tax_condition']) && $carspot_theme['allow_tax_condition'] && $current_adpost != "yes" && $a == 2) {
                ?>
                <div class="col-sm-4 col-md-4 col-xs-12 no-padding carspot-terms">
                    <div class="terms-details">
                        <span><strong><?php echo esc_html__('Condition', 'carspot'); ?></strong> :</span>
                        <?php echo esc_html(get_post_meta($pid, '_carspot_ad_condition', true)); ?>
                    </div>
                </div>
                <?php
            }
            if (get_post_meta($pid, '_carspot_ad_warranty', true) != "" && isset($carspot_theme['allow_tax_warranty']) && $carspot_theme['allow_tax_warranty'] && $current_adpost != "yes" && $a == 2) {
                ?>
                <div class="col-sm-4 col-md-4 col-xs-12 no-padding carspot-terms">
                    <div class="terms-details">
                        <span><strong><?php echo esc_html__('Warranty', 'carspot'); ?></strong> :</span>
                        <?php echo esc_html(get_post_meta($pid, '_carspot_ad_warranty', true)); ?>
                    </div>
                </div>
                <?php
            }
            global $wpdb;
            $rows = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE post_id = '$pid' AND meta_key LIKE '_sb_extra_%'");

            foreach ($rows as $row) {
                $caption = explode('_', $row->meta_key);
                if ($row->meta_value == "") {
                    continue;
                }
                ?>
                <div class="col-sm-4 col-md-4 col-xs-12 no-padding carspot-terms">
                    <div class="terms-details">
                        <span><strong><?php echo esc_html(ucfirst($caption[3])); ?></strong> :</span>
                        <?php echo esc_html($row->meta_value); ?>
                    </div>
                </div>
                <?php
            }
            if (function_exists('carspotCustomFieldsHTML')) {
                echo carspotCustomFieldsHTML($pid);
            }
            ?>
            <?php if (carspot_display_adLocation($pid) != "") { ?>
                <div class="col-sm-12 col-md-12 col-xs-12 location-exit no-padding carspot-terms">
                    <div class="terms-details">
                        <span><strong><?php echo esc_html__("Location", 'carspot'); ?></strong> :</span>
                        <?php echo carspot_display_adLocation($pid); ?>
                    </div>
                </div>
            <?php } ?>

                <?php if (get_post_meta($pid, '_carspot_tpl_field_ad_model', true) != "") { ?> 
                    <div class="col-sm-12 col-md-12 col-xs-12 location-exit no-padding carspot-terms">
                <div class="terms-details">
                    <span><strong><?php echo esc_html__("Model", 'carspot'); ?></strong> :</span>
                    <?php echo esc_html(get_post_meta($pid, '_carspot_tpl_field_ad_model', true)); ?>
                </div>
            </div>
         <?php } 
    
        ?>

        <?php if (get_post_meta($pid, '_carspot_tpl_field_ad_brand', true) != "") { ?>
            <div class="col-sm-12 col-md-12 col-xs-12 location-exit no-padding carspot-terms">
                <div class="terms-details">
                    <span><strong><?php echo esc_html__("Brands", 'carspot'); ?></strong> :</span>
                    <?php echo esc_html(get_post_meta($pid, '_carspot_tpl_field_ad_brand', true)); ?>
                </div>
            </div>
        <?php } ?>

        <?php if (get_post_meta($pid, '_carspot_tpl_field_ad_weight', true) != "") { ?>
            <div class="col-sm-12 col-md-12 col-xs-12 location-exit no-padding carspot-terms">
                <div class="terms-details">
                    <span><strong><?php echo esc_html__("Tonnage", 'carspot'); ?></strong> :</span>
                    <?php echo esc_html(get_post_meta($pid, '_carspot_tpl_field_ad_weight', true)); ?>
                </div>
            </div>
        <?php } 
       
        ?>

        <?php if (get_post_meta($pid, '_carspot_tpl_field_ad_hours', true) != "") { ?>
            <div class="col-sm-12 col-md-12 col-xs-12 location-exit no-padding carspot-terms">
                <div class="terms-details">
                    <span><strong><?php echo esc_html__("Number Of  Hours", 'carspot'); ?></strong> :</span>
                    <?php echo esc_html(get_post_meta($pid, '_carspot_tpl_field_ad_hours', true)); ?>
                </div>
            </div>
        <?php } ?>

        </div>
    </div>
    <div class="short-features" id="features">
        <?php get_template_part('template-parts/layouts/ad_style/car', 'features2'); ?>
    </div>
    <div class="clearfix"></div>
</div>