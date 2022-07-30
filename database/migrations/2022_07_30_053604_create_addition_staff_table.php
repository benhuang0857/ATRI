<?php
/**
* Name：就業人數
* Purpose：可添就業人數異動，廠商與就業人數異動為OneToMany
*/

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addition_staff', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cid');
            $table->integer('staff')->default(0)->comment('員工人數');
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
        Schema::dropIfExists('addition_staff');
    }
}
