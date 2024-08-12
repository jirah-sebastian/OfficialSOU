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
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender')->nullable();
            $table->string('course')->nullable();
            $table->string('year')->nullable();
            $table->string('religion')->nullable();
            $table->string('nationality')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('present_address')->nullable();
            $table->string('home_address')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_contact_no')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mothers_contact_no')->nullable();
            $table->string('source_of_financial_support')->nullable();
            $table->string('talent_skills')->nullable();
            $table->date('date_filed')->nullable();

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
