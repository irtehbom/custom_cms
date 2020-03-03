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

Route::get('/', 'Auth\LoginController@index')->name('login');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Auth::routes();

Route::get('/dashboard/addleads', 'LeadsController@index')->name('addLead');
Route::post('/dashboard/addleads', 'LeadsController@save')->name('addLeadSave');

//Project Management

Route::get('/dashboard/projects/all', 'ProjectsController@all')->name('projectsAll');
Route::get('/dashboard/projects/create', 'ProjectsController@create')->name('projectsCreate');
Route::post('/dashboard/projects/create', 'ProjectsController@save')->name('projectsSave');
Route::get('/dashboard/projects/edit/{id}', 'ProjectsController@edit')->name('projectsEdit');
Route::post('/dashboard/projects/edit/{id}', 'ProjectsController@editSave')->name('projectsEditSave');
Route::get('/dashboard/projects/delete/{id}', 'ProjectsController@deleteObject')->name('projectsDelete');

//Users

Route::get('/dashboard/users/all', 'UserController@all')->name('usersAll');
Route::get('/dashboard/users/create', 'UserController@create')->name('usersCreate');
Route::post('/dashboard/users/create', 'UserController@save')->name('usersSave');
Route::get('/dashboard/users/edit/{id}', 'UserController@edit')->name('usersEdit');
Route::post('/dashboard/users/edit/{id}', 'UserController@editSave')->name('usersEditSave');
Route::get('/dashboard/users/delete/{id}', 'UserController@deleteObject')->name('usersDelete');
Route::get('/dashboard/user/{id}/create_password', 'UserController@usersCreatePassword')->name('usersCreatePassword');
Route::post('/dashboard/user/{id}/create_password', 'UserController@usersCreatePasswordSave')->name('usersPasswordSave');

//Single Projects

Route::get('/dashboard/project/{id}/overview', 'SingleProjectsController@overview')->name('singleProjectOverview');
Route::get('/dashboard/project/{id}/messages', 'SingleProjectsController@messages')->name('singleProjectMessages');
Route::get('/dashboard/project/{id}/time', 'SingleProjectsController@time')->name('singleProjectTime');
Route::get('/dashboard/project/{id}/qa/{qa_id}', 'SingleProjectsController@qaView')->name('qaView');
Route::get('/dashboard/project/{id}/files', 'SingleProjectsController@filesView')->name('filesView');
Route::get('/dashboard/project/{id}/citations/{citations_id}', 'SingleProjectsController@citationsView')->name('citationsView');
Route::get('/dashboard/project/{id}/guest-post-pipeline/overview', 'SingleProjectsController@GuestPostingPipelineOverview')->name('GuestPostingPipelineOverview');
Route::get('/dashboard/project/{id}/guest-post-pipeline/sourcing-analysing', 'SingleProjectsController@GuestPostingPipelineSourcingAnalysing')->name('GuestPostingPipelineSourcingAnalysing');
Route::get('/dashboard/project/{id}/guest-post-pipeline/outreach', 'SingleProjectsController@GuestPostingPipelineOutreachView')->name('GuestPostingPipelineOutreachView');

//Single Project Messages
Route::get('/dashboard/project/{id}/messages/create', 'MessagesController@create')->name('singleProjectMessagesCreate');
Route::post('/dashboard/project/{id}/messages/create', 'MessagesController@createSave')->name('singleProjectMessagesCreateSave');
Route::get('/dashboard/project/{id}/messages/{thread_id}', 'MessagesController@viewThread')->name('singleProjectMessagesViewThread');
Route::post('/dashboard/project/{id}/messages/{thread_id}', 'MessagesController@saveThread')->name('singleProjectMessagesThreadSave');
Route::post('/dashboard/project/{id}/messages/{thread_id}/edit', 'MessagesController@saveThreadEditMessage')->name('singleProjectMessagesEdit');

//Time Entries
Route::get('/dashboard/project/{id}/time/create', 'TimeController@create')->name('timeCreateView');
Route::post('/dashboard/project/{id}/time/create', 'TimeController@createSave')->name('timeCreateSave');
Route::get('/dashboard/project/{id}/time/edit/{time_id}', 'TimeController@edit')->name('timeEdit');
Route::post('/dashboard/project/{id}/time/edit/{time_id}', 'TimeController@editSave')->name('timeEditSave');
Route::get('/dashboard/project/{id}/time/delete/{time_id}', 'TimeController@delete')->name('timeDelete');
Route::get('/dashboard/timetracker', 'TimeController@timeTracker')->name('timeTracker');

//GuestPostingPipeline
Route::get('/dashboard/project/{id}/guest-post-pipeline/sourcing-analysing/add', 'GuestPostingPipelineController@sourcingAddView')->name('GuestPostingPipelineSourcingAdd');
Route::post('/dashboard/project/{id}/guest-post-pipeline/sourcing-analysing/add', 'GuestPostingPipelineController@sourcingAddSave')->name('GuestPostingPipelineSourcingSave');
Route::post('/dashboard/project/{id}/guest-post-pipeline/sourcing-analysing/', 'GuestPostingPipelineController@sourcingAjax')->name('GuestPostingPipelineSourcingAjax');
Route::post('/dashboard/project/{id}/guest-post-pipeline/outreach/domain-notes-save', 'GuestPostingPipelineController@saveDomainNotes')->name('saveDomainNotes');
Route::post('/dashboard/project/{id}/guest-post-pipeline/outreach/save-domain-details', 'GuestPostingPipelineController@saveDomainDetails')->name('saveDomainDetails');


//files
Route::post('/dashboard/project/{id}/files', 'FilesController@fileUploadFilesView')->name('fileUploadFilesView');
Route::post('/dashboard/project/{id}/files/delete/', 'FilesController@fileDelete')->name('fileDelete');

//All activity for WS
Route::get('/dashboard/overview/', 'DashboardController@allActivityOverview')->name('allActivityOverview');

//Planning
Route::get('/dashboard/planning/', 'DashboardController@planningView')->name('planningView');
Route::post('/dashboard/planning/', 'DashboardController@planningViewSave')->name('planningViewSave');

Route::get('/oauth/gmail', function (){
    return LaravelGmail::redirect();
});

Route::get('/oauth/gmail/callback', function (){
    LaravelGmail::makeToken();
    return redirect()->to('/');
});

Route::get('/oauth/gmail/logout', function (){
    LaravelGmail::logout(); //It returns exception if fails
    return redirect()->to('/');
});