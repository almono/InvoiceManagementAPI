<?php

declare(strict_types=1);

namespace Modules\Notifications\Infrastructure\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Modules\Invoices\Application\Listeners\ResourceDeliveredListener;
use Modules\Notifications\Api\Events\ResourceDeliveredEvent;
use Modules\Notifications\Api\NotificationFacadeInterface;
use Modules\Notifications\Application\Facades\NotificationFacade;
use Modules\Notifications\Infrastructure\Drivers\DummyDriver;

final class NotificationServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->app->scoped(NotificationFacadeInterface::class, NotificationFacade::class);

        $this->app->singleton(NotificationFacade::class, static fn ($app) => new NotificationFacade(
            driver: $app->make(DummyDriver::class),
        ));
    }

    /** @return array<class-string> */
    public function provides(): array
    {
        return [
            NotificationFacadeInterface::class,
        ];
    }

    public function boot()
    {
        // register event listener
        Event::listen(
            ResourceDeliveredEvent::class,
            [ResourceDeliveredListener::class, 'handle']
        );
    }
}
