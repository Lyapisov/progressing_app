<?php

declare(strict_types=1);

namespace App\Publications\Test\Domain;

use App\Publications\Domain\Author\Role;
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

    /**
     * @return array<string, array<string, string>>
     */
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
