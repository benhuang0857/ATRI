<?php
/**
 * Name：技術移轉
 * Purpose：可添加對應廠商的技術移轉
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tech_transfer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cid')->comment('廠商ID');
            $table->string('tech_transfer_name')->comment('技術移轉名稱');
            $table->integer('price')->default(0)->comment('金額(元單位)');
            $table->datetime('start_time')->comment('開始時間');
            $table->datetime('end_time')->comment('結束時間');
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
        Schema::dropIfExists('tech_transfer');
    }
}
