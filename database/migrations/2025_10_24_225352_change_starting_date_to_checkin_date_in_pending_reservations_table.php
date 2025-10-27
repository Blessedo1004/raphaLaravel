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
        Schema::table('pending_reservations', function (Blueprint $table) {
            $table->renameColumn('starting_date', 'checkin_date');
            $table->renameColumn('ending_date', 'checkout_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pending_reservations', function (Blueprint $table) {
            //
        });
    }
};
