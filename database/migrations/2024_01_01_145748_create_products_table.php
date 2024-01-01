<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_number')->uniqid();
            $table->string('name');
            $table->string('code')->uniqid();
            $table->string('price');
            $table->string('count');
            $table->string('manufacture_date');
            $table->string('expire_date');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('supplier_id'); // Change to match 'supplier_number' data type
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
