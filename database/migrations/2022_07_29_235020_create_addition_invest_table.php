<?php
/**
* Name：投增資額明細表
* Purpose：可添加投增資額明細表，廠商與投增資額明細表為OneToMany
*/

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionInvestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addition_invest', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cid');
            $table->string('type')->default('invest')->comment('投資(invest)或是增資(increase)');
            $table->integer('price')->default(0)->comment('金額');
            $table->text('reason')->nullable()->comment('用途');
            $table->datetime('date_time')->comment('日期');
            $table->string('document')->nullable()->comment('佐證文件');
            $table->text('note')->nullable()->comment('輔導內容');

            /**
             * 讓使用者先選擇投資或是增資
             * 再來才是輸入這筆資料的用途、文件、輔導說明...等
             * 這樣較為合理，故先將下方的結構註銷
             */
            // $table->integer('invest_price')->default(0)->comment('投資金額');
            // $table->datetime('invest_time')->comment('投資日期');
            // $table->text('invest_reason')->nullable()->comment('投資用途');
            // $table->string('invest_document')->nullable()->comment('投資佐證文件');
            // $table->integer('increase_price')->default(0)->comment('增資金額');
            // $table->datetime('increase_time')->comment('增資日期');
            // $table->text('increase_reason')->nullable()->comment('增資用途');
            // $table->string('increase_document')->nullable()->comment('增資佐證文件');
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
        Schema::dropIfExists('addition_invest');
    }
}
