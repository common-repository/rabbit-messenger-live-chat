<?php

declare(strict_types=1);

namespace Rabbit\RabbitMessengerLiveChat\ValueObject;

use Rabbit\RabbitMessengerLiveChat\Exception\InvalidDataException;

class DisplayOptionsConfig
{

    private function __construct(
        public string $position,
        public string $zIndex,
        public string $left,
        public string $right,
        public string $bottom,
        public string $top,
        public string $margin,
    )
    {
    }

    /**
     * @throws InvalidDataException
     */
    public static function createFromRequest(array $data): self
    {
        return new self(
            $data['position'] ?? 'fixed',
            $data['z_index'] ?? '10',
            $data['left'] ?? 'inherit',
            $data['right'] ?? '0',
            $data['bottom'] ?? '0',
            $data['top'] ?? 'inherit',
            $data['margin'] ?? '20px',
        );
    }
}
