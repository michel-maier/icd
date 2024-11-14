<?php

namespace App\Controller;

use App\Core\UseCase\RateMovie\RateMovie;
use App\Core\UseCase\RateMovie\RateMovieRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class RateMovieAction
{
    public function __construct(
        private RateMovie $rateMovie,
    ) {
    }

    #[Route(path: '/movie/rate/{id}', name: 'movie_rate', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function __invoke(Request $request, int $id): JsonResponse
    {
        ($this->rateMovie)(new RateMovieRequest($id, $request->request->get('rating')));

        return new JsonResponse(null, 204);
    }
}