<?php

namespace App\Admin\Controllers;

use App\AdditionInvest;
use App\CompanyBasicInfo;
use App\GroupCategory;
use Encore\Admin\Controllers\AdminController;
use Illuminate\Database\Eloquent\Collection;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AdditionInvestController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '投增資額明細表';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AdditionInvest());
        $grid->filter(function($filter){

            $_option = array();
            $GroupOptions = GroupCategory::all();
            foreach ($GroupOptions as $item) {
                $_option[$item->slug] = $item->name;
            }

            $filter->disableIdFilter();
            $filter->equal('group_category', '進駐單位')->select($_option);
            $filter->equal('real_or_virtula', '進駐方式')->select([
                'real' => '實質進駐',
                'virtual' => '虛擬進駐'
            ]);
            $filter->like('company_name', '自然人/組織/公司名稱');
            $filter->like('identity_code', '身分證/統一編號');
            $filter->where(function ($query) {
                $query->where('contact_name', 'like', "%{$this->input}%")
                    ->orWhere('owner_name', 'like', "%{$this->input}%");
            }, '聯絡人/負責人姓名');
            $filter->where(function ($query) {
                $query->where('contact_email', 'like', "%{$this->input}%")
                    ->orWhere('owner_email', 'like', "%{$this->input}%");
            }, '聯絡人/負責人Email');
            $filter->where(function ($query) {
                $query->where('contact_phone', 'like', "%{$this->input}%")
                    ->orWhere('owner_phone', 'like', "%{$this->input}%");
            }, '聯絡人/負責人電話');
        });
        
        $grid->export(function ($export) {
            $export->except(['tmp']);
        });

        $grid->model()->collection(function (Collection $collection) {
            foreach($collection as $index => $item) {
                $item->tmp = $index + 1;
            }
            return $collection;
        });
        
        $grid->column('tmp', '編號');

        $grid->column('CompanyBasicInfo.group_category', '進駐單位')->using([
            'farmer'        => '農試所',
            'forestry'      => '林試所',
            'water'         => '水試所',
            'livestock'     => '畜試所',
            'agricultural'  => '農科院',
        ], '未知');
        $grid->column('cid', '自然人/組織/公司名稱')->display(function($cid){
            return CompanyBasicInfo::where('cid', $cid)->first()->company_name;
        });
        $grid->column('type', __('投資/增資'))->using([
            'invest'      => '投資', 
            'increase'    => '增資'
        ]);
        $grid->column('price', __('金額'));
        $grid->column('reason', __('用途'));
        $grid->column('date_time', __('日期'))->display(function($date_time){
            return date("Y-m-d", strtotime($date_time));  
        });
        $grid->column('document', __('佐證文件'));
        $grid->column('note', __('輔導內容'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(AdditionInvest::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('cid', __('Cid'));
        $show->field('type', __('Type'));
        $show->field('price', __('Price'));
        $show->field('reason', __('Reason'));
        $show->field('date_time', __('Date time'));
        $show->field('document', __('Document'));
        $show->field('note', __('Note'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new AdditionInvest());
        $_companies = CompanyBasicInfo::all();

        $_companiesArr = array();
        foreach($_companies as $item)
        {
            $_companiesArr[$item->cid] = $item->company_name;
        }
        $form->select('cid', '自然人/組織/公司名稱')->options($_companiesArr);
        $form->select('type', __('投資/增資'))->options([
            'invest'      => '投資', 
            'increase'    => '增資'
        ]);
        $form->number('price', __('金額'));
        $form->textarea('reason', __('用途'));
        $form->datetime('date_time', __('日期'))->default(date('Y-m-d H:i:s'));
        $form->file('document', __('佐證文件'));
        $form->textarea('note', __('輔導內容'));

        return $form;
    }
}
