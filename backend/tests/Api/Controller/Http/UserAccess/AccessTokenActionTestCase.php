<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Http\UserAccess;

use App\DataFixtures\UserAccess\UserWithCodeFixture;
use App\Tests\ControllerTestCase;
use App\Tests\Helpers\DatabaseTrait;
use App\UserAccess\Test\Helper\UserAccessTrait;
use App\Tests\UserAccess\Helpers\PKCE;
use App\UserAccess\Domain\OAuth\AccessToken;
use App\UserAccess\Domain\OAuth\Client;
use App\UserAccess\Domain\OAuth\RefreshToken;
use App\UserAccess\Domain\OAuth\Scope;
use DateTimeImmutable;
use Defuse\Crypto\Crypto;
use Sentry\Util\JSON;
use Symfony\Component\HttpFoundation\Response;

final class AccessTokenActionTestCase extends ControllerTestCase
{
    use UserAccessTrait;
    use DatabaseTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([UserWithCodeFixture::class]);
    }

    public function testIncorrectMethod(): void
    {
        $response = $this->jsonRequest(
            'GET',
            self::query(),
        );

        $this->assertEquals(Response::HTTP_METHOD_NOT_ALLOWED, $response->getStatusCode());
    }

    public function testSuccess(): void
    {
        $verifier = PKCE::verifier();
        $challenge = PKCE::challenge($verifier);

        $payload = [
            'client_id' => 'frontend',
            'redirect_uri' => 'https://localhost:5000/ss',
            'auth_code_id' => 'def50200f204dedbb244ce4539b9e',
            'scopes' => 'email',
            'user_id' => '00000000-0000-0000-0000-000000000001',
            'expire_time' => (new DateTimeImmutable('2300-12-31 21:00:10'))->getTimestamp(),
            'code_challenge' => $challenge,
            'code_challenge_method' => 'S256',
        ];

        $codeCrypto = Crypto::encryptWithPassword(Json::encode($payload), getenv('JWT_ENCRYPTION_KEY'));

        $response = $this->jsonRequest(
            'POST',
            $this->query(),
            [
                'grant_type' => 'authorization_code',
                'code' => $codeCrypto,
                'redirect_uri' => 'https://localhost:5000/ss',
                'client_id' => 'frontend',
                'code_verifier' => $verifier,
                'access_type' => 'offline',
            ]
        );

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        self::assertJson($content = (string)$response->getContent());

        $data = Json::decode($content);

        self::assertArrayHasKey('expires_in', $data);
        self::assertNotEmpty($data['expires_in']);

        self::assertArrayHasKey('access_token', $data);
        self::assertNotEmpty($data['access_token']);

        self::assertArrayHasKey('refresh_token', $data);
        self::assertNotEmpty($data['refresh_token']);
    }

    private function testRefreshToken(): void
    {
        $user = $this->getUserBuilder()
            ->withId('00000000-0000-0000-0000-000000000002')
            ->build();

        $client = new Client(
            identifier: 'frontend',
            name: 'Frontend',
            redirectUri: 'https://localhost:5000/ss',
        );

        $accessToken = new AccessToken(
            $client,
            [new Scope('email')]
        );
        $accessToken->setIdentifier('50200f204dedbb244ce453');

        $refreshToken = new RefreshToken();
        $refreshToken->setAccessToken($accessToken);
        $refreshToken->setExpiryDateTime(new DateTimeImmutable('2300-12-31 21:00:10'));
        $refreshToken->setIdentifier('aef50200f204dedbb244ce4539b9e');

        $this->saveEntity($user);
        $this->saveEntity($accessToken);
        $this->saveEntity($refreshToken);

        $payload = [
            'client_id' => 'frontend',
            'refresh_token_id' => 'aef50200f204dedbb244ce4539b9e',
            'access_token_id' => '50200f204dedbb244ce453',
            'scopes' => [new Scope('email')],
            'user_id' => '00000000-0000-0000-0000-000000000002',
            'expire_time' => (new DateTimeImmutable('2300-12-31 21:00:10'))->getTimestamp(),
        ];

        $token = Crypto::encryptWithPassword(Json::encode($payload), getenv('JWT_ENCRYPTION_KEY'));

        $response = $this->jsonRequest(
            'POST',
            $this->query(),
            [
                'grant_type' => 'refresh_token',
                'refresh_token' => $token,
                'redirect_uri' => 'http://localhost:8080/oauth',
                'client_id' => 'frontend',
                'access_type' => 'offline',
            ]);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());

        self::assertJson($content = (string)$response->getContent());

        $data = Json::decode($content);

//        self::assertArraySubset([
//            'token_type' => 'Bearer',
//        ], $data);

        self::assertArrayHasKey('expires_in', $data);
        self::assertNotEmpty($data['expires_in']);

        self::assertArrayHasKey('access_token', $data);
        self::assertNotEmpty($data['access_token']);

        self::assertArrayHasKey('refresh_token', $data);
        self::assertNotEmpty($data['refresh_token']);
    }

    private static function query(): string
    {
        return '/access-token';
    }
}
