<?php

use App\Admin;
use App\PermissionAccess;
use Yadahan\AuthenticationLog\AuthenticationLog;
use App\Announcement;
use App\Page;
use App\Course;
use App\CourseAssignToUser;
use App\Slider;
use App\GradingExam;
use App\GradingPaper;
use App\GradingPaperQuestion;
use App\GradingStudentResults;
use App\TestPaper;
use App\PaperCategory;
use App\TestPaperDetail;
use App\TestPaperQuestionDetail;
use App\GradingListingDetail;
use App\Role;
use App\User;
use App\Menu;
use App\SystemSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\MenuList;
use App\Banner;

if (!function_exists('getPageList')) {

    /**
     * description
     *
     * @param
     * @return
     */

    function guid()
    {
        return uniqid();
    }

    function generatePINumber()
    {
        return uniqid('PI');
    }

    function generateTransactionNumber()
    {
        return uniqid('TNX');
    }

	function systemSetting()
    {
        return (object) SystemSetting::pluck('title','key')->all();
    }

    function getPageList($pages, $parent_ids = [0], $indent = 0)
    {
        $data = '';
        if ($pages) {
            $i = 0;
            $array = $pages->whereIn('parent', $parent_ids);
            foreach ($parent_ids as $parent_id) {
                foreach ($array as $key => $value) {
                    $pageKeys =  session('page_key');
                    if (isset($_GET['status']) && $_GET['status'] == 2 && !in_array($value['id'], session('page_key'))) {
                        $pageKeys[] = $value['id'];
                        session(['page_key' => $pageKeys]);
                        $pages = $pages->whereNotIn('id', session('page_key'));

                        $i++;
                        $status_icon = '<div class="badge badge-danger">' . getActiveStatus($value['status']) . '</div>';
                        if ($value['status'] == 1) {
                            $status_icon = '<div class="badge badge-success">' . getActiveStatus($value['status']) . '</div>';
                        }
                        $data .= '<tr>';

                        if ($value['slug'] != 'home') {
                            $data .= '<td scope="row">
					<div class="custom-checkbox custom-control"> <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-' . ($key + 1) . '" value="' . $value['id'] . '"> <label for="checkbox-' . ($key + 1) . '" class="custom-control-label">&nbsp;</label></div></td>';
                        } else {
                            $data .= '<td scope="row">';
                        }
                        $data .= '<td>' . $i . '</td>';
                        $data .= '<td>';
                        $data .= '<a href="' . route('pages.show', $value['id']) . '" class="btn btn-info mr-1 mt-1" data-toggle="tooltip" data-original-title="View"><i class="fas fa-eye"></i></a>';
                        $data .= '<a href="' . route('pages.edit', $value['id']) . '" class="btn btn-light mr-1 mt-1" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>';
                        $data .= '</td>';
                        $data .= '<td>';
                        $data .= str_repeat('<i class="fas fa-minus"></i> &nbsp;', $indent);
                        $data .= $value['title'] . '</td>';
                        $data .= '<td>' . $value['view_order'] . '</td>';
                        $data .= '<td>' . $status_icon . '</td>';
                        $data .= '<td>' . date('d M, Y h:i A', strtotime($value['created_at'])) . '</td>';
                        $data .= '<td>' . date('d M, Y h:i A', strtotime($value['updated_at'])) . '</td>';
                        $data .= '</tr>';
                        //$data .= getPageList($array, $value['id'], $indent + 1);

                    } else {
                        if ($value['parent'] == $parent_id && !in_array($value['id'], session('page_key'))) {
                            $pageKeys[] = $value['id'];
                            session(['page_key' => $pageKeys]);
                            $pages = $pages->whereNotIn('id', session('page_key'));
                            $i++;
                            $status_icon = '<div class="badge badge-danger">' . getActiveStatus($value['status']) . '</div>';
                            if ($value['status'] == 1) {
                                $status_icon = '<div class="badge badge-success">' . getActiveStatus($value['status']) . '</div>';
                            }
                            $data .= '<tr>';

                            if ($value['slug'] != 'home') {
                                $data .= '<td scope="row">
					<div class="custom-checkbox custom-control"> <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-' . ($key + 1) . '" value="' . $value['id'] . '"> <label for="checkbox-' . ($key + 1) . '" class="custom-control-label">&nbsp;</label></div></td>';
                            } else {
                                $data .= '<td scope="row">';
                            }
                            $data .= '<td>' . $i . '</td>';
                            $data .= '<td>';
                            $data .= '<a href="' . route('pages.show', $value['id']) . '" class="btn btn-info mr-1 mt-1" data-toggle="tooltip" data-original-title="View"><i class="fas fa-eye"></i></a>';
                            $data .= '<a href="' . route('pages.edit', $value['id']) . '" class="btn btn-light mr-1 mt-1" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>';
                            $data .= '</td>';
                            $data .= '<td>';
                            $data .= str_repeat('<i class="fas fa-minus"></i> &nbsp;', $indent);
                            $data .= $value['title'] . '</td>';
                            $data .= '<td>' . $value['view_order'] . '</td>';
                            $data .= '<td>' . $status_icon . '</td>';
                            $data .= '<td>' . date('d M, Y h:i A', strtotime($value['created_at'])) . '</td>';
                            $data .= '<td>' . date('d M, Y h:i A', strtotime($value['updated_at'])) . '</td>';
                            $data .= '</tr>';
                            $data .= getPageList($pages, [$value['id']], $indent + 1);
                        }
                    }
                }
            }
        }
        return $data;
    }

    function getPageTitle($id)
    {
        if ($id != 0) {
            $details = Page::where('id', $id)
                ->select('title')
                ->where('id', $id)
                ->first();

            return $details->title;
        } else {
            return '-';
        }
    }

    function getParentPages()
    {

        $pages = Page::where('parent', 0)
            ->select('pages.*')
            ->get();
        if ($pages)
            return $pages;
        else
            return NULL;
    }

	function getFormStatus($id = null)
    {
        $array_list = ['1'  =>  'Active', '2'  =>  'Deactive'];
        if ($id) {
            return $array_list[$id];
        }
        return $array_list;
    }


    function getPaperType($id = null)
    {
        $array_list = ['1'  =>  'Test', '2'  =>  'Lesson'];
        if ($id) {
            return $array_list[$id];
        }
        return $array_list;
    }

    function getDropdownPageList($array, $parent_page_id, $parent_id = 0, $indent = 0)
    {
        $data = '';
        if ($array) {
            foreach ($array as $key => $value) {
                if ($value['parent'] == $parent_id) {
                    $selected = '';
                    if ($parent_page_id == $value['id']) {
                        $selected = 'selected';
                    }
                    $data .= '<option  value="' . $value['id'] . '" ' . $selected . '>';
                    $data .= str_repeat('__ &nbsp;', $indent);
                    $data .= $value['title'] . '</option>';
                    $data .= getDropdownPageList($array, $parent_page_id, $value['id'], $indent + 1);
                }
            }
        }
        return $data;
    }

    function getCountry($id = null)
    {
        $country_list = DB::table('country')->orderBy('country', 'asc')->get();
        $country_arr = [];
        $i = 0;
        foreach ($country_list as $country) {
            $i++;
            $country_arr[$i] =    $country->country;
        }
        if ($id) {
            if(isset($country_arr[$id]))
            {
                return $country_arr[$id];
            }
            else
            {
                return NULL;
            }

        }
        return $country_arr;
    }

    function get_category_paper_list($comprtetion_id,$category)
    {
        $list = PaperCategory::where('competition_id',$comprtetion_id)->where('category_id',$category)->get();
        if($list)
        {
            return $list;
        }

           return null;
    }

    function getUserTypes($id = null)
    {
        $user_types = DB::table('user_types')->where('id','!=',5)->orderBy('id', 'asc')->get();
        $types_arr = [];
        $i = 0;
        foreach ($user_types as $type) {
            $i++;
            $types_arr[$type->id] =    $type->name;
        }
        if ($id) {
            if(isset($types_arr[$id]))
            {
                return $types_arr[$id];
            }
            else
            {
                return NULL;
            }

        }
        return $types_arr;
    }


    function getChildPage($array, $page_id, $indent = 0)
    {
        $data = '';
        if ($array) {
            foreach ($array as $key => $value) {
                if ($value['id'] == $page_id) {
                    $parent_icon = str_repeat('&nbsp; <i class="fas fa-chevron-right"></i> &nbsp;', $indent);
                    $data .= getChildPage($array, $value['parent'], $indent = 1);
                    $data .= $value['title'] . $parent_icon;
                }
            }
        }
        return $data;
    }

    function getQuestionTemplate($id = null)
    {
        $array_list = ['1'  =>  'Listening Questions', '2'  =>  'Visual Flashing Questions' , '3' => 'Number Questions', '4' => 'Add and subtract Questions', '5' => 'Multiply and Divide Questions', '6' => 'Challenge Questions', '7' => 'Mixed Questions', '8' => 'Abacus simulator Questions', '9' => 'Online Lessons'];
        if ($id) {
            return $array_list[$id];
        }
        return $array_list;
    }

    function getActiveStatus($id = null)
    {
        $array_list = ['1'  =>  'Active', '2'  =>  'Inactive'];
        if ($id) {
            return $array_list[$id];
        }
        return $array_list;
    }

    function getStatuses($id = null)
    {
        $array_list = ['1'  =>  'Active', '2'  =>  'Draft'];
        if ($id) {
            return $array_list[$id];
        }
        return $array_list;
    }

    function input_types($id = null)
    {
        $array_list = ['1' => 'Textbox', '2' => 'Dropdown', '3' => 'Datepicker', '4' => 'Upload', '5' => 'Radio button', '6' => 'Number', '7' => 'URL Link'];
        if ($id) {
            return $array_list[$id];
        }
        return $array_list;
    }




    function getCauserIp($causer_id)
    {
        if ($causer_id) {
            $result = AuthenticationLog::where('authenticatable_id', $causer_id)->first();
            if ($result) {
                return $result->ip_address;
            }
        }
        return '-';
    }

    function getActivePage($array, $page_id)
    {
        if ($array) {
            $result = $array->where('id', $page_id)->first();
            if ($result) {
                return $result->title;
            } else {
                return '-';
            }
        }
    }

    function getModules($module = null)
    {

        $array_list = [
            'SYSTEM_SETTING', 'ACTIVITY_LOG', 'STATUS', 'PAGES', 'MENU', 'MENU_LIST', 'HOME_BANNER', 'PAGE_BANNER',
            'EMAIL_TEMPLATE', 'TEMPLATE', 'USER_ACCOUNT', 'ROLES_AND_PERMISSION',  'CUSTOMER_ACCOUNT','INSTRUCTOR_ACCOUNT',
            'BANNER_MANAGEMENT','QUESTION_MANAGEMENT','TOPIC','LEVEL','WORKSHEET'

        ];

        return $array_list;
    }

    function getPosition($id = null)
    {
        // $array_list = ['1'  =>  'Top', '2'  =>  'Right',    '3' =>  'Bottom', '4'   =>  'Left'];
        $array_list = ['1'  =>  'Top'];
        if ($id) {
            return $array_list[$id];
        }
        return $array_list;
    }
    function get_permission_access_value($type, $module, $value, $role_id = null)
    {
        $permission_access = PermissionAccess::where(['role_id' => $role_id, $type => $value, 'module' => $module])->get();
        if ($permission_access->count()) {
            return 'checked';
        }
    }

	function get_active_modules($role_id = null)
    {
        //DB::enableQueryLog();
		$modules = PermissionAccess::where('role_id',$role_id)
		                             ->where(function($query){
                                         $query->where('deletes',1)->orWhere('views',1)->orWhere('creates',1)->orWhere('edits',1);
                                     })->pluck('module');
									 //dd(DB::getQueryLog());
        $module_list=[];
		if ($modules->count()) {
            foreach($modules as $key=>$val)
			{
				$module_list[]=$val;
			}
			if($module_list)
		    {
		    return implode(', ',$module_list);
		    }
			else
			{
			return '';
			}
        }
    }

    function is_permission_allowed($admin_id, $role_id, $module, $type)
    {
        if ($admin_id == 1) {
            return false;
        }
        $query = PermissionAccess::join('admins', 'permission_accesses.role_id', '=', 'admins.admin_role');
        if ($role_id) {
            $query->where('admins.id', $admin_id);
            $query->where('permission_accesses.role_id', $role_id);
            $query->where('permission_accesses.' . $type, 1);
            $query->where('permission_accesses.module', $module);
        }
        $permission_access = $query->get();
        if (!$permission_access->count()) {
            abort(redirect()->route('access-not-allowed'));
        }
    }

    function getRoleName($role_id)
    {
        $result = Role::find($role_id);
        if ($result) {
            return $result->name;
        }
        return '-';
    }

    function getMenuName($menu)
    {
        $result = Menu::find($menu);
        if ($result) {
            return $result->title;
        }
    }
    function getExamName($exam)
    {
        $result = GradingExam::find($exam);
        if ($result) {
            return $result->title;
        }
    }
    function getPaperName($paper)
    {
        $result = TestPaper::find($paper);
        if ($result) {
            return $result->title;
        }
    }

    function getPaperDetail($paper)
    {
        $result = TestPaper::find($paper);
        if ($result) {
            return $result;
        }
    }

    function getExamDetail($exam)
    {
        $result = GradingExam::find($exam);
        if ($result) {
            return $result;
        }
    }
    function getAllGradingExam()
    {
        $result = GradingExam::get();
        if ($result) {
            return $result;
        }
    }
    function getAllGradingExamListDetail($id)
    {
        $result = GradingListingDetail::where('grading_listing_id',$id)->get();
        if ($result) {
            return $result;
        }
         return NULL;
    }

    function getGradingStudentResult($grading_id,$user_id)
    {
        $result = GradingStudentResults::where('grading_id',$grading_id)->where('user_id',$user_id)->first();
        if ($result) {
            return $result;
        }
         return NULL;
    }

    function getAllQuestions($id)
    {
        $result = TestPaperQuestionDetail::where('test_paper_question_id',$id)->get();
        if ($result) {
            return $result;
        }
         return NULL;
    }

    function getPaperQuestions($id)
    {
        $result = GradingPaperQuestion::where('grading_paper_question_id',$id)->get();
        if ($result) {
            return $result;
        }
         return NULL;
    }
    function getAllGradingPaper()
    {
        $result = GradingPaper::get();
        if ($result) {
            return $result;
        }
    }
    function activePageHierarchy($page_id)
    {
        $pageIds = [];
        $pageId = $page_id;
        do {
            $page = Page::where('id', $pageId)->where('status', 1)->first();
            $pageIds[] = $page->id;
            $pageId = $page->parent;
        } while ($page->parent != 0);
        return $pageIds;
    }
    function get_parent_menu($position = NULL, $page_id = 1)
    {
        $string = [];
        $menus = MenuList::where('menu_lists.menu_id', $position)
            ->where('menu_lists.status', 1)
            ->select('menu_lists.*')
            ->orderBy('view_order', 'asc')
            ->get();
        if (!$menus->count()) {
            return " ";
        }
        $menuIds = $menus->pluck('page_id')->all();
        $pages = Page::whereIn('id', $menuIds)->where('status', 1)->first();
        $activePageIds = activePageHierarchy($page_id);
        if ($menus->count() > 0) {
            $string[] = '<ul>';
            foreach ($menus as $menu) {
                $link = "#";
                $title = $menu->title;
                $target = "_self";
                $sel = '';
                $fragmentId = "";
                $parent = 0;
                $childPages = collect([]);
                if ($menu->page_id) {
                    $page = $pages->where('id', $menu->page_id)->first();
                    if ($page) {
                        $link = $page->external_link ?  $page->external_link_value : url($page->slug);

                        //?!! fragment is for # id
                        $fragmentId = parse_url($link, PHP_URL_FRAGMENT);

                        $title = $page->parent == 0 ?  $menu->title : $page->title;
                        $target = $page->target;
                        $parent = $page->parent;
                        $childPages = $pages->where('parent', $page->id)->get();
                        if (in_array($page->id, $activePageIds)) {
                            $sel = "active";
                        }
                    }
                }

                $string[] = '<li class="' . $sel . '"><a class="target target-' . $fragmentId . '"  target="' . $target . '" href="' . $link . '">' .  $title . '</a>';
                if ($childPages->count()) {
                    $string[] = get_sub_menus($pages, $childPages, $activePageIds);
                }
                $string[] = '</li>';
            }
            $string[] = '</ul>';
        }
        return join("", $string);
    }

    function get_sub_menus($pages, $subpages, $activePageIds)
    {
        if ($subpages->count()) {
            $string[] = '<ul>';
            foreach ($subpages as $page) {
                $link = $page->external_link ?  $page->external_link_value : url($page->slug);

                //?!! fragment is for # id
                $fragmentId = parse_url($link, PHP_URL_FRAGMENT);

                $title = $page->title;
                $target = $page->target;
                $parent = $page->parent;
                $childPages = $pages->where('parent', $page->id)->get();
                $sel = '';
                if (in_array($page->id, $activePageIds)) {
                    $sel = 'active';
                }
                $string[] = '<li class="' . $sel . '"><a class="target target-' . $fragmentId . '" target="' . $target . '" href="' . $link . '">' .  $title . '</a>';
                if ($childPages->count()) {
                    $string[] = get_sub_menus($pages, $childPages, $activePageIds);
                }
                $string[] = '</li>';
            }
            $string[] = '</ul>';
            return join("", $string);
        }
    }


    function create_menu_link($item = [])
    {

        if ($item['page_id'] == NULL) {
            return $item['external_link'];
        } else {
            $page = Page::where('id', $item['page_id'])->select('pages.slug')->first();
            if (!$page) {
                return null;
            }
            return url($page['slug']);
        }
    }

    function get_page_by_slug($slug = NULL)
    {
        $page = Page::where('slug', $slug)->where('status', 1)->first();
        if ($page)
            return $page;
        else
            return null;
    }


    function get_sliders()
    {
        $slider = Slider::where('page_id', 1)->where('status', 1)->first();
        if ($slider)
            return $slider;
        else
            return null;
    }




    function get_faq_categories()
    {
        $categories = FaqCategory::all();
        if ($categories)
            return $categories;
        else
            return [];
    }



    function get_banner_by_page($page_id)
    {
        $banner = Banner::where('page_id', $page_id)->where('status', 1)->inRandomOrder()->first();
        if ($banner)
            return $banner;
        else
            return "";
    }




    function getGender($id = null)
    {
        $array_list = ['1' => 'Male', '2' => 'Female'];
        if ($id) {
            return $array_list[$id];
        }
        return $array_list;
    }

    function getRegisterStatus($id = null)
    {
        $array_list = ['1' => 'Approved', '2' => 'Not Approved'];
        if ($id) {
            return $array_list[$id];
        }
        return $array_list;
    }

    function getLinkTarget($id = null)
    {
        $array_list = ['_self'  =>  'Same Tab', '_blank'  =>  'New Tab'];
        if ($id) {
            return $array_list[$id];
        }
        return $array_list;
    }



	//Get user detail by email id
	function get_user_detail_by_email($email)
    {
        $user = User::where('email', $email)->first();
        if ($user)
            return $user;
        else
            return NULL;
    }


	function get_user_detail($id)
    {
        $user = User::find($id);
        if ($user)
            return $user;
        else
            return NULL;
    }


    function getUsers($admin_role)
    {
        $admins = Admin::where('admin_role', $admin_role)->get();
        if($admins)
        {
            return $admins;
        }
    }

	function getUserAdmin($id)
    {
        $admin = Admin::where('id', $id)->first();
        if($admin)
        {
            return $admin;
        }
		    return NULL;
    }

    function admin_last_login($id)
    {
        $authentication_log = DB::table('authentication_log')->where('authenticatable_id', $id)->orderby('id', 'desc')->first();
        if ($authentication_log) {
            return date('d M, Y h:i A', strtotime($authentication_log->login_at));
        }
        return "-";
    }

    function getYesNo($id = null)
    {
        $array_list = ['1' => 'Yes', '2' => 'No'];
        if ($id) {
            return $array_list[$id];
        }
        return $array_list;
    }

    function gradingExamType($id = null)
    {
        $array_list = ['1' => 'Physical', '2' => 'Online'];
        if ($id) {
            return $array_list[$id];
        }
        return $array_list;
    }


    function gradingExamLayout($id = null)
    {
        $array_list = ['1' => 'Vertical sum layout', '2' => 'Horizontal sum layout'];
        if ($id) {
            return $array_list[$id];
        }
        return $array_list;
    }


    function get_footer_menu($menuId = 2, $page_id = NULL, $title = true, $class = 'term')
    {

        $string = [];
        $menu = Menu::find($menuId);
        if (!$menu) {
            return " ";
        }

        $menus = MenuList::where('menu_lists.menu_id', $menuId)
            ->where('menu_lists.status', 1)
            ->select('menu_lists.*')
            ->orderBy('view_order', 'asc')
            ->get();
        if (!$menus->count()) {
            return " ";
        }
        $menuIds = $menus->pluck('page_id')->all();
        $pages = Page::whereIn('id', $menuIds)->where('status', 1)->get();
        if($page_id)
        {
            $activePageIds = activePageHierarchy($page_id);
        }

        if ($menus->count() > 0) {
            $string[] = "<ul class='$class'>";
            foreach ($menus as $menu) {
                $link = "#";
                $title = $menu->title;
                $target = "_self";
                $sel = '';
                $parent = 0;
                //$childPages = collect([]);
                if ($menu->page_id) {
                    $page = $pages->where('id', $menu->page_id)->first();
                    if ($page) {
                        $link = $page->external_link ?  $page->external_link_value : url($page->slug);
                        $title = $menu->title;
                        $target = $page->target;
                        $parent = $page->parent;
                        //$childPages = $pages->where('parent', $page->id)->get();
                        if (in_array($page->id, $activePageIds)) {
                            $sel = 'class="active"';
                        }
                    }
                }

                $string[] = '<li ' . $sel . '><a target="'. $target.'" href="' . $link . '">' .  $title . '</a>';
                /* if ($childPages->count()) {
                    $string[] = get_sub_menus($pages, $childPages, $activePageIds);
                } */
                $string[] = '</li>';
            }
            $string[] = '</ul>';
        }
        return join("", $string);
    }



    /* -------------------------------------------------------------------------- */
    /*                          Upload picture in storage                         */
    /* -------------------------------------------------------------------------- */
    /**
     * * Upload picture in storage
     * ? $file = file request object
     * ! $folder e.g banner
     */
    function uploadPicture($file, $folder)
    {
        $folder = str_replace(' ', '_', strtolower($folder));
        $filename = time() . "_" . $file->getClientOriginalName();
        Storage::putFileAs(
            'public/' . $folder,
            $file,
            $filename
        );
        $pathBanner = 'storage/' . $folder . '/' . $filename;
        return $pathBanner;
    }

    /* -------------------------------------------------------------------------- */
    /*               Image Resizer made from php core functionality               */
    /* -------------------------------------------------------------------------- */
    function imageResize($path, $frame_width, $frame_height)
    {
        $img_path = $path;

        if (file_exists($img_path)) {
            list($img_width, $img_height) = getimagesize($img_path);

            $file_extension = strtolower(pathinfo($img_path, PATHINFO_EXTENSION));

            if (in_array($file_extension, array('jpg', 'jpeg', 'JPG', 'JPEG')))
                $imagick = imagecreatefromjpeg($img_path);
            elseif (in_array($file_extension, array('png', 'PNG')))
                $imagick = imagecreatefrompng($img_path);
            elseif (in_array($file_extension, array('gif', 'GIF')))
                $imagick = imagecreatefromgif($img_path);
            else
                return FALSE;

            $frame = imagecreatetruecolor($frame_width, $frame_height);

            if (in_array($file_extension, array('png', 'PNG'))) {
                imagesavealpha($frame, true);
                $white_color = imagecolorallocatealpha($frame, 0, 0, 0, 127);
            } else {
                $white_color = imagecolorallocate($frame, 255, 255, 255);
            }

            imagefill($frame, 0, 0, $white_color);

            if ($img_width > $frame_width || $img_height > $frame_height) {
                if ($img_width > $img_height) {
                    $new_width = $frame_width;
                    $diff = $img_width - $frame_width;
                    $new_height = $img_height - (($diff / $img_width) * $img_height);

                    if ($new_height > $frame_height) {
                        $diff = $new_height - $frame_height;
                        $new_width = $new_width - (($diff / $new_height) * $new_width);
                        $new_height = $frame_height;
                    }
                } else {
                    $new_height = $frame_height;
                    $diff = $img_height - $frame_height;
                    $new_width = $img_width - (($diff / $img_height) * $img_width);

                    if ($new_width > $frame_width) {
                        $diff = $new_width - $frame_width;
                        $new_height = $new_height - (($diff / $new_width) * $new_height);
                        $new_width = $frame_width;
                    }
                }

                $new_x = ($frame_width - $new_width) / 2;
                $new_y = ($frame_height - $new_height) / 2;

                imagecopyresampled($frame, $imagick, $new_x, $new_y, 0, 0, $new_width, $new_height, $img_width, $img_height);
                imagedestroy($imagick);

                if (in_array($file_extension, array('png', 'PNG'))) {
                    imagepng($frame, $img_path, 0);
                } else {
                    imagejpeg($frame, $img_path, 100);
                }
                imagedestroy($frame);
            } else {
                $new_x = ($frame_width - $img_width) / 2;
                $new_y = ($frame_height - $img_height) / 2;
                imagecopyresampled($frame, $imagick, $new_x, $new_y, 0, 0, $img_width, $img_height, $img_width, $img_height);
                imagedestroy($imagick);
                if (in_array($file_extension, array('png', 'PNG'))) {
                    imagepng($frame, $img_path, 0);
                } else {
                    imagejpeg($frame, $img_path, 100);
                }
                imagedestroy($frame);
            }

            return TRUE;
        } else {
            return FALSE;
        }
    }




    function getAdminByRole($id)
    {
        $admin = Admin::where('admin_role', $id)->get();
        if($admin->count())
        {
            return $admin;
        }
    }

    function getAnnouncementsByTeacher($id)
    {
        $announcements = Announcement::where('teacher_id', $id)->get();
        if($announcements->count())
        {
            return $announcements;
        }
    }



    function getAllUsers()
    {
        $users = User::get();
        if($users)
        {
            return $users;
        }
    }

    /**
     * fileReadText(array $file_format, string $filesize, string $pixel_size)
     */
    function fileReadText($file_format = null, $filesize = null, $pixel_size = null)
    {
        $file_format = implode(', ', $file_format);

        $full_text = "";
        if ($file_format) {
            $full_text .= 'only ' . $file_format . ' supported file format ';
        }
        if ($filesize) {
            $full_text .= 'upto ' . $filesize . '. ';
        }
        if ($pixel_size) {
            $full_text .= 'Upload ' . $pixel_size . ' pixel size for better viewing experience.';
        }
        return ucFirst($full_text);
    }

    function getInstructor($instructor_id)
    {
        if ($instructor_id) {
            $result = User::where('id', $instructor_id)->first();
            if ($result) {
                return $result;
            }
        }
        return '-';
    }
}
