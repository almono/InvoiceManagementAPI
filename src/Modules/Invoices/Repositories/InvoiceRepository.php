<?php

namespace Modules\Invoices\Repositories;

use App\Models\Invoice;
use Modules\Invoices\Api\Dtos\InvoiceDataDTO;

class InvoiceRepository
{
    public function create(array $data): Invoice
    {
        return Invoice::create($data);
    }

    public function update(Invoice $invoice, array $data) : bool
    {
        return $invoice->update($data);
    }

    public function find(string $id): ?Invoice
    {
        return Invoice::where($id);
    }

    public function findWithProductLines(string $id) : ?Invoice
    {
        return Invoice::with('productLine')->find($id);
    }
}
