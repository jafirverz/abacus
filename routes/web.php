
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
    $exitCode2 = \Illuminate\Support\Facades\Artisan::call('config:clear');
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


Route::get('docusign', 'DocusignController@index')->name('docusign');
Route::get('connect-docusign', 'DocusignController@connectDocusign')->name('connect.docusign');

Route::get('sign-document', 'DocusignController@signDocument')->name('docusign.sign');

Route::get('connect/docusign/insurance', 'DocusignInsuranceController@connectDocusign')->name('connect.docusign.insurance');

Auth::routes();
Route::get('/', 'PagesFrontController@index');
Route::get('/home', 'PagesFrontController@index')->name('home');
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('login');
//Route::get('auth/callback', 'Auth\SingpassLoginController@handleCallback');
//Route::get('singpass/error', 'Auth\SingpassLoginController@showError');
Route::get('marketplace-search-results', 'PagesFrontController@marketplace_search_results');

Route::get('myinfo/user', 'Auth\MyinfoController@createAuthorizeUrl');



// Individual
Route::get('seller-sales-purchase/callback', 'Auth\SPAgreementController@authorise');
Route::get('car-insurance/callback', 'Auth\MyinfoController@authorise');
Route::get('car-loan/callback', 'Auth\LoanController@authorise');
Route::get('advertise-car/callback', 'Auth\AdvertiseMyCarController@authorise');
Route::get('quote-my-car/callback', 'Auth\QuoteMyCarController@authorise');
Route::get('buyer-sales-purchase/callback', 'Auth\BuyerSPAgreementController@authorise');
Route::get('acc-reg/callback', 'Auth\AccountRegistrationController@authorise');

// Business
Route::get('mib-car-loan/callback', 'Auth\LoanControllerBusiness@authorise');
Route::get('mib-car-insurance/callback', 'Auth\InsuranceBusinessController@authorise');
Route::get('mib-seller-sales-purchase/callback', 'Auth\SPAgreementBusinessController@authorise');
Route::get('mib-quote-my-car/callback', 'Auth\QuoteMyCarBusinessController@authorise');
Route::get('mib-advertise-car/callback', 'Auth\AdvertiseMyCarBusinessController@authorise');


Route::get('sp-pdf', 'TestPdfController@index');


// ************ ACCOUNT/PROFILE *******************/

Route::get('my-profile', 'ProfileController@index')->name('my-profile');
Route::get('my-chats/{carId?}/{buyerId?}', 'ProfileController@myChat');
Route::get('chat/details/{id}/{buyerId}', 'ProfileController@chatDetails')->name('chat.details');
Route::get('chat/offer/{carId?}', 'ProfileController@makeOffer')->name('make.offer');
Route::post('chat/save', 'ProfileController@saveChat')->name('save.chat');
Route::post('chat/save/offer', 'ProfileController@saveOffer')->name('saveOffer');
Route::post('chat/approve/offer', 'ProfileController@approveOffer')->name('save.sellerApprove');
Route::post('chat/approve/revised/offer', 'ProfileController@approveOfferRevised')->name('save.sellerApproveRevised');
Route::post('chat/cancel/offer', 'ProfileController@cancelOffer')->name('cancel.offer');
Route::post('chat/revise/offer', 'ProfileController@reviseOffer')->name('revise.offer');
Route::post('chat/block/user', 'ProfileController@blockUser')->name('block.user');
Route::post('chat/delete', 'ProfileController@deleteChat')->name('delete.chat');
Route::post('chat/stainspection', 'ProfileController@staInspection')->name('stainspection');
Route::post('chat/buyer-info', 'ProfileController@buyerInfo')->name('buyerInfo');
Route::post('chat/booking-confirm', 'ProfileController@confirmBooking')->name('confirmBooking');
Route::post('my-chats/{carId?}/{buyerId?}', 'ProfileController@myChat')->name('search.message');
Route::post('chat/report/user', 'ProfileController@reportUser')->name('report.user');


Route::get('my-cars', 'ProfileController@my_cars')->name('my-cars');
Route::get('my-quote-requests', 'ProfileController@my_quote_requests')->name('my-quote-requests');
Route::get('my-invoices', 'ProfileController@my_invoices')->name('my-invoices');
Route::get('view-invoice/{id}', 'ProfileController@view_invoice')->name('view-invoice');
Route::get('advertise-my-car-form', 'ProfileController@advertise_my_car_form')->name('advertise-my-car-form');
Route::post('advertise-my-car-form', 'ProfileController@advertise_my_car_store')->name('advertise-my-car-form1');
Route::get('quote-my-car-form', 'ProfileController@quote_my_car_form')->name('quote-my-car-form');
Route::post('quote-my-car-form', 'ProfileController@quote_my_car_store')->name('quote-my-car-form1');
Route::post('my-profile', 'ProfileController@store')->name('my-profile.update');
Route::post('my-profile/account/delete', 'ProfileController@destroy')->name('my-profile.account.delete');
Route::get('change-password', 'ProfileController@change_password')->name('change-password');
Route::post('change-password', 'ProfileController@change_password_update')->name('change-password.update');
//INSURANCE
Route::get('insurance-applications', 'ProfileController@insurance_applications');
Route::get('insurance-applications/{id}', 'ProfileController@insurance_applications_detail');
Route::post('quotation-submit', 'ProfileController@quotation_submit');
Route::post('insurance-customer-sign', 'ProfileController@insurance_customer_sign')->name('insurance.customer.sign');

Route::post('insurance-applications/archived', 'ProfileController@archivedInsurance');
Route::get('insurance-applications/archived/show', 'ProfileController@archivedInsuranceShow');

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
    Route::get('insurance/callback', 'DocusignInsuranceController@callback')->name('docusign.callback.insurance');
    Route::get('insurance/seller/{id?}', 'DocusignInsuranceController@seller')->name('docusign.sign.insurance');

    Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('admin_register');
    Route::post('/register', 'AdminAuth\RegisterController@register');

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

    // SYSTEM SETTINGS
    Route::get('/system-settings', 'CMS\SystemSettingsController@edit')->name('admin.system-settings');
    Route::post('/system-settings/update', 'CMS\SystemSettingsController@update')->name('admin.system-settings.update');

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

    // ROLES AND PERMISSION
    Route::get('roles-and-permission/search', 'CMS\RolesPermissionController@search')->name('roles-and-permission.search');
    Route::get('/access-not-allowed', 'CMS\RolesPermissionController@access_not_allowed')->name('access-not-allowed');
    Route::resource('roles-and-permission', 'CMS\RolesPermissionController');

    // USER ACCOUNT
    Route::get('user-account/search', 'CMS\UserAccountController@search')->name('user-account.search');
    Route::resource('user-account', 'CMS\UserAccountController');

    // CONTACT
    Route::get('contact/search', 'CMS\ContactController@search')->name('contact.search');
    Route::resource('contact', 'CMS\ContactController');



    // SYSTEM SETTINGS
    Route::get('/system-settings', 'CMS\SystemSettingsController@edit')->name('admin.system-settings');
    Route::post('/system-settings/update', 'CMS\SystemSettingsController@update')->name('admin.system-settings.update');

    // CUSTOMER
    Route::get('customer-account/search', 'CMS\CustomerAccountController@search')->name('customer-account.search');
    Route::resource('customer-account', 'CMS\CustomerAccountController');

});


