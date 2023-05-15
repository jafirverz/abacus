<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Testimonial;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Image;

class TestimonialController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.TESTIMONIAL');
        $this->module = 'TESTIMONIAL';
        $this->width = 380;
        $this->height = 200;
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
        $testimonial = Testimonial::orderBy('view_order', 'asc')->paginate($this->pagination);

        return view('admin/testimonial.index', compact('title', 'testimonial'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $testimonial = Testimonial::orderBy('view_order', 'asc')->get();

        return view('admin/testimonial.create', compact('title', 'testimonial'));
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
            'customer_name'  =>  'required',
            // 'content'  =>  'required|max:300',
            'content'  =>  'required',
            'picture'  =>  'required|file|mimes:jpg,png,gif,jpeg|max:2000',
            'view_order'   =>  'required',
            'status'  =>  'required',
        ]);


        $testimonial = new Testimonial;

        if ($request->hasFile('picture')) {

            $testimonial->picture = uploadPicture($request->file('picture'), $this->title);

            //? Resize image
            imageResize(asset($testimonial->picture), $this->height, $this->width);
        }


        $testimonial->customer_name = $request->customer_name;
		$testimonial->designation = $request->designation;
        $testimonial->content = $request->content;
        $testimonial->view_order = $request->view_order;
        $testimonial->status = $request->status;
        $testimonial->created_at = Carbon::now();
        $testimonial->save();

        return redirect()->route('testimonial.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
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
        $testimonial = Testimonial::findorfail($id);

        return view('admin.testimonial.show', compact('title', 'testimonial'));
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
        $testimonial = Testimonial::findorfail($id);
        return view('admin/testimonial.edit', compact('title', 'testimonial'));
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
            'customer_name'  =>  'required',
            // 'content'  =>  'required|max:300',
            'content'  =>  'required',
            'picture'  =>  'nullable|file|mimes:jpg,png,gif,jpeg|max:2000',
            'view_order'   =>  'required',
            'status'  =>  'required',
        ]);
        //dd(json_encode($request->picture_uploaded));
        $testimonial = Testimonial::findorfail($id);

        if ($request->hasFile('picture')) {

            $testimonial->picture = uploadPicture($request->file('picture'), $this->title);

            //? Resize image
            imageResize($testimonial->picture, $this->width,$this->height);
        }
        $testimonial->customer_name = $request->customer_name;
		$testimonial->designation = $request->designation;
        $testimonial->content = $request->content;
        $testimonial->view_order = $request->view_order;
        $testimonial->status = $request->status;
        $testimonial->updated_at = Carbon::now();
        $testimonial->save();

        return redirect()->route('testimonial.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
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
        Testimonial::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        //DB::enableQueryLog();
        $title = $this->title;
        $testimonial = Testimonial::search($request)->orderBy('view_order', 'asc')->paginate($this->systemSetting()->pagination);
        return view('admin.testimonial.index', compact('title', 'testimonial'));
    }


    //Update Status

    public function update_status($id, $type)
    {
        $testimonial = Testimonial::findorfail($id);
        $testimonial->status = $type;
        $testimonial->save();
        return redirect()->route('testimonial.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
    }

    // Resource ajax file upload
    public function upload_files(Request $request)
    {

        $file_type = ['png', 'jpg', 'gif', 'PNG', 'JPG', 'GIF'];
        $file_inputs = array();
        $all_files = explode(',', $request->all_files);
        $count = 0;
        if (isset($request->picture_uploaded)) {
            $count = count($request->picture_uploaded);
        }
        if (isset($request->picture)) {
            $count += count($request->picture);
        }
        if ($count > 3) {
            return "max_upload_exceed";
        }
        if ($files = $request->file('picture')) {
            foreach ($files as $file) {

                if (!in_array($file->getClientOriginalExtension(), $file_type)) {
                    return "invalid_file_type";
                } elseif ($file->getSize() > 25000000) {
                    return "invalid_file_size";
                } elseif (in_array($file->getClientOriginalName(), $all_files)) {
                    return "duplicate_file_name";
                } else {
                    $imageFilepath = 'storage/testimonial/';
                    $imgName = Carbon::now()->format('YmdHis') . '_' . $file->getClientOriginalName();
                    /* Main Image store */
                    $img = Image::make(($file)->getRealPath());
                    $img->resize(300, 160);
                    $img->save($imageFilepath . $imgName);

                    $file_inputs[] = $imageFilepath . $imgName;
                }
            }
        }
        //dd($file_inputs);

        if (count($file_inputs) > 0) {
            foreach ($file_inputs as $input) {
                //$file_display = explode('/', $input);
?>
                <div class="tb-col row-file">
                    <a class="fas fa-minus-circle link-2 remove_file" href="javascript:void(0);"></a>
                    <?php echo $input; ?>
                    &nbsp;<a class="btn-download" target="_blank" href="<?php echo url($input); ?>"> <i class="fas fa-download"></i></a>
                    <input type="hidden" name="picture_uploaded[]" value="<?php echo $input ?>">
                </div>
<?php
            }
        }
    }
}
