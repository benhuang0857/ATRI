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

        $grid->column('id', __('Id'));
        $grid->column('CompanyBasicInfo.group_category', '進駐單位')->display(function($data){
            $reault = GroupCategory::where('slug', $data)->first()->name;
            return '<span class="badge badge-primary" style="background:blue">'.$reault.'</span>';
        });
        $grid->column('cid', '自然人/組織/公司名稱')->display(function($cid){
            return CompanyBasicInfo::where('cid', $cid)->first()->company_name;
        });
        $grid->column('CompanyBasicInfo.owner_name', '負責人');
        $grid->column('CompanyBasicInfo.service', '服務項目');
        $grid->column('CompanyBasicInfo.established_time', '設立日期');
        $grid->column('CompanyBasicInfo.cid', '合約日期')->display(function($cid){
            $company = CompanyBasicInfo::where('cid', $cid)->first();
            $result = $company->contract_start_time.'<BR>'.$company->contract_end_time;
            return $result;
        });
        
        // $grid->column('CompanyBasicInfo.real_or_virtula', '進駐方式')->display(function($data){
        //     if ($data == 'real') 
        //         return '實質進駐';
        //     else
        //         return '虛擬進駐';
        // });
        

        // $grid->column('cid', '自然人/組織/公司名稱')->display(function($cid){
        //     return 0;
        // });

        // $grid->model()->cid;

        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));

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
