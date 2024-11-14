<?php

declare(strict_types=1);

namespace App\Core\Domain\Entity;

readonly class GenderId
{
    public static function fromInt(int $id): self
    {
        return new self($id);
    }

    public function getValue(): int
    {
        return $this->id;
    }

    private function __construct(private int $id)
    {
    }
}
