<?php

namespace App\Admin\Controllers;

use App\IndustryAcademiaCoop;
use App\CompanyBasicInfo;
use App\ProjectCategory;
use Encore\Admin\Controllers\AdminController;
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

        $grid->column('id', __('Id'));
        $grid->column('cid', '自然人/組織/公司名稱')->display(function($cid){
            return CompanyBasicInfo::where('id', $cid)->first()->company_name;
        });
        $grid->column('project_name', '計畫名稱');
        $grid->column('project_category', '計畫類別');
        $grid->column('price', '金額(千元)');
        $grid->column('start_time', '開始時間');
        $grid->column('end_time', '結束時間');
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
            $_companiesArr[$item->id] = $item->company_name;
        }

        $_pCategoriesArr = array();
        foreach($_pCategories as $item)
        {
            $_pCategoriesArr[$item->slug] = $item->name;
        }

        $form->select('cid', '自然人/組織/公司名稱')->options($_companiesArr);
        $form->text('project_name', '計畫名稱');
        $form->select('project_category', '計畫類別')->options($_pCategoriesArr);
        $form->number('price', '金額(千元)');
        $form->datetime('start_time', '開始時間')->default(date('Y-m-d H:i:s'));
        $form->datetime('end_time', '結束時間')->default(date('Y-m-d H:i:s'));
        $form->file('document', '佐證文件');

        return $form;
    }
}
