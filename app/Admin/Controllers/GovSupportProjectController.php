<?php

namespace App\Admin\Controllers;

use App\GovSupportProject;
use Encore\Admin\Controllers\AdminController;
use Illuminate\Database\Eloquent\Collection;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GovSupportProjectController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '政府補助資源維護及查詢';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new GovSupportProject());
        $grid->fixColumns(4, 0);

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->filter(function($filter){

            $filter->disableIdFilter();
            $filter->equal('status', '狀態')->select([
                'no' => '未通過',
                'yes' => '通過'
            ]);
            $filter->equal('price', '資金額度')->select([
                'all'    => '不限',
                '1M'    => '100萬(含)以下',
                '1M3M'  => '100-300萬(含)以下',
                '3M10M' => '300-1000萬',
                'more10M'  => '100萬(含)以下',
            ]);
        });

        $grid->model()->collection(function (Collection $collection) {
            foreach($collection as $index => $item) {
                $item->tmp = $index + 1;
            }
            return $collection;
        });
        
        $grid->column('tmp', '編號');
        $grid->column('status', __('狀態'))->using([
            'no' => '下架',
            'yes' => '上架'
        ]);
        $grid->column('price', __('資金額度'))->using([
            'all'       => '不限',
            '1M'        => '100萬(含)以下',
            '1M3M'      => '100-300萬(含)以下',
            '3M10M'     => '300-1000萬',
            'more10M'  => '100萬(含)以下',
        ]);

        $grid->column('plan_title', __('計畫名稱'))->display(function($plan_title){
            return "<a target='_blank' href=/gov-project-view/".$this->id.">".$plan_title."</a>";
        });
        $grid->column('organizer', __('主辦單位'));
        $grid->column('organizer_contact_name', __('主辦方聯絡人'));
        $grid->column('organizer_phone', __('主辦方電話'));
        $grid->column('organizer_email', __('主辦方Email'));
        $grid->column('organizer_fax', __('主辦方傳真'));
        $grid->column('coorganizer', __('執行單位'));
        $grid->column('coorganizer_contact_name', __('執行方聯絡人'));
        $grid->column('coorganizer_phone', __('執行方'));
        $grid->column('coorganizer_email', __('執行方Email'));
        $grid->column('coorganizer_fax', __('執行方傳真'));
        // $grid->column('qualification_description', __('Qualification description'));
        // $grid->column('plan_description', __('Plan description'));
        // $grid->column('industry_description', __('Industry description'));
        // $grid->column('review_point_description', __('Review point description'));
        // $grid->column('amount_description', __('Amount description'));
        // $grid->column('date_start_time', __('Date start time'));
        // $grid->column('date_end_time', __('Date end time'));
        // $grid->column('web', __('Web'));
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
        $show = new Show(GovSupportProject::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('price', __('Price'));
        $show->field('status', __('Status'));
        $show->field('plan_title', __('Plan title'));
        $show->field('organizer', __('Organizer'));
        $show->field('organizer_contact_name', __('Organizer contact name'));
        $show->field('organizer_phone', __('Organizer phone'));
        $show->field('organizer_email', __('Organizer email'));
        $show->field('organizer_fax', __('Organizer fax'));
        $show->field('coorganizer', __('Coorganizer'));
        $show->field('coorganizer_contact_name', __('Coorganizer contact name'));
        $show->field('coorganizer_phone', __('Coorganizer phone'));
        $show->field('coorganizer_email', __('Coorganizer email'));
        $show->field('coorganizer_fax', __('Coorganizer fax'));
        $show->field('qualification_description', __('Qualification description'));
        $show->field('plan_description', __('Plan description'));
        $show->field('industry_description', __('Industry description'));
        $show->field('review_point_description', __('Review point description'));
        $show->field('amount_description', __('Amount description'));
        $show->field('date_start_time', __('Date start time'));
        $show->field('date_end_time', __('Date end time'));
        $show->field('web', __('Web'));
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
        $form = new Form(new GovSupportProject());

        $form->select('price', __('資金額度'))->options([
            'all'    => '不限',
            '1M'    => '100萬(含)以下',
            '1M3M'  => '100-300萬(含)以下',
            '3M10M' => '300-1000萬',
            'more10M'  => '100萬(含)以下',
        ]);
        $form->select('status', __('狀態'))->options([
            'no' => '下架',
            'yes' => '上架'
        ]);
        $form->text('plan_title', __('計畫名稱'));
        $form->text('organizer', __('主辦單位'));
        $form->text('organizer_contact_name', __('主辦方聯絡人'));
        $form->text('organizer_phone', __('主辦方電話'));
        $form->text('organizer_email', __('主辦方Email'));
        $form->text('organizer_fax', __('主辦方傳真'));
        $form->text('coorganizer', __('執行單位'));
        $form->text('coorganizer_contact_name', __('執行方聯絡人'));
        $form->text('coorganizer_phone', __('執行方電話'));
        $form->text('coorganizer_email', __('執行方Email'));
        $form->text('coorganizer_fax', __('執行方傳真'));
        $form->ckeditor('qualification_description', __('申請資格/申請對象'));
        $form->ckeditor('plan_description', __('標的'));
        $form->ckeditor('industry_description', __('產業別/屬性'));
        $form->ckeditor('review_point_description', __('審查重點'));
        $form->ckeditor('amount_description', __('獎勵方式'));
        $form->date('date_start_time', __('申請起始時間'))->default(date('Y-m-d'));
        $form->date('date_end_time', __('申請截止時間'))->default(date('Y-m-d'));
        $form->text('web', __('網站連結'));

        return $form;
    }
}
