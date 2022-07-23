<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Http\Profiles\Get;

use App\DataFixtures\Helpers\LoadFixtureTrait;
use App\DataFixtures\UserAccess\UserFixture;
use App\Profiles\Domain\Fan\Fan;
use App\Profiles\Domain\Musician\Musician;
use App\Profiles\Domain\Shared\Address;
use App\Profiles\Domain\Shared\Name;
use App\Profiles\Domain\Shared\Phone;
use App\Tests\ControllerTestCase;
use App\UserAccess\Test\Helper\OAuthHeader;
use Symfony\Component\HttpFoundation\Response;

final class ByIdTest extends ControllerTestCase
{
    use LoadFixtureTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([UserFixture::class]);
    }

    public function testSuccessful(): void
    {
        $this->markTestSkipped();

//        $fan = new Fan(
//            $id = 'fc53f31a-50b7-49af-97e6-45529c2e947a',
//            $userId = 'fc53f31a-49af-49af-97e6-45529c2e947a',
//            new Name($name = 'www', 'first', 'last', 'father'),
//            new \DateTimeImmutable('1995-10-10'),
//            new Address($address = 'Azov'),
//            new Phone($number = '+79889474700'),
//        );
//
//        $this->saveEntity($fan);

        $response = $this->jsonRequest(
            'GET',
            self::query($id),
            [],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $responseContent = json_decode($response->getContent(), true);

        $this->assertEquals($id, $responseContent['fanId']);
        $this->assertEquals('first', $responseContent['name']);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    private static function query(string $id): string
    {
        return "/profiles/{$id}";
    }
}
