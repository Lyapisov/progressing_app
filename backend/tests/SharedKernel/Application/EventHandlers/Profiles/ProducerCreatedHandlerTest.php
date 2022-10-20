<?php

declare(strict_types=1);

namespace App\Tests\SharedKernel\Application\EventHandlers\Profiles;

use App\Profiles\Domain\Events\ProducerCreated;
use App\Profiles\Domain\Shared\Address;
use App\Profiles\Domain\Shared\Name;
use App\Profiles\Domain\Shared\PersonalData;
use App\Profiles\Domain\Shared\Phone;
use App\Tests\ControllerTestCase;
use App\Tests\Helpers\Traits\DIContainerTrait;
use App\Tests\Helpers\Traits\Profiles\ProfilesTrait;
use App\Tests\Helpers\Traits\Publications\PublicationsTrait;
use App\Util\EventDispatcher\EventDispatcher;
use App\Util\EventDispatcher\Infrastructure\Sync\SymfonyEventDispatcherAdapter;
use DateTimeImmutable;

final class ProducerCreatedHandlerTest extends ControllerTestCase
{
    use DIContainerTrait;
    use ProfilesTrait;
    use PublicationsTrait;

    public function testSuccessful(): void
    {
        $producer = $this->getProducerBuilder()
            ->withUserId($userId = '0cf9773e-869d-46d5-a771-1c5f08296c84')
            ->withPersonalData(
                new PersonalData(
                    new Name($name = 'first', $last = 'last', ''),
                    new Phone($number = '+79889474700'),
                    new Address($address = 'Azov'),
                    new DateTimeImmutable($birthday = '10-10-1995'),
                )
            )
            ->build();
        $this->saveEntity($producer);

        $this->getEventDispatcher()->dispatch([
            new ProducerCreated($producer->getId())
        ]);

        $author = $this->getAuthorRepository()->findById($producer->getUserId());
        $this->assertEquals($userId, $author->getId());
        $this->assertEquals($last . ' ' . $name, $author->getFullName());
        $this->assertTrue($author->getRole()->isProducer());
    }

    private function getEventDispatcher(): SymfonyEventDispatcherAdapter
    {
        return $this->getDependency(EventDispatcher::class);
    }
}
