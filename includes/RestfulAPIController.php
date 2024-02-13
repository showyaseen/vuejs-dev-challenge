<?php

/**
 * Restful API Controller this is a class that register and implements api endpoints provide
 * functionality that required by vuejs challenge developer app
 *
 * @package ytaha-vuejs-dev-challenge
 */

namespace YaseenTaha\VueJSDevChallenge;

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
     * This method registers the 'registerRestfulAPI' using 'rest_api_init' action hook.
     */
    public function init()
    {
        add_action('rest_api_init', [$this, 'registerRestfulAPI']);
    }

    /**
     * Define and register RESTful API routes.
     */
    public function registerRestfulAPI()
    {
        $endpoints = [
            ['route' => '/settings', 'method' => 'GET', 'callback' => [$this, 'getSettings']],
            ['route' => '/settings', 'method' => 'PUT', 'callback' => [$this, 'updateSettings']],
            ['route' => '/data', 'method' => 'GET', 'callback' => [$this, 'getData']]
        ];

        foreach ($endpoints as $endpoint) {
            register_rest_route(YTAHA_VUEJS_DEV_CHALLENGE_API_NAMESPACE, $endpoint['route'], [
                'methods' => $endpoint['method'],
                'callback' => $endpoint['callback'],
                'permission_callback' =>  [$this, 'restPermissionCallback']
            ]);
        }
    }

    /**
     * Permission callback for RESTful API.
     * only users with admin capabilities can access the API.
     *
     * @return bool|WP_Error
     */
    public function restPermissionCallback()
    {
        $user = wp_get_current_user();

        if (!in_array('administrator', $user->roles) || false === current_user_can('manage_options')) {
            return new WP_Error('rest_forbidden', __('Unauthenticated', YTAHA_VUEJS_DEV_CHALLENGE_TEXT_DOMAIN), ['status' => 401]);
        }

        return true;
    }

    /**
     * Get all settings from database.
     *
     * This function retrieves all settings for the Vue.js development challenge app.
     * It retrieves the values of three options ('rowNumber', 'isHuman', and 'extraEmail')
     * If any of the options don't exist, default values are used.
     *
     * @param WP_REST_Request $request The REST request object.
     * @return WP_REST_Response The REST response object containing the settings data.
     */
    public function getSettings(WP_REST_Request $request)
    {
        $user = wp_get_current_user();
        $response_data = [
            'rowNumber' => get_option(YTAHA_VUEJS_DEV_CHALLENGE_ROWS_NO, 5),
            'isHuman' => get_option(YTAHA_VUEJS_DEV_CHALLENGE_DATE_IN_HUMAN, true),
            'extraEmail' => get_option(YTAHA_VUEJS_DEV_CHALLENGE_EMAILS, [$user->user_email]),
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
    public function updateSettings(WP_REST_Request $request)
    {
        // Retrieve the 'settings' data from the request payload.
        $data = $request->get_json_params();
        $settings = $data['settings'] ?? [];

        // Validate and Sanitize 'rowNumber' setting.
        if (array_key_exists('rowNumber', $settings)) {
            // Sanitize rowNumber setting.
            $rowNumber = !empty($settings['rowNumber']) ? absint($settings['rowNumber']) : 0;
            if (
                !is_numeric($rowNumber) ||
                $rowNumber > 5 ||
                $rowNumber < 1
            ) {
                $errors['rowNumber'] = __('Server Error: Rows number setting should take value from 1 to 5.', YTAHA_VUEJS_DEV_CHALLENGE_TEXT_DOMAIN);
            } else {
                // Update 'rowNumber' setting option.
                update_option(YTAHA_VUEJS_DEV_CHALLENGE_ROWS_NO, $rowNumber);
            }
        }

        $errors = [];

        // Sanitize and Validate 'extraEmail' setting list.
        if (array_key_exists('extraEmail', $settings)) {
            if (empty($settings['extraEmail']) || !is_array($settings['extraEmail'])) {
                $errors['extraEmail'] = __('Server Error: Extra Emails list is empty.', YTAHA_VUEJS_DEV_CHALLENGE_TEXT_DOMAIN);
            } else {
                foreach ($settings['extraEmail'] as $email) {
                    // Sanitize email setting value.
                    $email = sanitize_email($email);
                    // Validate if the email value follow the correct emails format.
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors['extraEmail'] = __('Server Error: Extra Email List is invalid.', YTAHA_VUEJS_DEV_CHALLENGE_TEXT_DOMAIN);
                        break;
                    } else {
                        // Add Sanitized and Validated email to the list.
                        $extraEmail[] = $email;
                    }
                }
                // Update 'extraEmail' setting in database if all emails in the list is valid.
                if (empty($errors['extraEmail'])) {
                    update_option(YTAHA_VUEJS_DEV_CHALLENGE_EMAILS, $extraEmail);
                }
            }
        }

        // Sanitize and Update 'isHuman' setting option.
        if (array_key_exists('isHuman', $settings)) {
            $isHuman = array_key_exists('isHuman', $settings) ? absint($settings['isHuman']) : 0;
            update_option(YTAHA_VUEJS_DEV_CHALLENGE_DATE_IN_HUMAN, $isHuman);
        }

        // If there are validation errors, return a WP_Error object.
        if (!empty($errors)) {
            return new WP_Error(
                'invalid_data',
                __('Validation failed.', YTAHA_VUEJS_DEV_CHALLENGE_TEXT_DOMAIN),
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
    public function getData(WP_REST_Request $request)
    {
        // Check if the data is already cached in the options.
        $cached_data = get_option('cached_data');

        // Check if the timestamp option is set.
        $timestamp = get_option('cached_data_timestamp', 0);

        // Check if the cached data is still valid (less than one hour old).
        if (false === $cached_data || false === $timestamp || current_time('timestamp') - $timestamp > HOUR_IN_SECONDS) {
            // If not cached or expired, fetch data from the remote server.
            $remote_data = wp_remote_get(YTAHA_VUEJS_DEV_CHALLENGE_REMOTE_DATA_URL);

            if (!is_wp_error($remote_data) && wp_remote_retrieve_response_code($remote_data) === 200) {
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

                // Return sanitized data afer cached in database
                return new WP_REST_Response($sanitized_data, 200);
            } elseif (false === $cached_data) {
                // Handle error if cache is empty and failed to fetch remote data.
                return new WP_Error(
                    'cannot_fetch_remote_data',
                    __('Unable to fetch the remote data.', YTAHA_VUEJS_DEV_CHALLENGE_TEXT_DOMAIN),
                    ['status' => 400]
                );
            }
        }

        // Return the cached data if it's still valid.
        return new WP_REST_Response($cached_data, 200);
    }
}
