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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

// Enable error reporting output to browser. Default value is false.
define( 'WP_DEBUG', true );
// log errors to `/wp-content/debug.log`. Useful when debugging code that does not output to browser.
define('WP_DEBUG_LOG', true);

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'XX39S1k9SZOGW4Eeh05s2AtJGxkgKKjSMG/R0OdC1p02V9SQr4dnAYeHDDY3K5C/O8KqTuIe/BPJ7EoYYmm2dg==');
define('SECURE_AUTH_KEY',  'yWZOSkVmkm/b8IZuwfSdZQTFmEsI0M2j9h9M2Z7k+59JkXYwSa92FpKHFSAfk3xPKC+mU8FOjCfISdRPgSWBpQ==');
define('LOGGED_IN_KEY',    'wvXDPuctJdrKoHtiIjMS92OwUYIoSFYHO17/z+dbTbmMv4iWt2dKacoUC/A5TihIi/IHCoU3bnXd4LC3wmrusw==');
define('NONCE_KEY',        'WhP+RFiCOt+LKhuk323RqsIbgkd9Jy6s0CplCXydT9uwUHGFt1fYpD46pDABu0PzYBP7RHeCEwRh/ofswOoB6A==');
define('AUTH_SALT',        '3nPWtE+lFjX/3/9jQOyxQlCZseL4jaXZeeSdN/Z+6/QVRb+eFfClDWKWC+ZXeS0uCiiI1LMeqAfKG/9VgoGcaw==');
define('SECURE_AUTH_SALT', 'sDpySAThGRcNPViWR3kGLdftfJo6sKxDFf7WvdlSBisJ0/okjJyu+E5YMhCCxkM/rP1d/Rm3CBzAx+ao370AVw==');
define('LOGGED_IN_SALT',   'rvy/7vCZe5cBpnoGun27YNUGyazRsaVTOw1HMxopI4+1DBUo0d1s7uKGzmLcj0CXJuaVaJKAJFaQ2bu4MlTWRw==');
define('NONCE_SALT',       'GTYD+peHg1Bgb3BUARWKec6s+sQDYtj1WgXxIfL0y/WNxYJkYQCtU48bzqrKb3K0o/+dWasZj4xVkuK1DnbwKg==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
