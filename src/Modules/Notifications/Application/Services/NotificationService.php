<?php

declare(strict_types=1);

namespace Modules\Notifications\Application\Services;

use App\Models\Invoice;
use Illuminate\Contracts\Events\Dispatcher;
use Modules\Invoices\Domain\Enums\StatusEnum;
use Modules\Invoices\Repositories\InvoiceRepository;
use Modules\Notifications\Api\Events\ResourceDeliveredEvent;
use Ramsey\Uuid\Uuid;

use Modules\Notifications\Application\Facades\NotificationFacade;
use Modules\Notifications\Api\Dtos\NotifyData;
use Modules\Notifications\Infrastructure\Drivers\DummyDriver;

/**
 * @OA\Info(title="Invoice Handler API", version="0.1", description="Invoice Swagger API")
 */
final readonly class NotificationService
{
    public function __construct(
        private Dispatcher $dispatcher,
        private DummyDriver $driverInterface,
        private InvoiceRepository $invoiceRepository
    ) {}

    public function delivered(string $reference): void
    {
        $this->dispatcher->dispatch(new ResourceDeliveredEvent(
            resourceId: Uuid::fromString($reference),
        ));
    }

    public function sendNotification(Invoice $invoice) : string
    {
        if($invoice->status !== StatusEnum::Draft->value) {
            return "Can't send notification for the current Invoice status: {$invoice->status}";
        }

        if(empty($invoice->productLine)) {
            return "Can't send notification for Invoice with no product lines";
        }

        // Prepare and send notification for the invoice
        $emailData = new NotifyData(
            resourceId: Uuid::fromString($invoice->id),
            toEmail: $invoice->customer_email,
            subject: 'Your Invoice Delivery Status',
            message: 'The invoice ' . $invoice->id . ' has been sent to you'
        );

        $notificationFacade = new NotificationFacade($this->driverInterface);
        $notificationFacade->notify($emailData);
        $this->invoiceRepository->update($invoice, ['status' => StatusEnum::Sending->value]);
        $this->delivered($invoice->id);
        event(new ResourceDeliveredEvent(Uuid::fromString($invoice->id))); // trigger event

        return "Notification has been sent for Invoice {$invoice->id}";
    }
}
