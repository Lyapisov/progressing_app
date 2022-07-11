<?php

namespace App\Tests\Helpers;

use App\Profiles\Infrastructure\Repository\FanRepository;
use App\Profiles\Infrastructure\Repository\MusicianRepository;
use App\Profiles\Infrastructure\Repository\Read\FanReadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

trait DatabaseTrait
{
    /**
     * @var KernelInterface
     */
    protected static $kernel;

    /**
     * Метод для создания базы данных с актуальной схемой в тестовом окружении.
     */
    public static function executeMigrations()
    {
        passthru('php bin/console doctrine:migrations:migrate -q --no-interaction --env=test');
    }

    /**
     * Метод для создания базы данных в тестовом окружении.
     */
    public static function createDatabaseIfNotExists()
    {
        passthru('php bin/console d:d:c -q --if-not-exists --env=test');
    }

    /**
     * Метод для удаления базы данных в тестовом окружении.
     */
    public static function dropTables()
    {
        passthru('php bin/console doctrine:schema:drop -q --force --full-database --env=test');
    }

    public static function getEntityManager(): ?EntityManagerInterface
    {
        if (static::$kernel) {
            return static::$kernel
                ->getContainer()
                ->get('doctrine.orm.entity_manager')
                ;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        static::bootKernel();
        static::getEntityManager()->beginTransaction();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        $em = static::getEntityManager();
        $em->rollback();

        parent::tearDown();
    }

    protected function saveEntity(object $entity)
    {
        static::getEntityManager()->persist($entity);
        static::getEntityManager()->flush();
        static::getEntityManager()->clear();
    }

    protected function persist(object $entity)
    {
        static::getEntityManager()->persist($entity);
    }

    protected function save()
    {
        static::getEntityManager()->flush();
        static::getEntityManager()->clear();
    }

    protected function clearUoW()
    {
        static::getEntityManager()->clear();
    }
}
