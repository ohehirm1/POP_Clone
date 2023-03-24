<?php

use App\Models\User;
use Carbon\Carbon;

if (! function_exists('auther')) {
    function auther(): User
    {
        return auth()->user();
    }
}

if (! function_exists('carbon')) {
    function carbon($val): Carbon
    {
        return Carbon::make($val);
    }
}
