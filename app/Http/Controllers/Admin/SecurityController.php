<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    public function index(){
        $lists = \CommanFunction::logActivityLists('admin');
        return view('admin.security',compact('lists'));
    }
}
