/**
 *	Show/hide form sections
 */
 (function($){
 	function handle_template_change() {
 		var fadeInTemplate = $('#page_template').val();

 		$('#wpbody').find('[data-template]').each(function (i,e) {
 			var fadeOutId = '#' + $(e).data('parent'),
 				fadeOutTemplate = $(e).data('template');
			if (fadeInTemplate !== fadeOutTemplate) {
	 			$(fadeOutId).fadeOut();
	 		} else {
 				$(fadeOutId).fadeIn();
	 		}
 		});
 	}

 	$('#wpbody').on('change', '#page_template', handle_template_change);
 	handle_template_change();

 })(jQuery);


/**
 *	Media Selector
 */
 (function($){
 	var file_frame;

	//
	// Allow single or multiple select
	//
	$('#wpbody').on('blur change', '.js-sc-gallery-source', function(event) {
		event.preventDefault;

		if ($(this).val() >= 0) {
			$('[data-media-selector]').parent().slideUp();
		} else {
			$('[data-media-selector]').parent().slideDown();
		}
	});

	$('#wpbody').on('click', '[data-media-selector], [data-media-preview]', function( event ){
		event.preventDefault();

		var $choose_trigger = $(this),
			$choose_image = $(this).is('img') ? $(this) : $(this).siblings('[data-media-preview]'),
			$value_field = $choose_trigger.siblings('[data-media-target]'),
			multiple_select = $value_field.is('[data-media-multiple]');

	    // If the media frame already exists, reopen it.
	    if ( typeof file_frame === 'undefined' ) {
		    // Create the media frame.
		    file_frame = wp.media.frames.file_frame = wp.media({
		    	title: 'Choose Gallery Images',
		    	button: {
		    		text: 'Done'
		    	},
		    	multiple: multiple_select
		    });
		}

	    // When an image is selected, run a callback.
	    file_frame.off('select').on( 'select', function() {
			// We set multiple to false so only get one image from the uploader
			var attachment = file_frame.state().get('selection').toJSON();

			if (attachment.length > 0) {
				$choose_image.attr('src', attachment[0].url);
			}

			// Do something with attachment.id and/or attachment.url here
			var image_ids = '';
			$.each(attachment, function(k, v) { image_ids += v.id + ',' });
			image_ids = image_ids.substring(0, image_ids.length - 1);
			$value_field.val(image_ids);

			var count = $value_field.siblings('.js-sc-count');
			count.text(count.text() + '*');
		});

	    file_frame.off('open').on('open',function() {
	    	var selection = file_frame.state().get('selection');
	    	selection.reset();
	    	ids = $value_field.val().split(',');
	    	$.each(ids, function(k, v) {
	    		attachment = wp.media.attachment(v);
	    		attachment.fetch();
	    		selection.add( attachment ? [ attachment ] : [] );
	    	});
	    });

	    // Finally, open the modal
	    file_frame.open();
	});
})(jQuery);