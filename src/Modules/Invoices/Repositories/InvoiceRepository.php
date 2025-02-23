<?php

namespace Modules\Invoices\Repositories;

use App\Models\Invoice;
use App\Models\InvoiceProductLine;

class InvoiceRepository
{
    public function create(array $data): Invoice
    {
        return Invoice::create($data);
    }

    public function attachProductLines(Invoice $invoice, array $productLineData)
    {
        return $invoice->productLine()->insert($productLineData);
    }

    public function update(Invoice $invoice, array $data) : bool
    {
        return $invoice->update($data);
    }

    public function find(string $id): ?Invoice
    {
        return Invoice::find($id);
    }

    public function findWithProductLines(string $id) : ?Invoice
    {
        return Invoice::with('productLine')->find($id);
    }
}
