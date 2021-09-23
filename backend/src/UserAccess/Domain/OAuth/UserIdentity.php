<?php

declare(strict_types=1);

namespace App\UserAccess\Domain\OAuth;

use League\OAuth2\Server\Entities\UserEntityInterface;
use Webmozart\Assert\Assert;

final class UserIdentity implements UserEntityInterface
{
    private string $identifier;

    public function __construct(string $identifier)
    {
        Assert::uuid($identifier);

        $this->identifier = $identifier;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }
}
