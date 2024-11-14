<?php

declare(strict_types=1);

namespace App\Core\UseCase\FindMovies;

readonly class FindMoviesRequest
{
    /**
     * @param array<int> $genderIds
     */
    public function __construct(public array $genderIds)
    {
    }
}
