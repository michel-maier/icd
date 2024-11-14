<?php

declare(strict_types=1);

namespace App\Tests\Gateway;

use App\Core\Domain\ReadModel\Gender;
use App\Core\Gateway\GenderFinder;

class InMemoryGenderFinder implements GenderFinder
{
    /** @var array<Gender> */
    private array $genders = [];

    /**
     * @return array<Gender>
     */
    public function all(): array
    {
        return $this->genders;
    }

    public function add(Gender $gender): void
    {
        $this->genders[] = $gender;
    }
}
