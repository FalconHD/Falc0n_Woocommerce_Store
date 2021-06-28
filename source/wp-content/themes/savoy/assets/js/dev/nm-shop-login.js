(function($) {
	
	'use strict';
	
    $.nmReady(function() {
		
		var animTimeout = 250;
		
		/* Show register form */
		function showRegisterForm() {
			// Form wrapper elements
			var $loginWrap = $('#nm-login-wrap'),
				$registerWrap = $('#nm-register-wrap');
			
			// Login/register form
			$loginWrap.removeClass('fade-in');
			setTimeout(function() {
				$registerWrap.addClass('inline fade-in slide-up');
				$loginWrap.removeClass('inline slide-up');
			}, animTimeout);
		};
        
		/* Show login form */
		function showLoginForm() {
			// Form wrapper elements
			var $loginWrap = $('#nm-login-wrap'),
				$registerWrap = $('#nm-register-wrap');
			
			// Login/register form
			$registerWrap.removeClass('fade-in');
			setTimeout(function() {
				$loginWrap.addClass('inline fade-in slide-up');
				$registerWrap.removeClass('inline slide-up');
			}, animTimeout);
		};
		
		/* Bind: Show register form button */
		$('#nm-show-register-button').on('click', function(e) {
			e.preventDefault();
			showRegisterForm();
		});
		
		/* Bind: Show login form button */
		$('#nm-show-login-button').on('click', function(e) {
			e.preventDefault();
			showLoginForm();
		});
        
        // Show register form if "#register" is added to URL
        if (window.location.hash && window.location.hash == '#register') {
            showRegisterForm();
        }
		
	});
})(jQuery);
