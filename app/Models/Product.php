<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('store', function (Builder $builder) {
            if (Auth::user()->store_id) {
                $builder->where('store_id', Auth::user()->store_id);
            }
        });
    }
}
