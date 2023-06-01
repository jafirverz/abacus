
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



// ************ ACCOUNT/PROFILE *******************/

Route::get('my-profile', 'ProfileController@index')->name('my-profile');
Route::get('instructor-profile', 'ProfileController@instructor')->name('instructor-profile');
Route::post('my-profile', 'ProfileController@store')->name('my-profile.update');


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
    Route::get('/access-not-allowed', 'AdminAuth\Account\PermissionController@access_not_allowed');
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


    // SYSTEM SETTINGS
    Route::get('/system-settings', 'CMS\SystemSettingsController@edit')->name('admin.system-settings');
    Route::post('/system-settings/update', 'CMS\SystemSettingsController@update')->name('admin.system-settings.update');

    // CUSTOMER
    Route::get('customer-account/search', 'CMS\CustomerAccountController@search')->name('customer-account.search');
    Route::resource('customer-account', 'CMS\CustomerAccountController');


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
});



