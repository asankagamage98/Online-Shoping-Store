<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'mobile',
        'address',
        'email'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            $latestCustomer = static::latest()->first();

            if ($latestCustomer) {
                $latestCustomerNumber = (int) substr($latestCustomer->customer_number, 3);
                $nextCustomerNumber = 'CUS' . str_pad($latestCustomerNumber + 1, 3, '0', STR_PAD_LEFT);
                $customer->customer_number =$nextCustomerNumber;
            } else {
                $customer->customer_number = 'CUS001';
            }
        });
    }
}

