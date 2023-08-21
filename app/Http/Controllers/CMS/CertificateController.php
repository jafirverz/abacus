<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Certificate;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{

    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.CERTIFICATE');
        $this->module = 'CERTIFICATE';
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
        //
        $title = $this->title;
        $certificates = Certificate::paginate($this->pagination);
        return view('admin.certificate.index', compact('title', 'certificates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = $this->title;
        return view('admin.certificate.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'content' =>  'required',
            'title'  =>  'required',
            'status' =>  'required',
            'certificate_type' => 'required',
        ]);

        $certificate = new Certificate();
        $certificate->certification_type = $request->certificate_type;
        $certificate->title = $request->title;
        $certificate->subject = $request->subject;
        $certificate->content = $request->content;
        $certificate->status = $request->status;
        $certificate->save();
        return redirect()->route('certificate.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $title = $this->title;
        $certificate = Certificate::where('id', $id)->first();
        return view('admin.certificate.show', compact('title', 'certificate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $title = $this->title;
        $certificate = Certificate::where('id', $id)->first();
        return view('admin.certificate.edit', compact('title', 'certificate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'content' =>  'required',
            'title'  =>  'required',
            'status' =>  'required',
            'certificate_type' => 'required',
        ]);
        $certificate = Certificate::where('id', $id)->first();
        $certificate->certification_type = $request->certificate_type;
        $certificate->title = $request->title;
        $certificate->subject = $request->subject;
        $certificate->content = $request->content;
        $certificate->status = $request->status;
        $certificate->save();
        return redirect()->route('certificate.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certificate $certificate)
    {
        //
    }
}
