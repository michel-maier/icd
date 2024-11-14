<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Core\Domain\Entity\GenderId;
use App\Core\Domain\ReadModel\ListedMovie;
use App\Core\Gateway\ListedMovieFinder;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;

class TmdbListedMovieFinder implements ListedMovieFinder
{
    public function __construct(private HttpClientInterface $tmbdClient)
    {
    }

    public function byGenderIds(array $genderIds = []): array
    {
        $queryParams = [];

        if (!empty($genderIds)) {
            $queryParams['with_genres'] = implode(',', array_map(fn(GenderId $id) => $id->getValue(), $genderIds));
        }

        $data = $this->fetchMovies('/discover/movie', $queryParams);

        return $this->mapMovies($data);
    }

    public function byPartialTitle(string $name): array
    {
        $data = $this->fetchMovies('/search/movie', ['query' => $name]);

        return $this->mapMovies($data);
    }

    private function fetchMovies(string $endpoint, array $queryParams): array
    {
        $response = $this->tmbdClient->request(Request::METHOD_GET, $endpoint, ['query' => $queryParams]);
        $data = $response->toArray();

        return $data['results'] ?? [];
    }

    private function mapMovies(array $moviesData): array
    {
        return array_map(
            fn($movie) => new ListedMovie(
                id: $movie['id'],
                title: $movie['title'],
                releaseDate: new \DateTimeImmutable($movie['release_date']),
                description: $movie['overview'] ?? '',
                posterUrl: $movie['poster_path'] ? sprintf('https://image.tmdb.org/t/p/w500%s', $movie['poster_path']) : '',
                scoreAverage: $movie['vote_average'] ?? null,
                voteCount: $movie['vote_count'] ?? 0
            ),
            $moviesData
        );
    }
}
