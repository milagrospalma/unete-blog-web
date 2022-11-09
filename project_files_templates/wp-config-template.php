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
define('DB_NAME', '*************');

/** MySQL database username */
define('DB_USER', '*************');

/** MySQL database password */
define('DB_PASSWORD', '*************');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'Hb1XqwC6yNeuRVJX+=VBMKcDCg{r(/1MTt/`7xK*64-H2`.|a!Ec8_;9Y7:Ju<HR');
define('SECURE_AUTH_KEY', 'y-47AZJrFt8Q?s$j ec!)*GS5,L7}JL&&hB<+Ng+^+NOi5/k|,%/=Ice04403_=z');
define('LOGGED_IN_KEY', '{f/r*,BbW([DG}mr1/L2^}(ikjDkw~U23u9F[Y2+HgI8D8_r-N11(MuG_p=H.5:P');
define('NONCE_KEY', '3K|y?.r^T^q=X*Z=+,}onoz-jl:O}=S8RmJqf*:H*h!UY-c1>Tx&r9[_WtR,?aWR');
define('AUTH_SALT', 'Z&rz?Bam%PW@5%j+p*`b5x;; RjbrIa+%qP-S<?^A{nxSI=i85f{o3xr#|mIM[E&');
define('SECURE_AUTH_SALT', 'Y%FBo@kriM;2Xxan%pji]v7(5oX8bbAL&T,?Tf]lT}_u9_IEGa(1RQ,Tbe cGuGf');
define('LOGGED_IN_SALT', '0%LavwU~-.lNrqF&g&A9CIFJnK1&0J6KH+`WP,3z_W@?.Dqvn`_*h)NXUF.*uAn5');
define('NONCE_SALT', 'o0*b8<q8HHbrcdAJ)cr3&k%Pb#;r htn`u^Q0eFNY);|F7bpIY}|C3+4lIlXG<sn');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'Vn3t3bl0g_';

/** Config to upload files to S3. */

define( 'AS3CF_SETTINGS', serialize( array(
    'provider' => 'aws',
    'access-key-id' => '******************',
    'secret-access-key' => '************************************',
) ) );

/**
 * Configuration cache redis
 */
define( 'WP_REDIS_HOST', '127.0.0.1' );
define( 'WP_REDIS_PORT', 6379 );

define( 'DISABLE_COMMENTS_ALLOW_DISCUSSION_SETTINGS', true );

define( 'DISALLOW_FILE_EDIT', true );
define( 'DISALLOW_FILE_MODS', true );

/**
 * Configuration recaptcha
 */
define( 'RECAPTCHA_SITEKEY', '' );
define( 'RECAPTCHA_SECRETKEY', '' );

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

