<?php

declare(strict_types=1);

namespace Modules\Invoices\Application\Services;

use Modules\Invoices\Repositories\InvoiceRepository;

use App\Models\Invoice;
use Modules\Invoices\Api\Dtos\InvoiceDataDTO;

final readonly class InvoiceService
{
    public function __construct(
        private InvoiceRepository $invoiceRepository
    ) {}

    public function createNewInvoice(array $data) : Invoice
    {
        return $this->invoiceRepository->create($data);
    }

    public function getInvoiceData(string $id) : Invoice
    {
        return $this->invoiceRepository->find($id);
    }

    public function getInvoiceWithProductLines(string $id) : ?Invoice
    {
        return $this->invoiceRepository->findWithProductLines($id);
    }
}
