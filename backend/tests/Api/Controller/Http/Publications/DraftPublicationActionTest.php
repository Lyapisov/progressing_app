<?php

namespace App\Tests\Api\Controller\Http\Publications;

use App\DataFixtures\Helpers\LoadFixtureTrait;
use App\DataFixtures\UserAccess\UserFixture;
use App\Publications\Domain\Author\Role;
use App\Publications\Domain\Publication\Content;
use App\Publications\Domain\Publication\Image;
use App\Publications\Domain\Publication\Status;
use App\Tests\ControllerTestCase;
use App\Tests\Helpers\Traits\DIContainerTrait;
use App\Tests\Helpers\Traits\Publications\PublicationsTrait;
use App\UserAccess\Test\Helper\OAuthHeader;
use DateTimeImmutable;

class DraftPublicationActionTest extends ControllerTestCase
{
    use LoadFixtureTrait;
    use PublicationsTrait;
    use DIContainerTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([UserFixture::class]);
    }

    public function testSuccessfullyWithPublished(): void
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
            ->withPublishedStatus()
            ->build();
        $this->saveEntity($firstPublication);

        $response = $this->jsonRequest(
            'PATCH',
            self::query($firstPublication->getId()),
            [],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertResponseStatusCodeSame(200);

        $publication = $this->getPublicationRepository()->getById($firstPublication->getId());
        $this->assertEquals('draft', $publication->getStatus()->getName());
    }

    public function testSuccessfullyWithArchived(): void
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
            ->withArchivedStatus()
            ->build();
        $this->saveEntity($firstPublication);

        $response = $this->jsonRequest(
            'PATCH',
            self::query($firstPublication->getId()),
            [],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertResponseStatusCodeSame(200);

        $publication = $this->getPublicationRepository()->getById($firstPublication->getId());
        $this->assertEquals('draft', $publication->getStatus()->getName());
    }

    public function testIncorrectStatus(): void
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
            'PATCH',
            self::query($firstPublication->getId()),
            [],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonResponse($response, [
            'error' => [
                'messages' => [
                    'Публикацию можно перевести в черновик только из статуса "Архивирована" или "Опубликована"'
                ],
                'code' => 1,
            ]
        ]);
    }

    public function testAccessDenied(): void
    {
        $author = $this->getAuthorBuilder()
            ->withId('00000000-0000-0000-0000-000000000001')
            ->withFullName('Full')
            ->withRole(Role::fan())
            ->build();
        $this->saveEntity($author);

        $firstPublication = $this->getPublicationBuilder()
            ->withId('0cf9773e-869d-46d5-a771-1c5f08296c84')
            ->withAuthorId('00000000-0000-0000-0000-000000000002')
            ->withContent(new Content('first title', 'text', Image::createDefault()))
            ->withCreatedAt($firstCreatedAt = new DateTimeImmutable('01-01-2022'))
            ->withPublishedStatus()
            ->build();
        $this->saveEntity($firstPublication);

        $response = $this->jsonRequest(
            'PATCH',
            self::query($firstPublication->getId()),
            [],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertResponseStatusCodeSame(403);

        $this->assertJsonResponse($response, [
            'error' => [
                'messages' => [
                    'Доступ к публикации запрещен.'
                ],
                'code' => 1,
            ]
        ]);
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
            'PATCH',
            self::query('00000000-0000-0000-0000-000000000001'),
            [],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertJsonResponse($response, [
            'error' => [
                'messages' => [
                    'Публикация с идентификатором: 00000000-0000-0000-0000-000000000001 не найдена.'
                ],
                'code' => 1,
            ]
        ]);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testUnauthorized(): void
    {
        $response = $this->jsonRequest(
            'PATCH',
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
        return "/publications/" . $id . "/draft";
    }
}
