<?php

declare(strict_types=1);

namespace App\Core\UseCase\SearchMovies;

use App\Core\Domain\ReadModel\ListedMovie;

interface SearchMoviesPresenter
{
    /**
     * @param array<ListedMovie> $movies
     */
    public function present(array $movies): mixed;
}
