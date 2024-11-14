<?php

declare(strict_types=1);

namespace App\Core\Domain\ReadModel;

readonly class DetailedMovie
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public string $youtubeKey,
        public string $videoName,
        public float $scoreAverage,
        public int $voteCount,
    ) {
    }
}
