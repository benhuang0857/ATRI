<?php

namespace App\Admin\Controllers;

use App\CapitalMemo;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CapitalMemoController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'CapitalMemo';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CapitalMemo());

        $grid->column('id', __('Id'));
        $grid->column('month', __('Month'));
        $grid->column('capital', __('Capital'));
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
        $show = new Show(CapitalMemo::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('month', __('Month'));
        $show->field('capital', __('Capital'));
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
        $form = new Form(new CapitalMemo());

        $form->text('month', __('Month'));
        $form->text('capital', __('Capital'));

        return $form;
    }
}
