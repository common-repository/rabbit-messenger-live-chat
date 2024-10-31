<?php

declare(strict_types=1);

namespace Rabbit\RabbitMessengerLiveChat\Frontend;

use Rabbit\RabbitMessengerLiveChat\Service\SettingsService;
use Rabbit\RabbitMessengerLiveChat\ValueObject\DisplayOptionsConfig;
use Rabbit\RabbitMessengerLiveChat\ValueObject\LiveChatConfig;

class Assets
{

    private ?LiveChatConfig $liveChatConfig;
    private ?DisplayOptionsConfig $displayOptionsConfig;
    private SettingsService $settingsService;

    public function __construct()
    {
        $this->settingsService = new SettingsService();

        $this->liveChatConfig = $this->settingsService->getSettings();
        if (!$this->liveChatConfig) {
            return;
        }
        $this->displayOptionsConfig = $this->settingsService->getDisplayOptions();
        if (!$this->displayOptionsConfig) {
            return;
        }

        add_action('wp_enqueue_scripts', [$this, 'register_assets']);
        add_action('wp_body_open', [$this, 'inject_html_template']);

    }

    public function register_assets()
    {
        wp_enqueue_style(RMLC_TEXTDOMAIN . '-styles', sprintf('//%s/styles.css', $this->settingsService->pluginRepoAssetsUrl), [], RMLC_VERSION);
        wp_enqueue_script(RMLC_TEXTDOMAIN . '-polyfills', sprintf('//%s/polyfills.js', $this->settingsService->pluginRepoAssetsUrl), [], RMLC_VERSION, ['in_footer' => true]);
        wp_enqueue_script(RMLC_TEXTDOMAIN . '-main', sprintf('//%s/main.js', $this->settingsService->pluginRepoAssetsUrl), [], RMLC_VERSION, ['in_footer' => true]);
    }

    public function inject_html_template()
    {
        $imgUrl = sprintf('//%s/assets/images/default-avatar.svg', $this->settingsService->pluginRepoAssetsUrl);
        if ($this->liveChatConfig?->avatarAssetId) {
            $imgUrl = wp_get_attachment_image_url($this->liveChatConfig->avatarAssetId);
        }

        $displayOptions = [
            'z-index' => $this->displayOptionsConfig->zIndex,
            'position' => $this->displayOptionsConfig->position,
            'left' => $this->displayOptionsConfig->left,
            'right' => $this->displayOptionsConfig->right,
            'bottom' => $this->displayOptionsConfig->bottom,
            'top' => $this->displayOptionsConfig->top,
            'margin' => $this->displayOptionsConfig->margin,
        ];

        echo sprintf(
            '<rabbit-messenger-live-chat-widget
                        avatar-url="%s"
                        login-url="%s"
                        whatsapp-url="%s"
                        welcome-title="%s"
                        welcome-description="%s"
                        display-options="%s"
                    ></rabbit-messenger-live-chat-widget>',
            esc_html($imgUrl),
            esc_html(rest_url('/rmlc/login')),
            esc_html($this->liveChatConfig?->whatsAppUrl),
            esc_html($this->liveChatConfig?->title),
            esc_html($this->liveChatConfig?->description),
            esc_html(wp_json_encode($displayOptions))
        );
    }
}
