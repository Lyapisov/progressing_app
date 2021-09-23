<?php

declare(strict_types=1);

namespace App\UserAccess\Domain\OAuth;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="oauth_refresh_tokens")
 */
class RefreshToken implements RefreshTokenEntityInterface
{
    use EntityTrait;
    use RefreshTokenTrait;

    /**
     * @ORM\Column(name="id", type="string", nullable=false)
     * @ORM\Id
     * @var string
     */
    protected $identifier;

    /**
     * @ORM\Column(name="expiry_date_time", type="date_immutable", nullable=false)
     * @var DateTimeImmutable
     */
    protected $expiryDateTime;

    /**
     * @ORM\Column(name="user_identifier", type="string", nullable=false)
     */
    private ?string $userIdentifier = null;

    public function setAccessToken(AccessTokenEntityInterface $accessToken): void
    {
        $this->accessToken = $accessToken;
        $this->userIdentifier = (string) $accessToken->getUserIdentifier();
    }

    public function getUserIdentifier(): ?string
    {
        return $this->userIdentifier;
    }
}
