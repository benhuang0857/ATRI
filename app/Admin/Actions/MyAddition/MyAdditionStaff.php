<?php

namespace App\Admin\Actions\MyAddition;

use App\AdditionStaff;
use App\CompanyBasicInfo;
use App\GroupCategory;
use Encore\Admin\Actions\RowAction;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MyAdditionStaff extends RowAction
{
    public $name = '就業人數';

    public function handle(Model $model, Request $request)
    {
        $additionStaff = new AdditionStaff();
        $additionStaff->cid = $request->get('cid');
        $additionStaff->staff = $request->get('staff');
        $additionStaff->date_time = $request->get('date_time');
        $additionStaff->note = $request->get('note');

        // 處理日期分割並儲存至額外欄位
        $dateTime = $request->get('date_time');
        if ($dateTime) {
            $date = Carbon::parse($dateTime);
            $additionStaff->tmp_year = $date->format('Y');
            $additionStaff->tmp_date = $date->format('n-d H:i:s');
        }

        $additionStaff->save();

        return $this->response()->success('添加成功')->refresh();
    }

    public function form(Model $model)
    {
        $currentYear = Carbon::now()->year;

        $this->text('cid', '公司ID')->value($model->cid);
        $this->text('staff', '員工人數')->rules('required');
        $this->select('date_time', '時間')
            ->options([
                "$currentYear-01-01 00:00:00" => '1月~2月',
                "$currentYear-03-01 00:00:00" => '3月~4月',
                "$currentYear-05-01 00:00:00" => '5月~6月',
                "$currentYear-07-01 00:00:00" => '7月~8月',
                "$currentYear-09-01 00:00:00" => '9月~10月',
                "$currentYear-11-01 00:00:00" => '11月~12月',
            ])
            ->rules('required')
            ->default("$currentYear-01-01 00:00:00"); // 預設值
        $this->textarea('note', '日期');
    }

}