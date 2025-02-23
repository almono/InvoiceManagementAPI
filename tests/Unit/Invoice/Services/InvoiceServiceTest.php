<?php

declare(strict_types=1);

namespace Tests\Unit\Invoice\Services;

use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Invoices\Application\Services\InvoiceService;
use Modules\Invoices\Repositories\InvoiceRepository;
use PHPUnit\Framework\TestCase;

final class InvoiceServiceTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    private InvoiceService $notificationService;
    private InvoiceRepository $invoiceRepository;

    protected function setUp(): void
    {
        $this->setUpFaker();
    }

    // Create invoice with draft status and check if its created successfully
    public function testCreateNewInvoice()
    {
        $data = [
            'status' => 'draft',
            'customer_name' => 'Test customer',
            'customer_email' => 'test@test.test',
            'product_lines' => [
                ['product_name' => 'Product 1', 'quantity' => 10, 'unit_price' => 2.00],
                ['product_name' => 'Product 2', 'quantity' => 5, 'unit_price' => 10.00],
            ],
        ];

        $invoice = Invoice::create($data);
        $this->assertEquals('draft', $invoice->status);
    }

    // Test for invalid quantity and unit price values
    public function testCreateNewInvoiceInvalidIntegers()
    {
        $data = [
            'status' => 'draft',
            'customer_name' => 'Test customer',
            'customer_email' => 'test@test.test',
            'product_lines' => [
                ['product_name' => 'Product 1', 'quantity' => -10, 'unit_price' => 2.00],
                ['product_name' => 'Product 2', 'quantity' => 5, 'unit_price' => -10.00],
            ],
        ];

        // Expect validation exception due to invalid product line values
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        Invoice::create($data);
    }

    public function testGetInvalidInvoice()
    {
        $randomInvoiceId = $this->faker->uuid;
        $invoice = Invoice::find($randomInvoiceId);

        $this->assertNull($invoice);
    }
}
