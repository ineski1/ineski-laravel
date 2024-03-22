<?php

namespace App\Filament\Resources\ItemResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use Filament\Resources\RelationManagers\RelationManager;

class SupplyRelationManager extends RelationManager
{
    protected static string $relationship = 'supply';
    public function isReadOnly(): bool
{
    return false;
}

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('item_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->poll('3s')
            ->recordTitleAttribute('item_id')
            ->columns([
                Tables\Columns\TextColumn::make('quantity')
                    ->badge()
                    ->color(function (string $state): string {
                        if(strpos($state, '-') !== false){
                            return 'danger';
                            }else{
                                return 'success';
                            }
                        }
                    ),
                Tables\Columns\TextColumn::make('remarks'),
                Tables\Columns\TextColumn::make('updated_at')->sortable('asc'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportAction::make()
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make()->iconButton(),
                // Tables\Actions\DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])->defaultSort('updated_at', 'desc');
    }
}
