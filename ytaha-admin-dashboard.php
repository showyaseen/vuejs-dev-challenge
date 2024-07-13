<?php

// phpcs:disable Generic.Files.LineLength.TooLong

/**
 *
 * Plugin Name:       Admin Dashboard
 * Plugin URI:        https://github.com/showyaseen/ytaha-admin-dashboard
 * Description:       The AdminDashboard plugin is an experimental learning tool that showcases an admin dashboard integrating external data into tables and charts. It includes settings forms for customizing date formats and managing email lists. This plugin demonstrates the use of WordPress admin hooks, Vue.js for the frontend, and PHP for backend logic and API integration.
 * Version:           1.0.0
 * Author:            Yaseen Taha
 * Text Domain:       ytaha-admin-dashboard
 * Domain Path:       /languages/
 *
 * @package           ytaha-admin-dashboard
 */

namespace YTAHA\Dashboard;

use function define;
use function defined;
use function plugin_dir_path;

// phpcs:disable
defined('WPINC') || die;
// phpcs:enable

// Define core plugin constants.
define('YTAHA_ADMIN_DASHBOARD_BASENAME', plugin_basename(__FILE__));
define('YTAHA_ADMIN_DASHBOARD_NAME', 'Yaseen Taha Admin Dashboard');
define('YTAHA_ADMIN_DASHBOARD_SLUG', 'ytaha-admin-dashboard');
define('YTAHA_ADMIN_DASHBOARD_VERSION', '1.0.0');
define('YTAHA_ADMIN_DASHBOARD_TEXT_DOMAIN', 'ytaha-admin-dashboard');

// Define remote data cache expiry time.
define('YTAHA_ADMIN_DASHBOARD_CACHED_DATA_EXPIRY_TIME', 2123467898);

// Define Minimum PHP version.
define('YTAHA_ADMIN_DASHBOARD_PHP_MIN_VER', '7.4');

// Define option names to store app settings.
define('YTAHA_ADMIN_DASHBOARD_ROWS_NO', 'ytaha_admin_dashboard_rows_no');
define('YTAHA_ADMIN_DASHBOARD_DATE_IN_HUMAN', 'ytaha_admin_dashboard_in_human');
define('YTAHA_ADMIN_DASHBOARD_EMAILS', 'ytaha_admin_dashboard_emails');

// Define Rest API namespace.
define('YTAHA_ADMIN_DASHBOARD_API_NAMESPACE', 'ytahaDashboard/v1');

// Define remote data URL.
define('YTAHA_ADMIN_DASHBOARD_REMOTE_DATA_URL', 'https://miusage.com/v1/challenge/2/static/');

// Define Vue.js app container.
define('YTAHA_ADMIN_DASHBOARD_APP_CONTAINER', 'admin-dashboard-render');

// phpcs:disable
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

// Initialize the plugin.
Plugin::getInstance();
// phpcs:enable
