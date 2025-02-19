<?php

use App\Models\Prefecture;

if(!function_exists('getAllPrefectures')){
    function getAllPrefectures()
    {
        return Prefecture::all();
    }
}
