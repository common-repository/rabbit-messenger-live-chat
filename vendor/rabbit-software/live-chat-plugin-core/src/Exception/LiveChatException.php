<?php

declare(strict_types=1);

namespace Rabbit\LiveChatPluginCore\Exception;

use Exception;
use JsonException;
use Throwable;

class LiveChatException extends Exception
{
    public static function becauseFailedToEncode(JsonException $e): self
    {
        return new self('Failed to encode message', previous: $e);
    }

    public static function becauseFailedToDecode(Exception|JsonException $e): self
    {
        return new self('Failed to decode message', previous: $e);
    }

    public static function becauseFailedToMakeRequest(Throwable $e): self
    {
        return new self('Failed to make request', previous: $e);
    }

    public static function becauseOfBadResponse(int $responseCode): self
    {
        return new self(sprintf('Got a bad response, received a %s HTTP status code.', $responseCode));
    }

    public static function becauseOfResponseHasNoData(): self
    {
        return new self('Received a response, but no data received.');
    }

    public static function becauseUnableToCreateAuthenticationResponse(AuthenticationResponseException $e): self
    {
        return new self('Unable to create AuthenticationResponse object.', previous: $e);
    }
}
