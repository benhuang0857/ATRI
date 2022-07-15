<?php

namespace App\Admin\Actions\CompanyBasicInfo;

use Illuminate\Http\Request;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use App\CapitalMemo;

class CapitalMemoAction extends RowAction
{
    public $name = '資本額異動紀錄';

    public function handle(Model $model, Request $request)
    {
        $CapitalMemo = new CapitalMemo();
        $CapitalMemo->cid = $request->get('cid');
        $CapitalMemo->create_month = $request->get('create_month');
        $CapitalMemo->staff = $request->get('capital');
        $CapitalMemo->note = $request->get('note');
        $CapitalMemo->save();

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
        $this->text('capital', '資本額')->rules('required');
        $this->textarea('note', '備註')->rules('required');
    }

}