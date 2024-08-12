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
            $table->string('type_of_activity')->nullable();
            $table->string('sustainable_development_goal')->nullable();
            $table->boolean('gad_funded')->default(0)->nullable();
            
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
