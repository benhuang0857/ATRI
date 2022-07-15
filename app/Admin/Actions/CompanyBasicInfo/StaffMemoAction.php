<?php

namespace App\Admin\Actions\CompanyBasicInfo;

use Illuminate\Http\Request;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use App\StaffMemo;

class StaffMemoAction extends RowAction
{
    public $name = '員工異動紀錄';

    public function handle(Model $model, Request $request)
    {
        $StaffMemo = new StaffMemo();
        $StaffMemo->cid = $request->get('cid');
        $StaffMemo->create_month = $request->get('create_month');
        $StaffMemo->staff = $request->get('staff');
        $StaffMemo->note = $request->get('note');
        $StaffMemo->save();

        return $this->response()->success('添加成功')->refresh();
    }

    public function form(Model $model)
    {
        $this->hidden('cid', '公司ID')->value($model->id);
        $this->select('create_month','時間')->options([
            '11月-12月',
            '01月-02月',
            '03月-04月',
            '05月-06月',
            '07月-08月',
            '09月-10月',
        ]);
        $this->text('staff', '員工數')->rules('required');
        $this->textarea('note', '備註')->rules('required');
    }

}