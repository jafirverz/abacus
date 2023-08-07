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


// Route::get('/chat-email', function () {
//     $exitCode2 = \Illuminate\Support\Facades\Artisan::call('chat:notification');
//     return $exitCode2;
// });


Route::get('/storage-link', function () {
    $exitCode2 = \Illuminate\Support\Facades\Artisan::call('storage:link');
    return $exitCode2;
});

Auth::routes(['verify' => true]);

Auth::routes();
Route::get('/', 'PagesFrontController@index');

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

Route::get('/competition/{id?}', 'CompetitionController@index');

Route::get('/competition-paper/{id?}', 'CompetitionController@paper');
Route::post('/competition-paper/submit', 'CompetitionController@submitPaper')->name('competition.submit');


Route::get('/online-student/feedback', 'OnlineStudentController@feedback')->name('feedback');
Route::post('/online-student/feedback', 'OnlineStudentController@feedbackstore')->name('feedback.submit');
Route::get('/online-student/my-course', 'OnlineStudentController@my_course')->name('my-course');
Route::get('/online-student/my-course/detail/{id?}', 'OnlineStudentController@detail_course')->name('my-course.detail');
Route::post('/online-student/my-course/result', 'OnlineStudentController@submit_course')->name('course.answer.submit');
Route::get('/instructor-students', 'ProfileController@studentlist');
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


Route::get('/membership', 'ProfileController@membership')->name('membership');

Route::get('/cart/{id?}', 'ProfileController@cartList')->name('cartlist');
Route::get('/cart/delete/all', 'ProfileController@cartListDelete')->name('delete.cart');
Route::post('/cart', 'ProfileController@cart')->name('cart');


Route::get('/checkout', 'ProfileController@checkout');


// Route::get('paywithpaypal', array('as' => 'paywithpaypal','uses' => 'ProfileController@payWithPaypal',));
// Route::post('paypal', array('as' => 'paypal','uses' => 'ProfileController@postPaymentWithpaypal',));
// Route::get('paypal', array('as' => 'status','uses' => 'ProfileController@getPaymentStatus',));

// Route::get('payment', 'PayPalController@payment')->name('payment');
// Route::get('cancel', 'PayPalController@cancel')->name('payment.cancel');
// Route::get('payment/success', 'PayPalController@success')->name('payment.success');

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
Route::get('grading-overview', 'ProfileController@grading_overview')->name('grading-overview');
Route::post('grading-overview/result', 'GradingSubmitController@resultpage')->name('grading_answer.submit');
Route::get('grading-examination', 'ProfileController@grading_examination')->name('grading-examination');
Route::get('grading-examination/delete/{id?}', 'ProfileController@delete_grading')->name('grading-examination.delete');
Route::get('grading-examination/edit/{id?}', 'ProfileController@edit_grading')->name('grading-examination.edit');
Route::post('grading-examination/edit/{id?}', 'ProfileController@update_grading')->name('grading-examination.update');
Route::get('grading-examination/view/{id?}', 'ProfileController@view_grading')->name('grading-examination.view');
Route::get('grading-examination', 'ProfileController@grading_examination')->name('grading-examination');
Route::get('register-grading-examination', 'ProfileController@register_grading_examination')->name('register-grading-examination');
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


Route::get('logout', 'Auth\LoginController@logout');



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


    //QUESTION
    Route::get('question/search', 'CMS\QuestionController@search')->name('question.search');
    Route::resource('question', 'CMS\QuestionController');
    Route::post('question/find-worksheet', 'CMS\QuestionController@find_worksheet');



    // TOPIC MASTER
    Route::get('topic/search', 'CMS\TopicController@search')->name('topic.search');
    Route::resource('topic', 'CMS\TopicController');


    // WORKSHEET MASTER
    Route::get('worksheet/search', 'CMS\WorksheetController@search')->name('worksheet.search');
    Route::resource('worksheet', 'CMS\WorksheetController');


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

    Route::get('comp-result', 'CMS\CompetitionController@uploadCompResult');
    Route::post('comp-result', 'CMS\CompetitionController@compResultUpload')->name('comp.result.store');



    // COMPETITION PAPERS
    Route::get('papers/search', 'CMS\CompetitionController@search')->name('competition.search');
    Route::resource('papers', 'CMS\CompetitionPaperController');


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



    // RECRUITER
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
});
