<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Http\Profiles\Create;

use App\Tests\ControllerTestCase;

final class CreateFanActionTestCase extends ControllerTestCase
{
    public function testSuccessful(): void
    {
        $this->markTestSkipped();

        $response = $this->jsonRequest(
            'GET',
            self::query(),
            [
                'firstName' => 'firstName',
                'lastName' => 'lastName',
                'fatherName' => 'fatherName',
                'birthday' => '1995-10-10',
                'address' => 'Azov',
                'phone' => '+79889474747',
            ]
        );

        $responseContent = $response->getContent();
        $responseContent = json_decode($responseContent, true);

        $this->assertNotEmpty($responseContent['fanId']);
    }

    private static function query(): string
    {
        return "/profile/create/fan";
    }
}
