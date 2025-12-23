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
        Schema::table('ads', function (Blueprint $table) {
            // Guitar-specific fields
            $table->string('brand')->nullable()->after('title');
            $table->string('model')->nullable()->after('brand');
            $table->string('year')->nullable()->after('model');
            $table->enum('condition', ['New','Like New','Good','Fair','For Parts'])->default('Good')->after('year');
            $table->string('location')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['brand','model','year','condition','location']);
        });
    }
};
