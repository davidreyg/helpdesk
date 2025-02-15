<?php

namespace App\Providers;

use Closure;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\ServiceProvider;
use Str;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        TextInput::macro('money', function (string|Closure|null $currency = null): static {
            $this->extraAttributes(['wire:key' => Str::random()])
                ->prefix(static function (TextInput $component) use ($currency) {
                    $currency = $component->evaluate($currency);

                    return currency($currency)->getPrefix();
                })
                ->suffix(static function (TextInput $component) use ($currency) {
                    $currency = $component->evaluate($currency);

                    return currency($currency)->getSuffix();
                })
                ->mask(static function (TextInput $component) use ($currency) {
                    $currency = $component->evaluate($currency);

                    return moneyMask($currency);
                });

            return $this;
        });
    }
}
