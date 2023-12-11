<?php

namespace App\Http\Controllers\CMS;

use App\EmailTemplate;
use App\ExaminationPass;
use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExaminationPassController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.PASS');
        $this->module = 'PASS';
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
        $email_template = ExaminationPass::orderBy('id', 'asc')->paginate($this->pagination);

        return view('admin.cms.pass.index', compact('title', 'email_template'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $title = $this->title;
        $email_template = ExaminationPass::findorfail($id);

        return view('admin.cms.pass.show', compact('title', 'email_template'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $title = $this->title;
        $email_template = ExaminationPass::findorfail($id);

        return view('admin.cms.pass.edit', compact('title', 'email_template'));
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
        //
        $request->validate([
            'title'  =>  'required',
            'content'  =>  'required',
        ]);

        $email_template = ExaminationPass::findorfail($id);
        $email_template->title = $request->title;
        $email_template->content = $request->content;
        $email_template->updated_at = Carbon::now();
        $email_template->save();

        return redirect()->route('pass.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
