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

                [
                    'title' =>  __('constant.CONTACT'),
                    'icon'  =>  '<i class="fas fa-phone"></i>',
                    'url'   =>  'admin/contact',
                ],

                [
                    'title' =>  __('constant.EMAIL_TEMPLATE'),
                    'icon'  =>  '<i class="fas fa-envelope"></i>',
                    'url'   =>  'admin/email-template',
                ],

            ],
        ],
        [
            'menu_header'   =>  __('constant.MODULES'),
            'main_menu' =>  [
                [
                    'title' =>  __('constant.LOAN_APPLICATION'),
                    'icon'  =>  '<i class="fas fa-check"></i>',
                    'url'   =>  'admin/loan-application',
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
