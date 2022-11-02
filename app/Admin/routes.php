<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('company-basic-infos', CompanyBasicInfoController::class);
    // $router->resource('foster-lists', FosterListController::class); //長官要求合併，故隱藏
    $router->resource('group-categories', GroupCategoryController::class);
    $router->resource('project-categories', ProjectCategoryController::class);
    $router->resource('company-statuses', CompanyStatusController::class);
    
    $router->resource('addition-invests', AdditionInvestController::class);
    $router->resource('addition-invests-ex', AdditionInvestExcelController::class);

    $router->resource('addition-revenues', AdditionRevenueController::class);
    $router->resource('addition-revenues-ex', AdditionRevenueExcelController::class);

    $router->resource('addition-staffs', AdditionStaffController::class);
    $router->resource('addition-staffs-ex', AdditionStaffExcelController::class);

    $router->resource('gov-grants', GovGrantController::class);
    $router->resource('gov-grants-ex', GovGrantExcelController::class);

    $router->resource('awards', AwardController::class);
    $router->resource('awards-ex', AwardExcelController::class);
    
    $router->resource('industry-academia-coops', IndustryAcademiaCoopController::class);
    $router->resource('tech-transfers', TechTransferController::class);
    $router->resource('gov-support-projects', GovSupportProjectController::class);
    $router->resource('regions', RegionController::class);
});
