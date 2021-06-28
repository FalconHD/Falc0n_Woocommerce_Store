(function($) {
    
	'use strict';
	
	$(function() { // Doc ready
        
        if (wp && wp.media) {
            var frame = null,
                $fieldWrap,
                $fieldImg,
                $fieldInput,   
                $fieldAddLink,
                $fieldRemoveLink;
            
            /* Field: Thumbnail - Add input tag */
            var thumbnailAddInputTag = function($fieldWrap, val) {
                // Adding input here to prevent PHP "max_input_vars" error when saving menu page (too many inputs can cause this error)
                var menuItemId = $fieldWrap.data('item-id');
                $fieldWrap.find('label').append('<input type="hidden" name="nm-menu-item-thumbnail['+menuItemId+']" value="'+val+'">');
            }
            
            /* Field: Thumbnail - Bind "Set thumbnail" link */
            $('#menu-to-edit').on('click', '.nm-menu-item-set-thumbnail', function(e) {
                e.preventDefault();
                
                $fieldWrap = $(this).closest('.nm-field-thumbnail');
                $fieldImg = $fieldWrap.find('img');
                $fieldInput = $fieldWrap.find('input');
                $fieldAddLink = $fieldWrap.find('.nm-menu-item-set-thumbnail');
                $fieldRemoveLink = $fieldWrap.find('.nm-menu-item-remove-thumbnail');
                
                // Code reference: https://codex.wordpress.org/Javascript_Reference/wp.media
                
                // If the media frame already exists, reopen it
                if (frame) {
                    frame.open();
                    return;
                }
                
                // Create a new media frame
                frame = wp.media({
                    title: 'Select Image',
                    button: {
                        text: 'Set image'
                    },
                    multiple: false // Set to true to allow multiple files to be selected
                });


                // When an image is selected in the media frame...
                frame.on('select', function() {
                    // Get media attachment details from the frame state
                    var attachment = frame.state().get('selection').first().toJSON();
                    
                    // Add wrapper class
                    $fieldWrap.addClass('has-thumbnail');
                    
                    // Toggle links
                    $fieldAddLink.addClass('hidden');
                    $fieldRemoveLink.removeClass('hidden');
                    
                    // Show thumbnail
                    $fieldImg.attr('src', attachment.url).removeClass('hidden');
                    
                    // Set input
                    if ($fieldInput.length) {
                        $fieldInput.val(attachment.id);
                    } else {
                        thumbnailAddInputTag($fieldWrap, attachment.id);
                    }
                });

                // Finally, open the modal on click
                frame.open();
            });
            
            
            /* Field: Thumbnail - Bind "Remove thumbnail" link */
            $('#menu-to-edit').on('click', '.nm-menu-item-remove-thumbnail', function(e) {
                e.preventDefault();
                
                $fieldWrap = $(this).closest('.nm-field-thumbnail');
                $fieldInput = $fieldWrap.find('input');
                $fieldAddLink = $fieldWrap.find('.nm-menu-item-set-thumbnail');
                $fieldRemoveLink = $(this);
                
                // Remove wrapper class
                $fieldWrap.removeClass('has-thumbnail');
                
                // Toggle links
                $fieldAddLink.removeClass('hidden');
                $fieldRemoveLink.addClass('hidden');

                // Hide thumbnail
                $fieldWrap.find('img').attr('src', '').addClass('hidden');

                // Clear input
                if ($fieldInput.length) {
                    $fieldInput.val('');
                } else {
                    thumbnailAddInputTag($fieldWrap, '');
                }
            });
        }
        
	});
})(jQuery);
