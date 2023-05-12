<?php

namespace App\Traits;

use App\MessageTemplate;

trait GetMessageTemplate
{
    protected function messageTemplate($messageTemplateId)
    {
        //check page
        $messageTemplate = MessageTemplate::where('id', $messageTemplateId)
            ->where('status', 1)
            ->first();
        return $messageTemplate;

    }
}
