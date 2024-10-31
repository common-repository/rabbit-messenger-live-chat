<?php

declare(strict_types=1);

namespace Rabbit\RabbitMessengerLiveChat\Controller;

use GuzzleHttp\Client;
use Rabbit\RabbitMessengerLiveChat\Service\SettingsService;
use Rabbit\LiveChatPluginCore\Exception\LiveChatException;
use Rabbit\LiveChatPluginCore\LiveChatService;
use WP_Error;

class LoginController
{

    private SettingsService $settingsService;
    private LiveChatService $liveChatService;

    public function __construct()
    {
        $this->settingsService = new SettingsService();

        $liveChatConfig = $this->settingsService->getSettings();

        $this->liveChatService = new LiveChatService(
            $liveChatConfig->apiKey,
            $liveChatConfig->apiSecret,
            new Client(['http_errors' => false]),
            $this->settingsService->pluginRepoUrl,
        );
    }

    public function handle()
    {
        try {
            $token = $this->liveChatService->fetchToken();
        } catch (LiveChatException $e) {
            return rest_ensure_response(new WP_Error(401, $e->getMessage()));
        }
        return rest_ensure_response($token);
    }
}
