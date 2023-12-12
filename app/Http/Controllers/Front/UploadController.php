<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Models\Picture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller{

    public function uploadPic(Request $request){   
        if(Auth::check()){   

            $request->validate([
                'image' => 'image|max:6134|required', // Adjust the maximum file size as needed
                'item' => 'required',
                'lat' => 'required',
                'lng' => 'required',
            ]);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $user = Auth::user();
                
                Picture::create([
                    'url' => $imagePath,
                    'user_id' => $user->id,
                    'date' => date("Y-m-d"),
                    'time' => date("H:i:s"),
                    'item' => $request->input('item'),
                    'lat' => $request->input('lat'),
                    'lng' => $request->input('lng')
                ]);           
            }

            session()->flash('msg','Image uploaded successfully.');
            session()->flash('success','true');
            return redirect()->route('dashboard');
        }
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to upload the picture.',
        ])->onlyInput('email');
        
    }
    public function index(){
        if(Auth::check()){
            $user = Auth::user();
            return view('upload')->with('user',$user);
        }
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to access to upload page.',
        ])->onlyInput('email');
    }
}           