<?php

declare(strict_types=1);

namespace Rabbit\LiveChatPluginCore\Exception;

use Exception;
use Throwable;

class AuthenticationResponseException extends Exception
{
    public static function becauseOfMissingKey(string $missingKey): self
    {
        return new self(sprintf('Unable to create AuthenticationResponse. The "%s" key is missing inside the data.', $missingKey));
    }

    public static function becauseOfMissingValue(string $requiredKey): self
    {
        return new self(sprintf('Unable to create AuthenticationResponse. No value provided for property "%s".', $requiredKey));
    }

    public static function becauseOfDateTimeImmutableException(Throwable $e): self
    {
        return new self('Unable to create DateTimeImmutable', previous: $e);
    }
}
