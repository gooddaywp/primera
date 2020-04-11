<?php

declare(strict_types=1);

namespace App\Controllers;

defined('ABSPATH') || exit;

trait AppAsync
{
    final public function add_ajax_actions()
    {
        add_ajax_action('do-something', [$this, 'ajax_do_something']);
    }

    final public function register_rest_routes()
    {
        register_rest_route('primera/v1', '/do-something/', [
            'methods'  => 'POST',
            'callback' => [$this, 'rest_do_something'],
        ], true);
    }

    // TODO: Check if Laravel's `\Request $request` can be used as the methods parameter.
    public static function ajax_do_something()
    {
        // Validate a nonce, other $_POST/$_REQUEST data elements and execute some code.
        // It's possible to check if a user is logged-in or not via `is_user_logged_in()`.
        // You can use PHP's `parse_str` function to decode jQuery's `form.serialize`.
        // Use `wp_json_send`, or `wp_send_json_success`, or `wp_send_json_error to return data to JS.

        // wp_send_json_success();
    }

    public static function rest_do_something(\WP_REST_Request $request)
    {
        // $response = ['success' => true];
        // return \rest_ensure_response($response);
    }
}
