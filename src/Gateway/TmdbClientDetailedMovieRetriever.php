<?php

declare(strict_types=1);

namespace App\Gateway;

use App\Core\Domain\Entity\MovieId;
use App\Core\Domain\Exception\MovieNotFoundException;
use App\Core\Domain\ReadModel\DetailedMovie;
use App\Core\Gateway\DetailedMovieRetriever;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;

readonly class TmdbClientDetailedMovieRetriever implements DetailedMovieRetriever
{
    public function __construct(private HttpClientInterface $tmdbClient)
    {
    }

    public function retrieve(MovieId $id): DetailedMovie
    {
        $data = $this->fetchMovieDetails($id);
        [$mainVideoKey, $mainVideoName] = $this->fetchLastYouTubeVideo($id);

        return new DetailedMovie(
            id: $data['id'],
            title: $data['title'],
            description: $data['overview'] ?? '',
            mainVideoKey: $mainVideoKey,
            mainVideoName: $mainVideoName,
            scoreAverage: $data['vote_average'] ?? null,
            voteCount: $data['vote_count'] ?? 0
        );
    }

    private function fetchMovieDetails(MovieId $id): array
    {
        try {
            $response = $this->tmdbClient->request(Request::METHOD_GET, sprintf('/3/movie/%s', $id->getValue()));
            return $response->toArray();
        } catch (ClientExceptionInterface $e) {
            if (404 === $e->getCode()) {
                throw MovieNotFoundException::fromId($id);
            }
            throw $e;
        }
    }

    private function fetchLastYouTubeVideo(MovieId $id): array
    {
        $response = $this->tmdbClient->request(Request::METHOD_GET, sprintf('/3/movie/%s/videos', $id->getValue()));
        $data = $response->toArray();;
        $youtubeVideos = array_filter($data['results'] ?? [], fn($video) => ($video['site'] ?? '') === 'YouTube');

        if (empty($youtubeVideos)) {
            return [null, null];
        }
        $lastVideo = end($youtubeVideos);
        return [
            $lastVideo['key'] ?? null,
            $lastVideo['name'] ?? null
        ];
    }
}

