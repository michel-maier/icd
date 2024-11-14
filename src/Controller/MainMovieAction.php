<?php

declare(strict_types=1);

namespace App\Controller;

use App\Core\Domain\ReadModel\DetailedMovie;
use App\Core\UseCase\RetrieveMovie\RetrieveMovie;
use App\Core\UseCase\RetrieveMovie\RetrieveMoviePresenter;
use App\Core\UseCase\RetrieveMovie\RetrieveMovieRequest;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

readonly class MainMovieAction
{
    public function __construct(
        private Environment $twig,
        private RetrieveMovie $retrieveMovie,
    ) {
    }

    public function __invoke(int $id)
    {
        return new Response(
            $this->twig->render('_movie_main.html.twig', ($this->retrieveMovie)(new RetrieveMovieRequest($id), $this->getPresenter()))
        );
    }

    private function getPresenter(): RetrieveMoviePresenter {
        return new class implements RetrieveMoviePresenter {
            public function present(DetailedMovie $detailedMovie): array
            {
                return [
                    'key' => $detailedMovie->mainVideoKey,
                    'description' => $detailedMovie->description,
                ];
            }
        };
    }
}