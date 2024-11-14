<?php

declare(strict_types=1);

namespace App\Tests\Gateway;

use App\Core\Domain\Entity\GenderId;
use App\Core\Domain\ReadModel\ListedMovie;
use App\Core\Gateway\ListedMovieFinder;

class InMemoryListedMovieFinder implements ListedMovieFinder
{
    /** @var array<int, array<ListedMovie>> */
    private array $moviesByGender = [];

    /**
     * @param array<GenderId> $genderIds
     *
     * @return array<ListedMovie>
     */
    public function byGenderIds(array $genderIds = []): array
    {
        if (empty($genderIds)) {
            return array_merge(...array_values($this->moviesByGender));
        }

        return array_reduce(
            $genderIds,
            function (array $result, GenderId $genderId): array {
                return isset($this->moviesByGender[$genderId->getValue()])
                    ? array_merge($result, $this->moviesByGender[$genderId->getValue()])
                    : $result;
            },
            []
        );
    }

    public function byPartialTitle(string $name): array
    {
        $result = [];

        foreach ($this->moviesByGender as $movies) {
            foreach ($movies as $movie) {
                if (false !== stripos($movie->title, $name)) {
                    $result[] = $movie;
                }
            }
        }

        return $result;
    }

    public function add(GenderId $movieIds, ListedMovie $movie): void
    {
        $this->moviesByGender += [$movieIds->getValue() => []];
        $this->moviesByGender[$movieIds->getValue()][] = $movie;
    }
}
