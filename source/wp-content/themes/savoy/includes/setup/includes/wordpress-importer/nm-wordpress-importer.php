<?php

// NM: Custom version of the WP Importer - changes are commented with "NM"

/*
Plugin Name: WordPress Importer
Plugin URI: https://wordpress.org/plugins/wordpress-importer/
Description: Import posts, pages, comments, custom fields, categories, tags and more from a WordPress export file.
Author: wordpressdotorg
Author URI: https://wordpress.org/
Version: 0.7
Text Domain: wordpress-importer
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

// NM
/*if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
	return;
}*/
// /NM

/** Display verbose errors */
if ( ! defined( 'IMPORT_DEBUG' ) ) {
	// NM
    //define( 'IMPORT_DEBUG', WP_DEBUG );
    define( 'IMPORT_DEBUG', true );
    // /NM
}

/** WordPress Import Administration API */
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( ! class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) )
		require $class_wp_importer;
}

/** Functions missing in older WordPress versions. */
require_once dirname( __FILE__ ) . '/compat.php';

/** WXR_Parser class */
// NM
//require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser.php';
if ( ! class_exists( 'WXR_Parser' ) ) {
    require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser.php';
}
// /NM

/** WXR_Parser_SimpleXML class */
// NM
//require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-simplexml.php';
if ( ! class_exists( 'WXR_Parser_SimpleXML' ) ) {
    require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-simplexml.php';
}
// /NM

/** WXR_Parser_XML class */
// NM
//require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-xml.php';
if ( ! class_exists( 'WXR_Parser_XML' ) ) {
    require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-xml.php';
}
// /NM

/** WXR_Parser_Regex class */
// NM
//require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-regex.php';
if ( ! class_exists( 'WXR_Parser_Regex' ) ) {
    require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-regex.php';
}
// /NM

/** WP_Import class */
require_once dirname( __FILE__ ) . '/class-wp-import.php';

// NM
/*function wordpress_importer_init() {
	load_plugin_textdomain( 'wordpress-importer' );

	/**
	 * WordPress Importer object for registering the import callback
	 * @global WP_Import $wp_import
	 */
	/*$GLOBALS['wp_import'] = new WP_Import();
	register_importer( 'wordpress', 'WordPress', __('Import <strong>posts, pages, comments, custom fields, categories, and tags</strong> from a WordPress export file.', 'wordpress-importer'), array( $GLOBALS['wp_import'], 'dispatch' ) );
}
add_action( 'admin_init', 'wordpress_importer_init' );*/
// /NM