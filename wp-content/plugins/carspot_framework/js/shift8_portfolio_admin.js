 var meta_gallery_frame;

$('#dwt_listing_gallery_button').on('click', function(e){
                // sonu code here.
                if ( meta_gallery_frame ) {
                        meta_gallery_frame.open();
                        return;
                }
                // Sets up the media library frame
                meta_gallery_frame = wp.media.frames.meta_gallery_frame = wp.media({
                        title: 'this is my title',
                        button:'add gallery',
                        library: { type: 'image' },
						multiple: true
                });
				// Create Featured Gallery state. This is essentially the Gallery state, but selection behavior is altered.
				meta_gallery_frame.states.add([
					new wp.media.controller.Library({
						priority:   20,
						toolbar:    'main-gallery',
						filterable: 'uploaded',
						library:    wp.media.query( meta_gallery_frame.options.library ),
						multiple:   meta_gallery_frame.options.multiple ? 'reset' : false,
						editable:   true,
						allowLocalEdits: true,
						displaySettings: true,
						displayUserSettings: true
					}),
				]);
				var idsArray;
				var attachment;
				meta_gallery_frame.on('open', function() {
					var selection = meta_gallery_frame.state().get('selection');
					var library = meta_gallery_frame.state('gallery-edit').get('library');
					var ids = $('#dwt_listing_gall_idz').val();
					if (ids) {
						idsArray = ids.split(',');
						idsArray.forEach(function(id) {
							attachment = wp.media.attachment(id);
							attachment.fetch();
							selection.add( attachment ? [ attachment ] : [] );
						});
					}
				});
				meta_gallery_frame.on('ready', function() {
					$( '.media-modal' ).addClass( 'no-sidebar' );
				});
		 var images;
		// When an image is selected, run a callback.
		//meta_gallery_frame.on('update', function() {
		meta_gallery_frame.on('select', function() {
			var imageIDArray = [];
			var imageHTML = '';
			var metadataString = '';
			images = meta_gallery_frame.state().get('selection');
			imageHTML += '<ul class="dwt_listing_gallery">';
			images.each(function(attachment) {
				//sonu get image object
                console.debug(attachment.attributes);
				imageIDArray.push(attachment.attributes.id);
				imageHTML += '<li><div class="dwt_listing_gallery_container"><span class="dwt_listing_delete_icon"><img id="'+attachment.attributes.id+'" src="'+attachment.attributes.sizes.thumbnail.url+'"></span></div></li>';
			});
			imageHTML += '</ul>';
			metadataString = imageIDArray.join(",");
			if (metadataString) {
				$("#dwt_listing_gall_idz").val(metadataString);
				$("#dwt_listing_gall_render").html(imageHTML);
			}
		});
		 
		// Finally, open the modal
		meta_gallery_frame.open();
		
        });
        
        
        $(document.body).on('click', '.dwt_listing_delete_icon', function(event){
		event.preventDefault();
		if (confirm(admin_varible.img_del))
		{
			var removedImage = $(this).children('img').attr('id');
			var oldGallery = $("#dwt_listing_gall_idz").val();
			var newGallery = oldGallery.replace(','+removedImage,'').replace(removedImage+',','').replace(removedImage,'');
			//var newGallery = oldGallery.replace(','+removedImage,'');
			$(this).parents().eq(1).remove();
			$("#dwt_listing_gall_idz").val(newGallery);
		}
	});