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

Route::pattern('id', '\d+');
Route::pattern('applicationId', '\d+');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/** AEC */
Route::get('admin', 'AecController@index')->middleware(['auth']);
Route::get('index', 'AecController@index')->middleware(['auth']);

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

    /** 用户 */
    Route::resource('user', 'UserController');

    /** 角色 */
    Route::resource('role', 'RoleController');

    /** 权限 */
    Route::resource('permission', 'PermissionController');

    /** 学校 */
    Route::resource('school', 'SchoolController');

    /** Student */
    Route::resource('student', 'StudentController');

    /** 教师 */
    Route::resource('teacher', 'TeacherController');

    /** 考试机构 */
    Route::resource('studio', 'StudioController');

    /** 申请人 */
    Route::resource('applicant', 'ApplicantController');

    /** 申请 */
    Route::resource('application', 'ApplicationController');

    /** part A */
    Route::resource('part_a', 'PartAController');

    /** Part B */
    Route::resource('part_b', 'PartBController');

    /** Part C */
    Route::resource('part_c', 'PartCController');

    /** Part C Teacher */
    Route::resource('part_c_teacher', 'PartCTeacherController');

    /** Part D */
    Route::resource('part_d', 'PartDController');

    /** Part E */
    Route::resource('part_e', 'PartEController');

    /** Part F */
    Route::resource('part_f', 'PartFController');

    /** Exam */
    Route::resource('exam', 'ExamController');

    /** Section */
    Route::resource('section', 'SectionController');

    /** Group */
    Route::resource('group', 'GroupController');

    /** Group */
    Route::resource('item', 'ItemController');

    /** Export */
    Route::any('export/{id}', 'ExportController@export');

});
