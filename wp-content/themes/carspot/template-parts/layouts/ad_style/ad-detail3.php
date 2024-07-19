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
$type = $carspot_theme['cat_and_location'];
?>

<div class="description">
    <h3><?php echo esc_html__("Description", "carspot"); ?></h3>
    <?php
    carspot_get_formated_description(the_content());
    ?>
</div>
<div class="desc-dtl">
    <div class="row term-wraps">
        <div class="col-sm-4 col-md-4 col-xs-12 no-padding ad_mileage carspot-terms">
            <div class="terms-details">
                <span><strong>
                    <?php
                    $categ_label_detail_page_description = ($carspot_theme['cs_categ_label_detail_page_description']);
                    $valu_detail = (explode("|", $categ_label_detail_page_description));
                    for ($i = 0; $i < count($post_categories); $i++) {
                        $symb = '';
                        if ($i < (count($post_categories) - 1) && $valu_detail != '') {
                            $symb = ", ";
                        }
                        ?>
                        <?php echo $valu_detail[$i] . $symb; ?>
                        <?php
                    }
                    echo "</strong>";
                    echo ':';
                    echo "</span>";
                    for ($a = 0; $a < count($term_ids); $a++) {
                        $cat = get_term($term_ids[$a], 'ad_cats');
                        if ($type == 'search') {
                            $link = get_the_permalink($carspot_theme['sb_search_page']) . '?cat_id=' . $cat->term_id;
                        } else {
                            $link = get_term_link($cat->term_id);
                        }
                        ?>
                        <a href="<?php echo esc_attr($link); ?>"><span><?php echo esc_html($cat->name); ?></span></a>
                        <?php
                    }
                    ?>
            </div>
        </div>
        <div class="col-sm-4 col-md-4 col-xs-12 no-padding ad_dattime carspot-terms">
            <div class="terms-details">
                <span><strong><?php echo esc_html__('Date', 'carspot'); ?> </strong> :</span>
                <span><?php echo esc_html(get_the_date()); ?></span>
            </div>
        </div>
        <div class="col-sm-4 col-md-4 col-xs-12 no-padding ad_warranty  carspot-terms">
            <div class="terms-details">
                <span><strong><?php echo esc_html__('Warranty', 'carspot'); ?> </strong> :</span>
                <span><?php echo esc_html(get_post_meta($pid, '_carspot_ad_warranty', true)); ?></span>
            </div>
        </div>
        <?php
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
            print(carspotCustomFieldsHTML($pid));
        }
        if (carspot_display_adLocation($pid) != "") { ?>
            <div class="col-sm-12 col-md-12 col-xs-12 location-exit no-padding  carspot-terms">
                <div class="terms-details">
                    <span><strong><?php echo esc_html__("Location", 'carspot'); ?></strong> :</span>
                    <?php echo carspot_display_adLocation($pid); ?>
                </div>
            </div>
        <?php }
        ?>
    </div>
</div>