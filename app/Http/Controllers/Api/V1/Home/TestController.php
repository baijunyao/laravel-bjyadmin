<?php

namespace App\Http\Controllers\Api\V1\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function index()
    {
        echo config('api.version');
    }

    public function test(Request $request)
    {
        $data=$request->all();
        p($data);
    }
}
