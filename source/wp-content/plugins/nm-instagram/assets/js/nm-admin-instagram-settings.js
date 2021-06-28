(function($) {
	$(function() { // Doc ready
        // Handle returned token
		var url_hash = window.location.hash;
		if (url_hash.indexOf('access_token') > 0 && url_hash.indexOf('api_type') > 0) {

			var token = $('#nm-access-token'),
                user_id = $('#nm-user-id'),
                token_expires = $('#nm-token-expires-in'),
                api_type = $('#nm-api-type');
			
			var url_hash_arr = url_hash.split('&');

			url_hash_arr.forEach(function(param) {
                
				switch (param.split('=').shift()) {

					case '#access_token':
						token.val(param.split('=').pop());
						break;

					case 'expires_in':
						var expires_in_time = parseInt(param.split('=').pop()) + parseInt(Math.floor(Date.now() / 1000));
						token_expires.val(expires_in_time);
						break;

					case 'user_id':
						user_id.val(param.split('=').pop());
						break;

					case 'api_type':
						api_type.val(param.split('=').pop());
						break;
				
					default:
						break;
				}
			});

			if (url_hash.indexOf('expires_in') == -1) {
				var expires_in = parseInt(86400 * 60) + parseInt(Math.floor(Date.now() / 1000));
				token_expires.val(expires_in);
				console.log('not find expires_in in URL');
			}

			token.parents('form').find('#submit').click();
		}
	});
})(jQuery);