<?php

declare(strict_types=1);

namespace App\Core\UseCase\RateMovie;

use App\Core\Domain\Entity\MovieId;
use App\Core\Gateway\MovieRater;

readonly class RateMovie
{
    public function __construct(
        private MovieRater $movieRater,
    ) {
    }

    public function __invoke(RateMovieRequest $request): void
    {
        $this->movieRater->rate(MovieId::fromInt($request->movieId), $request->score);
    }
}
