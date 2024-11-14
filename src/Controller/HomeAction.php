<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Presenter\FindMoviePresenter;
use App\Controller\Presenter\RetrieveAllGenderPresenter;
use App\Core\UseCase\FindMovies\FindMovies;
use App\Core\UseCase\FindMovies\FindMoviesRequest;
use App\Core\UseCase\RetrieveAllGenders\RetrieveAllGenders;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

readonly class HomeAction
{
    public function __construct(
        private Environment $twig,
        private FindMovies $findMovies,
        private RetrieveAllGenders $retrieveAllGenders,
    ) {
    }

    #[Route(path: '/', name: 'home')]
    public function __invoke(Request $request): Response
    {
        $genderIds = array_map('intval', $request->query->all('genders'));
        $moviesContext = ($this->findMovies)(new FindMoviesRequest($genderIds), new FindMoviePresenter());
        $gendersContext = ($this->retrieveAllGenders)(new RetrieveAllGenderPresenter());

        return new Response(
            $this->twig->render('home.html.twig', $moviesContext + $gendersContext)
        );
    }
}
