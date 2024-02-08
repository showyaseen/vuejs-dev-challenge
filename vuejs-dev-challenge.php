<?php

// phpcs:disable Generic.Files.LineLength.TooLong

/**
 * Plugin implement vuejs developer challenge.
 *
 * Plugin Name:       Yaseen Taha VueJS Developer Challenge
 * Plugin URI:        https://showyaseen@hotmail.com
 * Description:       Plugin implement vuejs developer challenge.
 * Version:           1.0.0
 * Author:            Yaseen Taha
 * Text Domain:       vuejs-dev-challenge
 * Domain Path:       /languages/
 *
 * @package           vuejs-dev-challenge
 */

namespace YaseenTaha\VueJSDevChallenge;

use function define;
use function defined;
use function plugin_dir_path;

// phpcs:disable
defined('WPINC') || die;
// phpcs:enable

define('VUEJS_DEV_CHALLENGE_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('VUEJS_DEV_CHALLENGE_PLUGIN_URL', plugins_url('/', __FILE__));
define('VUEJS_DEV_CHALLENGE_PLUGIN_FILE', VUEJS_DEV_CHALLENGE_PLUGIN_DIR . 'vuejs-dev-challenge-pro.php');
define('VUEJS_DEV_CHALLENGE_PLUGIN_BASENAME', plugin_basename(__FILE__));

define('VUEJS_DEV_CHALLENGE_PLUGIN_NAME', 'Yaseen Taha VueJS Developer Challenge');
define('VUEJS_DEV_CHALLENGE_PLUGIN_SLUG', 'vuejs-dev-challenge');
define('VUEJS_DEV_CHALLENGE_PLUGIN_VERSION', '1.0.0');

define('VUEJS_DEV_CHALLENGE_PLUGIN_ADDON_SETTINGS_GROUP', 'VUEJS_DEV_CHALLENGE_addon_settings');


define('VUEJS_DEV_CHALLENGE_PLUGIN_SETTINGS_PAGE', VUEJS_DEV_CHALLENGE_PLUGIN_SLUG . '-settings');

define('VUEJS_DEV_CHALLENGE_CACHED_DATA_EXPIRY_TIME', 2123467898);

define('VUEJS_DEV_CHALLENGE_PHP_MIN_VER', '7.4');

define('VUEJS_DEV_CHALLENGE_ADMIN_LIBS_JS_DIR', plugin_dir_path(__FILE__) . 'admin/libs/js/');
define('VUEJS_DEV_CHALLENGE_ADMIN_LIBS_JS_URL', plugins_url('/admin/libs/js/', __FILE__));
define('VUEJS_DEV_CHALLENGE_ADMIN_LIBS_CSS_DIR', plugin_dir_path(__FILE__) . 'admin/libs/css/');
define('VUEJS_DEV_CHALLENGE_ADMIN_LIBS_CSS_URL', plugins_url('/admin/libs/css/', __FILE__));
define('VUEJS_DEV_CHALLENGE_ADMIN_LIBS_FONTS_DIR', plugin_dir_path(__FILE__) . 'admin/libs/fonts/');
define('VUEJS_DEV_CHALLENGE_ADMIN_LIBS_FONTS_URL', plugins_url('/admin/libs/fonts/', __FILE__));
define('VUEJS_DEV_CHALLENGE_ADMIN_BUILD_DIR', plugin_dir_path(__FILE__) . 'admin/build/');
define('VUEJS_DEV_CHALLENGE_ADMIN_BUILD_URL', plugins_url('/admin/build/', __FILE__));

// Option names
define('VUEJS_DEV_CHALLENGE_ROWS_NO', 'vuejs_dev_challenge_rows_no');
define('VUEJS_DEV_CHALLENGE_DATE_IN_HUMAN', 'vuejs_dev_challenge_in_human');
define('VUEJS_DEV_CHALLENGE_EMAILS', 'vuejs_dev_challenge_emails');

// Rest API
define('VUEJS_DEV_CHALLENGE_API_NAMESPACE', 'vuejsdevchallenge/v1');

// phpcs:disable
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

Plugin::getInstance();
// phpcs:enable
