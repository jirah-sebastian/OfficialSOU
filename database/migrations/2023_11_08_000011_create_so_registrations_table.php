<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::create('so_registrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->nullable();
            $table->string('membership_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
