<?php
define('WP_CACHE', false); // Added by WP Rocket
define('DISALLOW_FILE_EDIT', true);
define('DISALLOW_FILE_MODS', true);
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
define( 'DB_NAME', 'livespoglobal');

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'NganHa12345678' );

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
define( 'AUTH_KEY',         ',/ $N~SZ*]CP7=nx)ATQYU~47_Y*Da$sP 96bQ6K+R_Qo^8UW?JgF&.$l.!S@,&r' );
define( 'SECURE_AUTH_KEY',  'M0c7RA=.+IqtOWV!!yDvn0%|s3N/I)FaiX+~?oGQm9Kp!2c2s-R{5Vr UHX8&@~r' );
define( 'LOGGED_IN_KEY',    'sgFs-a5rJXTT+M_PJz&yWSC9%uH Mzk$(3AO|-L~!3AOv=nub)|NS^B::kC?XclK' );
define( 'NONCE_KEY',        'Yax#+GIYc6[uR@wIqkIPC*FHFOadg(SWi23z-gEJ/~| Oho+/[lUrOxvC%yg68N;' );
define( 'AUTH_SALT',        ',z+b@;c2vy)>9^#GfaP[8kNCAcxp?r}.Oc$/bAVa-|P^G#Zt&pUD?n%;A8|Wf&By' );
define( 'SECURE_AUTH_SALT', '0X~rY!FRY5!,EeY4<(1#AH*xdJaTW}MhF%~8w7wH.4.o+jpQe #YCKYGbiXd[^xo' );
define( 'LOGGED_IN_SALT',   'n0EC9Pq0)Vl`lE+vArp3E6<-YIMu5O$3|e&<m}~uS&914&LwHk;`H6vS:)><ksGF' );
define( 'NONCE_SALT',       '7T3Qv:lq6Z!?U~P!85@A`^Kw38t9*vRxA(eg:mjI3oH6}_9pZ,Ei<yNF+:}<]4)O' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
