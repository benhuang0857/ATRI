<?php

namespace App\Admin\Controllers;

use App\GovSupportProject;
use App\GroupCategory;
use App\Region;
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

        $grid->filter(function($filter){

            $_option = array();
            $RegionOptions = Region::all();
            foreach ($RegionOptions as $item) {
                $_option[$item->slug] = $item->name;
            }

            $filter->disableIdFilter();
            $filter->equal('region', '地區')->select($_option);
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
            $filter->like('company_name', '聯絡人');
            $filter->like('phone', '電話');
            $filter->like('email', 'Email');
            $filter->like('fax', '傳真');
        });

        $grid->model()->collection(function (Collection $collection) {
            foreach($collection as $index => $item) {
                $item->tmp = $index + 1;
            }
            return $collection;
        });
        
        $grid->column('tmp', '編號');
        $grid->column('status', __('狀態'))->using([
            'no' => '未通過',
            'yes' => '通過'
        ]);
        $grid->column('plan_title', __('計畫名稱'))->display(function($plan_title){
            return "<a target='_blank' href=/gov-project-view/".$this->id.">".$plan_title."</a>";
        });
        $grid->column('plan_group', __('執行單位'));
        $grid->column('region', __('地區'))->display(function($slug){
            $reault = Region::where('slug', $slug)->first()->name;
            return $reault;
        });
        $grid->column('type', __('性質'));
        $grid->column('price', __('資金額度'))->using([
            'all'       => '不限',
            '1M'        => '100萬(含)以下',
            '1M3M'      => '100-300萬(含)以下',
            '3M10M'     => '300-1000萬',
            'more10M'  => '100萬(含)以下',
        ]);
        $grid->column('contact_name', __('聯絡人'));
        $grid->column('phone', __('電話'));
        $grid->column('email', __('Email'));
        $grid->column('fax', __('傳真'));
        $grid->column('web', __('網站連結'));
        $grid->column('date_start_time', __('申請開始日期'));
        $grid->column('date_end_time', __('申請結束日期'));

        // $grid->column('qualification_description', __('申請資格說明'));
        // $grid->column('plan_description', __('計畫標的說明'));
        // $grid->column('industry_description', __('產業屬性說明'));
        // $grid->column('review_point_description', __('審查種點說明'));
        // $grid->column('amount_description', __('研擬額度說明'));
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
        $show->field('region', __('Region'));
        $show->field('type', __('Type'));
        $show->field('price', __('Price'));
        $show->field('contact_name', __('Contact name'));
        $show->field('phone', __('Phone'));
        $show->field('email', __('Email'));
        $show->field('fax', __('Fax'));
        $show->field('web', __('Web'));
        $show->field('date_start_time', __('Date start time'));
        $show->field('date_end_time', __('Date end time'));
        $show->field('status', __('Status'));
        $show->field('plan_title', __('Plan title'));
        $show->field('plan_group', __('Plan group'));
        $show->field('qualification_description', __('Qualification description'));
        $show->field('plan_description', __('Plan description'));
        $show->field('industry_description', __('Industry description'));
        $show->field('review_point_description', __('Review point description'));
        $show->field('amount_description', __('Amount description'));
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

        $_groupOption = array();
        $GroupOptions = GroupCategory::all();
        foreach ($GroupOptions as $item) {
            $_groupOption[$item->slug] = $item->name;
        }

        $_regionOption = array();
        $RegionOptions = Region::all();
        foreach ($RegionOptions as $item) {
            $_regionOption[$item->slug] = $item->name;
        }

        $form->text('plan_title', __('計畫名稱'));
        $form->select('plan_group', __('執行單位'))->options($_groupOption);
        $form->select('region', __('地區'))->options($_regionOption);
        $form->text('type', __('性質'));
        $form->select('price', __('資金額度'))->options([
            'all'    => '不限',
            '1M'    => '100萬(含)以下',
            '1M3M'  => '100-300萬(含)以下',
            '3M10M' => '300-1000萬',
            'more10M'  => '100萬(含)以下',
        ]);
        $form->text('contact_name', __('聯絡人'));
        $form->text('phone', __('電話'));
        $form->email('email', __('Email'));
        $form->text('fax', __('傳真'));
        $form->text('web', __('網站連結'));
        $form->datetime('date_start_time', __('申請開始日期'))->default(date('Y-m-d'));
        $form->datetime('date_end_time', __('申請結束日期'))->default(date('Y-m-d'));
        $form->select('status', __('狀態'))->options([
            'no' => '未通過',
            'yes' => '通過'
        ]);

        $form->ckeditor('qualification_description', __('申請資格說明'));
        $form->ckeditor('plan_description', __('計畫標的說明'));
        $form->ckeditor('industry_description', __('產業屬性說明'));
        $form->ckeditor('review_point_description', __('審查種點說明'));
        $form->ckeditor('amount_description', __('研擬額度說明'));

        return $form;
    }
}
