<?php

declare(strict_types=1);

namespace App\Controller\Presenter;

use App\Core\UseCase\RetrieveAllGenders\RetrieveAllGendersPresenter as Presenter;

class RetrieveAllGenderPresenter implements Presenter
{
    public function present(array $genders): array
    {
        return [
            'genders' => $genders,
        ];
    }
}
