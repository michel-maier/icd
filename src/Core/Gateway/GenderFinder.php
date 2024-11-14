<?php

declare(strict_types=1);

namespace App\Core\Gateway;

use App\Core\Domain\ReadModel\Gender;

interface GenderFinder
{
    /**
     * @return array<Gender>
     */
    public function all(): array;
}
