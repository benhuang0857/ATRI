<?php

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
            $table->string('group_category')->comment('進駐單位:農試所/林試所/水試所/畜試所/農科院');
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
            $table->datetime('contract_time')->comment('合約時間');
            $table->string('capital_checkin')->comment('資本額');
            $table->string('capital_checkout')->nullable()->comment('資本額(畢業)');
            $table->string('revenue_checkin')->comment('年營業額');
            $table->string('revenue_checkout')->nullable()->comment('年營業額(畢業)');
            $table->string('staff_checkin')->comment('員工人數');
            $table->string('staff_checkout')->nullable()->comment('員工人數(畢業)');
            
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
