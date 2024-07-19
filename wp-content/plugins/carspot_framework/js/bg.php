<?php 
function sb_load_bread_bg() {
	global $carspot_theme; 
?>


    <?php
}
add_action( 'wp_head', 'sb_load_bread_bg' , "100" );
function sb_load_custom_js()
{
?>
<script type="text/javascript">
 (function($) {
	"use strict";
// Adding email in mailchimp

	$('#processing_req').hide();
	$('#save_email').on('click', function()
	{
		var sb_email	=	$('#sb_email').val();
		var sb_action 	=	$('#sb_action').val();
		if( carspot_validateEmail( sb_email ) )
		{
			$('#save_email').hide();
			$('#processing_req').show();
			$.post('<?php echo admin_url('admin-ajax.php'); ?>',
				{action : 'sb_mailchimp_subcribe' , sb_email:sb_email, sb_action:sb_action }).done(function(response) 
				{
					$('#processing_req').hide();
					$('#save_email').show();
					if( response == 1 )
					{
						toastr.success('<?php echo carspot_translate( 'mc_success_msg' ); ?>', '<?php echo carspot_translate( 'cart_success' ); ?>!', {timeOut: 2500,"closeButton": true, "positionClass": "toast-bottom-right"});
						$('#sb_email').val('');
					}
					else
					{
						toastr.error('<?php echo carspot_translate( 'mc_error_msg' ); ?>', '<?php echo carspot_translate( 'cart_error' ); ?>!', {timeOut: 2500,"closeButton": true, "positionClass": "toast-bottom-right"});
					}
				});
		}
		else
		{
			toastr.error('<?php echo carspot_translate( 'email_error_msg' ); ?>', '<?php echo carspot_translate( 'cart_error' ); ?>!', {timeOut: 2500,"closeButton": true, "positionClass": "toast-bottom-right"});
		}
	});

		
})( jQuery );
function checkVals()
{
	return false;	
}
	
</script>
<?php	
}
add_action( 'wp_footer', 'sb_load_custom_js' , "100" );

?>