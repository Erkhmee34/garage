<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            // Хэрвээ багана байхгүй бол нэмнэ, байвал алгасна
            if (!Schema::hasColumn('cars', 'customer_id')) {
                $table->foreignId('customer_id')
                      ->after('year')
                      ->nullable()
                      ->constrained('customers')
                      ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
        });
    }
};