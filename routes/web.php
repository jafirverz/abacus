
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

    // SPECIFICATIONS
    Route::get('specifications/search', 'Admin\SpecificationsController@search')->name('specifications.search');
    Route::resource('specifications', 'Admin\SpecificationsController');

    // ATTRIBUTES
    Route::get('attributes/search', 'Admin\AttributesController@search')->name('attributes.search');
    Route::resource('attributes', 'Admin\AttributesController');

    // MARKETPLACE ADMIN
    Route::get('marketplace/search', 'Admin\MarketplaceController@search')->name('marketplace.search');
    Route::resource('marketplace', 'Admin\MarketplaceController');
    Route::post('marketplace/image/delete', 'Admin\MarketplaceController@deleteImage')->name('image.delete');

    // INVOICE ADMIN
    Route::get('invoice/search', 'Admin\InvoiceController@search')->name('invoice.search');
    Route::resource('invoice', 'Admin\InvoiceController');

    // QUOTE REQUESTS
    Route::get('quoterequest/search', 'Admin\QuoteRequestController@search')->name('quoterequest.search');
    Route::resource('quoterequest', 'Admin\QuoteRequestController');

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

    // PARTNER
    Route::get('partner/search', 'CMS\PartnerControlle@search')->name('partner.search');
    Route::resource('partner', 'CMS\PartnerControlle');

    // FILTER
    Route::get('filter/search', 'CMS\FilterController@search')->name('filter.search');
    Route::resource('filter', 'CMS\FilterController');
    Route::post('/filter/get-make', 'CMS\FilterController@get_make');

    // INSURANCE
    Route::get('insurance/search', 'CMS\InsuranceApplicationController@search')->name('insurance.search');
    Route::resource('insurance', 'CMS\InsuranceApplicationController');
    Route::post('insurance/store', 'CMS\InsuranceApplicationController@store')->name('admin.insurance.store');
    Route::post('insurance/delete-quotation', 'CMS\InsuranceApplicationController@delete_quotation');


    // ONE_MOTORING
    Route::get('oneMotoring/search', 'CMS\OneMotoringController@search')->name('oneMotoring.search');
    Route::resource('oneMotoring', 'CMS\OneMotoringController');

    //*! FAQ Category
    Route::get('category/search', 'CMS\CategoryController@search')->name('category.search');
    Route::resource('category', 'CMS\CategoryController');

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

    // MESSAGE TEMPLATE
    Route::get('message-template/search', 'CMS\MessageTemplateController@search')->name('message-template.search');
    Route::resource('message-template', 'CMS\MessageTemplateController');

    /* -------------------------------------------------------------------------- */
    /*                                 Testimonial                                */
    /* -------------------------------------------------------------------------- */
    //TESTIMONIAL
    Route::get('testimonial/search', 'CMS\TestimonialController@search')->name('testimonial.search');
    Route::resource('testimonial', 'CMS\TestimonialController');
    Route::post('testimonial/update/{id}', 'CMS\TestimonialController@update')->name('testimonial.update');
    Route::get('testimonial/update_status/{id}/{type}', 'CMS\TestimonialController@update_status');

    /* -------------------------------------------------------------------------- */
    /*                              Smart Blocks                                */
    /* -------------------------------------------------------------------------- */
    Route::get('smart-block/search', 'CMS\SmartBlockController@search')->name('smart-block.search');
    Route::resource('smart-block', 'CMS\SmartBlockController');


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
    // FAQ
    Route::get('faqs/search', 'CMS\FaqController@search')->name('faqs.search');
    Route::resource('faqs', 'CMS\FaqController');
    // CONTACT
    Route::get('contact/search', 'CMS\ContactController@search')->name('contact.search');
    Route::resource('contact', 'CMS\ContactController');


    // LEVEL MASTER
    Route::get('level/search', 'CMS\LevelController@search')->name('level.search');
    Route::resource('level', 'CMS\LevelController');

    // TOPIC MASTER
    Route::get('topic/search', 'CMS\TopicController@search')->name('topic.search');
    Route::resource('topic', 'CMS\TopicController');


    // WORKSHEET MASTER
    Route::get('worksheet/search', 'CMS\WorksheetController@search')->name('worksheet.search');
    Route::resource('worksheet', 'CMS\WorksheetController');

    // CHAT WINDOW
    Route::get('chat-window/search', 'CMS\ChatWindowController@search')->name('chat-window.search');
    Route::resource('chat-window', 'CMS\ChatWindowController');

    // STA INSPECTION
    Route::get('sta-inspection/search', 'CMS\StaInspectionController@search')->name('sta-inspection.search');
    Route::get('sta-inspection/change-status/{id}/{status}', 'CMS\StaInspectionController@change_status');
    Route::resource('sta-inspection', 'CMS\StaInspectionController');

    // SYSTEM SETTINGS
    Route::get('/system-settings', 'CMS\SystemSettingsController@edit')->name('admin.system-settings');
    Route::post('/system-settings/update', 'CMS\SystemSettingsController@update')->name('admin.system-settings.update');

    /* -------------------------------------------------------------------------- */
    /*                              Smart Blocks                                */
    /* -------------------------------------------------------------------------- */
    Route::get('smart-block/search', 'CMS\SmartBlockController@search')->name('smart-block.search');
    Route::resource('smart-block', 'CMS\SmartBlockController');


    // LOAN APPLICATIONS
    Route::post('loan-application/upload-files', 'CMS\LoanApplicationController@upload_files');
    Route::get('loan-application/search', 'CMS\LoanApplicationController@search')->name('loan-application.search');

    Route::get('loan-application/connect/docusign', 'DocusignLoanController@connectDocusign')->name('loanapplication.connect');
    Route::get('loan-application/callback', 'DocusignLoanController@callback')->name('loanapplication.callback');
    Route::get('loan-application/loan/{id}', 'DocusignLoanController@sendPDF');
    Route::resource('loan-application', 'CMS\LoanApplicationController');


    Route::get('sp-agreement/callback', 'DocusignController@callback')->name('docusign.callback');
    Route::get('sp-agreement/seller/{id}', 'DocusignController@seller');
    Route::get('sp-agreement/search', 'CMS\SPAgreementController@search')->name('sp-agreement.search');
    Route::resource('sp-agreement', 'CMS\SPAgreementController');


    Route::prefix('sp-agreement-archive')->name('sp-agreement-archive.')->group(function () {
        Route::get('active/{id}', 'CMS\SPAgreementArchiveController@active')->name('active');
        Route::get('search', 'CMS\SPAgreementArchiveController@search')->name('search');
        Route::resource('/', 'CMS\SPAgreementArchiveController');
    });


    // S&P AGREEMENT FORMS
    Route::resource('forms', 'CMS\FormsController');

    // CUSTOMER
    Route::get('customer-account/search', 'CMS\CustomerAccountController@search')->name('customer-account.search');
    Route::resource('customer-account', 'CMS\CustomerAccountController');


    // NOTIFICATION
    Route::get('notification/search', 'CMS\NotificationController@search')->name('notification.search');
    Route::get('notification/redirect/{id}', 'CMS\NotificationController@showRedirect')->name('notification.show-redirect');
    Route::get('notification/search', 'CMS\NotificationController@search')->name('notification.search');
    Route::resource('notification', 'CMS\NotificationController');
});

// SIGN SIGNATURE
Route::get('sign-signature', 'PagesFrontController@sign_signature');

//Contact
Route::post('contact-us', 'PagesFrontController@contact_store')->name('contact-enquiry-submit');

//User account verification
Route::get('account-verification/{token}', 'ProfileController@account_verification')->name('account-verification');
//*! contact enquiry submission

// LOAN MODULE
Route::post('loan/update', 'LoanController@update');
Route::post('loan-application/display-loan-chart', 'LoanController@loanChart');

// PROFILE LOAN APPLICATION
Route::get('loan-applications', 'LoanApplicationController@index');
Route::get('loan-applications/other-docs/{reference_id}/{id}', 'LoanApplicationController@otherDocs');
Route::get('loan-applications/{reference_id}/{id}', 'LoanApplicationController@show');
Route::post('loan-applications/archive', 'LoanApplicationController@archive');
Route::get('loan-archived', 'LoanApplicationController@showarchived');


// INSURANCE
Route::get('insurance', 'InsuranceController@index');
Route::post('insurance-store', 'InsuranceController@insurance_store')->name('insurance.store');

// S&P AGREEMENT
Route::get('forms/{slug}/{carId?}', 'PagesFrontController@pages');
Route::post('forms/{slug}', 'SPContractAgreement@store');

Route::get('forms/{slug}/buyer/{reference}/{id}', 'PagesFrontController@pages');
Route::post('forms/{slug}/buyer/{reference}/{id}', 'SPContractAgreement@buyer_store');

Route::get('forms/{slug}/seller/{reference}/{id}', 'PagesFrontController@pages');
Route::post('forms/{slug}/seller/{reference}/{id}', 'SPContractAgreement@seller_store');

Route::get('forms/{slug}/revised/{reference}/{id}', 'PagesFrontController@pages');
Route::post('forms/{slug}/revised/{reference}/{id}', 'SPContractAgreement@revised_store');

Route::get('forms/{slug}/view/{reference}/{id}', 'PagesFrontController@pages');

// PROFILE S&P AGREEMENT
Route::post('my-forms/destroy', 'SPContractAgreement@destroy')->name('my-forms.destroy');
Route::get('my-forms', 'SPContractAgreement@index');
Route::get('my-forms/archived', 'SPContractAgreementArchived@index');
Route::get('my-forms/archived/active/{id}', 'SPContractAgreementArchived@active');

Route::get('test-pdf', 'ProfileController@testPDF');
Route::post('get-country-code', 'SPContractAgreement@getCountryCode')->name('get-country-code');
Route::get('{slug}', 'PagesFrontController@pages');

//MARKETPLACE FRONTEND
Route::get('car/marketplace', 'MarketplaceController@index');
Route::get('car/{id}/marketplace-details', 'MarketplaceController@show');
Route::get('car/print/{id}/marketplace-details', 'MarketplaceController@print');
Route::get('marketplace-details/like/{id}', 'ProfileController@likeVehicle');
Route::get('car/marketplace/view-all/{slug}', 'MarketplaceController@viewAll');
Route::get('marketplace-details/report/{id}', 'ProfileController@reportVehicle');

Route::get('view-quote/{id}', 'ProfileController@viewQuote');
