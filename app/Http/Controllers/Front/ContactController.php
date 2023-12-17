<?php

namespace App\Http\Controllers\Front;

use App\Models\User;
use App\Models\Picture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;


class ContactController extends Controller{

    public function show($user_id)
    {
        $user = User::where('id', $user_id)->get();
        $pictures = Picture::where('user_id', $user_id)->get();
        
        return view('contact')->with(['user'=>$user[0],'pictures'=>$pictures]);
    }

    public function submitForm(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        // Process form data here
	    $user_id = $request->input('user_id');
        $user = User::where('id', $user_id)->get();

        Mail::to($user[0]->email)->send(new ContactFormMail($validatedData));           
	      

        return response('OK');
    }

    public function suppportContact(Request $request){

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        // Process form data here

        Mail::to('support@nature-spy.com')->send(new ContactFormMail($validatedData));           
	      

        return response('OK');
    }
}