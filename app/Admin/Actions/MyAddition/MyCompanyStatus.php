<?php

namespace App\Admin\Actions\MyAddition;

use App\CompanyStatus;
use App\CompanyBasicInfo;
use App\GroupCategory;
use App\ContractRecord;
use Encore\Admin\Actions\RowAction;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class MyCompanyStatus extends RowAction
{
    public $name = '更改合約狀態';

    public function handle(Model $model, Request $request)
    {
        $CompanyStatus = new CompanyStatus();
        $CompanyStatus->cid = $request->get('cid');
        $CompanyStatus->status = $request->get('status');
        $CompanyStatus->date_time = $request->get('date_timestamp');
        $CompanyStatus->note = $request->get('note');
        $CompanyStatus->save();

        if ($request->get('start_time') != NULL || $request->get('end_time') != NULL) {
            $ContractRecord = new ContractRecord();
            $ContractRecord->cid = $request->get('cid');
            $ContractRecord->start_time = $request->get('start_time');
            $ContractRecord->end_time = $request->get('end_time');
            $ContractRecord->note = $request->get('note');
            $ContractRecord->save();
        }
        
        return $this->response()->success('添加成功')->refresh();
    }

    public function form(Model $model)
    {
        $this->text('cid', '公司ID')->value($model->cid);
        $this->select('status', '異動狀態')->options([
            'stationed' => '進駐',
            'extend' => '展延',
            'graduate' => '畢業',
            'leave' => '離駐'
        ]);
        $this->date('date_timestamp','時間')->rules('required');
        $this->date('start_time','合約開始時間');
        $this->date('end_time','合約結束時間');
        $this->textarea('note', '異動原因');
    }

}