<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Menu;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.MENU');
        $this->module = 'MENU';
        $this->middleware('grant.permission:' . $this->module);
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
        $menu = Menu::orderBy('view_order', 'asc')->paginate($this->pagination);

        return view('admin.cms.menu.index', compact('title', 'menu'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list($type = 'header')
    {

        if ($type == 'header') {
            $title = __('constant.HEADER_MENU_TITLE');
            $menu = Menu::whereIn('id', [__('constant.TOP_MENU')])->orderBy('view_order', 'asc')->paginate($this->pagination);
        } else {
            $title = __('constant.FOOTER_MENU_TITLE');
            $menu = Menu::whereNotIn('id', [__('constant.TOP_MENU')])->orderBy('view_order', 'asc')->paginate($this->pagination);
        }


        return view('admin.cms.menu.index', compact('title', 'menu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;

        return view('admin.cms.menu.create', compact('title'));
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
            'title'  =>  'required|unique:menus,title',
            'view_order'    =>  'required|numeric',
            'status'   =>  'required',
        ]);

        $menu = new Menu;
        $menu->title = $request->title;
        $menu->view_order = $request->view_order;
        $menu->status = $request->status;
        $menu->save();

        return redirect()->route('menu.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $menu = Menu::findorfail($id);

        return view('admin.cms.menu.show', compact('title', 'menu'));
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
        $menu = Menu::findorfail($id);

        return view('admin.cms.menu.edit', compact('title', 'menu'));
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
            'title'  =>  'required|unique:menus,title,' . $id . ',id',
            'view_order'    =>  'required|numeric',
            'status'   =>  'required',
        ]);

        $menu = Menu::findorfail($id);
        $menu->title = $request->title;
        $menu->view_order = $request->view_order;
        $menu->status = $request->status;
        $menu->updated_at = Carbon::now();
        $menu->save();
        if (in_array($id, [__('constant.TOP_MENU')])) {
            return redirect()->route('menu.list',['type'=>'header'])->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
        }else{
            return redirect()->route('menu.list',['type'=>'footer'])->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
        }
        
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
            Menu::destroy($id);
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
        $menu = Menu::search($search)->orderBy('view_order', 'asc')->paginate($this->pagination);

        return view('admin.cms.menu.index', compact('title', 'secondary_title', 'menu'));
    }
}
