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
    private const MAX_MOVIE_BY_GENDER_IDS = 4;

    private const MAX_MOVIE_BY_PARTIAL_TITLE = 10;

    public function __construct(private HttpClientInterface $tmdbClient)
    {
    }

    public function byGenderIds(array $genderIds = []): array
    {
        $queryParams = [
            'sort_by' => 'popularity.desc',
        ];

        if (!empty($genderIds)) {
            $queryParams['with_genres'] = implode(',', array_map(fn(GenderId $id) => $id->getValue(), $genderIds));
        }

        $data = $this->fetchMovies('/3/discover/movie', $queryParams);

        return $this->mapMovies(array_slice($data, 0, self::MAX_MOVIE_BY_GENDER_IDS));
    }

    public function byPartialTitle(string $name): array
    {
        $queryParams = [
            'query' => $name,
        ];

        $data = $this->fetchMovies('/3/search/movie',  $queryParams);

        return $this->mapMovies(array_slice($data, 0, self::MAX_MOVIE_BY_PARTIAL_TITLE));
    }

    private function fetchMovies(string $endpoint, array $queryParams): array
    {
        $response = $this->tmdbClient->request(Request::METHOD_GET, $endpoint, ['query' => $queryParams]);
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
                scoreAverage:  isset($movie['vote_average']) ? $movie['vote_average'] / 2 : null,
                voteCount: $movie['vote_count'] ?? 0
            ),
            $moviesData
        );
    }
}
