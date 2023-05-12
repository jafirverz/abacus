<?php

namespace App\Http\Controllers\CMS;

use App\OneMotoring;
use App\Category;
use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class OneMotoringController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.ONE_MOTORING');
        $this->module = 'ONE_MOTORING';
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
        $OneMotoring = OneMotoring::join('categories','categories.id','=','one_motorings.category_id')->select('one_motorings.*','categories.title as category')->orderBy('one_motorings.created_at','desc')->paginate($this->pagination);
        $categories = Category::orderBy('created_at','desc')->get();
        return view('admin.oneMotoring.index', compact('title', 'OneMotoring','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
		$categories = Category::orderBy('created_at','desc')->get();
        return view('admin.oneMotoring.create', compact('title','categories'));
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
			'link'  =>  'required|url',
			'category_id'  =>  'required',
			'view_order'  =>  'required',
            'status' =>  'required',
        ]);

        $OneMotoring = new OneMotoring;
		$OneMotoring->title = $request->title??NULL;
		$OneMotoring->link = $request->link??NULL;
		$OneMotoring->category_id = $request->category_id??NULL;
		$OneMotoring->view_order = $request->view_order??NULL;
        $OneMotoring->status = $request->status;
        $OneMotoring->save();

        return redirect()->route('oneMotoring.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $oneMotoring = OneMotoring::join('categories','categories.id','=','one_motorings.category_id')->select('one_motorings.*','categories.title as category')->first($id);

        return view('admin.oneMotoring.show', compact('title', 'oneMotoring'));
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
        $oneMotoring = OneMotoring::find($id);
        $categories = Category::orderBy('created_at','desc')->get();
        return view('admin.oneMotoring.edit', compact('title', 'oneMotoring','categories'));
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
			'link'  =>  'required|url',
			'category_id'  =>  'required',
			'view_order'  =>  'required',
            'status' =>  'required',
        ]);

        $OneMotoring = OneMotoring::find($id);
        $OneMotoring->title = $request->title??NULL;
		$OneMotoring->link = $request->link??NULL;
		$OneMotoring->category_id = $request->category_id??NULL;
		$OneMotoring->view_order = $request->view_order??NULL;
        $OneMotoring->status = $request->status;
        $OneMotoring->save();

        return redirect()->route('oneMotoring.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
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
            OneMotoring::destroy($id);
        } catch (QueryException $e) {

            if ($e->getCode() == "23000") {

                //!!23000 is sql code for integrity constraint violation
                return redirect()->back()->with('error',  __('constant.FOREIGN', ['module'    =>  $this->title]));
            }
        }

        return redirect()->back()->with('success',  __('constant.DELETED_ALL', ['module'    =>  $this->title]));
    }

	 public function search(Request $request)
    {
        $title = $this->title;
        $secondary_title = "Search";
        $search = $request;
		$categories = Category::orderBy('created_at','desc')->get();
        $OneMotoring =  OneMotoring::join('categories','categories.id','=','one_motorings.category_id')->select('one_motorings.*','categories.title as category')->search($search)->orderBy('one_motorings.created_at','desc')->paginate($this->pagination);
		//dd($search);
        return view('admin.oneMotoring.index', compact('title', 'secondary_title', 'OneMotoring','categories'));
    }
}
