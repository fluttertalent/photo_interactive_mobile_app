<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
    

    public function rankingView(Request $request){     
        return view('review');
    }

    public function ranking(Request $request){

        $method = $request->query('method');
        
        $users = [];
        if($method == 'week'){
            $users = DB::select("
                SELECT *,
                (review_count * 0.6) + (mark * 0.4) AS score
                FROM (
                    SELECT users.*,
                    COUNT(reviews.id) AS review_count, ROUND(AVG(reviews.mark), 1) AS mark
                    FROM users
                    LEFT JOIN reviews
                    ON users.id = reviews.user_id
                    WHERE reviews.date >= NOW() - INTERVAL 1 WEEK 
                    GROUP BY users.id
                ) AS user_reviews
                ORDER BY score DESC;
            ");
        }else if($method == 'total'){
            $users = DB::select("
                SELECT *,
                (review_count * 0.6) + (mark * 0.4) AS score
                FROM (
                    SELECT users.*,
                    COUNT(reviews.id) AS review_count, ROUND(AVG(reviews.mark), 1) AS mark
                    FROM users
                    LEFT JOIN reviews
                    ON users.id = reviews.user_id
                    GROUP BY users.id
                ) AS user_reviews
                ORDER BY score DESC;
            ");
        }else if($method == 'month'){
            $users = DB::select("
                SELECT *,
                (review_count * 0.6) + (mark * 0.4) AS score
                FROM (
                    SELECT users.*,
                    COUNT(reviews.id) AS review_count, ROUND(AVG(reviews.mark), 1) AS mark
                    FROM users
                    LEFT JOIN reviews
                    ON users.id = reviews.user_id
                    WHERE reviews.date >= NOW() - INTERVAL 1 MONTH 
                    GROUP BY users.id
                ) AS user_reviews
                ORDER BY score DESC;
            ");
        }else if($method == 'year'){
            $users = DB::select("
                SELECT *,
                (review_count * 0.6) + (mark * 0.4) AS score
                FROM (
                    SELECT users.*,
                    COUNT(reviews.id) AS review_count, ROUND(AVG(reviews.mark), 1) AS mark
                    FROM users
                    LEFT JOIN reviews
                    ON users.id = reviews.user_id
                    WHERE reviews.date >= NOW() - INTERVAL 1 YEAR 
                    GROUP BY users.id
                ) AS user_reviews
                ORDER BY score DESC;
            ");
        }
        ;

        return response()->json(['users' => $users]);
    }
    
}