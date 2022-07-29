<?php
/**
 * Name：產學合作及委託
 * Purpose：可添加對應廠商的產學合作或是委託案件
 */

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
            $table->string('cid')->comment('廠商ID');
            $table->string('project_name')->comment('計畫名稱');
            $table->string('project_category')->comment('計畫類別');
            $table->integer('price')->default(0)->comment('金額(千元單位)');
            $table->datetime('start_time')->comment('開始時間');
            $table->datetime('end_time')->comment('結束時間');
            $table->string('document')->nullable()->comment('佐證文件');
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
