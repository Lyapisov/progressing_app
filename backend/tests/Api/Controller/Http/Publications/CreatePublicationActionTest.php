<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Http\Publications;

use App\DataFixtures\Helpers\LoadFixtureTrait;
use App\DataFixtures\UserAccess\UserFixture;
use App\Publications\Domain\Author\Role;
use App\Publications\Domain\Publication\Image;
use App\Publications\Domain\Publication\Status;
use App\Tests\ControllerTestCase;
use App\Tests\Helpers\Traits\DIContainerTrait;
use App\Tests\Helpers\Traits\Publications\PublicationsTrait;
use App\UserAccess\Test\Helper\OAuthHeader;
use App\Util\DateProvider\TestDateProvider;
use DateTimeImmutable;

final class CreatePublicationActionTest extends ControllerTestCase
{
    use LoadFixtureTrait;
    use PublicationsTrait;
    use DIContainerTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([UserFixture::class]);
    }

    public function testWithoutImageId(): void
    {
        /** @var TestDateProvider $dateProvider */
        $dateProvider = $this->getDependency(TestDateProvider::class);
        $dateProvider->setNow($date = new DateTimeImmutable('01-01-2022'));

        $author = $this->getAuthorBuilder()
            ->withId('00000000-0000-0000-0000-000000000001')
            ->withFullName('Full')
            ->withRole(Role::fan())
            ->build();
        $this->saveEntity($author);

        $response = $this->jsonRequest(
            'POST',
            self::query(),
            [
                'title' => $title = 'new title',
                'text' => $text = 'new text publication',
                'imageId' => '',
            ],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonResponse($response, ['id' => '@uuid@']);

        $publicationId = $this->extractParameterFromResponse($response, 'id');

        $publication = $this->getPublicationRepository()->findById($publicationId);
        $this->assertEquals($title, $publication->getContent()->getTitle());
        $this->assertEquals($text, $publication->getContent()->getText());
        $this->assertEquals(Image::createDefault(), $publication->getContent()->getImage());
        $this->assertEquals($author->getId(), $publication->getAuthorId());
        $this->assertEquals(new Status(), $publication->getStatus());
        $this->assertEquals(0, $publication->getLikes()->getCount());
        $this->assertEquals([], $publication->getLikes()->getAuthors());
        $this->assertEquals($date, $publication->getCreatedAt());
    }

    public function testWithImageId(): void
    {
        /** @var TestDateProvider $dateProvider */
        $dateProvider = $this->getDependency(TestDateProvider::class);
        $dateProvider->setNow($date = new DateTimeImmutable('01-01-2022'));

        $author = $this->getAuthorBuilder()
            ->withId('00000000-0000-0000-0000-000000000001')
            ->withFullName('Full')
            ->withRole(Role::fan())
            ->build();
        $this->saveEntity($author);

        $response = $this->jsonRequest(
            'POST',
            self::query(),
            [
                'title' => $title = 'new title',
                'text' => $text = 'new text publication',
                'imageId' => 'imageId',
            ],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonResponse($response, ['id' => '@uuid@']);

        $publicationId = $this->extractParameterFromResponse($response, 'id');

        $publication = $this->getPublicationRepository()->findById($publicationId);
        $this->assertEquals($title, $publication->getContent()->getTitle());
        $this->assertEquals($text, $publication->getContent()->getText());
        $this->assertEquals('imageId', $publication->getContent()->getImage()->getId());
        $this->assertEquals($author->getId(), $publication->getAuthorId());
        $this->assertEquals(new Status(), $publication->getStatus());
        $this->assertEquals(0, $publication->getLikes()->getCount());
        $this->assertEquals([], $publication->getLikes()->getAuthors());
        $this->assertEquals($date, $publication->getCreatedAt());
    }

    public function testAuthorNotFound(): void
    {
        $response = $this->jsonRequest(
            'POST',
            self::query(),
            [
                'title' => $title = 'new title',
                'text' => $text = 'new text publication',
                'imageId' => 'imageId',
            ],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonResponse($response, [
            'error' => [
                'messages' => [
                    'Автор с идентификатором: 00000000-0000-0000-0000-000000000001 не найден.'
                ],
                'code' => 1
            ]
        ]);
    }

    public function testUnauthorized(): void
    {
        $response = $this->jsonRequest(
            'POST',
            self::query(),
            [
                'title' => $title = 'new title',
                'text' => $text = 'new text publication',
                'imageId' => 'imageId',
            ],
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

    public function testEmptyRequest(): void
    {
        $response = $this->jsonRequest(
            'POST',
            self::query(),
        );

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonResponse($response, [
            'error' => [
                'messages' => [
                    'Заголовок публикации обязателен.',
                    'Текст публикации обязателен.',
                ],
                'code' => 1
            ]
        ]);
    }

    public function testLongTitle(): void
    {
        $title = 'long long long long long long title';
        while (strlen($title) < 252) {
            $title = $title . $title;
        }

        $response = $this->jsonRequest(
            'POST',
            self::query(),
            [
                'title' => $title,
                'text' => $text = 'new text publication',
                'imageId' => 'imageId',
            ],
        );

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonResponse($response, [
            'error' => [
                'messages' => [
                    'Заголовок публикации должен быть не более 250 символов.',
                ],
                'code' => 1
            ]
        ]);
    }

    private static function query(): string
    {
        return "/publications";
    }
}
