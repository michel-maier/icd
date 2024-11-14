<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Core\Domain\ReadModel\Gender;
use App\Core\Gateway\GenderFinder;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;

readonly class TmdbClientGenderFinder implements GenderFinder
{
    public function __construct(private HttpClientInterface $tmdbClient)
    {
    }

    public function all(): array
    {
        return array_map(
            fn($genreData) => new Gender(
                id: $genreData['id'],
                name: $genreData['name']
            ),
            $this->fetchGenres()
        );
    }

    private function fetchGenres(): array
    {
        $response = $this->tmdbClient->request(Request::METHOD_GET, '/3/genre/movie/list');
        $data = $response->toArray();

        return $data['genres'] ?? [];
    }
}
