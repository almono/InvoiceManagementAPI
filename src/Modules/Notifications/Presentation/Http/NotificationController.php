<?php

declare(strict_types=1);

namespace Modules\Notifications\Presentation\Http;

use Illuminate\Http\JsonResponse;
use Modules\Notifications\Application\Services\NotificationService;
use Symfony\Component\HttpFoundation\Response;

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
    *     path="/api/invoices/send",
    *     summary="Send Invoice",
    *     tags={"Notifications"},
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
