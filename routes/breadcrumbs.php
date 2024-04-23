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
// INSTRUCTOR CALENDAR
Breadcrumbs::for('admin_instructor_calendar', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.INSTRUCTOR_CALENDAR'), route('instructor-calendar.index'));
});

Breadcrumbs::for('admin_instructor_calendar_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_instructor_calendar');
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

// ACHIEVEMENT
Breadcrumbs::for('admin_achievement', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.ACHIEVEMENT'), route('achievement.index'));
});

Breadcrumbs::for('admin_achievement_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_achievement');
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
Breadcrumbs::for('admin_location', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.CONTACT'), route('contact.index'));
});

Breadcrumbs::for('admin_contact_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_contact');
    $trail->push($title, $url);
});
//LEARNING_LOCATION
Breadcrumbs::for('admin_learning_location', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.LEARNING_LOCATION'), route('learning-location.index'));
});

Breadcrumbs::for('admin_learning_location_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_learning_location');
    $trail->push($title, $url);
});
//SUB_HEADING
Breadcrumbs::for('admin_sub_heading', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.SUB_HEADING'), route('sub-heading.index'));
});

Breadcrumbs::for('admin_sub_heading_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_sub_heading');
    $trail->push($title, $url);
});
//COUNTRY
Breadcrumbs::for('admin_country', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.COUNTRY'), route('country.index'));
});

Breadcrumbs::for('admin_country_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_country');
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
//EXTERNAL_CENTRE_ACCOUNT
Breadcrumbs::for('external_centre_account', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.EXTERNAL_CENTRE_ACCOUNT'), route('external-centre-account.index'));
});

Breadcrumbs::for('external_centre_account_crud', function ($trail, $title, $url = '#') {
    $trail->parent('external_centre_account');
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


// CATEGORY GRADING
Breadcrumbs::for('category_grading', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.CATEGORY_GRADING'), route('category-grading.index'));
});

Breadcrumbs::for('category_grading_crud', function ($trail, $title, $url = '#') {
    $trail->parent('category_grading');
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

// TEST ALLOCATION
Breadcrumbs::for('test_allocation', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.TEST_ALLOCATION'), route('test-allocation.index'));
});

Breadcrumbs::for('test_allocation_crud', function ($trail, $title, $url = '#') {
    $trail->parent('test_allocation');
    $trail->push($title, $url);
});
// SURVEY ALLOCATION
Breadcrumbs::for('survey_allocation', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.SURVEY_ALLOCATION'), route('survey-allocation.index'));
});

Breadcrumbs::for('survey_allocation_crud', function ($trail, $title, $url = '#') {
    $trail->parent('survey_allocation');
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

// TEST PAPER
Breadcrumbs::for('test_paper', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.TEST_PAPER'), route('test-paper.index'));
});

Breadcrumbs::for('test_paper_crud', function ($trail, $title, $url = '#') {
    $trail->parent('test_paper');
    $trail->push($title, $url);
});

// TEST PAPER QUIESTION
Breadcrumbs::for('admin_test_paper_question', function ($trail, $paper) {
    $trail->parent('test_paper', $paper);
    $trail->push(getPaperName($paper), route('test-paper-question.index', $paper));
});

Breadcrumbs::for('admin_test_paper_question_crud', function ($trail, $paper, $title, $url = '#') {
    $trail->parent('admin_test_paper_question', $paper);
    $trail->push($title, $url);
});



