<?php

declare(strict_types=1);

namespace Rabbit\LiveChatPluginCore\ValueObject;

use DateTimeImmutable;
use JsonSerializable;
use Rabbit\LiveChatPluginCore\Exception\AuthenticationResponseException;
use Throwable;

class AuthenticationResponse implements JsonSerializable
{
    public function __construct(
        private string $externalId,
        private string $token,
        private string $refreshToken,
        private DateTimeImmutable $refreshTokenExpiresAt,
    ) {
    }

    /**
     * @throws AuthenticationResponseException
     */
    public static function createFromArray(array $data): self
    {
        $requiredKeys = [
            'externalId',
            'token',
            'refreshToken',
            'refreshTokenExpiresAt',
        ];

        foreach ($requiredKeys as $requiredKey) {
            if (!array_key_exists($requiredKey, $data)) {
                throw AuthenticationResponseException::becauseOfMissingKey($requiredKey);
            }
            if (empty($data[$requiredKey])) {
                throw AuthenticationResponseException::becauseOfMissingValue($requiredKey);
            }
        }

        try {
            $refreshTokenExpiresAt = new DateTimeImmutable($data['refreshTokenExpiresAt']);
        } catch (Throwable $e) {
            throw AuthenticationResponseException::becauseOfDateTimeImmutableException($e);
        }

        return new self(
            $data['externalId'],
            $data['token'],
            $data['refreshToken'],
            $refreshTokenExpiresAt,
        );
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function getRefreshTokenExpiresAt(): DateTimeImmutable
    {
        return $this->refreshTokenExpiresAt;
    }

    public function jsonSerialize(): array
    {
        return [
            'externalId' => $this->externalId,
            'token' => $this->token,
            'refreshToken' => $this->refreshToken,
            'refreshTokenExpiresAt' => $this->refreshTokenExpiresAt,
        ];
    }
}
