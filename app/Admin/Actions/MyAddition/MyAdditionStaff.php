<?php

namespace App\Admin\Actions\MyAddition;

use App\AdditionStaff;
use App\CompanyBasicInfo;
use App\GroupCategory;
use Encore\Admin\Actions\RowAction;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class MyAdditionStaff extends RowAction
{
    public $name = '就業人數';

    public function handle(Model $model, Request $request)
    {
        $AdditionStaff = new AdditionStaff();
        $AdditionStaff->cid = $request->get('cid');
        $AdditionStaff->staff = $request->get('staff');
        $AdditionStaff->date_time = $request->get('date_time');
        $AdditionStaff->note = $request->get('note');
        $AdditionStaff->save();

        return $this->response()->success('添加成功')->refresh();
    }

    public function form(Model $model)
    {
        $this->text('cid', '公司ID')->value($model->cid);
        $this->text('staff', '員工人數')->rules('required');
        $this->date('date_time','時間')->rules('required');
        $this->textarea('note', '日期');
    }

}