<?php 
add_action( 'show_user_profile', 'sb_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'sb_show_extra_profile_fields' );
 
function sb_show_extra_profile_fields( $user ) { ?>
 
    <h3><?php echo __('Package Information','redux-framework'); ?></h3>
 
    <table class="form-table">
 
        
        <tr>
            <th><label for="_sb_simple_ads"><?php echo __('Ads Remaining','redux-framework'); ?></label></th>
 
            <td>
                <input type="text" name="_sb_simple_ads" id="_sb_simple_ads" value="<?php echo esc_attr( get_the_author_meta( '_sb_simple_ads', $user->ID ) ); ?>" class="regular-text" /><br />
                <p><?php echo __('-1 means unlimited.','redux-framework'); ?>
            </td>
        </tr>
        
                <tr>
            <th><label for="_carspot_featured_ads"><?php echo __('Featured Ads Remaining','redux-framework'); ?></label></th>
 			<?php 
			$featured_ads	=	  get_the_author_meta( '_carspot_featured_ads', $user->ID );
			if( $featured_ads == "" )
			{
				$featured_ads	=	0;		
			}
			?>
            <td>
                <input type="text" name="_carspot_featured_ads" id="_carspot_featured_ads" value="<?php echo esc_attr( $featured_ads ); ?>" class="regular-text" /><br />
                <p><?php echo __('-1 means unlimited.','redux-framework'); ?>
            </td>
        </tr>
        <tr>
            <th><label for="_carspot_bump_ads"><?php echo __('Bump up Ads Remaining','redux-framework'); ?></label></th>
 			<?php 
			$bump_ads	=	  get_the_author_meta( '_carspot_bump_ads', $user->ID );
			if( $bump_ads == "" )
			{
				$bump_ads	=	0;		
			}
			?>
            <td>
                <input type="text" name="_carspot_bump_ads" id="_carspot_bump_ads" value="<?php echo esc_attr( $bump_ads ); ?>" class="regular-text" /><br />
                <p><?php echo __('-1 means unlimited.','redux-framework'); ?></p>
            </td>
        </tr>
        
        <tr>
            <th><label for="_carspot_expire_ads"><?php echo __('Expiry Date','redux-framework'); ?></label></th>
 
            <td>
                <input type="text" name="_carspot_expire_ads" id="_carspot_expire_ads" value="<?php echo esc_attr( get_the_author_meta( '_carspot_expire_ads', $user->ID ) ); ?>" class="regular-text" /><br />
                <p><?php echo __('-1 means never expired or date format will be yyyy-mm-dd.','redux-framework'); ?>
            </td>
        </tr>

        
        
        <tr>
            <th><label for="_sb_badge_type"><?php echo __('Badge Color','redux-framework'); ?></label></th>
 
            <td>
                <select name="_sb_badge_type" id="_sb_badge_type">
                	<option value=""><?php echo __('Select Type','redux-framework'); ?></option>
                	<option value="label-success" <?php if( get_the_author_meta( '_sb_badge_type', $user->ID ) == "label-success" ) echo "selected"; ?>><?php echo __('Green','redux-framework'); ?></option>
                	<option value="label-warning" <?php if( get_the_author_meta( '_sb_badge_type', $user->ID ) == "label-warning" ) echo "selected"; ?>><?php echo __('Orange','redux-framework'); ?></option>
                	<option value="label-info" <?php if( get_the_author_meta( '_sb_badge_type', $user->ID ) == "label-info" ) echo "selected"; ?>><?php echo __('Blue','redux-framework'); ?></option>
                	<option value="label-danger" <?php if( get_the_author_meta( '_sb_badge_type', $user->ID ) == "label-danger" ) echo "selected"; ?>><?php echo __('Red','redux-framework'); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="_sb_badge_text"><?php echo __('Badge Text','redux-framework'); ?></label></th>
            <td>
                <input type="text" name="_sb_badge_text" id="_sb_badge_text" value="<?php echo esc_attr( get_the_author_meta( '_sb_badge_text', $user->ID ) ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="_sb_user_type"><?php echo __('Select User Type','redux-framework'); ?></label></th>
 
            <td>
                <select name="_sb_user_type" id="_sb_user_type">
                	<option value=""><?php echo __('Select User Type','redux-framework'); ?></option>
                	<option value="individual" <?php if( get_the_author_meta( '_sb_user_type', $user->ID ) == "individual" ) echo "selected='selected'"; ?>><?php echo __('Individual','redux-framework'); ?></option>
                	<option value="dealer" <?php if( get_the_author_meta( '_sb_user_type', $user->ID ) == "dealer" ) echo "selected='selected'"; ?>><?php echo __('Dealer','redux-framework'); ?></option>
                </select>
            </td>
        </tr>
 
    </table>
<?php }

add_action( 'personal_options_update', 'sb_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'sb_save_extra_profile_fields' );
 
function sb_save_extra_profile_fields( $user_id ) {
 
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
 
    /* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
    update_usermeta( absint( $user_id ), '_sb_simple_ads', wp_kses_post( $_POST['_sb_simple_ads'] ) );
    update_usermeta( absint( $user_id ), '_carspot_featured_ads', wp_kses_post( $_POST['_carspot_featured_ads'] ) );
    update_usermeta( absint( $user_id ), '_carspot_bump_ads', wp_kses_post( $_POST['_carspot_bump_ads'] ) );
    update_usermeta( absint( $user_id ), '_carspot_expire_ads', wp_kses_post( $_POST['_carspot_expire_ads'] ) );
    update_usermeta( absint( $user_id ), '_sb_badge_type', wp_kses_post( $_POST['_sb_badge_type'] ) );
    update_usermeta( absint( $user_id ), '_sb_badge_text', wp_kses_post( $_POST['_sb_badge_text'] ) );
    update_usermeta( absint( $user_id ), '_sb_user_type', wp_kses_post( $_POST['_sb_user_type'] ) );
}