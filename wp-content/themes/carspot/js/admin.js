(function($) {
    "use strict";

	// verifying Purchase code...
	$('#verify_it').on('click', function()
	{
		var purchase_code	=	document.getElementById('carspot_code').value;
		if( purchase_code != "" )
		{
			$.post(ajaxurl,	{action : 'verify_code' , code:purchase_code}).done( function(response) 
			{
			$('#carspot_code').val('');
			if( $.trim(response) == 'Looks good, now you can install required plugins.' )
			{
				alert( response );
				location.reload();
				
			}
			else
			{
				alert( response );	
			}
			});
		}
	});
	
})(jQuery);

