<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Attributes;
use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttributesController extends Controller
{
    use SystemSettingTrait;
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('Car Accessories');
        $this->module = 'ACCESSORIES';
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
        $attributes = Attributes::orderBy('position', 'asc')->paginate($this->pagination);

        return view('admin.attributes.index', compact('title', 'attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;

        return view('admin.attributes.create', compact('title'));
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
            'attribute_title'  =>  'required|unique:attributes',
            'position'   =>  'required',
            'status'   =>  'required',
        ]);

        $attribute = new Attributes;
        $attribute->attribute_title = $request->attribute_title;
        $attribute->position = $request->position;
        $attribute->status = $request->status;
		$attribute->created_at = Carbon::now();
        $attribute->save();

        return redirect()->route('attributes.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $attributes = Attributes::findorfail($id);

        return view('admin.attributes.show', compact('title', 'attributes'));
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
        $attributes = Attributes::findorfail($id);

        return view('admin.attributes.edit', compact('title', 'attributes'));
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
            'attribute_title'  =>  'required',
            'position'   =>  'required',
            'status'   =>  'required',
        ]);

        $attribute = Attributes::findorfail($id);
        $attribute->attribute_title = $request->attribute_title;
        $attribute->position = $request->position;
        $attribute->status = $request->status;
        $attribute->updated_at = Carbon::now();
        $attribute->save();

        return redirect()->route('attributes.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
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
        Attributes::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $title = $this->title;
        $search = $request->search;
        $attributes = Attributes::search($search)->orderBy('position', 'asc')->paginate($this->systemSetting()->pagination);

        return view('admin.attributes.index', compact('title', 'attributes'));
    }
}
