<?php

declare(strict_types=1);

namespace App\Tests\Core\UseCase;

use App\Core\Domain\ReadModel\Gender;
use App\Core\UseCase\RetrieveAllGenders\RetrieveAllGenders;
use App\Core\UseCase\RetrieveAllGenders\RetrieveAllGendersPresenter;
use App\Tests\Gateway\InMemoryGenderFinder;
use PHPUnit\Framework\TestCase;

class RetrieveAllGendersTest extends TestCase
{
    private const GENDERS_VALUES = [['id' => 1, 'name' => 'My first gender'], ['id' => 2, 'name' => 'My second gender'], ['id' => 3, 'name' => 'My third gender']];

    /**
     * @test
     */
    public function itShouldRetrieveAllGenders(): void
    {
        $finder = new InMemoryGenderFinder();
        $useCase = new RetrieveAllGenders($finder);
        $this->setupFinder($finder);

        $result = $useCase($this->getPresenter());

        $this->assertCount(count(self::GENDERS_VALUES), $result);
        $this->assertEquals(self::GENDERS_VALUES[0]['id'], $result[0]->id);
        $this->assertEquals(self::GENDERS_VALUES[0]['name'], $result[0]->name);
        $this->assertEquals(self::GENDERS_VALUES[1]['id'], $result[1]->id);
        $this->assertEquals(self::GENDERS_VALUES[1]['name'], $result[1]->name);
        $this->assertEquals(self::GENDERS_VALUES[2]['id'], $result[2]->id);
        $this->assertEquals(self::GENDERS_VALUES[2]['name'], $result[2]->name);
    }

    private function getPresenter(): RetrieveAllGendersPresenter
    {
        return new class implements RetrieveAllGendersPresenter {
            public function present(array $genders): mixed
            {
                return $genders;
            }
        };
    }

    private function setupFinder(InMemoryGenderFinder $finder): void
    {
        array_map(
            fn (array $g) => $finder->add(new Gender($g['id'], $g['name'])),
            self::GENDERS_VALUES,
        );
    }
}
