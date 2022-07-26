<?php

declare(strict_types=1);

namespace App\Publications\Domain\Author;

use App\SharedKernel\Domain\Assert\Assert;
use App\SharedKernel\Domain\Model\Aggregate;
use Doctrine\ORM\Mapping as ORM;

/**
 * Автор публикации
 *
 * @ORM\Entity
 * @ORM\Table(name="publications_author")
 */
class Author extends Aggregate
{
    /**
     * Идентификатор соответствующий userId
     *
     * @ORM\Column(name="id", type="string", nullable=false)
     * @ORM\Id
     */
    private string $id;

    /**
     * @ORM\Column(name="full_name", type="string", nullable=false)
     */
    private string $fullName;

    /**
     * @ORM\Embedded(class="App\Publications\Domain\Author\Role")
     */
    private Role $role;

    public function __construct(
        string $id,
        string $fullName,
        Role $role,
    ) {
        $this->setId($id);
        $this->setFullName($fullName);
        $this->role = $role;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    private function setId(string $id): void
    {
        Assert::uuid(
            $id,
            'Идентификатор фаната должен соответствовать формату uuid.'
        );

        $this->id = $id;
    }

    private function setFullName(string $fullName): void
    {
        Assert::notEmpty(
            $fullName,
            'Полное имя автора не может быть пустым.'
        );

        $this->fullName = $fullName;
    }
}
