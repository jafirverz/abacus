<?php

use Illuminate\Http\Response;
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

Route::get('/clear', function () {
    $exitCode2 = \Illuminate\Support\Facades\Artisan::call('cache:clear');
    $exitCode4 = \Illuminate\Support\Facades\Artisan::call('config:clear');
    $exitCode1 = \Illuminate\Support\Facades\Artisan::call('route:clear');
    $exitCode3 = \Illuminate\Support\Facades\Artisan::call('view:clear');
    return '<h1>CLEARED All </h1>';
});

Route::get('/updateapp', function()
{
    exec('composer dump-autoload');
    echo 'composer dump-autoload complete';
});


Route::get('/notification', function () {
    $exitCode2 = \Illuminate\Support\Facades\Artisan::call('notify:users');
    return $exitCode2;
});

Route::get('/cron/competiton-result', function () {
    $exitCode2 = \Illuminate\Support\Facades\Artisan::call('competition:results');
    return $exitCode2;
});
Route::get('/cron-test-reminder', function () {
    $exitCode2 = \Illuminate\Support\Facades\Artisan::call('instructor:reminder');
    return $exitCode2;
});

Route::get('/storage-link', function () {
    $exitCode2 = \Illuminate\Support\Facades\Artisan::call('storage:link');
    return $exitCode2;
});

Auth::routes(['verify' => true]);

Auth::routes();
Route::get('/', 'PagesFrontController@index');
Route::post('/country/instructor', 'Auth\RegisterController@instructor')->name('country.instructor');
Route::get('/forget-account-id', 'Auth\LoginController@forgetaccountid');
Route::post('/forget-account-id', 'Auth\LoginController@checkaccountid')->name('forgetaccountid');

Route::get('/forget-password', 'Auth\ForgotPasswordController@showForm');
Route::post('/forget-password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('forgetpassword');

//Route::get('/reset-password/{token}', 'Auth\ResetPasswordController@showResetForm');

Route::get('/home', 'PagesFrontController@index')->name('home');
Route::get('/instructor/{slug?}', 'PagesFrontController@instructor')->name('instructor.overview');

Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('login');


Route::get('/level/{slug?}', 'LevelController@index');

Route::get('/worksheet/{worksheetId?}/qId/{qid?}/lId/{lId?}', 'WorksheetController@index');
Route::post('/worksheet/result', 'WorksheetController@resultpage')->name('answer.submit');

Route::get('/leaderboard/{levelid?}/{worksheetId?}', 'WorksheetController@leaderboard');


Route::get('/competition/{id?}', 'CompetitionController@index');

Route::get('/competition-paper/{id?}', 'CompetitionController@paper');
Route::post('/competition-paper/submit', 'CompetitionController@submitPaper')->name('competition.submit');


Route::get('/online-student/feedback', 'OnlineStudentController@feedback')->name('feedback');
Route::post('/online-student/feedback', 'OnlineStudentController@feedbackstore')->name('feedback.submit');
Route::get('/online-student/my-course', 'OnlineStudentController@my_course')->name('my-course');
Route::get('/online-student/my-course/detail/{id?}', 'OnlineStudentController@detail_course')->name('my-course.detail');
Route::post('/online-student/my-course/result', 'OnlineStudentController@submit_course')->name('course.answer.submit');

Route::get('/instructor-students', 'ProfileController@studentlist')->name('instructor.my-students');
Route::get('/announcements/{id?}', 'ProfileController@download_all_announcements')->name('instructor.download_all_announcements');
Route::get('/add-material', 'ProfileController@add_material')->name('instructor.add-material');
Route::post('instructor-content-update', 'ProfileController@instructor_content_update')->name('instructor-content.update');
Route::post('/add-material', 'ProfileController@store_add_material');
Route::get('/add-students', 'ProfileController@add_students')->name('instructor.add-students');
Route::post('/add-students', 'ProfileController@store_add_students')->name('instructor.add-students');
Route::get('/students/edit/{id?}', 'ProfileController@edit_students')->name('instructor.add-students.edit');
Route::get('/students/view/{id?}', 'ProfileController@view_students')->name('instructor.students.view');
Route::get('/students/approve/{id?}', 'ProfileController@approve_students')->name('instructor.students.approve');
Route::post('/students/approve/{id?}', 'ProfileController@update_approved_students')->name('instructor.students.approve.update');
Route::post('/add-students/edit/{id?}', 'ProfileController@update_students')->name('instructor.add-students.update');
Route::get('/add-students/delete/{id?}', 'ProfileController@delete_students')->name('instructor.add-students.delete');


Route::get('/online-student/about-3g-abacus', 'OnlineStudentController@aboutPage')->name('about-page-online');
Route::get('/instructor-competition', 'ProfileController@competition')->name('instructor-competition');
Route::get('/instructor-competition/register/{competition_id?}', 'ProfileController@competition_register_instructor')->name('instructor.register');
Route::post('/instructor-competition/register/{competition_id?}', 'ProfileController@competition_register_instructor_store')->name('competition.instructor.register.submit');
Route::get('/instructor-competition/register/delete/{id?}', 'ProfileController@delete_instructor_competition')->name('competition.instructor.register.delete');
Route::get('/instructor-competition/register/edit/{id?}', 'ProfileController@edit_instructor_competition')->name('competition.instructor.register.edit');
Route::post('/instructor-competition/register/edit/{id?}', 'ProfileController@update_instructor_competition')->name('competition.instructor.register.update');

//TEST
Route::get('/my-test/detail/{id?}', 'ProfileController@detail_test')->name('test.detail');
Route::post('/my-test/result', 'ProfileController@submit_test')->name('test.answer.submit');
Route::get('/survey-form', 'SurveyController@index');
Route::post('/survey-form/submit', 'SurveyController@store')->name('survey.submit');
Route::get('/standalone-page', 'StandalonePageController@index');
//Route::post('/standalone-page', 'StandalonePageController@checkanswer');
Route::post('/standalone-page/result', 'StandalonePageController@result');

Route::get('/achievements', 'ProfileController@achievements')->name('normal.achievements');
Route::get('/achievements/{id?}', 'ProfileController@my_achievements')->name('normal.my-achievements');

Route::get('/membership', 'ProfileController@membership')->name('membership');

Route::get('/cart/{id?}', 'ProfileController@cartList')->name('cartlist');
Route::get('/cart/delete/all', 'ProfileController@cartListDelete')->name('delete.cart');
Route::post('/cart/delete', 'ProfileController@cartListClear')->name('clear.cart');
Route::post('/cart', 'ProfileController@cart')->name('cart');
Route::get('/cart', 'ProfileController@cart')->name('cart');


Route::get('/checkout', 'ProfileController@checkout');

Route::get('about-us', 'GuestUserController@aboutUs')->name('about-us');
Route::get('privacy-policy', 'GuestUserController@privacy')->name('privacy-policy');
Route::get('faqs', 'GuestUserController@faq')->name('faqs');
Route::get('terms-of-use', 'GuestUserController@termsofuse')->name('terms-of-use');
Route::get('standalonepage', 'GuestUserController@standalonepage')->name('standalonepage');
Route::post('standalonepage/result', 'GuestUserController@standalonepageresult')->name('standalonepageresult');


Route::get('payament/error', 'PayPalController@errorPayment')->name('errorTransaction');
Route::get('payament/success', 'PayPalController@successPayment')->name('successTransactionn');
Route::get('create-transaction', 'PayPalController@createTransaction')->name('createTransaction');
Route::post('process-transaction', 'PayPalController@processTransaction')->name('processTransaction');
Route::get('success-transaction', 'PayPalController@successTransaction')->name('successTransaction');
Route::get('cancel-transaction', 'PayPalController@cancelTransaction')->name('cancelTransaction');


// ************ ACCOUNT/PROFILE *******************/
Route::get('instructor-overview', 'ProfileController@instructor_overview')->name('instructor.overview');
Route::get('my-profile', 'ProfileController@index')->name('my-profile');
Route::get('instructor-profile', 'ProfileController@instructor')->name('instructor-profile');
Route::post('instructor-profile', 'ProfileController@instructor_store')->name('instructor-profile.update');
Route::post('instructor-profile-cal', 'ProfileController@cal_store')->name('instructor-profile.cal_update');
Route::get('grading-overview/{id?}', 'ProfileController@grading_overview')->name('grading-overview');
Route::post('grading-overview/result', 'GradingSubmitController@resultpage')->name('grading_answer.submit');
Route::get('download-grading-certificate/{id?}', 'GradingSubmitController@downloadCertificate')->name('grading.downloadCertificate');
Route::get('grading-examination', 'ProfileController@grading_examination')->name('grading-examination');
Route::get('grading-examination/delete/{id?}', 'ProfileController@delete_grading')->name('grading-examination.delete');
Route::get('grading-examination/edit/{id?}', 'ProfileController@edit_grading')->name('grading-examination.edit');
Route::post('grading-examination/edit/{id?}', 'ProfileController@update_grading')->name('grading-examination.update');
Route::get('grading-examination/view/{id?}', 'ProfileController@view_grading')->name('grading-examination.view');
Route::get('grading-examination', 'ProfileController@grading_examination')->name('grading-examination');
Route::get('register-grading-examination/{id?}', 'ProfileController@register_grading_examination')->name('register-grading-examination');
Route::post('register-grading-examination/submit', 'ProfileController@grading_register_store')->name('register-grading-examination.submit');
Route::get('grading-overview/{grading_exam_id?}/{listing_id?}/{paper_id?}', 'ProfileController@grading_paper');
Route::get('competition-overview', 'ProfileController@competition_overview')->name('competition-overview');

Route::get('allocation', 'ProfileController@allocation')->name('allocation');
Route::get('allocation/test/delete/{id?}', 'ProfileController@allocation_test_delete');
Route::get('allocation/test/{id?}', 'ProfileController@allocation_test');
Route::get('allocation/survey/delete/{id?}', 'ProfileController@allocation_survey_delete');
Route::post('allocation/survey/{id?}', 'ProfileController@survey_store')->name('survey.update');
Route::post('allocation/test/{id?}', 'ProfileController@allocation_store')->name('allocation.update');
Route::get('allocation/survey/{id?}', 'ProfileController@allocation_survey');
Route::get('teaching-materials', 'ProfileController@teaching_materials')->name('teaching-materials');

Route::post('my-profile', 'ProfileController@store')->name('my-profile.update');

Route::post('external-profile', 'ExternalAccountController@external_store')->name('external-profile.update');
Route::get('external-profile/my-students', 'ExternalAccountController@my_students')->name('external-profile.my-students');
Route::get('external-profile/add-students', 'ExternalAccountController@add_students')->name('external-profile.add-students');
Route::post('external-profile/add-students', 'ExternalAccountController@store_add_students')->name('external-profile.add-students');
Route::get('external-profile/add-students/edit/{id?}', 'ExternalAccountController@edit_students')->name('external-profile.add-students.edit');
Route::get('external-profile/students/view/{id?}', 'ExternalAccountController@view_students')->name('external-profile.students.view');
Route::post('external-profile/add-students/edit/{id?}', 'ExternalAccountController@update_students')->name('external-profile.add-students.update');
Route::get('external-profile/add-students/delete/{id?}', 'ExternalAccountController@delete_students')->name('external-profile.add-students.delete');
Route::get('logout', 'Auth\LoginController@logout');



Route::get('download-certificate/{id?}', 'OnlineStudentController@downloadCertificate')->name('downloadCertificate');


Route::group(['prefix' => 'safelogin'], function () {
    Route::get('/', 'AdminAuth\LoginController@showLoginForm')->name('admin_login');
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin_login');
    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/logout', 'AdminAuth\LoginController@logout')->name('admin_logout');
    Route::get('/logout', 'AdminAuth\LoginController@showLoginForm');
    Route::get('safelogin/home', function () {
        if (Auth::check()) {
            $users[] = Auth::user();
            $users[] = Auth::guard()->user();
            $users[] = Auth::guard('admin')->user();
            return view('admin.home');
        } else {
            return redirect('safelogin/login');
        }
    })->name('home');
});

Route::group(['prefix' => 'admin'], function () {
    /*Route::get('/', 'AdminAuth\LoginController@showLoginForm')->name('admin_login');
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin_login');
    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/logout', 'AdminAuth\LoginController@logout')->name('admin_logout');
    Route::get('/logout', 'AdminAuth\LoginController@showLoginForm');*/



    Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.request');
    Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('admin.password.email');
    Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.reset');
    Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');


    // ACTIVITY LOG
    Route::get('/activity-log/search', 'CMS\ActivityLogController@search')->name('activitylog.search');
    Route::get('/activity-log', 'CMS\ActivityLogController@index')->name('activitylog.index');
    Route::post('/activity-log/destroy', 'CMS\ActivityLogController@destroy')->name('activitylog.destroy');
    Route::get('/activity-log/show/{id}', 'CMS\ActivityLogController@show')->name('activity-log.show');
    Route::get('/activity-log/search', 'CMS\ActivityLogController@search')->name('activitylog.search');

    // PROFILE
    Route::get('/profile', 'CMS\ProfileController@edit')->name('admin.profile');
    Route::post('/profile/update', 'CMS\ProfileController@update')->name('admin.profile.update');



    // PAGES
    Route::get('pages/search', 'CMS\PagesController@search')->name('pages.search');
    Route::resource('pages', 'CMS\PagesController');
    Route::get('image/upload', 'CMS\PagesController@imageUpload')->name('image-upload');
    Route::get('image/create', 'CMS\PagesController@imageCreate')->name('images.create');
    Route::post('image/upload', 'CMS\PagesController@imageStore')->name('image.store');
    Route::post('image/delete', 'CMS\PagesController@imageDelete')->name('images.destroy');



    // USERS ACCOUNT
    Route::get('users/search', 'CMS\UsersAccountController@search')->name('users.search');
    Route::get('users', 'CMS\UsersAccountController@index')->name('users.index');
    Route::get('users/destroy', 'CMS\UsersAccountController@destroy')->name('users.destroy');
    Route::get('users/create', 'CMS\UsersAccountController@create')->name('users.create');
    Route::get('users/edit', 'CMS\UsersAccountController@edit')->name('users.edit');

    // MENU
    Route::get('menu/search', 'CMS\MenuController@search')->name('menu.search');
    Route::resource('menu', 'CMS\MenuController');





    // MENU
    Route::get('menu/search', 'CMS\MenuController@search')->name('menu.search');
    Route::get('menu/list/{type}', 'CMS\MenuController@list')->name('menu.list');
    Route::resource('menu', 'CMS\MenuController');

    // MENU LIST
    Route::get('menu-list/{menu}/search', 'CMS\MenuListController@search')->name('menu-list.search');
    Route::get('menu-list/{menu}', 'CMS\MenuListController@index')->name('menu-list.index');
    Route::get('menu-list/{menu}/create', 'CMS\MenuListController@create')->name('menu-list.create');
    Route::post('menu-list/{menu}/create', 'CMS\MenuListController@store')->name('menu-list.store');
    Route::get('menu-list/{menu}/{id}', 'CMS\MenuListController@show')->name('menu-list.show');
    Route::get('menu-list/{menu}/{id}/edit', 'CMS\MenuListController@edit')->name('menu-list.edit');
    Route::post('menu-list/{menu}/{id}/edit', 'CMS\MenuListController@update')->name('menu-list.update');
    Route::post('menu-list/{menu}/{id}', 'CMS\MenuListController@destroy')->name('menu-list.destroy');

    // EMAIL TEMPLATE
    Route::get('email-template/search', 'CMS\EmailTemplateController@search')->name('email-template.search');
    Route::resource('email-template', 'CMS\EmailTemplateController');


    // BANNER MANAGEMENT
    Route::get('banner-management', 'CMS\BannerManagementController@index');

    // BANNER
    Route::get('banner/search', 'CMS\BannerController@search')->name('banner.search');
    Route::resource('banner', 'CMS\BannerController');

    // SLIDER
    Route::get('slider/search', 'CMS\SliderController@search')->name('slider.search');
    Route::resource('slider', 'CMS\SliderController');

    Route::get('/system-setting', 'CMS\SystemSettingController@index')->name('system-setting.index');
    Route::get('/system-setting/create', 'CMS\SystemSettingController@create');
    Route::post('/system-setting/store', 'CMS\SystemSettingController@store');
    Route::get('/system-setting/edit/{id}', 'CMS\SystemSettingController@edit');
    Route::post('/system-setting/update/{id}', 'CMS\SystemSettingController@update');
    Route::get('/system-setting/destroy/{id}', 'CMS\SystemSettingController@destroy');

    /*end filter module backend*/
    Route::get('/access-not-allowed', 'AdminAuth\Account\PermissionController@access_not_allowed')->name('access-not-allowed');
    Route::get('/roles-and-permission', 'AdminAuth\Account\PermissionController@index');
    Route::get('/roles-and-permission/create', 'AdminAuth\Account\PermissionController@create');
    Route::post('/roles-and-permission/store', 'AdminAuth\Account\PermissionController@store');
    Route::get('/roles-and-permission/edit/{id}', 'AdminAuth\Account\PermissionController@edit');
    Route::post('/roles-and-permission/update/{id}', 'AdminAuth\Account\PermissionController@update');
    Route::post('/roles-and-permission/delete', 'AdminAuth\Account\PermissionController@destroy');

    Route::get('/roles/create', 'AdminAuth\Account\PermissionController@create_roles');
    Route::post('/roles/store', 'AdminAuth\Account\PermissionController@store_roles');
    Route::get('/roles/edit/{id}', 'AdminAuth\Account\PermissionController@edit_roles');
    Route::post('/roles/update/{id}', 'AdminAuth\Account\PermissionController@update_roles');
    Route::post('/roles/delete', 'AdminAuth\Account\PermissionController@delete_roles');

    // USER ACCOUNT
    Route::get('user-account/search', 'CMS\UserAccountController@search')->name('user-account.search');
    Route::resource('user-account', 'CMS\UserAccountController');

    // CONTACT
    Route::get('contact/search', 'CMS\ContactController@search')->name('contact.search');
    Route::resource('contact', 'CMS\ContactController');


    // TEMPLATE
    Route::get('template/search', 'CMS\TemplateController@search')->name('template.search');
    Route::resource('template', 'CMS\TemplateController');

    // TEST ALLOCATION
    Route::get('test-allocation/search', 'CMS\TestAllocationController@search')->name('test-allocation.search');
    Route::resource('test-allocation', 'CMS\TestAllocationController');

    // SURVEY ALLOCATION
    Route::get('survey-allocation/search', 'CMS\SurveyAllocationController@search')->name('survey-allocation.search');
    Route::resource('survey-allocation', 'CMS\SurveyAllocationController');


    // LEVEL MASTER
    Route::get('level/search', 'CMS\LevelController@search')->name('level.search');
    Route::resource('level', 'CMS\LevelController');

    // ACHIEVEMENT
    Route::get('achievement/search', 'CMS\AchievementController@search')->name('achievement.search');
    Route::resource('achievement', 'CMS\AchievementController');
    Route::get('/admin/achievement/edit/{id}/{type}', 'CMS\AchievementController@edit')->name('achievement.edit2');
    Route::get('/admin/achievement/delete/{id}/{type}', 'CMS\AchievementController@destroy')->name('achievement.delete2');


    //QUESTION
    Route::get('question/search', 'CMS\QuestionController@search')->name('question.search');
    Route::resource('question', 'CMS\QuestionController');
    Route::post('question/find-worksheet', 'CMS\QuestionController@find_worksheet');



    // TOPIC MASTER
    Route::get('learning-location/search', 'CMS\TopicController@search')->name('learning-location.search');
    Route::resource('learning-location', 'CMS\TopicController');


    // WORKSHEET MASTER
    Route::get('worksheet/search', 'CMS\WorksheetController@search')->name('worksheet.search');
    Route::resource('worksheet', 'CMS\WorksheetController');
    Route::get('worksheet/{id?}/questions', 'CMS\WorksheetController@questions')->name('worksheet.questions');
    // Route::get('worksheet/{wId?}/questions/{qId?}/create', 'CMS\WorksheetController@questionCreate')->name('worksheet.questions.create');
    // Route::get('worksheet/question/edit/{id?}', 'CMS\WorksheetController@questionsEdit')->name('worksheet.question.edit');
    Route::get('worksheet/{wId?}/questions/{qId?}/create', 'CMS\WorksheetController@questionCreate')->name('worksheet.questions.create');
    Route::get('worksheet/{wId?}/question/{qid?}/edit', 'CMS\WorksheetController@questionsEdit')->name('worksheet.question.edit');
    Route::get('worksheet/{wId?}/question/{qId?}/show', 'CMS\WorksheetController@questionsShow')->name('worksheet.question.show');



    // LESSONS MASTER
    Route::get('lessons/search', 'CMS\LessonManagementController@search')->name('lessons.search');
    Route::resource('lessons', 'CMS\LessonManagementController');


    // LESSONS QUESTIONS MASTER
    Route::get('lesson-questions/search', 'CMS\LessonQuestionManagementController@search')->name('lesson-questions.search');
    Route::resource('lesson-questions', 'CMS\LessonQuestionManagementController');


    // CATEGORY COMPETITION
    Route::get('category-competition/search', 'CMS\CategoryCompetitionController@search')->name('category-competition.search');
    Route::resource('category-competition', 'CMS\CategoryCompetitionController');


    // COMPETITION RESULTS
    Route::get('results/search', 'CMS\CompetitionResultController@search')->name('results.search');
    Route::resource('results', 'CMS\CompetitionResultController');
    Route::get('results/competition/{id?}', 'CMS\CompetitionResultController@studentList')->name('results.competition');
    Route::get('results/{id?}/edit', 'CMS\CompetitionResultController@edit')->name('results-user.edit');

    Route::get('results/user/search', 'CMS\CompetitionResultController@userresultsearch')->name('userresults.search');

    Route::get('results/download/excel/{id?}', 'CMS\CompetitionResultController@excelDownload')->name('studentResultDownload');
    //Route::post('results/update/{id?}', 'CMS\CompetitionResultController@update')->name('results.update');

    // GRADING RESULTS
    Route::get('grading-students/search', 'CMS\GradingResultController@search')->name('grading-students.search');
    Route::resource('grading-students', 'CMS\GradingResultController');

    Route::get('grading-result-upload', 'CMS\GradingResultController@uploadCompResult');
    Route::post('grading-result-upload', 'CMS\GradingResultController@compResultUpload')->name('grading.result.upload');


    // COMPETITION
    Route::get('competition/search', 'CMS\CompetitionController@search')->name('competition.search');
    Route::resource('competition', 'CMS\CompetitionController');
    Route::get('competition/student-list/{id?}', 'CMS\CompetitionController@studentList')->name('competition.studentlist');
    Route::get('competition/student-list/{id?}/edit', 'CMS\CompetitionController@editstudentList')->name('competition.student.edit');
    Route::post('competition/student/list/{id?}/reject', 'CMS\CompetitionController@rejectstudentList')->name('competition.student.reject');
    Route::post('competition/student/list/{id?}/approve', 'CMS\CompetitionController@approvestudentList')->name('competition.student.approve');

    Route::post('competition/student-list/destroy', 'CMS\CompetitionController@studentDelete')->name('competition.student.destroy');

    Route::get('comp-result', 'CMS\CompetitionController@uploadCompResult');
    Route::post('comp-result', 'CMS\CompetitionController@compResultUpload')->name('comp.result.store');


    Route::get('assign-competition', 'CMS\CompetitionController@assignCompetition');
    Route::get('assign-competition/edit/{id?}', 'CMS\CompetitionController@assignCompetitionEdit')->name('assign-competition.edit');
    Route::post('assign-competition/store', 'CMS\CompetitionController@assignCompetitionStore')->name('assign-competition.store');



    // COMPETITION PAPERS
    Route::get('papers/search', 'CMS\CompetitionPaperController@search')->name('papers.search');
    Route::resource('papers', 'CMS\CompetitionPaperController');
    Route::get('papers/{id?}/questions', 'CMS\CompetitionPaperController@questions')->name('papers.questions');
    Route::get('papers/{pId?}/questions/{qId?}/create', 'CMS\CompetitionPaperController@questionCreate')->name('papers.questions.create');
    Route::get('papers/{pId?}/question/{qId?}/edit', 'CMS\CompetitionPaperController@questionsEdit')->name('papers.question.edit');
    Route::get('papers/{pId?}/question/{qId?}/show', 'CMS\CompetitionPaperController@questionsShow')->name('papers.question.show');


    // COMPETITION QUESTIONS
    Route::get('comp-questions/search', 'CMS\CompetitionQuestionsController@search')->name('comp-questions.search');
    Route::resource('comp-questions', 'CMS\CompetitionQuestionsController');


    // STANDALONE PAGE
    Route::get('standalone/search', 'CMS\StandalonePageController@search')->name('standalone.search');
    Route::resource('standalone', 'CMS\StandalonePageController');

    Route::get('standalone/questions/{id?}', 'CMS\StandalonePageController@questionslist')->name('standalone.questions');
    Route::get('standalone/questions/{id?}/add', 'CMS\StandalonePageController@questionsAdd')->name('standalone.questions.add');
    Route::get('standalone/questions/{id?}/edit', 'CMS\StandalonePageController@questionsEdit')->name('standalone.questions.edit');
    Route::post('standalone/questions/add', 'CMS\StandalonePageController@questionsStore')->name('standalone.questions.store');
    Route::post('standalone/questions/{id?}/update', 'CMS\StandalonePageController@questionsUpdate')->name('standalone.questions.update');

    Route::post('standalone/questions/{id?}/destroy', 'CMS\StandalonePageController@destroy')->name('standalone-questions.destroy');



    // TEST PAPER
    Route::get('test-paper/search', 'CMS\TestPaperController@search')->name('test-paper.search');
    Route::resource('test-paper', 'CMS\TestPaperController');

    Route::get('test-paper-question/{paper_id}/search', 'CMS\TestPaperQuestionController@search')->name('test-paper-question.search');
    Route::get('test-paper-question/{paper_id}', 'CMS\TestPaperQuestionController@index')->name('test-paper-question.index');
    Route::get('test-paper-question/{paper_id}/create', 'CMS\TestPaperQuestionController@create')->name('test-paper-question.create');
    Route::post('test-paper-question/{paper_id}/create', 'CMS\TestPaperQuestionController@store')->name('test-paper-question.store');
    Route::get('test-paper-question/{paper_id}/{id}', 'CMS\TestPaperQuestionController@show')->name('test-paper-question.show');
    Route::get('test-paper-question/{paper_id}/{id}/edit', 'CMS\TestPaperQuestionController@edit')->name('test-paper-question.edit');
    Route::post('test-paper-question/{paper_id}/{id}/edit', 'CMS\TestPaperQuestionController@update')->name('test-paper-question.update');
    Route::post('test-paper-question/{paper_id}/{id}', 'CMS\TestPaperQuestionController@destroy')->name('test-paper-question.destroy');



    // SURVEY
    Route::get('surveys/search', 'CMS\SurveyController@search')->name('surveys.search');
    Route::resource('surveys', 'CMS\SurveyController');


    // SURVEY QUESTIONS
    Route::get('survey-question/search', 'CMS\SurveyQuestionController@search')->name('survey-questions.search');
    Route::resource('survey-questions', 'CMS\SurveyQuestionController');


    // SURVEY QUESTIONS OPTIONS
    Route::get('options-survey-questions/search', 'CMS\SurveyQuestionOptionController@search')->name('options-survey-questions.search');
    Route::resource('options-survey-questions', 'CMS\SurveyQuestionOptionController');


    // OPTIONS CHOICES
    Route::get('option-choices/search', 'CMS\OptionChoiceController@search')->name('option-choices.search');
    Route::resource('option-choices', 'CMS\OptionChoiceController');


    // SYSTEM SETTINGS
    Route::get('/system-settings', 'CMS\SystemSettingsController@edit')->name('admin.system-settings');
    Route::post('/system-settings/update', 'CMS\SystemSettingsController@update')->name('admin.system-settings.update');

    // CUSTOMER
    Route::get('customer-account/search', 'CMS\CustomerAccountController@search')->name('customer-account.search');
    Route::resource('customer-account', 'CMS\CustomerAccountController');

    Route::resource('student-feedback', 'CMS\FeedbackController');


    // ANNOUNCEMENT
    Route::get('announcement/search', 'CMS\AnnouncementController@search')->name('announcement.search');
    Route::resource('announcement', 'CMS\AnnouncementController');

     // GRADE
     Route::get('grade/search', 'CMS\GradeController@search')->name('grade.search');
     Route::resource('grade', 'CMS\GradeController');

     // GRADING EXAM
     Route::get('grading-exam/search', 'CMS\GradingExamController@search')->name('grading-exam.search');
     Route::resource('grading-exam', 'CMS\GradingExamController');

     // GRADING EXAM LIST
    Route::get('grading-exam-list/{exam_id}/search', 'CMS\GradingExamListController@search')->name('grading-exam-list.search');
    Route::get('grading-exam-list/{exam_id}', 'CMS\GradingExamListController@index')->name('grading-exam-list.index');
    Route::get('grading-exam-list/{exam_id}/create', 'CMS\GradingExamListController@create')->name('grading-exam-list.create');
    Route::post('grading-exam-list/{exam_id}/create', 'CMS\GradingExamListController@store')->name('grading-exam-list.store');
    Route::get('grading-exam-list/{exam_id}/{id}', 'CMS\GradingExamListController@show')->name('grading-exam-list.show');
    Route::get('grading-exam-list/{exam_id}/{id}/edit', 'CMS\GradingExamListController@edit')->name('grading-exam-list.edit');
    Route::post('grading-exam-list/{exam_id}/{id}/edit', 'CMS\GradingExamListController@update')->name('grading-exam-list.update');
    Route::post('grading-exam-list/{exam_id}/{id}', 'CMS\GradingExamListController@destroy')->name('grading-exam-list.destroy');

     // GRADING PAPER
     Route::get('grading-paper/search', 'CMS\GradingPaperController@search')->name('grading-paper.search');
     Route::resource('grading-paper', 'CMS\GradingPaperController');

     // TEST MANAGEMENT
     Route::get('test-management/search', 'CMS\TestManagementController@search')->name('test-management.search');
     Route::resource('test-management', 'CMS\TestManagementController');

     // COURSE
     Route::get('course/search', 'CMS\CourseController@search')->name('course.search');
     Route::resource('course', 'CMS\CourseController');

    //TEACHING MATERIALS
    Route::get('teaching-materials/search', 'CMS\TeachingMaterialsController@search')->name('teaching-materials.search');
    Route::resource('teaching-materials', 'CMS\TeachingMaterialsController');

    //INSTRUCTOR CALENDAR
    Route::get('instructor-calendar/search', 'CMS\InstructorCalendarController@search')->name('instructor-calendar.search');
    Route::resource('instructor-calendar', 'CMS\InstructorCalendarController');


    // EXTERNAL CENTRE
    Route::get('external-centre-account/search', 'CMS\ExternalCentreAccountController@search')->name('external-centre-account.search');
    Route::resource('external-centre-account', 'CMS\ExternalCentreAccountController');


    // INSTRUCTOR
    Route::get('instructor-account/search', 'CMS\InstructorAccountController@search')->name('instructor-account.search');
    Route::resource('instructor-account', 'CMS\InstructorAccountController');

    Route::get('customer/pending-request', 'CMS\UserProfileUpdateController@index')->name('customer.pendingRequest');
    Route::get('customer/search', 'CMS\UserProfileUpdateController@search')->name('customer.search');
    Route::get('customer/edit/{id}', 'CMS\UserProfileUpdateController@edit')->name('customer.edit');
    Route::post('customer/update/{id}', 'CMS\UserProfileUpdateController@update')->name('customer.update');
    Route::get('customer/show/{id}', 'CMS\UserProfileUpdateController@show')->name('customer.show');



    // NOTIFICATION
    Route::get('notification/search', 'CMS\NotificationController@search')->name('notification.search');
    Route::get('notification/redirect/{id}', 'CMS\NotificationController@showRedirect')->name('notification.show-redirect');
    Route::get('notification/search', 'CMS\NotificationController@search')->name('notification.search');
    Route::resource('notification', 'CMS\NotificationController');


    Route::post('reports-student/search', 'CMS\ReportController@search')->name('reports-student.search');
    Route::get('reports-student', 'CMS\ReportController@index');

    Route::post('reports-grading-examination/search', 'CMS\ReportController@grading_examination_search')->name('reports-grading-examination.search');
    Route::get('reports-grading-examination', 'CMS\ReportController@grading_examination');

    Route::post('reports-competition/search', 'CMS\ReportController@competition_search')->name('reports-competition.search');
    Route::get('reports-competition', 'CMS\ReportController@competition');


    Route::post('reports-instructor/search', 'CMS\ReportController@searchInstructor')->name('reports-instructor.search');
    Route::get('reports-instructor', 'CMS\ReportController@instructor');

    Route::get('reports-sales/search', 'CMS\ReportController@searchInSales')->name('reports-sales.search');
    Route::get('reports-sales', 'CMS\ReportController@sales');
    Route::post('reports-sales', 'CMS\ReportController@searchSales')->name('salesexcel');

    Route::get('reports-external-centre/search', 'CMS\ReportController@search_external_centre')->name('reports-external-centre.search');
    Route::get('reports-external-centre', 'CMS\ReportController@external_centre');
    Route::get('reports-external-centre/students/{id}', 'CMS\ReportController@external_centre_students_list')->name('reports-external-centre.student_list');;


    Route::get('reports-worksheet/search', 'CMS\ReportController@searchInWorksheet')->name('reports-worksheet.search');
    Route::get('reports-worksheet', 'CMS\ReportController@worksheet');
    //Route::post('reports-worksheet', 'CMS\ReportController@searchWorksheet')->name('salesexcel');

    Route::get('orders/show/{id?}', 'CMS\OrderController@show')->name('order.show');
    Route::get('orders', 'CMS\OrderController@index');
    Route::get('orders', 'CMS\OrderController@index')->name('orders.index');
    Route::get('orders/create', 'CMS\OrderController@create')->name('orders.create');
    Route::post('orders/store', 'CMS\OrderController@store')->name('orders.store');

    //Route::get('orders/show/{id?}', 'CMS\OrderController@show')->name('order.show');
    Route::get('survey-completed', 'CMS\SurveyController@getlist')->name('survey-completed.getlist');
    Route::get('survey-completed/search', 'CMS\SurveyController@search')->name('surveys-completed.search');


    Route::get('survey-view/{id?}', 'CMS\SurveyController@viewDetails')->name('surveyslist.show');
    Route::get('survey-edit/{id?}/edit', 'CMS\SurveyController@editSurvey')->name('surveyslist.edit');
    Route::post('survey-edit/{id?}/update', 'CMS\SurveyController@updateSurvey')->name('survey-completed.update');

    Route::get('certificate/search', 'CMS\CertificateController@search')->name('certificate.search');
    Route::resource('certificate', 'CMS\CertificateController');


    Route::get('question-attempt/search', 'CMS\QuestionAttempt@search')->name('question-attempt.search');
    Route::resource('question-attempt', 'CMS\QuestionAttempt');


    Route::get('challenge', 'CMS\QuestionAttempt@challenge');
    Route::get('challenge/delete', 'CMS\QuestionAttempt@challengedelete')->name('challenge.delete');

});


