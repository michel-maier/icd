<?php

declare(strict_types=1);

namespace App\Tests\Builder;

use App\Core\Domain\ReadModel\DetailedMovie;

class DetailedMovieDirector
{
    public static function createDefaultTestDetailedMovie(int $id): DetailedMovie
    {
        return (new DetailedMovieBuilder())
            ->withId($id)
            ->withTitle('Default Title')
            ->withDescription('Default Description')
            ->withMainVideoKey('default_key')
            ->withMainVideoName('Default Video')
            ->withScoreAverage(5.0)
            ->withVoteCount(100)
            ->build();
    }
}
