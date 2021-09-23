<?php
declare(strict_types=1);

namespace App\Tests;

use App\DataFixtures\Helpers\LoadFixtureTrait;
use App\Tests\Helpers\DatabaseTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ControllerTestCase extends WebTestCase
{
    use DatabaseTrait {
        DatabaseTrait::setUp as setupDatabase;
    }
    use LoadFixtureTrait;

    protected EntityManagerInterface $em;
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->client->disableReboot();
        $this->em = $this->getEntityManager();
        $this->em->beginTransaction();
        $this->em->getConnection()->setAutoCommit(false);
    }

    protected function tearDown(): void
    {
        $this->em->getConnection()->rollback();
        $this->em->close();
        parent::tearDown();
    }

    protected function jsonRequest(
        string $method,
        string $uri,
        array $parameters = [],
        array $files = [],
        array $server = [],
        string $content = null,
        bool $changeHistory = true
    ): Response {
        $this->client->setServerParameters(['CONTENT_TYPE' => 'application/json']);
        $this->client->request(
            $method,
            $uri,
            $parameters,
            $files,
            $server,
            $content,
            $changeHistory
        );

        return $this->client->getResponse();
    }

    /**
     * Форматирует данные в формате json, делая их более читаемыми.
     *
     * @param $content
     * @return string
     */
    protected function prettifyJson($content): string
    {
        return json_encode(
            json_decode($content),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }
}
