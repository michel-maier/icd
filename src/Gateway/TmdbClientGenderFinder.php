<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Core\Domain\ReadModel\Gender;
use App\Core\Gateway\GenderFinder;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;

readonly class TmdbClientGenderFinder implements GenderFinder
{
    public function __construct(private HttpClientInterface $tmbdClient)
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
        $response = $this->tmbdClient->request(Request::METHOD_GET, '/genre/movie/list');
        $data = $response->toArray();

        return $data['genres'] ?? [];
    }
}
