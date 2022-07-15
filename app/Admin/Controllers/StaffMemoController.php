<?php

namespace App\Admin\Controllers;

use App\StaffMemo;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class StaffMemoController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'StaffMemo';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new StaffMemo());

        $grid->column('id', __('Id'));
        $grid->column('cid', __('Cid'));
        $grid->column('create_month', __('Create month'));
        $grid->column('staff', __('Staff'));
        $grid->column('note', __('Note'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(StaffMemo::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('cid', __('Cid'));
        $show->field('create_month', __('Create month'));
        $show->field('staff', __('Staff'));
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
        $form = new Form(new StaffMemo());

        $form->text('cid', __('Cid'));
        $form->text('create_month', __('Create month'));
        $form->number('staff', __('Staff'));
        $form->text('note', __('Note'));

        return $form;
    }
}
