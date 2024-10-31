<?php

declare(strict_types=1);

namespace Rabbit\RabbitMessengerLiveChat\Admin;
class Menu
{

    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_live_chat_menu_item']);
    }

    public function add_live_chat_menu_item()
    {
        add_menu_page(
            'Rabbit Messenger Live-chat',
            'Rabbit Messenger Live-chat',
            'manage_options',
            'rabbit-messenger-live-chat',
            fn() => include_once(RMLC_PLUGIN_ROOT . 'templates/settings.php'),
            'dashicons-admin-comments',
        );
    }
}

