<?php

declare(strict_types=1);

namespace App\Core\Domain\Entity;

class Movie
{
    public function __construct(
        readonly public MovieId $id,
    ) {
    }
}
