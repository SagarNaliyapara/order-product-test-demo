<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    protected $guarded = ['id'];
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_items');
    }
}
