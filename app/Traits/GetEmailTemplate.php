<?php

namespace App\Traits;

use App\EmailTemplate;

trait GetEmailTemplate
{
    protected function emailTemplate($emailTemplateId)
    {
        //check page
        $emailTemplate = EmailTemplate::where('id', $emailTemplateId)
            ->where('status', 1)
            ->first();
        return $emailTemplate;

    }
}