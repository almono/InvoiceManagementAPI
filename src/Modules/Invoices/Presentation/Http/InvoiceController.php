<?php

declare(strict_types=1);

namespace Modules\Invoices\Presentation\Http;

use Illuminate\Http\JsonResponse;
use Modules\Invoices\Application\Services\InvoiceService;
use Symfony\Component\HttpFoundation\Response;

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
    *                     property="Invoice Status",
    *                     type="string",
    *                     description="Status of the Invoice",
    *                     example="draft",
    *                     default="draft",
    *                     enum={"draft", "sending", "sent-to-client"}
    *                 ),
    *                 @OA\Property(
    *                     property="Customer Name",
    *                     type="string",
    *                     description="Customer Name",
    *                     example="Customer Name"
    *                 ),
    *                 @OA\Property(
    *                     property="Customer Email",
    *                     type="email",
    *                     description="Customer Email",
    *                     example="Customer Email"
    *                 ),
    *                 @OA\Property(
    *                     property="Invoice Product Lines",
    *                     type="string",
    *                     description="JSON data of product lines",
    *                     example="{}"
    *                 ),
    *                 @OA\Property(
    *                     property="Total Price",
    *                     type="double",
    *                     description="Sum of all prices",
    *                     example="0.00"
    *                 )
    *             )
    *         )
    *     ),
    *     @OA\Response(response="201", description="Invoice created successfully"),
    *     @OA\Response(response="422", description="Validation errors")
    * )
    */
    public function store(): JsonResponse
    {
        return new JsonResponse(data: "test");
    }

    /**
    * @OA\Get(
    *     path="/api/invoices/{id}",
    *     summary="View Invoice Information",
    *     tags={"Invoices"},
    *     @OA\Parameter(
    *         name="id",
    *         in="query",
    *         description="Invoice ID",
    *         required=true,
    *         @OA\Schema(type="string")
    *     ),
    *     @OA\Response(response="201", description="Invoice Information"),
    *     @OA\Response(response="400", description="Invoice was not found")
    * )
    */
    public function show(): JsonResponse
    {
        return new JsonResponse(data: "test");
    }

    /**
    * @OA\Post(
    *     path="/api/invoice/send",
    *     summary="Send Invoice",
    *     tags={"Invoices"},
    *     @OA\Parameter(
    *         name="id",
    *         in="path",
    *         description="Invoice ID",
    *         required=true,
    *         @OA\Schema(type="string")
    *     ),
    *     @OA\Response(response="201", description="Invoice has been sent successfully"),
    *     @OA\Response(response="400", description="Sending error"),
    *     @OA\Response(response="422", description="Validation errors")
    * )
    */
    public function send(): JsonResponse
    {
        return new JsonResponse(data: "test");
    }
}
