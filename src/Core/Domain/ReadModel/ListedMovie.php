<?php

declare(strict_types=1);

namespace App\Core\Domain\ReadModel;

readonly class ListedMovie
{
    public function __construct(
        public int $id,
        public string $title,
        public \DateTimeImmutable $releaseDate,
        public string $description,
        public string $posterUrl,
        public float $scoreAverage,
        public int $voteCount,
    ) {
    }
}
