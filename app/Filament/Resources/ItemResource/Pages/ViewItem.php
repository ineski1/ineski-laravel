<?php

namespace App\Filament\Resources\ItemResource\Pages;

use App\Models\Item;
use Filament\Actions;
use App\Models\Supply;
use Filament\Actions\CreateAction;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use App\Filament\Resources\ItemResource;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;
use Symfony\Contracts\Service\Attribute\Required;
use App\Filament\Resources\ItemResource\Widgets\ItemOverview;

class ViewItem extends ViewRecord
{
    protected static string $resource = ItemResource::class;


    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make('add_stocks')
                ->modalHeading('Add Stock/s')
                ->modalSubmitActionLabel('Add')
                ->successNotificationTitle('Stock/s Added Successfully')
                ->label('Add Stock/s')
                ->color('primary')
                ->model(Supply::class)
                ->createAnother(false)
                ->form([
                    Hidden::make('item_id')->default($this->record->id),
                    TextInput::make('quantity')->label('Quantity')->required()->numeric(),
                ])
                ->mutateFormDataUsing(function (array $data): array {
                    $data['remarks'] = 'added by: '.Auth::user()->name;
                    return $data;
                }),
            CreateAction::make('release')
                ->label('Release')
                ->modalHeading('Release')
                ->modalSubmitActionLabel('Release')
                ->successNotificationTitle('Released Successfully')
                ->color('warning')
                ->model(Supply::class)
                ->createAnother(false)
                ->form([
                    Hidden::make('item_id')->default($this->record->id),
                    TextInput::make('quantity')->label('Quantity')->required()->numeric()->autofocus(),
                    TextInput::make('remarks')->label('issued to: ')->required()->autocapitalize(true),
                ])
                ->mutateFormDataUsing(function (array $data): array {
                    $data['quantity'] = -$data['quantity'];
                    $data['remarks'] = 'issued to: '.$data['remarks'];
                    return $data;
                }),
            Actions\EditAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array{
        return [
            ItemOverview::class
        ];
    }
}
