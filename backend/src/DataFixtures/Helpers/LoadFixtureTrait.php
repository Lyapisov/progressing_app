<?php

declare(strict_types=1);

namespace App\DataFixtures\Helpers;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

trait LoadFixtureTrait
{
    /**
     * @var KernelInterface
     */
    protected static $kernel;

    /**
     * @param array<string|int,string> $fixtures
     */
    protected function loadFixtures(array $fixtures): void
    {
        $container = self::$kernel->getContainer();
        $loader = new Loader();
        foreach ($fixtures as $name => $class) {
            /** @var AbstractFixture $fixture */
            $fixture = $container->get($class);
            $loader->addFixture($fixture);
        }
        /** @var EntityManagerInterface $em */
        $em = $container->get('doctrine.orm.entity_manager');
        $executor = new ORMExecutor($em, new ORMPurger($em));
        $executor->execute($loader->getFixtures());
    }
}
