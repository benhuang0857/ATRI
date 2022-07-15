<?php

namespace App\Admin\Controllers;

use App\CompanyBasicInfo;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
Use Encore\Admin\Widgets\Table;
use Grid\Displayers\Actions;
use App\GroupCategory;
use App\OtherMemo;
use App\Admin\Actions\CompanyBasicInfo\OtherMemoAction;
use App\Admin\Actions\CompanyBasicInfo\CounselingMemoAction;
use App\Admin\Actions\CompanyBasicInfo\CaptialMemoAction;
use App\Admin\Actions\CompanyBasicInfo\RevenueMemoAction;
use App\Admin\Actions\CompanyBasicInfo\StaffMemoAction;

class CompanyBasicInfoController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '基本資料表暨輔導歷程';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CompanyBasicInfo());

        $grid->filter(function($filter){

            $_option = array();
            $GroupOptions = GroupCategory::all();
            foreach ($GroupOptions as $item) {
                $_option[$item->slug] = $item->name;
            }

            $filter->disableIdFilter();
            $filter->equal('group_category', '進駐單位')->select($_option);
            $filter->like('company_name', '自然人/組織/公司名稱');
            $filter->like('identity_code', '身分證/統一編號');
            $filter->where(function ($query) {
                $query->where('contact_name', 'like', "%{$this->input}%")
                    ->orWhere('owner_name', 'like', "%{$this->input}%");
            }, '聯絡人/負責人姓名');
            $filter->where(function ($query) {
                $query->where('contact_email', 'like', "%{$this->input}%")
                    ->orWhere('owner_email', 'like', "%{$this->input}%");
            }, '聯絡人/負責人Email');
            $filter->where(function ($query) {
                $query->where('contact_phone', 'like', "%{$this->input}%")
                    ->orWhere('owner_phone', 'like', "%{$this->input}%");
            }, '聯絡人/負責人電話');
        });

        // $grid->column('id', __('Id'));
        
        $grid->column('group_category', '進駐單位')->display(function($slug){
            $reault = GroupCategory::where('slug', $slug)->first()->name;
            return '<span class="badge badge-primary" style="background:blue">'.$reault.'</span>';
        });
        $grid->column('company_name', '自然人/組織/公司名稱')->expand(function ($model) {

            $row = CompanyBasicInfo::where('id', $this->id)->get()->map(function ($row) {
                return $row->only([
                    'owner_name', 
                    'owner_email', 
                    'owner_phone',
                    'project_name',
                    'service',
                    'contract_time',
                    'capital',
                    'revenue',
                    'staff'
                ]);
            });
        
            return new Table([
                '負責人', 
                '負責人Email',
                '負責人電話',
                '營運專案名稱',
                '主要產品/服務項目',
                '合約日期',
                '進駐時實收資本額',
                '進駐時年營業額',
                '進駐時員工人數'
                ], $row->toArray());
        });
        $grid->column('identity_code', '身分證/統一編號');
        $grid->column('established_time', '設立日期');
        $grid->column('contact_name', '聯絡人');
        $grid->column('contact_email', '聯絡人Email');
        $grid->column('contact_phone', '聯絡人電話');
        // $grid->column('id', '添加紀錄')->display(function($id){
        //     return '<a href="/add-note/'.$id.'"><span class="badge badge-primary" style="background:blue">添加紀錄</span></a>';
        // });

        $grid->actions(function ($actions) {
            $actions->add(new OtherMemoAction);
            $actions->add(new CounselingMemoAction);
            $actions->add(new CaptialMemoAction);
            $actions->add(new RevenueMemoAction);
            $actions->add(new StaffMemoAction);
        });

        // $grid->column('owner_name', __('Owner name'));
        // $grid->column('owner_email', __('Owner email'));
        // $grid->column('owner_phone', __('Owner phone'));
        // $grid->column('project_name', __('Project name'));
        // $grid->column('service', __('Service'));
        // $grid->column('contract_time', __('Contract time'));
        // $grid->column('capital', __('Capital'));
        // $grid->column('revenue', __('Revenue'));
        // $grid->column('staff', __('Staff'));
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
        $show = new Show(CompanyBasicInfo::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('group_category', __('Group category'));
        $show->field('company_name', __('Company name'));
        $show->field('identity_code', __('Identity code'));
        $show->field('established_time', __('Established time'));
        $show->field('contact_name', __('Contact name'));
        $show->field('contact_email', __('Contact email'));
        $show->field('contact_phone', __('Contact phone'));
        $show->field('owner_name', __('Owner name'));
        $show->field('owner_email', __('Owner email'));
        $show->field('owner_phone', __('Owner phone'));
        $show->field('project_name', __('Project name'));
        $show->field('service', __('Service'));
        $show->field('contract_time', __('Contract time'));
        $show->field('capital', __('Capital'));
        $show->field('revenue', __('Revenue'));
        $show->field('staff', __('Staff'));
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
        $form = new Form(new CompanyBasicInfo());

        $_option = array();
        $GroupOptions = GroupCategory::all();
        foreach ($GroupOptions as $item) {
            $_option[$item->slug] = $item->name;
        }

        $form->select('group_category','進駐單位')->options($_option);
        
        $form->text('company_name', '自然人/組織/公司名稱');
        $form->text('identity_code', '身分證/統一編號');
        $form->datetime('established_time', '設立日期')->default(date('Y-m-d H:i:s'));
        $form->text('contact_name', '聯絡人');
        $form->text('contact_email', '聯絡人Email');
        $form->text('contact_phone', '聯絡人電話');
        $form->text('owner_name', '負責人');
        $form->text('owner_email', '負責人Email');
        $form->text('owner_phone', '負責人電話');
        $form->text('project_name', '營運專案名稱');
        $form->text('service', '主要產品/服務項目');
        $form->datetime('contract_time', '合約日期')->default(date('Y-m-d H:i:s'));
        $form->text('capital', '進駐時實收資本額');
        $form->text('revenue', '進駐時年營業額');
        $form->text('staff', '進駐時員工人數');

        return $form;
    }
}
