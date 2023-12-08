<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Message;

class ReviewController extends Controller{

    public function sendReview(Request $request){        
        try {
            
            $request->validate([
                'mark' => 'required',
                'picture_id' => 'required',                
            ]);  
          
            $user = Auth::user();                
            Review::create([                  
                'user_id' => $user->id,
                'date' => date("Y-m-d"),
                'mark' => $request->input('mark'),
                'picture_id' => $request->input('picture_id'),
                
            ]);                         
            return response()->json(['data'=>'success']);

        } catch (\Exception $e) {            
            return response()->json(['data' => 'error'], 404);
        }
    }   
}