<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Filter;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.FILTER_MANAGEMENT');
        $this->module = 'FILTER_MANAGEMENT';
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
        $filter = Filter::orderBy('type', 'asc')->orderBy('view_order', 'asc')->paginate($this->pagination);
        return view('admin.filter.index', compact('title', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        return view('admin.filter.create', compact('title'));
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
            'title'  =>  'required',
			 'type'  =>  'required',
             'from_value'  =>  'nullable|numeric|min:1',
             'to_value'  =>  'nullable|numeric|min:1',
            'view_order'   =>  'required|numeric',
        ]);

        $filter = new Filter;
        $filter->title = $request->title;
		    $filter->type = $request->type;
		    $filter->to_value = $request->to_value?$request->to_value:NULL;
        $filter->from_value = $request->from_value?$request->from_value:NULL;
        $filter->make_val = $request->make_val?$request->make_val:NULL;
        $filter->content = $request->content?$request->content:NULL;

        $filter->view_order = $request->view_order;
        $filter->save();

        return redirect()->route('filter.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $filter = Filter::findorfail($id);

        return view('admin.filter.show', compact('title', 'filter'));
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
        $filter = Filter::findorfail($id);
        return view('admin.filter.edit', compact('title', 'filter'));
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
            'title'  =>  'required',
            'from_value'  =>  'nullable|numeric|min:1',
            'to_value'  =>  'nullable|numeric|min:1',
            'view_order'   =>  'required|numeric',
        ]);

        $filter = Filter::findorfail($id);
        $filter->title = $request->title;
        //$filter->type = $request->type;
        $filter->to_value = $request->to_value?$request->to_value:NULL;
        $filter->from_value = $request->from_value?$request->from_value:NULL;
        $filter->make_val = $request->make_val?$request->make_val:NULL;
        $filter->content = $request->content?$request->content:NULL;
        $filter->view_order = $request->view_order;
        $filter->updated_at = Carbon::now();
        $filter->save();
        
        if(!empty($request->previousUrll)){
            return redirect($request->previousUrll)->with('success',  __('constant.UPDATED', ['module' => $this->title]));
        }else{
            return redirect()->route('filter.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
        }
        // return redirect()->route('filter.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
    }

    public function get_make($type=null)
    {
        $option="";
        if(getFilterValByType(5 ))
        {
            $option.='<label for="type">Type</label>';
            $option.="<select class='form-control' name='make_val'>";
            foreach(getFilterValByType(5) as $key => $val)
            {
                $option.="<option value='".$val->title."'>".$val->title."</option>";
            }
            $option.="</select>";

            return $option;
        }
        return null;
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
        Filter::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        //DB::enableQueryLog();
		$title = $this->title;
        $filter = Filter::search($request)->orderBy('view_order', 'asc')->paginate($this->pagination);
       // dd(DB::getQueryLog());
        return view('admin.filter.index', compact('title', 'filter'));
    }
}
