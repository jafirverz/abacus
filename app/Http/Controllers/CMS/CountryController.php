<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Country;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.COUNTRY');
        $this->module = 'COUNTRY';
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
        $country = Country::orderBy('id','desc')->paginate($this->pagination);

        return view('admin.master.country.index', compact('title', 'country'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        return view('admin.master.country.create', compact('title'));
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
            'country'  =>  'required|unique:country,country|max:191',
        ]);

        $topic = new Country();
        $topic->country = $request->country;
        $topic->phonecode = $request->phonecode;
        $topic->save();

        return redirect()->route('country.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $country = Country::find($id);

        return view('admin.master.country.show', compact('title', 'country'));
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
        $country = Country::findorfail($id);
        return view('admin.master.country.edit', compact('title', 'country'));
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
            'country'  =>  'required|unique:country,country,'.$id.',id|max:191',
        ]);

        $topic = Country::findorfail($id);
        $topic->country = $request->country;
        $topic->phonecode = $request->phonecode;
        $topic->save();

        return redirect()->route('country.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = explode(',', $request->multiple_delete);
        Country::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module' =>  $this->title]));
    }

    public function search(Request $request)
    {
        $search_term = $request->search;
        $title = $this->title;
        $country = Country::orderBy('id','desc')->search($search_term)->paginate($this->pagination);
        if ($search_term) {
            $country->appends('search', $search_term);
        }

        return view('admin.master.country.index', compact('title', 'country'));
    }
}
