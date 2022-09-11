<?php

namespace App\Admin\Actions\MyAddition;

use App\AdditionRevenue;
use App\CompanyBasicInfo;
use App\GroupCategory;
use Encore\Admin\Actions\RowAction;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class MyAdditionRevenue extends RowAction
{
    public $name = '營業額異動';

    public function handle(Model $model, Request $request)
    {
        $AdditionRevenue = new AdditionRevenue();
        $AdditionRevenue->cid = $request->get('cid');
        $AdditionRevenue->price = $request->get('price');
        $AdditionRevenue->date_time = $request->get('date_time');
        $AdditionRevenue->note = $request->get('note');
        $AdditionRevenue->save();

        return $this->response()->success('添加成功')->refresh();
    }

    public function form(Model $model)
    {
        $this->text('cid', '公司ID')->value($model->cid);
        $this->text('price', '營業額')->rules('required');
        $this->date('date_time','時間')->rules('required');
        $this->textarea('note', '日期');
    }

}