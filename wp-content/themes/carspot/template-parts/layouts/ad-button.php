<?php
global $carspot_theme;
//if (!$carspot_theme['ad_in_menu']) {
//    return;
//}

$sell_car_switch = isset($carspot_theme['ad_in_menu']) ? $carspot_theme['ad_in_menu'] : true;
$cs_other_btn_sell_car_title = isset($carspot_theme['cs_other_btn_sell_car_title']) ? $carspot_theme['cs_other_btn_sell_car_title'] : esc_html__('Some Text', 'carspot');
$cs_other_btn_sell_car_link = isset($carspot_theme['cs_other_btn_sell_car_link']) ? $carspot_theme['cs_other_btn_sell_car_link'] : "#";


if ($sell_car_switch) {
    if (isset($carspot_theme['ad_button_type']) && $carspot_theme['ad_button_type'] == 'post') {
        ?>
        <a href="<?php echo esc_url(get_the_permalink($carspot_theme['sb_post_ad_page'])); ?>" class="btn btn-theme">
            <?php echo esc_html($carspot_theme['ad_button_title']); ?>
        </a>
        <?php
    } else if (isset($carspot_theme['ad_button_type']) && $carspot_theme['ad_button_type'] == 'search_field') {
        ?>
        <form class="form-inline btn-instead" action="<?php echo esc_url(get_the_permalink($carspot_theme['sb_search_page'])); ?>">
            <div class="form-group">
                <input type="text" class="form-control" name="ad_title" autocomplete="off" id="autocomplete-dynamic" placeholder="<?php echo esc_html__('What are you looking for...', 'carspot') ?>" >
            </div>
            <button type="submit" class="btn btn-theme"><i class="fa fa-search"></i></button>
        </form>
        <?php
    } else {
        if (isset($carspot_theme['ad_button_title']) && isset($carspot_theme['quote_page_link'])) {
            ?>
            <a href="<?php echo esc_url(get_the_permalink($carspot_theme['quote_page_link'])); ?>" class="btn btn-theme">
            <?php echo esc_html($carspot_theme['ad_button_title']); ?>
            </a>
            <?php
        }
    }
} else {
    if (isset($cs_other_btn_sell_car_title) && isset($cs_other_btn_sell_car_link)) {
        ?>
        <a href="<?php echo esc_url(get_the_permalink($cs_other_btn_sell_car_link)); ?>" class="btn btn-theme">
        <?php echo esc_html($cs_other_btn_sell_car_title); ?>
        </a>
        <?php
    }
}
?>