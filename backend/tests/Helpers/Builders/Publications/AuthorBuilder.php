<?php

declare(strict_types=1);

namespace App\Tests\Helpers\Builders\Publications;

use App\Publications\Domain\Author\Author;
use App\Publications\Domain\Author\Role;

final class AuthorBuilder
{
    private const ID = '54fb9344-428f-449f-8380-b97fa9a59ac2';
    private const FULL_NAME = 'Sadio Mane';

    private string $id = self::ID;
    private string $fullName = self::FULL_NAME;
    private Role $role;

    public function __construct()
    {
        $this->role = Role::fan();
    }

    public function withId(string $id): AuthorBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function withFullName(string $fullName): AuthorBuilder
    {
        $this->fullName = $fullName;
        return $this;
    }

    public function withRole(Role $role): AuthorBuilder
    {
        $this->role = $role;
        return $this;
    }

    public function build(): Author
    {
        $author = new Author(
            $this->id,
            $this->fullName,
            $this->role,
        );

        return $author;
    }
}
