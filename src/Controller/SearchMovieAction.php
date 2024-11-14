<?php

namespace App\Controller;

use App\Core\Domain\ReadModel\ListedMovie;
use App\Core\UseCase\SearchMovies\SearchMovies;
use App\Core\UseCase\SearchMovies\SearchMoviesPresenter;
use App\Core\UseCase\SearchMovies\SearchMoviesRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

readonly Class SearchMovieAction
{
    public function __construct(
        private SearchMovies $searchMovies,
    ) {
    }

    #[Route(path: '/movie/search', name: 'movie_search', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        $request = new SearchMoviesRequest($request->query->get('name', ''));

        return new JsonResponse(($this->searchMovies)($request, $this->getPresenter()));
    }

    private function getPresenter(): SearchMoviesPresenter {
        return new class implements SearchMoviesPresenter {
            public function present(array $movies): array
            {
                return array_map(fn(ListedMovie $m) => ['id' => $m->id, 'title' => $m->title], $movies);
            }
        };
    }
}
