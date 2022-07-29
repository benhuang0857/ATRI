<?php

namespace App\Admin\Controllers;

use App\GroupCategory;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GroupCategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '進駐單位設定';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new GroupCategory());

        $grid->column('id', __('Id'));
        $grid->column('name', __('進駐單位名稱'));
        $grid->column('slug', __('進駐單位英文簡稱'));
        $grid->column('created_at', __('建立時間'));
        $grid->column('updated_at', __('更新時間'));

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
        $show = new Show(GroupCategory::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('slug', __('Slug'));
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
        $form = new Form(new GroupCategory());

        $form->text('name', __('進駐單位名稱'));
        $form->text('slug', __('進駐單位英文簡稱'));

        return $form;
    }
}
