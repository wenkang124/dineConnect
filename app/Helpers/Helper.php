<?php

namespace App\Helpers;

class Helper
{
    public function selectionSelected($item,$collection) {
        if(in_array($item,$collection)) {
            return "selected";
        }
        return "";
    }
    
    public static function instance()
    {
        return new Helper();
    }
}