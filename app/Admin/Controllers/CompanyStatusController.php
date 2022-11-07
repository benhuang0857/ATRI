<?php

namespace App\Admin\Controllers;

use App\CompanyStatus;
use App\CompanyBasicInfo;
use App\GroupCategory;
use Encore\Admin\Controllers\AdminController;
use Illuminate\Database\Eloquent\Collection;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CompanyStatusController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '進駐狀態異動';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CompanyStatus());
        $grid->expandFilter();

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->filter(function($filter){

            $_option = array();
            $GroupOptions = GroupCategory::all();
            foreach ($GroupOptions as $item) {
                $_option[$item->slug] = $item->name;
            }

            $filter->disableIdFilter();
            $filter->equal('CompanyBasicInfo.group_category', '進駐單位')->select($_option);
            // $filter->equal('CompanyBasicInfo.real_or_virtula', '進駐方式')->select([
            //     'real' => '實質進駐',
            //     'virtual' => '虛擬進駐'
            // ]);
            $filter->like('CompanyBasicInfo.company_name', '自然人/組織/公司名稱');
            $filter->between('date_time', '異動日期')->date();
        });

        $grid->model()->collection(function (Collection $collection) {
            foreach($collection as $index => $item) {
                $item->tmp = $index + 1;
            }
            return $collection;
        });
        
        $grid->column('tmp', '編號');
        
        $grid->column('cid', '自然人/組織/公司名稱')->display(function($cid){
            try {
                return CompanyBasicInfo::where('cid', $cid)->first()->company_name;
            } catch (\Throwable $th) {
                //throw $th;
            }
        });
        // $grid->column('cid', __('Cid'));
        $grid->column('status', __('異動狀態'))->using([
            'stationed' => '進駐', 
            'extend'    => '展延',
            'graduate'  => '畢業',
            'leave'     => '離駐'
        ]);
        $grid->column('note', __('異動原因'));
        $grid->column('date_time', __('異動日期'))->display(function($date_time){
            $start_time = date("Y", strtotime($date_time));
            $start_year = $start_time - 1911;
            return $start_year.date("-m-d", strtotime($date_time)); 
        });
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
        $show = new Show(CompanyStatus::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('cid', __('Cid'));
        $show->field('status', __('Status'));
        $show->field('note', __('Note'));
        $show->field('date_time', __('Date time'));
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
        $form = new Form(new CompanyStatus());
        $_companies = CompanyBasicInfo::all();

        $_companiesArr = array();
        foreach($_companies as $item)
        {
            $_companiesArr[$item->cid] = $item->company_name;
        }
        $form->select('cid', '自然人/組織/公司名稱')->options($_companiesArr);
        $form->select('status', __('異動狀態'))->options([
            'stationed' => '進駐',
            'extend' => '展延',
            'graduate' => '畢業',
            'leave' => '離駐'
        ]);
        $form->textarea('note', __('異動原因'));
        $form->date('date_time', __('異動日期'))->default(date('Y-m-d'));

        return $form;
    }
}
