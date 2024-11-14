<?php

declare(strict_types=1);

namespace App\Core\UseCase\FindMovies;

use App\Core\Domain\ReadModel\ListedMovie;

interface FindMoviesPresenter
{
    /**
     * @param array<ListedMovie> $movies
     */
    public function present(array $movies): mixed;
}
