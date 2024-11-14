<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Core\Domain\Entity\GenderId;
use App\Tests\Builder\DetailedMovieDirector;
use App\Tests\Builder\ListedMovieDirector;
use App\Tests\Gateway\InMemoryDetailedMovieRetriever;
use App\Tests\Gateway\InMemoryListedMovieFinder;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeTest extends WebTestCase
{
    /**
     * @test
     */
    public function itShouldDisplayHomepageSuccessfully()
    {
        $client = static::createClient();
        $this->setupFinder(static::$kernel->getContainer()->get(InMemoryListedMovieFinder::class));
        $this->setupRetriever(static::$kernel->getContainer()->get(InMemoryDetailedMovieRetriever::class));

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
        $this->assertEquals(
            2,
            $crawler->filter('.card-custom')->count(),
            'Page needs to contains 2 movie cards'
        );
    }

    private function setupFinder(InMemoryListedMovieFinder $finder): void
    {
        $finder->add(GenderId::fromInt(1), ListedMovieDirector::createDefaultTestListedMovie(1));
        $finder->add(GenderId::fromInt(2), ListedMovieDirector::createDefaultTestListedMovie(2));
        $finder->add(GenderId::fromInt(3), ListedMovieDirector::createDefaultTestListedMovie(3));
    }

    private function setupRetriever(InMemoryDetailedMovieRetriever $retriever): void
    {
        $retriever->add(DetailedMovieDirector::createDefaultTestDetailedMovie(1));
    }
}
