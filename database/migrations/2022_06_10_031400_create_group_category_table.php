<?php
/**
 * Name：進駐單位
 * Purpose：目前規劃農試所/水試所/畜試所/農科院，暫不考慮寫死，保留未來添加所院的彈性
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('所院名稱');
            $table->string('slug')->comment('對應的Slug');
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
        Schema::dropIfExists('group_category');
    }
}
