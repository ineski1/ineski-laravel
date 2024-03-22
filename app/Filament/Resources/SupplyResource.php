<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Supply;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Model;
use pxlrbt\FilamentExcel\Columns\Column;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use App\Filament\Resources\SupplyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use App\Filament\Resources\SupplyResource\RelationManagers;

class SupplyResource extends Resource
{
    protected static ?string $model = Supply::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Supply';
    protected static ?int $navigationSort = 0;
    protected static ?string $navigationLabel = 'Supply Log';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('item_id')
                    ->relationship('item', 'name')
                    ->required(),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('remarks')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(ViewAction::class)
            ->recordUrl(
                fn (Model $record): string  =>'items/'.$record->item_id
            )
            ->poll('3')
            ->defaultSort('updated_at','desc')
            ->columns([
                Tables\Columns\TextColumn::make('item.name')
                    ->numeric()
                    ->sortable(),
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
                    )
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('remarks')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),
                Tables\Actions\EditAction::make()->iconButton(),

            ])
            ->headerActions([
                ExportAction::make()->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withColumns([
                            Column::make('item.name')->heading('Item Name'),
                            Column::make('quantity'),
                            Column::make('remarks'),
                            Column::make('updated_at')
                        ])
                        ->withFilename('Supplies '.date('Y-m-d'))
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSupplies::route('/'),
            'create' => Pages\CreateSupply::route('/create'),
            'edit' => Pages\EditSupply::route('/{record}/edit'),
        ];
    }
}
