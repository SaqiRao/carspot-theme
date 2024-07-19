<?php
global $carspot_theme;
$pid = get_the_ID();
?>
<?php
if (isset($carspot_theme['single_ad_style']) && $carspot_theme['single_ad_style'] == '2') {
    if (isset($carspot_theme['share_ads_on']) && $carspot_theme['share_ads_on'] != "") {
        ?>
        <li>
            <a href="javascript:void(0);" data-toggle="modal" data-target=".share-ad" class="btn btn-primary"> 
                <i class="la la-share"></i>
                <?php echo esc_html__('Share', 'carspot'); ?>
            </a>
        </li>
        <?php
        get_template_part('template-parts/layouts/ad_style/share', 'ad');
    }
    ?>
    <li><a href="javascript:void(0);"  data-target=".report-quote" data-toggle="modal"  class="btn btn-success"><i class="la la-warning"></i><?php echo esc_html__('Report', 'carspot'); ?></a></li>
    <li><a href="javascript:void(0);" id="ad_to_fav" data-adid="<?php echo esc_attr(get_the_ID()); ?>" class="btn btn-info"><i class="la la-heart-o"></i><?php echo esc_html__('Favourite', 'carspot'); ?></a></li>
    <input type="hidden" id="fav_ad_nonce" value="<?php echo wp_create_nonce('carspot_fav_ad_secure') ?>"  />
    <?php
} else {
    ?>
    <div class="ad-share text-center">
        <?php
        if (isset($carspot_theme['share_ads_on']) && $carspot_theme['share_ads_on'] != "") {
            ?>
            <div data-toggle="modal" data-target=".share-ad" class="small-box col-md-4 col-sm-4 col-xs-12">
                <i class="fa fa-share-alt"></i> <span class="hidetext"><?php echo esc_html__('Share', 'carspot'); ?></span>
            </div>
            <?php
            get_template_part('template-parts/layouts/ad_style/share', 'ad');
        }
        ?>
        <a class="small-box col-md-4 col-sm-4 col-xs-12" href="javascript:void(0);" id="ad_to_fav" data-adid="<?php echo esc_attr(get_the_ID()); ?>">
            <input type="hidden" id="fav_ad_nonce" value="<?php echo wp_create_nonce('carspot_fav_ad_secure') ?>"  />
            <i class="fa fa-heart-o active"></i> 
            <span class="hidetext">
                <?php echo esc_html__('Add to Favourites', 'carspot'); ?>
            </span>
        </a>
        <div data-target=".report-quote" data-toggle="modal" class="small-box col-md-4 col-sm-4 col-xs-12">
            <i class="fa fa-warning"></i>
            <span class="hidetext"><?php echo esc_html__('Report', 'carspot'); ?></span>
        </div>
    </div>
<?php } ?>

<div class="modal fade report-quote" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&#10005;</span><span class="sr-only"><?php echo esc_html__('Close', 'carspot'); ?></span></button>
                <h3 class="modal-title"><?php echo esc_html__('Why are you reporting this ad?', 'carspot'); ?></h3>
            </div>
            <div class="modal-body">
                <!-- content goes here -->
                <form>
                    <div class="skin-minimal">
                        <div class="form-group col-md-12 col-sm-12">
                            <ul class="list">
                                <li >
                                    <select class="alerts" id="report_option">
                                        <?php
                                        $options = explode('|', $carspot_theme['report_options']);
                                        foreach ($options as $option) {
                                            ?>
                                            <option value="<?php echo esc_attr($option); ?>"><?php echo esc_html($option); ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group  col-md-12 col-sm-12">
                        <label></label>
                        <textarea placeholder="<?php echo esc_html__('Write your comments.', 'carspot'); ?>" rows="3" class="form-control" id="report_comments"></textarea>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12 col-sm-12 margin-bottom-20 margin-top-20">
                        <input type="hidden" id="ad_id" value="<?php echo esc_attr($pid); ?>" />
                        <button type="button" class="btn btn-theme btn-block" id="sb_mark_it"><?php echo esc_html__('Submit', 'carspot'); ?></button>
                        <input type="hidden" id="report_ad_nonce" value="<?php echo wp_create_nonce('carspot_report_secure') ?>"  />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

