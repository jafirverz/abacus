<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class GrantPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $module)
    {

		$method_name = explode('@', $request->route()->getActionName());
        switch ($method_name[1]) {
            case 'index':
                $type = 'views';
                break;
			case 'list':
                $type = 'views';
                break;
            case 'create':
                $type = 'creates';
                break;
            case 'store':
                $type = 'creates';
                break;
            case 'edit':
                $type = 'edits';
                break;
            case 'update':
                $type = 'edits';
                break;
            default:
                $type = '';
                break;
        }

        if($type)
        {
            is_permission_allowed(Auth::user()->id, Auth::user()->admin_role, $module, $type);
        }

        return $next($request);
    }
}
