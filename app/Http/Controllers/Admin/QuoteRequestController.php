<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\QuoteRequest;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Traits\GetEmailTemplate;
use App\Jobs\SendEmail;

class QuoteRequestController extends Controller
{
    use SystemSettingTrait, GetEmailTemplate;
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('Quote Request');
        $this->module = 'QUOTE_REQUEST';
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
        $quote_requests = QuoteRequest::orderBy('created_at', 'desc')
                            ->paginate($this->pagination);

        return view('admin.quote_request.index', compact('title', 'quote_requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;

        return view('admin.quote_request.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'seller'    =>  'required',
            'full_name' => 'required',
			'country' => 'required',
			'contact_number' => 'required',
			'email' => 'required|email',
            'gender' => 'required',
			'vehicle_number' => 'required',
			'nric' => 'required|min:4|max:4',
            'handing_over_date' => 'required|date',
			'quote_price' => 'required|numeric',
			'mileage' => 'required|integer',
			'upload_file' => 'required'
        ]);

        $quote_request = new QuoteRequest;
        $quote_request->seller_id = $request->seller;
        $quote_request->full_name = $request->full_name;
        $quote_request->email = $request->email;
        $quote_request->country = $request->country;
        $quote_request->contact_number = $request->contact_number;
        $quote_request->gender = $request->gender;
        $quote_request->seller_remarks = $request->seller_remarks;
        $quote_request->handing_over_date = $request->handing_over_date;
        $quote_request->vehicle_number = $request->vehicle_number;
        $quote_request->nric = $request->nric;
        $quote_request->mileage = $request->mileage;
        $files = [];
        if($request->hasfile('upload_file'))
        {
            foreach($request->file('upload_file') as $file)
            {
                $filename = time().rand(1,50).'.'.$file->extension();
                $filepath = 'storage/upload-file/';
							Storage::putFileAs(
								'public/upload-file',
								$file,
								$filename
							);
                $files[] = $filepath.$filename;
            }
        }
        $quote_request->upload_file  = json_encode($files);
        $quote_request->quote_price = $request->quote_price;
		$quote_request->status = 1;
        $quote_request->save();

        return redirect()->route('quoterequest.index')->with('success',  __('constant.CREATED', ['module'   =>  $this->title]));
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
        $quote_request = QuoteRequest::where('id', '=', $id)->first();
        return view('admin.quote_request.show', compact('title', 'quote_request'));
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
        $quote_request = QuoteRequest::where('id', '=', $id)->first();
        return view('admin.quote_request.edit', compact('title', 'quote_request'));
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
            // 'seller'    =>  'required',
            'full_name' => 'required',
			// 'country' => 'required',   ************
			'contact_number' => 'required',
			'email' => 'required|email',
            'gender' => 'required',
			'vehicle_number' => 'required',
			'vehicle_make' => 'required',
            'vehicle_model' => 'required',
            // 'quote_price' => 'required',
            'quote_expiry_date' => 'required',
			'nric' => 'required',
            'handing_over_date' => 'required|date',
			// 'quote_price' => 'required|numeric',
			'mileage' => 'required', // **************
            'quota_premium' => 'required',
        ]);

        $quote_request = QuoteRequest::where('id', '=', $id)->first();;
        // $quote_request->seller_id = $request->seller;
        $quote_request->full_name = $request->full_name;
        $quote_request->email = $request->email;
        $quote_request->country = $request->country_code;
        $quote_request->contact_number = $request->contact_number;
        $quote_request->gender = $request->gender;
        $quote_request->seller_remarks = $request->seller_remarks;
        $quote_request->handing_over_date = date('Y-m-d', strtotime($request->handing_over_date));// **************
        $quote_request->vehicle_number = $request->vehicle_number;
        $quote_request->nric = $request->nric;
        $quote_request->mileage = str_replace(',','',$request->mileage); // **************

        $quote_request->quote_price = str_replace(',','',$request->quote_price); // **************
        $quote_request->quote_expiry_date = date('Y-m-d', strtotime($request->quote_expiry_date)); // **************

        $quote_request->vehicle_make = $request->vehicle_make;
        $quote_request->vehicle_model = $request->vehicle_model;
        $quote_request->primary_color = $request->primary_color;
        $quote_request->year_of_manufacture = $request->year_of_manufacture;
        $quote_request->open_market_value = str_replace(',','', $request->open_market_value);
        $quote_request->orig_reg_date = date('Y-m-d', strtotime($request->orig_reg_date));
        $quote_request->first_reg_date = date('Y-m-d', strtotime($request->first_reg_date));
        $quote_request->no_of_transfer = $request->no_of_transfer;
        $quote_request->coe_expiry_date = date('Y-m-d', strtotime($request->coe_expiry_date));
        $quote_request->coe_category = $request->coe_category;
        $quote_request->quota_premium = str_replace(',','',$request->quota_premium); // **************
        $quote_request->vehicle_type = $request->vehicle_type;
        $quote_request->propellant = $request->propellant;
        $quote_request->engine_capacity = str_replace(',','',$request->engine_capacity); // **************
        $quote_request->engine_no = $request->engine_no;
        $quote_request->chassis_no = $request->chassis_no;
        $quote_request->max_unladen_weight = str_replace(',','',$request->max_unladen_weight); // **************
        $quote_request->vehicle_scheme = $request->vehicle_scheme;
        $quote_request->roadtaxexpirydate = date('Y-m-d', strtotime($request->roadtaxexpirydate));
        $quote_request->minimumparfbenefit = str_replace(',','',$request->minimumparfbenefit); // **************

        $files = [];
        $old_files_arr = json_decode($quote_request->upload_file);
        if($request->hasfile('upload_file'))
        {
            foreach($request->file('upload_file') as $file)
            {
                $filename = time().rand(1,50).'.'.$file->extension();
                $filepath = 'storage/upload-file/';
							Storage::putFileAs(
								'public/upload-file',
								$file,
								$filename
							);
                $files[] = $filepath.$filename;
            }
        }
        if(isset($old_files_arr)){
            $files = array_merge($files, $old_files_arr);
        }
        $quote_request->upload_file  = json_encode($files);
        // $quote_request->quote_price = $request->quote_price;
		$quote_request->status = $request->status;
        $quote_request->updated_at = Carbon::now();
        $quote_request->save();
        
        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_QUOTE_UPDATE_USER'));
        if ($email_template) {
            $data = [];

            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
            $data['from_email'] = $this->systemSetting()->from_email;
            $data['cc_to_email'] = [];
            $data['email'] = [$request->email];

            $data['subject'] = $email_template->subject;
            $url = url('my-quote-requests');
            $link = '<a href="' . $url . '">' . $url . '</a>';
            // $key = ['{{name}}', '{{link}}'];
            // $value = [$request->full_name, $link];
            $key = ['{{name}}', '{{link}}', '{{quote_price}}', '{{quote_expiry_date}}', '{{handing_over_date}}', '{{vehicle_make}}', '{{vehicle_model}}'];
            $value = [$request->full_name, $link, $request->quote_price, $request->quote_expiry_date, $request->handing_over_date, $request->vehicle_make, $request->vehicle_model];
            
            $newContent = str_replace($key, $value, $email_template->content);
            $data['contents'] = $newContent;
            //dd($data);

            try {
                SendEmail::dispatchNow($data);
            } catch (\Exception $exception) {
                //dd($exception);
            }
        }
        if(!empty($request->previousUrll)){
            return redirect($request->previousUrll)->with('success',  __('constant.UPDATED', ['module' => $this->title]));
        }else{
            return redirect()->route('quoterequest.index', $id)->with('success',  __('constant.UPDATED', ['module' => $this->title]));
        }
        // return redirect()->route('quoterequest.index', $id)->with('success',  __('constant.UPDATED', ['module' => $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $id = explode(',', $request->multiple_delete);
        QuoteRequest::destroy($id);
        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $title = $this->title;
        $query = DB::table('vehicle_quote_requests as vq');
                    
        if($request->search!="")
		{
		    $query->where('vq.vehicle_number', 'like', '%'.$request->search.'%')
                    ->orWhere('vq.full_name', 'like', '%'.$request->search.'%');
		}

        if($request->status!="")
		{
		    $query->where('vq.status', $request->status);
		}

        $quote_requests = $query->orderBy('vq.created_at', 'desc')
                            ->paginate($this->systemSetting()->pagination);

        return view('admin.quote_request.index', compact('title', 'quote_requests'));
    }
}
