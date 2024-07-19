<?php
global $carspot_theme;
$current_user_id = get_current_user_id();
$user_pic = carspot_get_dealer_logo($current_user_id);
$store_pic = carspot_get_dealer_store_front($current_user_id);
$current_user = wp_get_current_user();
$user_meta = '';
$user_meta = get_user_meta($current_user_id);
?>

<div class="container-fluid">
    <!-- OVERVIEW -->
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="panel  panel-headline">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo esc_html__('My Messages ', 'carspot'); ?></h3>
                    <p class="panel-subtitle"><?php echo esc_html__('Last logged in ', 'carspot');
                        echo carspot_get_last_login($current_user_id);
                        echo esc_html__(' Ago', 'carspot'); ?></p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <div class="edit-profile-form dealers-review-section">
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                                        <a href="javascript:void(0)" hidden="hidden" class="get_msgs_auto"
                                           sb_action="my_msgs"> click</a>
                                        <div id="carspot_res">
                                        </div>
                                        <?php
                                        if (isset($_GET['sb_action']) && isset($_GET['ad_id']) && isset($_GET['uid']) && $_GET['sb_action'] == 'sb_load_messages') {
                                            ?>
                                            <form>
                                                <input type="hidden" id="current_action" name="current_action"
                                                       value="<?php echo esc_attr($_GET['sb_action']); ?>"/>
                                                <input type="hidden" id="current_ad" name="current_ad"
                                                       value="<?php echo esc_attr($_GET['ad_id']); ?>"/>
                                                <input type="hidden" id="second_user" name="second_user"
                                                       value="<?php echo esc_attr($_GET['uid']); ?>"/>
                                            </form>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>