<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreLocation;
use App\Models\Contact;
class ContactController extends Controller
{
    public function index()
    {
        $lists = Contact::findOrFail(1);
        return view('admin.contact.edit',compact('lists'));
    }
    public function storeLocation()
    {
        $lists = StoreLocation::findOrFail(1);
        return view('admin.contact.store-location',compact('lists'));
    }
    
}
