<?php

declare(strict_types=1);

namespace App\Core\UseCase\SearchMovies;

use App\Core\Gateway\ListedMovieFinder;

readonly class SearchMovies
{
    public function __construct(private ListedMovieFinder $listDetailedMovieFinder)
    {
    }

    public function __invoke(SearchMoviesRequest $request, SearchMoviesPresenter $presenter): mixed
    {
        return $presenter->present(
            $this->listDetailedMovieFinder->byPartialTitle($request->partialTitle)
        );
    }
}
