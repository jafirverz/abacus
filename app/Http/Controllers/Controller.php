<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function loginRedirect()
    {
        $slug = __('constant.SLUG_LOGIN');
        $page = get_page_by_slug($slug);

        if(!$page)
        {
            return abort(404);
        }
        return view('auth.login',compact("page"));
    }
}
