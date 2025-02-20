<?php

declare(strict_types=1);

namespace Modules\Invoices\Application\Services;

use Modules\Repositories\Repositories\InvoiceRepository;

use Modules\Invoices\Models\Invoice;
use Modules\Invoices\Models\InvoiceProductLine;

final readonly class InvoiceService
{
    public function __construct(
        private InvoiceRepository $invoiceRepository
    ) {}

    public function createNewInvoice($data) : Invoice
    {
        return $this->invoiceRepository->create($data);
    }

    public function getInvoiceData($id)
    {
        return $this->invoiceRepository->find($id);
    }
}
