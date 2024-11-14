<?php

declare(strict_types=1);

namespace App\Tests\Core\UseCase;

use App\Core\Domain\Entity\GenderId;
use App\Core\UseCase\SearchMovies\SearchMovies;
use App\Core\UseCase\SearchMovies\SearchMoviesPresenter;
use App\Core\UseCase\SearchMovies\SearchMoviesRequest;
use App\Tests\Builder\ListedMovieDirector;
use App\Tests\Gateway\InMemoryListedMovieFinder;
use PHPUnit\Framework\TestCase;

class SearchMoviesTest extends TestCase
{
    private InMemoryListedMovieFinder $finder;
    private SearchMovies $useCase;

    public function setUp(): void
    {
        $this->finder = new InMemoryListedMovieFinder();
        $this->useCase = new SearchMovies($this->finder);
    }

    /**
     * @test
     */
    public function itShouldRetrieveMoviesByPartialTitle(): void
    {
        $this->setupFinder();

        $result = ($this->useCase)(new SearchMoviesRequest('My mov'), $this->getPresenter());

        $this->assertCount(2, $result);
        $this->assertEquals(1, $result[0]->id);
        $this->assertEquals(2, $result[1]->id);
    }

    /**
     * @test
     */
    public function itShouldRetrieveNothing(): void
    {
        $result = ($this->useCase)(new SearchMoviesRequest('Nothing !!!'), $this->getPresenter());

        $this->assertCount(0, $result);
    }

    private function getPresenter(): SearchMoviesPresenter
    {
        return new class implements SearchMoviesPresenter {
            public function present(array $movies): mixed
            {
                return $movies;
            }
        };
    }

    private function setupFinder(): void
    {
        $this->finder->add(GenderId::fromInt(1), ListedMovieDirector::createNamedTestListedMovie(1, 'My movie 1'));
        $this->finder->add(GenderId::fromInt(2), ListedMovieDirector::createNamedTestListedMovie(2, 'My movie 2'));
        $this->finder->add(GenderId::fromInt(3), ListedMovieDirector::createNamedTestListedMovie(3, 'My TV show'));
    }
}
