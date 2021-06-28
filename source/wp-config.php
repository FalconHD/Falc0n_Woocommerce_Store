<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wpstore' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '.],J1=)N0f>QIwko087QGwdU`T Zwkhug7il:OhdF$Sp90|&5>i$IK_JBMiAk&/C' );
define( 'SECURE_AUTH_KEY',  '%0MB+4<Ma-e^anOos2Ae7*S}k]A|awi}lHWHI#00FA*`d@Mh,^v~{]sCBUt:Y<7+' );
define( 'LOGGED_IN_KEY',    '1X2@l6sWlrDvP0{S.y~%>9%5_2hfrJ%~a?P=]m&[wty|$gHI9,BE*Nz[w.H6?rK}' );
define( 'NONCE_KEY',        'Qf`Sxva`/9/&{-rZ*X1?)M,df-Ko3F@:,iQY+|coE/Sp{H*zSS6YIC_>b_-d&+l8' );
define( 'AUTH_SALT',        'Y,j:dBQ>7j&>A.(:1e?.t?J^^yp:{,mZWYI=pPk,;/S-(H#|nA:lu/8}^~[p9@R&' );
define( 'SECURE_AUTH_SALT', 'YSZHaj77MBmz`USF-0=1W;iF=LB&/W=FSgt?3:bD0S$yI{e.zkNEu6XDUglV`AnU' );
define( 'LOGGED_IN_SALT',   'B#lO[7i2,b/!~CnY~,{9M5rD/mh~3G[DwW]I:#>]siU~EJ.zV.N]o8&FJ!8N?z7V' );
define( 'NONCE_SALT',       ';<.0c?/5~%is^|[Z)e:?-C60_$ZVNT-?:(-*v<~gWuu^+yiabwR{bg=15%jI]Q2_' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'localhost');
define('PATH_CURRENT_SITE', '/wpstore/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
