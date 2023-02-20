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
    
    public function checkboxChecked($item,$collection) {
        if(in_array($item,$collection)) {
            return "checked";
        }
        return "";
    }
      
    public function operationTimeSetting($item,$collection,$type) {
        $data = $collection->where('day', $item)->first();

        if($type == "start_time") {
            return ($data)? $data->start_time : '08:00';
        }
        return ($data)? $data->end_time : '22:00';
    }

    public static function instance()
    {
        return new Helper();
    }
}