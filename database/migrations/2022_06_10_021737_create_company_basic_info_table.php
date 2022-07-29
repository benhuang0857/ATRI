<?php
/**
 * Name： 基本資料表暨輔導歷程
 * Purpose：輸入廠商資料
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyBasicInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_basic_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cid');
            $table->string('group_category')->comment('進駐單位:農試所/林試所/水試所/畜試所/農科院');
            // $table->string('status')->default('stationed')->comment('進駐狀態：進駐(stationed)/展延(extend)/畢業(graduate)/離駐(leave)');
            $table->string('real_or_virtula')->default('real')->comment('進駐方式：實質(real)/虛擬(virtual)');
            $table->string('company_name')->comment('公司名稱');
            $table->string('identity_code')->comment('身分證字號/統一編號');
            $table->datetime('established_time')->comment('成立時間');
            $table->string('contact_name')->comment('聯絡人姓名');
            $table->string('contact_email')->comment('聯絡人Email');
            $table->string('contact_phone')->comment('聯絡人電話');
            $table->string('owner_name')->comment('負責人姓名');
            $table->string('owner_email')->comment('負責人Email');
            $table->string('owner_phone')->comment('負責人電話');
            $table->string('project_name')->comment('營運專案名稱');
            $table->string('service')->comment('服務項目');
            $table->datetime('contract_start_time')->comment('合約開始時間');
            $table->datetime('contract_end_time')->comment('合約結束時間');
            $table->integer('capital')->comment('資本額');
            $table->integer('revenue')->comment('年營業額');
            $table->integer('staff')->comment('員工人數');
            
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
        Schema::dropIfExists('company_basic_info');
    }
}
