<?php

namespace App\Models;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\Permission\Traits\HasRoles;

class Supplier extends Model
{
    use HasFactory, HasRoles;
}
