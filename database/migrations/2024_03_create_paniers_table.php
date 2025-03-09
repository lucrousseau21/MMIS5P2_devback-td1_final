<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('paniers', function (Blueprint $table) { 
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            // $table->foreignId('product_id')->constrained()->onDelete('cascade');
            // $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paniers');
    }
}; 