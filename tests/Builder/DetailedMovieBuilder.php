<?php

declare(strict_types=1);

namespace App\Tests\Builder;

use App\Core\Domain\ReadModel\DetailedMovie;

class DetailedMovieBuilder
{
    private int $id;
    private string $title;
    private string $description;
    private string $youtubeKey;
    private string $videoName;
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

    public function withYoutubeKey(string $youtubeKey): self
    {
        $this->youtubeKey = $youtubeKey;

        return $this;
    }

    public function withVideoName(string $videoName): self
    {
        $this->videoName = $videoName;

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
            $this->id,
            $this->title,
            $this->description,
            $this->youtubeKey,
            $this->videoName,
            $this->scoreAverage,
            $this->voteCount
        );
    }
}
