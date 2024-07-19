<?php
global $carspot_theme;
$pid = get_the_ID();

//Car Features
$adfeatures = get_post_meta($pid, '_carspot_ad_features', true);
if (isset($adfeatures) && $adfeatures != "") {
    $features = explode('|', $adfeatures);
    if (count((array)$features) > 0) {
        ?>

        <div class="car-features">
            <h3><?php echo esc_html__('Car Features', 'carspot'); ?></h3>
            <ul>
                <?php
                foreach ($features as $feature) {
                    $tax_feature = get_term_by('name', $feature, 'ad_features');
                    $icon = '';
                    $icon_html = '';
                    if ($tax_feature == true) {
                        $cat_meta = get_option("taxonomy_term_$tax_feature->term_id");
                        if ($cat_meta != '') {
                            if (isset($cat_meta)) {
                                $icon = $cat_meta['ad_feature_icon'];
                            }
                        }
                        if ($icon != "") {
                            $icon_html = '<i class="' . esc_attr($icon) . '"></i>';
                        }
                    }
                    ?>
                    <li>
                        <div class="ftd-item"> <?php
                            echo($icon_html);
                            echo " <span>" . esc_html($feature) . "</span>";
                            ?></div>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <?php
    }
}
?>

<?php
$posttags = get_the_terms(get_the_ID(), 'ad_tags');
$count = 0;
$tags = '';
if ($posttags) {
    $flip_it = '';
    if (is_rtl()) {
        $flip_it = 'flip';
    }
    ?>
    <div class="other-links">
        <ul>
            <li>
                                <span class="iconify" data-icon="whh:bookmarkfour" data-rotate="270deg"
                                      data-flip="horizontal"></span>
            </li>
            <?php foreach ($posttags as $tag) { ?>
                <li>
                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
                       title="<?php echo esc_attr($tag->name); ?>">
                        #<?php echo esc_attr($tag->name); ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>