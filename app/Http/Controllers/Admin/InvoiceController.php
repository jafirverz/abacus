<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Invoice;
use App\InvoiceItem;
use App\User;
use App\Traits\GetEmailTemplate;
use App\Traits\GetMessageTemplate;
use App\Jobs\SendEmail;
use Exception;

class InvoiceController extends Controller
{
    use SystemSettingTrait, GetEmailTemplate, GetMessageTemplate;
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('Invoice');
        $this->module = 'INVOICE';
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
        $invoices = Invoice::orderBy('created_at', 'desc')->paginate($this->pagination);
        return view('admin.invoice.index', compact('title', 'invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;

        return view('admin.invoice.create', compact('title'));
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
            'vehicle_number'  =>  'required',
            'seller_id'   =>  'required',
            'buyer_id'   =>  'required',
            'invoice_type'   =>  'required',
            'seller_logo'   =>  'required',
            'seller_address'   =>  'required',
            'seller_email'   =>  'required|email',
            'seller_phone'   =>  'required',
            'buyer_email'   =>  'required|email',
            'buyer_phone'   =>  'required',
            'note_to_customer'   =>  'required',
            'terms_conditions' => 'required',
            'additional_fee_type'   =>  'required',
            'additional_fee_value'   =>  'required',
            'discount_type'   =>  'required',
            'discount_value'   =>  'required|numeric',
            'item.*'    =>  'required',
            'price.*'   =>  'required'
        ]);

        $invoice = new Invoice;
        $randomNumber = random_int(100000, 999999);
        $invoice->invoice_no = 'A'.$randomNumber;
        $invoice->vehicle_number = $request->vehicle_number;
        $invoice->seller_id = $request->seller_id;
        $invoice->buyer_id = $request->buyer_id;
        $invoice->invoice_type = $request->invoice_type;
        $invoice->seller_address = $request->seller_address;
        $invoice->seller_email = $request->seller_email;
        $invoice->seller_phone = $request->seller_phone;
        $invoice->buyer_email = $request->buyer_email;
        $invoice->buyer_phone = $request->buyer_phone;
        $invoice->note_to_customer = $request->note_to_customer;
        $invoice->terms_conditions = $request->terms_conditions;
        $invoice->additional_fee_type = $request->additional_fee_type;
        $invoice->additional_fee_value = $request->additional_fee_value;
        $invoice->discount_type = $request->discount_type;
        $invoice->discount_value = $request->discount_value;
        if($request->hasfile('seller_logo'))
        {
            $file = $request->file('seller_logo');
            $filename = time().rand(1,50).'.'.$file->extension();
            $filepath = 'storage/upload-file/';
                        Storage::putFileAs(
                            'public/upload-file',
                            $file,
                            $filename
                        );
            $seller_logo = $filepath.$filename;
        }
        $invoice->seller_logo = $seller_logo;
        $invoice->status = 1;
        $invoice->save();

        if(count($request->item)){
            $itemsArr = $request->item;
            $priceArr = $request->price;
            for ($i=0; $i < count($itemsArr); $i++) { 
                $invoiceItem = new InvoiceItem;
                $invoiceItem->invoice_id = $invoice->id;
                $invoiceItem->item_name = $itemsArr[$i];
                $invoiceItem->price = $priceArr[$i];
                $invoiceItem->save();
            }
        }
        // Send to seller
        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_INVOICE_GENERATE'));
        if ($email_template) {
            $data = [];

            $url = url('my-invoices');
            $url = '<a href="'.$url.'">'.$url.'</a>';

            $buyer_name = '';
            $buyer = User::find($request->buyer_id);
            if($buyer)
            {
                $buyer_name = $buyer->name;
            }
            $seller = User::find($request->seller_id);
            if($seller)
            {
                $seller_name = $seller->name;
            }
            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
            $data['from_email'] = $this->systemSetting()->from_email;
            $data['email'] = [$request->seller_email];
            $data['cc_to_email'] = [];

            $data['subject'] = $email_template->subject;

            /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

            $key = ['{{name}}', '{{link}}'];
            $value = [$seller_name, $url];
            $newContent = str_replace($key, $value, $email_template->content);
            $data['contents'] = $newContent;

            try {
                SendEmail::dispatchNow($data);
            } catch (Exception $exception) {
                //dd($exception);
            }
        }
        // Send to Buyer
        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_INVOICE_GENERATE'));
        if ($email_template) {
            $data = [];

            $url = url('my-invoices');
            $url = '<a href="'.$url.'">'.$url.'</a>';

            $buyer_name = '';
            $buyer = User::find($request->buyer_id);
            if($buyer)
            {
                $buyer_name = $buyer->name;
            }
            $seller_name = '';
            $seller = User::find($request->seller_id);
            if($seller)
            {
                $seller_name = $seller->name;
            }
            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
            $data['from_email'] = $this->systemSetting()->from_email;
            $data['email'] = [$request->buyer_email];
            $data['cc_to_email'] = [];

            $data['subject'] = $email_template->subject;

            /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

            $key = ['{{name}}', '{{link}}'];
            $value = [$buyer_name, $url];
            $newContent = str_replace($key, $value, $email_template->content);
            $data['contents'] = $newContent;

            try {
                SendEmail::dispatchNow($data);
            } catch (Exception $exception) {
                //dd($exception);
            }
        }
        return redirect()->route('invoice.index')->with('success',  __('constant.CREATED', ['module'   =>  $this->title]));
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
        $invoice = Invoice::where('id', '=', $id)->first();

        return view('admin.invoice.show', compact('title', 'invoice'));
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
        $invoice = Invoice::where('id', '=', $id)->first();

        return view('admin.invoice.edit', compact('title', 'invoice'));
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
            'vehicle_number'  =>  'required',
            'seller_id'   =>  'required',
            'buyer_id'   =>  'required',
            'invoice_type'   =>  'required',
            'seller_address'   =>  'required',
            'seller_email'   =>  'required|email',
            'seller_phone'   =>  'required',
            'buyer_email'   =>  'required|email',
            'buyer_phone'   =>  'required',
            'note_to_customer'   =>  'required',
            'terms_conditions' => 'required',
            'additional_fee_type'   =>  'required',
            'additional_fee_value'   =>  'required',
            'discount_type'   =>  'required',
            'discount_value'   =>  'required|numeric',
            'item.*'    =>  'required',
            'price.*'   =>  'required'
        ]);

        $invoice = Invoice::where('id', '=', $id)->first();
        $invoice->vehicle_number = $request->vehicle_number;
        $invoice->seller_id = $request->seller_id;
        $invoice->buyer_id = $request->buyer_id;
        $invoice->invoice_type = $request->invoice_type;
        $invoice->seller_address = $request->seller_address;
        $invoice->seller_email = $request->seller_email;
        $invoice->seller_phone = $request->seller_phone;
        $invoice->buyer_email = $request->buyer_email;
        $invoice->buyer_phone = $request->buyer_phone;
        $invoice->note_to_customer = $request->note_to_customer;
        $invoice->terms_conditions = $request->terms_conditions;
        $invoice->additional_fee_type = $request->additional_fee_type;
        $invoice->additional_fee_value = $request->additional_fee_value;
        $invoice->discount_type = $request->discount_type;
        $invoice->discount_value = $request->discount_value;
        if($request->hasfile('seller_logo'))
        {
            $file = $request->file('seller_logo');
            $filename = time().rand(1,50).'.'.$file->extension();
            $filepath = 'storage/upload-file/';
                        Storage::putFileAs(
                            'public/upload-file',
                            $file,
                            $filename
                        );
            $seller_logo = $filepath.$filename;
            $invoice->seller_logo = $seller_logo;
        }
        $invoice->status = $request->status;
        $invoice->updated_at = Carbon::now();
        $invoice->save();

        if(count($request->item)){
            InvoiceItem::where('invoice_id', $id)->delete();
            $itemsArr = $request->item;
            $priceArr = $request->price;
            for ($i=0; $i < count($itemsArr); $i++) {
                $invoiceItem = new InvoiceItem;
                $invoiceItem->invoice_id = $invoice->id;
                $invoiceItem->item_name = $itemsArr[$i];
                $invoiceItem->price = $priceArr[$i];
                $invoiceItem->save();
            }
        }

        return redirect()->route('invoice.index')->with('success',  __('constant.UPDATED', ['module'   =>  $this->title]));
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
        InvoiceItem::where('invoice_id', $id)->delete();
        Invoice::destroy($id);
        return redirect()->back()->with('success',  __('constant.DELETED', ['module' => $this->title]));
    }

    public function search(Request $request)
    {
        $title = $this->title;
        $query = DB::table('invoices');
        if($request->search!="")
		{
		    $query->where('vehicle_number', 'like', '%'.$request->search.'%')
                    ->orWhere('invoice_no', 'like', '%'.$request->search.'%');
		}

        if($request->status!="")
		{
		    $query->where('status', $request->status);
		}
        
		if($request->invoice_type!="")
		{
		    $query->where('invoice_type', $request->invoice_type);
		}

        $invoices = $query->orderBy('created_at', 'desc')
                    ->paginate($this->systemSetting()->pagination);

        return view('admin.invoice.index', compact('title', 'invoices'));
    }
}