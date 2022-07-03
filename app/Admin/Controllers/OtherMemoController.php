<?php

namespace App\Admin\Controllers;

use App\OtherMemo;
use App\CompanyBasicInfo;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OtherMemoController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '歷史紀錄管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {        
        $grid = new Grid(new OtherMemo());

        // $grid->column('id', __('Id'));
        $grid->column('cid', '公司/會員名稱')->display(function($cid){
            $company = CompanyBasicInfo::where('id', $cid)->firstOrFail();
            return $company->company_name;
        });
        $grid->column('note', '歷史紀錄');
        $grid->column('created_at', '創建時間');
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
        $show = new Show(OtherMemo::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('cid', __('Cid'));
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
        $form = new Form(new OtherMemo());

        $form->text('cid', __('Cid'));
        $form->text('note', __('Note'));

        return $form;
    }
}
