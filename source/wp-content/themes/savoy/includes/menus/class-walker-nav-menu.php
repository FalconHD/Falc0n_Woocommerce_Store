<?php
    /*
     * Menus class: Add custom menu markup
     * 
     * The extended "Walker_Nav_Menu" class is placed in: "../wp-includes/class-walker-nav-menu.php"
     */
    class NM_Sublevel_Walker extends Walker_Nav_Menu {
        /* Starts the list before the elements are added */
        function start_lvl( &$output, $depth = 0, $args = array() ) {
            $bridge_element = ( $depth == 0 ) ? "<div class='nm-sub-menu-bridge'></div>" : '';
            
            $indent = str_repeat( "\t", $depth );
            $output .= "\n$indent<div class='sub-menu'>" . $bridge_element . "<ul class='nm-sub-menu-ul'>\n";
        }
        
        /* Ends the list of after the elements are added */
        function end_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat( "\t", $depth );
            $output .= "$indent</ul></div>\n";
        }
    }
