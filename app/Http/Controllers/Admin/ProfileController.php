<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){
        return view('admin.profile');
    }
    
    public function notifications(){
        return view('admin.notifications');
    }

    function removeNotification($id){
        \Content::adminInfo()->notifications()->where('id', $id)->delete();
        flash()->addSuccess('Data Removed!');
        return back();
    }
}
