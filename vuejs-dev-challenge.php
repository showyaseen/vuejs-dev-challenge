<?php

// phpcs:disable Generic.Files.LineLength.TooLong

/**
 * The plugin addresses the Vue.js developer challenge, as presented by Awesome Motive, as part of the application process for the WordPress Developer position.
 *
 * Plugin Name:       Yaseen Taha VueJS Developer Challenge
 * Plugin URI:        https://github.com/showyaseen/yaseentaha-vuejs-dev-challenge
 * Description:       The plugin addresses the Vue.js developer challenge, as presented by Awesome Motive, as part of the application process for the WordPress Developer position.
 * Version:           1.0.0
 * Author:            Yaseen Taha
 * Text Domain:       ytaha-vuejs-dev-challenge
 * Domain Path:       /languages/
 *
 * @package           ytaha-vuejs-dev-challenge
 */

namespace YaseenTaha\VueJSDevChallenge;

use function define;
use function defined;
use function plugin_dir_path;

// phpcs:disable
defined('WPINC') || die;
// phpcs:enable

// Define core plugin constants.
define('YTAHA_VUEJS_DEV_CHALLENGE_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('YTAHA_VUEJS_DEV_CHALLENGE_PLUGIN_NAME', 'Yaseen Taha VueJS Developer Challenge');
define('YTAHA_VUEJS_DEV_CHALLENGE_PLUGIN_SLUG', 'ytaha-vuejs-dev-challenge');
define('YTAHA_VUEJS_DEV_CHALLENGE_PLUGIN_VERSION', '1.0.0');
define('YTAHA_VUEJS_DEV_CHALLENGE_TEXT_DOMAIN', 'ytaha-vuejs-dev-challenge');

// Define remote data cache expiry time.
define('YTAHA_VUEJS_DEV_CHALLENGE_CACHED_DATA_EXPIRY_TIME', 2123467898);

// Define Minimum PHP version.
define('YTAHA_VUEJS_DEV_CHALLENGE_PHP_MIN_VER', '7.4');

// Define option names to store app settings.
define('YTAHA_VUEJS_DEV_CHALLENGE_ROWS_NO', 'ytaha_vuejs_dev_challenge_rows_no');
define('YTAHA_VUEJS_DEV_CHALLENGE_DATE_IN_HUMAN', 'ytaha_vuejs_dev_challenge_in_human');
define('YTAHA_VUEJS_DEV_CHALLENGE_EMAILS', 'ytaha_vuejs_dev_challenge_emails');

// Define Rest API namespace.
define('YTAHA_VUEJS_DEV_CHALLENGE_API_NAMESPACE', 'ytahavuejsdevchallenge/v1');

// Define remote data URL.
define('YTAHA_VUEJS_DEV_CHALLENGE_REMOTE_DATA_URL', 'https://miusage.com/v1/challenge/2/static/');

// Define Vue.js app container.
define('YTAHA_VUEJS_DEV_CHALLENGE_APP_CONTAINER', 'vuejs-dev-challenge-render');

// phpcs:disable
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

// Initialize the plugin.
Plugin::getInstance();
// phpcs:enable
