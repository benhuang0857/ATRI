<?php
/**
* Name：政府補助資源維護
* Purpose：可添政府補助資源維護
*/

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGovSupportProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gov_support_project', function (Blueprint $table) {
            $table->increments('id');
            $table->string('price')->comment('補助金額');
            $table->string('status')->default('no')->comment('狀態');
            $table->string('plan_title')->comment('計畫名稱');
            $table->string('organizer')->comment('主辦單位');
            $table->string('organizer_contact_name')->comment('主辦聯絡人');
            $table->string('organizer_phone')->comment('主辦電話');
            $table->string('organizer_email')->comment('主辦Email');
            $table->string('organizer_fax')->nullable()->comment('主辦傳真');
            $table->string('coorganizer')->comment('執行單位');
            $table->string('coorganizer_contact_name')->comment('執行單位聯絡人');
            $table->string('coorganizer_phone')->comment('執行單位電話');
            $table->string('coorganizer_email')->comment('執行單位Email');
            $table->string('coorganizer_fax')->nullable()->comment('執行單位傳真');
            $table->text('qualification_description')->nullable()->comment('申請資格/申請對象');
            $table->text('plan_description')->nullable()->comment('計畫標的說明');
            $table->text('industry_description')->nullable()->comment('產業屬性說明');
            $table->text('review_point_description')->nullable()->comment('審查種點說明');
            $table->text('amount_description')->nullable()->comment('獎勵方式');
            $table->datetime('date_start_time')->comment('申請開始日期');
            $table->datetime('date_end_time')->comment('申請結束日期');
            $table->string('web')->nullable()->comment('網站連結');
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
        Schema::dropIfExists('gov_support_project');
    }
}
