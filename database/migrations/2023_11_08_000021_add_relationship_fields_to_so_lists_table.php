<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSoListsTable extends Migration
{
    public function up()
    {
        Schema::table('so_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('so_category_id')->nullable();
            $table->foreign('so_category_id', 'so_category_fk_9158933')->references('id')->on('so_categories');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_9189897')->references('id')->on('users');
        });
    }
}
