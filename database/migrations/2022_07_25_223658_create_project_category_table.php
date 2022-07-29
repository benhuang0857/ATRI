<?php
/**
* Name：產學合作及委託中的計畫類別
* Purpose：可添加產學合作及委託中的計畫類別暫不寫死
*/
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('產學計畫類別(產學/委託)');
            $table->string('slug');
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
        Schema::dropIfExists('project_category');
    }
}
