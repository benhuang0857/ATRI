<?php

namespace App\Admin\Actions\MyAddition;

use App\AdditionRevenue;
use App\CompanyBasicInfo;
use App\GroupCategory;
use Encore\Admin\Actions\RowAction;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MyAdditionRevenue extends RowAction
{
    public $name = '營業額異動';

    public function handle(Model $model, Request $request)
    {
        $additionRevenue = new AdditionRevenue();
        $additionRevenue->cid = $request->get('cid');
        $additionRevenue->price = $request->get('price');
        $additionRevenue->date_time = $request->get('date_time');
        $additionRevenue->note = $request->get('note');

        // 處理日期分割並儲存至額外欄位
        $dateTime = $request->get('date_time');
        if ($dateTime) {
            $date = Carbon::parse($dateTime);
            $additionRevenue->tmp_year = $date->format('Y');
            $additionRevenue->tmp_date = $date->format('n-d H:i:s');
        }

        $additionRevenue->save();

        return $this->response()->success('添加成功')->refresh();
    }

    public function form(Model $model)
    {
        $currentYear = Carbon::now()->year;

        $this->text('cid', '公司ID')->value($model->cid);
        $this->text('price', '營業額')->rules('required');
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