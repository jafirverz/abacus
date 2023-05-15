<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Specifications;
use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SpecificationsController extends Controller
{
    use SystemSettingTrait;
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('Car Features');
        $this->module = 'SPECIFICATION';
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
        $specifications = Specifications::orderBy('position', 'asc')->paginate($this->pagination);

        return view('admin.specifications.index', compact('title', 'specifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;

        return view('admin.specifications.create', compact('title'));
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
            'specification'  =>  'required|unique:specifications',
            'position'   =>  'required',
            'status'   =>  'required',
        ]);

        $specification = new Specifications;
        $specification->specification = $request->specification;
        $specification->position = $request->position;
        $specification->status = $request->status;
		$specification->created_at = Carbon::now();
        $specification->save();

        return redirect()->route('specifications.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $specifications = Specifications::findorfail($id);

        return view('admin.specifications.show', compact('title', 'specifications'));
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
        $specifications = Specifications::findorfail($id);

        return view('admin.specifications.edit', compact('title', 'specifications'));
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
            'specification'  =>  'required',
            'position'   =>  'required',
            'status'   =>  'required',
        ]);

        $specification = Specifications::findorfail($id);
        $specification->specification = $request->specification;
        $specification->position = $request->position;
        $specification->status = $request->status;
        $specification->updated_at = Carbon::now();
        $specification->save();
        
        if(!empty($request->previousUrll)){
            return redirect($request->previousUrll)->with('success',  __('constant.UPDATED', ['module' => $this->title]));
        }else{
            return redirect()->route('specifications.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
        }
        // return redirect()->route('specifications.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
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
        Specifications::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $title = $this->title;
        $search = $request->search;
        $specifications = Specifications::search($search)->orderBy('position', 'asc')->paginate($this->systemSetting()->pagination);

        return view('admin.specifications.index', compact('title', 'specifications'));
    }
}
