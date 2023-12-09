<?php

namespace App\Http\Controllers\Front;

use App\Models\Picture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PhotoController extends Controller{
    
    public function index(){
        if(Auth::check()){
            $user = Auth::user();
            $pictures = Picture::where('user_id', $user->id)->get();
            return view('auth.photo')->with('pictures', $pictures);
        }
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to access to upload the picture.',
        ])->onlyInput('email');
    }
}           