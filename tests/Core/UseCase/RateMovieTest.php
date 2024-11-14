<?php

namespace App\Tests\Core\UseCase;

use App\Adapter\Gateway\FakeMovieRater;
use App\Core\Domain\Exception\InvalidScoreException;
use App\Core\UseCase\RateMovie\RateMovie;
use App\Core\UseCase\RateMovie\RateMovieRequest;
use PHPUnit\Framework\TestCase;

class RateMovieTest extends TestCase
{
    private FakeMovieRater $rater;
    private RateMovie $useCase;

    public function setUp(): void
    {
        $this->rater = new FakeMovieRater();
        $this->useCase = new RateMovie($this->rater);
    }

    /**
     * @test
     *
     * @dataProvider provideScore
     */
    public function itShouldRateMovie(int $score): void
    {
        $this->expectNotToPerformAssertions();
        ($this->useCase)(new RateMovieRequest(123, $score));
    }

    public function provideScore(): array
    {
        return [[0], [1], [2], [3], [4], [5]];
    }

    /**
     * @test
     *
     * @dataProvider provideFailedScore
     */
    public function itShouldFailedToRateMovie(int $score): void
    {
        $this->expectExceptionObject(InvalidScoreException::fromBadScore($score));
        ($this->useCase)(new RateMovieRequest(123, $score));
    }

    public function provideFailedScore(): array
    {
        return [[-1], [6]];
    }
}
