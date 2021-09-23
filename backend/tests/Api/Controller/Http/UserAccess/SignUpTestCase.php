<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Http\UserAccess;

use App\Tests\ControllerTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\Tests\Helpers\AssertUUIDTrait;

final class SignUpTestCase extends ControllerTestCase
{
    use AssertUUIDTrait;

    private const USER_LOGIN = 'Kenny';
    private const USER_EMAIL = 'kenny@gmail.com';
    private const USER_PASSWORD = 'kenny2000;)';
    private const USER_PRODUCER_ROLE = 'producer';
    private const USER_MUSICIAN_ROLE = 'musician';
    private const USER_FAN_ROLE = 'fan';

    public function testSuccessful()
    {
//        copy('src/FilesDataBase/DataBase/UserAccess/Users/TestBase/users-test.csv',
//            'src/FilesDataBase/DataBase/UserAccess/Users/TestBase/users-copy.csv'
//        );

        $response = $this->jsonRequest(
            'POST',
            self::query(),
            [
                'login' => self::USER_LOGIN,
                'email' => self::USER_EMAIL,
                'password' => self::USER_PASSWORD,
                'role' => self::USER_FAN_ROLE,
            ]
        );

        $responseContent = $response->getContent();

        $responseContent = json_decode($responseContent, true);

        $this->assertEquals(self::USER_LOGIN, $responseContent['user']['login']);
        $this->assertEquals(self::USER_EMAIL, $responseContent['user']['email']);
        $this->assertEquals(self::USER_FAN_ROLE, $responseContent['user']['role']);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());

//        copy('src/FilesDataBase/DataBase/UserAccess/Users/TestBase/users-copy.csv',
//            'src/FilesDataBase/DataBase/UserAccess/Users/TestBase/users-test.csv'
//        );
//        unlink('src/FilesDataBase/DataBase/UserAccess/Users/TestBase/users-copy.csv');
    }

    public function testIncorrectLogin()
    {
        $response = $this->jsonRequest(
            'POST',
            self::query(),
            [
                'login' => 'a a%',
                'email' => self::USER_EMAIL,
                'password' => self::USER_PASSWORD,
                'role' => self::USER_FAN_ROLE,
            ]
        );

        $expectedContent =
            [
                'error' => [
                    'messages' => [ "Невозможно создать логин с данными символами." ],
                    'code' => 1,
                ],
            ];

        $responseContent = $response->getContent();
        $responseContent = json_decode($responseContent, true);

        $this->assertEquals($expectedContent, $responseContent);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testIncorrectRole()
    {
        $response = $this->jsonRequest(
            'POST',
            self::query(),
            [
                'login' => self::USER_LOGIN,
                'email' => self::USER_EMAIL,
                'password' => self::USER_PASSWORD,
                'role' => 'lol',
            ]
        );

        $expectedContent =
            [
                'error' => [
                    'messages' => [ "Роль не может принимать значение \"lol\"" ],
                    'code' => 1,
                ],
            ];

        $responseContent = $response->getContent();
        $responseContent = json_decode($responseContent, true);

        $this->assertEquals($expectedContent, $responseContent);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    private static function query(): string
    {
        return '/sign-up';
    }
}
