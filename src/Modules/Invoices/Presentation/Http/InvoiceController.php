<?php

declare(strict_types=1);

namespace Modules\Invoices\Presentation\Http;

use Illuminate\Http\JsonResponse;

// Services
use Modules\Invoices\Application\Services\InvoiceService;

// Requests
use Modules\Invoices\Presentation\Http\Requests\CreateInvoiceRequest;

// DTOs
use Modules\Invoices\Api\Dtos\InvoiceDataDTO;

/**
 * @OA\Info(title="Invoice Handler Controller", version="0.1", description="Invoice Swagger API")
 */
/**
  *  @OA\Tag(
  *     name="Invoices",
  *     description="Invoice Management Endpoints"
  *  )
*/
final readonly class InvoiceController
{
    public function __construct(
        private InvoiceService $invoiceService,
    ) {}

    /**
    * @OA\Post(
    *     path="/api/invoices/store",
    *     summary="Create a new invoice",
    *     tags={"Invoices"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="status",
    *                     type="string",
    *                     description="Status of the Invoice",
    *                     example="draft",
    *                     default="draft",
    *                     enum={"draft", "sending", "sent-to-client"}
    *                 ),
    *                 @OA\Property(
    *                     property="customer_name",
    *                     type="string",
    *                     description="Customer Name",
    *                     example="Customer Name"
    *                 ),
    *                 @OA\Property(
    *                     property="customer_email",
    *                     type="email",
    *                     description="Customer Email",
    *                     example="Customer Email"
    *                 ),
    *                 @OA\Property(
    *                     property="product_lines",
    *                     type="string",
    *                     description="JSON data of product lines",
    *                     example="{}"
    *                 )
    *             )
    *         )
    *     ),
    *     @OA\Response(response="201", description="Invoice created successfully"),
    *     @OA\Response(response="422", description="Validation errors")
    * )
    */
    public function store(CreateInvoiceRequest $request): JsonResponse
    {
        try {
            $newInvoice = $this->invoiceService->createNewInvoice($request->validated());
            return new JsonResponse(data: ['message' => $newInvoice], status: 201);
        } catch (\Exception $e) {
            return new JsonResponse(data: ['message' => $e->getMessage(), 'test' => $request->validated(), 'test2' => $request->all()], status: 422);
        }
    }

    /**
    * @OA\Get(
    *     path="/api/invoices/{id}",
    *     summary="View Invoice Information",
    *     tags={"Invoices"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="Invoice ID",
    *         required=true
    *     ),
    *     @OA\Response(response="201", description="Invoice Information"),
    *     @OA\Response(response="400", description="Invoice was not found")
    * )
    */
    public function show(string $id): JsonResponse
    {
        $invoice = $this->invoiceService->getInvoiceWithProductLines($id);

        if(!$invoice) {
            return new JsonResponse(data: ['message' => 'Invoice could not be found'], status: 400);
        }

        return new JsonResponse(data: $invoice, status: 201);
    }
}
