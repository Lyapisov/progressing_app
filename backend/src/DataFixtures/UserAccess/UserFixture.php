<?php

declare(strict_types=1);

namespace App\DataFixtures\UserAccess;

use App\UserAccess\Test\Helper\UserAccessTrait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * @service App\DataFixture\UserAccess\UserFixture
 */
final class UserFixture extends Fixture
{
    use UserAccessTrait;

    public function load(ObjectManager $manager): void
    {
        $user = $this
            ->getUserBuilder()
            ->withLogin('lyapisov')
            ->withId('00000000-0000-0000-0000-000000000001')
            ->withEmail('sdfsdf@sdf.com')
            ->withPassword('ololololol')
            ->build();

        $manager->persist($user);
        $manager->flush();
    }
}
