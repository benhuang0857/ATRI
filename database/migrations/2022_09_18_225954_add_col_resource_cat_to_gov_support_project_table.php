<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColResourceCatToGovSupportProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gov_support_project', function (Blueprint $table) {
            $table->string('resource_cat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gov_support_project', function (Blueprint $table) {
            $table->dropColumn('resource_cat');
        });
    }
}
