<?php

declare(strict_types=1);

namespace Tests\Unit\Notification\Services;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Invoices\Repositories\InvoiceRepository;
use Modules\Notifications\Api\Events\ResourceDeliveredEvent;
use Modules\Notifications\Application\Services\NotificationService;
use Modules\Notifications\Infrastructure\Drivers\DummyDriver;
use PHPUnit\Framework\TestCase;

final class NotificationServiceTest extends TestCase
{
    use WithFaker;

    private Dispatcher $dispatcher;

    private NotificationService $notificationService;
    private DummyDriver $driverInterface;
    private InvoiceRepository $invoiceRepository;

    protected function setUp(): void
    {
        $this->setUpFaker();

        $this->dispatcher = $this->createMock(Dispatcher::class);
        $this->notificationService = new NotificationService($this->dispatcher, $this->driverInterface, $this->invoiceRepository);
    }

    public function testDelivered(): void
    {
        $this->dispatcher->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(ResourceDeliveredEvent::class));

        $this->notificationService->delivered($this->faker->uuid());
    }
}
