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
        $OtherMemo->cid = $model->OtherMemoAction()->id;
        $OtherMemo->note = $request->get('note');

        return $this->response()->success('添加成功')->refresh();
    }

    public function form()
    {
        $this->textarea('note', '添加歷史紀錄')->rules('required');
    }

}