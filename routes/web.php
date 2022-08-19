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

Route::get('excel/addition-invest', 'AdditionInvestController@Export');
Route::get('excel/tech-transfer', 'TechTransferController@Export');
Route::get('excel/industry-academia-coop', 'IndustryAcademiaCoopController@Export');
Route::get('excel/addition-staff', 'AdditionStaffController@Export');
Route::get('excel/addition-revenue', 'AdditionRevenueController@Export');
