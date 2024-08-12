<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdviserFieldsToSoListsTable extends Migration
{
    public function up()
    {
        Schema::table('so_lists', function (Blueprint $table) {
            $table->string('adviser')->nullable();
            $table->string('adviserEmail')->nullable();
            $table->string('adviserCollege')->nullable();
            $table->integer('adviserYears')->nullable();
            $table->string('adviserField')->nullable();
        });
    }

    public function down()
    {
        Schema::table('so_lists', function (Blueprint $table) {
            $table->dropColumn('adviser');
            $table->dropColumn('adviserEmail');
            $table->dropColumn('adviserCollege');
            $table->dropColumn('adviserYears');
            $table->dropColumn('adviserField');
        });
    }
};
