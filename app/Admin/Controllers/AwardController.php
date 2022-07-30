<?php

namespace App\Admin\Controllers;

use App\Award;
use App\CompanyBasicInfo;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AwardController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '取得獎項';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Award());

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
        $grid->column('cid', '自然人/組織/公司名稱')->display(function($cid){
            return CompanyBasicInfo::where('cid', $cid)->first()->company_name;
        });
        $grid->column('award_name', '獎項名稱');
        $grid->column('application_time', '申請日期');
        $grid->column('application_status', '申請狀態');
        $grid->column('award_status', '獲獎狀態');
        $grid->column('award_time', '獲獎日期');
        $grid->column('document', '佐證文件');
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
        $show = new Show(Award::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('cid', __('Cid'));
        $show->field('award_name', __('Award name'));
        $show->field('application_time', __('Application time'));
        $show->field('application_status', __('Application status'));
        $show->field('award_status', __('Award status'));
        $show->field('award_time', __('Award time'));
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
        $form = new Form(new Award());
        $_companies = CompanyBasicInfo::all();

        $_companiesArr = array();
        foreach($_companies as $item)
        {
            $_companiesArr[$item->cid] = $item->company_name;
        }

        $form->select('cid', '自然人/組織/公司名稱')->options($_companiesArr);
        $form->text('award_name', '獎項名稱');
        $form->datetime('application_time', '申請日期')->default(date('Y-m-d'));
        $form->select('application_status', '申請狀態')->options([
            'no' => '未通過',
            'yes' => '通過'
        ]);
        $form->select('award_status', '獲獎狀態')->options([
            'no' => '未獲獎',
            'yes' => '獲獎'
        ]);
        $form->datetime('award_time', '獲獎日期')->default(date('Y-m-d H:i:s'));
        $form->file('document', '佐證文件');

        return $form;
    }
}
