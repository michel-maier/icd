<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Domain\ReadModel\DetailedMovie;
use App\Core\UseCase\RetrieveMovie\RetrieveMovie;
use App\Core\UseCase\RetrieveMovie\RetrieveMoviePresenter;
use App\Core\UseCase\RetrieveMovie\RetrieveMovieRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

readonly class DetailMovieAction
{
    public function __construct(
        private Environment $twig,
        private RetrieveMovie $retrieveMovie,
    ) {
    }

    #[Route(path: '/movie/{id}', name: 'movie_detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function __invoke(Request $request, int $id): Response
    {
        return new Response(
            $this->twig->render('_movie_detail.html.twig', ($this->retrieveMovie)(new RetrieveMovieRequest($id), $this->getPresenter()))
        );
    }

    private function getPresenter(): RetrieveMoviePresenter {
        return new class implements RetrieveMoviePresenter {
            public function present(DetailedMovie $detailedMovie): array
            {
                return ['movie' => $detailedMovie];
            }
        };
    }
}