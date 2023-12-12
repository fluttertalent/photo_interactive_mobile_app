<?php

namespace App\Http\Controllers\Front;

use App\Models\Picture;
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
            'email' => 'Please login to access to see photos.',
        ])->onlyInput('email');
    }

    public function delete($id){
        if(Auth::check()){
            try{
                Picture::where('id', $id)->delete();   
                session()->flash('msg','Photo deleted successfully.');
                session()->flash('success','true');
                return redirect()->back();
            }catch(\Exception $e){
                return response()->json(['error' => 'Can not delete Photo'], 404);
            }
        }
        return redirect()->route('login')
            ->withErrors([
            'email' => 'Please login to access to delete the photo.',
        ])->onlyInput('email');
    }
}           