<?php

declare(strict_types=1);

namespace App\Tests\Core\UseCase;

use App\Core\Domain\Entity\GenderId;
use App\Core\UseCase\FindMovies\FindMovies;
use App\Core\UseCase\FindMovies\FindMoviesPresenter;
use App\Core\UseCase\FindMovies\FindMoviesRequest;
use App\Tests\Builder\ListedMovieDirector;
use App\Tests\Gateway\InMemoryListedMovieFinder;
use PHPUnit\Framework\TestCase;

class FindMoviesTest extends TestCase
{
    private InMemoryListedMovieFinder $finder;
    private FindMovies $useCase;

    public function setUp(): void
    {
        $this->finder = new InMemoryListedMovieFinder();
        $this->useCase = new FindMovies($this->finder);
    }

    /**
     * @test
     */
    public function itShouldRetrieveMoviesByGenders(): void
    {
        $this->setupFinder();

        $result = ($this->useCase)(new FindMoviesRequest([1, 3]), $this->getPresenter());

        $this->assertCount(2, $result);
        $this->assertEquals(1, $result[0]->id);
        $this->assertEquals(3, $result[1]->id);
    }

    /**
     * @test
     */
    public function itShouldRetrieveAllMoviesWhenGendersIsEmpty(): void
    {
        $this->setupFinder();

        $result = ($this->useCase)(new FindMoviesRequest([]), $this->getPresenter());

        $this->assertCount(3, $result);
        $this->assertEquals(1, $result[0]->id);
        $this->assertEquals(2, $result[1]->id);
        $this->assertEquals(3, $result[2]->id);
    }

    /**
     * @test
     */
    public function itShouldRetrieveNothing(): void
    {
        $this->setupFinder();

        $result = ($this->useCase)(new FindMoviesRequest([7, 8]), $this->getPresenter());

        $this->assertCount(0, $result);
    }

    private function getPresenter(): FindMoviesPresenter
    {
        return new class implements FindMoviesPresenter {
            public function present(array $movies): mixed
            {
                return $movies;
            }
        };
    }

    private function setupFinder(): void
    {
        $this->finder->add(GenderId::fromInt(1), ListedMovieDirector::createDefaultTestListedMovie(1));
        $this->finder->add(GenderId::fromInt(2), ListedMovieDirector::createDefaultTestListedMovie(2));
        $this->finder->add(GenderId::fromInt(3), ListedMovieDirector::createDefaultTestListedMovie(3));
    }
}
