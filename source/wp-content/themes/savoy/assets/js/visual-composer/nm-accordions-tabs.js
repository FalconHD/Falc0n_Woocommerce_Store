(function($) {
	
	'use strict';
	
	$(function() { // Doc ready
        
        // Note: loading tabs from a URL #hash is not really possible since the accordion/tab-containers use id's with the same values (the content "jumps" to the container and breaks the layout)
        
        /* Accordions */
        var $accordions = $('.vc_tta-accordion').children('.vc_tta-panels-container').children('.vc_tta-panels'),
            $accordionLinks = $accordions.children('.vc_tta-panel').children('.vc_tta-panel-heading').find('a'),
            $accordion,
            $accordionActive,
            $accordionContent,
            $accordionContentActive,
            animating = false,
            accordionIsActive;
        
        $accordionLinks.on('click', function(e) {
            e.preventDefault();
            
            // Make sure sliding animation is complete
            if (animating) { return false; }
            animating = true;
            
            $accordion = $(this);
            $accordionContent = $($accordion.attr('href'));
            accordionIsActive = ($accordionContent.hasClass('vc_active')) ? true : false;
            
            if (accordionIsActive) {
                // Make sure it's allowed to toggle the active accordion
                if (!$accordionContent.parents('.vc_tta-o-all-clickable').length) {
                    animating = false;
                    return false;
                }
            } else {
                $accordionActive = $accordion.parents('.vc_tta-panels').children('.vc_active').children('.vc_tta-panel-heading').find('a');
                $accordionContentActive = $($accordionActive.attr('href'));
            }
            
            // Hide/show current container (toggle if active)
            $accordionContent.children('.vc_tta-panel-body').slideToggle(200, function() {
                $accordionContent.toggleClass('vc_active');
                animating = false;
            });
            
            // Hide active container
            if (!accordionIsActive) {
                $accordionContentActive.children('.vc_tta-panel-body').slideUp(200, function() {
                    $accordionContentActive.removeClass('vc_active');
                    animating = false;
                });
            }
        });
        
        
        /* Tabs */
        var $tabs = $('.vc_tta-tabs-list'),
            $tabLinks = $tabs.find('a'),
            $tab,
            $tabActive;
        
        $tabLinks.on('click', function(e) {
            e.preventDefault();
            
            $tab = $(this);
            $tabActive = $tab.parents('.vc_tta-tabs-list').children('.vc_active').children('a');
            
            // Change tab "active" class
            $tabActive.parent().removeClass('vc_active');
            $tab.parent().addClass('vc_active');
            
            // Change content "active" class
            $($tabActive.attr('href')).removeClass('vc_active');
            $($tab.attr('href')).addClass('vc_active');
        });
        
        
        /* Accordions/Tabs: Check for "active" accordion/tab #hash in page URL */
        if (window.location.hash) {
            var urlHash = window.location.hash;
            
            var $accordionPanel = $accordions.children(urlHash);
            if ($accordionPanel.length) {
                $accordionPanel.children('.vc_tta-panel-heading').find('a').trigger('click');
            }
            
            var $tabLink = $tabs.find('a[href='+urlHash+']');
            if ($tabLink.length) {
                $tabLink.trigger('click');
            }
        }
        
    });
    
})(jQuery);
