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
        Schema::table('activities', function (Blueprint $table) {
            $table->datetime('approval_date')->nullable();
            $table->unsignedBigInteger('approval_by_id')->nullable();
            $table->foreign('approval_by_id', 'approval_by_fk_9603983')->references('id')->on('users');
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
