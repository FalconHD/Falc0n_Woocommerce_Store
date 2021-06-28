<?php nm_add_page_include( 'login-popup' ); ?>
<div id="nm-login-popup-wrap" class="nm-login-popup-wrap mfp-hide">
    <?php wc_get_template( 'myaccount/form-login.php', array( 'is_popup' => true ) ); ?>
</div>