<?php

use App\Admin;
use App\Insurance;
use App\Filter;
use App\Specifications;
use App\Attributes;
use App\InsuranceInformation;
use App\InsuranceQuotation;
use App\InsuranceVehicle;
use App\Bank;
use App\PermissionAccess;
use Yadahan\AuthenticationLog\AuthenticationLog;
use App\Page;
use App\OneMotoring;
use App\Category;
use App\Faq;
use App\Partner;
use App\VehicleMain;
use App\VehicleDetail;
use App\Slider;
use App\Conversation;
use App\Banner;
use App\Menu;
use App\MenuList;
use App\Role;
use App\User;
use App\NotifyParty;
use App\CarEnquiry;
use App\ShippingAddress;
use App\UserConsignee;
use App\InsuranceCostSettings;
use App\Notification;
use App\OperationVendor;
use App\PaymentMode;
use App\SpContractTerm;
use App\SystemSetting;
use App\ViewCount;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\New_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;
use App\ReportVehicle;

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
            return $country_arr[$id];
        }
        return $country_arr;
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

    function getActiveStatus($id = null)
    {
        $array_list = ['1'  =>  'Active', '2'  =>  'Inactive'];
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
            'SYSTEM_SETTING', 'LOAN_CALCULATOR_SETTINGS', 'ACTIVITY_LOG', 'FAQ_CATEGORY', 'STATUS', 'LOCATION', 'PAGES', 'MENU', 'MENU_LIST', 'HOME_BANNER', 'PAGE_BANNER', 'ONE_MOTORING','CATEGORY',
            'FAQ', 'CONTACT_ENQUIRY', 'TESTIMONIAL',
            'EMAIL_TEMPLATE', 'MESSAGE_TEMPLATE', 'USER_ACCOUNT', 'ROLES_AND_PERMISSION',  'CUSTOMER_ACCOUNT', 'BANK' ,'BANNER_MANAGEMENT','INSURANCE_APPLICATION','PARTNER', 'LOAN_APPLICATION', 'SP_AGREEMENT','FILTER_MANAGEMENT','MARKETPLACE','ACCESSORIES','SPECIFICATION','QUOTE_REQUEST','INVOICE','CHAT_WINDOW_MANAGEMENT',
            'STA_INSPECTION'

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

    function get_specifications()
    {
        $specifications = Specifications::where('status', 1)->orderBy('position', 'asc')->get();
        if ($specifications)
        return $specifications;

        return null;
    }

    function get_attributes()
    {
        $attributes = Attributes::where('status', 1)->get();
        if ($attributes)
        return $attributes;

        return null;
    }
	//Get more shipping address by user
	function get_shipping_address_of_user($user_id)
    {
        $shipping_address = ShippingAddress::where('user_id',$user_id)->where('consignee_id', NULL)->get();
        if ($shipping_address)
        return $shipping_address;

        return NULL;
    }

	//Get more shipping address by consignee
	function get_shipping_address_of_consignee($user_id,$consignee_id)
    {
        $shipping_address = ShippingAddress::where('user_id',$user_id)->where('consignee_id',$consignee_id)->get();
        if ($shipping_address)
        return $shipping_address;

        return NULL;
    }

	//Get notify party by user
	function get_notify_party_of_user($user_id)
    {
        $notifyParty = NotifyParty::where('user_id',$user_id)->where('consignee_id', NULL)->first();
        if ($notifyParty)
        return $notifyParty;

        return NULL;
    }

	//Get notify party by consignee
	function get_notify_party_of_consignee($user_id,$consignee_id)
    {
        $notifyParty = NotifyParty::where('user_id',$user_id)->where('consignee_id', $consignee_id)->first();
        if ($notifyParty)
        return $notifyParty;

        return NULL;
    }

	//Get consignee
	function get_consignee($user_id)
    {
        $consignee = UserConsignee::where('user_id',$user_id)->get();

		if ($consignee)
        return $consignee;

        return NULL;
    }

	 function get_enquiry_by_user($user_id)
	 {
		 $enquiry_id = CarEnquiry::join('conversations','conversations.enquiry_id','=','car_enquiries.id')->select('car_enquiries.id')->where('car_enquiries.user_id',$user_id)->pluck('id');
		 if(isset($enquiry_id))
		 {
		 return $enquiry_id;
		 }
		 else
		 {
		 return NULL;
		 }
	 }

	 function get_enquiry_by_admin()
	 {
		 $enquiry_id = CarEnquiry::join('conversations','conversations.enquiry_id','=','car_enquiries.id')->select('car_enquiries.id')->pluck('id');
		 if(isset($enquiry_id))
		 {
		 return $enquiry_id;
		 }
		 else
		 {
		 return NULL;
		 }
	 }

	 function count_chat($id,$type)
	 {

		 $conversations =Conversation::whereIn('enquiry_id',$id)->get();
		 //print_r($conversations);
		 if(isset($conversations) && $conversations->count()>0)
		 {
			 $total=0;
			 foreach($conversations as $conversation)
			 {
				 if(isset($conversation->content))
		         {

					 $messages=json_decode($conversation->content);
					 $cnt=0;
					 for($i=0;$i<count($messages);$i++)
					 {
						if($messages[$i]->user_type==$type && $messages[$i]->read==0)
						{
						 $cnt++;
						}
					 }
					// echo $cnt;

				 }

				 $total+=$cnt;

			 }

			return $total;
		 }
		 else
		 {
		   return NULL;
		 }
	 }



	function get_one_motoring_by_category($category)
    {
        $results = OneMotoring::where('category_id',$category)->where('status',1)->get();

		if ($results)
        return $results;

        return NULL;
    }




    function get_faq_categories()
    {
        $categories = FaqCategory::all();
        if ($categories)
            return $categories;
        else
            return [];
    }

    function get_faq_category_title($id)
    {
        $category = FaqCategory::where('id', $id)->select('title')->first();
        if ($category)
            return $category->title;
        else
            return '-';
    }

    function get_banner_by_page($page_id)
    {
        $banner = Banner::where('page_id', $page_id)->where('status', 1)->inRandomOrder()->first();
        if ($banner)
            return $banner;
        else
            return "";
    }



    function replaceStrByValue($key, $value, $contents)
    {
        $newContents = str_replace($key, $value, $contents);
        return $newContents;
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



    function getGender($id = null)
    {
        $array_list = ['1' => 'Male', '2' => 'Female'];
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

	function getQuotation($id)
	{
	  $insuranceQuotation =InsuranceQuotation::find($id);
	        if ($insuranceQuotation)
            return $insuranceQuotation;
            return NULL;
	}
	//Get Notification by partner id
	function getQuotationByPartner($partner_id,$insurance_id)
	{
	  $insuranceQuotation =InsuranceQuotation::where('partner_id',$partner_id)->where('insurance_id',$insurance_id)->get();
	        if ($insuranceQuotation)
            return $insuranceQuotation;
            return NULL;
	}

    //Get Notification of partner
    function getNotifications()
	{
	    
	    if(Auth::user()->admin_role==1)
	    {
	        $notifications =Notification::where('insurance_id', null)->where('quotaton_id', null)->where('status', 1)->latest()->limit(10)->get();
	    }
	    else
	    {
	        $notifications =Notification::where('partner_id', Auth::user()->id)->where('status', 1)->latest()->limit(10)->get();
	    }
	    
        if($notifications->count())
        {
            return $notifications;
        }
        return false;
	}

    function getMakeModel()
    {
        $merge_array=$make=$model=[];
        $carDetails = vehicleDetail::select('vehicle_make','vehicle_model');
        $make=$carDetails->pluck('vehicle_make')->toArray();
        $model=$carDetails->pluck('vehicle_model')->toArray();
        $merge_array=array_merge($make,$model);
        return array_filter($merge_array);
    }

    function getFilterValByType($type=null)
    {
        $filters = Filter::where('type',$type)->orderBy('view_order', 'asc')->get();
        if($filters)
        {
            return $filters;
        }
            return null;
    }

    function getFilterValByVal($type=null,$val)
    {
        $val=explode('_',$val);
        $filters = Filter::where('type',$type)->where('from_value',$val[0])->where('to_value',$val[1])->first();
        if($filters)
        {
            return $filters->title;
        }
            return null;
    }


	function get_current_year()
	{
		$year=[];
		$cur_year=date('Y');

		for($i=0;$i<20;$i++)
		{
		$year[]=$cur_year-$i;
		}
		return $year;
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

    function generateAgreementID()
    {
        return uniqid('AID');
    }



    function getYesNo($id = null)
    {
        $array_list = ['1' => 'Yes', '2' => 'No'];
        if ($id) {
            return $array_list[$id];
        }
        return $array_list;
    }






    function send_sms($recipient, $message)
    {
        if (empty($recipient)) {
            return 0;
        }
        $recipient = '65' . $recipient;
        if (strlen($recipient) != 10) {
            $status = 0;
        } else {
            $status = 0;
            $app_id = config('system_settings')->app_id;
            $app_secret = config('system_settings')->app_secret;
            $url = "http://www.smsdome.com/api/http/sendsms.aspx?appid=" . urlencode($app_id) . "&appsecret=" . urlencode($app_secret) . "&receivers=" . urlencode($recipient) . "&content=" . urlencode($message) . "&responseformat=JSON";
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $response = json_decode($result);
            curl_close($ch);
            if ($response->result->status == 'OK') {
                $status = 1;
            }
        }
        return $status;
    }

    function features($type)
    {
        $detail = Feature::select('item_ids')->where('item_type', $type)->first();
        $featureIds = [];
        if ($detail) {
            $array = json_decode($detail->item_ids);
            $featureIds = is_array($array) ? $array : [];
        }
        return $featureIds;
    }
    function storeFeatures($type, $itemIds)
    {
        $detail = Feature::where('item_type', $type)->first();
        if (!$detail) {
            $detail = new Feature();
            $detail->item_type = $type;
        }
        $detail->item_ids = json_encode($itemIds);
        $detail->save();
        return "success";
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


    function getForms($id, $form_id)
    {
        $forms = Form::where('form_module_id', $id)->where('form_type', $form_id)->active()->get();
        if($forms)
        {
            return $forms;
        }
    }

    function getCheckList($id, $checklist_id)
    {
        $checklist = Checklist::where('checklist_module_id', $id)->where('checklist_type', $checklist_id)->active()->get();
        if($checklist)
        {
            return $checklist;
        }
    }

    function getFormList($id, $form_id)
    {
        $form_list = Form::where('form_module_id', $id)->where('form_type', $form_id)->active()->get();
        if($form_list)
        {
            return $form_list;
        }
    }

    function inputSlug($label)
    {
        return Str::slug(strtolower($label), '_');
    }

    function locationMaster()
    {
        $location = Location::all();
        if($location)
        {
            return $location;
        }
    }

    function prefixValue($array)
    {
        return '.'.$array;
    }

    function prefixArrayValue($file_format)
    {
        $prefix_value = array_map('prefixValue', explode(', ', $file_format));
        return implode(',', $prefix_value);
    }

    function generateStockReferenceID()
    {
        return Str::uuid();
    }

   function getBankDetail()
    {
        $bank = Bank::active()->get();
        if($bank->count())
        {
            return $bank;
        }
    }

    function tenor($id = null)
    {
        $array_list = ['1' => 'Maximum Tenor', '2' => 'No. of Years and Months'];
        if($id)
        {
            return $array_list[$id];
        }
        return $array_list;
    }

    function getLoanStatus($id = null)
    {
        $array_list = ['1' => 'Processing', '2' => 'Approved', '3' => 'Rejected'];
        if($id)
        {
            return $array_list[$id];
        }
        return $array_list;
    }

    function getTabStatus($id = null)
    {
        $array_list = ['1' => 'Negotiate', '2' => 'Offers', '3' => 'Accepted', '4' => 'Rejected'];
        if($id)
        {
            return $array_list[$id];
        }
        return $array_list;
    }

	function getInsuranceStatus($id = null)
    {
        $array_list = ['1' => 'Complete', '2' => 'Processing'];
        if($id)
        {
            return $array_list[$id];
        }
        return $array_list;
    }

    function getVehicleStatus($id = null)
    {
        $array_list = ['1'=>'Processing', '2'=>'Reserved', '3'=>'Sold', '4'=>'Cancelled', '5'=>'Published'];
        if($id)
        {
            return $array_list[$id];
        }
        return $array_list;
    }

    function getQuoteRequestStatus($id = null)
    {
        $array_list = ['1'=>'Processing', '2'=>'Approved'];
        if($id)
        {
            return $array_list[$id];
        }
        return $array_list;
    }

    function getlistingStatus($id = null)
    {
        $array_list = ['1'=>'Most Viewed', '2'=>'Most Liked', '3'=>'Price', '4'=>'Depreciation', '5'=>'Age', '6'=>'New Listing', '7'=>'Vehicle Sold', '8'=>'Auction Vehicles'];
        if($id)
        {
            return $array_list[$id];
        }
        return $array_list;
    }

    function getFilterType($id = null)
    {
        $array_list = ['1' => 'Price Range ', '2' => 'Depreciation Range', '3' => 'Year of Registration','4' => 'Vehicle Type','5' => 'Make','6' => 'Model','7' => 'Engine Capacity','8' => 'Mileage'];
        if($id)
        {
            return $array_list[$id];
        }
        return $array_list;
    }


    function getAdminByRole($id)
    {
        $admin = Admin::where('admin_role', $id)->get();
        if($admin->count())
        {
            return $admin;
        }
    }

    function getPaymentMode($id = null)
    {
        $query = PaymentMode::query();
        if($id)
        {
            $payment_mode = $query->where('id', $id)->first();
        }
        else
        {
            $payment_mode = $query->get();
        }
        return $payment_mode;
    }

	function getLoanCalculatorRange()
    {
        $array_list = ['01 to 12 Months', '13 to 24 Months', '25 to 36 Months', '37 to 48 Months', '49 to 60 Months', '61 to 72 Months', '73 to 84 Months'];
        return $array_list;
    }

    function sendWhatsappMessage($contact, $message, $media = null)
    {
        $sid = systemSetting()->sid ?? ''; // Your Account SID from www.twilio.com/console
        $token = systemSetting()->whatsapp_token ?? ''; // Your Auth Token from www.twilio.com/console

        try
        {
            if($contact && $message)
            {
                $client = new Client($sid, $token);
                $message = $client->messages->create(
                    'whatsapp:'.$contact, // Text this number
                    [
                        'from' => 'whatsapp:'.systemSetting()->whatsapp_contact, // From a valid Twilio number
                        'body' => $message,
                    ]
                );
                if($media)
                {
                    $client = new Client($sid, $token);
                    $message = $client->messages->create(
                        'whatsapp:'.$contact, // Text this number
                        [
                            'from' => 'whatsapp:'.systemSetting()->whatsapp_contact, // From a valid Twilio number
                            'MediaUrl' => $media ?? '',
                        ]
                    );
                }
            }
        }
        catch(Exception $e)
        {
            Log::info($e);
        }
    }

    function notificationStatus()
    {
        $array_list = ['1' => 'Unread', '2' => 'Read'];
        return $array_list;
    }

    function checkSellerSigned($seller_id)
    {
        $sp_terms = SpContractTerm::where('seller_particular_id', $seller_id)->whereNotNull('signature')->first();
        if($sp_terms)
        {
            return true;
        }
        return false;
    }

    function country()
    {
        $country = DB::table('country')->get();
        if($country)
        {
            return $country;
        }
        return false;
    }

    function checkUserApproved($seller_particular_id)
    {
        $sp_contract_term = SpContractTerm::where('seller_particular_id', $seller_particular_id)->where(function($query) {
            $query->whereNotNull('seller_approval_at')->orwhereNotNull('buyer_approval_at');
        })->first();
        if($sp_contract_term)
        {
            return true;
        }
        return false;
    }

    function getViewCountByVehicleID($vehicle_id){
        // $user_ip = \Request::ip();
        // if(!Auth::guest()){
        //     $loggedUserID = Auth::user()->id;
        //     $totalView = DB::table('vehicle_view_counts')
        //                     ->select(DB::raw('SUM(view_count) as total_views'))
        //                     ->where('vehicle_id', '=', $vehicle_id)
        //                     ->where('user_id', '=', $loggedUserID)
        //                     ->first();
        // }else{
        //     $totalView = DB::table('vehicle_view_counts')
        //                     ->select(DB::raw('SUM(view_count) as total_views'))
        //                     ->where('vehicle_id', '=', $vehicle_id)
        //                     ->where('user_ip', '=', $user_ip)
        //                     ->whereNull('user_id')
        //                     ->first();
        // }
         $totalView = ViewCount::has('vehicle.vehicleDetail')
                                    ->select('view_count','vehicle_id', DB::raw('count(view_count) as total_views'))
                                    ->where('vehicle_id', '=', $vehicle_id)
                                    ->groupBy('vehicle_id')
                                    ->orderBy('total_views', 'desc')
                                    ->first();
        if(isset($totalView->total_views))
            return $totalView->total_views;
        else
            return 0;
    }

    function dateDiff($date1, $date2)
    {
        $date1_ts = strtotime($date1);
        $date2_ts = strtotime($date2);
        $diff = $date1_ts - $date2_ts;
        return round($diff / 86400);
    }

    function is_vehicle_liked($user_id, $vehicle_id){
        $is_liked = DB::table('vehicle_like_counts')
                    ->select('is_liked')
                    ->where('vehicle_id', '=', $vehicle_id)
                    ->where('user_id', '=', $user_id)
                    ->first();
        if(isset($is_liked)) return $is_liked->is_liked;
        else return false;
    }
    
    function vehicle_like_count($vehicle_id){
        $liked = DB::table('vehicle_like_counts')
                    ->where('vehicle_id', '=', $vehicle_id)
                    ->count();
        if(isset($liked)) 
        return $liked;
        else 
        return 0;
    }

    function is_vehicle_reported($user_id, $vehicle_id){
        $is_reported = DB::table('report_vehicles')
                    ->select('is_reported')
                    ->where('vehicle_id', '=', $vehicle_id)
                    ->where('user_id', '=', $user_id)
                    ->first();
        if(isset($is_reported)) return $is_reported->is_reported;
        else return false;
    }

    function calculateRoadTax($propellant, $engine_cc, $orig_reg_date, $price){
        $road_tax_formula = 0; $road_tax = 0; $surcharge = 0;
        if($engine_cc >= 1 && $engine_cc <= 600){
            $road_tax = (400 * 0.782);
        }elseif($engine_cc > 600 && $engine_cc <= 1000){
            $road_tax = (400 + 0.25 * ($engine_cc - 600)) * 0.782;
        }elseif($engine_cc > 1000 && $engine_cc <= 1600){
            $road_tax = (500 + 0.75 * ($engine_cc - 1000)) * 0.782;
        }elseif($engine_cc > 1600 && $engine_cc <= 3000){
            $road_tax = (950 + 1.5 * ($engine_cc - 1600)) * 0.782;
        }elseif($engine_cc > 3000){
            $road_tax = (3050 + 2.0 * ($engine_cc - 3000)) * 0.782;
        }

        $today_date = date("Y-m-d");
        $no_of_yrs_in_days_of_vehicle = dateDiff($today_date, $orig_reg_date);
        $no_of_yrs_of_vehicle = floor($no_of_yrs_in_days_of_vehicle / 365);
        if($no_of_yrs_of_vehicle < 10){
            $surcharge = 0;
        }elseif($no_of_yrs_of_vehicle >= 10 && $no_of_yrs_of_vehicle <= 11){
            // $surcharge = ($price * 10)/100;
            $surcharge = 0.1;
        }elseif($no_of_yrs_of_vehicle > 11 && $no_of_yrs_of_vehicle <= 12){
            // $surcharge = ($price * 20)/100;
            $surcharge = 0.2;
        }elseif($no_of_yrs_of_vehicle > 12 && $no_of_yrs_of_vehicle <= 13){
            // $surcharge = ($price * 30)/100;
            $surcharge = 0.3;
        }elseif($no_of_yrs_of_vehicle > 13 && $no_of_yrs_of_vehicle <= 14){
            // $surcharge = ($price * 40)/100;
            $surcharge = 0.4;
        }elseif($no_of_yrs_of_vehicle > 14){
            // $surcharge = ($price * 50)/100;
            $surcharge = 0.5;
        }

        if($propellant == 'petrol'){
            $road_tax_formula = $road_tax + ($road_tax * $surcharge);
        }elseif($propellant == 'diesel euro 4/iv & below'){
            $road_tax_formula = ($road_tax + ($road_tax * $surcharge)) + $engine_cc * 1.25;
        }elseif($propellant == 'diesel euro 5/iv & above'){
            $road_tax_formula = ($road_tax + ($road_tax * $surcharge)) + $engine_cc * 0.4;
        }
        return $road_tax_formula;
    }

    function calculateRemainingCoe($coe_expiry_date){
        $today_date = date("Y-m-d");
        $date1 = new DateTime($today_date);
        $date2 = new DateTime($coe_expiry_date);

        $interval = $date1->diff($date2);
        // return ((($y = $interval->format('%y')) > 0) ? $y . ' Year' . ($y > 1 ? 's' : '') . ', ' : '') . ((($m = $interval->format('%m')) > 0) ? $m . ' Month' . ($m > 1 ? 's' : '') . ', ' : '') . ((($d = $interval->format('%d')) > 0) ? $d . ' Day' . ($d > 1 ? 's' : '') : '');
        return $interval->format('%Y years %M months %D days');
    }

    function calculateMonthlyInstallment($price, $interest_rate, $max_tenor){
        $monthly_inst = ((($price*(1-0.3)*$interest_rate/12*$max_tenor)+($price*(1-0.3)))/$max_tenor);
        return $monthly_inst;
    }
    
    function calculateMonthlyInstallmentNew($price, $interest_rate, $max_tenor, $aaa){
        $monthly_inst = ((($price*($aaa)*$interest_rate/12*$max_tenor)+($price*($aaa)))/$max_tenor);
        return $monthly_inst;
    }

    function getAllUsers()
    {
        $users = User::get();
        if($users)
        {
            return $users;
        }
    }

    function get_invoice_items($invoice_id)
    {
        $items = App\InvoiceItem::where('invoice_id', '=', $invoice_id)->get();
        if ($items)
            return $items;
        else
            return NULL;
    }

    function getInvoiceStatus($id = null)
    {
        $array_list = ['1'=>'Pending', '2'=>'Paid'];
        if($id)
        {
            return $array_list[$id];
        }
        return $array_list;
    }

    function getInvoiceTypes($id = null)
    {
        $array_list = ['1' => 'Deposit', '2' => 'Balance Payment', '3' => 'STA Inspection'];
        if($id)
        {
            return $array_list[$id];
        }
        return $array_list;
    }

    function calculateAddnlDiscFee($type, $value, $sub_total){
        if($type == 1){
            $fee = ($sub_total * $value) / 100;
        }elseif ($type == 2) {
            $fee = $value;
        }
        return $fee;
    }

    function getPropellantType($id = null)
    {
        // $array_list = ['petrol' => 'Petrol ', 'diesel euro 4/iv & below' => 'Diesel euro 4/iv & below', 'diesel euro 5/iv & above' => 'Diesel euro 5/iv & above'];
        $array_list = ['compressed natural gas'=>'Compressed Natural Gas', 'diesel'=>'Diesel', 'diesel-cng'=>'Diesel-CNG', 'diesel euro 4/iv & below' => 'Diesel euro 4/iv & below', 'diesel euro 5/iv & above' => 'Diesel euro 5/iv & above', 'diesel-electric'=>'Diesel-Electric', 'diesel-electric (plug-in)'=>'Diesel-Electric (Plug-In)', 'electric'=>'Electric', 'gas'=>'Gas', 'liquefied petroleum gas (lpg)'=>'Liquefied Petroleum Gas (LPG)', 'petrol' => 'Petrol', 'petrol-cng'=>'Petrol-CNG', 'petrol-electric'=>'Petrol-Electric', 'petrol-electric (plug-in)'=>'Petrol-Electric (Plug-In)', 'petrol-lpg'=>'Petrol-LPG'  ];
        if($id)
        {
            return $array_list[$id];
        }
        return $array_list;
    }
    
    function getReportByCar($id = null)
    {
        $vehicle_reported = ReportVehicle::where('user_id', '=', Auth::user()->id)
        ->where('vehicle_id', '=', $id)
        ->first();

        if(isset($vehicle_reported))
        {
            return $vehicle_reported;
        }
        else
        {
            return NULL;
        }
    }
}
