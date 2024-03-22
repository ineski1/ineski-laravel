<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Item;
use Filament\Tables;
use App\Models\Supply;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Resources\ItemResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Filament\Resources\ItemResource\Widgets\ItemOverview;
use App\Filament\Resources\ItemResource\RelationManagers\SupplyRelationManager;
use App\Tables\Columns\ItemAvailabilityColumn;

class ItemResource extends Resource
{

    protected static ?string $model = Item::class;

    protected static ?string $recordTitleAttribute = 'name';
    public static function getGlobalSearchResultUrl(Model $record): ?string
    {
        return ItemResource::getUrl('view', ['record' => $record]);
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Supply';
    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->hiddenOn('view')
                            ->autocapitalize('words')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required(),
                        TextInput::make('unit')
                            ->required(),
                        Forms\Components\TextInput::make('min_quantity')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('max_quantity')
                            ->required()
                            ->numeric()
                            ->step(100),
                    ])->columns(4)

            ]);
    }


    public static function infolist(Infolist $infolist): Infolist
    {

        return $infolist
            ->schema([
                // Section::make('Item Details')
                //     ->schema([
                //         Grid::make('3')
                //             ->schema([
                //                 TextEntry::make('name'),
                //                 TextEntry::make('min_quantity')
                //                     ->badge()
                //                     // ->color(fn (int $state): int => match ($state) {
                //                     //     'draft' => 'gray',
                //                     //     'reviewing' => 'warning',
                //                     //     'published' => 'success',
                //                     //     'rejected' => 'danger',
                //                     // }),
                //             ])
                //     ]),
                ]);
    }

    public static function table(Table $table): Table
    {


        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->size('Large')
                    ->weight('Bold'),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable()
                    ->badge(),
                    //->url('item-categories'),
                TextColumn::make('supply_sum_quantity')
                    ->label('Available Stock')
                    ->sum('supply','quantity'),
                TextColumn::make('unit'),
                Tables\Columns\TextColumn::make('min_quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                ExportAction::make()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconButton(),
                Tables\Actions\EditAction::make()->iconButton(),
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
            SupplyRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'view' => Pages\ViewItem::route('/{record}'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
