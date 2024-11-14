<?php

declare(strict_types=1);

namespace App\Core\Domain\Exception;

use App\Core\Domain\Entity\MovieId;

class MovieNotFoundException extends \DomainException
{
    private const MESSAGE = 'Movie "%s" not found';

    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function fromId(MovieId $id)
    {
        return new self(sprintf(self::MESSAGE, $id->getValue()));
    }
}
