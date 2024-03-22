<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\SupplyResource;
use Filament\Widgets\TableWidget as BaseWidget;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class LatestSupplies extends BaseWidget
{
    use HasWidgetShield;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                SupplyResource::getEloquentQuery()
            )
            ->defaultPaginationPageOption(5)
            ->defaultSort('updated_at','desc')
            ->recordUrl(
                fn (Model $record): string  =>'items/'.$record->item_id
            )
            ->columns([
                Tables\Columns\TextColumn::make('item.name')
                    ->numeric(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->badge()
                    ->color(function (string $state): string {
                        if(strpos($state, '-') !== false){
                            return 'danger';
                            }else{
                                return 'success';
                            }
                        }
                    ),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('remarks'),
            ]);
    }
}
