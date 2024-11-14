<?php

declare(strict_types=1);

namespace App\Core\UseCase\SearchMovies;

readonly class SearchMoviesRequest
{
    public function __construct(public string $partialTitle)
    {
    }
}
