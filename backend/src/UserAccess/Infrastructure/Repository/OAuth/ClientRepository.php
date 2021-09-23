<?php

declare(strict_types=1);

namespace App\UserAccess\Infrastructure\Repository\OAuth;

use App\UserAccess\Domain\OAuth\Client;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;

final class ClientRepository implements ClientRepositoryInterface
{
    private string $clientId = 'frontend';
    private string $clientName = 'Schedule';
    private string $redirectUri = 'https://localhost:5000/ss';

    public function __construct() {}

    public function getClientEntity($clientIdentifier): Client
    {
        return new Client(
            $this->clientId,
            $this->clientName,
            $this->redirectUri,
        );
    }

    public function validateClient($clientIdentifier, $clientSecret, $grantType): bool
    {
        $client = $this->getClientEntity($clientIdentifier);

        if ($client === null) {
            return false;
        }

        if ($clientSecret !== null) {
            return false;
        }

        return true;
    }
}
