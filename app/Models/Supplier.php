<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
       'name',
       'companyName',
       'mobile',
       'email'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($supplier) {
            $latestOrder = static::latest()->first();

            if ($latestSupplier) {
                $latestSupplierNumber = (int) substr($latestSupplier->supplier_number, 3);
                $nextSupplierNumber = 'SUP' . str_pad($latestSupplierNumber + 1, 3, '0', STR_PAD_LEFT);
                $supplier->supplier_number = $nextSupplierNumber;
            } else {
                $supplier->supplier_number = 'SUP001';
            }
        });
    }
}
