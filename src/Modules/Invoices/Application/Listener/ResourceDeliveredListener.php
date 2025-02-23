<?php

namespace Modules\Invoices\Application\Listeners;

use Illuminate\Notifications\Events\NotificationSent;
use Modules\Invoices\Domain\Enums\StatusEnum;
use Modules\Invoices\Repositories\InvoiceRepository;

class ResourceDeliveredListener
{
    protected $event;

    public function __construct(private InvoiceRepository $invoiceRepository){}

    public function handle(NotificationSent $event)
    {
        $this->event = $event;
        $this->checkIfDummyNotificationDelivered();
    }

    /**
     * Check if the notification was delivered using the dummy mail driver.
     *
     * @return void
     */
    public function checkIfDummyNotificationDelivered()
    {
        // check if invoice exists and has proper status
        $invoice = $this->invoiceRepository->find($this->event->resourceId);

        if($invoice) {
            if($invoice->status == StatusEnum::Sending->value) {
                $this->invoiceRepository->update($invoice, ['status' => StatusEnum::SentToClient->value]);
            }
        }
    }
}
