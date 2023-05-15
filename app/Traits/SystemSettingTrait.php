<?php

namespace App\Traits;

use App\SystemSetting;

trait SystemSettingTrait
{
    protected function systemSetting()
    {
        return (object) SystemSetting::pluck('title','key')->all();
    }
}
