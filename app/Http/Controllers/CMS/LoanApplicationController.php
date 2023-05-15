<?php

namespace App\Http\Controllers\CMS;

use App\Bank;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Loan;
use App\Traits\GetEmailTemplate;
use App\Traits\SystemSettingTrait;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LoanApplicationController extends Controller
{
    use SystemSettingTrait, GetEmailTemplate;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.LOAN_APPLICATION');
        $this->module = 'LOAN_APPLICATION';
        $this->middleware('grant.permission:'.$this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $title = $this->title;
        $loan_application = Loan::paginate($this->pagination);

        return view('admin.loan_application.index', compact('title', 'loan_application'));
    }

    public function create()
    {
        $title = $this->title;
        $users = User::orderby('name')->get();

        return view('admin.loan_application.create', compact('title', 'users'));
    }

    public function store(Request $request)
    {
        $messages = [
            'nric_company_registration_no.required' => 'The NRIC/Business ID/Company Registration ID field is required.',
            'bank_id.required' => 'The Bank field is required.',
            'year.required_if' => 'The Year field is required when No. of Years and Months is selected.',
            'month.required_if' => 'The Month field is required when No. of Years and Months is selected.',
            'vehicle_no.required_if' => 'The Vehicle no field is required.',
            'nric.required_if' => 'The NRIC field is required.',
            'estimated_mileage.required_if' => 'The Estimated mileage field is required.',
        ];

        $request->validate([
            'vehicle_registration_no' => 'required',
            'nric_company_registration_no' => 'required|min:4|max:4',
            'name' => 'required',
            'loan_purchase_price' => 'required',
            'loan_amount' => 'required',
            'bank_id' => 'required',
            'tenor' => 'required',
            'year' => 'required_if:tenor,2',
            'month' => 'required_if:tenor,2|numeric|min:0|max:12',
            'quote_trade' => 'required',
            'vehicle_no' => 'required_if:quote_trade,1',
            'nric' => 'required_if:quote_trade,1',
            'estimated_mileage' => 'required_if:quote_trade,1',
            'status' => 'required',
        ], $messages);

        $send_email = 0;
        $loan = new Loan();
        $loan->vehicle_registration_no = $request->vehicle_registration_no;
        $loan->nric_company_registration_no = $request->nric_company_registration_no;
        $loan->bank_id = $request->bank_id;
        $loan->loan_purchase_price = $request->loan_purchase_price;
        $loan->user_id = $request->name;
        $loan->loan_amount = $request->loan_amount;
        $loan->tenor = $request->tenor;
        if($loan->tenor==2)
        {
            $loan->year = $request->year;
            $loan->month = $request->month;
        }
        else
        {
            $loan->year = null;
            $loan->month = null;
        }
        $loan->quote_trade = $request->quote_trade;
        if($loan->quote_trade==1)
        {
            $loan->trade_details = json_encode([
                'vehicle_no' => $request->vehicle_no,
                'nric' => $request->nric,
                'estimated_mileage' => $request->estimated_mileage,
            ]);
        }
        else
        {
            $loan->trade_details = null;
        }
        if($loan->status<>$request->status)
        {
            $send_email = 1;
        }
        $loan->data_protection = $request->data_protection;
        $loan->other_documents = $request->other_document_uploaded ? json_encode($request->other_document_uploaded) : null;
        $loan->status = $request->status;
        $loan->data_protection = 0;
        $loan->save();

        if($send_email)
        {
            // EMAIL
            $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_LOAN_APPLICATION_TO_LOAN_APPLICANT'));
            if ($email_template) {
                $data = [];

                $url = url('loan-applications/'.strtotime($loan->created_at).'/'.$loan->id);
                $url = '<a href="'.$url.'">'.$url.'</a>';
                $status  = getLoanStatus($request->status) ?? 'Processing';

                $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                $data['from_email'] = $this->systemSetting()->from_email;
                $data['email'] = [$loan->user->email];
                $data['cc_to_email'] = [];

                $data['subject'] = $email_template->subject;

                /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

                $key = ['{{username}}', '{{status}}', '{{url}}'];
                $value = [$loan->user->name, $status, $url];
                $newContent = str_replace($key, $value, $email_template->content);
                $data['contents'] = $newContent;

                try {
                    SendEmail::dispatch($data);
                } catch (Exception $exception) {
                    //dd($exception);
                }
            }
        }

        return redirect('admin/loan-application')->with('success', 'Loan Application has been created.');
    }

    public function edit($id)
    {
        $title = $this->title;
        $loan_application = Loan::findorfail($id);

        return view('admin.loan_application.edit', compact('title', 'loan_application'));
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'nric_company_registration_no.required' => 'The NRIC/Business ID/Company Registration ID field is required.',
            'bank_id.required' => 'The Bank field is required.',
            'year.required_if' => 'The Year field is required when No. of Years and Months is selected.',
            'month.required_if' => 'The Month field is required when No. of Years and Months is selected.',
            'vehicle_no.required_if' => 'The Vehicle no field is required.',
            'nric.required_if' => 'The NRIC field is required.',
            'estimated_mileage.required_if' => 'The Estimated mileage field is required.',
        ];

        $request->validate([
            'vehicle_registration_no' => 'required',
            'nric_company_registration_no' => 'required|min:4|max:4',
            'loan_purchase_price' => 'required',
            'loan_amount' => 'required',
            'bank_id' => 'required',
            'tenor' => 'required',
            'year' => 'required_if:tenor,2',
            'month' => 'required_if:tenor,2|numeric|min:0|max:12',
            'quote_trade' => 'required',
            'vehicle_no' => 'required_if:quote_trade,1',
            'nric' => 'required_if:quote_trade,1',
            'estimated_mileage' => 'required_if:quote_trade,1',
            'status' => 'required',
        ], $messages);

        $send_email = 0;
        $loan = Loan::findorfail($id);
        $loan->vehicle_registration_no = $request->vehicle_registration_no;
        $loan->owner_id_type = $request->owner_id_type;
        $loan->nric_company_registration_no = $request->nric_company_registration_no;
        $loan->bank_id = $request->bank_id;
        $loan->loan_purchase_price = str_replace(',','', $request->loan_purchase_price);
        $loan->loan_amount = str_replace(',', '', $request->loan_amount);
        $loan->down_payment = str_replace(',', '', $request->down_payment);
        $loan->estimated_monthly_installment = str_replace(',', '', $request->estimated_monthly_installment);
        $loan->tenor = $request->tenor;
        if($loan->tenor==2)
        {
            $loan->year = $request->year;
            $loan->month = $request->month;
        }
        else
        {
            $loan->year = null;
            $loan->month = null;
        }
        $loan->quote_trade = $request->quote_trade;
        if($loan->quote_trade==1)
        {
            $loan->trade_details = json_encode([
                'vehicle_no' => $request->vehicle_no,
                'nric' => $request->nric,
                'owner_id_typee' => $request->owner_id_typee,
                'estimated_mileage' => str_replace(',','',$request->estimated_mileage),
            ]);
        }
        else
        {
            $loan->trade_details = null;
        }
        if($loan->status<>$request->status)
        {
            $send_email = 1;
        }

        $loan->data_protection = $request->data_protection;
        $loan->other_documents = $request->other_document_uploaded ? json_encode($request->other_document_uploaded) : null;
        $loan->status = $request->status;
        $loan->save();

        if($send_email)
        {
            // EMAIL
            $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_LOAN_APPLICATION_TO_LOAN_APPLICANT'));
            if ($email_template) {
                $data = [];

                $url = url('loan-applications/'.strtotime($loan->created_at).'/'.$loan->id);
                $url = '<a href="'.$url.'">'.$url.'</a>';
                $status  = getLoanStatus($request->status) ?? 'Processing';

                $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                $data['from_email'] = $this->systemSetting()->from_email;
                $data['email'] = [$loan->user->email];
                $data['cc_to_email'] = [];
                if($loan->other_documents)
                {
                    $other_documents = json_decode($loan->other_documents, true);
                    if($other_documents)
                    {
                        $data['attachment'] = str_replace('storage', '', $other_documents);
                    }
                }


                $data['subject'] = $email_template->subject;

                /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

                $key = ['{{username}}', '{{status}}', '{{url}}'];
                $value = [$loan->user->name, $status, $url];
                $newContent = str_replace($key, $value, $email_template->content);
                $data['contents'] = $newContent;

                try {
                    SendEmail::dispatch($data);
                } catch (Exception $exception) {
                    //dd($exception);
                }
            }
        }
        if(!empty($request->previousUrll)){
            return redirect($request->previousUrll)->with('success',  __('constant.UPDATED', ['module' => $this->title]));
        }else{
            return redirect('admin/loan-application')->with('success', 'Loan Application has been updated.');
        }
        // return redirect('admin/loan-application')->with('success', 'Loan Application has been updated.');
    }

    public function search(Request $request)
    {
        $title = $this->title;
        $query = Loan::query();

        if($request->search1)
        {
            $user = User::where('name', 'like', '%'.$request->search1.'%')->orWhere('email', 'like', '%'.$request->search1.'%')->orWhere('mobile', 'like', '%'.$request->search1.'%')->get();
            $query->whereIn('user_id', $user->pluck('id'));
        }

        if($request->search2)
        {
            $query->where(function($inner_query) use($request) {
                return $inner_query->where('vehicle_registration_no', 'like', '%'.$request->search2.'%')->orWhere('nric_company_registration_no', 'like', '%'.$request->search2.'%')->orWhere('loan_purchase_price', 'like', '%'.$request->search2.'%')->orWhere('loan_amount', 'like', '%'.$request->search2.'%');
            });
        }

        if($request->search3)
        {
            $bank = Bank::where('title', 'like', '%'.$request->search3.'%')->get();
            $query->whereIn('bank_id', $bank->pluck('id'));
        }

        if($request->status)
        {
            $query->where('status', $request->status);
        }

        $loan_application = $query->paginate($this->pagination);
        if($request->search1)
        {
            $loan_application->appends('search1', $request->search1);
        }
        if($request->search2)
        {
            $loan_application->appends('search2', $request->search2);
        }
        if($request->search3)
        {
            $loan_application->appends('search3', $request->search3);
        }
        if($request->status)
        {
            $loan_application->appends('status', $request->status);
        }

        return view('admin.loan_application.index', compact('title', 'loan_application'));
    }

    public function upload_files(Request $request)
    {
        $file_type = explode(', ', $request->uploadfiles['photo']);
        $file_inputs = array();
        if($request->hasFile('other_document'))
        {
            $file = $request->file('other_document');
            if(!in_array($file->getClientOriginalExtension(), $file_type))
            {
                return response()->json(['error', 'Only '.$request->uploadfiles['photo'].' supported file format'], 422);
            }
            elseif($file->getSize()>5000000)
            {
                return response()->json(['error', '5MB max file size supported.'], 422);
            }
            else
            {
                $loan_application = $file;
                $filename = Carbon::now()->format('YmdHis') . '_' . $loan_application->getClientOriginalName();
                $filepath = 'storage/loan_application/';
                Storage::putFileAs(
                    'public/loan_application', $loan_application, $filename
                );
                $path_loan_application = $filepath.$filename;
                $file_inputs[] = $path_loan_application;
            }
        }

        if(count($file_inputs)>0)
        {
            foreach($file_inputs as $input)
            {
                $file_display = explode('/', $input);
        ?>
           <div class="uploaded_file">
                <i class="fas fa-minus-circle text-danger remove_file" style="cursor: pointer;"></i>
                <a href="<?php echo url($input); ?>" target="_blank">
                    <?php
                    if($file_display[2])
                    {
                        $file_name = explode('__', $file_display[2]);
                        $my_file_name = end($file_name);
                        echo $my_file_name;
                    }
                    ?>
                </a>
                <input type="hidden" name="<?php if($request->hasFile('other_document')) {echo "other_document_uploaded[]";} ?>" value="<?php echo $input ?>">
            </div>
        <?php
            }
        }
    }

    public function show($id)
    {
        $title = $this->title;
        $loan_application = Loan::findorfail($id);

        return view('admin.loan_application.show', compact('title', 'loan_application'));
    }

    public function destroy(Request $request, $id)
    {
        $id = explode(',', $request->multiple_delete);
        Loan::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }
}
