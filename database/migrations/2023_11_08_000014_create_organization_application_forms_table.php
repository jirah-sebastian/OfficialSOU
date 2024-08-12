<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationApplicationFormsTable extends Migration
{
    public function up()
    {
        Schema::create('organization_application_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
