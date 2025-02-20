<?php

declare(strict_types=1);

namespace Modules\Notifications\Application\Services;

use Illuminate\Contracts\Events\Dispatcher;
use Modules\Notifications\Api\Events\ResourceDeliveredEvent;
use Ramsey\Uuid\Uuid;

use Modules\Invoices\Models\Invoice;
use Modules\Invoices\Models\InvoiceProductLine;

/**
 * @OA\Info(title="Invoice Handler API", version="0.1", description="Invoice Swagger API")
 */
final readonly class NotificationService
{
    public function __construct(
        private Dispatcher $dispatcher,
    ) {}

    public function delivered(string $reference): void
    {
        $this->dispatcher->dispatch(new ResourceDeliveredEvent(
            resourceId: Uuid::fromString($reference),
        ));
    }
}
