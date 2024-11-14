<?php

declare(strict_types=1);

namespace App\Core\UseCase\RateMovie;

readonly class RateMovieRequest
{
    public function __construct(
        public int $movieId,
        public int $score,
    ) {
    }
}
