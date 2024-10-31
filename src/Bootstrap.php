<?php

declare(strict_types=1);

namespace Rabbit\RabbitMessengerLiveChat;

/*
 * Exit if called directly.
 */

use Rabbit\RabbitMessengerLiveChat\Admin\Menu;
use Rabbit\RabbitMessengerLiveChat\Api\Routes;
use Rabbit\RabbitMessengerLiveChat\Frontend\Assets;
use Rabbit\RabbitMessengerLiveChat\Settings\Settings;

if (!defined('WPINC')) {
    die;
}

class Bootstrap
{
    /**
     * Holds main plugin file.
     *
     * @var string
     */
    protected string $file;

    /**
     * Holds main plugin directory.
     *
     * @var string
     */
    protected string $dir;

    /**
     * Constructor.
     *
     * @param string $file Main plugin file.
     * @return void
     */
    public function __construct(string $file)
    {
        $this->file = $file;
        $this->dir = dirname($file);
    }


    /**
     * Deactivate plugin and die as composer autoloader not loaded.
     *
     * @return void
     */
    public function deactivate_die()
    {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        \deactivate_plugins(plugin_basename($this->file));

        $message = sprintf(
        /* translators: %1: opening tag, %2: closing tag */
            __('RabbitMessengerLiveChat is missing required composer dependencies. %1$sLearn more.%2$s', 'rabbit-messenger-live-chat'),
            '<a href="https://www.rabbit.nl" target="_blank" rel="noreferrer">',
            '</a>'
        );

        wp_die(wp_kses_post($message));
    }

    public function init()
    {
        $menu = new Menu();
        $routes = new Routes();
        $settings = new Settings();
        $assets = new Assets();
    }

}
