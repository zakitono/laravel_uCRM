<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\Subtotal;

class Order extends Model
{
    protected static function booted()
    {
        static::addGlobalScope(new Subtotal);
    }
}
