<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    App\Providers\MacroServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    \SocialiteProviders\Manager\ServiceProvider::class, // add
];
