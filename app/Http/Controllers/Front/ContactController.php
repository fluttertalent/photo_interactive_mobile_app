<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Models\Picture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller{

    public function show($user_id)
    {
        $user = User::where('id', $user_id)->get();
        $pictures = Picture::where('user_id', $user_id)->get();
        
        return view('contact')->with(['user'=>$user[0],'pictures'=>$pictures]);
    }
}