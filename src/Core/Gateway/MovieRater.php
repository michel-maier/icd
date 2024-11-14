<?php

namespace App\Core\Gateway;

use App\Core\Domain\Entity\MovieId;
use App\Core\Domain\Exception\InvalidScoreException;

interface MovieRater
{
    /**
     * @throws InvalidScoreException
     */
    public function rate(MovieId $movieId, int $score): void;
}
