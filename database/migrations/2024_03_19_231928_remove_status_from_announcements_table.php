<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('announcements', function (Blueprint $table) {
            // If you ever need to rollback, you can re-add the column here
            // For example:
            // $table->string('status')->nullable();
        });
    }
};
