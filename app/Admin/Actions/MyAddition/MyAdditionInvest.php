<?php

namespace App\Admin\Actions\MyAddition;

use App\AdditionInvest;
use Encore\Admin\Actions\RowAction;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MyAdditionInvest extends RowAction
{
    public $name = '投增資金額';

    public function handle(Model $model, Request $request)
    {
        // 創建新增投資資料
        $additionInvest = new AdditionInvest();
        $additionInvest->cid = $request->get('cid');
        $additionInvest->type = $request->get('type');
        $additionInvest->price = $request->get('price');
        $additionInvest->reason = $request->get('reason');
        $additionInvest->document = $request->file('document') ? $request->file('document')->store('documents') : null;
        $additionInvest->date_time = $request->get('date_time');
        $additionInvest->note = $request->get('note');

        // 處理日期分割並儲存至額外欄位
        $dateTime = $request->get('date_time');
        if ($dateTime) {
            $date = Carbon::parse($dateTime);
            $additionInvest->tmp_year = $date->format('Y');
            $additionInvest->tmp_date = $date->format('n-d H:i:s');
        }

        $additionInvest->save();

        return $this->response()->success('添加成功')->refresh();
    }

    public function form(Model $model)
    {
        $currentYear = Carbon::now()->year;

        // 動態生成選項
        $this->text('cid', '公司ID')->value($model->cid)->readonly();
        $this->select('type', '投資/增資')->options([
            'invest'   => '投資', 
            'increase' => '增資'
        ])->rules('required');
        $this->text('price', '金額')->rules('required|numeric');
        $this->textarea('reason', '用途')->rules('required');
        $this->file('document', '佐證文件')->rules('required');
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
        $this->textarea('note', '備註');
    }
}