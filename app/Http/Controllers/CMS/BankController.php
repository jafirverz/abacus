<?php

namespace App\Http\Controllers\CMS;

use App\Bank;
use App\Http\Controllers\Controller;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.BANK');
        $this->module = 'BANK';
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
        $bank = Bank::paginate($this->pagination);

        return view('admin.master.bank.index', compact('title', 'bank'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        return view('admin.master.bank.create', compact('title'));
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
            'title'  =>  'required|unique:banks,title|max:191',
            'interest' => 'required|numeric',
            'terms_and_condition' => 'required|max:191',
            'view_order' => 'required|numeric',
            'status' =>  'required',
        ]);

        $bank = new Bank();
        $bank->title = $request->title;
        $bank->interest = $request->interest;
        $bank->terms_and_condition = $request->terms_and_condition;
        $bank->view_order = $request->view_order;
        $bank->status = $request->status;
        $bank->save();

        return redirect()->route('bank.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $bank = Bank::find($id);

        return view('admin.master.bank.show', compact('title', 'bank'));
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
        $bank = Bank::findorfail($id);

        return view('admin.master.bank.edit', compact('title', 'bank'));
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
            'title'  =>  'required|unique:banks,title,'.$id.',id|max:191',
            'interest' => 'required|numeric',
            'terms_and_condition' => 'required|max:191',
            'view_order' => 'required|numeric',
            'status' =>  'required',
        ]);

        $bank = Bank::findorfail($id);
        $bank->title = $request->title;
        $bank->interest = $request->interest;
        $bank->terms_and_condition = $request->terms_and_condition;
        $bank->view_order = $request->view_order;
        $bank->status = $request->status;
        $bank->save();

        return redirect()->route('bank.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
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
        Bank::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $title = $this->title;
        $query = Bank::query();
        if($request->search)
        {
            $query->search($request->search);
        }
        $bank = $query->paginate($this->pagination);

        if($request->search)
        {
            $bank->appends('search', $request->search);
        }


        return view('admin.master.bank.index', compact('title', 'bank'));
    }
}
