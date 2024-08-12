<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSoRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::table('so_registrations', function (Blueprint $table) {
            $table->unsignedBigInteger('so_list_id')->nullable();
            $table->foreign('so_list_id', 'so_list_fk_9158944')->references('id')->on('so_lists');
            $table->unsignedBigInteger('title_id')->nullable();
            $table->foreign('title_id', 'title_fk_9181959')->references('id')->on('titles');
        });
    }
}
