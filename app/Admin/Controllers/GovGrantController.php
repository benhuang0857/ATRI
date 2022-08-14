<?php

namespace App\Admin\Controllers;

use App\GovGrant;
use App\CompanyBasicInfo;
use Encore\Admin\Controllers\AdminController;
use Illuminate\Database\Eloquent\Collection;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GovGrantController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '取得政府補助資源';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new GovGrant());

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
        $grid->column('gov_grant_name', '政府補助資源名稱');
        $grid->column('plan_name', '計畫名稱');
        $grid->column('application_time', '申請日期')->display(function($application_time){
            return date("Y-m-d", strtotime($application_time));  
        });
        $grid->column('application_status', '申請狀態')->using([
            'pending'   => '申請中',
            'no'        => '未通過',
            'yes'       => '通過'
        ]);
        $grid->column('grant_time', '補助核定日期')->display(function($grant_time){
            return date("Y-m-d", strtotime($grant_time));  
        });
        $grid->column('grant_price', '核定補助金額');
        $grid->column('document', '佐證文件');

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
        $show = new Show(GovGrant::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('cid', __('Cid'));
        $show->field('gov_grant_name', __('Gov grant name'));
        $show->field('plan_name', __('Plan name'));
        $show->field('application_time', __('Application time'));
        $show->field('application_status', __('Application status'));
        $show->field('grant_time', __('Grant time'));
        $show->field('grant_price', __('Grant price'));
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
        $form = new Form(new GovGrant());
        $_companies = CompanyBasicInfo::all();

        $_companiesArr = array();
        foreach($_companies as $item)
        {
            $_companiesArr[$item->cid] = $item->company_name;
        }

        $form->select('cid', '自然人/組織/公司名稱')->options($_companiesArr);
        $form->text('gov_grant_name', '政府補助資源名稱');
        $form->text('plan_name', '計畫名稱');
        $form->datetime('application_time', '申請日期')->default(date('Y-m-d H:i:s'));
        $form->select('application_status', '申請狀態')->options([
            'pending'   => '申請中',
            'no'        => '未通過',
            'yes'       => '通過'
        ]);
        $form->datetime('grant_time', '補助核定日期')->default(date('Y-m-d H:i:s'));
        $form->number('grant_price', '核定補助金額');
        $form->textarea('note', __('輔導內容'));
        $form->file('document', '佐證文件');

        return $form;
    }
}
