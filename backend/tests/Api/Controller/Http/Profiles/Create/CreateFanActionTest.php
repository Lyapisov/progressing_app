<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Http\Profiles\Create;

use App\DataFixtures\Helpers\LoadFixtureTrait;
use App\DataFixtures\UserAccess\UserFixture;
use App\Tests\ControllerTestCase;
use App\UserAccess\Test\Helper\OAuthHeader;

final class CreateFanActionTest extends ControllerTestCase
{
    use LoadFixtureTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures([UserFixture::class]);
    }

    public function testSuccessful(): void
    {
        $response = $this->jsonRequest(
            'POST',
            self::query(),
            [
                'firstName' => 'firstName',
                'lastName' => 'lastName',
                'fatherName' => 'fatherName',
                'birthday' => '1995-10-10',
                'address' => 'Azov',
                'phone' => '+79889474747',
            ],
            [],
            OAuthHeader::for('lyapisov', $this->getEntityManager()),
        );

        $this->assertJsonResponse($response, ['fanId' => '@uuid@']);
    }

    private static function query(): string
    {
        return "/profiles/fans";
    }
}
