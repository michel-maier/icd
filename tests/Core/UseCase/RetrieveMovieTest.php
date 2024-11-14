<?php

namespace App\Tests\Core\UseCase;

use App\Core\Domain\Entity\MovieId;
use App\Core\Domain\Exception\MovieNotFoundException;
use App\Core\Domain\ReadModel\DetailedMovie;
use App\Core\UseCase\RetrieveMovie\RetrieveMovie;
use App\Core\UseCase\RetrieveMovie\RetrieveMoviePresenter;
use App\Core\UseCase\RetrieveMovie\RetrieveMovieRequest;
use App\Tests\Builder\DetailedMovieDirector;
use App\Tests\Gateway\InMemoryDetailedMovieRetriever;
use PHPUnit\Framework\TestCase;

class RetrieveMovieTest extends TestCase
{
    private InMemoryDetailedMovieRetriever $finder;
    private RetrieveMovie $useCase;

    public function setUp(): void
    {
        $this->finder = new InMemoryDetailedMovieRetriever();
        $this->useCase = new RetrieveMovie($this->finder);
    }

    /**
     * @test
     */
    public function itShouldRetrieveMovie()
    {
        $this->setupFinder();

        $result = ($this->useCase)(new RetrieveMovieRequest(1), $this->getPresenter());

        $this->assertInstanceOf(DetailedMovie::class, $result);
        $this->assertEquals(1, $result->id);
    }

    /**
     * @test
     */
    public function itShouldFailedOnTryToRetrieveNotExistingMovie()
    {
        $this->setupFinder();

        $this->expectExceptionObject(MovieNotFoundException::fromId(MovieId::fromInt(7)));

        ($this->useCase)(new RetrieveMovieRequest(7), $this->getPresenter());
    }

    private function getPresenter(): RetrieveMoviePresenter
    {
        return new class implements RetrieveMoviePresenter {
            public function present(DetailedMovie $detailedMovie): mixed
            {
                return $detailedMovie;
            }
        };
    }

    private function setupFinder(): void
    {
        $this->finder->add(DetailedMovieDirector::createDefaultTestDetailedMovie(1));
    }
}
