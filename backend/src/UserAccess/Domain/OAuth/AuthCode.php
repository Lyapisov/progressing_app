<?php

declare(strict_types=1);

namespace App\UserAccess\Domain\OAuth;

use DateTimeImmutable;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AuthCodeTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="oauth_auth_codes")
 */
class AuthCode implements AuthCodeEntityInterface
{
    use AuthCodeTrait;
    use EntityTrait;
    use TokenEntityTrait;

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
     * @var string
     */
    protected $userIdentifier;
}
