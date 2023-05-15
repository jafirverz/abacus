<?php

namespace App\Traits;

use App\Menu;
use App\MenuList;
use App\Page;

trait PageTrait
{
    protected function getPages($slug)
    {
        $result = Page::where('slug', $slug)->active()->first();
        if($result)
        {
            return $result;
        }
        return false;
    }

    protected function getAllPages()
    {
        $result = Page::active()->get();
        if($result->count())
        {
            return $result;
        }
        return false;
    }

    protected function getMenu()
    {
        $result = $menu_list = MenuList::join('pages', 'menu_lists.page_id', '=', 'pages.id')->select('pages.id as pages_id', 'menu_lists.title as menu_title', 'pages.title as page_title', 'menu_lists.*', 'pages.*')->orderBy('menu_lists.view_order', 'asc')->get();
        if($result)
        {
            return $result;
        }
    }
}
