<?php

declare(strict_types=1);

namespace App\Core\Gateway;

use App\Core\Domain\Entity\MovieId;
use App\Core\Domain\Exception\MovieNotFoundException;
use App\Core\Domain\ReadModel\DetailedMovie;

interface DetailedMovieRetriever
{
    /**
     * @throws MovieNotFoundException
     */
    public function retrieve(MovieId $id): DetailedMovie;
}
