<?php
global $carspot_theme;
$pid = get_the_ID();
?>
<?php
if (isset($carspot_theme['car_key_features']) && $carspot_theme['car_key_features'] == 1) {
    ?>
    <!-- Heading Area -->
    <?php if (isset($carspot_theme['car_key_features_title']) && $carspot_theme['car_key_features_title'] != '') { ?>
        <div class="heading-panel">
            <h3 class="main-title text-left">
                <?php echo esc_attr($carspot_theme['car_key_features_title']); ?>
            </h3>
        </div>
    <?php } ?>
    <div class="key-features">
        <?php if ($carspot_theme['single_ad_style'] == "2") {
            ?>
            <?php if (get_post_meta($pid, '_carspot_ad_engine_types', true) != "") { ?>
                <div class="boxicon petrol">
                    <a data-toggle="tooltip" data-placement="bottom"
                       title="<?php echo esc_html__('Engine Type', 'carspot') ?>" href="javascript:void(0)">
                        <?php if (isset($carspot_theme['car_key_icons_enginetype']) && $carspot_theme['car_key_icons_enginetype'] != '') {
                            ?>
                            <img src="<?php echo trailingslashit(get_template_directory_uri()) . 'images/icons/001-gas-pump.png' ?>"
                                 class="img-responsive" alt="<?php echo esc_html__('engine type icon', 'carspot'); ?>">
                        <?php }
                        ?>
                        <p><?php echo esc_html__(get_post_meta($pid, '_carspot_ad_engine_types', true),'carspot'); ?></p>
                    </a>
                </div>
            <?php } ?>
            <?php if (get_post_meta($pid, '_carspot_ad_mileage', true) != "") { ?>
                <div class="boxicon kilo-meter">
                    <a data-toggle="tooltip" data-placement="bottom"
                       title="<?php echo esc_html__('Mileage', 'carspot') ?>" href="javascript:void(0)">
                        <?php if (isset($carspot_theme['car_key_icons_mileage']) && $carspot_theme['car_key_icons_mileage'] != '') {
                            ?>
                            <img src="<?php echo trailingslashit(get_template_directory_uri()) . 'images/icons/002-meter.png' ?>"
                                 class="img-responsive" alt="<?php echo esc_html__('mileage icon', 'carspot'); ?>">
                        <?php }
                        ?>
                        <p> <?php echo carspot_numberFormat($pid); ?><?php echo $carspot_theme['sb_distance_unit']; ?></p>
                    </a>
                </div>
            <?php } ?>
            <?php if (get_post_meta($pid, '_carspot_ad_engine_capacities', true) != "") { ?>
                <div class="boxicon engile-capacity">
                    <a data-toggle="tooltip" data-placement="bottom"
                       title="<?php echo esc_html__('Engine Capacity', 'carspot') ?>" href="javascript:void(0)">
                        <?php if (isset($carspot_theme['car_key_icons_engine_capacity']) && $carspot_theme['car_key_icons_engine_capacity'] != '') {
                            ?>
                            <img src="<?php echo trailingslashit(get_template_directory_uri()) . 'images/icons/003-engine.png' ?>"
                                 class="img-responsive"
                                 alt="<?php echo esc_html__('engine capacity icon', 'carspot'); ?>">
                        <?php }
                        ?>
                        <p><?php echo esc_html__(get_post_meta($pid, '_carspot_ad_engine_capacities', true),'carspot') . " " . $carspot_theme['sb_power_unit']; ?></p>
                    </a>
                </div>
            <?php } ?>
            <?php if (get_post_meta($pid, '_carspot_ad_years', true) != "") { ?>
                <div class="boxicon reg-year">
                    <a data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_html__('Year', 'carspot') ?>"
                       href="javascript:void(0)">
                        <?php if (isset($carspot_theme['car_key_icons_year']) && $carspot_theme['car_key_icons_year'] != '') {
                            ?>
                            <img src="<?php echo trailingslashit(get_template_directory_uri()) . 'images/icons/004-calendar.png' ?>"
                                 class="img-responsive" alt="<?php echo esc_html__('Year icon', 'carspot'); ?>">
                        <?php }
                        ?>
                        <p><?php echo esc_html__(get_post_meta($pid, '_carspot_ad_years', true),'carspot'); ?></p>
                    </a>
                </div>
            <?php } ?>
            <?php if (get_post_meta($pid, '_carspot_ad_transmissions', true) != "") { ?>
                <div class="boxicon transmission">
                    <a data-toggle="tooltip" data-placement="bottom"
                       title="<?php echo esc_html__('Transmission Type', 'carspot') ?>" href="javascript:void(0)">
                        <?php if (isset($carspot_theme['car_key_icons_transmission']) && $carspot_theme['car_key_icons_transmission'] != '') {
                            ?>
                            <img src="<?php echo trailingslashit(get_template_directory_uri()) . 'images/icons/006-shift.png' ?>"
                                 class="img-responsive" alt="<?php echo esc_html__('transmission icon', 'carspot'); ?>">
                        <?php }
                        ?>
                        <p><?php echo esc_html__(get_post_meta($pid, '_carspot_ad_transmissions', true),'carspot'); ?></p>
                    </a>
                </div>
            <?php } ?>
            <?php if (get_post_meta($pid, '_carspot_ad_body_types', true) != "") { ?>
                <div class="boxicon body-type">
                    <a data-toggle="tooltip" data-placement="bottom"
                       title="<?php echo esc_html__('Body Type', 'carspot') ?>" href="javascript:void(0)">
                        <?php if (isset($carspot_theme['car_key_icons_body_type']) && $carspot_theme['car_key_icons_body_type'] != '') {
                            ?>
                            <img src="<?php echo trailingslashit(get_template_directory_uri()) . 'images/icons/007-car.png' ?>"
                                 class="img-responsive" alt="<?php echo esc_html__('body type icon', 'carspot'); ?>">
                        <?php }
                        ?>
                        <p><?php echo esc_html__(get_post_meta($pid, '_carspot_ad_body_types', true),'carspot'); ?></p>
                    </a>
                </div>
            <?php } ?>
            <?php if (get_post_meta($pid, '_carspot_ad_colors', true) != "") { ?>
                <div class="boxicon car-color">
                    <a data-toggle="tooltip" data-placement="bottom"
                       title="<?php echo esc_html__('Color Family', 'carspot') ?>" href="javascript:void(0)">
                        <?php if (isset($carspot_theme['car_key_icons_color']) && $carspot_theme['car_key_icons_color'] != '') {
                            ?>
                            <img src="<?php echo trailingslashit(get_template_directory_uri()) . 'images/icons/008-gear.png' ?>"
                                 class="img-responsive" alt="<?php echo esc_html__('color family icon', 'carspot'); ?>">
                        <?php }
                        ?>
                        <p><?php echo esc_html__(get_post_meta($pid, '_carspot_ad_colors', true),'carspot'); ?></p>
                    </a>
                </div>
            <?php } ?>
            <?php
        } else {
            ?>
            <?php if (get_post_meta($pid, '_carspot_ad_engine_types', true) != "") { ?>
                <div class="boxicon">
                    <a data-toggle="tooltip" data-placement="bottom"
                       title="<?php echo esc_html__('Engine Type', 'carspot') ?>" href="javascript:void(0)">
                        <?php
                        if (isset($carspot_theme['car_key_icons_enginetype']) && $carspot_theme['car_key_icons_enginetype'] != '') {

                            echo('<i class="' . esc_attr($carspot_theme['car_key_icons_enginetype']) . ' petrol"></i>');
                        }
                        ?>
                        <p><?php echo esc_html__(get_post_meta($pid, '_carspot_ad_engine_types', true),'carspot'); ?></p>
                    </a>
                </div>
            <?php } ?>
            <?php if (get_post_meta($pid, '_carspot_ad_mileage', true) != "") { ?>
                <div class="boxicon">
                    <a data-toggle="tooltip" data-placement="bottom"
                       title="<?php echo esc_html__('Mileage', 'carspot') ?>" href="javascript:void(0)">
                        <?php
                        if (isset($carspot_theme['car_key_icons_mileage']) && $carspot_theme['car_key_icons_mileage'] != '') {

                            echo('<i class="' . esc_attr($carspot_theme['car_key_icons_mileage']) . ' kilo-meter"></i>');
                        }
                        ?>
                        <p> <?php echo carspot_numberFormat($pid); ?><?php echo $carspot_theme['sb_distance_unit']; ?></p>
                    </a>
                </div>
            <?php } ?>
            <?php if (get_post_meta($pid, '_carspot_ad_engine_capacities', true) != "") { ?>
                <div class="boxicon">
                    <a data-toggle="tooltip" data-placement="bottom"
                       title="<?php echo esc_html__('Engine Capacity', 'carspot') ?>" href="javascript:void(0)">
                        <?php
                        if (isset($carspot_theme['car_key_icons_engine_capacity']) && $carspot_theme['car_key_icons_engine_capacity'] != '') {

                            echo('<i class="' . esc_attr($carspot_theme['car_key_icons_engine_capacity']) . ' engile-capacity"></i>');
                        }
                        ?>
                        <p><?php echo esc_html__(get_post_meta($pid, '_carspot_ad_engine_capacities', true),'carspot') . " " . $carspot_theme['sb_power_unit']; ?></p>
                    </a>
                </div>
            <?php } ?>
            <?php if (get_post_meta($pid, '_carspot_ad_years', true) != "") { ?>
                <div class="boxicon">
                    <a data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_html__('Year', 'carspot') ?>"
                       href="javascript:void(0)">
                        <?php
                        if (isset($carspot_theme['car_key_icons_year']) && $carspot_theme['car_key_icons_year'] != '') {

                            echo('<i class="' . esc_attr($carspot_theme['car_key_icons_year']) . ' reg-year"></i>');
                        }
                        ?>
                        <p><?php echo esc_html__(get_post_meta($pid, '_carspot_ad_years', true),'carspot'); ?></p>
                    </a>
                </div>
            <?php } ?>
            <?php if (get_post_meta($pid, '_carspot_ad_transmissions', true) != "") { ?>
                <div class="boxicon">
                    <a data-toggle="tooltip" data-placement="bottom"
                       title="<?php echo esc_html__('Transmission Type', 'carspot') ?>" href="javascript:void(0)">
                        <?php
                        if (isset($carspot_theme['car_key_icons_transmission']) && $carspot_theme['car_key_icons_transmission'] != '') {

                            echo('<i class="' . esc_attr($carspot_theme['car_key_icons_transmission']) . ' transmission"></i>');
                        }
                        ?>
                        <p><?php echo esc_html__(get_post_meta($pid, '_carspot_ad_transmissions', true),'carspot'); ?></p>
                    </a>
                </div>
            <?php } ?>
            <?php if (get_post_meta($pid, '_carspot_ad_body_types', true) != "") { ?>
                <div class="boxicon">
                    <a data-toggle="tooltip" data-placement="bottom"
                       title="<?php echo esc_html__('Body Type', 'carspot') ?>" href="javascript:void(0)">
                        <?php
                        if (isset($carspot_theme['car_key_icons_body_type']) && $carspot_theme['car_key_icons_body_type'] != '') {
                            echo('<i class="' . esc_attr($carspot_theme['car_key_icons_body_type']) . ' body-type"></i>');
                        }
                        ?>
                        <p><?php echo esc_html__(get_post_meta($pid, '_carspot_ad_body_types', true),'carspot'); ?></p>
                    </a>
                </div>
            <?php } ?>
            <?php if (get_post_meta($pid, '_carspot_ad_colors', true) != "") { ?>
                <div class="boxicon">
                    <a data-toggle="tooltip" data-placement="bottom"
                       title="<?php echo esc_html__('Color Family', 'carspot') ?>" href="javascript:void(0)">
                        <?php
                        if (isset($carspot_theme['car_key_icons_color']) && $carspot_theme['car_key_icons_color'] != '') {

                            echo('<i class="' . esc_attr($carspot_theme['car_key_icons_color']) . ' car-color"></i>');
                        }
                        ?>
                        <p><?php echo esc_html__(get_post_meta($pid, '_carspot_ad_colors', true),'carspot'); ?></p>
                    </a>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
<?php } ?>