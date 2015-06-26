<?php

// 學生頁面
Route::group(['namespace' => 'Student'], function()
{
    // 首頁
    get('/', ['as' => 'student.index', 'uses' => 'HomeController@index']);

    // 公告
    get('announcements', ['as' => 'student.announcements.index', 'uses' => 'AnnouncementsController@index']);
    get('announcements/{heading}', ['as' => 'student.announcements.show', 'uses' => 'AnnouncementsController@show']);

    // 認証
    Route::group(['prefix' => 'auth'], function()
    {
        get('login', ['as' => 'student.login', 'uses' => 'AuthController@login']);
        post('/', ['as' => 'student.auth', 'uses' => 'AuthController@auth']);
        get('logout', ['as' => 'student.logout', 'uses' => 'AuthController@logout']);
    });

    Route::group(['middleware' => 'auth:student'], function()
    {
        // 預約
        Route::group(['prefix' => 'test-applies', 'as' => 'student.test-applies.'], function()
        {
            get('apply', ['as' => 'apply', 'uses' => 'TestAppliesController@apply']);
            get('manage', ['as' => 'manage', 'uses' => 'TestAppliesController@manage']);
            get('manage-unite', ['as' => 'manage-unite', 'uses' => 'TestAppliesController@manageUnite']);
            get('history', ['as' => 'history', 'uses' => 'TestAppliesController@history']);
            
            Route::group(['prefix' => 'apply/{id}', 'as' => ''], function()
            {
                post('/', ['as' => 'store', 'uses' => 'TestAppliesController@store']);
                patch('/', ['as' => 'update', 'uses' => 'TestAppliesController@update']);
                delete('/', ['as' => 'destroy', 'uses' => 'TestAppliesController@destroy']);
            });
        });

        // 練習測驗
        Route::group(['prefix' => 'practice-exam', 'as' => 'student.practice-exam.'], function()
        {
            get('/', ['as' => 'index', 'uses' => 'PracticeExamController@index']);
            get('testing/{exam_set_tag}', ['as' => 'testing', 'uses' => 'PracticeExamController@testing']);
            post('result', ['as' => 'result', 'uses' => 'PracticeExamController@result']);
        });

        // 會員中心
        Route::group(['prefix' => 'member', 'as' => 'student.member.'], function()
        {
            get('info', ['as' => 'info', 'uses' => 'MemberController@info']);
            patch('info', ['as' => 'info.update', 'uses' => 'MemberController@info_update']);
        });
    });
});

// 考試頁面
Route::group(['prefix' => 'exam', 'namespace' => 'Exam'], function()
{
    // 認証
    Route::group(['prefix' => 'auth'], function()
    {
        get('login', ['as' => 'exam.login', 'uses' => 'AuthController@login']);
        post('/', ['as' => 'exam.auth', 'uses' => 'AuthController@auth']);
        get('logout', ['as' => 'exam.logout', 'uses' => 'AuthController@logout']);
    });

    Route::group(['middleware' => 'auth:exam'], function()
    {
        get('testing/{ssn}', ['as' => 'exam.testing', 'uses' => 'ExamController@testing']);
        post('testing', ['as' => 'exam.submit', 'uses' => 'ExamController@submit']);
        get('result', ['as' => 'exam.result', 'uses' => 'ExamController@result']);

        resource('panel', 'PanelController', ['only' => ['index', 'show', 'update']]);
    });
});

// 管理頁面
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function()
{
    // 認証
    Route::group(['prefix' => 'auth'], function()
    {
        get('login', ['as' => 'admin.login', 'uses' => 'HomeController@login']);
        post('/', ['as' => 'admin.auth', 'uses' => 'HomeController@auth']);
        get('logout', ['as' => 'admin.logout', 'uses' => 'HomeController@logout']);
    });

    Route::group(['middleware' => 'auth:admin'], function()
    {
        // 首頁
        get('/', ['as' => 'admin.index', 'uses' => 'HomeController@index']);

        // 學生查詢及資料修改
        Route::group(['prefix' => 'student-information', 'as' => 'admin.student-information.'], function()
        {
            get('/', ['as' => 'index', 'uses' => 'StudentInformationController@index']);
            get('search', ['as' => 'search', 'uses' => 'StudentInformationController@search']);
            get('{user}/edit', ['as' => 'edit', 'uses' => 'StudentInformationController@edit']);
            patch('{user}', ['as' => 'update', 'uses' => 'StudentInformationController@update']);
        });

        // 資料同步
        get('sync-student-data', ['as' => 'admin.sync-student-data.index', 'uses' => 'SyncStudentDataController@index']);
        post('sync-student-data', ['as' => 'admin.sync-student-data.execute', 'uses' => 'SyncStudentDataController@execute']);

        // 帳號群組
        resource('account-groups', 'AccountGroupsController');

        // 測驗場次及測驗預約
        Route::group(['prefix' => 'test-lists/{test_lists}', 'as' => 'admin.test-lists.'], function()
        {
            get('apply', ['as' => 'apply', 'uses' => 'TestListsController@apply']);
            post('apply', ['as' => 'apply.store', 'uses' => 'TestListsController@apply_store']);
            delete('{apply_ssn}', ['as' => 'apply.destroy', 'uses' => 'TestListsController@destroy_apply']);
        });
        patch('test-lists', ['as' => 'admin.test-lists.update.all', 'uses' => 'TestListsController@update']);
        resource('test-lists', 'TestListsController', ['except' => ['edit']]);

        // 題庫及題目
        resource('exam-sets', 'ExamSetsController');
        resource('exam-questions', 'ExamQuestionsController', ['except' => ['index']]);
        resource('exam-set-tags', 'ExamSetTagsController');
        Route::group(['prefix' => 'exam-configs'], function()
        {
            get('/', ['as' => 'admin.exam-configs.edit', 'uses' => 'ExamConfigsController@edit']);
            patch('/', ['as' => 'admin.exam-configs.update', 'uses' => 'ExamConfigsController@update']);
        });

        // 試卷
        resource('paper-lists', 'PaperListsController');
        resource('paper-questions', 'PaperQuestionsController', ['only' => ['create', 'store', 'destroy']]);

        // 公告
        delete('announcements/{announcements}/delete-images', ['as' => 'admin.announcements.destroy.images', 'uses' => 'AnnouncementsController@destroy_images']);
        resource('announcements', 'AnnouncementsController');

        // 網站設定
        Route::group(['prefix' => 'website-configs'], function()
        {
            get('/', ['as' => 'admin.website-configs.edit', 'uses' => 'WebsiteConfigsController@edit']);
            patch('/', ['as' => 'admin.website-configs.update', 'uses' => 'WebsiteConfigsController@update']);
            resource('ips', 'WebsiteIpsConfigsController', ['except' => ['show']]);
        });

        // Log
        get('logs', ['as' => 'admin.website-logs.basic', 'uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index']);
        get('website-logs', ['as' => 'admin.website-logs', 'uses' => 'LogViewerController@index']);
    });
});

// 圖片
Route::group(['prefix' => 'images/{ssn}'], function()
{
    get('/', ['as' => 'image', 'uses' => 'ImageController@show']);
    get('s', ['as' => 'image.small', 'uses' => 'ImageController@show_s']);
});

Route::group(['prefix' => 'api', 'namespace' => 'Api'], function()
{
    get('auth/sso', ['as' => 'api.auth.sso', 'uses' => 'AuthSsoController@index']);
});

get('noscript', ['as' => 'noscript', 'uses' => 'ExceptionHandleController@noscript']);
get('browser-not-support', ['as' => 'browser-not-support', 'uses' => 'ExceptionHandleController@browserNotSupport']);