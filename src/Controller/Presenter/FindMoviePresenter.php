<?php

namespace App\Controller\Presenter;

use App\Core\UseCase\FindMovies\FindMoviesPresenter as Presenter;

class FindMoviePresenter implements Presenter
{
    public function present(array $movies): array
    {
        $firstMovie = array_shift($movies);

        return [
            'mainMovieId' => $firstMovie->id ?? null,
            'list' => $movies ?? null,
        ];
    }
}