<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Item extends Model
{
    use HasFactory;

    protected $fillable =  [
        'item_id','quantity'
    ];


    public function category(): BelongsTo{
        return $this->belongsTo(ItemCategory::class);
    }

    public function supply(): HasMany{
        return $this->hasMany(Supply::class);
    }
}
