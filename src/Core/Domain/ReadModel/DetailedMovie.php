<?php

declare(strict_types=1);

namespace App\Core\Domain\ReadModel;

readonly class DetailedMovie
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public ?string $mainVideoKey,
        public ?string $mainVideoName,
        public ?float $scoreAverage,
        public int $voteCount,
    ) {
    }
}
