<?php

namespace App\Http\Controllers\CMS;

use App\Partner;
use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class PartnerControlle extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.PARTNER');
        $this->module = 'PARTNER';
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
        $partner = Partner::orderBy('created_at','desc')->paginate($this->pagination);

        return view('admin.partner.index', compact('title', 'partner'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        return view('admin.partner.create', compact('title'));
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
		    'partner_name'  =>  'required',
            'logo'  =>  'required|file|mimes:jpg,png,gif,jpeg|max:25000',
			'url'  =>  'required|url',
			'view_order'  =>  'required',
            'status' =>  'required',
        ]);

        $partner = new Partner;
		$partner->partner_name = $request->partner_name??NULL;
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = Carbon::now()->format('Y-m-d H-i-s') . '__' . guid() . '__' . $logo->getClientOriginalName();
            $filepath = 'storage/partner/';
            Storage::putFileAs(
                'public/partner', $logo, $filename
            );
            $path_logo = $filepath . $filename;
            $partner->logo = $path_logo;
        }
		$partner->url = $request->url??NULL;
		$partner->view_order = $request->view_order??NULL;
        $partner->status = $request->status;
        $partner->save();

        return redirect()->route('partner.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $partner = Partner::find($id);

        return view('admin.partner.show', compact('title', 'partner'));
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
        $partner = Partner::find($id);

        return view('admin.partner.edit', compact('title', 'partner'));
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
		    'partner_name'  =>  'required',
            'logo'  =>  'nullable|file|mimes:jpg,png,gif,jpeg|max:25000',
			'url'  =>  'required|url',
			'view_order'  =>  'required',
            'status' =>  'required',
        ]);

        $partner = Partner::find($id);
        $partner->partner_name = $request->partner_name??NULL;
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = Carbon::now()->format('Y-m-d H-i-s') . '__' . guid() . '__' . $logo->getClientOriginalName();
            $filepath = 'storage/partner/';
            Storage::putFileAs(
                'public/partner', $logo, $filename
            );
            $path_logo = $filepath . $filename;
            $partner->logo = $path_logo;
        }
		$partner->url = $request->url??NULL;
		$partner->view_order = $request->view_order??NULL;
        $partner->status = $request->status;
        $partner->save();

        return redirect()->route('partner.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
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
        try {
            Partner::destroy($id);
        } catch (QueryException $e) {

            if ($e->getCode() == "23000") {

                //!!23000 is sql code for integrity constraint violation
                return redirect()->back()->with('error',  __('constant.FOREIGN', ['module'    =>  $this->title]));
            }
        }

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

	 public function search(Request $request)
    {
        $title = $this->title;
        $secondary_title = "Search";
        $search = $request->search;
        $partner =  Partner::select('partners.*')->search($search)->orderBy('created_at','desc')->paginate($this->pagination);
		//dd($search);
        return view('admin.partner.index', compact('title', 'secondary_title', 'partner'));
    }
}
