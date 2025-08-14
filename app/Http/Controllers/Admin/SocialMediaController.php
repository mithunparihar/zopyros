<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialMedia;
class SocialMediaController extends Controller
{
   
    function socialMedia(){
        $lists = \App\Models\SocialMedia::get();
        return view('admin.social-media',compact('lists'));
    }
    function socialMediaEdit(SocialMedia $info){
        return view('admin.edit-social-media',compact('info'));
    }
    function socialMediaUpdate(Request $request){
        if($request->social_account=='whatsapp'){
            $request->validate([
                'link' => 'required|digits:10',
            ],[
                'link.max' => 'The whatsapp number field must not be greater than 13 digits.',
                'link.min' => 'The whatsapp number field must not be less than 11 digits.',
                'link.required' => 'The whatsapp number field is required.',
            ]);
        }else{
            $request->validate([
                'link' => 'required|url',
            ],[
                'link.required_without' => 'The link field is required.',
            ]);
        }

        $data = \App\Models\SocialMedia::find($request->preId);
        $data->link = $request->link;
        $data->social_media_icon = $request->social_account;
        $data->save();
        flash()->addSuccess('Data updated!');
        return back();
    }
}
