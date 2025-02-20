<?php

declare(strict_types=1);

namespace Modules\Notifications\Presentation\Http;

use Illuminate\Http\JsonResponse;
use Modules\Invoices\Application\Services\InvoiceService;
use Modules\Notifications\Application\Services\NotificationService;
use Symfony\Component\HttpFoundation\Response;

// DTOs
use Modules\Notifications\Api\Dtos\NotifyData;
use Modules\Notifications\Application\Facades\NotificationFacade;

/**
 * @OA\Info(title="Notification Handler Controller", version="0.1", description="Invoice Swagger API")
 */
/**
  *  @OA\Tag(
  *     name="Notifications",
  *     description="Notification Management Endpoints"
  *  )
*/
final readonly class NotificationController
{
    public function __construct(
        private NotificationService $notificationService,
        private InvoiceService $invoiceService
    ) {}


    public function hook(string $action, string $reference): JsonResponse
    {
        match ($action) {
            'delivered' => $this->notificationService->delivered(reference: $reference),
            default => null,
        };

        return new JsonResponse(data: null, status: Response::HTTP_OK);
    }

    
    /**
    * @OA\Post(
    *     path="/api/notifications/send",
    *     summary="Send Invoice",
    *     tags={"Notifications"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="multipart/form-data",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="id",
    *                     type="string",
    *                     description="Invoice ID",
    *                     example="1234",
    *                     default="1234"
    *                 )
    *             )
    *         )
    *     ),
    *     @OA\Response(response="201", description="Invoice has been sent successfully"),
    *     @OA\Response(response="400", description="Sending error"),
    *     @OA\Response(response="422", description="Validation errors")
    * )
    */
    public function send(string $id): JsonResponse
    {
        $invoice = $this->invoiceService->getInvoiceData($id);

        $emailData = new NotifyData(
            resourceId: $invoice->id,
            toEmail: $invoice->customer_email,
            subject: 'Your Invoice Delivery Status',
            message: 'The invoice ' . $invoice->id . ' has been sent to you'
        );

        // We can either make the method static or call it this way
        app(NotificationFacade::class)->notify($emailData);
        return new JsonResponse(data: "test");
    }
}
