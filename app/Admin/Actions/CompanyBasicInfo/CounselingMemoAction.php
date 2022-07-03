<?php

namespace App\Admin\Actions\CompanyBasicInfo;

use Illuminate\Http\Request;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use App\CounselingMemo;

class CounselingMemoAction extends RowAction
{
    public $name = '輔導(服務)紀錄';

    public function handle(Model $model, Request $request)
    {
        $CounselingMemo = new CounselingMemo();
        $CounselingMemo->cid = $request->get('cid');
        $CounselingMemo->name = $request->get('name');
        $CounselingMemo->note = $request->get('note');
        $CounselingMemo->save();

        return $this->response()->success('添加成功')->refresh();
    }

    public function form(Model $model)
    {
        $this->hidden('cid', '公司ID')->value($model->id);
        $this->text('name', '輔導歷程名稱')->rules('required');
        $this->textarea('note', '輔導歷程記錄')->rules('required');
    }

}