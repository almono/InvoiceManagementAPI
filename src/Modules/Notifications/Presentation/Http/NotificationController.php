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

    public function send()
    {

    }
}
