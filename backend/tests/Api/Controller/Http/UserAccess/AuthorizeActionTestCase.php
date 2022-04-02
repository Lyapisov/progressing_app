<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Http\UserAccess;

use App\Tests\ControllerTestCase;
use App\UserAccess\Test\Helper\UserAccessTrait;
use Symfony\Component\HttpFoundation\Response;
use Trikoder\Bundle\OAuth2Bundle\Model\Client;
use Trikoder\Bundle\OAuth2Bundle\Model\Grant;
use Trikoder\Bundle\OAuth2Bundle\OAuth2Grants;

final class AuthorizeActionTestCase extends ControllerTestCase
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
        $client->setGrants(new Grant(OAuth2Grants::PASSWORD));
        $this->saveEntity($client);

        $response = $this->jsonRequest(
            'POST',
            self::query(),
            [
                'grant_type' => 'password',
                'username' => 'lyapisov',
                'password' => '123456789',
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

    public function testInvalidUsername(): void
    {
        $user = $this->getUserBuilder()
            ->withId('18478ecd-b865-4e85-9726-e0582fb6aa82')
            ->withLogin('lyapisov')
            ->withPassword('123456789')
            ->build();
        $this->saveEntity($user);

        $client = new Client('oauth', 'secret');
        $client->setGrants(new Grant(OAuth2Grants::PASSWORD));
        $this->saveEntity($client);

        $response = $this->jsonRequest(
            'POST',
            self::query(),
            [
                'grant_type' => 'password',
                'username' => 'lyapiso',
                'password' => '123456789',
                'client_id' => 'oauth',
                'client_secret' => 'secret',
            ]
        );

//        $this->assertJsonResponse($response, [
//            'error' => [
//                'messages' => ['Неверный логин или пароль!'],
//                'code' => 1,
//            ],
//        ]);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testInvalidPassword(): void
    {
        $user = $this->getUserBuilder()
            ->withId('18478ecd-b865-4e85-9726-e0582fb6aa82')
            ->withLogin('lyapisov')
            ->withPassword('123456789')
            ->build();
        $this->saveEntity($user);

        $client = new Client('oauth', 'secret');
        $client->setGrants(new Grant(OAuth2Grants::PASSWORD));
        $this->saveEntity($client);

        $response = $this->jsonRequest(
            'POST',
            self::query(),
            [
                'grant_type' => 'password',
                'username' => 'lyapisov',
                'password' => '123456780',
                'client_id' => 'oauth',
                'client_secret' => 'secret',
            ]
        );

//        $this->assertJsonResponse($response, [
//            'error' => 'invalid_grant',
//            "error_description" => "The user credentials were incorrect.",
//            "message" => "The user credentials were incorrect."
//        ]);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    private static function query(): string
    {
        return '/token';
    }
}
