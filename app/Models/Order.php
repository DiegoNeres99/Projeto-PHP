<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'customer_id',
        'order_date',
        'status', // Pendente, Concluído, etc.
    ];

    // Relacionamento: Pedido pertence a um Cliente
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relacionamento: Pedido tem muitos itens
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Calcula o valor total do pedido
    public function getTotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });
    }
}