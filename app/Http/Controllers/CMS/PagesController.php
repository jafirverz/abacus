<?php

namespace App\Http\Controllers\CMS;

use App\Faq;
use App\Http\Controllers\Controller;
use App\ImagesUpload;
use App\Page;
use App\Testimonial;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PagesController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.PAGES');
        $this->module = 'PAGES';
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
        $pages = Page::orderBy('view_order', 'asc')->get();

        return view('admin.cms.pages.index', compact('title', 'pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $pages = Page::orderBy('title', 'asc')->get();

        return view('admin.cms.pages.create', compact('title', 'pages'));
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
            'slug'   =>  'required_unless:external_link,1|nullable|unique:pages,slug',
            'parent'  =>  'required',
            'external_link'  =>  'nullable|boolean',
            'external_link_value'  =>  'nullable|required_with:external_link|url',
            'content'  =>  'required_unless:external_link,1',
            'view_order'   =>  'required|numeric',
            'status'   =>  'required',
        ]);
        $external_link = $request->external_link ?? 0;
        $pages = new Page;
        $pages->title = $request->title;
        $pages->meta_title = $request->meta_title;
        $pages->meta_description = $request->meta_description;
        $pages->meta_keywords = $request->meta_keywords;
        $pages->external_link = $external_link;
        $pages->external_link_value = $request->external_link_value;
        $pages->target = $request->target ?? '_self';
        if ($external_link) {
            $pages->slug = null;
            $pages->content = null;
        } else {
            $pages->slug = $request->slug;
            $pages->content = $request->content;
        }
        $pages->parent = $request->parent;
        $pages->view_order = $request->view_order;
        $pages->status = $request->status;
        $pages->save();

        return redirect()->route('pages.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $page = Page::findorfail($id);
        $pages = Page::all();

        return view('admin.cms.pages.show', compact('title', 'page', 'pages'));
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
        $page = Page::findorfail($id);
        $pages = Page::whereNotIn('id', [$id])->orderBy('title', 'asc')->get();

        return view('admin.cms.pages.edit', compact('title', 'page', 'pages'));
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

        $fields = [
            'title'  =>  'required',
            'slug'   =>  'required_unless:external_link,1|nullable|unique:pages,slug,' . $id . ',id',
            'parent'  =>  'required',
            'external_link'  =>  'nullable|boolean',
            'external_link_value'  =>  'nullable|required_with:external_link|url',
            'content'  =>  'nullable',
            'header'  =>  'nullable',
            'view_order'   =>  'required|numeric',
        ];

        if (in_array($id, [__('constant.HOME_PAGE_ID')])) {
            $fields['marketplace_title'] = 'required';
            $fields['marketplace_link'] = 'required|url';
            $fields['marketplace_content'] = 'required';
        }
        if (in_array($id, [__('constant.ABOUT_PAGE_ID')])) {
            $fields['section_1'] = 'required';
            $fields['section_2'] = 'required';
            $fields['section_3'] = 'required';
        }
        if (in_array($id, [__('constant.INSURANCE_PAGE_ID')])) {
            $fields['section_1'] = 'required';
        }

        $request->validate($fields);

        $pages = Page::findorfail($id);
        $pages->title = $request->title;
        $pages->meta_title = $request->meta_title;
        $pages->meta_description = $request->meta_description;
        $pages->meta_keywords = $request->meta_keywords;
        $external_link = $request->external_link ?? 0;
        $pages->external_link = $external_link;
        $pages->external_link_value = $request->external_link_value;
        $pages->target = $request->target ?? '_self';
        if ($external_link) {
            $pages->slug = null;
            $pages->content = null;
        } else {
            $pages->slug = $request->slug;
            $pages->content = $request->content;
        }
        $pages->parent = $request->parent;
        $pages->view_order = $request->view_order;
        $pages->updated_at = Carbon::now();

        $content = [];
        if ($pages->json_content) {
            $content = json_decode($pages->json_content, true);
        }
        /* Start Home page attribute  */
        if (in_array($id, [__('constant.HOME_PAGE_ID')])) {

            $content['marketplace_title'] =  $request->marketplace_title;
            $content['marketplace_link'] =  $request->marketplace_link;
            $content['marketplace_content'] =  $request->marketplace_content;

            $pages->json_content = json_encode($content);
        } elseif (in_array($id, [__('constant.ABOUT_PAGE_ID')])) {

            $content['section_1'] =  $request->section_1;
            $content['section_2'] =  $request->section_2;
            $content['section_3'] =  $request->section_3;
            $content['section_4'] =  $request->section_4;
            $pages->json_content = json_encode($content);
        } elseif (in_array($id, [__('constant.INSURANCE_PAGE_ID')])) {

            $content['section_1'] =  $request->section_1;
            $content['section_2'] =  $request->section_2;
            $pages->json_content = json_encode($content);
        } elseif (in_array($id, [__('constant.LOAN_PAGE_ID')])) {

            $content['section_1'] =  $request->section_1;
            $content['section_2'] =  $request->section_2;
            $content['section_3'] =  $request->section_3;

            $pages->json_content = json_encode($content);
        } else {
            $pages->status = $request->status;
        }

        /* End Home page attribute */
        $pages->save();
        //dd( $pages);
        return redirect()->route('pages.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
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
        Page::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        DB::enableQueryLog();
        $title = $this->title;
        $pages = Page::orderBy('title', 'asc')->search($request)->orderBy('view_order', 'asc')->paginate($this->systemSetting()->pagination);
        //dd(DB::getQueryLog());
        return view('admin.cms.pages.index', compact('title', 'pages'));
    }

    public function imageUpload()
    {
        $title = 'Image Upload';
        $images = ImagesUpload::orderBy('id', 'desc')->paginate(10);

        return view('admin.cms.pages.image_upload', compact('title', 'images'));
    }

    public function imageCreate()
    {
        $title = 'Image Upload';
        return view('admin.cms.pages.create_image', compact('title'));
    }

    public function imageStore(Request $request)
    {
        $request->validate([
            'image' => 'required',
        ]);

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $filename = Carbon::now()->timestamp . '__' . guid() . '__' . $image->getClientOriginalName();

            $filepath = 'storage/images/';

            Storage::putFileAs(

                'public/images',
                $image,
                $filename

            );

            $image_path = $filepath . $filename;
            $imageUpload = new ImagesUpload();
            $imageUpload->image = $image_path;
            $imageUpload->save();
        }
        return redirect()->route('image-upload')->with('success',  __('constant.CREATED', ['module'    =>  'Image Upload']));
    }

    public function imageDelete(Request $request){
        $deleteId = explode(',',$request->multiple_delete);
        foreach($deleteId as $item){
            $image = ImagesUpload::where('id', $item)->first();
            $image->delete();
        }
        return redirect()->route('image-upload')->with('success',  __('constant.DELETED', ['module'    =>  'Image']));
    }
}
