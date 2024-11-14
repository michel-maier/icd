<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RateMovieTest extends WebTestCase
{
    /**
     * @test
     */
    public function itShouldDisplayHomepageSuccessfully()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/movie/rate/123',
            ['rating' => 5]
        );

        $this->assertResponseStatusCodeSame(204);
    }
}
