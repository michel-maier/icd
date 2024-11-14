<?php

declare(strict_types=1);

namespace App\Core\UseCase\RetrieveAllGenders;

use App\Core\Domain\ReadModel\Gender;

interface RetrieveAllGendersPresenter
{
    /**
     * @param array<Gender> $genders
     */
    public function present(array $genders): mixed;
}
