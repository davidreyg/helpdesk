<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Requirement;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;


    protected function getStats(): array
    {
        return [
            Stat::make(__('Employee'), Employee::count())
                ->description('32k increase')
                ->color('success')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make(__('Company'), Company::count())
                ->description('32k increase')
                ->color('success')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make(__('Requirement'), Requirement::count())
                ->description('32k increase')
                ->color('success')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
        ];
    }
}
