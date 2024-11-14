<?php

declare(strict_types=1);

namespace App\Core\Gateway;

use App\Core\Domain\Entity\GenderId;
use App\Core\Domain\ReadModel\ListedMovie;

interface ListedMovieFinder
{
    /**
     * @param array<GenderId> $genderIds
     *
     * @return array<ListedMovie>
     */
    public function byGenderIds(array $genderIds = []): array;

    /**
     * @return array<ListedMovie>
     */
    public function byPartialTitle(string $name): array;
}
