<?php

// @TODO: add `mod` to `role` key in all `middleware` arrays

Route::group([
    'middleware' => ['domain'],
    'domain' => '{domain}.' .config('app.url')
], function() {
    /*
    |--------------------------------------------------------------------------
    | Homepage Routes
    |--------------------------------------------------------------------------
    |
    | Each subdomain gets it's own unique homepage
    */
    Route::get('/', [
        'as' => 'home',
        function($domain)
        {
            return view("pages.$domain.homepage", [
                'page' => 'home',
                'title' => 'Coaching UP',
                'schools' => App\School::with('classrooms')->get()
            ]);
        }
    ]);
    /*
    |--------------------------------------------------------------------------
    | Page Routes
    |--------------------------------------------------------------------------
    */
    Route::get('faq', function() {
        return view("pages.faq", [
            'page' => 'home',
            'title' => 'FAQ'
        ]);
    });

    Route::get('faq', [
        'as' => 'faq',
        'uses' => 'PagesController@getFaq',
    ]);

    Route::get('help', [
        'as' => 'help',
        'uses' => 'PagesController@getHelp',
    ]);

    Route::get('report-issue', [
        'as' => 'report-issue',
        'uses' => 'PagesController@getReportIssue',
    ]);

    /*
    |--------------------------------------------------------------------------
    | Authentication Routes
    |--------------------------------------------------------------------------
    |
    */
    Route::get('login', [
        'as' => 'login',
        'uses' => 'Auth\AuthController@getLogin',
    ]);

    Route::post('login', 'Auth\AuthController@postLogin');

    Route::get('forgot', [
        'as' => 'forgot',
        'uses' => 'Auth\PasswordController@getForgot',
    ]);

    Route::get('password/set/{token}', [
        'as' => 'reset',
        'uses' => 'Auth\PasswordController@getSet',
    ]);

    Route::get('password/reset/{token}', [
        'as' => 'reset',
        'uses' => 'Auth\PasswordController@getReset',
    ]);

    Route::post('password/email', [
        'uses' => 'Auth\PasswordController@postEmail',
    ]);

    Route::post('password/reset', [
        'uses' => 'Auth\PasswordController@postReset',
    ]);

    Route::get('/logout', [
        'as' => 'logout',
        'uses' => 'Auth\AuthController@getLogout',
    ]);

    Route::get('/signup', [
        'as' => 'signup',
        'uses' => 'Auth\AuthController@getRegister',
    ]);

    Route::post('/signup', 'Auth\AuthController@postRegister');

    /*
    |--------------------------------------------------------------------------
    | Authenticated Routes
    |--------------------------------------------------------------------------
    |
    */
    Route::group([
        'middleware' => ['auth']
    ], function() {

        /*
        |--------------------------------------------------------------------------
        | Dashboard Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/dashboard', [
            'as' => 'dashboard',
            'uses' => 'DashboardController@index',
        ]);

        Route::get('/keepAlive', [
            'as' => 'keepAlive',
            'uses' => 'DashboardController@keepAlive'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Progress Bars
        |--------------------------------------------------------------------------
        |
        /**/
        Route::group(['middleware' => [
            'role:teacher,master_teacher,school_leader,project_admin,super_admin,mod,coach',
            'domain.features:progress-bars'
        ]], function()
        {
            //Route::resource('progress-bars', 'ProgressBarsController');

            Route::get('/progress-bars', [
                'uses' => 'ProgressBarsController@index',
                'as' => 'progress-bars.index'
            ]);

            Route::get('/progress-bars/search', [
                'uses' => 'ProgressBarsController@search',
                'as' => 'progress-bars.search'
            ]);

            Route::get('/progress-bars/show/{id}', [
                'uses' => 'ProgressBarsController@show',
                'as' => 'progress-bars.show'
            ]);

            Route::post('/progress-bars/store', [
                'uses' => 'ProgressBarsController@store',
                'as' => 'progress-bars.store'
            ]);

            Route::post('/progress-bars/updateTemplate', [
                'uses' => 'ProgressBarsController@updateTemplate',
                'as' => 'progress-bars.updateTemplate'
            ]);

            Route::post('/progress-bars/createFromTemplate', [
                'uses' => 'ProgressBarsController@createFromTemplate',
                'as' => 'progress-bars.createFromTemplate'
            ]);

            Route::post('/progress-bars/update', [
                'uses' => 'ProgressBarsController@update',
                'as' => 'progress-bars.update'
            ]);

            Route::post('/progress-bars/destroy', [
                'uses' => 'ProgressBarsController@destroy',
                'as' => 'progress-bars.destroy'
            ]);

            Route::post('/progress-bars/storeStep', [
                'uses' => 'ProgressBarsController@storeStep',
                'as' => 'progress-bars.steps.add'
            ]);

            Route::post('/progress-bars/storeStepAjax', [
                'uses' => 'ProgressBarsController@storeStepAjax',
                'as' => 'progress-bars.steps.add.ajax'
            ]);

            Route::post('/progress-bars/updateStep', [
                'uses' => 'ProgressBarsController@updateStep',
                'as' => 'progress-bars.steps.update'
            ]);

            Route::post('/progress-bars/updateStepAjax', [
                'uses' => 'ProgressBarsController@updateStepAjax',
                'as' => 'progress-bars.steps.update.ajax'
            ]);

            Route::post('/progress-bars/updateStepOrderAjax', [
                'uses' => 'ProgressBarsController@updateStepOrderAjax',
                'as' => 'progress-bars.steps.updateOrder.ajax'
            ]);

            Route::post('/progress-bars/destroyStep', [
                'uses' => 'ProgressBarsController@destroyStep',
                'as' => 'progress-bars.steps.destroy'
            ]);

            Route::post('/progress-bars/fetchStepAjax', [
                'uses' => 'ProgressBarsController@fetchStepAjax',
                'as' => 'progress-bars.steps.fetchAjax'
            ]);

            Route::post('/progress-bars/destroyStepAjax', [
                'uses' => 'ProgressBarsController@destroyStepAjax',
                'as' => 'progress-bars.steps.destroy.ajax'
            ]);

            Route::get('/progress-bars/completeStep/{progressBarId}/{id}', [
                'uses' => 'ProgressBarsController@completeStep',
                'as' => 'progress-bars.steps.completeStep'
            ]);

            Route::get('/progress-bars/startStep/{progressBarId}/{id}', [
                'uses' => 'ProgressBarsController@startStep',
                'as' => 'progress-bars.steps.startStep'
            ]);

            Route::post('/progress-bars/fetchProgressBarAjax', [
                'uses' => 'ProgressBarsController@fetchProgressBarAjax',
                'as' => 'progress-bars.fetchAjax'
            ]);

            Route::get('/api/progress-bars/search-title', [
                'uses' => 'Api\ProgressBarsController@searchTitle',
                'as' => 'progress-bars.search-title'
            ]);

            Route::get('/api/progress-bars/search-author', [
                'uses' => 'Api\ProgressBarsController@searchAuthor',
                'as' => 'progress-bars.search-author'
            ]);

            Route::post('/progress-bars/store-comment/{id}', [
                'as' => 'progress-bars.store-comment',
                'uses' => 'ProgressBarsController@storeComment',
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Activities
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/api/activities/{id}/markReadByUserId', [
            'uses' => 'Api\ActivitiesController@markReadByUserId'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Notifications
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/notifications', [
            'uses' => 'NotificationsController@index',
            'as' => 'notifications.index'
        ]);

        Route::get('/notifications/filter', [
            'uses' => 'NotificationsController@filter',
            'as' => 'notifications.filter'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/permissions', [
            'uses' => 'PermissionsController@index',
            'as' => 'permissions.index'
        ]);

        Route::get('/permissions/{id}/update', [
            'uses' => 'PermissionsController@update',
            'as' => 'permissions.update'
        ]);

        /*
        |--------------------------------------------------------------------------
        | User Shares & Saves
        |--------------------------------------------------------------------------
        |
        */
        Route::post('/share', [
            'uses' => 'UserSharesController@store',
            'as' => 'share'
        ]);

        Route::post('/unshare', [
            'uses' => 'UserSharesController@destroy',
            'as' => 'unshare'
        ]);

        Route::post('/save', [
            'uses' => 'UserSavesController@store',
            'as' => 'save'
        ]);

        Route::post('/unsave', [
            'uses' => 'UserSavesController@destroy',
            'as' => 'unsave'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Request to Delete & Request to Recover
        |--------------------------------------------------------------------------
        |
        */
        Route::post('/request-delete', [
            'uses' => 'DeleteRequestsController@store',
            'as' => 'request-delete'
        ]);

        Route::get('/request-delete/approve/{id}', [
            'uses' => 'DeleteRequestsController@approve',
            'as' => 'request-delete.approve'
        ]);

        Route::get('/request-delete/deny/{id}', [
            'uses' => 'DeleteRequestsController@deny',
            'as' => 'request-delete.deny'
        ]);

        Route::post('/request-recover', [
            'uses' => 'RecoverRequestsController@store',
            'as' => 'request-recover'
        ]);

        Route::get('/request-recover/approve/{id}', [
            'uses' => 'RecoverRequestsController@approve',
            'as' => 'request-recover.approve'
        ]);

        Route::get('/request-recover/deny/{id}', [
            'uses' => 'RecoverRequestsController@deny',
            'as' => 'request-recover.deny'
        ]);

        /*
        |--------------------------------------------------------------------------
        | User Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::group(['middleware' => [
            'role:super_admin',
            'domain.features:users'
        ]], function()
        {
            Route::get('/users', [
                'as' => 'users',
                'uses' => 'UsersController@index',
            ]);

            Route::post('/users', [
                'as' => 'users.store',
                'uses' => 'UsersController@store',
            ]);

            Route::get('/users/{id}/delete', [
                'as' => 'users.delete',
                'uses' => 'UsersController@destroy',
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Cycles Routes
        |--------------------------------------------------------------------------
        |
        */
        /*Route::get('/cycles', [
            'as' => 'cycles',
            'uses' => 'CyclesController@index',
        ]);

        Route::post('/cycles/{id}/storeStep', [
            'uses' => 'CyclesController@storeStep'
        ]);

        Route::group(['middleware' => [
            'role:parent,teacher,master_teacher,school_leader,project_admin,super_admin',
            'domain.features:cycles'
        ]], function()
        {
            Route::resource('cycles', 'CyclesController');

            Route::post('/cycles/{id}/remove', [
                'uses' => 'CyclesController@destroy'
            ]);
        });*/

        /*
        |--------------------------------------------------------------------------
        | Pending Requests Routes
        |--------------------------------------------------------------------------
        */
        /*Route::group(['middleware' => [
            'role:super_admin',
            'domain.features:users'
        ]], function()
        {
            Route::get('/pending-requests', [
                'uses' => 'PendingRequestsController@index',
                'as' => 'pending-requests'
            ]);
        });*/

        /*
        |--------------------------------------------------------------------------
        | Video Center Routes
        |--------------------------------------------------------------------------
        |
        | The video center can be seen by every role apart from parents
        */
        Route::group(['middleware' => [
            'role:teacher,master_teacher,school_leader,project_admin,super_admin,mod,coach',
            'domain.features:video-center'
        ]], function()  {
            Route::post('/video-center/{id}/remove', [
                'uses' => 'VideosController@destroy'
            ]);

            Route::post('/video-center/{id}/documents', [
                'uses' => 'VideoCenter\DocumentsController@store'
            ]);

            Route::post('/video-center/storeColumn', [
                'uses' => 'VideosController@storeColumn',
                'as' => 'video-center.column.store'
            ]);

            Route::post('/video-center/column/addToColumn', [
                'uses' => 'VideosController@storeAddToColumn',
                'as' => 'video-center.column.addTo'
            ]);

            Route::post('/video-center/column/destroyObjectInColumn', [
                'uses' => 'VideosController@destroyObjectInColumn',
                'as' => 'video-center.column.destroy'
            ]);

            Route::post('/video-center/updateColumn', [
                'uses' => 'VideosController@updateColumn',
                'as' => 'video-center.column.update'
            ]);

            Route::get('/video-center/destroyColumn', [
                'uses' => 'VideosController@destroyColumn',
                'as' => 'video-center.column.destroy'
            ]);

            Route::get('/video-center/exemplars', [
                'uses' => 'VideosController@exemplars',
            ]);

            Route::post('/video-center/emailError', [
                'uses' => 'VideosController@emailError',
            ]);

            Route::get('/video-center/search', [
                'uses' => 'VideosController@search',
                'as' => 'video-center.search'
            ]);

            Route::get('/video-center/pending', [
                'uses' => 'VideosController@pending',
            ]);

            Route::get('/video-center/{id}/participant/{participantId}', [
                'uses' => 'VideosController@show',
                'as' => 'video-center.show.participant'
            ]);

            Route::resource('video-center', 'VideosController');

            Route::post('/video-center/{id}/update', [
                'uses' => 'VideosController@update',
                'as' => 'video-center.update'
            ]);

            Route::post('/video-center/{id}/destroy', [
                'uses' => 'VideosController@destroy',
                'as' => 'video-center.destroy'
            ]);

            Route::get('/video-center/author/{id}', [
                'uses' => 'VideosController@listVideosByAuthorId',
                'as' => 'video-center.author'
            ]);

            Route::get('/api/video-center', [
                'uses' => 'Api\VideosController@index'
            ]);

            Route::get('/api/video-center/search-title', [
                'uses' => 'Api\VideosController@searchTitle'
            ]);

            Route::get('/api/video-center/search-author', [
                'uses' => 'Api\VideosController@searchAuthor'
            ]);

            Route::get('/api/video-center/{id}/participants', [
                'uses' => 'Api\Videos\ParticipantsController@index'
            ]);

            Route::get('/api/video-center/{id}/tags', [
                'uses' => 'Api\Videos\TagsController@index'
            ]);

            Route::put('/api/video-center/{id}', [
                'uses' => 'Api\VideosController@update'
            ]);

            Route::post('/api/video-center/{id}/comments', [
                'uses' => 'Api\Videos\CommentsController@store',
                'as' => 'api.video-center.comments.store'
            ]);

            Route::delete('/api/video-center/{id}/comments', [
                'uses' => 'Api\Videos\CommentsController@destroy',
                'as' => 'api.video-center.comments.destroy'
            ]);

            Route::post('/video-center/{id}/documents', [
                'uses' => 'VideoCenter\DocumentsController@store'
            ]);

            Route::post('/api/video-center/{id}/annotations', [
                'uses' => 'Api\Videos\AnnotationsController@store',
                'as' => 'api.video-center.annotations.store'
            ]);

            Route::post('/video-center/{id}/exemplar', [
                'uses' => 'VideoCenter\ExemplarsController@store',
            ]);

            Route::put('/video-center/{id}/exemplar', [
                'uses' => 'VideoCenter\ExemplarsController@update',
            ]);

            Route::delete('/video-center/{id}/exemplar', [
                'uses' => 'VideoCenter\ExemplarsController@destroy',
            ]);

            Route::get('/api/resources/{id}/resource_types', [
                'uses' => 'Api\ResourcesController@resource_types'
            ]);

            Route::get('/api/video-center/{id}/annotations', [
                'uses' => 'Api\AnnotationsController@showAnnotations',
                'as' => 'api.video-center.annotations.showAnnotations'
            ]);

            // Create discussion
            Route::post('/video-center/{id}/discussion', [
                'uses' => 'VideoDiscussionsController@store',
                'as' => 'video.discussion.store'
            ]);

            // Update discussion
            Route::post('/video-center/discussion/{id}/update', [
                'uses' => 'VideoDiscussionsController@update',
                'as' => 'video.discussion.update'
            ]);

            // Delete discussion
            Route::delete('/video-center/discussion/{id}/destroy', [
                'uses' => 'VideoDiscussionsController@destroy'
            ]);

            // Delete answer
            Route::delete('/video-center/discussion/answer/{id}/destroy', [
                'uses' => 'VideoDiscussionsController@destroyAnswer',
                'as' => 'video.discussion.answer.destroy'
            ]);

            // Reply to discussion ("answer" the questions)
            Route::post('/video-center/{id}/discussion/respond', [
                'uses' => 'VideoDiscussionsController@storeResponse',
                'as' => 'video.discussion.respond'
            ]);

            // Reply to discussion ("answer" the questions) but save as a draft
            Route::post('/video-center/{id}/discussion/saveDraft', [
                'uses' => 'VideoDiscussionsController@storeSaveDraft',
                'as' => 'video.discussion.saveDraft'
            ]);

            // Reply to discussion answers ("comment" on the answer)
            Route::post('/video-center/{id}/discussion/respondToAnswer', [
                'uses' => 'VideoDiscussionsController@storeResponseToAnswer',
                'as' => 'video.discussion.respondToAnswer'
            ]);

            Route::get('/api/discussions', [
                'uses' => 'Api\VideosController@showDiscussions'
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Message Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::group(['middleware' => [
            'role:parent,teacher,master_teacher,school_leader,project_admin,super_admin,mod,coach',
            'domain.features:messages'
        ]], function()
        {

            Route::get('/messages/search', [
                'uses' => 'MessagesController@search',
                'as' => 'messages.search'
            ]);

            Route::resource('messages', 'MessagesController');

            Route::get('/messages/export/{id}', [
                'uses' => 'MessagesController@export',
                'as' => 'messages.export'
            ]);

            Route::post('/messages/{id}/remove', [
                'uses' => 'MessagesController@destroy'
            ]);

            Route::get('/api/messages/{id}/participants', [
                'uses' => 'Api\Messages\ParticipantsController@index'
            ]);

            Route::get('/api/messages', [
                'uses' => 'Api\MessagesController@index'
            ]);

            Route::put('/api/messages/{id}', [
                'uses' => 'Api\MessagesController@update'
            ]);

            Route::post('/api/messages/{id}/comments', [
                'uses' => 'Api\Messages\CommentsController@store',
                'as' => 'api.messages.comments.store'
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Instructional Design Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::group(['middleware' => [
            'role:teacher,master_teacher,school_leader,project_admin,super_admin,mod,coach',
            'domain.features:instructional-design'
        ]], function()
        {
            Route::get('/instructional-design/exemplars', [
                'uses' => 'InstructionalDesignController@exemplars',
            ]);

            Route::get('instructional-design/download/{id}', [
                'as' => 'instructional-design.download',
                'uses' => 'InstructionalDesignController@download'
            ]);

            Route::resource('instructional-design', 'InstructionalDesignController');

            Route::post('/instructional-design/{id}/remove', [
                'uses' => 'InstructionalDesignController@destroy'
            ]);

            Route::post('/instructional-design/{id}/documents', [
                'uses' => 'InstructionalDesign\DocumentsController@store'
            ]);

            Route::post('/instructional-design/{id}/storeLessonPlan', [
                'uses' => 'InstructionalDesign\DocumentsController@storeLessonPlan'
            ]);

            Route::post('/instructional-design/{id}/exemplar', [
                'uses' => 'InstructionalDesign\ExemplarsController@store',
            ]);

            Route::put('/instructional-design/{id}/exemplar', [
                'uses' => 'InstructionalDesign\ExemplarsController@update',
            ]);

            Route::delete('/instructional-design/{id}/exemplar', [
                'uses' => 'InstructionalDesign\ExemplarsController@destroy',
            ]);

            Route::get('/api/instructional-design/{id}/participants', [
                'uses' => 'Api\InstructionalDesign\ParticipantsController@index'
            ]);

            Route::get('/api/instructional-design', [
                'uses' => 'Api\InstructionalDesignController@index'
            ]);

            Route::post('/api/instructional-design/{id}/comments', [
                'uses' => 'Api\InstructionalDesign\CommentsController@store',
                'as' => 'api.instructional-design.comments.store'
            ]);

            Route::post('/api/instructional-design/{id}/activityComments', [
                'uses' => 'Api\InstructionalDesign\CommentsController@storeActivityComment',
                'as' => 'api.instructional-design.comments-activity.store'
            ]);

            Route::get('/api/instructional-design/{id}/tags', [
                'uses' => 'Api\InstructionalDesign\TagsController@index'
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Document Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::delete('/api/documents/{id}', [
            'as' => 'document.destroy',
            'uses' => 'Api\DocumentsController@destroy'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Annotation Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::post('/api/annotations/{id}', [
            'uses' => 'Api\AnnotationsController@update'
        ]);

        Route::delete('/api/annotations/{id}', [
            'uses' => 'Api\AnnotationsController@destroy'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Profile Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/profile/{id}/activity/', [
            'as' => 'activity',
            'uses' => 'ProfileController@activity',
        ]);

        Route::get('/profile/{id}/activity/authored', [
            'as' => 'activity.authored',
            'uses' => 'ProfileController@authoredActivity',
        ]);

        Route::get('/profile/{id}', [
            'as' => 'profile',
            'uses' => 'ProfileController@index',
        ]);

        Route::get('/profile/{id}/edit/', [
            'as' => 'profile.edit',
            'uses' => 'ProfileController@edit',
        ]);

        Route::post('/profile/{id}/update-avatar/', [
            'as' => 'update-avatar',
            'uses' => 'ProfileController@updateAvatar',
        ]);

        Route::post('/profile/{id}/update/', [
            'as' => 'update-profile',
            'uses' => 'ProfileController@updateProfile',
        ]);

        Route::post('/profile/{id}/update-password/', [
            'as' => 'update-password',
            'uses' => 'ProfileController@updatePassword',
        ]);

        Route::get('/profile/{id}/acitivty/authored', [
            'as' => 'authored-activity',
            'uses' => 'ProfileController@showAuthoredActivity',
        ]);

        Route::get('/profile/{id}/teacher-list/', [
            'as' => 'teacher-list-selected',
            'uses' => 'TeacherSelectController@showAllSelected',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Learning Module Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/learning-modules', [
            'as' => 'learningModules',
            'uses' => 'LearningModulesController@showAll',
        ]);
        Route::group(['middleware' => [
            'role:teacher,master_teacher,school_leader,project_admin,super_admin,mod,coach',
            'domain.features:learning-modules'
        ]], function()
        {
            Route::resource('learning-modules', 'LearningModulesController');

            Route::get('/api/learning-modules', [
                'uses' => 'Api\LearningModulesController@index'
            ]);

            Route::post('/learning-modules/{id}/remove', [
                'uses' => 'LearningModulesController@destroy'
            ]);

            Route::post('/learning-modules/{id}/documents', [
                'uses' => 'LearningModules\DocumentsController@store'
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Resources Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/resources', [
            'as' => 'resources',
            'uses' => 'ResourcesController@index',
        ]);

        Route::get('/api/resources', [
            'uses' => 'Api\ResourcesController@index'
        ]);


        Route::group(['middleware' => [
            'role:parent,teacher,master_teacher,school_leader,project_admin,super_admin,mod,coach',
            'domain.features:resources'
        ]], function() {



            /*Route::get('/resources', [
                'as' => 'resources.index',
                'uses' => 'ResourcesController@index'
            ]);*/

            Route::get('/resources/show/{id}', [
                'as' => 'resources.show',
                'uses' => 'ResourcesController@show',
            ]);

            Route::post('/resources/update/{id}', [
                'as' => 'resources.update',
                'uses' => 'ResourcesController@update',
            ]);

            Route::post('/resources/delete/{id}', [
                'as' => 'resources.delete',
                'uses' => 'ResourcesController@destroy',
            ]);

            Route::get('/resources/search', [
                'as' => 'resources.search',
                'uses' => 'ResourcesController@search',
            ]);

            Route::post('/resources/makeResource/{id}', [
                'as' => 'resources.makeResource',
                'uses' => 'ResourcesController@makeResource',
            ]);

            Route::get('/resources/make-public/{id}', [
                'as' => 'resources.make-public',
                'uses' => 'ResourcesController@makePublic',
            ]);

            Route::post('/resources/store-comment/{id}', [
                'as' => 'resources.store-comment',
                'uses' => 'ResourcesController@storeComment',
            ]);

            Route::resource('resource', 'ResourcesController');

            Route::get('/resources/{category}/{type}', [
                'uses' => 'ResourcesController@resourcesByCategory'
            ]);

            Route::get('/resources/{category}/{type}/{id}', [
                'uses' => 'ResourcesController@showByCategory'
            ]);

            Route::post('/resources/{category}/{type}/{id}/remove', [
                'uses' => 'ResourcesController@destroy'
            ]);

            Route::put('/resources/{category}/{type}/{id}', [
                'uses' => 'ResourcesController@update'
            ]);

            /*Route::post('/resources/search', [
                'uses' => 'ResourcesController@search',
                'as' => 'resources.search'
            ]);*/

        });

        /*
        |--------------------------------------------------------------------------
        | API Routes
        |--------------------------------------------------------------------------
        |
        */
        Route::get('/api/', [
            'as' => 'api-front',
            'uses' => 'ApiController@get',
        ]);

        Route::get('/api/participants', [
            'uses' => 'Api\ParticipantsController@index'
        ]);

        Route::get('/api/participants/exclude', [
            'uses' => 'Api\ParticipantsController@exclude'
        ]);

        Route::post('/api/participants/destroy', [
            'uses' => 'Api\ParticipantsController@destroyParticipant',
            'as' => 'api.participant.destroy'
        ]);

        Route::get('/api/users', [
            'uses' => 'ApiController@listTeachers',
        ]);

        Route::get('/medium/delete', [
            'uses' => 'ApiController@deleteFile',
        ]);

        Route::get('/medium/upload', [
            'uses' => 'ApiController@uploadFile',
        ]);

        Route::get('/api/tags', [
            'uses' => 'Api\TagsController@index'
        ]);

        Route::get('/api/tags', [
            'uses' => 'Api\TagsController@index'
        ]);
    });
});
