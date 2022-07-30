<?php
/**
 * Name：申請/取得政府補助資源
 * Purpose：可添加對應廠商的申請/取得政府補助資源
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGovGrantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gov_grant', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cid')->comment('廠商ID');
            $table->string('gov_grant_name')->comment('政府補助資源名稱');
            $table->string('plan_name')->comment('計畫名稱');
            $table->datetime('application_time')->comment('申請日期');
            $table->string('application_status')->default('no')->comment('申請狀態');
            $table->datetime('grant_time')->nullable()->comment('核定補助時間');
            $table->integer('grant_price')->default(0)->comment('核定補助金額');
            $table->text('note')->nullable()->comment('輔導內容');
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
        Schema::dropIfExists('gov_grant');
    }
}
