<?php
/**
* Name：進駐異動
* Purpose：可添加進駐異動，廠商與進駐異動為OneToMany
*/

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cid');
            $table->string('status')->default('checkin')->comment('進駐狀態：進駐(stationed)/展延(extend)/畢業(graduate)/離駐(leave)');
            $table->text('note')->nullable()->comment('異動原因');
            $table->datetime('date_time')->comment('異動日期');
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
        Schema::dropIfExists('company_status');
    }
}
