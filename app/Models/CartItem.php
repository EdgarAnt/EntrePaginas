<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'content_id',
        'quantity', // otros campos que sean asignables en masa
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
