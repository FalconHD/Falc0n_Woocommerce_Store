<?php
    
    /* Block editor (Gutenberg)
    ==================================================================================================== */
    
    /* Block editor: Setup */
    function nm_block_editor_setup() {
        add_theme_support( 'editor-styles' );
        add_theme_support( 'align-wide' ); // Adds support for full and wide blocks

        add_editor_style( NM_URI . '/block-editor/assets/style-editor.css' );
    }
    add_action( 'after_setup_theme', 'nm_block_editor_setup' );


    /* Block editor: Assets */
    function nm_block_editor_assets() {
        wp_enqueue_script( 'nm-block-editor', NM_URI . '/block-editor/assets/editor.js', array( 'wp-blocks', 'wp-dom' ), NM_THEME_VERSION, true );

        // Add inline CSS with "dummy" handle
        $block_editor_inline_styles = nm_block_editor_get_inline_styles();
        wp_register_style( 'nm-block-editor-inline', '', array(), NM_THEME_VERSION, 'all' );
        wp_enqueue_style( 'nm-block-editor-inline' );
        wp_add_inline_style( 'nm-block-editor-inline', $block_editor_inline_styles );
    }
    add_action( 'enqueue_block_editor_assets', 'nm_block_editor_assets' );

    
    /* Block editor: Get inline styles */
    function nm_block_editor_get_inline_styles() {
        global $nm_theme_options;
        
        $letter_spacing_body = ( ! empty( $nm_theme_options['letter_spacing_body'] ) ) ? 'letter-spacing:' . intval( $nm_theme_options['letter_spacing_body'] ) . 'px;' : '';
        $letter_spacing_h1 = ( ! empty( $nm_theme_options['letter_spacing_h1'] ) ) ? 'letter-spacing:' . intval( $nm_theme_options['letter_spacing_h1'] ) . 'px;' : '';
        $letter_spacing_h2 = ( ! empty( $nm_theme_options['letter_spacing_h2'] ) ) ? 'letter-spacing:' . intval( $nm_theme_options['letter_spacing_h2'] ) . 'px;' : '';
        $letter_spacing_h3 = ( ! empty( $nm_theme_options['letter_spacing_h3'] ) ) ? 'letter-spacing:' . intval( $nm_theme_options['letter_spacing_h3'] ) . 'px;' : '';
        $letter_spacing_h456 = ( ! empty( $nm_theme_options['letter_spacing_h456'] ) ) ? 'letter-spacing:' . intval( $nm_theme_options['letter_spacing_h456'] ) . 'px;' : '';
        
        $block_editor_inline_styles =
'.editor-styles-wrapper {
    background-color:' . esc_attr( $nm_theme_options['main_background_color'] ). ';
}
.editor-styles-wrapper p {
    font-weight:' . esc_attr( $nm_theme_options['font_weight_body'] ) . ';
    color:' . esc_attr( $nm_theme_options['main_font_color'] ) . ';
    ' . $letter_spacing_body . '
}
.block-editor .editor-styles-wrapper,
.block-editor .editor-styles-wrapper p {
    font-size:' . intval( $nm_theme_options['font_size_small'] ) . 'px;
}
.block-editor .editor-styles-wrapper {
    font-size:' . intval( $nm_theme_options['font_size_small'] ) . 'px;
    color:' . esc_attr( $nm_theme_options['main_font_color'] ) . ';
}
.block-editor .editor-styles-wrapper h1 {
    font-weight:' . esc_attr( $nm_theme_options['font_weight_h1'] ) . ';
    color:' . esc_attr( $nm_theme_options['heading_1_color'] ) . ';
    ' . $letter_spacing_h1 . '
}
.block-editor .editor-styles-wrapper h2 {
    font-weight:' . esc_attr( $nm_theme_options['font_weight_h2'] ) . ';
    color:' . esc_attr( $nm_theme_options['heading_2_color'] ) . ';
    ' . $letter_spacing_h2 . '
}
.block-editor .editor-styles-wrapper h3 {
    font-weight:' . esc_attr( $nm_theme_options['font_weight_h3'] ) . ';
    color:' . esc_attr( $nm_theme_options['heading_3_color'] ) . ';
    ' . $letter_spacing_h3 . '
}
.block-editor .editor-styles-wrapper h4,
.block-editor .editor-styles-wrapper h5,
.block-editor .editor-styles-wrapper h6 {
    font-weight:' . esc_attr( $nm_theme_options['font_weight_h456'] ) . ';
    color:' . esc_attr( $nm_theme_options['heading_456_color'] ) . ';
    ' . $letter_spacing_h456 . '
}
.editor-styles-wrapper a {
    color:' . esc_attr( $nm_theme_options['highlight_color'] ) . ';
}
.editor-styles-wrapper a:hover {
    color:' . esc_attr( $nm_theme_options['font_strong_color'] ) . ';
}
.editor-styles-wrapper .wp-block-quote,
.editor-styles-wrapper .wp-block-pullquote {
    color:' . esc_attr( $nm_theme_options['font_strong_color'] ) . ';
}';
    
        return $block_editor_inline_styles;
    }
    