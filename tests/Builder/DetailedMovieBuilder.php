<?php

declare(strict_types=1);

namespace App\Tests\Builder;

use App\Core\Domain\ReadModel\DetailedMovie;

class DetailedMovieBuilder
{
    private int $id;
    private string $title;
    private string $description;
    private string $mainVideoKey;
    private string $mainVideoName;
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

    public function withDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function withMainVideoKey(string $youtubeKey): self
    {
        $this->mainVideoKey = $youtubeKey;

        return $this;
    }

    public function withMainVideoName(string $videoName): self
    {
        $this->mainVideoName = $videoName;

        return $this;
    }

    public function withScoreAverage(float $scoreAverage): self
    {
        $this->scoreAverage = $scoreAverage;

        return $this;
    }

    public function withVoteCount(int $voteCount): self
    {
        $this->voteCount = $voteCount;

        return $this;
    }

    public function build(): DetailedMovie
    {
        return new DetailedMovie(
            id: $this->id,
            title: $this->title,
            description: $this->description,
            mainVideoKey: $this->mainVideoKey,
            mainVideoName: $this->mainVideoName,
            scoreAverage: $this->scoreAverage,
            voteCount: $this->voteCount,
        );
    }
}
