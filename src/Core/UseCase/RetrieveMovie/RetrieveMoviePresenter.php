<?php

declare(strict_types=1);

namespace App\Core\UseCase\RetrieveMovie;

use App\Core\Domain\ReadModel\DetailedMovie;

interface RetrieveMoviePresenter
{
    public function present(DetailedMovie $detailedMovie): mixed;
}
