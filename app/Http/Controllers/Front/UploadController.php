<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Models\Picture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller{

    public function uploadPic(Request $request){        
        $request->validate([
            'image' => 'image|max:2048|required', // Adjust the maximum file size as needed
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
        return redirect()->back();
    }
    public function index(){
        $user = Auth::user();
        return view('upload')->with('user',$user);
    }
}           