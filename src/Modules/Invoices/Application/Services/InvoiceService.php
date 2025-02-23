<?php

declare(strict_types=1);

namespace Modules\Invoices\Application\Services;

use Modules\Invoices\Repositories\InvoiceRepository;

use App\Models\Invoice;
use App\Models\InvoiceProductLine;
use Illuminate\Support\Facades\DB;
use Modules\Invoices\Api\Dtos\InvoiceDataDTO;
use Illuminate\Support\Str;

final readonly class InvoiceService
{
    public function __construct(
        private InvoiceRepository $invoiceRepository
    ) {}

    public function createNewInvoice(array $data) : ?Invoice
    {
        return DB::transaction(function () use ($data) {
            $invoice = $this->invoiceRepository->create($data);
            $productLines = json_decode($data['product_lines'], true);

            if (!empty($productLines)) {
                foreach($productLines as $productLine)
                {
                    $productLine['invoice_id'] = $invoice->id;
                    $productLine['id'] = Str::uuid();
                    $this->invoiceRepository->attachProductLines($invoice, $productLine);
                }
            }

            return $invoice;
        });
    }


    public function getInvoiceData(string $id) : ?Invoice
    {
        return $this->invoiceRepository->find($id);
    }

    public function getInvoiceWithProductLines(string $id) : ?Invoice
    {
        $invoiceData = $this->invoiceRepository->findWithProductLines($id);
        
        if(!is_null($invoiceData)) {
            $invoiceData['total_price'] = 0;

            if(!empty($invoiceData->productLine)) {
                foreach($invoiceData->productLine as $product) {
                    $invoiceData['total_price'] = $invoiceData['total_price'] + ( $product['price'] * $product['quantity'] );
                }
            }
        }

        return $invoiceData;
    }
}
