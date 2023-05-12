<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Menu;
use App\MenuList;
use App\Page;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuListController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.MENU_LIST');
        $this->module = 'MENU_LIST';
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
    public function index($menu)
    {

        $menu_title = Menu::findorfail($menu);
        $menu_list = MenuList::where('menu_id', $menu)->orderBy('view_order', 'asc')->paginate($this->pagination);

        $title = $this->title;
        $pages = Page::where('parent', 0)->get();

        return view('admin.cms.menu.menu_list.index', compact('title', 'menu_list', 'menu', 'pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($menu)
    {
        $menu_title = Menu::findorfail($menu);
        $title = $this->title;

        if ($menu == __('constant.TOP_MENU')) {
            $pages = Page::where('parent', 0)->orderBy('title', 'asc')->get();
        } else {
            $pages = Page::orderBy('title', 'asc')->get();
        }


        return view('admin.cms.menu.menu_list.create', compact('title', 'menu', 'pages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $menu)
    {

        //External Link validation
        if ($request->new_tab == 1) {
            $request->validate([
                'title'  =>  'required',
                'external_link' => 'required|url',
                'view_order'    =>  'required|numeric',
                'status'   =>  'required',
            ]);
        } else {
            $request->validate([
                'title'  =>  'required',
                'page_id'  =>  'required',
                'view_order'    =>  'required|numeric',
                'status'   =>  'required',
            ]);
        }

        $menu_list = new MenuList;
        $menu_list->menu_id = $menu;
        $menu_list->title = $request->title;
        $menu_list->page_id = $request->page_id ?: 0;
        //$menu_list->new_tab = $request->new_tab ?: 0;
        $menu_list->view_order = $request->view_order;
        //$menu_list->external_link = ($request->new_tab==1)?$request->external_link:'';
        $menu_list->status = $request->status;
        $menu_list->created_at = Carbon::now();
        $menu_list->save();

        return redirect()->route('menu-list.index', $menu)->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($menu, $id)
    {
        $menu_title = Menu::findorfail($menu);
        $title = $this->title;
        $menu_list = MenuList::findorfail($id);
        $pages = Page::where('parent', 0)->get();

        return view('admin.cms.menu.menu_list.show', compact('title', 'menu', 'menu_list', 'pages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($menu, $id)
    {
        $menu_title = Menu::findorfail($menu);
        $title = $this->title;
        $menu_list = MenuList::findorfail($id);
        if ($menu == __('constant.TOP_MENU')) {
            $pages = Page::where('parent', 0)->orderBy('title', 'asc')->get();
        } else {
            $pages = Page::orderBy('title', 'asc')->get();
        }

        return view('admin.cms.menu.menu_list.edit', compact('title', 'menu', 'menu_list', 'pages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $menu, $id)
    {
        if ($request->new_tab == 1) {
            //External Link validation
            $request->validate([
                'title'  =>  'required',
                'external_link' => 'required|url',
                'view_order'    =>  'required|numeric',
                'status'   =>  'required',
            ]);
        } else {
            $request->validate([
                'title'  =>  'required',
                'page_id'  =>  'required',
                'view_order'    =>  'required|numeric',
                'status'   =>  'required',
            ]);
        }

        $menu_list = MenuList::findorfail($id);
        $menu_list->title = $request->title;
        /*if (in_array($menu_list->page_id, [__('constant.EVENT_CATEGORY'), __('constant.GALERY_CATEGORY')])) {
            $menu_list->page_id = 0;
            $menu_list->category = $request->page_id;
        } else {
            $menu_list->page_id = $request->page_id ?: 0;
            $menu_list->category = 0;
        }*/
        $menu_list->page_id = $request->page_id ?: 0;
        $menu_list->view_order = $request->view_order;
        //$menu_list->new_tab = $request->new_tab ?: 0;
        $menu_list->status = $request->status;
        //$menu_list->external_link = ($request->new_tab==1)?$request->external_link:'';
        $menu_list->updated_at = Carbon::now();
        $menu_list->save();

        return redirect()->route('menu-list.index', $menu)->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
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
            MenuList::destroy($id);
        } catch (QueryException $e) {

            if ($e->getCode() == "23000") {

                //!!23000 is sql code for integrity constraint violation
                return redirect()->back()->with('error',  __('constant.FOREIGN', ['module'    =>  $this->title]));
            }
        }
        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }
    //Search from menu and pages
    public function search(Request $request, $menu)
    {
        // DB::enableQueryLog();

        $search = $request->search;
        $menu_title = Menu::findorfail($menu);
        $title = $this->title;
        $pages = Page::where('parent', 0)->get();
        $menu_list = MenuList::leftJoin('pages', 'pages.id', '=', 'menu_lists.page_id')->select('menu_lists.title as menu_list_title', 'menu_lists.view_order as menu_list_view_order', 'menu_lists.created_at as menu_list_created_at', 'menu_lists.updated_at as menu_list_updated_at', 'pages.*', 'menu_lists.*')->where('menu_lists.menu_id', $menu)->search($search)->orderBy('menu_lists.view_order', 'asc')->paginate($this->pagination);
        //dd(DB::getQueryLog());

        return view('admin.cms.menu.menu_list.index', compact('title', 'menu_list', 'menu', 'pages'));
    }
}
