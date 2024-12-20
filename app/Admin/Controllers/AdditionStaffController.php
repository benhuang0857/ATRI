<?php

namespace App\Admin\Controllers;

use App\AdditionStaff;
use App\AdditionRevenue;
use App\CompanyBasicInfo;
use App\CompanyStatus;
use App\GroupCategory;
use Encore\Admin\Controllers\AdminController;
use Illuminate\Database\Eloquent\Collection;
Use Encore\Admin\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AdditionStaffController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '就業人數查詢及維護';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AdditionStaff());
        $grid->expandFilter();

        $grid->disableExport();

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
            $filter->in('CompanyBasicInfo.group_category', '進駐單位')->checkbox($_option);
            $filter->like('CompanyBasicInfo.company_name', '自然人/組織/公司名稱');

            $filter->between('date_time', '時間')->date();
        });

        $grid->model()->collection(function (Collection $collection) {
            
            foreach($collection as $index => $item) {

                $company = CompanyBasicInfo::where('cid', $item->cid)->first();
                $oStaff = $company->staff;

                $item->tmp = $index + 1;
                $item->cid = $item->staff - $oStaff;
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
        $grid->column('CompanyBasicInfo.staff', __('進駐員工人數'));
        $grid->column('staff', __('當月員工人數'))->totalRow();
        $grid->column('date_time', __('日期'))->display(function($myTime){
            $myTime_year = date("Y", strtotime($myTime));
            $myTime_year = intval($myTime_year) - 1911;
            return $myTime_year.date("-m-d", strtotime($myTime)); 
        });
        $grid->column('note', __('備註'));

        $grid->tools(function ($tools) {
            $tools->append('<a href="" target="_blank" id="advexcel" class="btn btn-sm btn-info" ><i class="fa fa-download"></i>彙總匯出</a>');
        });

        Admin::script('
            var target = "/excel/addition-staff";
            $("#advexcel").click(function(){
                var date_time_start = $("#date_time_start").val();
                var date_time_end = $("#date_time_end").val();

                if(date_time_start == "" || date_time_end == "")
                {
                    alert("請填時間");
                    return;
                }
                else
                {
                    $("#advexcel").attr("href", "/excel/addition-staff?start_time="+date_time_start+"&end_time="+date_time_end+"")
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
        $show = new Show(AdditionStaff::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('cid', __('Cid'));
        $show->field('staff', __('Staff'));
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
        $form = new Form(new AdditionStaff());
        $_companies = CompanyBasicInfo::all();

        $_companiesArr = array();
        foreach($_companies as $item)
        {
            $groupCategory = [
                'farmer'        => '農試所',
                'forestry'      => '林試所',
                'water'         => '水試所',
                'livestock'     => '畜試所',
                'agricultural'  => '農科院',
            ];
            
            $_companiesArr[$item->cid] = "(".$groupCategory[$item->group_category].")".$item->company_name;
        }

        $tmp_date_arr = [];
        // $nowMonth = (int)date_format(now(), 'm');
        // $tmpMonth = $nowMonth;
        // for ($i=1; $i < 3; $i++) { 
        //     $tmp_date_arr[($tmpMonth-2).'-01 00:00:00'] = ($tmpMonth-2).'月-'.($tmpMonth-1).'月';
        //     $tmpMonth -= 2;
        // }

        $tmpMonth = 1;
        for ($i=1; $i < 7; $i++) { 
            $tmp_date_arr[($tmpMonth).'-01 00:00:00'] = ($tmpMonth).'月-'.($tmpMonth+1).'月';
            $tmpMonth += 2;
        }

        $form->select('cid', '自然人/組織/公司名稱')->options($_companiesArr);
        $form->number('staff', __('員工人數'))->rules('integer|min:0')->default(0);
        $form->year('tmp_year', __('年度'))->default(now('Y'))->required();
        $form->select('tmp_date', __('月份'))->options($tmp_date_arr)->required();
        $form->hidden('date_time', __('日期'));
        $form->textarea('note', __('備註'));

        $form->saving(function (Form $form) {
            $form->date_time = $form->tmp_year.'-'.$form->tmp_date;
        });

        return $form;
    }
}
