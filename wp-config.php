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
define('DB_NAME', 'milgen');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'GC/rAQDf4pJW/m4bvo`rZ+08!^|v`lhc)/+}F+ru-;vqW@X,5{I)EJ}6c3|Cj@:?');
define('SECURE_AUTH_KEY',  'w[@GYm,?d%iu}-rh25~5#S_jh+xqZk.3rr!p77|O&Nq<3f?x>3N![,P{K+w{<V[)');
define('LOGGED_IN_KEY',    '-qBpA1ISo-JC{H$a^_Q@O:&<W|]5>z9KxB)4||@&;5~`8]Pe`EZJJN[8PF_8 [:w');
define('NONCE_KEY',        '}p,Hc2py:hkGnQh{I_OE(T]Gtq[tsibtsvLuST2$Ql/X{:|)/BJ25V<HX/r4l|v6');
define('AUTH_SALT',        'uak:HDtfH:<^8=4K^$+OkSYiF|.0[ $eax/o +)9=N)|[DZgObii  >OWl05q38n');
define('SECURE_AUTH_SALT', 'IPwA{?w7zC<+WeG|!/pi)]z;fruo{P)#n-?y-yjXyHb+-X3-#0U?ggsWZfcle;[#');
define('LOGGED_IN_SALT',   'cD-qSVi_]0Pd7Gxmd}t4nl&ya.Ssi#7%D6CZoGMX~1X vfZO#M9QTm=$HRyfjfet');
define('NONCE_SALT',       '9>6@+U`B}.nt{Hd|X9y!4Hse[sRBa`IZD-pIjXC(,/A<]=*HOYe<=@,;kVM9USAQ');

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
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
