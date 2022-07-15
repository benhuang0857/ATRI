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
    $router->resource('change-memos', ChangeMemoController::class);
    $router->resource('counseling-memos', CounselingMemoController::class);
    $router->resource('group-categories', GroupCategoryController::class);
    $router->resource('other-memos', OtherMemoController::class);
    $router->resource('status-categories', StatusCategoryController::class);
    $router->resource('capital-memos', CapitalMemoController::class);
    $router->resource('revenue-memos', RevenueMemoController::class);
    $router->resource('staff-memos', StaffMemoController::class);
});
