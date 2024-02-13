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

// core plugin information
define('VUEJS_DEV_CHALLENGE_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('VUEJS_DEV_CHALLENGE_PLUGIN_NAME', 'Yaseen Taha VueJS Developer Challenge');
define('VUEJS_DEV_CHALLENGE_PLUGIN_SLUG', 'ytaha-vuejs-dev-challenge');
define('VUEJS_DEV_CHALLENGE_PLUGIN_VERSION', '1.0.0');
define('VUEJS_DEV_CHALLENGE_TEXT_DOMAIN', 'ytaha-vuejs-dev-challenge');


// remote data cache expiry time
define('VUEJS_DEV_CHALLENGE_CACHED_DATA_EXPIRY_TIME', 2123467898);

// Minmum php version
define('VUEJS_DEV_CHALLENGE_PHP_MIN_VER', '7.4');


// Option names to store app settings
define('VUEJS_DEV_CHALLENGE_ROWS_NO', 'ytaha_vuejs_dev_challenge_rows_no');
define('VUEJS_DEV_CHALLENGE_DATE_IN_HUMAN', 'ytaha_vuejs_dev_challenge_in_human');
define('VUEJS_DEV_CHALLENGE_EMAILS', 'ytaha_vuejs_dev_challenge_emails');

// Rest API
define('VUEJS_DEV_CHALLENGE_API_NAMESPACE', 'ytahavuejsdevchallenge/v1');

// remote data url
define('VUEJS_DEV_CHALLENGE_REMOTE_DATA_URL', 'https://miusage.com/v1/challenge/2/static/');

// vue js app container
define('VUEJS_DEV_CHALLENGE_APP_CONTAINER', 'vuejs-dev-challenge-render');

// phpcs:disable
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

Plugin::getInstance();
// phpcs:enable
