<?php

declare(strict_types=1);

namespace App\UserAccess\Test\Domain\OAuth;

use App\UserAccess\Domain\OAuth\Client;
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
    public function testCreate(): void
    {
        $client = new Client(
            identifier: 'frontend',
            name: 'Frontend',
            redirectUri: 'https://localhost:5000/ss',
        );

        self::assertSame('frontend', $client->getIdentifier());
        self::assertSame('Frontend', $client->getName());
        self::assertSame('https://localhost:5000/ss', $client->getRedirectUri());

        self::assertFalse($client->isConfidential());
    }
}
