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

class LikePublicationActionTest extends ControllerTestCase
{
    use LoadFixtureTrait;
    use PublicationsTrait;
    use DIContainerTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([UserFixture::class]);
    }

    public function testLikeWithZeroCurrentLikes(): void
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
        $this->assertEquals(1, $publication->getLikes()->getCount());
        $this->assertEquals(['00000000-0000-0000-0000-000000000001'], $publication->getLikes()->getAuthors());
    }

    public function testLikeWithOneCurrentLikes(): void
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
            ->withLikesAuthors(['00000000-0000-0000-0000-000000000002'])
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
        $this->assertEquals(2, $publication->getLikes()->getCount());
        $this->assertEquals(
            ['00000000-0000-0000-0000-000000000002', '00000000-0000-0000-0000-000000000001'],
            $publication->getLikes()->getAuthors()
        );
    }

    public function testDislike(): void
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
            ->withLikesAuthors(['00000000-0000-0000-0000-000000000001'])
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
        $this->assertEquals(0, $publication->getLikes()->getCount());
        $this->assertEquals([], $publication->getLikes()->getAuthors());
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
                    'Лайк/Дизлайк можно поставить только опубликованной публикации.'
                ],
                'code' => 1,
            ]
        ]);
    }

    public function testLikeAuthorNotFound(): void
    {
        $firstPublication = $this->getPublicationBuilder()
            ->withId('0cf9773e-869d-46d5-a771-1c5f08296c84')
            ->withAuthorId('00000000-0000-0000-0000-000000000001')
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

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonResponse($response, [
            'error' => [
                'messages' => [
                    'Автор с идентификатором: 00000000-0000-0000-0000-000000000001 не найден.'
                ],
                'code' => 1,
            ]
        ]);
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
        return "/publications/" . $id . "/like";
    }
}
