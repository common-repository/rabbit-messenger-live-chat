<?php

declare(strict_types=1);

/**
 * Rabbit Messenger Live-chat
 *
 * @author   Rabbit
 * @license  GPLv3
 * @link     https://www.rabbit.nl
 * @package  rabbit-messenger-live-chat
 */

/**
 * Plugin Name:       Rabbit Messenger Live-chat
 * Author URI:        https://www.rabbit.nl
 * Description:       A plugin to show the Rabbit Messenger Live-chat in your WordPress installation
 * Version:           0.1.3
 * Author:            Rabbit
 * License:           GPLv3
 * Network:           true
 * Requires at least: 6.0
 * Requires PHP:      8.0
 */


/*
 * Exit if called directly.
 * PHP version check and exit.
 */

use Rabbit\RabbitMessengerLiveChat\Bootstrap;

if (!defined('WPINC')) {
    die;
}

define('RMLC_VERSION', '{{plugin_version}}');
define('RMLC_TEXTDOMAIN', 'rabbit-messenger-live-chat');
define('RMLC_NAME', '{{plugin_name}}');
define('RMLC_PLUGIN_ROOT', plugin_dir_path(__FILE__));
define('RMLC_PLUGIN_ABSOLUTE', __FILE__);
define('RMLC_MIN_PHP_VERSION', '8.0');
define('RMLC_WP_VERSION', '5.3');

// Load the Composer autoloader.
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    // Avoids a redeclaration error for move_dir() from Shim.php.
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require __DIR__ . '/vendor/autoload.php';
}


// Check for composer autoloader.
if (!class_exists(Bootstrap::class)) {
    require_once __DIR__ . '/src/Bootstrap.php';
    (new Bootstrap(__FILE__))->deactivate_die();
}

$bootstrap = new Bootstrap(__FILE__);

$bootstrap->init();

