<?php

declare(strict_types=1);

namespace App\Tests\Gateway;

use App\Core\Domain\Entity\MovieId;
use App\Core\Domain\Exception\MovieNotFoundException;
use App\Core\Domain\ReadModel\DetailedMovie;
use App\Core\Gateway\DetailedMovieRetriever;

class InMemoryDetailedMovieRetriever implements DetailedMovieRetriever
{
    /** @var array<int, DetailedMovie> */
    private array $movies = [];

    public function retrieve(MovieId $id): DetailedMovie
    {
        if (!isset($this->movies[$id->getValue()])) {
            throw MovieNotFoundException::fromId($id);
        }

        return $this->movies[$id->getValue()];
    }

    public function add(DetailedMovie $movie): void
    {
        $this->movies[$movie->id] = $movie;
    }
}
