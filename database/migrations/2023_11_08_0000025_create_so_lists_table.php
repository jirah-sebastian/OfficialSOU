<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoListsTable extends Migration
{
    public function up()
    {
        Schema::create('so_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('so_name')->nullable();
            $table->string('overview')->nullable();
            $table->longText('information')->nullable();
            $table->date('expired_at')->nullable();
            $table->boolean('approved')->default(0)->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
