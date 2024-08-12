<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeRemarksColumnToRemarkInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('remark')->nullable()->after('remarks');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('remarks');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('remarks')->nullable()->after('remark');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('remark');
        });
    }
}
