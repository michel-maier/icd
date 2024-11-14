<?php

declare(strict_types=1);

namespace App\Core\UseCase\FindMovies;

use App\Core\Domain\Entity\GenderId;
use App\Core\Gateway\ListedMovieFinder;

readonly class FindMovies
{
    public function __construct(private ListedMovieFinder $listDetailedMovieFinder)
    {
    }

    public function __invoke(FindMoviesRequest $request, FindMoviesPresenter $presenter): mixed
    {
        $genderIds = array_map(fn (int $id): GenderId => GenderId::fromInt($id), $request->genderIds);

        return $presenter->present($this->listDetailedMovieFinder->byGenderIds($genderIds));
    }
}
