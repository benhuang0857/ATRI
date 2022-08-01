<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('company-info-view/{cid}', 'CompanyBasicInfoController@CompanyInfoView');
Route::get('gov-project-view/{cid}', 'CompanyBasicInfoController@GovProjectView');
// Route::get('company-info-pdf/{cid}', 'CompanyBasicInfoController@CompanyInfoPDF');
