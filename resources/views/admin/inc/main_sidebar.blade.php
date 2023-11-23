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
                ],
                [
                    'title' =>  __('constant.COMPETITION'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/competition',
                ],
                [
                    'title' =>  __('Competition Papers'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/papers',
                ],
                [
                    'title' =>  __('Online Competition Questions'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/comp-questions',
                ],
                [
                    'title' =>  __('constant.COMPETITION_ASSIGN'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/assign-competition',
                ],
                [
                    'title' =>  __('constant.COMPETITION_RESULT'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/results',
                ],
                [
                    'title' =>  __('constant.COMPETITION_RESULT_UPLOAD'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/comp-result',
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
                ],
                [
                    'title' =>  __('constant.GRADING_EXAM'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/grading-exam',
                ],
                [
                    'title' =>  __('constant.GRADING_PAPER'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/grading-paper',
                ],
                [
                    'title' =>  __('constant.GRADING_RESULT'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/grading-students',
                ],
                [
                    'title' =>  __('constant.GRADING_RESULT_UPLOAD'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/grading-result-upload',
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
                ],
                [
                    'title' =>  __('constant.TEST_MANAGEMENT'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/test-management',
                ],
                [
                    'title' =>  __('constant.TEST_ALLOCATION'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/test-allocation',
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
                ],
                [
                    'title' =>  __('Topics'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/topic',
                ],
                [
                    'title' =>  __('Worksheet Management'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/worksheet',
                ],

                [
                    'title' =>  __('constant.QUESTION_MANAGEMENT'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/question',
                ],

                [
                    'title' =>  __('constant.TEACHING_MATERIALS'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/teaching-materials',
                ],
                [
                    'title' =>  __('constant.ANNOUNCEMENT'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/announcement',
                ],
                /*
                [
                    'title' =>  __('constant.LESSON_MANAGEMENT'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/lessons',
                ],
                [
                    'title' =>  __('constant.LESSON_QUESTION_MANAGEMENT'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/lesson-questions',
                ],
                */
                [
                    'title' =>  __('constant.SURVEY'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/surveys',
                ],
                [
                    'title' =>  __('constant.SURVEY_QUESTIONS'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/survey-questions',
                ],
                [
                    'title' =>  __('constant.SURVEY_QUESTIONS_OPTIONS'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/options-survey-questions',
                ],
                [
                    'title' =>  __('constant.OPTIONS_CHOICES'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/option-choices',
                ],
                [
                    'title' =>  __('constant.SURVEY_ALLOCATION'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/survey-allocation',
                ],

                [
                    'title' =>  __('constant.STANDALONE_PAGE'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/standalone',
                ],
                [
                    'title' =>  __('constant.QUESTIONS_ATTEMPT'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/question-attempt',
                ],
                [
                    'title' =>  __('constant.CHALLENGE_BOARD_CLEAR'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/challenge',
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
                ],
                [
                    'title' =>  __('Image Upload'),
                    'icon'  =>  '<i class="fas fa-file-invoice"></i>',
                    'url'   =>  'admin/image/upload',
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
                    ],
                    [
                    'title' => __('constant.FOOTER_MENU_TITLE'),
                    'icon' => '<i class="fas fa-bars"></i>',
                    'url' => 'admin/menu/list/footer',
                    ]
                ]
                ],
                [
                    'title' =>  __('constant.BANNER_MANAGEMENT'),
                    'icon'  =>  '<i class="fas fa-images"></i>',
                    'url'   =>  'admin/banner-management',
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
                ],
                [
                    'title' =>  __('constant.ROLES_AND_PERMISSION'),
                    'icon'  =>  '<i class="fas fa-key"></i>',
                    'url'   =>  'admin/roles-and-permission',
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
                ],
                [
                    'title' =>  __('constant.INSTRUCTOR_ACCOUNT'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/instructor-account',
                ],
                [
                    'title' =>  __('constant.EXTERNAL_CENTRE_ACCOUNT'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/external-centre-account',
                ],
                [
                    'title' =>  __('constant.COURSE'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/course',
                ],
                [
                    'title' =>  __('constant.FEEDBACK'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/student-feedback',
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
                ],
                [
                    'title' =>  __('constant.STUDENT_REPORTS'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/reports-student',
                ],
                [
                    'title' =>  __('constant.INSTRUCTOR_REPORTS'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/reports-instructor',
                ],
                [
                    'title' =>  __('constant.WORKSHEET_REPORTS'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/reports-worksheet',
                ],
                [
                    'title' =>  __('constant.EXTERNAL_CENTRE_REPORT'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/reports-external-centre',
                ],
                [
                    'title' =>  __('constant.GRADING_EXAMINATION_REPORTS'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/reports-grading-examination',
                ],
                [
                    'title' =>  __('constant.COMPETITION_REPORTS'),
                    'icon'  =>  '<i class="fas fa-user"></i>',
                    'url'   =>  'admin/reports-competition',
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
                class="dropdown @if(property_exists($mainitem, 'sub_menu') && hasChildUrl(url()->current(), $mainitem->sub_menu)!==false)  active @elseif(Str::contains(url()->current(), $mainitem->url)!==false) active @endif">
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
