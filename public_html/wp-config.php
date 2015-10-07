<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'easykarm_easy');

/** MySQL database username */
define('DB_USER', 'easykarm_easy');

/** MySQL database password */
define('DB_PASSWORD', 'SzhPj7zw84');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'az7igsavhhddreqzmdqlyyqyysxh1cz7emfvjsf7hmynrx1aaon75riqass7ykhe');
define('SECURE_AUTH_KEY',  'ml7ja8tn2bhjl2muknld3gqro2rsnbnzr3ufoydvonhphgzymvr4zzmjc22w98pg');
define('LOGGED_IN_KEY',    'qxmc3qnyrjtqxsdueejyprsurj255dfxyddjtqqxk8smqmowuqok9u9mnmw5n4dc');
define('NONCE_KEY',        'mmotukjtimcm2tmqqwsxkclbrst61ncsfagpm41udbzynadkbvvgn81hrvkdgndk');
define('AUTH_SALT',        'siuhogr9fc4dxhpoiyxuk0glfas3nqreca1efkoxbtc90bhrpnrb5txarbpyzmz7');
define('SECURE_AUTH_SALT', 'pl3ygfdhb5uujnvqglterfz4bvrw4fqdya3cpc5aeabfvjg4xpiqxiatyugf3cgv');
define('LOGGED_IN_SALT',   'z1gnsqaq3ktdhh99mlk1kgut23df1fy4urg9oeknej0np7lysme3nrqcn0zqob9d');
define('NONCE_SALT',       '8birpaykz7a7skzdiydhwjylvtqzin5pdncabayxwovoutpkvznp01xyxgptz0nv');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define ('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
