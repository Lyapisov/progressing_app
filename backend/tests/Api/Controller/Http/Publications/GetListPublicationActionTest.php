<?php

declare(strict_types=1);

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
use App\Util\DateProvider\TestDateProvider;
use DateTimeImmutable;

final class GetListPublicationActionTest extends ControllerTestCase
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

        $secondPublication = $this->getPublicationBuilder()
            ->withId('0cf9773e-869d-46d5-a771-1c5f08296c85')
            ->withAuthorId($author->getId())
            ->withContent(new Content('second title', 'text', Image::createDefault()))
            ->withCreatedAt($secondCreatedAt = new DateTimeImmutable('02-01-2022'))
            ->build();
        $this->saveEntity($secondPublication);

        $response = $this->jsonRequest(
            'GET',
            self::query(),
            [
                'filters' => [],
                'sorting' => [],
            ],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertJsonResponse($response, [
            [
                'id' => $firstPublication->getId(),
                'content' => [
                    'title' => $firstPublication->getContent()->getTitle(),
                    'text' => $firstPublication->getContent()->getText(),
                    'imageId' => $firstPublication->getContent()->getImage()->getId(),
                ],
                'author' => [
                    'id' => $author->getId(),
                    'fullName' => $author->getFullName(),
                    'role' => $author->getRole()->getName(),
                ],
                'status' => $firstPublication->getStatus()->getName(),
                'likes' => [
                    'count' => $firstPublication->getLikes()->getCount(),
                    'authors' => $firstPublication->getLikes()->getAuthors(),
                ],
                'createdAt' => $firstCreatedAt->getTimestamp(),
            ],
            [
                'id' => $secondPublication->getId(),
                'content' => [
                    'title' => $secondPublication->getContent()->getTitle(),
                    'text' => $secondPublication->getContent()->getText(),
                    'imageId' => $secondPublication->getContent()->getImage()->getId(),
                ],
                'author' => [
                    'id' => $author->getId(),
                    'fullName' => $author->getFullName(),
                    'role' => $author->getRole()->getName(),
                ],
                'status' => $secondPublication->getStatus()->getName(),
                'likes' => [
                    'count' => $secondPublication->getLikes()->getCount(),
                    'authors' => $secondPublication->getLikes()->getAuthors(),
                ],
                'createdAt' => $secondCreatedAt->getTimestamp(),
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);
    }

    public function testFilterByAuthor(): void
    {
        $author = $this->getAuthorBuilder()
            ->withId('00000000-0000-0000-0000-000000000001')
            ->withFullName('Full')
            ->withRole(Role::fan())
            ->build();
        $this->saveEntity($author);

        $secondAuthor = $this->getAuthorBuilder()
            ->withId('00000000-0000-0000-0000-000000000002')
            ->withFullName('Full')
            ->withRole(Role::musician())
            ->build();
        $this->saveEntity($secondAuthor);

        $firstPublication = $this->getPublicationBuilder()
            ->withId('0cf9773e-869d-46d5-a771-1c5f08296c84')
            ->withAuthorId($author->getId())
            ->withContent(new Content('first title', 'text', Image::createDefault()))
            ->withCreatedAt($firstCreatedAt = new DateTimeImmutable('01-01-2022'))
            ->build();
        $this->saveEntity($firstPublication);

        $secondPublication = $this->getPublicationBuilder()
            ->withId('0cf9773e-869d-46d5-a771-1c5f08296c85')
            ->withAuthorId($secondAuthor->getId())
            ->withContent(new Content('second title', 'text', Image::createDefault()))
            ->withCreatedAt($secondCreatedAt = new DateTimeImmutable('02-01-2022'))
            ->build();
        $this->saveEntity($secondPublication);

        $response = $this->jsonRequest(
            'GET',
            self::query(),
            [
                'filters' => [
                    'authors' => [$secondAuthor->getId()]
                ],
                'sorting' => [],
            ],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertJsonResponse($response, [
            [
                'id' => $secondPublication->getId(),
                'content' => [
                    'title' => $secondPublication->getContent()->getTitle(),
                    'text' => $secondPublication->getContent()->getText(),
                    'imageId' => $secondPublication->getContent()->getImage()->getId(),
                ],
                'author' => [
                    'id' => $secondAuthor->getId(),
                    'fullName' => $secondAuthor->getFullName(),
                    'role' => $secondAuthor->getRole()->getName(),
                ],
                'status' => $secondPublication->getStatus()->getName(),
                'likes' => [
                    'count' => $secondPublication->getLikes()->getCount(),
                    'authors' => $secondPublication->getLikes()->getAuthors(),
                ],
                'createdAt' => $secondCreatedAt->getTimestamp(),
            ]
        ]);

        $this->assertResponseStatusCodeSame(200);
    }

    public function testFilterByStatus(): void
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

        $secondPublication = $this->getPublicationBuilder()
            ->withId('0cf9773e-869d-46d5-a771-1c5f08296c85')
            ->withAuthorId($author->getId())
            ->withContent(new Content('second title', 'text', Image::createDefault()))
            ->withCreatedAt($secondCreatedAt = new DateTimeImmutable('02-01-2022'))
            ->build();
        $this->saveEntity($secondPublication);

        $response = $this->jsonRequest(
            'GET',
            self::query(),
            [
                'filters' => [
                    'statuses' => ['banned']
                ],
                'sorting' => [],
            ],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertJsonResponse($response, []);

        $this->assertResponseStatusCodeSame(200);
    }

    public function testSortingByCreatedAtDESC(): void
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

        $secondPublication = $this->getPublicationBuilder()
            ->withId('0cf9773e-869d-46d5-a771-1c5f08296c85')
            ->withAuthorId($author->getId())
            ->withContent(new Content('second title', 'text', Image::createDefault()))
            ->withCreatedAt($secondCreatedAt = new DateTimeImmutable('02-01-2022'))
            ->build();
        $this->saveEntity($secondPublication);

        $response = $this->jsonRequest(
            'GET',
            self::query(),
            [
                'filters' => [],
                'sorting' => [
                    'createdAt' => 'DESC'
                ],
            ],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertJsonResponse($response, [
            [
                'id' => $secondPublication->getId(),
                'content' => [
                    'title' => $secondPublication->getContent()->getTitle(),
                    'text' => $secondPublication->getContent()->getText(),
                    'imageId' => $secondPublication->getContent()->getImage()->getId(),
                ],
                'author' => [
                    'id' => $author->getId(),
                    'fullName' => $author->getFullName(),
                    'role' => $author->getRole()->getName(),
                ],
                'status' => $secondPublication->getStatus()->getName(),
                'likes' => [
                    'count' => $secondPublication->getLikes()->getCount(),
                    'authors' => $secondPublication->getLikes()->getAuthors(),
                ],
                'createdAt' => $secondCreatedAt->getTimestamp(),
            ],
            [
                'id' => $firstPublication->getId(),
                'content' => [
                    'title' => $firstPublication->getContent()->getTitle(),
                    'text' => $firstPublication->getContent()->getText(),
                    'imageId' => $firstPublication->getContent()->getImage()->getId(),
                ],
                'author' => [
                    'id' => $author->getId(),
                    'fullName' => $author->getFullName(),
                    'role' => $author->getRole()->getName(),
                ],
                'status' => $firstPublication->getStatus()->getName(),
                'likes' => [
                    'count' => $firstPublication->getLikes()->getCount(),
                    'authors' => $firstPublication->getLikes()->getAuthors(),
                ],
                'createdAt' => $firstCreatedAt->getTimestamp(),
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);
    }

    public function testWithLikes(): void
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
            ->withLikesAuthors(['00000000-0000-0000-0000-000000000001'])
            ->withPublishedStatus()
            ->build();
        $this->saveEntity($firstPublication);

        $secondPublication = $this->getPublicationBuilder()
            ->withId('0cf9773e-869d-46d5-a771-1c5f08296c85')
            ->withAuthorId($author->getId())
            ->withContent(new Content('second title', 'text', Image::createDefault()))
            ->withCreatedAt($secondCreatedAt = new DateTimeImmutable('02-01-2022'))
            ->build();
        $this->saveEntity($secondPublication);

        $response = $this->jsonRequest(
            'GET',
            self::query(),
            [
                'filters' => [],
                'sorting' => [],
            ],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertJsonResponse($response, [
            [
                'id' => $firstPublication->getId(),
                'content' => [
                    'title' => $firstPublication->getContent()->getTitle(),
                    'text' => $firstPublication->getContent()->getText(),
                    'imageId' => $firstPublication->getContent()->getImage()->getId(),
                ],
                'author' => [
                    'id' => $author->getId(),
                    'fullName' => $author->getFullName(),
                    'role' => $author->getRole()->getName(),
                ],
                'status' => $firstPublication->getStatus()->getName(),
                'likes' => [
                    'count' => 1,
                    'authors' => ['00000000-0000-0000-0000-000000000001'],
                ],
                'createdAt' => $firstCreatedAt->getTimestamp(),
            ],
            [
                'id' => $secondPublication->getId(),
                'content' => [
                    'title' => $secondPublication->getContent()->getTitle(),
                    'text' => $secondPublication->getContent()->getText(),
                    'imageId' => $secondPublication->getContent()->getImage()->getId(),
                ],
                'author' => [
                    'id' => $author->getId(),
                    'fullName' => $author->getFullName(),
                    'role' => $author->getRole()->getName(),
                ],
                'status' => $secondPublication->getStatus()->getName(),
                'likes' => [
                    'count' => $secondPublication->getLikes()->getCount(),
                    'authors' => $secondPublication->getLikes()->getAuthors(),
                ],
                'createdAt' => $secondCreatedAt->getTimestamp(),
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);
    }

    private static function query(): string
    {
        return "/publications";
    }
}
