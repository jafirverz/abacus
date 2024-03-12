<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Allocation;
use App\TestManagement;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TestAllocationController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.TEST_ALLOCATION');
        $this->module = 'TEST_ALLOCATION';
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
        if(Auth::user()->admin_role == 1)
        {
        $allocations = Allocation::where('allocations.type',1)->orderBy('id', 'desc')->paginate($this->pagination);
        }
        else
        {
        $allocations = Allocation::where('allocations.type',1)->join('users','users.id','allocations.student_id')->where('users.country_code', Auth::user()->country_id)->orderBy('allocations.id', 'desc')->select('allocations.*')->paginate($this->pagination);
        }

        return view('admin.test-allocation.index', compact('title', 'allocations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.test-allocation.create', compact('title', 'allocations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        $item = Allocation::findorfail($id);

        return view('admin.template.show', compact('title', 'item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        Template::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        //DB::enableQueryLog();
		$title = $this->title;
        $allocations = Allocation::join('test_management','allocations.assigned_id','test_management.id')->join('users','allocations.student_id','users.id')->select('allocations.*')->search($request->search)->where('allocations.type',1)->paginate($this->pagination);
       // dd(DB::getQueryLog());
        return view('admin.test-allocation.index', compact('title', 'allocations'));
    }
}
