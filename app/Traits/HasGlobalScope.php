<?php

namespace App\Traits;

use App\Libraries\DNA;

trait HasGlobalScope
{

    public function scopeActive($query)
    {
        return $query->where("active", true);
    }

    public function scopeInactive($query)
    {
        return $query->where("active", false);
    }
}
