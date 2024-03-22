<?php

namespace App\Filament\Resources;

use App\Models\Supplier;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Table;
use Miguilim\FilamentAutoPanel\AutoResource;
use Spatie\Permission\Traits\HasRoles;


class SupplierResource extends AutoResource
{

    use HasRoles;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $model = Supplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Supply';
    protected static ?int $navigationSort = 2;


    protected static array $enumDictionary = [];

    protected static array $visibleColumns = [];

    protected static array $searchableColumns = [];

    public static function getFilters(): array
    {
        return [
            //
        ];
    }

    public static function getActions(): array
    {
        return [
            //
        ];
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getHeaderWidgets(): array
    {
        return [
            'list' => [
                //
            ],
            'view' => [
                //
            ],
        ];
    }

    public static function getFooterWidgets(): array
    {
        return [
            'list' => [
                //
            ],
            'view' => [
                //
            ],
        ];
    }

    public static function getColumnsOverwrite(): array
    {
        return [
            'table' => [
                //
            ],
            'form' => [
                TextInput::make('name')->unique()->autocapitalize('words'),
                TextInput::make('created_at')->hidden(),
                TextInput::make('updated_at')->hidden(),
            ],
            'infolist' => [
                //
            ],
        ];
    }

    public static function getExtraPages(): array
    {
        return [
            //
        ];
    }
}
