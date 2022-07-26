<?php

declare(strict_types=1);

namespace App\Tests;

use App\DataFixtures\Helpers\LoadFixtureTrait;
use App\Tests\Helpers\Traits\DatabaseTrait;
use Bondalex96\JsonAsserter\JsonAsserter;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
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
    protected JsonAsserter $jsonAsserter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->client->disableReboot();
        $this->em = $this->getEntityManager();
        $this->em->beginTransaction();
        $this->em->getConnection()->setAutoCommit(false);
        $this->jsonAsserter = new JsonAsserter();
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
     * Сравнивает содержимое переданного Response'а в формате json,
     * и ожидаемого ответа.
     *
     * Примечание: При статусе 204 не использовать данный метод, т.к. заголовок
     * application/json не проставляется
     * см. https://github.com/symfony/symfony/issues/29326.
     *
     * @param Response $actualResponse Проверяемый Response
     * @param array $expectedResponseBody Ожидаемый ответ. Переводится
     *                                       в Json формат для сравнения. Значения
     *                                       данного массива могут содержать
     *                                       такие паттерны для сравнения:
     *                                       "@string@", "@integer@", "@number@",
     *                                       "@double@", "@boolean@", "@array@",
     *                                       "@...@", "@null@", "@*@",
     *                                       "@wildcard@", "expr(expression)",
     *                                       "@uuid@"
     *                                       Подробнее тут: https://github.com/coduo/php-matcher
     * @throws Exception
     */
    protected function assertJsonResponse(Response $actualResponse, array $expectedResponseBody): void
    {
        $this->assertHeader($actualResponse, 'application/json');
        $actualContent = trim($actualResponse->getContent());
        $expectedContent = trim(json_encode($expectedResponseBody));
        $this->jsonAsserter->assertJsonContent(
            $this->prettifyJson($actualContent),
            $this->prettifyJson($expectedContent)
        );
    }

    /**
     * Извлекает параметр из респонса. Можно обращать к значениям массива,
     * выстраивая путь к нужному элементу,например "0.list.0.id"
     *
     * @param Response $response
     * @param string $parameter
     * @return mixed
     */
    protected function extractParameterFromResponse(
        Response $response,
        string $parameter
    ) {
        $this->assertHeader($response, 'application/json');
        $content = json_decode($response->getContent(), true);

        $keys = explode(".", $parameter);

        $foundedResult = $content;

        foreach ($keys as $key) {
            if (isset($foundedResult[$key])) {
                $foundedResult = $foundedResult[$key];
                continue;
            }
            $foundedResult = null;
            break;
        }

        return $foundedResult;
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

    /**
     * @param Response $response
     * @param $contentType
     */
    private function assertHeader(Response $response, $contentType): void
    {
        $headerContentType = $response->headers->get('Content-Type', $contentType);

        $this->assertTrue(
            mb_strpos($headerContentType, $contentType) !== false
        );
    }
}
