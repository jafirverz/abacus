<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\SystemSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SystemSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.SYSTEM_SETTING');
        $this->module = 'SYSTEM_SETTING';
        $this->middleware('grant.permission:' . $this->module);
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function edit()
    {
        $title = $this->title;
        $setting_fields = $this->setting_fields();
        $system_setting = SystemSetting::pluck('title', 'key')->all();
        // dd($system_setting);
        return view('admin.account.system_setting.edit', compact('title', 'system_setting', 'setting_fields'));
    }

    public function setting_fields()
    {
        return [
            [
                'title' => 'General',
                'key' => [
                    'site_name' => [
                        'label' => 'Site Name', 'input' => 'text', 'class' => 'form-control',
                    ],
                    'site_title' => [
                        'label' => 'Site Title', 'input' => 'text', 'class' => 'form-control', 'required' => '',
                    ],
                    'site_keyword' => [
                        'label' => 'Site Keyword', 'input' => 'text', 'class' => 'form-control',
                    ],
                    'site_description' => [
                        'label' => 'Site Description', 'input' => 'text', 'class' => 'form-control',
                    ],
                    'google_anaytics_code' => [
                        'label' => 'Google Analytics Code', 'input' => 'textarea', 'class' => 'form-control',
                    ],
                    'pagination' => [
                        'label' => 'Pagination', 'input' => 'number', 'class' => 'form-control', 'required' => '', 'value' => 10, 'min' => 10, 'max' => 100,
                    ],
                ],
            ],

            [
                'title' => 'Logo',
                'key' => [
                    'site_logo' => [
                        'label' => 'Site Logo', 'input' => 'file', 'class' => 'form-control', 'required' => '', 'size' => '1MB', 'pixel' => '220x35', 'format' => 'png, jpg, gif', 'accept' => '.jpeg, .gif, .jpg, .png',
                    ],
                    'favicon' => [
                        'label' => 'Favicon', 'input' => 'file', 'class' => 'form-control', 'required' => '', 'size' => '1MB', 'pixel' => '32x32', 'format' => 'png, ico', 'accept' => '.ico, .png',
                    ],
                    'email_logo' => [
                        'label' => 'Email Logo', 'input' => 'file', 'class' => 'form-control', 'required' => '', 'size' => '1MB', 'pixel' => '220x35', 'format' => 'png, jpg, gif', 'accept' => '.jpeg,.gif,.jpg,.png',
                    ],
                    'backend_logo' => [
                        'label' => 'Backend Logo', 'input' => 'file', 'class' => 'form-control', 'required' => '', 'size' => '1MB', 'pixel' => '220x35',
                        'format' => 'png, jpg, gif', 'accept' => '.jpeg, .gif, .jpg, .png',
                    ]
                ],
            ],
            [
                'title' => 'Icon',
                'key' => [
                    'grading_icon' => [
                        'label' => 'Grading Examination', 'input' => 'file', 'class' => 'form-control', 'required' => '', 'size' => '1MB', 'pixel' => '220x35', 'format' => 'png, jpg, gif', 'accept' => '.jpeg, .gif, .jpg, .png',
                    ],
                    'competition_icon' => [
                        'label' => 'Competition', 'input' => 'file', 'class' => 'form-control', 'required' => '', 'size' => '1MB', 'pixel' => '220x35', 'format' => 'png, jpg, gif', 'accept' => '.jpeg,.gif,.jpg,.png',
                    ],
                    'test_survey_icon' => [
                        'label' => 'Test/Survey', 'input' => 'file', 'class' => 'form-control', 'required' => '', 'size' => '1MB', 'pixel' => '220x35',
                        'format' => 'png, jpg, gif', 'accept' => '.jpeg, .gif, .jpg, .png',
                    ]
                ],
            ],

            [
                'title' => 'Email',
                'key' => [
                    'email_sender_name' => [
                        'label' => 'Email Sender Name', 'input' => 'text', 'class' => 'form-control', 'required' => '',
                    ],
                    'from_email' => [
                        'label' => 'From Email', 'input' => 'text', 'class' => 'form-control', 'required' => '',
                    ],
                    'to_email' => [
                        'label' => 'To Email', 'input' => 'text', 'class' => 'form-control', 'required' => '',
                    ],
                ],
            ],
			[
                'title' => 'Footer Contact Details',
                'key' => [
                    'contact_address' => [
                        'label' => 'Contact Address', 'input' => 'textarea', 'class' => 'form-control', 'required' => '',
                    ],
                    'contact_number' => [
                        'label' => 'Contact Number', 'input' => 'text', 'class' => 'form-control', 'required' => '',
                    ],
                    'contact_email' => [
                        'label' => 'Contact Email', 'input' => 'text', 'class' => 'form-control', 'required' => '',
                    ],
                    'contact_link' => [
                        'label' => 'Contact Link', 'input' => 'text', 'class' => 'form-control', 'required' => '',
                    ],
                ],
            ],

            [
                'title' => 'Social Link',
                'key' => [
                    'facebook_url' => [
                        'label' => 'Facebook', 'input' => 'text', 'class' => 'form-control', 'required' => '',
                    ],

                    'instagram_url' => [
                        'label' => 'Instagram', 'input' => 'text', 'class' => 'form-control',
                    ],
                    'linkedin_url' => [
                        'label' => 'Linkedin', 'input' => 'text', 'class' => 'form-control', 'required' => '',
                    ],

                ],
            ],
            [
                'title' => 'Google Recaptcha',
                'key' => [
                    'recaptcha_site_key' => [
                        'label' => 'Site Key', 'input' => 'text', 'class' => 'form-control', 'required' => '',
                    ],
                    'recaptcha_secret_key' => [
                        'label' => 'Seceret Key', 'input' => 'text', 'class' => 'form-control',
                    ],
                ]
            ],

        ];
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $logo = $request->file('favicon');
        foreach ($request->except('_token', '_method') as $key => $item) {
            $validator = Validator::make($request->all(), [
                'site_logo' => 'nullable|mimes:jpeg,png,png,gif|max:10000',
                'favicon' => 'nullable|mimes:ico,png|max:10000',
                'email_logo' => 'nullable|mimes:jpeg,png,gif|max:10000',
                'backend_logo' => 'nullable|mimes:jpeg,png,gif|max:10000',
//                'facebook_url' => 'nullable|url',
//                'twitter_url' => 'nullable|url',
//                'instagram_url' => 'nullable|url',
//                'linkedin_url' => 'nullable|url',
            ]);
            if ($validator->fails()) {
                //$errros =$validator->errors;
                return redirect()->back()->with('error',  'System setting have some following errors.')->withErrors($validator)->withInput();
            }
            $system_setting = SystemSetting::where('key', $key)->first();
            if (!$system_setting) {
                $system_setting = new SystemSetting;
            }

            $system_setting->key = $key;
            if (in_array($key, ['site_logo', 'favicon', 'email_logo', 'backend_logo','grading_icon','competition_icon','test_survey_icon'])) {
                if ($request->hasFile($key)) {
                    $logo = $request->file($key);
                    $filename = Carbon::now()->format('YmdHis') . '_' . $logo->getClientOriginalName();
                    $filepath = 'storage/' . $key . '/';
                    Storage::putFileAs(
                        'public/' . $key,
                        $logo,
                        $filename
                    );
                    $path_logo = $filepath . $filename;
                    $system_setting->title = $path_logo;
                }
            } else {
                $system_setting->title = $item;
            }
            $system_setting->save();
        }

        return redirect()->back()->with('success', __('constant.UPDATED', ['module' => $this->title]));
    }
}
