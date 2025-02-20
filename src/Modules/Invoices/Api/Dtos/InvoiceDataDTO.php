<?php

namespace Modules\Invoices\Api\Dtos;

class InvoiceDataDTO
{
    public function __construct(
        public readonly string $customerName,
        public readonly string $customerEmail,
        public readonly string $status
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['customer_name'],
            $data['customer_email'],
            $data['status']
        );
    }
}