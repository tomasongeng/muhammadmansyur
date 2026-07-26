<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '*^aBHOPnGaFy(uG8|:fdL@Ofc)<Rxp[!Yly2cKPwzJpLK5g}9`xank>nsGfJjUE>' );
define( 'SECURE_AUTH_KEY',   'rO2sgf=?TC Ehui2(SX+r]C!hgbq_60qTK<Qn@uz9vItbE`P;E!%E/74ZA~!F0n[' );
define( 'LOGGED_IN_KEY',     '4$t~@9xbfRIbNKcnW,H5{X5:u06c7JgyLJJ(!xc/H.&@#8JYI4$z05!+i-6O3UhJ' );
define( 'NONCE_KEY',         'lG*})=YdbBmE<>!x>ajez@v;oAr_gJ<>9_OiD?`hTfp8fU<|[=EU <d!t6wP+FEz' );
define( 'AUTH_SALT',         '8hWkn^^tBodYw-%fyIGp-NNU?5bV)PjqfnC$P5fMhpt#.Vi2R&>$U&|tBUA8eHI%' );
define( 'SECURE_AUTH_SALT',  'Giwol_2 zjU QN~fs/,).SJrD8,O3vbuDWOwR +6+uBPOLTDk0tsi2T~zzE]demz' );
define( 'LOGGED_IN_SALT',    '6}lgXU1@fQVD]X3I<|IOsPj@*#y8vt%:DY$V3HzZk&Fx{SxcD,?w~:_$0[];)2Wi' );
define( 'NONCE_SALT',        'gY)kHdszCg1`Ob^ ox&6Yy_CHGg&#8XKT_d#|3LDInEPkd`MO;*s+287jA5^BlW ' );
define( 'WP_CACHE_KEY_SALT', 'Dj2S}! YgAxjza#Z&=NOT?0:AJg3j:%V56.7MD0(nK?S/aJb@[rKsi-Jzd<v_d@B' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
