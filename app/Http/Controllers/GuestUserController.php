<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestUserController extends Controller
{
    //
    public function aboutUs(){
        $slug = 'about-us';
        $page = get_page_by_slug($slug);
		// $system_settings = $this->system_settings;
        // $smart_blocks = $this->smart_blocks;
        if (!$page) {
            return abort(404);
        }
        return view('about', compact('page'));
    }
    public function privacy(){
        $slug = 'privacy-policy';
        $page = get_page_by_slug($slug);
		// $system_settings = $this->system_settings;
        // $smart_blocks = $this->smart_blocks;
        if (!$page) {
            return abort(404);
        }
        return view('about', compact('page'));
    }
    public function faq(){
        $slug = 'faqs';
        $page = get_page_by_slug($slug);
		// $system_settings = $this->system_settings;
        // $smart_blocks = $this->smart_blocks;
        if (!$page) {
            return abort(404);
        }
        return view('about', compact('page'));
    }
    public function termsofuse(){
        $slug = 'terms-of-use';
        $page = get_page_by_slug($slug);
		// $system_settings = $this->system_settings;
        // $smart_blocks = $this->smart_blocks;
        if (!$page) {
            return abort(404);
        }
        return view('about', compact('page'));
    }
}
