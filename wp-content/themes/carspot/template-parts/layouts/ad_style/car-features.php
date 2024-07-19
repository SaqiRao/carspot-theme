<?php
global $carspot_theme;
$pid = get_the_ID();
?>
<?php
//Car Features
$adfeatures = get_post_meta($pid, '_carspot_ad_features', true);
if (isset($adfeatures) && $adfeatures != "") {
    $features = explode('|', $adfeatures);
    if (count((array) $features) > 0) {
        ?>
        <!-- Heading Area -->
        <div class="heading-panel margin-top-20">
            <h3 class="main-title text-left">
                <?php echo esc_html__('Car Features', 'carspot'); ?>
            </h3>
        </div>
        <ul class="car-feature-list ">
            <?php
            foreach ($features as $feature) {
                $tax_feature = get_term_by('name', $feature, 'ad_features'); 
                $icon = '';
                $icon_html = '';
                if ($tax_feature == true && $tax_feature != '') {
                    $cat_meta = get_option("taxonomy_term_$tax_feature->term_id");
                    if ($cat_meta != '') {
                        $icon = $cat_meta['ad_feature_icon'];
                        if ($icon != "") {
                            $icon_html = '<i class="' . esc_attr($icon) . '"></i>';
                        }
                    }
                }
                ?>
                <li> <?php
                    echo($icon_html);
                    echo esc_html($feature);
                    ?></li>
                <?php
            }
            ?>
        </ul>   
        <?php
    }
}                