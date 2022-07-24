<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Http\UserAccess;

use App\DataFixtures\Helpers\LoadFixtureTrait;
use App\DataFixtures\UserAccess\UserFixture;
use App\Profiles\Domain\Fan\Fan;
use App\Profiles\Test\Helpers\ProfilesTrait;
use App\Tests\ControllerTestCase;
use App\UserAccess\Test\Helper\OAuthHeader;
use Symfony\Component\HttpFoundation\Response;

final class GetMineActionTest extends ControllerTestCase
{
    use LoadFixtureTrait;
    use ProfilesTrait;

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

        $this->assertJsonResponse($response, [
            'error' => [
                'messages' => [ 'Неверный токен авторизации!' ],
                'code' => 1,
            ],
        ]);

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

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $this->assertJsonResponse($response, [
            'id' => '00000000-0000-0000-0000-000000000001',
            'profileCreated' => false,
            'fanId' => null,
            'musicianId' => null,
            'producerId' => null,
        ]);
    }

    public function testWithFanProfile(): void
    {
        $fan = $this->getFanBuilder()
            ->withUserId('00000000-0000-0000-0000-000000000001')
            ->build();
        $this->saveEntity($fan);

        $response = $this->jsonRequest(
            'GET',
            $this->query(),
            [],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $this->assertJsonResponse($response, [
            'id' => '00000000-0000-0000-0000-000000000001',
            'profileCreated' => true,
            'fanId' => $fan->getId(),
            'musicianId' => null,
            'producerId' => null,
        ]);
    }

    private static function query(): string
    {
        return '/users/mine';
    }
}
