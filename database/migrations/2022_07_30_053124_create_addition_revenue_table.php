<?php
/**
* Name：營業額異動
* Purpose：可添營業額異動，廠商與營業額異動為OneToMany
*/

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionRevenueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addition_revenue', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cid');
            $table->integer('price')->default(0)->comment('金額');
            $table->datetime('date_time')->comment('日期');
            $table->text('note')->nullable()->comment('輔導內容');
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
        Schema::dropIfExists('addition_revenue');
    }
}
