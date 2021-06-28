(function($) {

    'use strict';

    wp.customize.bind('ready', function() {
        wp.customize.notifications.add(
            'nm-wpcustomizer-notice',
            new wp.customize.Notification(
                'nm-wpcustomizer-notice', {
                    dismissible: true,
                    message: nm_wpcustomizer_notice.notice,
                    type: 'warning'
                }
            )
        );
    });
})(jQuery);