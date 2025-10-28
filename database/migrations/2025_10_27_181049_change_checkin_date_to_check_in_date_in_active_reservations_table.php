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
        Schema::table('active_reservations', function (Blueprint $table) {
            $table->renameColumn('checkin_date', 'check_in_date');
            $table->renameColumn('checkout_date', 'check_out_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('active_reservations', function (Blueprint $table) {
            //
        });
    }
};
