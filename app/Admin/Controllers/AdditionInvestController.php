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
    protected $title = '投增資金額查詢及維護';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AdditionInvest());
        $grid->expandFilter();

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        // $grid->quickSearch(function ($model, $query) {
        //     $model->where('title', $query)->orWhere('desc', 'like', "%{$query}%");
        // });

        $grid->filter(function($filter){

            $_option = array();
            $GroupOptions = GroupCategory::all();
            foreach ($GroupOptions as $item) {
                $_option[$item->slug] = $item->name;
            }

            $filter->disableIdFilter();
            $filter->in('CompanyBasicInfo.group_category', '進駐單位')->checkbox($_option);
            $filter->like('CompanyBasicInfo.company_name', '自然人/組織/公司名稱');
            $filter->between('date_time', '投增資時間')->date();
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
            try {
                return CompanyBasicInfo::where('cid', $cid)->first()->company_name;
            } catch (\Throwable $th) {
                //throw $th;
            }
        });
        $grid->column('type', __('投資/增資'))->using([
            'invest'      => '投資', 
            'increase'    => '增資'
        ]);
        $grid->column('price', __('金額'))->display(function($price){
            return number_format($price);
        });
        $grid->column('reason', __('用途'));
        $grid->column('date_time', __('投增資時間'))->display(function($myTime){
            $myTime_year = date("Y", strtotime($myTime));
            $myTime_year = intval($myTime_year) - 1911;
            return $myTime_year.date("-m-d", strtotime($myTime)); 
        })->width(150);
        $grid->column('document', __('佐證文件'));
        $grid->column('note', __('備註'));

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
                    alert("請填時間");
                    return;
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

        $tmp_date_arr = [];
        $nowMonth = (int)date_format(now(), 'm');
        $tmpMonth = $nowMonth;
        for ($i=1; $i <= 6; $i++) { 
            $tmp_date_arr[($tmpMonth-2).'-01 00:00:00'] = ($tmpMonth-2).'月-'.($tmpMonth-1).'月';
            $tmpMonth -= 2;
        }

        $form->select('cid', '自然人/組織/公司名稱')->options($_companiesArr)->required();
        $form->select('type', __('投資/增資'))->options([
            'invest'      => '投資', 
            'increase'    => '增資'
        ])->required();
        $form->html('<span style="color:red">增資為現金增資，投資為購買機器設備、種苗之支出</span>', '');
        $form->number('price', __('金額'))->default(0)->required();
        $form->textarea('reason', __('用途'));
        $form->year('tmp_year', __('年度'))->default(now('Y'))->required();
        $form->select('tmp_date', __('月份'))->options($tmp_date_arr)->required();
        $form->hidden('date_time', __('日期'));
        $form->file('document', __('佐證文件'));
        $form->textarea('note', __('備註'));

        $form->saving(function (Form $form) {
            $form->date_time = $form->tmp_year.'-'.$form->tmp_date;
        });

        return $form;
    }
}
