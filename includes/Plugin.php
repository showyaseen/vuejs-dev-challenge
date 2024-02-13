<?php

/**
 * The file that defines the core plugin class
 *
 * @package ytaha-vuejs-dev-challenge
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
use function is_array;
use function printf;
use function sprintf;
use function version_compare;
use function wp_enqueue_script;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

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
	 * and set the hooks for the admin area and the public-facing side of the site.
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
		$this->clearPluginData();
	}

	/**
	 * remove app stored data from wordpress options 
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
	 * Create Wordpress actions required to store and manage settings data
	 *
	 * @return void
	 */
	private function createPluginData()
	{
		$user = wp_get_current_user();
		add_option(VUEJS_DEV_CHALLENGE_ROWS_NO, 5);
		add_option(VUEJS_DEV_CHALLENGE_DATE_IN_HUMAN, TRUE);
		add_option(VUEJS_DEV_CHALLENGE_EMAILS, [
			$user->user_email
		]);
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
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'vuejs-dev-challenge'),
			'<strong>' . esc_html(VUEJS_DEV_CHALLENGE_PLUGIN_NAME) . '</strong>',
			'<strong>' . __('PHP', 'vuejs-dev-challenge') . '</strong>',
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
		// Check for required PHP version.
		if (version_compare(PHP_VERSION, VUEJS_DEV_CHALLENGE_PHP_MIN_VER, '<')) {
			add_action('admin_notices', [$this, 'adminNoticeMinimumPHPVersion']);
			add_action('network_admin_notices', [$this, 'adminNoticeMinimumPHPVersion']);
			return;
		}

		add_action('plugin_action_links_' . VUEJS_DEV_CHALLENGE_PLUGIN_BASENAME, [$this, 'addLinksToPluginActions']);
		add_action('admin_enqueue_scripts', [$this, 'vuejs_dev_challenge_enqueue_scripts']);
		add_action('admin_menu', [$this, 'vuejs_dev_challenge_menu']);

		add_action('rest_api_init', [$this, 'vuejs_dev_challenge_register_restful_api']);
	}

	function vuejs_dev_challenge_enqueue_scripts()
	{
		$screen = get_current_screen();
		if (false === strpos($screen->id, VUEJS_DEV_CHALLENGE_PLUGIN_SLUG)) {
			return;
		}

		wp_enqueue_style(VUEJS_DEV_CHALLENGE_PLUGIN_SLUG . '-styles', plugins_url('/public/dist/app.css', __FILE__), array(), null);

		wp_enqueue_script(VUEJS_DEV_CHALLENGE_PLUGIN_SLUG . '-script', plugins_url('/public/dist/app.js', __FILE__), array('wp-i18n'), VUEJS_DEV_CHALLENGE_PLUGIN_VERSION, true);

		// localize data for script
		wp_localize_script(
			VUEJS_DEV_CHALLENGE_PLUGIN_SLUG . '-script',
			'vuejs_dev_challenge',
			array(
				'base_rest_url' => esc_url_raw(rest_url()),
				'settings_rest_url' => esc_url_raw(rest_url() . VUEJS_DEV_CHALLENGE_API_NAMESPACE . '/settings'),
				'data_rest_url' => esc_url_raw(rest_url() . VUEJS_DEV_CHALLENGE_API_NAMESPACE . '/data'),
				'nonce' => wp_create_nonce('wp_rest'),
				'app_container' => VUEJS_DEV_CHALLENGE_APP_CONTAINER,
				'text_domain' => VUEJS_DEV_CHALLENGE_TEXT_DOMAIN
			)
		);
	}

	function vuejs_dev_challenge_menu()
	{

		add_menu_page(__('VueJS Developer Challenge', 'vuejs-dev-challenge'), __('VueJS Challenge', 'vuejs-dev-challenge'), 'manage_options', VUEJS_DEV_CHALLENGE_PLUGIN_SLUG, [$this, 'vuejs_dev_challenge_admin_page']);

		add_submenu_page(
			VUEJS_DEV_CHALLENGE_PLUGIN_SLUG,
			__('Table', 'vuejs-dev-challenge'),
			__('Table', 'vuejs-dev-challenge'),
			'manage_options',
			VUEJS_DEV_CHALLENGE_PLUGIN_SLUG . '#/table',
			[$this, 'vuejs_dev_challenge_admin_page'],
			10
		);
		add_submenu_page(
			VUEJS_DEV_CHALLENGE_PLUGIN_SLUG,
			__('Graph', 'vuejs-dev-challenge'),
			__('Graph', 'vuejs-dev-challenge'),
			'manage_options',
			VUEJS_DEV_CHALLENGE_PLUGIN_SLUG . '#/graph',
			[$this, 'vuejs_dev_challenge_admin_page'],
			10
		);
		add_submenu_page(
			VUEJS_DEV_CHALLENGE_PLUGIN_SLUG,
			__('Settings', 'vuejs-dev-challenge'),
			__('Settings', 'vuejs-dev-challenge'),
			'manage_options',
			VUEJS_DEV_CHALLENGE_PLUGIN_SLUG . '#/settings',
			[$this, 'vuejs_dev_challenge_admin_page'],
			10
		);
	}

	function vuejs_dev_challenge_admin_page()
	{
		include_once(plugin_dir_path(__FILE__) . 'admin/views/vuejs-dev-challenge.php');
	}

	function vuejs_dev_challenge_register_restful_api()
	{
		$endpoints = [
			[
				'route' => '/settings',
				'method' => 'GET',
				'callback' => function (WP_REST_Request $request) {
					$response_data = [
						'rowNumber' => get_option(VUEJS_DEV_CHALLENGE_ROWS_NO, 5),
						'isHuman' => get_option(VUEJS_DEV_CHALLENGE_DATE_IN_HUMAN, TRUE),
						'extraEmail' => get_option(VUEJS_DEV_CHALLENGE_EMAILS, []),
					];
					return new WP_REST_Response($response_data, 200);
				},
			],
			[
				'route' => '/settings',
				'method' => 'PUT',
				'callback' => function (WP_REST_Request $request) {
					$data = $request->get_json_params();
					$settings = $data['settings'] ?? [];
					$rowNumber = !empty($settings['rowNumber']) ? absint($settings['rowNumber']) : 0;
					if (!empty($settings['extraEmail'])) {
						$extraEmail = [];
						foreach ($settings['extraEmail'] as $email) {
							$extraEmail[] = sanitize_email($email);
						}
					}
					$isHuman = array_key_exists('isHuman', $settings) ? absint($settings['isHuman']) : 0;

					// Validate each input field
					if (array_key_exists('rowNumber', $settings)) {
						if (
							!is_numeric($rowNumber) ||
							$rowNumber > 5 ||
							$rowNumber < 1
						) {
							$errors['rowNumber'] = __('Server Error: Row number field is invalid.', 'vuejs-dev-challenge');
						} else {
							update_option(VUEJS_DEV_CHALLENGE_ROWS_NO, $rowNumber);
						}
					}

					if (array_key_exists('extraEmail', $settings)) {
						if (!is_array($extraEmail)) {
							$errors['extraEmail'] = __('Server Error: Extra Email field is invalid.', 'vuejs-dev-challenge');
						} else {
							foreach ($extraEmail as $email) {
								if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
									$errors['extraEmail'] = __('Server Error: Extra Email List is invalid.', 'vuejs-dev-challenge');
									break;
								}
							}
							if (empty($errors['extraEmail'])) {
								update_option(VUEJS_DEV_CHALLENGE_EMAILS, $extraEmail);
							}
						}
					}

					if (array_key_exists('isHuman', $settings)) {
						update_option(VUEJS_DEV_CHALLENGE_DATE_IN_HUMAN, $isHuman);
					}


					// If there are validation errors, return a response with errors
					if (!empty($errors)) {
						return new WP_Error(
							'invalid_data',
							__('Validation failed.', 'vuejs-dev-challenge'),
							['status' => 400, 'errors' => $errors]
						);
					}


					return new WP_REST_Response($settings, 200);
				},
			],
			[
				'route' => '/data',
				'method' => 'GET',
				'callback' => function (WP_REST_Request $request) {
					// Check if the data is already in the options
					$cached_data = get_option('remote_data');

					// Check if the timestamp option is set
					$timestamp = get_option('remote_data_timestamp', 0);

					// Check if the cached data is still valid (less than one hour old)
					if (false === $cached_data || false === $timestamp || current_time('timestamp') - $timestamp > HOUR_IN_SECONDS) {
						// If not cached or expired, fetch data from the remote server
						$remote_data = wp_remote_get(VUEJS_DEV_CHALLENGE_REMOTE_DATA_URL);

						if (!is_wp_error($remote_data) && wp_remote_retrieve_response_code($remote_data) === 200) {
							// Parse and process the remote data
							$parsed_data = json_decode(wp_remote_retrieve_body($remote_data), true);

							// Sanitize and escape remote data
							$sanitized_graph = [];
							foreach ($parsed_data['graph'] as $graph) {
								$sanitized_graph[] = [
									'date' => !empty($graph['date']) ? absint($graph['date']) : 0,
									'value' => !empty($graph['value']) ? absint($graph['value']) : 0
								];
							}

							$sanitized_table = [];
							$sanitized_table['title'] = sanitize_text_field($parsed_data['table']['title'] ?? '');
							$sanitized_table['headers'] = [];
							$sanitized_table['rows'] = [];

							if ($parsed_data['table']['data']['headers'] ?? false) {
								foreach ($parsed_data['table']['data']['headers'] as $header) {
									$sanitized_table['headers'][] = sanitize_text_field($header);
								}
							}
							if ($parsed_data['table']['data']['rows'] ?? false) {
								foreach ($parsed_data['table']['data']['rows'] as $row) {
									$row['id'] = !empty($row['id']) ? absint($row['id']) : 0;
									$row['pageviews'] = !empty($row['pageviews']) ? absint($row['pageviews']) : 0;
									$row['title'] = !empty($row['title']) ? sanitize_text_field($row['title']) : '';
									$row['url'] = !empty($row['url']) ? esc_url_raw($row['url']) : '';
									$row['date'] = !empty($row['date']) ? absint($row['date']) : 0;

									$sanitized_table['rows'][] = $row;
								}
							}

							$sanitized_data = ['graph' => $sanitized_graph, 'table' => $sanitized_table];

							// Cache the sanitized data and timestamp in options
							update_option('remote_data', $sanitized_data, false);
							update_option('remote_data_timestamp', current_time('timestamp'), false);

							return new WP_REST_Response($sanitized_data, 200);
						} else if(false === $cached_data) {
							// Handle error if cache is empty and failed to fetching remote data
							return new WP_Error(
								'cannot_fetch_remote_data',
								__('Unable to fetch the remote data.', 'vuejs-dev-challenge'),
								['status' => 400]
							);
						}
					}
					return new WP_REST_Response($cached_data, 200);
				},
			],
		];

		foreach ($endpoints as $endpoint) {
			register_rest_route(VUEJS_DEV_CHALLENGE_API_NAMESPACE, $endpoint['route'], [
				'methods' => $endpoint['method'],
				'callback' => $endpoint['callback'],
				'permission_callback' =>  function () {
					rest_cookie_check_errors(null);
					$user = wp_get_current_user();
					// Restrict endpoint to only users who have administrator capability.
					if (!in_array('administrator', $user->roles) || false === current_user_can( 'manage_options' )) {
						return new WP_Error('rest_forbidden', __('Unauthenticated', 'vuejs-dev-challenge'), ['status' => 401]);
					}
					return true;
				},
			]);
		}
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
		$settings_anchor = sprintf(
			'<a href="%s">%s</a>',
			esc_url(admin_url('admin.php?page=' . VUEJS_DEV_CHALLENGE_PLUGIN_SLUG . '#/settings')),
			__('Settings', 'vuejs-dev-challenge')
		);
		if (!is_array($settings)) {
			return [$settings_anchor];
		}

		return array_merge($settings, [$settings_anchor]);
	}
}
