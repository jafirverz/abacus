<?php

namespace App\Http\Controllers\CMS;

use App\Chat;
use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use App\Traits\GetEmailTemplate;
use App\Jobs\SendEmail;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class StaInspectionController extends Controller
{
    use SystemSettingTrait, GetEmailTemplate;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.STA_INSPECTION');
        $this->module = 'STA_INSPECTION';
        $this->middleware('grant.permission:'.$this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title;
        $chat = Chat::where('sta_inspection',1)->where('sta_inspection_date','!=',NULL)->where('sta_inspection',1)->orderBy('created_at','desc')->paginate($this->pagination);
        return view('admin.sta-inspection.index', compact('title', 'chat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = $this->title;
        $chat = Chat::find($id);

        return view('admin.sta-inspection.show', compact('title', 'chat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = $this->title;
        $chat = Chat::find($id);

        return view('admin.sta-inspection.edit', compact('title', 'chat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
		    'title'  =>  'required',
            'icon'  =>  'nullable|file|mimes:jpg,png,gif,jpeg|max:25000',
			'url'  =>  'required|url',
			'view_order'  =>  'required',
            'status' =>  'required',
        ]);

        $chat = Chat::find($id);
        $chat->title = $request->title??NULL;
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $filename = Carbon::now()->format('Y-m-d H-i-s') . '__' . guid() . '__' . $icon->getClientOriginalName();
            $filepath = 'storage/sta-inspection/';
            Storage::putFileAs(
                'public/sta-inspection', $icon, $filename
            );
            $path_icon = $filepath . $filename;
            $chat->icon = $path_icon;
        }
		$chat->url = $request->url??NULL;
		$chat->view_order = $request->view_order??NULL;
        $chat->status = $request->status;
        $chat->save();

        return redirect()->route('sta-inspection.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
    }

    public function change_status($id,$status)
    {
        $chat = Chat::find($id);
        $chat->approved_by_admin = $status;
        $chat->save();
        if($status==1)
        {
            // NOTE BUYER EMAIL
            $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_STA_INSPECTION_TO_BUYER'));
            if ($email_template) {
                $data = [];


                $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                $data['from_email'] = $this->systemSetting()->from_email;
                $data['email'] = [$chat->user->email];
                $data['cc_to_email'] = [];

                $data['subject'] = $email_template->subject;

                /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */
                
                $staDateTime = $chat->sta_inspection_date;
                if(!empty($staDateTime)){
                    $insDate = explode(' ', $staDateTime);
                    $datee = date('d-m-Y', strtotime($insDate[0]));
                    $timee = date('g:ia', strtotime($insDate[1]));
                }else{
                    $datee = '';
                    $timee = '';
                }

                $key = ['{{name}}', '{{date}}', '{{time}}'];
                $value = [$username, $datee, $timee];
                $newContent = str_replace($key, $value, $email_template->content);
                $data['contents'] = $newContent;

                try {
                    SendEmail::dispatch($data);
                } catch (Exception $exception) {
                    //dd($exception);
                }
            }

            // NOTE SELLER EMAIL
            $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_STA_INSPECTION_TO_SELLER'));
            if ($email_template) {
                $data = [];

                // $url = url('forms/form-details/view/'.$reference.'/'.$id);
                // $url = '<a href="'.$url.'">'.$url.'</a>';
                $username = $chat->seller->name;

                $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                $data['from_email'] = $this->systemSetting()->from_email;
                $data['email'] = [$chat->seller->email];
                $data['cc_to_email'] = [];

                $data['subject'] = $email_template->subject;
                
                $staDateTime = $chat->sta_inspection_date;
                if(!empty($staDateTime)){
                    $insDate = explode(' ', $staDateTime);
                    $datee = date('d-m-Y', strtotime($insDate[0]));
                    $timee = date('g:ia', strtotime($insDate[1]));
                }else{
                    $datee = '';
                    $timee = '';
                }

                /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

                $key = ['{{name}}', '{{date}}', '{{time}}'];
                $value = [$username, $datee, $timee];
                $newContent = str_replace($key, $value, $email_template->content);
                $data['contents'] = $newContent;

                try {
                    SendEmail::dispatch($data);
                } catch (Exception $exception) {
                    //dd($exception);
                }
            }

        }

        
        return redirect()->route('sta-inspection.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

    }

	 public function search(Request $request)
    {
        $title = $this->title;
        $secondary_title = "Search";
        $daterange = $request->daterange;

        if(isset($daterange))
        {
            $daterange = str_replace('/', '-', explode('-', $daterange));
            $start_date = trim($daterange[0]);
            $end_date = trim($daterange[1]);
            $chat =  Chat::select('chats.*')->whereBetween('chats.sta_inspection_date', [$start_date, $end_date])->orderBy('created_at','desc')->paginate($this->pagination);

        }
        else
        {
            $chat =  Chat::select('chats.*')->orderBy('created_at','desc')->paginate($this->pagination);

        }
        		//dd($search);
        return view('admin.sta-inspection.index', compact('title', 'secondary_title', 'chat'));
    }
}
