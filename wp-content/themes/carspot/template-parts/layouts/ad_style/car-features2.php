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
        <div class="heading-panel">
            <h3 class="main-title text-left">
                <?php echo esc_html__('Car Features', 'carspot'); ?>
            </h3>
        </div>
        <div class="short-feature-body">
            <ul class="car-feature-list clearfix">
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
                    <li> <?php
                        echo( $icon_html );
                        echo esc_html($feature);
                        ?></li>
                    <?php
                }
                ?>
            </ul>
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
                <div class="tags-share clearfix margin-top-20">
                    <div class="tags pull-left <?php echo esc_attr($flip_it); ?>">
                        <i class="fa fa-tags"></i>
                        <ul>
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
                </div>
            <?php } ?>
        </div>
        <?php
    }
}
?>
                      