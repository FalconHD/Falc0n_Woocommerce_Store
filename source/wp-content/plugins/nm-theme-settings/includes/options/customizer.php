<?php
/*
 *	NM: Redux framework - WP Customizer
 */

function nm_redux_customizer_fields() {
    if ( class_exists( 'Redux_Customizer_Control' ) && ! class_exists( 'Redux_Customizer_Control_info' ) ) {
        // Add "Info" field - Code from "../includes/options/ReduxCore/inc/extensions/customizer/inc/customizer_fields.php" file
        class Redux_Customizer_Control_info extends Redux_Customizer_Control {
            public $type = "redux-info";
        }
    }
}
// Action placed in "../includes/options/ReduxCore/inc/extensions/customizer/extension_customizer.php" file
add_action( 'redux/extension/customizer/control/includes', 'nm_redux_customizer_fields' );
