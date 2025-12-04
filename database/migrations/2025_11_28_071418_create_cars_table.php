<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('cars', function (Blueprint $table) {
        $table->id();
        $table->string('plate_number')->unique();
        $table->string('brand');
        $table->string('model');
        $table->string('image')->nullable();
        $table->integer('year');
        $table->unsignedBigInteger('customer_id')->nullable(); // ← ТҮР ИЙМ
        $table->timestamps();
        $table->softDeletes();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};