<?php

declare(strict_types=1);

namespace Rabbit\RabbitMessengerLiveChat\Service;

use Rabbit\RabbitMessengerLiveChat\Exception\InvalidDataException;
use Rabbit\RabbitMessengerLiveChat\ValueObject\DisplayOptionsConfig;
use Rabbit\RabbitMessengerLiveChat\ValueObject\LiveChatConfig;

class SettingsService
{

    public string $pluginRepoUrl;
    public string $pluginRepoAssetsUrl;

    public function __construct()
    {
        $pluginRepoUrl = null;
        if (defined('RMLC_PLUGIN_REPO_URL')) {
            $pluginRepoUrl = RMLC_PLUGIN_REPO_URL;
        }
        $pluginRepoAssetUrl = null;
        if (defined('RMLC_PLUGIN_REPO_ASSET_URL')) {
            $pluginRepoAssetUrl = RMLC_PLUGIN_REPO_ASSET_URL;
        }
        $this->pluginRepoUrl = $pluginRepoUrl ?: LiveChatConfig::PLUGIN_REPO_PROD_URL;
        $this->pluginRepoAssetsUrl = $pluginRepoAssetUrl ?: LiveChatConfig::PLUGIN_REPO_PROD_ASSET_URL;
    }

    public function getSettings(): ?LiveChatConfig
    {
        $settingsData = get_option(RMLC_TEXTDOMAIN . '_options', []);

        if (!is_array($settingsData)) {
            $settingsData = [];
        }
        try {
            return LiveChatConfig::createFromRequest($settingsData);
        } catch (InvalidDataException) {
            return null;
        }
    }

    public function getDisplayOptions(): ?DisplayOptionsConfig
    {
        $displayOptions = get_option(RMLC_TEXTDOMAIN . '_display_options', []);
        if (!is_array($displayOptions)) {
            $displayOptions = [];
        }

        return DisplayOptionsConfig::createFromRequest($displayOptions);
    }

}
