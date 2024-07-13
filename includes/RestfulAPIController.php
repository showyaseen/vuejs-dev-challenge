<?php

/**
 * RESTful API Controller
 * @package     ytaha-admin-dashboard
 * @description This class registers and implements API endpoints to provide functionality
 * required to show data on the admin dashboard from an external API.
 *
 *
 * Plugin Name:   Admin Dashboard
 * Plugin URI:    https://github.com/showyaseen/ytaha-admin-dashboard
 * Version:       1.0.0
 * Author:        Yaseen Taha
 * Text Domain:   ytaha-admin-dashboard
 */

namespace YTAHA\Dashboard;

use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

use function current_user_can;

class RestfulAPIController
{
    /**
     * Constructor function
     */
    public function __construct()
    {
    }

    /**
     * Initialize the RESTful API registration.
     *
     * This method registers the 'register_restful_api' using 'rest_api_init' action hook.
     */
    public function init()
    {
        add_action('rest_api_init', [$this, 'register_restful_api']);
    }

    /**
     * Define and register RESTful API routes.
     */
    public function register_restful_api()
    {
        $endpoints = [
            ['route' => '/settings', 'method' => 'GET', 'callback' => [$this, 'get_settings']],
            ['route' => '/settings', 'method' => 'PUT', 'callback' => [$this, 'update_settings']],
            ['route' => '/data', 'method' => 'GET', 'callback' => [$this, 'get_data']]
        ];

        foreach ($endpoints as $endpoint) {
            register_rest_route(YTAHA_ADMIN_DASHBOARD_API_NAMESPACE, $endpoint['route'], [
                'methods' => $endpoint['method'],
                'callback' => $endpoint['callback'],
                'permission_callback' =>  [$this, 'rest_permission_callback']
            ]);
        }
    }

    /**
     * Permission callback for RESTful API.
     * Only users with admin capabilities can access the API.
     *
     * @return bool|WP_Error
     */
    public function rest_permission_callback()
    {
        $user = wp_get_current_user();

        if (!in_array('administrator', $user->roles) || false === current_user_can('manage_options')) {
            return new WP_Error('rest_forbidden', __('Unauthenticated', YTAHA_ADMIN_DASHBOARD_TEXT_DOMAIN), ['status' => 401]);
        }

        return true;
    }

    /**
     * Get all settings from database.
     *
     * This function retrieves all settings for the admin dashboard page.
     * It retrieves the values of three options ('row_number', 'is_human', and 'extra_email')
     * If any of the options don't exist, default values are used.
     *
     * @param WP_REST_Request $request The REST request object.
     * @return WP_REST_Response The REST response object containing the settings data.
     */
    public function get_settings(WP_REST_Request $request)
    {
        $user = wp_get_current_user();
        $response_data = [
            'row_number' => get_option(YTAHA_ADMIN_DASHBOARD_ROWS_NO, 5),
            'is_human' => get_option(YTAHA_ADMIN_DASHBOARD_DATE_IN_HUMAN, true),
            'extra_email' => get_option(YTAHA_ADMIN_DASHBOARD_EMAILS, [$user->user_email]),
        ];

        return new WP_REST_Response($response_data, 200);
    }

    /**
     * Update settings based on the REST request.
     *
     * This function updates the settings in database. It retrieves the new 'settings' data from the request payload and performs validations.
     * If the validation fails, it returns a WP_Error object with the corresponding error messages.
     * If the validation passes, it updates the corresponding options.
     * Finally, it returns a WP_REST_Response object with the updated settings.
     *
     * @param WP_REST_Request $request The REST request object.
     * @return WP_REST_Response|WP_Error The REST response object containing the updated settings.
     */
    public function update_settings(WP_REST_Request $request)
    {
        $errors = [];
        $extra_email = [];
        // Retrieve the 'settings' data from the request payload.
        $data = $request->get_json_params();
        $settings = $data['settings'] ?? [];

        // Validate and Sanitize 'row_number' setting.
        if (array_key_exists('row_number', $settings)) {
            // Sanitize row_number setting.
            $row_number = !empty($settings['row_number']) ? absint($settings['row_number']) : 0;
            if (
                !is_numeric($row_number) ||
                $row_number > 5 ||
                $row_number < 1
            ) {
                $errors['row_number'] = __('Server Error: Rows number setting should take value from 1 to 5.', YTAHA_ADMIN_DASHBOARD_TEXT_DOMAIN);
            } else {
                // Update 'row_number' setting option.
                update_option(YTAHA_ADMIN_DASHBOARD_ROWS_NO, $row_number);
            }
        }

        // Sanitize and Validate 'extra_email' setting list.
        if (array_key_exists('extra_email', $settings)) {
            if (empty($settings['extra_email']) || !is_array($settings['extra_email'])) {
                $errors['extra_email'] = __('Server Error: Extra Emails list is empty.', YTAHA_ADMIN_DASHBOARD_TEXT_DOMAIN);
            } else {
                foreach ($settings['extra_email'] as $email) {
                    // Sanitize email setting value.
                    $email = sanitize_email($email);
                    // Validate if the email value follow the correct emails format.
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors['extra_email'] = __('Server Error: Extra Email List is invalid.', YTAHA_ADMIN_DASHBOARD_TEXT_DOMAIN);
                        break;
                    } else {
                        // Add Sanitized and Validated email to the list.
                        $extra_email[] = $email;
                    }
                }
                // Update 'extra_email' setting in database if all emails in the list is valid.
                if (empty($errors['extra_email'])) {
                    update_option(YTAHA_ADMIN_DASHBOARD_EMAILS, $extra_email);
                }
            }
        }

        // Sanitize and Update 'is_human' setting option.
        if (array_key_exists('is_human', $settings)) {
            $is_human = array_key_exists('is_human', $settings) ? absint($settings['is_human']) : 0;
            update_option(YTAHA_ADMIN_DASHBOARD_DATE_IN_HUMAN, $is_human);
        }

        // If there are validation errors, return a WP_Error object.
        if (!empty($errors)) {
            return new WP_Error(
                'invalid_data',
                __('Validation failed.', YTAHA_ADMIN_DASHBOARD_TEXT_DOMAIN),
                ['status' => 400, 'errors' => $errors]
            );
        }

        // Return a WP_REST_Response object with the updated settings data
        // and then setting in Vuex store is updated as well.
        return new WP_REST_Response($settings, 200);
    }

    /**
     * Retrieves table & graph data from the remote server and caches it for efficient retrieval.
     *
     * This function checks if the data is already cached in the options. If the cached data
     * is not available or has expired, it fetches the data from the remote server, processes
     * and sanitizes it, and then caches the sanitized data along with the timestamp.
     *
     * @param WP_REST_Request $request The REST request object.
     *
     * @return WP_REST_Response|WP_Error Returns a REST response containing the sanitized data
     *                                  if successful, or a WP_Error object on failure.
     */
    public function get_data(WP_REST_Request $request)
    {
        // Check if the data is already cached in the options.
        $cached_data = get_option('cached_data');

        // Check if the timestamp option is set.
        $timestamp = get_option('cached_data_timestamp', 0);

        // Check if the cached data is still valid (less than one hour old).
        if (false === $cached_data || false === $timestamp || current_time('timestamp') - $timestamp > HOUR_IN_SECONDS) {
            // If not cached or expired, fetch data from the remote server.
            $remote_data = wp_remote_get(YTAHA_ADMIN_DASHBOARD_REMOTE_DATA_URL);

            if (!is_wp_error($remote_data) && 200 === wp_remote_retrieve_response_code($remote_data)) {
                // Parse the remote data.
                $parsed_data = json_decode(wp_remote_retrieve_body($remote_data), true);

                // Sanitize and escape remote data for the graph data.
                $sanitized_graph = [];
                foreach ($parsed_data['graph'] as $graph) {
                    $sanitized_graph[] = [
                        'date' => !empty($graph['date']) ? absint($graph['date']) : 0,
                        'value' => !empty($graph['value']) ? absint($graph['value']) : 0
                    ];
                }

                // Sanitize and escape remote data for the table data.
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

                // Cache the sanitized data and timestamp in options.
                update_option('cached_data', $sanitized_data, false);
                update_option('cached_data_timestamp', current_time('timestamp'), false);

                // Return sanitized data after cached in the database
                return new WP_REST_Response($sanitized_data, 200);
            } elseif (false === $cached_data) {
                // Handle error if cache is empty and failed to fetch remote data.
                return new WP_Error(
                    'cannot_fetch_remote_data',
                    __('Unable to fetch the remote data.', YTAHA_ADMIN_DASHBOARD_TEXT_DOMAIN),
                    ['status' => 400]
                );
            }
        }

        // Return the cached data if it's still valid.
        return new WP_REST_Response($cached_data, 200);
    }
}
