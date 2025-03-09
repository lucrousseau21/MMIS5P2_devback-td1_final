<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['panier_id', 'product_id', 'quantity'];

    public function panier()
    {
        return $this->belongsTo(Panier::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
