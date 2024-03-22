<?php

namespace App\Filament\Resources\ItemResource\Widgets;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Supply;
use Illuminate\Database\Eloquent\Model;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ItemOverview extends BaseWidget
{

    public ?Item $record;

    protected function getStats(): array
    {
        $available = Supply::where('item_id',$this->record->id)->sum('quantity');
        $outgoingmonth = Supply::where('item_id',$this->record->id)
            ->where('quantity','like','%-%')
            ->whereYear('updated_at', Carbon::now()->year)
            ->whereMonth('updated_at', Carbon::now()->month)
            ->sum('quantity');
        $outgoingyear = Supply::where('item_id',$this->record->id)
            ->where('quantity','like','%-%')
            ->whereYear('updated_at', Carbon::now()->year)
            ->sum('quantity');
        $min = Item::where('id',$this->record->id)->sum('min_quantity');
        if($min < $available){
            $status = 'Normal';
            $color = 'success';
            $icon = 'heroicon-m-arrow-trending-up';
        }else{
            $color = 'danger';
            $status = 'Low on Stock';
            $icon = 'heroicon-m-arrow-trending-down';
        }

        return [
            Stat::make('Available Quantity',number_format($available) )
                ->description($status)
                ->descriptionIcon($icon)
                ->color($color),
            Stat::make('Released this Month', $outgoingmonth)
                ->color('danger')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->description(date('F')),
            Stat::make('Released this Year', $outgoingyear)
                ->description(date('Y')),

        ];
    }
}
