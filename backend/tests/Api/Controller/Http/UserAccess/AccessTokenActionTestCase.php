<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Http\UserAccess;

use App\Tests\ControllerTestCase;
use App\UserAccess\Test\Helper\UserAccessTrait;
use DateTimeImmutable;
use Defuse\Crypto\Crypto;
use Sentry\Util\JSON;
use Symfony\Component\HttpFoundation\Response;
use Trikoder\Bundle\OAuth2Bundle\Model\AccessToken;
use Trikoder\Bundle\OAuth2Bundle\Model\Client;
use Trikoder\Bundle\OAuth2Bundle\Model\RefreshToken;

final class AccessTokenActionTestCase extends ControllerTestCase
{
    use UserAccessTrait;

    public function testSuccess(): void
    {
        $user = $this->getUserBuilder()
            ->withId('18478ecd-b865-4e85-9726-e0582fb6aa82')
            ->withLogin('lyapisov')
            ->withPassword('123456789')
            ->build();
        $this->saveEntity($user);

        $client = new Client('oauth', 'secret');

        $accessToken = new AccessToken(
            '2e805af8-79d1-4043-9f1a-04be8caec5e3',
            new DateTimeImmutable('2300-12-31 21:00:10'),
            $client,
            '18478ecd-b865-4e85-9726-e0582fb6aa82',
            []
        );

        $refreshToken = new RefreshToken(
            '24625b91-71be-4a5c-a841-1c977dd3e9d9',
            new DateTimeImmutable('2300-12-31 21:00:10'),
            $accessToken
        );

        $this->persist($client);
        $this->persist($accessToken);
        $this->persist($refreshToken);
        $this->save();

        $payload = [
            'client_id' => 'oauth',
            'refresh_token_id' => '24625b91-71be-4a5c-a841-1c977dd3e9d9',
            'access_token_id' => '2e805af8-79d1-4043-9f1a-04be8caec5e3',
            'scopes' => [],
            'user_id' => '18478ecd-b865-4e85-9726-e0582fb6aa82',
            'expire_time' => (new DateTimeImmutable('2300-12-31 21:00:10'))->getTimestamp(),
        ];

        $token = Crypto::encryptWithPassword(Json::encode($payload), getenv('OAUTH_ENCRYPTION_KEY'));

        $response = $this->jsonRequest(
            'POST',
            self::query(),
            [
                'grant_type' => 'refresh_token',
                'refresh_token' => $token,
                'client_id' => 'oauth',
                'client_secret' => 'secret',
            ]
        );

        $res = json_decode($response->getContent(), true);

        $this->assertEquals($res['token_type'], 'Bearer');
        $this->assertEquals($res['expires_in'], 600);
        $this->assertNotEmpty($res['access_token']);
        $this->assertNotEmpty($res['refresh_token']);
        $this->assertTrue(is_string($res['access_token']));
        $this->assertTrue(is_string($res['refresh_token']));

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    private static function query(): string
    {
        return '/token';
    }
}
