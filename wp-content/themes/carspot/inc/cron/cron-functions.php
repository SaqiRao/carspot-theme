<?php

// Add function to register event to wp
add_action('wp', 'cron_function');

function cron_function() {
    global $carspot_theme;
    $carspot_theme = get_option('carspot_theme');

    $cron_switch = $cron_interval = '';
    if (is_array($carspot_theme) && !empty($carspot_theme)) {
        $cron_switch = $carspot_theme['cs_pakg_expirty_email_cron_switch'];
        if ($carspot_theme['cs_pakg_expirty_cron_interval'] != '') {
            $cron_interval = $carspot_theme['cs_pakg_expirty_cron_interval'];
        } else {
            $cron_interval = 'daily';
        }
        if (isset($cron_switch) && $cron_switch == true) {
            if (isset($cron_switch) && $cron_switch) {
                /* Make sure this event hasn't been scheduled */
                if (!wp_next_scheduled('cs_send_emial_on_package_expire')) {
                    /* Schedule the event */
                    wp_schedule_event(time(), $cron_interval, 'cs_send_emial_on_package_expire');
                }
            }
        } else {
            /* =  Un-scheduling Events = */
            if (isset($cron_switch) && !$cron_switch) {
                /* Get the timestamp of the next scheduled run */
                $timestamp = wp_next_scheduled('cs_send_emial_on_package_expire');
                /* Un-schedule the event */
                wp_unschedule_event($timestamp, 'cs_send_emial_on_package_expire');
            }
        }
    }
}

add_action('cs_send_emial_on_package_expire', 'cs_before_package_expire_sent_email');

/* cron jobs call back */

function cs_before_package_expire_sent_email() {
    global $carspot_theme;
    $carspot_theme = get_option('carspot_theme');
    $users = get_users(array('fields' => array('ID')));
    foreach ($users as $user_id) {
        $expiry_date = get_user_meta($user_id->ID, '_carspot_expire_ads', true);
        if ($expiry_date != '-1') {
            /* wp selected date format */
            $wp_date_format = get_option('date_format');
            $current_date = date($wp_date_format, strtotime(date(get_option('date_format'))));
            $prev_date = date($wp_date_format, strtotime($expiry_date . ' -1 day'));
            if (strtotime($current_date) >= strtotime($prev_date)) {
                carspot_send_email_package_expiry($expiry_date, $user_id->ID);
            }
        }
    }
}
