<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Contact;
use App\Mail\AdminSideMail;
use Illuminate\Http\Request;
use App\Page;
use App\Menu;
use App\Slider;
use App\SystemSetting;
use App\User;
use App\Traits\SystemSettingTrait;
use App\Traits\GetSmartBlock;
use App\Mail\EmailNotification;
use App\Traits\GetEmailTemplate;
use Exception;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    use SystemSettingTrait, GetSmartBlock, GetEmailTemplate;

    public function __construct()
    {
        $this->system_settings = $this->systemSetting();
        $this->smart_blocks = $this->smartBlock();
    }

    public function submitEnquiry(Request $request)
    {
        //dd($request->all());
        $system_settings = $this->system_settings;
        // Get verify response data
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $system_settings->recaptcha_secret_key . '&response=' . $request->captcha_response);
        $responseData = json_decode($verifyResponse);
        $messages = [];
        $messages['full_name.required'] = 'The full name field is required.';
        $messages['email.required'] = 'The email field is required.';
        $messages['email.email'] = 'The email must be a valid email address.';
        $messages['country_code.required'] = 'The country code field is required.';
        $messages['country_code.regex'] = ' The country code format is invalid. Please use like +65.';
        $messages['contact_number.regex'] = ' The contact number is invalid.';
        $messages['contact_number.required'] = 'The contact number field is required.';
        $messages['contact_number.min'] = 'The contact number must be at least 8 characters.';
       // $messages['company.required'] = 'The company/organization field is required.';
        $messages['comment.required'] = 'The comments/feedbacks field is required.';
        $messages['comment.max'] = 'The comments/feedbacks may not be greater than 1000 characters.';
        $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email',
            'country_code' => 'required|regex:/^(\+)([1-9]{1,3})$/',
            'contact_number' => 'required|min:8|regex:/^([1-9][0-9]{7,9})$/',
            //'company' => 'required|string',
            'comment'   =>  'required|max:1000',
        ], $messages);

        if (!$responseData->success) {
            return redirect()->back()->withInput()->with('error', __('constant.CAPTCHA_ERROR'));
        }
        $contactEnquiry = new Contact();
        $contactEnquiry->full_name = $request->full_name;
        $contactEnquiry->email = $request->email;
        $contactEnquiry->country_code = $request->country_code;
        $contactEnquiry->contact_number = $request->contact_number;
        $contactEnquiry->company = $request->company;
        $contactEnquiry->enquiry_purpose = $request->enquiry_purpose;
        $contactEnquiry->comment = $request->comment;
        $contactEnquiry->save();

        // EMAIL
        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_USER_CONTACT_ENQUIRY'));
        if ($email_template) {
            $data = [];

            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
            $data['from_email'] = $this->systemSetting()->from_email;
            $data['cc_to_email'] = [];

            $data['subject'] = $email_template->subject;

            /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

            $key = ['{{full_name}}'];
            $value = [$contactEnquiry->full_name];
            $newContent = str_replace($key, $value, $email_template->content);
            $data['contents'] = $newContent;
            try {
                $mail = Mail::to($contactEnquiry->email)->send(new AdminSideMail($data));
            } catch (Exception $exception) {
                //dd($exception);
            }
        }

        $email_template = $this->emailTemplate(__('constant.EMAIL_TEMPLATE_TO_ADMIN_CONTACT_ENQUIRY'));
        if ($email_template) {
            $data = [];

            $toEmails = explode(",", $system_settings->to_email);
            $url = url("/admin/contact/" . $contactEnquiry->id);

            $data['email_sender_name'] = $this->systemSetting()->email_sender_name;
            $data['from_email'] = $this->systemSetting()->from_email;
            $data['cc_to_email'] = [];

            $data['subject'] = $email_template->subject;

            /* "Please take note : /{{action_url}}", "{{action_url}}" use different different because admin panel href"/{{action_url}}" */

            $key = ['{{full_name}}', '{{email}}', "{{contact_number}}", "{{company}}", "{{purpose}}", "{{comments}}", "/{{action_url}}", "{{action_url}}"];
            $value = [$contactEnquiry->full_name, $contactEnquiry->email, $contactEnquiry->contact_number.' '.$contactEnquiry->contact_number, $contactEnquiry->company, $contactEnquiry->enquiry_purpose, $contactEnquiry->comment, $url, $url];
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
        $page = Page::where('id', __('constant.THANK_YOU_PAGE_ID'))->where('status', 1)->first();
        if (!$page) {
            return redirect()->back()->with('success',  "Contact enquiry submitted successfully");
        }
        return redirect(url($page->slug));
    }
}
