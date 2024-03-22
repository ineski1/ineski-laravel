<?php

namespace App\Filament\Resources\SupplyResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SupplyResource;
use Carbon\Carbon;
use Filament\Resources\Pages\ListRecords\Tab;

class ListSupplies extends ListRecords
{
    protected static string $resource = SupplyResource::class;

    public function getTabs(): array
    {
        return [
            'month' => Tab::make('This Month')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereMonth('updated_at',Carbon::now()->month)),
            'all' => Tab::make('all')
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
