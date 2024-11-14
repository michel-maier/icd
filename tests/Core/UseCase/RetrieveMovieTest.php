<?php

declare(strict_types=1);

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
    private InMemoryDetailedMovieRetriever $retriever;
    private RetrieveMovie $useCase;

    public function setUp(): void
    {
        $this->retriever = new InMemoryDetailedMovieRetriever();
        $this->useCase = new RetrieveMovie($this->retriever);
    }

    /**
     * @test
     */
    public function itShouldRetrieveMovie()
    {
        $this->setupRetriever();

        $result = ($this->useCase)(new RetrieveMovieRequest(1), $this->getPresenter());

        $this->assertInstanceOf(DetailedMovie::class, $result);
        $this->assertEquals(1, $result->id);
    }

    /**
     * @test
     */
    public function itShouldFailedOnTryToRetrieveNotExistingMovie()
    {
        $this->setupRetriever();

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

    private function setupRetriever(): void
    {
        $this->retriever->add(DetailedMovieDirector::createDefaultTestDetailedMovie(1));
    }
}
