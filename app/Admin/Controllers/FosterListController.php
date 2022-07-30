<?php

namespace App\Admin\Controllers;

use App\FosterList;
use App\CompanyBasicInfo;
use App\GroupCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Database\Eloquent\Collection;

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
            $filter->equal('CompanyBasicInfo.group_category', '進駐單位')->select($_option);
            $filter->equal('CompanyBasicInfo.real_or_virtula', '進駐方式')->select([
                'real' => '實質進駐',
                'virtual' => '虛擬進駐'
            ]);
            $filter->like('CompanyBasicInfo.company_name', '自然人/組織/公司名稱');
        });

        $grid->export(function ($export) {
            $export->originalValue(['CompanyBasicInfo.group_category']);
            $export->column('CompanyBasicInfo.group_category', function ($value, $original) {
                if ($original == 'farmer') 
                    return '農試所';
                if ($original == 'forestry') 
                    return '林試所';
                if ($original == 'water') 
                    return '水試所';
                if ($original == 'livestock') 
                    return '畜試所';
                if ($original == 'agricultural') 
                    return '農科院';
            });
        });

        $grid->column('id', __('Id'));
        $grid->column('CompanyBasicInfo.group_category', '進駐單位')->using([
            'farmer'        => '農試所',
            'forestry'      => '林試所',
            'water'         => '水試所',
            'livestock'     => '畜試所',
            'agricultural'  => '農科院',
        ], '未知')->dot([
            'livestock'     => 'danger',
            'agricultural'  => 'success',
            'forestry'      => 'info',
            'water'         => 'primary',
            'farmer'        => 'success',
        ], 'warning');

        $grid->column('CompanyBasicInfo.company_name', '自然人/組織/公司名稱');
        $grid->column('CompanyBasicInfo.owner_name', '負責人');
        $grid->column('CompanyBasicInfo.service', '主要產品');
        $grid->column('cid', '進駐時實收資本額/員工人數/營業額')->display(function($cid){
            $company = CompanyBasicInfo::where('cid', $cid)->first();
            return $company->capital.'/'.$company->staff.'/'.$company->revenue;
        });
        $grid->column('CompanyBasicInfo.established_time', '設立日期');
        $grid->column('CompanyBasicInfo.cid', '合約日期')->display(function($cid){
            $company = CompanyBasicInfo::where('cid', $cid)->first();
            $result = $company->contract_start_time.'至'.$company->contract_end_time;
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
