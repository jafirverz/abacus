<?php

use App\Admin;
use App\Insurance;
use App\InsuranceInformation;
use App\InsuranceQuotation;
use App\InsuranceVehicle;
use App\AutoQuoteReference;
use App\Bank;
use App\PermissionAccess;
use Yadahan\AuthenticationLog\AuthenticationLog;
use App\Page;
use App\OneMotoring;
use App\Category;
use App\Faq;
use App\Partner;
use App\Slider;
use App\Conversation;
use App\Banner;
use App\Menu;
use App\MenuList;
use App\Role;
use App\Status;
use App\StockListingSales;
use App\StockMeta;
use App\Preference;
use App\User;
use App\NotifyParty;
use App\CarEnquiry;
use App\ShippingAddress;
use App\UserConsignee;
use App\InsuranceCostSettings;
use App\NewCarStock;
use App\OperationVendor;
use App\PaymentMode;
use App\SystemSetting;
use App\VehicleQuotation;
use App\VehicleRegistration;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpParser\Node\Expr\New_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

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
        return (object) SystemSetting::pluck('value','key')->all();
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
            'SYSTEM_SETTING', 'LOAN_CALCULATOR_SETTINGS', 'ACTIVITY_LOG', 'FAQ_CATEGORY', 'STATUS', 'LOCATION', 'PAGES', 'MENU', 'MENU_LIST', 'HOME_BANNER', 'PAGE_BANNER', 'SMART_BLOCK',
            'FAQ', 'CONTACT_ENQUIRY', 'TESTIMONIAL',
            'EMAIL_TEMPLATE', 'MESSAGE_TEMPLATE', 'USER_ACCOUNT', 'ROLES_AND_PERMISSION',  'CUSTOMER_ACCOUNT', 'BANK' ,'BANNER_MANAGEMENT','INSURANCE_APPLICATION','PARTNER', 'LOAN_APPLICATION', 'SP_AGREEMENT'

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

	function calculate_final_car_price($price,$id)
	{
		$port = M3CostSettings::where('id',$id)->first();
		$insurance_cost = InsuranceCostSettings::where('id',1)->first();
		if(isset($port))
		{
		return ($price+$port->cost+$insurance_cost->cost);
		}
		else
		{
		return $price;
		}
    }


	function get_consignee_detail($id)
    {
        $consignee = UserConsignee::where('id',$id)->get();

		if ($consignee)
        return $consignee;

        return NULL;
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
        $array_list = ['1' => 'Processing', '2' => 'Confirmed', '3' => 'Cancelled'];
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
}
