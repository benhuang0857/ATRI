<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTmpColsToAdditionInvestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addition_invest', function (Blueprint $table) {
            $table->string('tmp_year')->nullable();
            $table->string('tmp_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addition_invest', function (Blueprint $table) {
            $table->dropColumn('tmp_year');
            $table->dropColumn('tmp_date');
        });
    }
}
