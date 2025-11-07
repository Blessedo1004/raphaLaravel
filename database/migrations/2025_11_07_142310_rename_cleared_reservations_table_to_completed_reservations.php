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
        Schema::table('cleared_reservations', function (Blueprint $table) {
        });

        Schema::rename('cleared_reservations' , 'completed_reservations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('completed_reservations', function (Blueprint $table) {
        });
        Schema::rename('completed_reservations' , 'cleared_reservations');
    }
};
