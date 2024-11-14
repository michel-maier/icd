<?php

declare(strict_types=1);

namespace App\Core\UseCase\RetrieveAllGenders;

use App\Core\Gateway\GenderFinder;

readonly class RetrieveAllGenders
{
    public function __construct(private GenderFinder $genderFinder)
    {
    }

    public function __invoke(RetrieveAllGendersPresenter $presenter): mixed
    {
        return $presenter->present($this->genderFinder->all());
    }
}
