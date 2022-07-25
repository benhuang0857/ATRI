<?php

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
            $table->string('cid');
            $table->string('tech_transfer_name');
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
        Schema::dropIfExists('tech_transfer');
    }
}
