<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Order;


class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
            'name',
            'code',
            'price',
            'count',
            'manufacture_date',
            'expire_date',
            'description',
            'supplier_id'
        ];

        protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $latestProduct = static::latest()->first();

            if ( $latestProduct) {
                $latestProductNumber = (int) substr( $latestProduct->product_number, 3);
                $nextProductNumber = 'PRO' . str_pad( $latestProductNumber + 1, 3, '0', STR_PAD_LEFT);
                $product->product_number = $nextProductNumber;
            } else {
                $product->product_number = 'PRO001';
            }
        });
    }

    /**
     * Define the many-to-many relationship with orders.
     *
     * @return BelongsToMany
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'products_orders', 'product_id', 'order_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }


}
