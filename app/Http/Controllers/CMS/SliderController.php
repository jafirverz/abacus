<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Page;
use App\Slider;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.SLIDER');
        $this->module = 'HOME_BANNER';
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
        $pages = Page::where('slug', 'home')->get();
        $slider = Slider::orderBy('view_order', 'asc')->paginate($this->pagination);

        return view('admin.cms.slider.index', compact('title', 'slider', 'pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $page = Page::find(__('constant.HOME_PAGE_ID'));
        $max_view_order = Slider::max('view_order');
        if ($max_view_order) {
            $max_view_order++;
        } else {
            $max_view_order = 1;
        }
        return view('admin.cms.slider.create', compact('title', 'page', 'max_view_order'));
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
            'title' =>  'required|max:60',
            'content' =>  'required',
            'slider_images'  =>  'required|file|mimes:jpg,png,gif,jpeg|max:2000',
            'link_label' => 'required_with:link',
            'link' => 'nullable|url',
            'view_order' =>  'required',
            'status' =>  'required',
        ]);

        $slider = new Slider;
        if ($request->hasFile('slider_images')) {
            $slider_images = $request->file('slider_images');
            $filename = Carbon::now()->format('YmdHis') . '_' . $slider_images->getClientOriginalName();
            $filepath = 'storage/slider/';
            Storage::putFileAs(
                'public/slider',
                $slider_images,
                $filename
            );
            $path_slider = $filepath . $filename;
            $slider->slider_images = $path_slider;
        }
        $slider->title = $request->title ?? NULL;
        $slider->content = $request->content ?? NULL;
        $slider->link_label = $request->link_label ?? NULL;
        $slider->link = $request->link ?? NULL;
        $slider->page_id = $request->page_id ?? NULL;
        $slider->view_order = $request->view_order ?? 0;
        $slider->status = $request->status;
        $slider->save();

        return redirect()->route('slider.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $pages = Page::where('slug', 'home')->get();
        $slider = Slider::find($id);

        return view('admin.cms.slider.show', compact('title', 'slider', 'pages'));
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
        $pages = Page::where('slug', 'home')->get();
        $slider = Slider::find($id);

        return view('admin.cms.slider.edit', compact('title', 'slider', 'pages'));
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
            'title' =>  'required|max:60',
            'content' =>  'required',
            'slider_images'  =>  'sometimes|file|mimes:jpg,png,gif,jpeg|max:2000',
            'link_label' => 'required_with:link',
            'link' => 'nullable|url',
            'view_order' =>  'required',
            'status' =>  'required',
        ]);

        $slider = Slider::find($id);
        if ($request->hasFile('slider_images')) {
            $slider_images = $request->file('slider_images');
            $filename = Carbon::now()->format('YmdHis') . '_' . '_' . $slider_images->getClientOriginalName();
            $filepath = 'storage/slider/';
            Storage::putFileAs(
                'public/slider',
                $slider_images,
                $filename
            );
            $path_slider = $filepath . $filename;
            $slider->slider_images = $path_slider;
        }
        $slider->title = $request->title ?? NULL;
        $slider->content = $request->content ?? NULL;
        $slider->link_label = $request->link_label ?? NULL;
        $slider->link = $request->link ?? NULL;
        $slider->page_id = $request->page_id ?? NULL;
        $slider->view_order = $request->view_order ?? 0;
        $slider->status = $request->status;
        $slider->save();

        return redirect()->route('slider.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
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
        Slider::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        //DB::enableQueryLog();
        $title = $this->title;
        $slider = Slider::search($request->search)->orderBy('view_order', 'asc')->paginate($this->pagination);
        // dd(DB::getQueryLog());
        $pages = Page::all();
        return view('admin.cms.slider.index', compact('title', 'slider', 'pages'));
    }
}
