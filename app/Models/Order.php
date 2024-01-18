<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Product;


class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'orderItem',
        'product_id',
        'quantity',
        'orderType',
        'date',
        'time',
        'description'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $latestOrder = static::latest()->first();

            if ($latestOrder) {
                $latestOrderNumber = (int) substr($latestOrder->order_number, 3);
                $nextOrderNumber = 'ORD' . str_pad($latestOrderNumber + 1, 3, '0', STR_PAD_LEFT);
                $order->order_number = $nextOrderNumber;
            } else {
                $order->order_number = 'ORD001';
            }
        });
    }

     /**
     * Define the many-to-many relationship with products.
     *
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'products_orders', 'order_id', 'product_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }


}
