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
        //
        Schema::table('so_registrations', function (Blueprint $table) {
            $table->datetime('date_approval')->nullable();
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->foreign('approved_by_id', 'approved_by_fk_9603985')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
