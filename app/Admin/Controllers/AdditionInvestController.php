<?php

namespace App\Admin\Controllers;

use App\AdditionInvest;
use App\CompanyBasicInfo;
use App\GroupCategory;
use Encore\Admin\Controllers\AdminController;
use Illuminate\Database\Eloquent\Collection;
Use Encore\Admin\Admin;
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
            $filter->in('CompanyBasicInfo.group_category', '進駐單位')->multipleSelect($_option);
            $filter->equal('CompanyBasicInfo.real_or_virtula', '進駐方式')->select([
                'real' => '實質進駐',
                'virtual' => '虛擬進駐'
            ]);
            $filter->like('CompanyBasicInfo.company_name', '自然人/組織/公司名稱');
            $filter->like('CompanyBasicInfo.identity_code', '身分證/統一編號');
            $filter->where(function ($query) {
                $query->where('CompanyBasicInfo.contact_name', 'like', "%{$this->input}%")
                    ->orWhere('CompanyBasicInfo.owner_name', 'like', "%{$this->input}%");
            }, '聯絡人/負責人姓名');
            $filter->where(function ($query) {
                $query->where('CompanyBasicInfo.contact_email', 'like', "%{$this->input}%")
                    ->orWhere('CompanyBasicInfo.owner_email', 'like', "%{$this->input}%");
            }, '聯絡人/負責人Email');
            $filter->where(function ($query) {
                $query->where('CompanyBasicInfo.contact_phone', 'like', "%{$this->input}%")
                    ->orWhere('CompanyBasicInfo.owner_phone', 'like', "%{$this->input}%");
            }, '聯絡人/負責人電話');

            $filter->between('date_time', '時間')->datetime();
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

        $grid->tools(function ($tools) {
            $tools->append('<a href="" target="_blank" id="advexcel" class="btn btn-sm btn-info" ><i class="fa fa-download"></i>彙總匯出</a>');
        });

        Admin::script('
            var target = "/excel/addition-invest";
            $("#advexcel").click(function(){
                var date_time_start = $("#date_time_start").val();
                var date_time_end = $("#date_time_end").val();

                if(date_time_start == "" || date_time_end == "")
                {
                    $("#advexcel").attr("href", "/excel/addition-invest");
                }
                else
                {
                    $("#advexcel").attr("href", "/excel/addition-invest?start_time="+date_time_start+"&end_time="+date_time_end+"")
                }
            })
        ');

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
        $form->datetime('date_time', __('日期'))->default(date('Y-m-d'));
        $form->file('document', __('佐證文件'));
        $form->textarea('note', __('輔導內容'));

        return $form;
    }
}
