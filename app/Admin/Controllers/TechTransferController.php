<?php

namespace App\Admin\Controllers;

use App\TechTransfer;
use App\CompanyBasicInfo;
use Encore\Admin\Controllers\AdminController;
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
        $grid->column('tech_transfer_name', '技轉名稱');
        $grid->column('price', '技轉金額(千)');
        $grid->column('start_time', '合約起始日期');
        $grid->column('end_time', '合約終止日期');
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
        $form->number('price', '技轉金額(千)');
        $form->datetime('start_time', '合約起始日期')->default(date('Y-m-d H:i:s'));
        $form->datetime('end_time', '合約終止日期')->default(date('Y-m-d H:i:s'));
        $form->file('document', '佐證文件');

        return $form;
    }
}
