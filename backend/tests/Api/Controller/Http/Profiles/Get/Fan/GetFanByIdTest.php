<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Http\Profiles\Get\Fan;

use App\DataFixtures\Helpers\LoadFixtureTrait;
use App\DataFixtures\UserAccess\UserFixture;
use App\Profiles\Domain\Fan\Fan;
use App\Profiles\Domain\Shared\Address;
use App\Profiles\Domain\Shared\Name;
use App\Profiles\Domain\Shared\PersonalData;
use App\Profiles\Domain\Shared\Phone;
use App\Tests\Helpers\Traits\Profiles\ProfilesTrait;
use App\Tests\ControllerTestCase;
use App\UserAccess\Test\Helper\OAuthHeader;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Response;

final class GetFanByIdTest extends ControllerTestCase
{
    use LoadFixtureTrait;
    use ProfilesTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([UserFixture::class]);
    }

    public function testSuccessful(): void
    {
        $fan = $this->getFanBuilder()
            ->withId($id = 'fc53f31a-50b7-49af-97e6-45529c2e947a')
            ->withUserId($userId = '00000000-0000-0000-0000-000000000001')
            ->withPersonalData(
                new PersonalData(
                    new Name($name = 'first', $last = 'last', $father = 'father'),
                    new Phone($number = '+79889474700'),
                    new Address($address = 'Azov'),
                    new DateTimeImmutable($birthday = '10-10-1995'),
                )
            )
            ->build();
        $this->saveEntity($fan);

        $response = $this->jsonRequest(
            'GET',
            self::query($id),
            [],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

        $this->assertJsonResponse($response, [
            'id' => $id,
            'personalData' => [
                'name' => [
                    'first' => $name,
                    'last' => $last,
                    'father' => $father,
                ],
                'phone' => [
                    'number' => $number,
                ],
                'address' => $address,
                'birthday' => '@integer@'
            ]
        ]);
    }

    public function testFanNotFound(): void
    {
        $response = $this->jsonRequest(
            'GET',
            self::query('0cf9773e-869d-46d5-a771-1c5f08296c84'),
            [],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());

        $this->assertJsonResponse($response, [
           'error' => [
               'messages' => [
                   'Фанат с идентификатором: 0cf9773e-869d-46d5-a771-1c5f08296c84 не найден.'
               ],
               'code' => 1
           ]
        ]);
    }

    private static function query(string $id): string
    {
        return "/profiles/fans/{$id}";
    }
}
