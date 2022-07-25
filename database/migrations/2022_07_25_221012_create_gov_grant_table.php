<?php

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
            $table->string('cid');
            $table->string('gov_grant_name');
            $table->string('plan_name');
            $table->datetime('application_time');
            $table->string('application_status')->default('no');
            $table->datetime('grant_time');
            $table->integer('grant_price')->default(0);
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
        Schema::dropIfExists('gov_grant');
    }
}
