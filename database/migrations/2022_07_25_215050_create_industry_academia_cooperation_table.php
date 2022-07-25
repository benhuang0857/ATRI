<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndustryAcademiaCooperationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industry_academia_cooperation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cid');
            $table->string('project_name');
            $table->string('project_category');
            $table->integer('price')->default(0);
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->string('document');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('industry_academia_cooperation');
    }
}
