<?php

namespace App\Admin\Controllers;

use App\TechTransfer;
use App\CompanyBasicInfo;
use App\GroupCategory;
use Encore\Admin\Controllers\AdminController;
use Illuminate\Database\Eloquent\Collection;
Use Encore\Admin\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TechTransferController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '技術移轉';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TechTransfer());
        $grid->expandFilter();

        $grid->filter(function($filter){

            $_option = array();
            $GroupOptions = GroupCategory::all();
            foreach ($GroupOptions as $item) {
                $_option[$item->slug] = $item->name;
            }

            $filter->disableIdFilter();
            $filter->in('CompanyBasicInfo.group_category', '進駐單位')->multipleSelect($_option);
            $filter->like('CompanyBasicInfo.company_name', '自然人/組織/公司名稱');
            $filter->between('start_time', '合約開始時間')->date();
        });

        $grid->model()->collection(function (Collection $collection) {
            foreach($collection as $index => $item) {
                $item->tmp = $index + 1;
            }
            return $collection;
        });
        
        // $grid->column('tmp', '編號');
        
        $grid->column('CompanyBasicInfo.group_category', '進駐單位')->using([
            'farmer'        => '農試所',
            'forestry'      => '林試所',
            'water'         => '水試所',
            'livestock'     => '畜試所',
            'agricultural'  => '農科院',
        ], '未知');
        $grid->column('cid', '自然人/組織/公司名稱')->display(function($cid){
            try {
                return CompanyBasicInfo::where('cid', $cid)->first()->company_name;
            } catch (\Throwable $th) {
                //throw $th;
            }
        });
        $grid->column('tech_transfer_name', '技轉名稱');
        $grid->column('price', '技轉金額(元)');
        $grid->column('start_time', '合約起始日期')->display(function($myTime){
            $myTime_year = date("Y", strtotime($myTime));
            $myTime_year = intval($myTime_year) - 1911;
            return $myTime_year.date("-m-d", strtotime($myTime));   
        });
        $grid->column('end_time', '合約終止日期')->display(function($myTime){
            try {
                $myTime_year = date("Y", strtotime($myTime));
                $myTime_year = intval($myTime_year) - 1911;
                return $myTime_year.date("-m-d", strtotime($myTime));   
            } catch (\Throwable $th) {
            }
        });
        $grid->column('document', '佐證文件');
        $grid->column('note', __('輔導內容'))->width(200);
        
        $grid->tools(function ($tools) {
            $tools->append('<a href="" target="_blank" id="advexcel" class="btn btn-sm btn-info" ><i class="fa fa-download"></i>彙總匯出</a>');
        });

        Admin::script('
            var target = "/excel/tech-transfer";
            $("#advexcel").click(function(){
                var date_time_start = $("#start_time_start").val();
                var date_time_end = $("#start_time_end").val();

                if(date_time_start == "" || date_time_end == "")
                {
                    $("#advexcel").attr("href", "/excel/tech-transfer");
                }
                else
                {
                    $("#advexcel").attr("href", "/excel/tech-transfer?start_time="+date_time_start+"&end_time="+date_time_end+"")
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
        $show = new Show(TechTransfer::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('cid', __('Cid'));
        $show->field('tech_transfer_name', __('Tech transfer name'));
        $show->field('price', __('Price'));
        $show->field('start_time', __('Start time'));
        $show->field('end_time', __('End time'));
        $show->field('document', __('Document'));
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
        $form = new Form(new TechTransfer());
        $_companies = CompanyBasicInfo::all();

        $_companiesArr = array();
        foreach($_companies as $item)
        {
            $_companiesArr[$item->cid] = $item->company_name;
        }

        $form->select('cid', '自然人/組織/公司名稱')->options($_companiesArr);
        $form->text('tech_transfer_name', '技轉名稱');
        $form->number('price', '技轉金額(元)');
        $form->date('start_time', '合約起始日期')->default(date('Y-m-d'));
        $form->date('end_time', '合約終止日期')->default(date('Y-m-d'));
        $form->textarea('note', __('輔導內容'));
        $form->file('document', '佐證文件');

        return $form;
    }
}
