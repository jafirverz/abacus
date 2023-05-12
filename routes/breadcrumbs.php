<?php

// ADMIN DASHBOARD
Breadcrumbs::for('admin_home', function ($trail) {
    $trail->push(__('constant.DASHBOARD'), url('admin/home'));
});

// ACTIVITYLOG
Breadcrumbs::for('admin_activitylog', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.ACTIVITYLOG'), route('activitylog.index'));
});

Breadcrumbs::for('admin_activitylog_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_activitylog');
    $trail->push($title, $url);
});

// PROFILE
Breadcrumbs::for('admin_profile', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.PROFILE'), route('admin.profile'));
});

// LOAN SETTINGS
Breadcrumbs::for('system_settings', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.SYSTEM_SETTING'), route('admin.system-settings'));
});


// SYSTEM SETTINGS
Breadcrumbs::for('admin_loan_settings', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.LOAN_CALCULATOR_SETTINGS'), url('admin/loan-calculator-settings'));
});

// PAGES
Breadcrumbs::for('admin_pages', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.PAGES'), route('pages.index'));
});

Breadcrumbs::for('admin_pages_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_pages');
    $trail->push($title, $url);
});

// CATEGORY
Breadcrumbs::for('admin_categry', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.CATEGORY'), route('category.index'));
});

Breadcrumbs::for('admin_categry_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_categry');
    $trail->push($title, $url);
});


// ONE_MOTORING
Breadcrumbs::for('admin_oneMotoring', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.ONE_MOTORING'), route('oneMotoring.index'));
});

Breadcrumbs::for('admin_oneMotoring_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_oneMotoring');
    $trail->push($title, $url);
});

// BANK
Breadcrumbs::for('admin_bank', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.BANK'), route('bank.index'));
});

Breadcrumbs::for('admin_bank_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_bank');
    $trail->push($title, $url);
});


// FAQ
Breadcrumbs::for('admin_faq', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.FAQ'), route('faqs.index'));
});

Breadcrumbs::for('admin_faq_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_faq');
    $trail->push($title, $url);
});
// PARTNER
Breadcrumbs::for('admin_partner', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.PARTNER'), route('partner.index'));
});

Breadcrumbs::for('admin_partner_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_partner');
    $trail->push($title, $url);
});

// CHAT_WINDOW_MANAGEMENT
Breadcrumbs::for('admin_chat_window', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.CHAT_WINDOW_MANAGEMENT'), route('chat-window.index'));
});

Breadcrumbs::for('admin_chat_window_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_chat_window');
    $trail->push($title, $url);
});

// STA INSPECTION
Breadcrumbs::for('admin_sta_inspection', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.STA_INSPECTION'), route('sta-inspection.index'));
});

Breadcrumbs::for('admin_sta_inspection_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_sta_inspection');
    $trail->push($title, $url);
});

// FILTER
Breadcrumbs::for('admin_filter', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.FILTER_MANAGEMENT'), route('filter.index'));
});

Breadcrumbs::for('admin_filter_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_filter');
    $trail->push($title, $url);
});

// INSURANCE
Breadcrumbs::for('admin_insurance', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.INSURANCE_APPLICATION'), route('insurance.index'));
});

Breadcrumbs::for('admin_insurance_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_insurance');
    $trail->push($title, $url);
});



// TESTIMONIAL
Breadcrumbs::for('admin_testimonial', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.TESTIMONIAL'), route('testimonial.index'));
});

Breadcrumbs::for('admin_testimonial_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_testimonial');
    $trail->push($title, $url);
});

// MENU
Breadcrumbs::for('admin_menu', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.MENU'), route('menu.index'));
});

Breadcrumbs::for('admin_menu_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_menu');
    $trail->push($title, $url);
});

// MENU LIST
Breadcrumbs::for('admin_menu_list', function ($trail, $menu) {
    $trail->parent('admin_menu', $menu);
    $trail->push(getMenuName($menu), route('menu-list.index', $menu));
});

Breadcrumbs::for('admin_menu_list_crud', function ($trail, $menu, $title, $url = '#') {
    $trail->parent('admin_menu_list', $menu);
    $trail->push($title, $url);
});
// USERS ACCOUNT
Breadcrumbs::for('admin_users_account', function ($trail) {
    $trail->parent('admin_home');
    $trail->push('Users Account', route('users.index'));
});

Breadcrumbs::for('admin_users_account_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_users_account');
    $trail->push($title, $url);
});
// EMAIL TEMPLATE
Breadcrumbs::for('admin_email_template', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.EMAIL_TEMPLATE'), route('email-template.index'));
});

Breadcrumbs::for('admin_car_specifications', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('Car Features'), route('specifications.index'));
});

Breadcrumbs::for('admin_car_attributes', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('Car Accessories'), route('attributes.index'));
});

Breadcrumbs::for('admin_email_template_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_email_template');
    $trail->push($title, $url);
});

Breadcrumbs::for('admin_car_specifications_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_car_specifications');
    $trail->push($title, $url);
});

Breadcrumbs::for('admin_car_attributes_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_car_attributes');
    $trail->push($title, $url);
});

// MESSAGE TEMPLATE
Breadcrumbs::for('admin_message_template', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.MESSAGE_TEMPLATE'), route('message-template.index'));
});

Breadcrumbs::for('admin_message_template_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_message_template');
    $trail->push($title, $url);
});

// NOTIFICATION TEMPLATE
Breadcrumbs::for('admin_notification', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.NOTIFICATION'), route('notification.index'));
});

Breadcrumbs::for('admin_notification_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_notification');
    $trail->push($title, $url);
});



// BANNER MANAGEMENT
Breadcrumbs::for('admin_banner_management', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.BANNER_MANAGEMENT'), url('admin/banner-management'));
});
// BANNER
Breadcrumbs::for('admin_banner', function ($trail) {
    $trail->parent('admin_banner_management');
    $trail->push(__('constant.BANNER'), route('banner.index'));
});

Breadcrumbs::for('admin_banner_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_banner');
    $trail->push($title, $url);
});
// GALLERY
Breadcrumbs::for('admin_gallery', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.GALLERY'), route('gallery.index'));
});

Breadcrumbs::for('admin_gallery_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_gallery');
    $trail->push($title, $url);
});

Breadcrumbs::for('admin_location_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_location');
    $trail->push($title, $url);
});
// USER ACCOUNT
Breadcrumbs::for('user_account', function ($trail) {
	$trail->parent('admin_home');
    $trail->push(__('constant.USER_ACCOUNT'), route('user-account.index'));
});

Breadcrumbs::for('user_account_crud', function ($trail, $title, $url = '#') {
    $trail->parent('user_account');
    $trail->push($title, $url);
});
// CONTACT
Breadcrumbs::for('admin_contact', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.CONTACT'), route('contact.index'));
});

Breadcrumbs::for('admin_contact_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_contact');
    $trail->push($title, $url);
});
// SLIDER
Breadcrumbs::for('admin_slider', function ($trail) {
    $trail->parent('admin_banner_management');
    $trail->push(__('constant.SLIDER'), route('slider.index'));
});

Breadcrumbs::for('admin_slider_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_slider');
    $trail->push($title, $url);
});




// ROLES AND PERMISSION
Breadcrumbs::for('roles_and_permission', function ($trail) {
	$trail->parent('admin_home');
    $trail->push(__('constant.ROLES_AND_PERMISSION'), route('roles-and-permission.index'));
});

Breadcrumbs::for('roles_and_permission_crud', function ($trail, $title, $url = '#') {
    $trail->parent('roles_and_permission');
    $trail->push($title, $url);
});

// CUSTOMER
Breadcrumbs::for('customer_account', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.CUSTOMER_ACCOUNT'), route('customer-account.index'));
});

Breadcrumbs::for('customer_account_crud', function ($trail, $title, $url = '#') {
    $trail->parent('customer_account');
    $trail->push($title, $url);
});

/* -------------------------------------------------------------------------- */
/*                                Smart Blocks                                */
/* -------------------------------------------------------------------------- */

Breadcrumbs::for('admin_smart_block', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.SMART_BLOCK'), route('smart-block.index'));
});

Breadcrumbs::for('admin_smart_block_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_smart_block');
    $trail->push($title, $url);
});

// LOAN
Breadcrumbs::for('admin_loan', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.LOAN_APPLICATION'), route('loan-application.index'));
});

Breadcrumbs::for('admin_loan_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_loan');
    $trail->push($title, $url);
});

// S&P AGREEMENT
Breadcrumbs::for('admin_sp_agreement', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.SP_AGREEMENT'), route('sp-agreement.index'));
});

Breadcrumbs::for('admin_sp_agreement_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_sp_agreement');
    $trail->push($title, $url);
});

// S&P AGREEMENT ARCHIVE
Breadcrumbs::for('admin_sp_agreement_archive', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.SP_AGREEMENT'), route('sp-agreement-archive.index'));
});

Breadcrumbs::for('admin_sp_agreement_archive_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_sp_agreement_archive');
    $trail->push($title, $url);
});

// MARKETPLACE
Breadcrumbs::for('admin_car_marketplace', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('Car Marketplace'), route('marketplace.index'));
});

Breadcrumbs::for('admin_car_marketplace_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_car_marketplace');
    $trail->push($title, $url);
});

// QUOTE REQUEST
Breadcrumbs::for('admin_car_quote_request', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('Quote Requests'), route('quoterequest.index'));
});

Breadcrumbs::for('admin_car_quoterequest_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_car_quote_request');
    $trail->push($title, $url);
});

// Invoice
Breadcrumbs::for('admin_car_invoice', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('Invoices'), route('invoice.index'));
});

Breadcrumbs::for('admin_car_invoice_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_car_invoice');
    $trail->push($title, $url);
});
