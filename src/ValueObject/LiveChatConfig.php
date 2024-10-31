<?php

declare(strict_types=1);

namespace Rabbit\RabbitMessengerLiveChat\ValueObject;

use Rabbit\RabbitMessengerLiveChat\Exception\InvalidDataException;

class LiveChatConfig
{
    public const PLUGIN_REPO_PROD_URL = 'plugins.rabbit.nl';
    public const PLUGIN_REPO_PROD_ASSET_URL = 'cdn.plugins.rabbit.nl';

    private const REQUIRED_KEYS = [
        'api_key',
        'api_secret',
        'title',
        'description',
        'whatsapp_url',
    ];

    private function __construct(
        public string  $apiKey,
        public string  $apiSecret,
        public ?string $avatarAssetId,
        public string  $title,
        public string  $description,
        public string  $whatsAppUrl,
        public string  $loginUrl,
    )
    {
    }

    /**
     * @throws InvalidDataException
     */
    public static function createFromRequest(array $data): self
    {
        foreach (self::REQUIRED_KEYS as $key) {
            if (
                !array_key_exists($key, $data) ||
                empty($data[$key])
            ) {
                throw InvalidDataException::becauseOfMissingData(esc_html($key));
            }
        }

        return new self(
            $data['api_key'],
            $data['api_secret'],
            $data['avatar'] ?? null,
            $data['title'],
            $data['description'],
            $data['whatsapp_url'],
            '/actions/rabbit-messenger-live-chat/login/get-token'
        );
    }
}
