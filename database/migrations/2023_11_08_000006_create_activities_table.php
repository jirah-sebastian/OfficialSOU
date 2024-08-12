<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('sub_title')->nullable();
            $table->longText('content')->nullable();
            $table->datetime('event_date')->nullable();
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('is_published')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
