<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoListUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('so_list_user', function (Blueprint $table) {
            $table->unsignedBigInteger('so_list_id');
            $table->foreign('so_list_id', 'so_list_id_fk_9182188')->references('id')->on('so_lists')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_9182188')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
