<?php

declare(strict_types=1);

namespace App\Core\UseCase\RetrieveMovie;

readonly class RetrieveMovieRequest
{
    public function __construct(public int $movieId)
    {
    }
}
