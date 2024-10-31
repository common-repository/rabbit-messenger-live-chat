<?php

declare(strict_types=1);

namespace Rabbit\RabbitMessengerLiveChat\Api;

use Rabbit\RabbitMessengerLiveChat\Controller\LoginController;
use WP_REST_Server;

class Routes
{
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'prefix_register_example_routes']);
    }

    public function prefix_register_example_routes()
    {
        register_rest_route('rmlc', '/login', [
            // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
            'methods' => WP_REST_Server::CREATABLE,
            // Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
            'callback' => function () {
                $controller = new LoginController();
                return $controller->handle();
            },
            'permission_callback' => '__return_true'
        ]);
    }
}
