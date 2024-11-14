<?php

declare(strict_types=1);

namespace App\Core\UseCase\RetrieveMovie;

use App\Core\Domain\Entity\MovieId;
use App\Core\Gateway\DetailedMovieRetriever;

readonly class RetrieveMovie
{
    public function __construct(private DetailedMovieRetriever $detailedMovieRetriever)
    {
    }

    public function __invoke(RetrieveMovieRequest $request, RetrieveMoviePresenter $presenter): mixed
    {
        return $presenter->present(
            $this->detailedMovieRetriever->retrieve(MovieId::fromInt($request->movieId))
        );
    }
}
