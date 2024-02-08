<?php

/**
 * The file that defines the core plugin class
 *
 * @package vuejs-dev-challenge
 */

namespace YaseenTaha\VueJSDevChallenge;

use function add_action;
use function add_option;
use function array_merge;
use function deactivate_plugins;
use function delete_option;
use function esc_html;
use function esc_html__;
use function esc_url;
use function function_exists;
use function is_array;
use function printf;
use function sprintf;
use function version_compare;
use function wp_enqueue_script;

use const VUEJS_DEV_CHALLENGE_PHP_MIN_VER;
use const VUEJS_DEV_CHALLENGE_PLUGIN_BASENAME;
use const VUEJS_DEV_CHALLENGE_PLUGIN_NAME;
use const VUEJS_DEV_CHALLENGE_PLUGIN_SETTINGS_PAGE;
use const PHP_VERSION;

/**
 * The core plugin class.
 */
class Plugin
{
	/**
	 * Plugin instance.
	 *
	 * @access protected
	 * @static
	 *
	 * @var Plugin
	 */
	protected static $instance;


	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @access protected
	 *
	 * @since    1.0.0
	 */
	protected function __construct()
	{
		add_action('plugins_loaded', [$this, 'init']);
		register_activation_hook(VUEJS_DEV_CHALLENGE_PLUGIN_BASENAME, [$this, 'activation']);
		register_deactivation_hook(VUEJS_DEV_CHALLENGE_PLUGIN_BASENAME, [$this, 'deactivation']);
	}

	/**
	 * On Plugin deactivation
	 *
	 * @return void
	 */
	public function deactivation()
	{
		if (get_settings_remove_data_on_uninstall()) {
			$this->clearPluginData();
		}
	}

	/**
	 * Create database schema updates required to store and manage the additional analytic data
	 *
	 * @return void
	 */
	private function clearPluginData()
	{
		delete_option(VUEJS_DEV_CHALLENGE_ROWS_NO);
		delete_option(VUEJS_DEV_CHALLENGE_DATE_IN_HUMAN);
		delete_option(VUEJS_DEV_CHALLENGE_EMAILS);
	}

	/**
	 * Method to get instance of Core.
	 *
	 * @access public
	 * @static
	 *
	 * @return Plugin
	 */
	public static function getInstance()
	{
		if (!self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * On Plugin activation
	 *
	 * @return void
	 */
	public function activation()
	{
		$this->createPluginData();
	}

	/**
	 * Create database schema updates required to store and manage the additional analytic data
	 *
	 * @return void
	 */
	private function createPluginData()
	{
		add_option(VUEJS_DEV_CHALLENGE_ROWS_NO, 5);
		add_option(VUEJS_DEV_CHALLENGE_DATE_IN_HUMAN, TRUE);
		add_option(VUEJS_DEV_CHALLENGE_EMAILS, []);
	}

	/**
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function adminNoticeMinimumPHPVersion()
	{
		if (isset($_GET['activate'])) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			unset($_GET['activate']); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		$message = sprintf(
		/* Translators: %1$s - Plugin name, %2$s - "PHP", %3$s - Required PHP version. */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'vuejs-dev-challenge'),
			'<strong>' . esc_html(VUEJS_DEV_CHALLENGE_PLUGIN_NAME) . '</strong>',
			'<strong>' . esc_html__('PHP', 'vuejs-dev-challenge') . '</strong>',
			VUEJS_DEV_CHALLENGE_PHP_MIN_VER
		);

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

		deactivate_plugins(VUEJS_DEV_CHALLENGE_PLUGIN_BASENAME);
	}

	/**
	 * Method to initialize plugin.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function init()
	{
		if (!function_exists('is_plugin_active')) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		// Check for required PHP version.
		if (version_compare(PHP_VERSION, VUEJS_DEV_CHALLENGE_PHP_MIN_VER, '<')) {
			add_action('admin_notices', [$this, 'adminNoticeMinimumPHPVersion']);
			add_action('network_admin_notices', [$this, 'adminNoticeMinimumPHPVersion']);

			return;
		}

		add_action('plugin_action_links_' . VUEJS_DEV_CHALLENGE_PLUGIN_BASENAME, [$this, 'addLinksToPluginActions']);
        add_action('admin_enqueue_scripts', [$this, 'vuejs_dev_challenge_enqueue_scripts']);
        add_action('admin_menu', [$this, 'vuejs_dev_challenge_menu']);


		$this->loadDependencies();

	}

    function vuejs_dev_challenge_enqueue_scripts() {
        wp_enqueue_script(VUEJS_DEV_CHALLENGE_PLUGIN_SLUG.'-app', plugins_url('/public/dist/app.js', __FILE__), array(), '1.0', true);
        wp_enqueue_style(VUEJS_DEV_CHALLENGE_PLUGIN_SLUG.'-styles', plugins_url('/public/dist/app.css', __FILE__), array(), null);
    }

    function vuejs_dev_challenge_menu() {

        add_menu_page(__('VueJS Developer Challenge', 'vuejs-dev-challenge'), __('VueJS Challenge', 'vuejs-dev-challenge'), 'manage_options', VUEJS_DEV_CHALLENGE_PLUGIN_SLUG, [$this, 'vuejs_dev_challenge_admin_page']);

		add_submenu_page(
			VUEJS_DEV_CHALLENGE_PLUGIN_SLUG,
			esc_html__('Settings', 'vuejs-dev-challenge'),
			esc_html__('Settings', 'vuejs-dev-challenge'),
			'manage_options',
			VUEJS_DEV_CHALLENGE_PLUGIN_SLUG . '#/settings',
			[$this, 'vuejs_dev_challenge_admin_page'],
			10
		);
		add_submenu_page(
			VUEJS_DEV_CHALLENGE_PLUGIN_SLUG,
			esc_html__('Table', 'vuejs-dev-challenge'),
			esc_html__('Table', 'vuejs-dev-challenge'),
			'manage_options',
			VUEJS_DEV_CHALLENGE_PLUGIN_SLUG . '#/table',
			[$this, 'vuejs_dev_challenge_admin_page'],
			10
		);
		add_submenu_page(
			VUEJS_DEV_CHALLENGE_PLUGIN_SLUG,
			esc_html__('Graph', 'vuejs-dev-challenge'),
			esc_html__('Graph', 'vuejs-dev-challenge'),
			'manage_options',
			VUEJS_DEV_CHALLENGE_PLUGIN_SLUG . '#/graph',
			[$this, 'vuejs_dev_challenge_admin_page'],
			10
		);
    }

    function vuejs_dev_challenge_admin_page() {
        include_once(plugin_dir_path(__FILE__) . 'admin/views/vuejs-dev-challenge.php');
    }

	/**
	 * Load dependencies.
	 *
	 * @access private
	 *
	 * @return void
	 */
	private function loadDependencies()
	{
		require_once ABSPATH . 'wp-load.php';
		require_once ABSPATH . 'wp-includes/pluggable.php';
		require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/misc.php';
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	}

	/**
	 * Adds plugin settings page link to plugin links in WordPress Dashboard Plugins Page
	 *
	 * @param array $settings Uses $prefix . "plugin_action_links_$plugin_file" action.
	 *
	 * @return array Array of settings
	 */
	public function addLinksToPluginActions($settings)
	{
		$admin_anchor = sprintf(
			'<a href="%s">%s</a>',
			esc_url(admin_url('admin.php?page=' . VUEJS_DEV_CHALLENGE_PLUGIN_SETTINGS_PAGE)),
			esc_html__('Settings', 'vuejs-dev-challenge')
		);
		$dashboard_anchor = sprintf(
			'<a href="%s">%s</a>',
			esc_url(admin_url('admin.php?page=vuejs-dev-challenge-dashboard')),
			esc_html__('Dashboard', 'vuejs-dev-challenge')
		);
		if (!is_array($settings)) {
			return [$admin_anchor, $dashboard_anchor];
		}

		return array_merge($settings, [$admin_anchor, $dashboard_anchor]);
	}
}
