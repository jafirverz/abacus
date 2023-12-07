@php

    $systemSetting = (object) \DB::table('system_settings')->pluck('title','key')->all();
    $sidebar = [
        [
            'menu_header'   =>  __('constant.DASHBOARD'),
            'main_menu' =>  [
                [
                    'title' =>  __('constant.DASHBOARD'),
                    'icon'  =>  '<i class="fas fa-tachometer-alt"></i>',
                    'url'   =>  'admin/home',
                    'idtag'  => 'dashboard',
                ],
            ],
        ],
        [
            'menu_header'   =>  __('constant.LOGS'),
            'main_menu' =>  [
                [
                    'title' =>  __('constant.ACTIVITYLOG'),
                    'icon'  =>  '<i class="fas fa-life-ring"></i>',
                    'url'   =>  'admin/activity-log',
                    'idtag'  => 'logs',
                ],
            ],
        ],
        [
            'menu_header'   =>  __('constant.ACHIEVEMENT'),
            'main_menu' =>  [
                [
                    'title' =>  __('constant.ACHIEVEMENT'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/achievement',
                    'idtag'  => 'achievement',
                ],
            ],
        ],
        [
            'menu_header'   =>  __('constant.COMPETITION'),
            'main_menu' =>  [
                [
                    'title' =>  __('constant.CATEGORY_COMPETITION'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/category-competition',
                    'idtag'  => 'categorycomp',
                ],
                [
                    'title' =>  __('constant.COMPETITION'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/competition',
                    'idtag'  => 'competition',
                ],
                [
                    'title' =>  __('Competition Papers'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/papers',
                    'idtag'  => 'papers',
                ],
                /*
                [
                    'title' =>  __('Online Competition Questions'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/comp-questions',
                    'idtag'  => 'compquestion',
                ],
                */
                [
                    'title' =>  __('constant.COMPETITION_ASSIGN'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/assign-competition',
                    'idtag'  => 'assigncomp',
                ],
                [
                    'title' =>  __('constant.COMPETITION_RESULT'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/results',
                    'idtag'  => 'results',
                ],
                [
                    'title' =>  __('constant.COMPETITION_RESULT_UPLOAD'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/comp-result',
                    'idtag'  => 'compresult',
                ],
            ],
        ],
        [
            'menu_header'   =>  __('constant.GRADE'),
            'main_menu' =>  [
                [
                    'title' =>  __('constant.GRADE'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/grade',
                    'idtag'  => 'grade',
                ],
                [
                    'title' =>  __('constant.CATEGORY_GRADING'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/category-grading',
                ],
                [
                    'title' =>  __('constant.GRADING_EXAM'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/grading-exam',
                    'idtag'  => 'gradingexam',
                ],
                [
                    'title' =>  __('constant.GRADING_PAPER'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/grading-paper',
                    'idtag'  => 'gradingpaper',
                ],
                [
                    'title' =>  __('constant.GRADING_ASSIGN'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/assign-grading',
                ],
                [
                    'title' =>  __('constant.GRADING_RESULT'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/g-results',
                ],
                [
                    'title' =>  __('constant.GRADING_RESULT_UPLOAD'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/grading-result-upload',
                    'idtag'  => 'gradingresuupload',
                ],
            ],
        ],
        [
            'menu_header'   =>  __('constant.TEST_MANAGEMENT'),
            'main_menu' =>  [
                [
                    'title' =>  __('constant.TEST_PAPER'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/test-paper',
                    'idtag'  => 'testpaper',
                ],
                [
                    'title' =>  __('constant.TEST_MANAGEMENT'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/test-management',
                    'idtag'  => 'testmanagement',
                ],
                [
                    'title' =>  __('constant.TEST_ALLOCATION'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/test-allocation',
                    'idtag'  => 'testallocation',
                ],

            ],
        ],
        [
            'menu_header'   =>  __('constant.MASTER'),
            'main_menu' =>  [
                [
                    'title' =>  __('constant.LEVEL'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/level',
                    'idtag'  => 'level',
                ],
                [
                    'title' =>  __('constant.LEARNING_LOCATION'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/learning-location',
                    'idtag'  => 'learninglocation',
                ],
                [
                    'title' =>  __('Worksheet Management'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/worksheet',
                    'idtag'  => 'worksheet',
                ],
                /*
                [
                    'title' =>  __('constant.QUESTION_MANAGEMENT'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/question',
                    'idtag'  => 'question',
                ],
                */
                [
                    'title' =>  __('constant.TEACHING_MATERIALS'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/teaching-materials',
                    'idtag'  => 'teachingmaterial',
                ],
                [
                    'title' =>  __('constant.ANNOUNCEMENT'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/announcement',
                    'idtag'  => 'announcement',
                ],
                /*
                [
                    'title' =>  __('constant.LESSON_MANAGEMENT'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/lessons',
                    'idtag'  => 'lessons',
                ],
                [
                    'title' =>  __('constant.LESSON_QUESTION_MANAGEMENT'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/lesson-questions',
                    'idtag'  => 'lessonsquestion',
                ],
                */
                [
                    'title' =>  __('constant.SURVEY'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/surveys',
                    'idtag'  => 'surveys',
                ],
                [
                    'title' =>  __('constant.SURVEY_QUESTIONS'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/survey-questions',
                    'idtag'  => 'surveyquestion',
                ],
                [
                    'title' =>  __('constant.SURVEY_QUESTIONS_OPTIONS'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/options-survey-questions',
                    'idtag'  => 'optionsurveyquestion',
                ],
                [
                    'title' =>  __('constant.OPTIONS_CHOICES'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/option-choices',
                    'idtag'  => 'optionchoices',
                ],
                [
                    'title' =>  __('constant.SURVEY_ALLOCATION'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/survey-allocation',
                    'idtag'  => 'surveyallocation',
                ],

                [
                    'title' =>  __('constant.STANDALONE_PAGE'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/standalone',
                    'idtag'  => 'standalone',
                ],
                [
                    'title' =>  __('constant.QUESTIONS_ATTEMPT'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/question-attempt',
                    'idtag'  => 'questionattempt',
                ],
                [
                    'title' =>  __('constant.CHALLENGE_BOARD_CLEAR'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/challenge',
                    'idtag'  => 'challenge',
                ],

            ],
        ],
        [
            'menu_header'   =>  __('constant.CMS'),
            'main_menu' =>  [
                [
                    'title' =>  __('constant.PAGES'),
                    'icon'  =>  '<i class="fas fa-file-invoice"></i>',
                    'url'   =>  'admin/pages',
                    'idtag'  => 'pages',
                ],
                [
                    'title' =>  __('Image Upload'),
                    'icon'  =>  '<i class="fas fa-file-invoice"></i>',
                    'url'   =>  'admin/image/upload',
                    'idtag'  => 'imageupload',
                ],
                [
                'title' => __('constant.MENUS'),
                'icon' => '<i class="fas fa-bars"></i>',
                'url' => '#',
                "sub_menu" =>[
                    [
                    'title' => __('constant.HEADER_MENU_TITLE'),
                    'icon' => '<i class="fas fa-bars"></i>',
                    'url' => 'admin/menu/list/header',
                    'idtag'  => 'menuheader',
                    ],
                    [
                    'title' => __('constant.FOOTER_MENU_TITLE'),
                    'icon' => '<i class="fas fa-bars"></i>',
                    'url' => 'admin/menu/list/footer',
                    'idtag'  => 'menufooter',
                    ]
                ]
                ],
                [
                    'title' =>  __('constant.BANNER_MANAGEMENT'),
                    'icon'  =>  '<i class="fas fa-images"></i>',
                    'url'   =>  'admin/banner-management',
                    'idtag'  => 'challenge',
                    'idtag'  => 'challenge',
                ],
                /*
                [
                    'title' =>  __('constant.CONTACT'),
                    'icon'  =>  '<i class="fas fa-phone"></i>',
                    'url'   =>  'admin/contact',
                ],
                */

                [
                    'title' =>  __('constant.EMAIL_TEMPLATE'),
                    'icon'  =>  '<i class="fas fa-envelope"></i>',
                    'url'   =>  'admin/email-template',
                    'idtag'  => 'emailtemplate',
                ],

            ],
        ],

        [
            'menu_header'   =>  __('constant.ROLES_AND_PERMISSION'),
            'main_menu' =>  [

                [
                    'title' =>  __('constant.USER_ACCOUNT'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/user-account',
                    'idtag'  => 'useraccount',
                ],
                [
                    'title' =>  __('constant.ROLES_AND_PERMISSION'),
                    'icon'  =>  '<i class="fas fa-key"></i>',
                    'url'   =>  'admin/roles-and-permission',
                    'idtag'  => 'rolespermission',
                ],
            ],
        ],
        [
            'menu_header'   =>  __('constant.USER_ACCOUNT'),
            'main_menu' =>  [
                [
                    'title' =>  __('constant.CUSTOMER_ACCOUNT'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/customer-account',
                    'idtag'  => 'customeraccount',
                ],
                [
                    'title' =>  __('constant.INSTRUCTOR_ACCOUNT'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/instructor-account',
                    'idtag'  => 'instructoraccount',
                ],
                [
                    'title' =>  __('constant.EXTERNAL_CENTRE_ACCOUNT'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/external-centre-account',
                    'idtag'  => 'externalcentreaccount',
                ],
                [
                    'title' =>  __('constant.COURSE'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/course',
                    'idtag'  => 'admincourse',
                ],
                [
                    'title' =>  __('constant.FEEDBACK'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/student-feedback',
                    'idtag'  => 'studentfeedback',
                ],
            ],
        ],
        [
            'menu_header'   =>  __('constant.ORDERS'),
            'main_menu' =>  [
                [
                    'title' =>  __('constant.ORDERS'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/orders',
                    'idtag'  => 'orders',
                ],
            ],
        ],
        [
            'menu_header'   =>  __('constant.INSTRUCTOR_CALENDAR'),
            'main_menu' =>  [
                [
                    'title' =>  __('constant.INSTRUCTOR_CALENDAR'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/instructor-calendar',
                    'idtag'  => 'instructorcalendar',
                ],
            ],
        ],
        // For Certificate

        [
            'menu_header'   =>  __('constant.USERSURVEY'),
            'main_menu' =>  [
                [
                    'title' =>  __('constant.USERSURVEY'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/survey-completed',
                    'idtag'  => 'surveycompleted',
                ],
            ],
        ],
        [
            'menu_header'   =>  __('constant.CERTIFICATE'),
            'main_menu' =>  [
                [
                    'title' =>  __('constant.CERTIFICATE'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/certificate',
                    'idtag'  => 'certificate',
                ],
            ],
        ],
        [
            'menu_header'   =>  __('constant.REPORTS'),
            'main_menu' =>  [
                [
                    'title' =>  __('constant.SALES_REPORTS'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/reports-sales',
                    'idtag'  => 'reportssales',
                ],
                [
                    'title' =>  __('constant.STUDENT_REPORTS'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/reports-student',
                    'idtag'  => 'reportsstudent',
                ],
                [
                    'title' =>  __('constant.INSTRUCTOR_REPORTS'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/reports-instructor',
                    'idtag'  => 'reportsinstructor',
                ],
                [
                    'title' =>  __('constant.WORKSHEET_REPORTS'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/reports-worksheet',
                    'idtag'  => 'reportsworksheet',
                ],
                [
                    'title' =>  __('constant.EXTERNAL_CENTRE_REPORT'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/reports-external-centre',
                    'idtag'  => 'reportsexternal',
                ],
                [
                    'title' =>  __('constant.GRADING_EXAMINATION_REPORTS'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/reports-grading-examination',
                    'idtag'  => 'reportsgrading',
                ],
                [
                    'title' =>  __('constant.COMPETITION_REPORTS'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/reports-competition',
                    'idtag'  => 'reportscompetition',
                ],
            ],
        ],
    ];

    $sidebar = json_decode(json_encode($sidebar));
    //dd($sidebar);
    function hasChildUrl($url, $sub_menu)
    {
        foreach($sub_menu as $value)
        {
            if(strpos($url, $value->url)!==false)
            {
                return true;
            }
        }
        return false;
    }
@endphp

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">

            <a href="{{ url('admin/home') }}"><img style="width:150px" src=" {{ isset($systemSetting->backend_logo) ? asset($systemSetting->backend_logo) : '' }}"/></a>

        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('admin/home') }}"><img style="width:32px" src=" {{ isset(systemSetting()->favicon) ? asset(systemSetting()->favicon) : '' }}"/></a>
        </div>
        <ul class="sidebar-menu">
            @if($sidebar)
            @foreach ($sidebar as $item)
            <li class="menu-header">{{ $item->menu_header }}</li>
            @foreach ($item->main_menu as $mainitem)
            <li
                class="dropdown @if(property_exists($mainitem, 'sub_menu') && hasChildUrl(url()->current(), $mainitem->sub_menu)!==false)  active @elseif(Str::contains(url()->current(), $mainitem->url)!==false) active @endif" id="{{ $mainitem->idtag ?? '' }}">
                <a href="{{ url($mainitem->url) }}" 
                    class="@if(property_exists($mainitem, 'sub_menu')) has-dropdown @endif nav-link">{!! $mainitem->icon
                    !!}<span>{{ $mainitem->title }}</span></a>
                @if(property_exists($mainitem, 'sub_menu'))
                <ul class="dropdown-menu" @if(hasChildUrl(url()->current(), $mainitem->sub_menu)!==false)
                    style="display:block;" @endif>
                    @if($mainitem->sub_menu)
                    @foreach ($mainitem->sub_menu as $subitem)
                    <li @if(Str::contains(url()->current(), $subitem->url)!==false) class="active" @endif><a
                            href="{{ url($subitem->url) }}" class="nav-link">{{ $subitem->title }}</a></li>
                    @endforeach
                    @endif
                </ul>
                @endif
            </li>
            @endforeach
            @endforeach
            @endif
        </ul>
    </aside>
</div>
