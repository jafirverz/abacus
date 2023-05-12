<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Mail\AdminSideMail;
use App\Page;
use App\Testimonial;
use App\Traits\GetEmailTemplate;
use App\Traits\GetSmartBlock;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Newsletter;

class HomeController extends Controller
{
    use SystemSettingTrait, GetSmartBlock, GetEmailTemplate;

    public function __construct()
    {
        $this->system_settings = $this->systemSetting();
        $this->smart_blocks = $this->smartBlock();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function subscribe(Request $request)
    {
        $email = $request->email;
        $checkStatus = Newsletter::isSubscribed($email);
        if ($checkStatus) {
            return response()->json(['error' => 'You are already subscribed.'], 422);
        } else {
            $response = Newsletter::subscribeOrUpdate($email);

            // EMAIL Notification to the User
            $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_MAILCHIMP_SUBSCRIBER'));
            if ($email_template) {
                $data = [];
                $token = base64_encode($email);
                $url = route('unsubscribe', $token);
                $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
                $data['from_email'] = $this->systemSetting()->from_email;
                $data['to_email'] = [$email];
                $data['cc_to_email'] = [];

                $data['subject'] = $email_template->subject;

                $key = ['/{{unsubscribe_url}}'];
                $value = [$url];
                $newContent = str_replace($key, $value, $email_template->content);

                $data['contents'] = $newContent;

                try {
                    $mail = Mail::to($data['to_email'])->send(new AdminSideMail($data));
                } catch (Exception $exception) {
                    //dd($exception);
                }
            }

            return response()->json(['success' => 'You are subscribed now!'], 200);
        }
    }

    public function testimonialStore(Request $request)
    {


        //dd($request->all());
        $system_settings = $this->system_settings;
        // Get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $system_settings->recaptcha_secret_key . '&response=' . $request->captcha_response);
        $responseData = json_decode($verifyResponse);
        $messages = [];
        $messages['name.required'] = 'The your name field is required.';
        $messages['content.required'] = 'The description field is required.';
        $messages['content.max'] = 'The description may not be greater than 260 characters.';
        $request->validate(
            [
                'name'  =>  'required',
                'content'  =>  'required|string|max:260',
                'picture'  =>  'required|file|mimes:jpg,png,jpeg|max:2000',
            ],
            $messages
        );

        if (!$responseData->success) {
            return redirect()->back()->withInput()->with('error', __('constant.CAPTCHA_ERROR'));
        }

        $testimonial = new Testimonial();

        if ($request->hasFile('picture')) {

            $testimonial->picture = uploadPicture($request->file('picture'), __('constant.TESTIMONIAL'));

            //? Resize image
            imageResize(asset($testimonial->picture), 380, 200);
        }


        $testimonial->name = $request->name;
        $testimonial->content = $request->content;
        $testimonial->featured = 2;
        $testimonial->featured_view_order = 0;
        $testimonial->view_order = 0;
        $testimonial->status = 1;
        $testimonial->created_at = Carbon::now();
        $testimonial->save();

        // EMAIL
        /* $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_USER_TESTIMONIAL'));
        if ($email_template) {
            $data = [];

            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
            $data['from_email'] = $this->systemSetting()->from_email;
            $data['cc_to_email'] = [];

            $data['subject'] = $email_template->subject;

           

            $key = ['{{full_name}}'];
            $value = [$testimonial->name];
            $newContent = str_replace($key, $value, $email_template->content);
            $data['contents'] = $newContent;
            try {
                $mail = Mail::to($contactEnquiry->email)->send(new AdminSideMail($data));
            } catch (Exception $exception) {
                
            }
        } */

        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_ADMIN_TESTIMONIAL'));
        if ($email_template) {
            $data = [];

            $toEmails = explode(",", $system_settings->to_email);
            $url = url("/admin/testimonial/" . $testimonial->id);

            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
            $data['from_email'] = $this->systemSetting()->from_email;
            $data['cc_to_email'] = [];

            $data['subject'] = $email_template->subject;

            /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

            $key = ['{{your_name}}', '{{description}}', "/{{action_url}}", "{{action_url}}"];
            $value = [$testimonial->full_name, $testimonial->content, $url, $url];
            $newContent = str_replace($key, $value, $email_template->content);
            $data['contents'] = $newContent;

            foreach ($toEmails as $to) {
                try {
                    $mail = Mail::to($to)->send(new AdminSideMail($data));
                } catch (Exception $exception) {
                    //dd($exception);
                }
            }
        }
        $page = Page::where('id', __('constant.TESTIMONIAL_THANK_YOU_PAGE_ID'))->where('status', 1)->first();
        if (!$page) {
            return redirect()->back()->with('success',  "Testimonial submitted successfully");
        }
        return redirect(url($page->slug));
    }

    /**
     * 
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function enqueue(Request $request)
    {

        $system_settings = $this->system_settings;
        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_ADMIN_TESTIMONIAL'));
        if ($email_template) {
            $data = [];

            $toEmails = explode(",", $system_settings->to_email);
            $url = url("/");

            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
            $data['from_email'] = $this->systemSetting()->from_email;
            $data['cc_to_email'] = [];

            $data['subject'] = $email_template->subject;

            /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

            $key = ['{{your_name}}', '{{description}}', "/{{action_url}}", "{{action_url}}"];
            $value = ["Nikunj Patel", "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, to", $url, $url];
            $newContent = str_replace($key, $value, $email_template->content);
            $data['contents'] = $newContent;

            for ($i = 1; $i <= 30; $i++) {
                $data['email'] = "nikunj@verzdesign.com";
                $data['subject'] = "Email Queue: " . $i;
                try {
                    if (in_array($i, [25, 29])) {
                        SendEmail::dispatch($data)->onQueue('high');
                    } elseif (in_array($i, [26, 30])) {
                        SendEmail::dispatch($data)->onQueue('low');
                    } else {
                        SendEmail::dispatch($data);
                    }
                } catch (Exception $exception) {
                    //dd($exception);
                }
            }


            dd("Done");
            //$emailJob = (new SendEmail($details))->delay(Carbon::now()->addMinutes(5));
            //dispatch($emailJob);
        }
    }
}
