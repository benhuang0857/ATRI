<?php

namespace App\Admin\Actions\MyAddition;

use App\AdditionInvest;
use App\CompanyBasicInfo;
use App\GroupCategory;
use Encore\Admin\Actions\RowAction;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class MyAdditionInvest extends RowAction
{
    public $name = '投增資金額';

    public function handle(Model $model, Request $request)
    {
        $AdditionInvest = new AdditionInvest();
        $AdditionInvest->cid = $request->get('cid');
        $AdditionInvest->type = $request->get('type');
        $AdditionInvest->price = $request->get('price');
        $AdditionInvest->reason = $request->get('reason');
        $AdditionInvest->document = $request->post('document');
        $AdditionInvest->date_time = $request->get('date_time');
        $AdditionInvest->note = $request->get('note');
        $AdditionInvest->save();

        return $this->response()->success('添加成功')->refresh();
    }

    public function form(Model $model)
    {
        $this->text('cid', '公司ID')->value($model->cid);
        $this->select('type', '投資/增資')->options([
            'invest'      => '投資', 
            'increase'    => '增資'
        ])->rules('required');
        $this->text('price', '金額')->rules('required');
        $this->textarea('reason', '用途')->rules('required');
        $this->file('document', '佐證文件');
        $this->date('date_time','時間')->rules('required');
        $this->textarea('note', '輔導內容');
    }

}