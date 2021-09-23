<?php

declare(strict_types=1);

namespace App\Tests\Profiles\Infrastructure\Repository\Read;

use App\Profiles\Domain\Fan\Fan;
use App\Profiles\Domain\Musician\Musician;
use App\Profiles\Domain\Shared\Address;
use App\Profiles\Domain\Shared\Name;
use App\Profiles\Domain\Shared\Phone;
use App\Profiles\Test\Helpers\ProfilesTrait;
use App\Tests\Helpers\DatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class FanReadRepositoryTest extends KernelTestCase
{
    use DatabaseTrait;
    use ProfilesTrait;

    public function testSuccessful(): void
    {
        $musician1 = new Musician(
            $idMus1 = '11111111-50b7-49af-97e6-45529c2e947a',
            $userId = '22211111-50b7-49af-97e6-45529c2e947a',
            new Name('login', 'first', 'last', 'father'),
            new \DateTimeImmutable('2021-10-10'),
            new Address('Azov'),
            new Phone('+79889474747'),
            [''],
        );

        $musician2 = new Musician(
            $idMus2 = '22222222-50b7-49af-97e6-45529c2e947a',
            $userId = '22211111-50b7-49af-97e6-45529c2e947a',
            new Name('login', 'first', 'last', 'father'),
            new \DateTimeImmutable('2021-10-10'),
            new Address('Azov'),
            new Phone('+79889474747'),
            [''],
        );

        $fan = new Fan(
            $id = 'fc53f31a-50b7-49af-97e6-45529c2e947a',
            $userId = 'fc53f31a-97e6-49af-97e6-45529c2e947a',
            new Name($name = 'www', 'first', 'last', 'father'),
            new \DateTimeImmutable('1995-10-10'),
            new Address($address = 'Azov'),
            new Phone($number = '+79889474700'),
        );

        $this->saveEntity($fan);
        $this->saveEntity($musician1);
        $this->saveEntity($musician2);

        $fanRead = $this->getFanRepository()->findById($id);

        $musiciansss = $this->getMusicianRepository()->findByIds($fanRead->getFavoriteMusicians());

        $this->assertEquals($id, $fanRead->getId());
    }
}
