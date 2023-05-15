<?php

namespace App\Traits;

use App\SmsTemplate;

trait GetSmsTemplate
{
    protected function smsTemplate($smsTemplateId)
    {
        //check page
        $smsTemplate = SmsTemplate::where('id', $smsTemplateId)
            ->where('status', 1)
            ->first();
        return $smsTemplate;

    }
}
