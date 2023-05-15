<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\PermissionAccess;
use App\Role;
use App\Traits\SystemSettingTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RolesPermissionController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.ROLES_AND_PERMISSION');
        $this->module = 'ROLES_AND_PERMISSION';
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
        $modules = getModules();
        $permissions = Role::orderBy('updated_at', 'asc')->paginate($this->pagination);

        return view('admin.account.roles_and_permission.index', compact('title', 'permissions', 'modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $modules = getModules();

        return view('admin.account.roles_and_permission.create', compact('title', 'modules'));
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
            'role_name'  =>  'required',
        ]);

        $role = Role::create(['guard_name' => 'admin', 'name' => $request->role_name]);
		//dd($role->id);
        DB::table('role_has_permissions')->insert(
            ['permission_id' => $role->id, 'role_id' => $role->id]
        );
        foreach ($request->module as $module) {
            $permission = new PermissionAccess;
            $permission->role_id = $role->id;
            $permission->module  = $module['name'][0] ?? 0;
            $permission->views   = $module['view'][0] ?? 0;
            $permission->creates = $module['create'][0] ?? 0;
            $permission->edits   = $module['edit'][0] ?? 0;
            $permission->deletes = $module['delete'][0] ?? 0;
            $permission->save();
        }

        return redirect()->route('roles-and-permission.index')->with('success',  __('constant.CREATED', ['module'    =>  __('constant.ROLES_AND_PERMISSION')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $role_id = $id;
        $modules = getModules();

        return view('admin.account.roles_and_permission.edit', compact('title', 'role_id', 'modules', 'id'));
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
        foreach ($request->module as $module) {
            $permission = PermissionAccess::where(['role_id'    =>  $id, 'module'   =>  $module])->first();
            $has_permission = PermissionAccess::where(['role_id'    =>  $id, 'module'   =>  $module])->get();
            if(!$has_permission->count()) {
                $permission = new PermissionAccess;
                $permission->role_id = $id;
            }
            $permission->module  = $module['name'][0] ?? 0;
            $permission->views   = $module['view'][0] ?? 0;
            $permission->creates = $module['create'][0] ?? 0;
            $permission->edits   = $module['edit'][0] ?? 0;
            $permission->deletes = $module['delete'][0] ?? 0;
            $permission->save();
        }

        return redirect()->route('roles-and-permission.index')->with('success',  __('constant.UPDATED', ['module'    =>  __('constant.ROLES_AND_PERMISSION')]));
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
        foreach($id as $item)
        {
            $role = Role::find($item);
            $role->delete();
            DB::table('role_has_permissions')->where('role_id', $item)->delete();
            PermissionAccess::where('role_id', $item)->delete();
        }
        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function access_not_allowed()
    {
        $title = "Access Rights";
        return view('admin.account.roles_and_permission.access_not_allowed', compact('title'));
    }

    public function search(Request $request)
    {
        $search_term = $request->search;

        $title = $this->title;
        $modules = getModules();
        $query = Role::query();
        if($search_term)
        {
            $query->search($search_term);
        }
        $permissions = $query->orderBy('updated_at', 'asc')->paginate($this->pagination);

        return view('admin.account.roles_and_permission.index', compact('title', 'permissions', 'modules'));
    }
}
