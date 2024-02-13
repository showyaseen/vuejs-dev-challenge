<?php

/**
 * The file that defines the core plugin class
 *
 * @package ytaha-vuejs-dev-challenge
 */

namespace YaseenTaha\VueJSDevChallenge;

use YaseenTaha\VueJSDevChallenge\RestfulAPIController;

/**
 * Main vuejs dev challenge plugin class.
 */
class Plugin
{
    protected static $instance;

    /**
     * Class constructor.
     */
    protected function __construct()
    {
        add_action('plugins_loaded', [$this, 'init']);
        register_activation_hook(YTAHA_VUEJS_DEV_CHALLENGE_PLUGIN_BASENAME, [$this, 'activation']);
        register_deactivation_hook(YTAHA_VUEJS_DEV_CHALLENGE_PLUGIN_BASENAME, [$this, 'deactivation']);
    }

    /**
     * Get a singleton instance of the class.
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
     * Method called on plugin activation.
     */
    protected function activation()
    {
        $this->createPluginData();
    }

    /**
     * Method called on plugin deactivation.
     */
    public function deactivation()
    {
        $this->clearPluginData();
    }

    /**
     * Create defaults settings value on activation.
     */
    private function createPluginData()
    {
        $user = wp_get_current_user();
        add_option(YTAHA_VUEJS_DEV_CHALLENGE_ROWS_NO, 5);
        add_option(YTAHA_VUEJS_DEV_CHALLENGE_DATE_IN_HUMAN, true);
        add_option(YTAHA_VUEJS_DEV_CHALLENGE_EMAILS, [$user->user_email]);
    }

    /**
     * Remove settings values from database on deactivation.
     */
    private function clearPluginData()
    {
        delete_option(YTAHA_VUEJS_DEV_CHALLENGE_ROWS_NO);
        delete_option(YTAHA_VUEJS_DEV_CHALLENGE_DATE_IN_HUMAN);
        delete_option(YTAHA_VUEJS_DEV_CHALLENGE_EMAILS);
    }

    /**
     * Initialize the plugin.
     */
    public function init()
    {
        if (version_compare(PHP_VERSION, YTAHA_VUEJS_DEV_CHALLENGE_PHP_MIN_VER, '<')) {
            add_action('admin_notices', [$this, 'adminNoticeMinimumPHPVersion']);
            add_action('network_admin_notices', [$this, 'adminNoticeMinimumPHPVersion']);
            return;
        }

        add_action('plugin_action_links_' . YTAHA_VUEJS_DEV_CHALLENGE_PLUGIN_BASENAME, [$this, 'addLinksToPluginActions']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('admin_menu', [$this, 'addAdminMenuPages']);

        // Create an instance of RestfulAPIController class that creates and executes Restful API functions.
        (new RestfulAPIController())->init();
    }

    /**
     * Display admin notice if PHP version is insufficient.
     */
    public function adminNoticeMinimumPHPVersion()
    {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', YTAHA_VUEJS_DEV_CHALLENGE_TEXT_DOMAIN),
            '<strong>' . esc_html(YTAHA_VUEJS_DEV_CHALLENGE_PLUGIN_NAME) . '</strong>',
            '<strong>' . __('PHP', YTAHA_VUEJS_DEV_CHALLENGE_TEXT_DOMAIN) . '</strong>',
            YTAHA_VUEJS_DEV_CHALLENGE_PHP_MIN_VER
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

        deactivate_plugins(YTAHA_VUEJS_DEV_CHALLENGE_PLUGIN_BASENAME);
    }

    /**
     * Enqueue scripts and styles for the admin area.
     */
    public function enqueueScripts()
    {
        $screen = get_current_screen();
        // Do not load app files and assets if we are not present on the app page
        // This check avoids unnecessary resource load and improves performance.
        if (false === strpos($screen->id, YTAHA_VUEJS_DEV_CHALLENGE_PLUGIN_SLUG)) {
            return;
        }

        wp_enqueue_style(YTAHA_VUEJS_DEV_CHALLENGE_PLUGIN_SLUG . '-styles', plugins_url('/public/dist/app.css', __FILE__), array(), null);

        wp_enqueue_script(YTAHA_VUEJS_DEV_CHALLENGE_PLUGIN_SLUG . '-script', plugins_url('/public/dist/app.js', __FILE__), array('wp-i18n'), YTAHA_VUEJS_DEV_CHALLENGE_PLUGIN_VERSION, true);

        $localized_data = [
            'base_rest_url' => esc_url_raw(rest_url()),
            'settings_rest_url' => esc_url_raw(rest_url() . YTAHA_VUEJS_DEV_CHALLENGE_API_NAMESPACE . '/settings'),
            'data_rest_url' => esc_url_raw(rest_url() . YTAHA_VUEJS_DEV_CHALLENGE_API_NAMESPACE . '/data'),
            'nonce' => wp_create_nonce('wp_rest'),
            'app_container' => YTAHA_VUEJS_DEV_CHALLENGE_APP_CONTAINER,
            'text_domain' => YTAHA_VUEJS_DEV_CHALLENGE_TEXT_DOMAIN
        ];

        wp_localize_script(
            YTAHA_VUEJS_DEV_CHALLENGE_PLUGIN_SLUG . '-script',
            'vuejs_dev_challenge',
            $localized_data
        );
    }

    /**
     * Add admin menu pages.
     */
    public function addAdminMenuPages()
    {
        add_menu_page(
            __('VueJS Developer Challenge', YTAHA_VUEJS_DEV_CHALLENGE_TEXT_DOMAIN),
            __('VueJS Challenge', YTAHA_VUEJS_DEV_CHALLENGE_TEXT_DOMAIN),
            'manage_options',
            YTAHA_VUEJS_DEV_CHALLENGE_PLUGIN_SLUG,
            [$this, 'adminPageCallback'],
            'dashicons-shortcode'
        );
    }

    /**
     * Callback for rendering the page containing the vuejs application container that loads the vuejs developer challenge app.
     */
    public function adminPageCallback()
    {
        include_once(plugin_dir_path(__FILE__) . 'admin/views/vuejs-dev-challenge.php');
    }

    /**
     * Add settings link to plugin actions.
     *
     * @param array $settings
     * @return array
     */
    public function addLinksToPluginActions($settings)
    {
        $settings_anchor = sprintf(
            '<a href="%s">%s</a>',
            esc_url(admin_url('admin.php?page=' . YTAHA_VUEJS_DEV_CHALLENGE_PLUGIN_SLUG . '#/settings')),
            __('Settings', YTAHA_VUEJS_DEV_CHALLENGE_TEXT_DOMAIN)
        );

        if (!is_array($settings)) {
            return [$settings_anchor];
        }

        return array_merge($settings, [$settings_anchor]);
    }
}
