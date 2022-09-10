<?php

namespace App\Admin\Controllers;

use App\AdditionRevenue;
use App\CompanyBasicInfo;
use App\GroupCategory;
use Encore\Admin\Controllers\AdminController;
use Illuminate\Database\Eloquent\Collection;
Use Encore\Admin\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AdditionRevenueController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '營業額異動';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AdditionRevenue());

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->filter(function($filter){

            $_option = array();
            $GroupOptions = GroupCategory::all();
            foreach ($GroupOptions as $item) {
                $_option[$item->slug] = $item->name;
            }

            $filter->disableIdFilter();
            $filter->equal('group_category', '進駐單位')->select($_option);
            // $filter->equal('real_or_virtula', '進駐方式')->select([
            //     'real' => '實質進駐',
            //     'virtual' => '虛擬進駐'
            // ]);
            $filter->like('company_name', '自然人/組織/公司名稱');
            // $filter->like('identity_code', '身分證/統一編號');
            // $filter->where(function ($query) {
            //     $query->where('contact_name', 'like', "%{$this->input}%")
            //         ->orWhere('owner_name', 'like', "%{$this->input}%");
            // }, '聯絡人/負責人姓名');
            // $filter->where(function ($query) {
            //     $query->where('contact_email', 'like', "%{$this->input}%")
            //         ->orWhere('owner_email', 'like', "%{$this->input}%");
            // }, '聯絡人/負責人Email');
            // $filter->where(function ($query) {
            //     $query->where('contact_phone', 'like', "%{$this->input}%")
            //         ->orWhere('owner_phone', 'like', "%{$this->input}%");
            // }, '聯絡人/負責人電話');

            $filter->between('date_time', '時間')->datetime();
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
        $grid->column('CompanyBasicInfo.company_name', '自然人/組織/公司名稱');
        $grid->column('price', __('營業額'))->totalRow();
        $grid->column('date_time', __('日期'))->display(function($date_time){
            $start_time = date("Y", strtotime($date_time));
            $start_year = $start_time - 1911;
            return $start_year.date("-m-d", strtotime($date_time));
        });
        $grid->column('note', __('註記'));

        $grid->tools(function ($tools) {
            $tools->append('<a href="" target="_blank" id="advexcel" class="btn btn-sm btn-info" ><i class="fa fa-download"></i>彙總匯出</a>');
        });

        Admin::script('
            var target = "/excel/addition-revenue";
            $("#advexcel").click(function(){
                var date_time_start = $("#date_time_start").val();
                var date_time_end = $("#date_time_end").val();

                if(date_time_start == "" || date_time_end == "")
                {
                    $("#advexcel").attr("href", "/excel/addition-revenue");
                }
                else
                {
                    $("#advexcel").attr("href", "/excel/addition-revenue?start_time="+date_time_start+"&end_time="+date_time_end+"")
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
        $show = new Show(AdditionRevenue::findOrFail($id));

        $show->field('id', __('Id'));
        // $form->field('group_category');
        $show->field('cid', __('Cid'));
        $show->field('price', __('Price'));
        $show->field('date_time', __('Date time'));
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
        $form = new Form(new AdditionRevenue());
        $_companies = CompanyBasicInfo::all();

        $_companiesArr = array();
        foreach($_companies as $item)
        {
            $_companiesArr[$item->cid] = $item->company_name;
        }
        
        $form->hidden('group_category');
        $form->select('cid', '自然人/組織/公司名稱')->options($_companiesArr);
        $form->number('price', __('營業額'))->default(0);
        $form->datetime('date_time', __('日期'))->default(date('Y-m-d'));
        $form->textarea('note', __('註記'));

        $form->saving(function (Form $form) {
            $_company = CompanyBasicInfo::where('cid', $form->cid)->first();
            $form->group_category = $_company->group_category;
        });

        return $form;
    }
}
