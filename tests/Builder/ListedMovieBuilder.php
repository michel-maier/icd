<?php

declare(strict_types=1);

namespace App\Tests\Builder;

use App\Core\Domain\ReadModel\ListedMovie;

class ListedMovieBuilder
{
    private int $id;
    private string $title;
    private \DateTimeImmutable $releaseDate;
    private string $description;
    private string $posterUrl;
    private float $scoreAverage;
    private int $voteCount;

    public function withId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function withTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function withReleaseDate(\DateTimeImmutable $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function withDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function withPosterUrl(string $posterUrl): self
    {
        $this->posterUrl = $posterUrl;

        return $this;
    }

    public function withVoteAverage(float $voteAverage): self
    {
        $this->scoreAverage = $voteAverage;

        return $this;
    }

    public function withVoteCount(int $voteCount): self
    {
        $this->voteCount = $voteCount;

        return $this;
    }

    public function build(): ListedMovie
    {
        return new ListedMovie(
            id: $this->id,
            title: $this->title,
            releaseDate: $this->releaseDate,
            description: $this->description,
            posterUrl: $this->posterUrl,
            scoreAverage: $this->scoreAverage,
            voteCount: $this->voteCount,
        );
    }
}
