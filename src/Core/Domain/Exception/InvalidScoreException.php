<?php

declare(strict_types=1);

namespace App\Core\Domain\Exception;

class InvalidScoreException extends \DomainException
{
    private const MESSAGE = 'Score need to be between 1 and 5 : "%s" provided';

    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function fromBadScore(int $score): self
    {
        return new self(sprintf(self::MESSAGE, $score));
    }
}
