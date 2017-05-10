<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['prefix' => 'v1', 'middleware' => 'web'], function () {
	Route::post('/login', ['as' => 'user.login', 'uses' => 'UserController@login']);
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth'], function () {
	Route::get('/logout', ['as' => 'user.logout', 'uses' => 'UserController@logout']);
});

Route::group(['prefix' => 'v1', 'middleware' => 'admin'], function () {
	Route::group(['prefix' => 'user'], function () {
		Route::post('register', 'UserController@create');
		Route::get('list', 'UserController@users');
		Route::get('edit/{id}', 'UserController@get');
		Route::post('edit/{id}', 'UserController@update');
		Route::get('delete/{id}', 'UserController@delete');
	});

	Route::group(['prefix' => 'generate'], function() {
		Route::post('survey', 'GenerateSurveysController@getExcel');
	});

	Route::group(['prefix' => 'template'], function () {
		Route::get('/list', 'TemplateController@index');
		Route::get('/{id}', 'TemplateController@get');
		Route::post('/create', 'TemplateController@create');
		Route::get('/edit/{id}', 'TemplateController@get_edit');
		Route::post('/edit/{id}', 'TemplateController@edit');
		Route::get('/delete/{id}', 'TemplateController@delete');
		Route::post('/setDefautl/{id}', 'TemplateController@saveDefaultTemplate');
	});

	Route::group(['prefix' => 'survey'], function () {
		Route::get('/list', 'SurveyController@index');
		Route::get('/{id}', 'SurveyController@get');
		Route::post('/create', 'SurveyController@create');
		Route::get('/edit/{id}', 'SurveyController@get_edit');
		Route::post('/edit/{id}', 'SurveyController@edit');
		Route::get('/delete/{id}', 'SurveyController@delete');
	});

	Route::get('/surveys', 'UserController@surveys');
	Route::get('/notifications', 'UserController@notifications');
	Route::group(['prefix' => 'department'], function() {
		Route::get('list', 'DepartmentController@index');
		Route::get('create', 'DepartmentController@get_create');
		Route::post('create', 'DepartmentController@post_create');
		Route::get('edit/{id}', 'DepartmentController@get_edit');
		Route::post('edit/{id}', 'DepartmentController@post_edit');
		Route::get('delete/{id}', 'DepartmentController@delete');
	});
});

Route::group(['prefix' => 'v1', 'middleware' => 'student'], function () {
	Route::group(['prefix' => 'student'], function () {
		Route::get('getStudentSurveys/{id}', 'StudentController@getStudentSurveys');
		Route::get('getSurvey/{id}', 'StudentController@getSurvey');
		Route::post('submitSurvey/{id}', 'StudentController@submitSurvey');
	});
});

Route::group(['prefix' => 'v1', 'middleware' => 'staff'], function () {
	Route::group(['prefix' => 'staff'], function () {
		Route::get('getTeacherSurveys/{id}', 'TeacherController@getTeacherSurveys');
		Route::get('getSurvey/{id}', 'TeacherController@getSurvey');
		Route::get('getTeacherInfo/{id}', 'TeacherController@getTeacherInfo');
	});
});