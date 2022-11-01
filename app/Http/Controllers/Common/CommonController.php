<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\District;

class CommonController extends Controller
{
    public function getDistrict()
    {
        return District::orderBy('title', 'asc')
            ->when(request('province'), function ($q) {
                return $q->where('province_id', request('province'));
            })
            ->get(['id', 'title', 'province_id']); 
    }
}
