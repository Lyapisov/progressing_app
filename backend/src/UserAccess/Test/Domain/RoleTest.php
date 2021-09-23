<?php

declare(strict_types=1);

namespace App\UserAccess\Test\Domain;

use App\UserAccess\Domain\Role;
use DomainException;
use PHPUnit\Framework\TestCase;

final class RoleTest extends TestCase
{
    /**
     * @dataProvider validDataProvider
     */
    public function testSuccess(string $role): void
    {
        $createdRole = Role::create($role);

        $this->assertEquals($role, $createdRole->get());
    }

    public function testIncorrectRole(): void
    {
        $this->expectExceptionObject(
            new DomainException(
                "Роль не может принимать значение \"incorrect\""
            )
        );

        Role::create('incorrect');
    }

    public function validDataProvider(): array
    {
        return [
            'Фанат' => [
                'role' => 'fan'
            ],
            'Музыкант' => [
                'role' => 'musician'
            ],
            'Продюсер' => [
                'role' => 'producer'
            ],
        ];
    }
}
