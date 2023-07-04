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


// PAGES
Breadcrumbs::for('admin_pages', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.PAGES'), route('pages.index'));
});

Breadcrumbs::for('admin_pages_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_pages');
    $trail->push($title, $url);
});

// TEMPLATE
Breadcrumbs::for('admin_template', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.TEMPLATE'), route('template.index'));
});

Breadcrumbs::for('admin_template_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_template');
    $trail->push($title, $url);
});

// ANNOUNCEMENT
Breadcrumbs::for('admin_announcement', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.ANNOUNCEMENT'), route('announcement.index'));
});

Breadcrumbs::for('admin_announcement_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_announcement');
    $trail->push($title, $url);
});

// TEACHING_MATERIALS
Breadcrumbs::for('admin_teaching_materials', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.TEACHING_MATERIALS'), route('teaching-materials.index'));
});

Breadcrumbs::for('admin_teaching_materials_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_teaching_materials');
    $trail->push($title, $url);
});
// GRADE
Breadcrumbs::for('admin_grade', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.GRADE'), route('grade.index'));
});

Breadcrumbs::for('admin_grade_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_grade');
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


Breadcrumbs::for('admin_email_template_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_email_template');
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
Breadcrumbs::for('system-setting-create', function ($trail) {
    //$trail->parent('system_setting');
    $trail->parent('admin_home');
    $trail->push(__('constant.SYSTEM_SETTING'));
    $trail->push(__('constant.CREATE'), url('/admin/system-setting/create'));
});
Breadcrumbs::for('system-setting-edit', function ($trail, $id) {
    //$trail->parent('system-setting');
    $trail->parent('admin_home');
    $trail->push(__('constant.SYSTEM_SETTING'));
    $trail->push(__('constant.EDIT'), url('/admin/system-setting/edit'. $id));
});

Breadcrumbs::for('roles-and-permission', function ($trail) {
	$trail->parent('admin_home');
    $trail->push('Roles and Permission', url('/admin/roles-and-permission'));

});

Breadcrumbs::for('create-roles-and-permission', function ($trail) {
	$trail->parent('admin_home');
    $trail->push('Roles and Permission', url('/admin/roles-and-permission'));
	$trail->push(__('constant.CREATE'), url('/admin/roles-and-permission/create'));
});

Breadcrumbs::for('edit-roles-and-permission', function ($trail, $id) {
	$trail->parent('roles-and-permission');
    $trail->push('Edit', url('/admin/edit-roles-and-permission/' . $id));
});

Breadcrumbs::for('create_role', function ($trail) {
    $trail->parent('roles-and-permission');
    $trail->push('Create Role', url('/admin/roles/create'));
});

Breadcrumbs::for('edit_role', function ($trail, $id) {
    $trail->parent('roles-and-permission');
    $trail->push('Edit Role', url('/admin/roles/edit/'.$id));
});

// QUESTION
Breadcrumbs::for('question', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.QUESTION_MANAGEMENT'), route('question.index'));
});

Breadcrumbs::for('question_crud', function ($trail, $title, $url = '#') {
    $trail->parent('question');
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

Breadcrumbs::for('instructor_account', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.INSTRUCTOR_ACCOUNT'), route('instructor-account.index'));
});

Breadcrumbs::for('instructor_account_crud', function ($trail, $title, $url = '#') {
    $trail->parent('instructor_account');
    $trail->push($title, $url);
});
// CATEGORY COMPETITION
Breadcrumbs::for('category_competition', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.CATEGORY_COMPETITION'), route('category-competition.index'));
});

Breadcrumbs::for('category_competition_crud', function ($trail, $title, $url = '#') {
    $trail->parent('category_competition');
    $trail->push($title, $url);
});

// GRADING EXAM
Breadcrumbs::for('grading_exam', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.GRADING_EXAM'), route('grading-exam.index'));
});

Breadcrumbs::for('grading_exam_crud', function ($trail, $title, $url = '#') {
    $trail->parent('grading_exam');
    $trail->push($title, $url);
});

// GRADING EXAM LIST
Breadcrumbs::for('admin_grading_exam_list', function ($trail, $exam) {
    $trail->parent('grading_exam', $exam);
    $trail->push(getExamName($exam), route('grading-exam-list.index', $exam));
});

Breadcrumbs::for('admin_grading_exam_list_crud', function ($trail, $exam, $title, $url = '#') {
    $trail->parent('admin_grading_exam_list', $exam);
    $trail->push($title, $url);
});

// TEST MANAGEMENT
Breadcrumbs::for('test_management', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.TEST_MANAGEMENT'), route('test-management.index'));
});

Breadcrumbs::for('test_management_crud', function ($trail, $title, $url = '#') {
    $trail->parent('test_management');
    $trail->push($title, $url);
});

// COURSE
Breadcrumbs::for('course', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.COURSE'), route('course.index'));
});

Breadcrumbs::for('course_crud', function ($trail, $title, $url = '#') {
    $trail->parent('course');
    $trail->push($title, $url);
});

// GRADING PAPER
Breadcrumbs::for('grading_paper', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.GRADING_PAPER'), route('grading-paper.index'));
});

Breadcrumbs::for('grading_paper_crud', function ($trail, $title, $url = '#') {
    $trail->parent('grading_paper');
    $trail->push($title, $url);
});



