<?php

	/* Visual Composer: Initialize
	================================================== */
	
	if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
        
		if ( is_admin() ) {
			// Include external elements
			function nm_post_types_vc_register_elements() {
				include( NM_TEAM_DIR . 'visual-composer/elements/team.php' );
			}
			add_action( 'vc_build_admin_page', 'nm_post_types_vc_register_elements' ); // Note: Using the "vc_build_admin_page" action so external elements are added before default WooCommerce elements
		}
		
	}
