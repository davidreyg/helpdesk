<?php

namespace App\Providers;

use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Event;
use Illuminate\Support\ServiceProvider;
use LLoadout\Microsoftgraph\EventListeners\MicrosoftGraphCallbackReceived;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch): void {
            $switch
                ->locales(['es', 'en']); // also accepts a closure
        });
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event): void {
            $event->extendSocialite('microsoft', \SocialiteProviders\Microsoft\Provider::class);
        });

        Event::listen(function (MicrosoftGraphCallbackReceived $event): void {
            session()->put('microsoftgraph-access-data', $event->accessData);
        });
    }
}
