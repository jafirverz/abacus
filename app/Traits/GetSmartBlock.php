<?php

namespace App\Traits;

use App\SmartBlock;

trait GetSmartBlock
{
    protected function smartBlock($smartBlockId = "ALL")
    {
        //check page
        if ($smartBlockId == "ALL") {
            $smartBlock = SmartBlock::get();
        } else {
            $smartBlock = SmartBlock::where('id', $smartBlockId)
                ->first();
        }

        return $smartBlock;
    }
}
