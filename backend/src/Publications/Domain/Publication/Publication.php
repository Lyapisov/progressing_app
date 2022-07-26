<?php

declare(strict_types=1);

namespace App\Publications\Domain\Publication;

use App\SharedKernel\Domain\Assert\Assert;
use App\SharedKernel\Domain\Model\Aggregate;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Публикация
 *
 * @ORM\Entity
 * @ORM\Table(name="publications")
 */
class Publication extends Aggregate
{
    /**
     * @ORM\Column(name="id", type="string", nullable=false)
     * @ORM\Id
     */
    private string $id;

    /**
     * @ORM\Column(name="author_id", type="string", nullable=false)
     */
    private string $authorId;

    /**
     * @ORM\Embedded(class="App\Publications\Domain\Publication\Content")
     */
    private Content $content;

    /**
     * @ORM\Embedded(class="App\Publications\Domain\Publication\Likes")
     */
    private Likes $likes;

    /**
     * @ORM\Embedded(class="App\Publications\Domain\Publication\Status")
     */
    private Status $status;

    /**
     * @ORM\Column(name="created_at", type="datetime_immutable", nullable=false)
     */
    private DateTimeImmutable $createdAt;

    public function __construct(
        string $id,
        string $authorId,
        Content $content,
        Likes $likes,
        DateTimeImmutable $createdAt
    ) {
        $this->setId($id);
        $this->setAuthorId($authorId);
        $this->content = $content;
        $this->likes = $likes;
        $this->status = new Status();
        $this->createdAt = $createdAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getContent(): Content
    {
        return $this->content;
    }

    public function getLikes(): Likes
    {
        return $this->likes;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    private function setId(string $id): void
    {
        Assert::uuid(
            $id,
            'Идентификатор публикации должен соответствовать формату uuid.'
        );

        $this->id = $id;
    }

    private function setAuthorId(string $authorId): void
    {
        Assert::uuid(
            $authorId,
            'Идентификатор автора публикации должен соответствовать формату uuid.'
        );

        $this->authorId = $authorId;
    }
}
