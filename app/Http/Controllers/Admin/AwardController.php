<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Award;

class AwardController extends Controller
{
    public function index() {
        return view('admin.award.lists');
    }

    

}