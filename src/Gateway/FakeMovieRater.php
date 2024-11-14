<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Core\Domain\Entity\MovieId;
use App\Core\Domain\Exception\InvalidScoreException;
use App\Core\Gateway\MovieRater;

class FakeMovieRater implements MovieRater
{
    public function rate(MovieId $movieId, int $score): void
    {
        if ($score < 0 || $score > 5) {
            throw InvalidScoreException::fromBadScore($score);
        }
    }
}
