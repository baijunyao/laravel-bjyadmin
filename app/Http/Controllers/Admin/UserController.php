<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $data = User::orderBy('id', 'desc')->paginate(15);
        $assign = [
            'data'=>$data
        ];
        return view('admin/user/index', $assign);
    }

}
