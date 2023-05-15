<?php

namespace App\Http\Controllers\CMS;

use App\Banner;
use App\Http\Controllers\Controller;
use App\Page;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.BANNER');
        $this->module = 'PAGE_BANNER';
        $this->width = 1400;
        $this->height = 280;
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
        $pages = Page::all();
        $banner = Banner::orderBy('created_at', 'desc')->paginate($this->pagination);

        return view('admin.cms.banner.index', compact('title', 'banner', 'pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $pages = Page::all();
        return view('admin.cms.banner.create', compact('title', 'pages'));
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
            'page_id' =>  'required',
            'banner_image'  =>  'required|file|mimes:jpg,png,gif,jpeg|max:2000',
            'status' =>  'required',
        ]);

        $banner = new Banner;
        $banner->page_id = $request->page_id;
        
        if ($request->hasFile('banner_image')) {

            $banner->banner_image = uploadPicture($request->file('banner_image'), $this->title);

            //? Resize image
            imageResize(asset($banner->picture), $this->height, $this->width);
        }
		//$banner->url = $request->url??NULL;
        $banner->status = $request->status;
        $banner->save();

        return redirect()->route('banner.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $pages = Page::all();
        $banner = Banner::find($id);

        return view('admin.cms.banner.show', compact('title', 'banner', 'pages'));
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
        $pages = Page::all();
        $banner = Banner::find($id);

        return view('admin.cms.banner.edit', compact('title', 'banner', 'pages'));
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
            'page_id' =>  'required',
            'banner_image'  =>  'nullable|file|mimes:jpg,png,gif,jpeg|max:25000',
            'status' =>  'required',
        ]);

        $banner = Banner::find($id);
        $banner->page_id = $request->page_id;
        if ($request->hasFile('banner_image')) {

            $banner->banner_image = uploadPicture($request->file('banner_image'), $this->title);

            //? Resize image
            imageResize(asset($banner->picture), $this->height, $this->width);
        }
		//$banner->url = $request->url??NULL;
        $banner->status = $request->status;
        $banner->save();

        return redirect()->route('banner.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
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
        Banner::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

	 public function search(Request $request)
    {
        $title = $this->title;
        $secondary_title = "Search";
        $search = $request->search;
        $banner =  Banner::join('pages', 'pages.id', '=', 'banners.page_id')->select('banners.*')->search($search)->paginate($this->pagination);
        $pages = Page::all();
        return view('admin.cms.banner.index', compact('title', 'secondary_title', 'banner', 'pages'));
    }
}
