<?php

namespace App\Tests\Functional;

use App\Tests\Builder\DetailedMovieDirector;
use App\Tests\Gateway\InMemoryDetailedMovieRetriever;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DetailMovieTest extends WebTestCase
{
    /**
     * @test
     */
    public function itShouldDisplayDetailMoviePage(): void
    {
        $client = static::createClient();
        $this->setupRetriever(static::$kernel->getContainer()->get(InMemoryDetailedMovieRetriever::class));

        $client->request('GET', '/movie/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h3.mt-3', 'Default Video');
    }

    private function setupRetriever(InMemoryDetailedMovieRetriever $retriever): void
    {
        $retriever->add(DetailedMovieDirector::createDefaultTestDetailedMovie(1));
    }
}
