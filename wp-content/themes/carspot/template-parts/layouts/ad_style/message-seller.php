<?php
global $carspot_theme;
$pid       = get_the_ID();
$poster_id = get_post_field( 'post_author', $pid );
//this work for message customization but we are not work on it 5-Nov-2020
//if ( isset( $carspot_theme['cs_mesging_opt'] ) && $carspot_theme['cs_mesging_opt'] == 'btwn_admin' ) {
//	$poster_id = 1;
//}

$user_info = get_userdata( get_current_user_id() );
if ( $user_info != "" ) {
	?>
    <div class="modal fade price-quote" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&#10005;</span><span class="sr-only">Close</span></button>
                    <h3 class="modal-title" id="lineModalLabel"><?php the_title(); ?></h3>
                </div>
                <div class="modal-body">
                    <form id="send_message_pop">
                        <div class="form-group  col-md-12  col-sm-12">
                            <label><?php echo esc_html__( 'Your Name', 'carspot' ); ?></label>
                            <input type="text" name="name" readonly class="form-control"
                                   value="<?php echo esc_attr( $user_info->display_name ); ?>">
                        </div>
                        <div class="form-group  col-md-12  col-sm-12">
                            <label><?php echo esc_html__( 'Email Address', 'carspot' ); ?></label>
                            <input type="email" name="email" readonly class="form-control"
                                   value="<?php echo esc_attr( $user_info->user_email ); ?>">
                        </div>
                        <div class="form-group  col-md-12  col-sm-12">
                            <label><?php echo esc_html__( 'Message', 'carspot' ); ?></label>
                            <textarea id="sb_forest_message" name="message"
                                      placeholder="<?php echo esc_html__( 'Type here...', 'carspot' ); ?>" rows="3"
                                      class="form-control" data-parsley-required="true"
                                      data-parsley-error-message="<?php echo esc_html__( 'This field is required.', 'carspot' ); ?>"></textarea>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12  col-sm-12 margin-bottom-20 margin-top-20">
                            <input type="hidden" name="ad_post_id" value="<?php echo esc_attr( $pid ); ?>"/>
                            <input type="hidden" name="usr_id"
                                   value="<?php echo esc_attr( get_current_user_id() ); ?>"/>
                            <input type="hidden" name="msg_receiver_id" value="<?php echo ( $poster_id ); ?>"/>
                            <input type="hidden" id="message_nonce"
                                   value="<?php echo wp_create_nonce( 'carspot_message_secure' ); ?>"/>
                            <button type="submit" id="send_ad_message"
                                    class="btn btn-theme btn-block"><?php echo esc_html__( 'Submit', 'carspot' ); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
	<?php
}
?>
