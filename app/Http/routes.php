<?php

Route::group(['namespace' => 'Student'], function()
{
    get('/', ['as' => 'student.index', 'uses' => 'HomeController@index']);

    get('announcements', ['as' => 'student.announcements.index', 'uses' => 'AnnouncementsController@index']);
    get('announcements/{heading}', ['as' => 'student.announcements.show', 'uses' => 'AnnouncementsController@show']);

    Route::group(['prefix' => 'auth'], function()
    {
        get('login', ['as' => 'student.login', 'uses' => 'AuthController@login']);
        post('/', ['as' => 'student.auth', 'uses' => 'AuthController@auth']);
        get('logout', ['as' => 'student.logout', 'uses' => 'AuthController@logout']);
    });

    Route::group(['middleware' => 'auth'], function()
    {
        Route::group(['prefix' => 'test-applies'], function()
        {
            get('apply', ['as' => 'student.test-applies.apply', 'uses' => 'TestAppliesController@apply']);
            get('manage', ['as' => 'student.test-applies.manage', 'uses' => 'TestAppliesController@manage']);
            get('manage-unite', ['as' => 'student.test-applies.manage-unite', 'uses' => 'TestAppliesController@manageUnite']);
            post('apply/{id}', ['as' => 'student.test-applies.store', 'uses' => 'TestAppliesController@store']);
            patch('apply/{id}', ['as' => 'student.test-applies.update', 'uses' => 'TestAppliesController@update']);
            delete('apply/{id}', ['as' => 'student.test-applies.destroy', 'uses' => 'TestAppliesController@destroy']);
            get('history', ['as' => 'student.test-applies.history', 'uses' => 'TestAppliesController@history']);
        });

        Route::group(['prefix' => 'practice-exam'], function()
        {
            get('/', ['as' => 'student.practice-exam.index', 'uses' => 'PracticeExamController@index']);
            get('testing/{exam_set_tag}', ['as' => 'student.practice-exam.testing', 'uses' => 'PracticeExamController@testing']);
            post('result', ['as' => 'student.practice-exam.result', 'uses' => 'PracticeExamController@result']);
        });

        Route::group(['prefix' => 'member'], function()
        {
            get('info', ['as' => 'student.member.info', 'uses' => 'MemberController@info']);
            patch('info', ['as' => 'student.member.info.update', 'uses' => 'MemberController@info_update']);
        });
    });
});

Route::group(['prefix' => 'exam', 'namespace' => 'Exam'], function()
{
    Route::group(['prefix' => 'auth'], function()
    {
        get('login', ['as' => 'exam.login', 'uses' => 'AuthController@login']);
        post('/', ['as' => 'exam.auth', 'uses' => 'AuthController@auth']);
        get('logout', ['as' => 'exam.logout', 'uses' => 'AuthController@logout']);
    });

    Route::group(['middleware' => 'auth'], function()
    {
        get('testing', ['as' => 'exam.testing', 'uses' => 'ExamController@testing']);
        post('submit', ['as' => 'exam.submit', 'uses' => 'ExamController@submit']);
        get('result', ['as' => 'exam.result', 'uses' => 'ExamController@result']);

        get('panel', ['as' => 'exam.panel', 'uses' => 'ExamController@panel']);
    });
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function()
{
    Route::group(['prefix' => 'auth'], function()
    {
        get('login', ['as' => 'admin.login', 'uses' => 'HomeController@login']);
        post('/', ['as' => 'admin.auth', 'uses' => 'HomeController@auth']);
        get('logout', ['as' => 'admin.logout', 'uses' => 'HomeController@logout']);
    });

    Route::group(['middleware' => 'auth'], function()
    {
        get('/', ['as' => 'admin.index', 'uses' => 'HomeController@index']);

        Route::group(['prefix' => 'student-information'], function()
        {
            get('/', ['as' => 'admin.student-information.index', 'uses' => 'StudentInformationController@index']);
            get('search', ['as' => 'admin.student-information.search', 'uses' => 'StudentInformationController@search']);
            get('{user}/edit', ['as' => 'admin.student-information.edit', 'uses' => 'StudentInformationController@edit']);
            patch('{user}', ['as' => 'admin.student-information.update', 'uses' => 'StudentInformationController@update']);
        });
        get('sync-student-data', ['as' => 'admin.sync-student-data.index', 'uses' => 'SyncStudentDataController@index']);
        post('sync-student-data', ['as' => 'admin.sync-student-data.execute', 'uses' => 'SyncStudentDataController@execute']);
        resource('account-groups', 'AccountGroupsController');

        Route::group(['prefix' => 'test-lists/{test_lists}'], function() {
            get('apply', ['as' => 'admin.test-lists.apply', 'uses' => 'TestListsController@apply']);
            post('apply', ['as' => 'admin.test-lists.apply.store', 'uses' => 'TestListsController@apply_store']);
            delete('{apply_ssn}', ['as' => 'admin.test-lists.apply.destroy', 'uses' => 'TestListsController@destroy_apply']);
        });
        resource('test-lists', 'TestListsController', ['except' => ['edit']]);
        patch('test-lists', ['as' => 'admin.test-lists.update.all', 'uses' => 'TestListsController@update']);

        resource('exam-sets', 'ExamSetsController');
        resource('exam-questions', 'ExamQuestionsController', ['except' => ['index']]);
        resource('exam-set-tags', 'ExamSetTagsController');
        Route::group(['prefix' => 'exam-configs'], function()
        {
            get('/', ['as' => 'admin.exam-configs.edit', 'uses' => 'ExamConfigsController@edit']);
            patch('/', ['as' => 'admin.exam-configs.update', 'uses' => 'ExamConfigsController@update']);
        });

        resource('paper-lists', 'PaperListsController');
        resource('paper-questions', 'PaperQuestionsController', ['only' => ['create', 'store', 'destroy']]);

        resource('announcements', 'AnnouncementsController');
        delete('announcements/{announcements}/delete-images', ['as' => 'admin.announcements.destroy.images', 'uses' => 'AnnouncementsController@destroy_images']);

        Route::group(['prefix' => 'website-configs'], function()
        {
            get('/', ['as' => 'admin.website-configs.edit', 'uses' => 'WebsiteConfigsController@edit']);
            patch('/', ['as' => 'admin.website-configs.update', 'uses' => 'WebsiteConfigsController@update']);
            resource('ips', 'WebsiteIpsConfigsController', ['except' => ['show']]);
        });

        get('website-logs', ['as' => 'admin.website-logs', 'uses' => 'LogViewerController@index']);
    });
});

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

get('admin/logs', ['middleware' => 'auth', 'as' => 'admin.website-logs.basic', 'uses' => '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index']);