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

Route::get('/login','LoginController@index');
Route::post('/api/user/login','LoginController@login');

Route::group(['middleware' => 'isLoggedOn'], function () {
  // dashboard
  Route::get('/dashboard','DashboardController@index');
  // person
  Route::get('/person/create','PersonController@index');
  Route::get('/person/edit/{id}','PersonController@index');
  Route::get('/person/view/{id}','PersonController@index');
  Route::get('/person/finder','PersonController@index');
  Route::get('/person/report/getpersonprofile','PersonController@getPersonProfileList');

  Route::get('/api/person/get','PersonController@getPersonProfile');
  Route::post('/api/person/create','PersonController@store');
  Route::post('/api/person/delete','PersonController@delete');
  Route::get('/api/person/collection/get','PersonController@getPersonCollection');
  Route::get('/api/person/collection/getmonthlydues','PersonController@getMonthlyDues');
  Route::get('/api/person/collection/getcarsticker','PersonController@getCarSticker');

  // collection reports
  Route::get('/collection/view','CollectionController@index');
  Route::get('/collection/edit/{id}','CollectionController@index');
  Route::get('/collection/create','CollectionController@index');
  Route::get('/collection/reports','CollectionController@index');
  Route::get('/collection/reports/orlisting','CollectionController@reports_orlisting');

  Route::post('/api/collection/get','CollectionController@get');
  Route::post('/api/collection/create','CollectionController@create');
  Route::post('/api/collection/update','CollectionController@update');
  Route::post('/api/collection/delete','CollectionController@delete');
  Route::post('/api/collection/reports/category_summary','CollectionController@reports_orcategorysummary');
  
  // collection_category
  Route::get('/api/collection/category/get','CollectionCategoryController@get');
  Route::post('/api/collection/category/create','CollectionCategoryController@create');

  // expenses
  Route::get('/expense/view','ExpenseController@index');
  Route::get('/expense/create','ExpenseController@index');
  Route::get('/expense/edit/{id}','ExpenseController@index');

  Route::post('/api/expense/get','ExpenseController@get');
  Route::post('/api/expense/create','ExpenseController@create');
  Route::post('/api/expense/update','ExpenseController@update');
  Route::post('/api/expense/delete','ExpenseController@delete');
  Route::get('/api/expense/category/get','ExpenseCategoryController@get');
  Route::post('/api/expense/category/create','ExpenseCategoryController@create');
  Route::post('/api/expense/category/type/create','ExpenseCategoryTypeController@create');
  Route::post('/api/expense/category/type/get','ExpenseCategoryTypeController@get');

  // transaction reports
  Route::get('/transaction/reports/comparative','TransactionController@comparative');
  Route::get('/transaction/reports/currentbalance','TransactionController@currentbalance');

  Route::post('/api/transaction/post','TransactionController@post');
  Route::post('/api/transaction/reports/monthend_posting','TransactionController@monthEndPosting');
  Route::post('/api/transaction/reports/get/monthend_posting','TransactionController@getMonthEndPostingDetails');

  Route::post('/api/user/logout','LoginController@logout');
});
