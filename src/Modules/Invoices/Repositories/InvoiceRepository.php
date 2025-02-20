<?php

namespace Modules\Invoices\Repositories;

use Modules\Invoices\Models\Invoice;

class InvoiceRepository
{
    public function create(array $data): Invoice
    {
        return Invoice::create($data);
    }

    public function update(Invoice $invoice, array $data): bool
    {
        return $invoice->update($data);
    }

    public function find(int $id): ?Invoice
    {
        return Invoice::find($id);
    }
}
