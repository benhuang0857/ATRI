<?php

namespace App\Admin\Controllers;

use App\IndustryAcademiaCoop;
use App\CompanyBasicInfo;
use App\ProjectCategory;
use App\GroupCategory;
use Encore\Admin\Controllers\AdminController;
use Illuminate\Database\Eloquent\Collection;
Use Encore\Admin\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class IndustryAcademiaCoopController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '產學合作及委託';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new IndustryAcademiaCoop());

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
            $filter->in('CompanyBasicInfo.group_category', '進駐單位')->multipleSelect($_option);
            // $filter->equal('CompanyBasicInfo.real_or_virtula', '進駐方式')->select([
            //     'real' => '實質進駐',
            //     'virtual' => '虛擬進駐'
            // ]);
            $filter->like('CompanyBasicInfo.company_name', '自然人/組織/公司名稱');
            // $filter->like('CompanyBasicInfo.identity_code', '身分證/統一編號');
            // $filter->where(function ($query) {
            //     $query->where('CompanyBasicInfo.contact_name', 'like', "%{$this->input}%")
            //         ->orWhere('CompanyBasicInfo.owner_name', 'like', "%{$this->input}%");
            // }, '聯絡人/負責人姓名');
            // $filter->where(function ($query) {
            //     $query->where('CompanyBasicInfo.contact_email', 'like', "%{$this->input}%")
            //         ->orWhere('CompanyBasicInfo.owner_email', 'like', "%{$this->input}%");
            // }, '聯絡人/負責人Email');
            // $filter->where(function ($query) {
            //     $query->where('CompanyBasicInfo.contact_phone', 'like', "%{$this->input}%")
            //         ->orWhere('CompanyBasicInfo.owner_phone', 'like', "%{$this->input}%");
            // }, '聯絡人/負責人電話');

            $filter->between('start_time', '合約開始時間')->datetime();
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
            try {
                return CompanyBasicInfo::where('cid', $cid)->first()->company_name;
            } catch (\Throwable $th) {
                //throw $th;
            }
        });
        $grid->column('project_name', '計畫名稱');
        $grid->column('project_category', '計畫類別')->using([
            'industry_academia' => '產學',
            'entrust' => '委託'
        ]);
        $grid->column('price', '金額(元)');
        $grid->column('start_time', '開始時間')->display(function($start_time){
            $start_time = date("Y", strtotime($start_time));
            $start_year = $start_time - 1911;
            return $start_year.date("-m-d", strtotime($start_time)); 
        });
        $grid->column('end_time', '結束時間')->display(function($end_time){
            $start_time = date("Y", strtotime($end_time));
            $start_year = $start_time - 1911;
            return $start_year.date("-m-d", strtotime($end_time));  
        });
        $grid->column('document', '佐證文件');
        
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
                    $("#advexcel").attr("href", "/excel/industry-academia-coop");
                }
                else
                {
                    $("#advexcel").attr("href", "/excel/industry-academia-coop?start_time="+date_time_start+"&end_time="+date_time_end+"")
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
        $show = new Show(IndustryAcademiaCoop::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('cid', __('Cid'));
        $show->field('project_name', __('Project name'));
        $show->field('project_category', __('Project category'));
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
        $form = new Form(new IndustryAcademiaCoop());
        $_companies = CompanyBasicInfo::all();
        $_pCategories = ProjectCategory::all();

        $_companiesArr = array();
        foreach($_companies as $item)
        {
            $_companiesArr[$item->cid] = $item->company_name;
        }

        $_pCategoriesArr = array();
        foreach($_pCategories as $item)
        {
            $_pCategoriesArr[$item->slug] = $item->name;
        }

        $form->select('cid', '自然人/組織/公司名稱')->options($_companiesArr);
        $form->text('project_name', '計畫名稱');
        $form->select('project_category', '計畫類別')->options($_pCategoriesArr);
        $form->number('price', '金額(元)');
        $form->datetime('start_time', '開始時間')->default(date('Y-m-d H:i:s'));
        $form->datetime('end_time', '結束時間')->default(date('Y-m-d H:i:s'));
        $form->textarea('note', __('輔導內容'));
        $form->file('document', '佐證文件');

        return $form;
    }
}
