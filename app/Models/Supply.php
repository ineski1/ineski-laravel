<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Supply extends Model
{
    use HasFactory;


    public function item(): BelongsTo{
        return $this->belongsTo(Item::class);
    }
}
