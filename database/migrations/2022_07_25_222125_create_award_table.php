<?php
/**
 * Name：申請/取得獎項
 * Purpose：可添加對應廠商的申請/取得獎項
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAwardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('award', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cid')->comment('廠商ID');
            $table->string('award_name')->comment('獎項名稱');
            $table->datetime('application_time')->comment('申請日期');
            $table->string('application_status')->default('no')->comment('申請狀態');
            $table->string('award_status')->default('no')->comment('獲獎/未獲獎');
            $table->datetime('award_time')->comment('獲獎日期');
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
        Schema::dropIfExists('award');
    }
}
