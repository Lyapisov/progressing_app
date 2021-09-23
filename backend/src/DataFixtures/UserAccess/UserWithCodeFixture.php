<?php

declare(strict_types=1);

namespace App\DataFixtures\UserAccess;

use App\UserAccess\Domain\OAuth\AuthCode;
use App\UserAccess\Domain\OAuth\Client;
use App\UserAccess\Domain\OAuth\Scope;
use App\UserAccess\Test\Helper\UserAccessTrait;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class UserWithCodeFixture extends Fixture
{
    use UserAccessTrait;

    public function load(ObjectManager $manager): void
    {
        $user = $this
            ->getUserBuilder()
            ->withId('00000000-0000-0000-0000-000000000001')
            ->withEmail('sdfsdf@sdf.com')
            ->withPassword('ololololol')
            ->build();

        $code = new AuthCode();
        $code->setClient(new Client(
            identifier: 'frontend',
            name: 'Frontend',
            redirectUri: 'https://localhost:5000/ss',
        ));
        $code->addScope(new Scope('email'));
        $code->setExpiryDateTime(new DateTimeImmutable('2300-12-31 21:00:10'));
        $code->setIdentifier('def50200f204dedbb244ce4539b9e');
        $code->setUserIdentifier('00000000-0000-0000-0000-000000000001');
        $code->setRedirectUri('https://localhost:5000/ss');

        $manager->persist($user);
        $manager->persist($code);
        $manager->flush();
    }
}
