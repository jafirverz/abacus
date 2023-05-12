<?php

namespace App\Http\Controllers\CMS;

use App\SmartBlock;
use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SmartBlockController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.SMART_BLOCK');
        $this->module = 'SMART_BLOCK';
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
        $smart_block = SmartBlock::orderBy('id', 'asc')->paginate($this->pagination);

        return view('admin.cms.smart_block.index', compact('title', 'smart_block'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;

        return view('admin.cms.smart_block.create', compact('title'));
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
            'header'   =>  'required',
            'content'  =>  'required',
            //'status'   =>  'required',
        ]);

        $smart_block = new SmartBlock;
        $smart_block->title = $request->title;
        $smart_block->header = $request->header;
        $smart_block->content = $request->content;
        //$smart_block->status = $request->status;
		$smart_block->created_at = Carbon::now();
        $smart_block->save();

        return redirect()->route('smart-block.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $smart_block = SmartBlock::findorfail($id);

        return view('admin.cms.smart_block.show', compact('title', 'smart_block'));
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
        $smart_block = SmartBlock::findorfail($id);

        return view('admin.cms.smart_block.edit', compact('title', 'smart_block'));
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
            'header'   =>  'required',
            'content'  =>  'required',
            //'status'   =>  'required',
        ]);

        $smart_block = SmartBlock::findorfail($id);
        $smart_block->title = $request->title;
        $smart_block->header = $request->header;
        $smart_block->content = $request->content;
        //$smart_block->status = $request->status;
        $smart_block->updated_at = Carbon::now();
        $smart_block->save();

        return redirect()->route('smart-block.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
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
        SmartBlock::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $title = $this->title;
        $search = $request->search;
        $smart_block = SmartBlock::search($search)->orderBy('view_order', 'asc')->paginate($this->systemSetting()->pagination);

        return view('admin.cms.smart_block.index', compact('title', 'smart_block'));
    }
}
