<?php
/**
* Name：政府補助資源維護
* Purpose：可添政府補助資源維護
*/

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGovSupportProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gov_support_project', function (Blueprint $table) {
            $table->increments('id');
            $table->string('region')->comment('地區');
            $table->string('type')->comment('性質');
            $table->string('price')->comment('資金額度');
            $table->string('contact_name')->comment('聯絡人');
            $table->string('phone')->comment('電話');
            $table->string('email')->comment('Email');
            $table->string('fax')->nullable()->comment('傳真');
            $table->string('web')->nullable()->comment('網站連結');
            $table->datetime('date_start_time')->comment('申請開始日期');
            $table->datetime('date_end_time')->comment('申請結束日期');
            $table->string('status')->default('no')->comment('狀態');
            $table->string('plan_title')->comment('計畫名稱');
            $table->string('plan_group')->comment('執行單位');
            $table->text('qualification_description')->nullable()->comment('申請資格說明');
            $table->text('plan_description')->nullable()->comment('計畫標的說明');
            $table->text('industry_description')->nullable()->comment('產業屬性說明');
            $table->text('review_point_description')->nullable()->comment('審查種點說明');
            $table->text('amount_description')->nullable()->comment('研擬額度說明');
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
        Schema::dropIfExists('gov_support_project');
    }
}
