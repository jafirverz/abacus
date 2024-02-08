<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\ImagesUpload;

class ImageUploadController extends Controller
{
    //

    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.IMAGEUPLOAD');
        $this->module = 'IMAGEUPLOAD';
        $this->middleware('grant.permission:' . $this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $title = 'Image Upload';
        $images = ImagesUpload::orderBy('id', 'desc')->paginate(10);

        return view('admin.cms.pages.image_upload', compact('title', 'images'));
    }

    public function create()
    {
        $title = 'Image Upload';
        return view('admin.cms.pages.create_image', compact('title'));
    }

    public function store(Request $request)
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

    public function destroy(Request $request){
        $deleteId = explode(',',$request->multiple_delete);
        foreach($deleteId as $item){
            $image = ImagesUpload::where('id', $item)->first();
            $image->delete();
        }
        return redirect()->route('image-upload')->with('success',  __('constant.DELETED', ['module'    =>  'Image']));
    }
}
