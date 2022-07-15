<?php

namespace App\Admin\Actions\CompanyBasicInfo;

use Illuminate\Http\Request;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use App\OtherMemo;

class OtherMemoAction extends RowAction
{
    public $name = '添加歷史紀錄';

    public function handle(Model $model, Request $request)
    {
        $OtherMemo = new OtherMemo();
        $OtherMemo->cid = $request->get('cid');
        $OtherMemo->note = $request->get('note');
        $OtherMemo->save();

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
        $this->textarea('note', '添加歷史紀錄')->rules('required');
    }

}