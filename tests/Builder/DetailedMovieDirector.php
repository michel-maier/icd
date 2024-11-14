<?php

declare(strict_types=1);

namespace App\Tests\Builder;

use App\Core\Domain\ReadModel\DetailedMovie;

class DetailedMovieDirector
{
    public function __construct(DetailedMovieBuilder $builder)
    {
        $this->builder = $builder;
    }

    public static function createDefaultTestDetailedMovie(int $id): DetailedMovie
    {
        return (new DetailedMovieBuilder())
            ->withId($id)
            ->withTitle('Default Title')
            ->withDescription('Default Description')
            ->withYoutubeKey('default_key')
            ->withVideoName('Default Video')
            ->withScoreAverage(5.0)
            ->withVoteCount(100)
            ->build();
    }
}
