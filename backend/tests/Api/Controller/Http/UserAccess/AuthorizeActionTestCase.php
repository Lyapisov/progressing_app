<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Http\UserAccess;

use App\DataFixtures\UserAccess\UserFixture;
use App\Tests\ControllerTestCase;
use App\Tests\Helpers\DatabaseTrait;
use App\UserAccess\Test\Helper\UserAccessTrait;
use App\Tests\UserAccess\Helpers\PKCE;
use Symfony\Component\HttpFoundation\Response;

final class AuthorizeActionTestCase extends ControllerTestCase
{
    use UserAccessTrait;
    use DatabaseTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([UserFixture::class]);
    }

    public function testPageWithChallenge(): void
    {
        $response = $this->jsonRequest(
            'GET',
            self::query() . '?' . http_build_query([
                'response_type' => 'code',
                'client_id' => 'frontend',
                'code_challenge' => PKCE::challenge(PKCE::verifier()),
                'code_challenge_method' => 'S256',
                'redirect_uri' => 'https://localhost:5000/ss',
                'scope' => 'email',
                'state' => 'sTaTe',
            ])
        );

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertNotEmpty($content = (string)$response->getContent());
        self::assertStringContainsString('<title>Title</title>', $content);
    }

    public function testSuccess(): void
    {
        $response = $this->jsonRequest(
            'POST',
            self::query() . '?' . http_build_query([
                'response_type' => 'code',
                'client_id' => 'frontend',
                'code_challenge' => PKCE::challenge(PKCE::verifier()),
                'code_challenge_method' => 'S256',
                'redirect_uri' => 'https://localhost:5000/ss',
                'scope' => 'email',
                'state' => 'sTaTe',
            ]),
            [
                'email' => 'sdfsdf@sdf.com',
                'password' => 'ololololol',
            ]
        );

        self::assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        self::assertNotEmpty($location = $response->headers->get('location'));

        /** @var array{query:string} $url */
        $url = parse_url($location);

        self::assertNotEmpty($url['query']);

        /** @var array{code:string,state:string} $query */
        parse_str($url['query'], $query);

        self::assertArrayHasKey('code', $query);
        self::assertNotEmpty($query['code']);
        self::assertArrayHasKey('state', $query);
        self::assertEquals('sTaTe', $query['state']);
    }

    public function testWithoutParams(): void
    {
        $response = $this->jsonRequest(
            'GET',
            self::query(),
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPageWithoutChallenge(): void
    {
        $response = $this->jsonRequest(
            'GET',
            self::query() . '?' . http_build_query([
                'response_type' => 'code',
                'client_id' => 'frontend',
                'redirect_uri' => 'https://localhost:5000/ss',
                'scope' => 'email',
                'state' => 'sTaTe',
            ])
        );

        self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        self::assertJson($content = (string)$response->getContent());

//        $data = Json::decode($content);

//        self::assertArraySubset([
//            'error' => 'invalid_request',
//        ], $data);
    }

    private static function query(): string
    {
        return '/authorize';
    }
}
