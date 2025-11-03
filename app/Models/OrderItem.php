<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
    ];

    // Item pertence a um pedido
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Item pertence a um produto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Calcula o total deste item
    public function getTotalAttribute()
    {
        return $this->quantity * $this->unit_price;
    }
}