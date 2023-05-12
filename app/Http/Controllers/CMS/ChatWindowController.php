<?php

namespace App\Http\Controllers\CMS;

use App\ChatWindow;
use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class ChatWindowController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.CHAT_WINDOW_MANAGEMENT');
        $this->module = 'CHAT_WINDOW_MANAGEMENT';
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
        $chatWindow = ChatWindow::orderBy('created_at','desc')->paginate($this->pagination);
        return view('admin.chat-window.index', compact('title', 'chatWindow'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        return view('admin.chat-window.create', compact('title'));
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
            'icon'  =>  'required|file|mimes:jpg,png,gif,jpeg|max:25000',
			'url'  =>  'required|url',
			'view_order'  =>  'required',
            'status' =>  'required',
        ]);

        $chatWindow = new ChatWindow;
		$chatWindow->title = $request->title??NULL;
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $filename = Carbon::now()->format('Y-m-d H-i-s') . '__' . guid() . '__' . $icon->getClientOriginalName();
            $filepath = 'storage/chat-window/';
            Storage::putFileAs(
                'public/chat-window', $icon, $filename
            );
            $path_icon = $filepath . $filename;
            $chatWindow->icon = $path_icon;
        }
		$chatWindow->url = $request->url??NULL;
		$chatWindow->view_order = $request->view_order??NULL;
        $chatWindow->status = $request->status;
        $chatWindow->save();

        return redirect()->route('chat-window.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $chatWindow = ChatWindow::find($id);

        return view('admin.chat-window.show', compact('title', 'chatWindow'));
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
        $chatWindow = ChatWindow::find($id);

        return view('admin.chat-window.edit', compact('title', 'chatWindow'));
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
            'icon'  =>  'nullable|file|mimes:jpg,png,gif,jpeg|max:25000',
			'url'  =>  'required|url',
			'view_order'  =>  'required',
            'status' =>  'required',
        ]);

        $chatWindow = ChatWindow::find($id);
        $chatWindow->title = $request->title??NULL;
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $filename = Carbon::now()->format('Y-m-d H-i-s') . '__' . guid() . '__' . $icon->getClientOriginalName();
            $filepath = 'storage/chat-window/';
            Storage::putFileAs(
                'public/chat-window', $icon, $filename
            );
            $path_icon = $filepath . $filename;
            $chatWindow->icon = $path_icon;
        }
		$chatWindow->url = $request->url??NULL;
		$chatWindow->view_order = $request->view_order??NULL;
        $chatWindow->status = $request->status;
        $chatWindow->save();

        return redirect()->route('chat-window.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
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
            ChatWindow::destroy($id);
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
        $chatWindow =  ChatWindow::select('chat_windows.*')->search($search)->orderBy('created_at','desc')->paginate($this->pagination);
		//dd($search);
        return view('admin.chat-window.index', compact('title', 'secondary_title', 'chatWindow'));
    }
}
