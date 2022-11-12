<?php

namespace App\Admin\Controllers;

use App\FosterList;
use App\CompanyBasicInfo;
use App\GroupCategory;
use Encore\Admin\Controllers\AdminController;
use Illuminate\Database\Eloquent\Collection;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;


class FosterListController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '培育企業名單';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FosterList());
        $grid->filter(function($filter){

            $_option = array();
            $GroupOptions = GroupCategory::all();
            foreach ($GroupOptions as $item) {
                $_option[$item->slug] = $item->name;
            }

            $filter->disableIdFilter();
            $filter->in('CompanyBasicInfo.group_category', '進駐單位')->checkbox($_option);
            $filter->equal('CompanyBasicInfo.real_or_virtula', '進駐方式')->select([
                'real' => '實質進駐',
                'virtual' => '虛擬進駐'
            ]);
            $filter->like('CompanyBasicInfo.company_name', '自然人/組織/公司名稱');
        });        
        $grid->export(function ($export) {
            $export->except(['tmp']);
        });

        $grid->model()->collection(function (Collection $collection) {
            
            foreach($collection as $index => $item) {
                $company = CompanyBasicInfo::where('cid', $item->cid)->first();
                $group = $company->group_category;
                $item->tmp = $index + 1;
                $item->tmp_group = $group;
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
        $grid->column('CompanyBasicInfo.owner_name', '負責人');
        $grid->column('CompanyBasicInfo.service', '主要產品');
        $grid->column('cid', '進駐時實收資本額/員工人數/營業額')->display(function($cid){
            $company = CompanyBasicInfo::where('cid', $cid)->first();
            return $company->capital.'/'.$company->staff.'/'.$company->revenue;
        });
        $grid->column('CompanyBasicInfo.established_time', '設立日期')->display(function($established_time){
            return date("Y-m-d", strtotime($established_time));  
        });
        $grid->column('CompanyBasicInfo.cid', '合約日期')->display(function($cid){
            $company = CompanyBasicInfo::where('cid', $cid)->first();
            $result = date("Y-m-d", strtotime($company->contract_start_time)).'至'.date("Y-m-d", strtotime($company->contract_end_time));
            return $result;
        });

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
        $show = new Show(FosterList::findOrFail($id));

        $show->field('id', __('Id'));
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
        $form = new Form(new FosterList());
        $_companies = CompanyBasicInfo::all();

        $_companiesArr = array();
        foreach($_companies as $item)
        {
            $_companiesArr[$item->cid] = $item->company_name;
        }
        $form->select('cid', '自然人/組織/公司名稱')->options($_companiesArr);


        return $form;
    }
}
