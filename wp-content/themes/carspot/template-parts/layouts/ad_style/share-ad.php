<?php
global $carspot_theme;
$pid = get_the_ID();
if ($carspot_theme['share_ads_on']) {
    $flip_it = 'text-left';
    if (is_rtl()) {
        $flip_it = 'text-right';
    }
    ?>
    <div class="modal fade share-ad" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content <?php echo esc_attr($flip_it); ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&#10005;</span><span
                                class="sr-only"><?php echo esc_html__('Close', 'carspot'); ?></span>
                    </button>
                    <h3 class="modal-title"><?php echo esc_html__('Share', 'carspot'); ?></h3>
                </div>
                <div class="modal-body <?php echo esc_attr($flip_it); ?>">
                    <div class="recent-ads">
                        <div class="recent-ads-list">
                            <div class="recent-ads-container">
                                <div class="recent-ads-list-image">
                                    <?php
                                    $media = carspot_fetch_listing_gallery($pid);
                                    $img = $carspot_theme['default_related_image']['url'];
                                    if (count((array)$media) > 0) {
                                        foreach ($media as $m) {
                                            $mid = '';
                                            if (isset($m->ID)) {
                                                $mid = $m->ID;
                                            } else {
                                                $mid = $m;
                                            }

                                            $image = wp_get_attachment_image_src($mid, 'carspot-ad-related');
                                            $img = isset($image[0]) ? $image[0] : '';
                                            break;
                                        }
                                        ?>
                                        <a href="javascript:void(0);" class="recent-ads-list-image-inner">
                                            <img src="<?php echo esc_url($img); ?>"
                                                 alt="<?php echo esc_attr(get_the_title()); ?>">
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="recent-ads-list-content">
                                    <h3 class="recent-ads-list-title">
                                        <a href="javascript:void(0);"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="recent-ads-list-price">
                                        <?php echo carspot_adPrice($pid); ?>
                                    </div>
                                    <p><?php echo carspot_words_count(get_the_excerpt(get_the_ID()), 250); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3><?php echo esc_html__('Link', 'carspot'); ?></h3>
                    <p><a href="javascript:void(0);"><?php the_permalink(); ?></a></p>
                </div>
                <div class="modal-footer">
                    <ul class="list-inline">
                        <?php echo carspot_social_share(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php }