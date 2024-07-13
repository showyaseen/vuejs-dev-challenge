<?php

/**
 * Core Plugin Class
 *
 * @package       ytaha-admin-dashboard
 * @description   This file defines the main class for the AdminDashboard plugin,
 *                which is responsible for initializing the plugin, handling activation and
 *                deactivation hooks, enqueuing scripts, and adding admin menu pages.
 *
 * Plugin Name:   Admin Dashboard
 * Plugin URI:    https://github.com/showyaseen/ytaha-admin-dashboard
 * Version:       1.0.0
 * Author:        Yaseen Taha
 * Text Domain:   ytaha-admin-dashboard
 */

namespace YTAHA\Dashboard;

use YTAHA\Dashboard\RestfulAPIController;

/**
 * Main Admin Dashboard Plugin Class.
 */
class Plugin
{
    /**
     * The singleton instance of the class.
     *
     * @var Plugin
     */
    protected static $instance;

    /**
     * Class constructor.
     */
    protected function __construct()
    {
        add_action('plugins_loaded', [$this, 'init']);
        register_activation_hook(YTAHA_ADMIN_DASHBOARD_BASENAME, [$this, 'activation']);
        register_deactivation_hook(YTAHA_ADMIN_DASHBOARD_BASENAME, [$this, 'deactivation']);
    }

    /**
     * Get the singleton instance of the class.
     *
     * @return Plugin
     */
    public static function get_instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Method called on plugin activation.
     */
    public function activation()
    {
        $this->create_plugin_data();
    }

    /**
     * Method called on plugin deactivation.
     */
    public function deactivation()
    {
        $this->clear_plugin_data();
    }

    /**
     * Create default settings values on activation.
     */
    private function create_plugin_data()
    {
        $user = wp_get_current_user();
        add_option(YTAHA_ADMIN_DASHBOARD_ROWS_NO, 5);
        add_option(YTAHA_ADMIN_DASHBOARD_DATE_IN_HUMAN, true);
        add_option(YTAHA_ADMIN_DASHBOARD_EMAILS, [$user->user_email]);
    }

    /**
     * Remove settings values from the database on deactivation.
     */
    private function clear_plugin_data()
    {
        delete_option(YTAHA_ADMIN_DASHBOARD_ROWS_NO);
        delete_option(YTAHA_ADMIN_DASHBOARD_DATE_IN_HUMAN);
        delete_option(YTAHA_ADMIN_DASHBOARD_EMAILS);
    }

    /**
     * Initialize the plugin.
     */
    public function init()
    {
        if (version_compare(PHP_VERSION, YTAHA_ADMIN_DASHBOARD_PHP_MIN_VER, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            add_action('network_admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return;
        }

        add_action('plugin_action_links_' . YTAHA_ADMIN_DASHBOARD_BASENAME, [$this, 'add_links_to_plugin_actions']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('admin_menu', [$this, 'add_admin_menu_pages']);

        // Create an instance of the RestfulAPIController class to create and execute Restful API functions.
        (new RestfulAPIController())->init();
    }

    /**
     * Display admin notice if the PHP version is insufficient.
     */
    public function admin_notice_minimum_php_version()
    {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', YTAHA_ADMIN_DASHBOARD_TEXT_DOMAIN),
            '<strong>' . esc_html(YTAHA_ADMIN_DASHBOARD_NAME) . '</strong>',
            '<strong>' . __('PHP', YTAHA_ADMIN_DASHBOARD_TEXT_DOMAIN) . '</strong>',
            YTAHA_ADMIN_DASHBOARD_PHP_MIN_VER
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

        deactivate_plugins(YTAHA_ADMIN_DASHBOARD_BASENAME);
    }

    /**
     * Enqueue scripts and styles for the admin area.
     */
    public function enqueue_scripts()
    {
        $screen = get_current_screen();

        // Do not load app files and assets if we are not on the app page.
        if (false === strpos($screen->id, YTAHA_ADMIN_DASHBOARD_SLUG)) {
            return;
        }

        wp_enqueue_style(
            YTAHA_ADMIN_DASHBOARD_SLUG . '-styles',
            plugins_url('/public/dist/app.css', __FILE__),
            array(),
            null
        );

        wp_enqueue_script(
            YTAHA_ADMIN_DASHBOARD_SLUG . '-script',
            plugins_url('/public/dist/app.js', __FILE__),
            array('wp-i18n'),
            YTAHA_ADMIN_DASHBOARD_VERSION,
            true
        );

        $localized_data = [
            'base_rest_url' => esc_url_raw(rest_url()),
            'settings_rest_url' => esc_url_raw(rest_url() . YTAHA_ADMIN_DASHBOARD_API_NAMESPACE . '/settings'),
            'data_rest_url' => esc_url_raw(rest_url() . YTAHA_ADMIN_DASHBOARD_API_NAMESPACE . '/data'),
            'nonce' => wp_create_nonce('wp_rest'),
            'app_container' => YTAHA_ADMIN_DASHBOARD_APP_CONTAINER,
            'text_domain' => YTAHA_ADMIN_DASHBOARD_TEXT_DOMAIN
        ];

        wp_localize_script(
            YTAHA_ADMIN_DASHBOARD_SLUG . '-script',
            'admin_dashboard',
            $localized_data
        );
    }

    /**
     * Add admin menu pages.
     */
    public function add_admin_menu_pages()
    {
        add_menu_page(
            __('Admin Dashboard', YTAHA_ADMIN_DASHBOARD_TEXT_DOMAIN),
            __('Admin Dashboard', YTAHA_ADMIN_DASHBOARD_TEXT_DOMAIN),
            'manage_options',
            YTAHA_ADMIN_DASHBOARD_SLUG,
            [$this, 'admin_page_callback'],
            'dashicons-shortcode'
        );
    }

    /**
     * Callback for rendering the page containing the Vue.js application container that loads the admin dashboard page.
     */
    public function admin_page_callback()
    {
        include_once(plugin_dir_path(__FILE__) . 'admin/views/admin-dashboard.php');
    }

    /**
     * Add settings link to plugin actions.
     *
     * @param array $settings Existing plugin action links.
     * @return array Modified plugin action links.
     */
    public function add_links_to_plugin_actions($settings)
    {
        $settings_anchor = sprintf(
            '<a href="%s">%s</a>',
            esc_url(admin_url('admin.php?page=' . YTAHA_ADMIN_DASHBOARD_SLUG . '#/settings')),
            __('Settings', YTAHA_ADMIN_DASHBOARD_TEXT_DOMAIN)
        );

        if (!is_array($settings)) {
            return [$settings_anchor];
        }

        return array_merge($settings, [$settings_anchor]);
    }
}
