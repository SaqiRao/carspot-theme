<?php global $carspot_theme;
$class = '';
if (isset($carspot_theme['footer_type']) && $carspot_theme['footer_type'] != "") {
    $class = $carspot_theme['footer_type'];
}
?>
<footer class="footer-bg <?php echo esc_attr($class); ?>">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-3  col-sm-6 col-xs-12">
                    <div class="widget">
                        <div class="logo">
                            <a href="<?php echo home_url('/'); ?>">
                                <?php
                                if (isset($carspot_theme['footer_logo']['url']) && $carspot_theme['footer_logo']['url'] != "") {
                                    ?>
                                    <img src="<?php echo esc_url($carspot_theme['footer_logo']['url']); ?>"
                                         class="img-responsive" alt="<?php echo esc_html__('Site Logo', 'carspot'); ?>">
                                    <?php
                                } else {
                                    ?>
                                    <img src="<?php echo esc_url(trailingslashit(get_template_directory_uri())) . 'images/logo.png' ?>"
                                         class="img-responsive" alt="<?php echo esc_html__('Logo', 'carspot'); ?>"/>
                                    <?php
                                }
                                ?>
                            </a>
                        </div>
                        <p><?php echo esc_html($carspot_theme['footer_text_under_logo']); ?></p>
                        <ul class="apps-donwloads">
                            <?php
                            if (isset($carspot_theme['footer_android_app']) && $carspot_theme['footer_android_app'] != "") {
                                echo '<li><a href="' . esc_url($carspot_theme['footer_android_app']) . '"><img src="' . esc_url(trailingslashit(get_template_directory_uri())) . 'images/googleplay.png" alt="' . esc_html__('Android App', 'carspot') . '"></a></li>';
                            }
                            if (isset($carspot_theme['footer_ios_app']) && $carspot_theme['footer_ios_app'] != "") {
                                echo '<li><a href="' . esc_url($carspot_theme['footer_ios_app']) . '"><img src="' . esc_url(trailingslashit(get_template_directory_uri())) . 'images/appstore.png" alt="' . esc_html__('IOS App', 'carspot') . '"></a></li>';
                            }

                            ?>

                        </ul>
                    </div>
                </div>
                <?php
                if (isset($carspot_theme['section_2_title']) && $carspot_theme['section_2_title'] != "") {
                    ?>
                    <div class="col-md-2  col-sm-6 col-xs-12">
                        <div class="widget socail-icons">

                            <h5><?php echo esc_html($carspot_theme['section_2_title']); ?></h5>
                            <ul>
                                <?php
                                if (isset($carspot_theme['social_media']) && $carspot_theme['social_media'] != "") {
                                    foreach ($carspot_theme['social_media'] as $index => $val) {
                                        ?>
                                        <?php
                                        if ($val != "") {
                                            ?>
                                            <li>
                                                <a class="<?php echo esc_attr($index); ?>"
                                                   href="<?php echo esc_url($val); ?>">
                                                    <i class="<?php echo carspot_social_icons($index); ?>"></i>
                                                </a><span><a
                                                            href="<?php echo esc_url($val); ?>"><?php echo esc_html__($index,'carspot'); ?></a></span>
                                            </li>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>


                <?php
                if (isset($carspot_theme['section_4_title']) && $carspot_theme['section_4_title'] != "") {
                    ?>
                    <div class="col-md-2  col-sm-6 col-xs-12">

                        <div class="widget my-quicklinks">
                            <h5><?php echo esc_html($carspot_theme['section_4_title']); ?></h5>
                            <ul>
                                <?php
                                if (isset($carspot_theme['sb_footer_links'])) {
                                    foreach ($carspot_theme['sb_footer_links'] as $foot_page) {

                                        echo '<li><a href="' . esc_url(get_the_permalink($foot_page)) . '">' . esc_html(get_the_title($foot_page)) . '</a></li>';
                                    }

                                }
                                ?>
                            </ul>
                        </div>

                    </div>
                <?php } ?>

                <?php
                if (isset($carspot_theme['section_3_title']) && $carspot_theme['section_3_title'] != "") {
                    ?>
                    <div class="col-md-5  col-sm-6 col-xs-12">
                        <div class="widget widget-newsletter">
                            <h5><?php echo esc_html($carspot_theme['section_3_title']); ?></h5>
                            <div class="fieldset">
                                <p><?php echo esc_html($carspot_theme['section_3_text']); ?></p>
                                <?php
                                if (isset($carspot_theme['section_3_mc']) && $carspot_theme['section_3_mc']) {
                                    ?>
                                    <form onSubmit="return checkVals();">
                                        <input name="sb_email" id="sb_email"
                                               placeholder="<?php echo esc_html__('Enter your email address', 'carspot'); ?>"
                                               type="text" autocomplete="off" required>
                                        <input class="submit-btn" id="save_email"
                                               value="<?php echo esc_html__('Submit', 'carspot'); ?>" type="button">
                                        <input class="submit-btn no-display" id="processing_req"
                                               value="<?php echo esc_html__('Processing...', 'carspot'); ?>"
                                               type="button">
                                        <input type="hidden" id="sb_action" value="footer_action"/>
                                    </form>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="copyright">
                            <?php
                            if (isset($carspot_theme['sb_footer']) && $carspot_theme['sb_footer'] != "") {
                                echo wp_kses($carspot_theme['sb_footer'], carspot_required_tags());
                            }
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <?php
                if (isset($carspot_theme['sb_footer']) && $carspot_theme['sb_footer'] != "") {
                } else {
                    ?>
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="copyrights">
                            <?php
                            echo wp_kses("Copyright 2017 &copy; Theme Created By <a href='https://themeforest.net/user/scriptsbundle/portfolio'>ScriptsBundle</a> All Rights Reserved.", carspot_required_tags());

                            ?>

                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</footer>	