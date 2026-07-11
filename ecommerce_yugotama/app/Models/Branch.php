<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'code',
        'address',
        'city',
        'is_active',
    ];

    public function productPrices()
    {
        return $this->hasMany(ProductPrice::class);
    }
}
