<?php

declare(strict_types=1);

namespace App\Tests\Builder;

use App\Core\Domain\ReadModel\ListedMovie;

readonly class ListedMovieDirector
{
    public static function createDefaultTestListedMovie(int $id): ListedMovie
    {
        return (new ListedMovieBuilder())
            ->withId($id)
            ->withTitle('Default Title')
            ->withReleaseDate(new \DateTimeImmutable('2000-01-01'))
            ->withDescription('Default description')
            ->withPosterUrl('https://example.com/default.jpg')
            ->withVoteAverage(5.0)
            ->withVoteCount(100)
            ->build();
    }

    public static function createNamedTestListedMovie(int $id, string $name): ListedMovie
    {
        return (new ListedMovieBuilder())
            ->withId($id)
            ->withTitle($name)
            ->withReleaseDate(new \DateTimeImmutable('2000-01-01'))
            ->withDescription('Default description')
            ->withPosterUrl('https://example.com/default.jpg')
            ->withVoteAverage(5.0)
            ->withVoteCount(100)
            ->build();
    }
}
