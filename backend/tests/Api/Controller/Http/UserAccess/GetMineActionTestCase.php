<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Http\UserAccess;

use App\DataFixtures\Helpers\LoadFixtureTrait;
use App\DataFixtures\UserAccess\UserFixture;
use App\Tests\ControllerTestCase;
use App\UserAccess\Test\Helper\OAuthHeader;
use Symfony\Component\HttpFoundation\Response;

final class GetMineActionTestCase extends ControllerTestCase
{
    use LoadFixtureTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([UserFixture::class]);
    }

    public function testGuest(): void
    {
        $response = $this->jsonRequest(
            'GET',
            $this->query(),
        );

        $responseContent = json_decode($response->getContent(), true);

        $expectedContent =
            [
                'error' => [
                    'messages' => [ 'Неверный токен авторизации!' ],
                    'code' => 1,
                ],
            ];

        $this->assertEquals($expectedContent, $responseContent);
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
    }

    public function testSuccess(): void
    {
        $response = $this->jsonRequest(
            'GET',
            $this->query(),
            [],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $responseContent = json_decode($response->getContent(), true);

        $this->assertEquals(['id' => '00000000-0000-0000-0000-000000000001'], $responseContent);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    private static function query(): string
    {
        return '/users/get/mind';
    }
}
