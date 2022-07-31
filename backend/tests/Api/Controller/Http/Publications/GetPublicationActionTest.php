<?php

namespace App\Tests\Api\Controller\Http\Publications;

use App\DataFixtures\Helpers\LoadFixtureTrait;
use App\DataFixtures\UserAccess\UserFixture;
use App\Publications\Domain\Author\Role;
use App\Publications\Domain\Publication\Content;
use App\Publications\Domain\Publication\Image;
use App\Tests\ControllerTestCase;
use App\Tests\Helpers\Traits\DIContainerTrait;
use App\Tests\Helpers\Traits\Publications\PublicationsTrait;
use App\UserAccess\Test\Helper\OAuthHeader;
use DateTimeImmutable;

class GetPublicationActionTest extends ControllerTestCase
{
    use LoadFixtureTrait;
    use PublicationsTrait;
    use DIContainerTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([UserFixture::class]);
    }

    public function testSuccessfully(): void
    {
        $author = $this->getAuthorBuilder()
            ->withId('00000000-0000-0000-0000-000000000001')
            ->withFullName('Full')
            ->withRole(Role::fan())
            ->build();
        $this->saveEntity($author);

        $firstPublication = $this->getPublicationBuilder()
            ->withId('0cf9773e-869d-46d5-a771-1c5f08296c84')
            ->withAuthorId($author->getId())
            ->withContent(new Content('first title', 'text', Image::createDefault()))
            ->withCreatedAt($firstCreatedAt = new DateTimeImmutable('01-01-2022'))
            ->build();
        $this->saveEntity($firstPublication);

        $response = $this->jsonRequest(
            'GET',
            self::query($firstPublication->getId()),
            [],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertJsonResponse($response, [
            'id' => $firstPublication->getId(),
            'authorId' => $firstPublication->getAuthorId(),
            'content' => [
                'title' => $firstPublication->getContent()->getTitle(),
                'text' => $firstPublication->getContent()->getText(),
                'imageId' => $firstPublication->getContent()->getImage()->getId(),
            ],
            'status' => $firstPublication->getStatus()->getName(),
            'countLikes' => $firstPublication->getLikes()->getCount(),
            'createdAt' => $firstCreatedAt->getTimestamp(),
        ]);

        $this->assertResponseStatusCodeSame(200);
    }

    public function testNotFoundPublication(): void
    {
        $author = $this->getAuthorBuilder()
            ->withId('00000000-0000-0000-0000-000000000001')
            ->withFullName('Full')
            ->withRole(Role::fan())
            ->build();
        $this->saveEntity($author);

        $response = $this->jsonRequest(
            'GET',
            self::query('00000000-0000-0000-0000-000000000001'),
            [],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertJsonResponse($response, [
            'error' => [
                'messages' => [
                    'Публикация с идентификатором 00000000-0000-0000-0000-000000000001 не найдена.'
                ],
                'code' => 1,
            ]
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testUnauthorized(): void
    {
        $response = $this->jsonRequest(
            'GET',
            self::query('00000000-0000-0000-0000-000000000001'),
        );

        $this->assertResponseStatusCodeSame(401);
        $this->assertJsonResponse($response, [
            'error' => [
                'messages' => [
                    'Неверный токен авторизации!'
                ],
                'code' => 1
            ]
        ]);
    }

    private static function query(string $id): string
    {
        return "/publications/" . $id;
    }
}