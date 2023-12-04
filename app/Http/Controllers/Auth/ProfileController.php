<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile')->with(['user'=>$user]);
    }

    public function update(Request $request)
    {
        
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250',            
        ]);
        
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->title = $request->input('title');
        $user->bio = $request->input('bio');        

        $user->save();
        session()->flash('msg', 'Profile updated successfully!');
        session()->flash('success', 'true');
        return back()->with(['user'=>$user,'success'=>'true', 'msg'=>'Porfile updated successfully!']); 
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail($attribute . ' is incorrect.');
                }
            }],
            'new_password' => ['required', 'confirmed', 'min:8'],
        ]); 

        Auth::user()->update([
            'password' => Hash::make($request->input('new_password')),
        ]);

        session()->flash('msg', 'Password has been changed!');
        session()->flash('success', 'true');
        return back();
    }

    public function updateAvatar(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'avatar' => 'image|max:2048' // Adjust the maximum file size as needed
        ]);

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user = Auth::user();
            $user->avatar = $avatarPath;    
            $user->save();
        }

        session()->flash('msg', 'Avartar has been updated!');
        session()->flash('success', 'true');
        return back()->with(['user'=>$user, 'success'=>'true', 'msg'=>'Avartar has been updated!']);
    }
}
