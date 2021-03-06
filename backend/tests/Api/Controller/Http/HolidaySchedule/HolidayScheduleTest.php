<?php

declare(strict_types=1);

namespace App\Tests\Api\Controller\Http\HolidaySchedule;

use App\ScheduleCalculation\Entity\TeamEvent;
use App\ScheduleCalculation\Entity\Vacation;
use App\ScheduleCalculation\Entity\Worker;
use App\Tests\ControllerTestCase;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;

final class HolidayScheduleTest extends ControllerTestCase
{
    const FIRST_WORKER_ID = 'idWorker1';
    const FIRST_VACATION_ID = 'idVacation1';
    const SECOND_VACATION_ID = 'idVacation2';
    const FIRST_TEAM_EVENT_ID = 'idTeamEvent1';

    protected EntityManagerInterface $em;
    protected KernelBrowser $client;

    public function testSuccessful()
    {

        $firstWorker = new Worker(
            $id = self::FIRST_WORKER_ID,
            $startWork = DateTimeImmutable::createFromFormat('H:i:s', '08:00:00'),
            $endWork = DateTimeImmutable::createFromFormat('H:i:s', '17:00:00'),
            $startBreak = DateTimeImmutable::createFromFormat('H:i:s', '13:00:00'),
            $endBreak = DateTimeImmutable::createFromFormat('H:i:s', '14:00:00'),
            [self::FIRST_VACATION_ID]
        );

        $firstVacation = new Vacation(
            $id = self::FIRST_VACATION_ID,
            $workerId = self::FIRST_WORKER_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-02-01 00:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-02-14 23:59:59')
        );

        $firstTeamEvent = new TeamEvent(
            $id = self::FIRST_TEAM_EVENT_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-10 15:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-11 00:00:00')
        );

        $this->saveEntity($firstWorker);
        $this->saveEntity($firstVacation);
        $this->saveEntity($firstTeamEvent);

        $this->client->request(
            'GET',
            self::formUrl(self::FIRST_WORKER_ID, '20201011', '20201012')
        );

        $expectedResponseContent =
            [
                'holidaySchedule' => [
                    [
                        'day' => '2020-10-11',
                        'timeRanges' => [
                            [
                                'start' => '00:00',
                                'end' => '23:59'
                            ],
                        ],
                    ],
                    [
                        'day' => '2020-10-12',
                        'timeRanges' => [
                            [
                                'start' => '00:00',
                                'end' => '08:00'
                            ],
                            [
                                'start' => '13:00',
                                'end' => '14:00'
                            ],
                            [
                                'start' => '17:00',
                                'end' => '23:59'
                            ],
                        ],
                    ],
                ]
            ];

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        $expectedResponseContent = trim(json_encode($expectedResponseContent));

        $this->assertEquals($expectedResponseContent, $responseContent);

        $this->assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode()
        );
    }

    public function testWithEventPeriod()
    {

        $firstWorker = new Worker(
            $id = self::FIRST_WORKER_ID,
            $startWork = DateTimeImmutable::createFromFormat('H:i:s', '08:00:00'),
            $endWork = DateTimeImmutable::createFromFormat('H:i:s', '17:00:00'),
            $startBreak = DateTimeImmutable::createFromFormat('H:i:s', '13:00:00'),
            $endBreak = DateTimeImmutable::createFromFormat('H:i:s', '14:00:00'),
            [self::FIRST_VACATION_ID]
        );

        $firstVacation = new Vacation(
            $id = self::FIRST_VACATION_ID,
            $workerId = self::FIRST_WORKER_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-02-01 00:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-02-14 23:59:59')
        );

        $firstTeamEvent = new TeamEvent(
            $id = self::FIRST_TEAM_EVENT_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-13 15:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-14 00:00:00')
        );

        $this->saveEntity($firstWorker);
        $this->saveEntity($firstVacation);
        $this->saveEntity($firstTeamEvent);

        $this->client->request(
            'GET',
            self::formUrl(self::FIRST_WORKER_ID, '20200113', '20200114')
        );

        $expectedResponseContent =
            [
                'holidaySchedule' => [
                    [
                        'day' => '2020-01-13',
                        'timeRanges' => [
                            [
                                'start' => '00:00',
                                'end' => '08:00'
                            ],
                            [
                                'start' => '13:00',
                                'end' => '14:00'
                            ],
                            [
                                'start' => '15:00',
                                'end' => '23:59'
                            ],
                        ],
                    ],
                    [
                        'day' => '2020-01-14',
                        'timeRanges' => [
                            [
                                'start' => '00:00',
                                'end' => '08:00'
                            ],
                            [
                                'start' => '13:00',
                                'end' => '14:00'
                            ],
                            [
                                'start' => '17:00',
                                'end' => '23:59'
                            ],
                        ],
                    ],
                ]
            ];

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        $expectedResponseContent = trim(json_encode($expectedResponseContent));

        $this->assertEquals($expectedResponseContent, $responseContent);

        $this->assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode()
        );
    }

    public function testWithVacationPeriod()
    {

        $firstWorker = new Worker(
            $id = self::FIRST_WORKER_ID,
            $startWork = DateTimeImmutable::createFromFormat('H:i:s', '08:00:00'),
            $endWork = DateTimeImmutable::createFromFormat('H:i:s', '17:00:00'),
            $startBreak = DateTimeImmutable::createFromFormat('H:i:s', '13:00:00'),
            $endBreak = DateTimeImmutable::createFromFormat('H:i:s', '14:00:00'),
            [self::FIRST_VACATION_ID]
        );

        $firstVacation = new Vacation(
            $id = self::FIRST_VACATION_ID,
            $workerId = self::FIRST_WORKER_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-02-01 00:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-02-13 23:59:59')
        );

        $firstTeamEvent = new TeamEvent(
            $id = self::FIRST_TEAM_EVENT_ID,
            $start = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-13 15:00:00'),
            $end = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-14 00:00:00')
        );

        $this->saveEntity($firstWorker);
        $this->saveEntity($firstVacation);
        $this->saveEntity($firstTeamEvent);

        $this->client->request(
            'GET',
            self::formUrl(self::FIRST_WORKER_ID, '20200212', '20200214')
        );

        $expectedResponseContent =
            [
                'holidaySchedule' => [
                    [
                        'day' => '2020-02-12',
                        'timeRanges' => [
                            [
                                'start' => '00:00',
                                'end' => '23:59'
                            ],
                        ],
                    ],
                    [
                        'day' => '2020-02-13',
                        'timeRanges' => [
                            [
                                'start' => '00:00',
                                'end' => '23:59'
                            ],
                        ],
                    ],
                    [
                        'day' => '2020-02-14',
                        'timeRanges' => [
                            [
                                'start' => '00:00',
                                'end' => '08:00'
                            ],
                            [
                                'start' => '13:00',
                                'end' => '14:00'
                            ],
                            [
                                'start' => '17:00',
                                'end' => '23:59'
                            ],
                        ],
                    ],
                ]
            ];

        $response = $this->client->getResponse();
        $responseContent = $response->getContent();

        $expectedResponseContent = trim(json_encode($expectedResponseContent));

        $this->assertEquals($expectedResponseContent, $responseContent);

        $this->assertEquals(
            Response::HTTP_OK,
            $response->getStatusCode()
        );
    }

    private static function formUrl(
        string $workerId,
        string $startDate,
        string $endDate
    ): string {
        return '/worker-holiday-schedule?workerId=' . $workerId . '&startDate=' . $startDate . '&endDate=' . $endDate;
    }
}
