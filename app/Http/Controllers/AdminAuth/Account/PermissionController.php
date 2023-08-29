<?php

namespace App\Http\Controllers\AdminAuth\Account;

use App\Http\Controllers\Controller;
use App\PermissionAccess;
use App\Role;
use App\Admin;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use Carbon\Carbon;
use DB;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->module_name = 'ROLES_AND_PERMISSION';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'views');

        $roles = Role::all();
        $admins = Admin::join('roles', 'admins.admin_role', '=', 'roles.id')->select('admins.firstname as admin_name', 'roles.name as role_name', 'admins.id as admins_id', 'admins.created_at as admin_created_at', 'admins.updated_at as admin_updated_at', 'admins.*', 'roles.*')->get();

        return view('admin.account.roles-and-permission', [
            'page_title' => 'Roles and Permission',
            'roles'      => $roles,
            'admins'    =>  $admins,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');

        return view('admin.account.create_permission', [
            'page_title' => 'Create',
            'modules'    => getModules(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
        $role = Role::create(['guard_name' => 'admin', 'name' => $request->role_name]);
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

        return redirect('admin/roles-and-permission')->with('success',  __('constant.UPDATED', ['module'    =>  __('constant.ROLES_AND_PERMISSION')]));
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
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');

        return view('admin.account.edit-roles-and-permission', [
            'page_title' => 'Edit',
            'id'         => $id,
            'modules'    => getModules(),
            'role_id'    => $id,
        ]);
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
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
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

        return redirect('admin/roles-and-permission')->with('success',  __('constant.UPDATED', ['module'    =>  __('constant.ROLES_AND_PERMISSION')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if($request->id==1)
        {
            return redirect('/admin/roles-and-permission')->with('error',  'Warning! Role cannot be deleted.');
        }
        $role = Role::find($request->id);
        $role->delete();
        DB::table('role_has_permissions')->where('role_id', $request->id)->delete();

        return redirect('/admin/roles-and-permission')->with('success',  __('constant.DELETED', ['module'    =>  __('constant.ROLE')]));
    }

    public function access_not_allowed()
    {
        return view('admin.account.access-not-allowed', [
            'page_title' => 'Access Rights',
        ]);
    }

    public function create_roles()
    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
        $roles = Role::all();
        $title = "Create Admin User";

        return view('admin.account.create_admin', compact('roles', 'title'));
    }

    public function store_roles(Request $request)
    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'creates');
        $request->validate([
            'firstname'  =>  'required',
            'lastname'  =>  'required',
            'country_id'  =>  'required',
            'email' =>  'required|email|unique:admins',
            'password'  =>  'required|min:8',
            'admin_role'    =>  'required',
        ]);

        $admins = new Admin;
        $admins->firstname   =   $request->firstname;
        $admins->lastname   =   $request->lastname;
        $admins->email = $request->email;
        $admins->country_id = $request->country_id;
        $admins->password = Hash::make($request->password);
        $admins->admin_role = $request->admin_role;
        $admins->status = $request->status;
        $admins->save();

        return redirect('/admin/roles-and-permission')->with('success',  __('constant.CREATED', ['module'    =>  __('constant.ROLES_AND_PERMISSION')]));
    }

    public function edit_roles($id)
    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $roles = Role::all();
        $admin = Admin::find($id);
        $title = "Edit Admin User";

        return view('admin.account.edit_admin', compact('roles', 'title', 'admin'));
    }

    public function update_roles(Request $request, $id)
    {
        //is_permission_allowed(Auth::user()->admin_role, $this->module_name, 'edits');
        $request->validate([
            'firstname'  =>  'required',
            'lastname'  =>  'required',
            'country_id'  =>  'required',
            'email' =>  'required|email|unique:admins,email,'.$id.',id',
            'password'  =>  'nullable|min:8',
            'admin_role'    =>  'required',
        ]);

        $admins = Admin::find($id);
        $admins->firstname   =   $request->firstname;
        $admins->lastname   =   $request->lastname;
        $admins->email = $request->email;
        $admins->country_id = $request->country_id;
        if($request->password)
        {
            $admins->password = Hash::make($request->password);
        }
        $admins->admin_role = $request->admin_role;
        if(Auth::user()->id!=1)
        {
            $admins->status = $request->status;
        }
        $admins->updated_at = Carbon::now();
        $admins->save();

        return redirect('/admin/roles-and-permission')->with('success',  __('constant.UPDATED', ['module'    =>  __('constant.ROLES_AND_PERMISSION')]));
    }

    public function delete_roles(Request $request)
    {
        if($request->id==1)
        {
            return redirect('/admin/roles-and-permission')->with('error',  'Warning! Role cannot be deleted.');
        }
        $admins = Admin::find($request->id);
        $admins->delete();

        return redirect('/admin/roles-and-permission')->with('success',  __('constant.DELETED', ['module'    =>  __('constant.ROLE')]));
    }
}
