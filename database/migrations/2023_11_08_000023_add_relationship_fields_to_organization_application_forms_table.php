<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOrganizationApplicationFormsTable extends Migration
{
    public function up()
    {
        Schema::table('organization_application_forms', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->foreign('organization_id', 'organization_fk_9182187')->references('id')->on('so_lists');
        });
    }
}
